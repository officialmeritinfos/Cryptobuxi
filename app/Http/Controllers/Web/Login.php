<?php

namespace App\Http\Controllers\Web;

use App\Events\LoginMail;
use App\Events\TwoFactor;
use App\Events\UserCreated;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\TwoWay;
use App\Models\User;
use App\Notifications\AccountLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Login extends BaseController
{
    public function index()
    {
        $webSettings = GeneralSetting::findOrFail(1);
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'Sign In - '.config('app.name') ,
        ];
        return view('auth.login',$viewData);
    }
    /**
     * AUTHENTICATE A LOGIN REQUEST AND RETURN EITHER AN ERROR OR LOGIN
     */
    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['bail','required','email','exists:users,email'],
            'password' => ['bail','required',Password::min(8),],
            'remember'=>['bail','nullable','integer']
        ])->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        if($request->has('remember')){
            $remember = true;
        }else{
            $remember = false;
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$remember)){
            $authUser = Auth::user();
            if ($authUser->emailVerified !=1){
                event(new UserCreated($authUser));
                $success['name']=$authUser->name;
                $success['needVerification'] = true;
                $success['redirect_to']='register/confirm/'.$authUser->email;
                $message='Please activate account to proceed';
                return $this->sendResponse($success, $message);
            }
            switch ($authUser->twoWay){
                case 1:
                    event(new TwoFactor($authUser));
                    $dataUser = ['twoWayPassed' =>2];
                    User::where('id',$authUser->id)->update($dataUser);
                    $success['name'] =  $authUser->name;
                    $success['needAuth'] = true;
                    $success['redirect_to']='login/confirm/'.$authUser->email;
                    return $this->sendResponse($success, 'Authentication needed');
                    break;
                case 2:
                    event(new LoginMail($authUser,$request->ip()));
                    $dataUser = ['twoWayPassed' =>1,'loggedIn'=>1];
                    User::where('id',$authUser->id)->update($dataUser);
                    $success['name'] =  $authUser->name;
                    $success['needAuth'] = false;
                    $success['loggedIn'] = true;
                    $success['account_type']=$authUser->accountType;
                    $success['is_admin']=$authUser->is_admin;
                    $success['redirect_to']='dashboard/index';
                    return $this->sendResponse($success, 'User signed in');
                    break;
            }
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Either password or email is wrong'],'403','Access Denied');
        }
    }
    public function confirmationNeeded($email)
    {
        $user= Auth::user();
        $webSettings = GeneralSetting::findOrFail(1);
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> '2FA',
            'email'=>$user->email
        ];
        return view('auth.confirm_login',$viewData);
    }
    public function verifyLogin($email,$hash){
        $exists = TwoWay::where('email',$email)->orderBy('id','desc')->first();
        if(!empty($exists)){
            //check if the token matches the sent token
            $sysToken = sha1($exists->code);
            if($sysToken == $hash){
                if ($exists->codeExpires < time()) {
                    return redirect('login')->with('error','Token has expired');
                }
                $user = User::where('email',$email)->first();
                $dataUser= [
                    'twowayPassed'=>1,
                    'loggedIn'=>1
                ];
                $update = User::where('id',$user->id)->update($dataUser);
                if($update){
                    $user->notify(new AccountLogin($user->name));
                    Auth::loginUsingId($user->id);
                    //delete all logins
                    TwoWay::where('user',$user->id)->delete();
                    return redirect('account/dashboard')->with('success','Login Authorized');
                }else{
                    return redirect('login')->with('error','Error processing Verification') ;
                }
            }else{
                return redirect('login')->with('error','Invalid token supplied');
            }
        }else{
            return redirect('login')->with('error','Invalid token accessor supplied');
        }
    }
    public function logout(Request $request)
    {
        $user=Auth::user();
        $dataUpdate = ['twowayPassed'=>2,'loggedIn'=>2];
        User::where('id',$user->id)->update($dataUpdate);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login')->with('info','Successfully logged out');
    }
}
