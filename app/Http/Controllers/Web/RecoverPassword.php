<?php

namespace App\Http\Controllers\Web;

use App\Events\AccountRecoveryMail;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\PasswordChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RecoverPassword extends BaseController
{
    public function index()
    {
        $webSettings = GeneralSetting::findOrFail(1);
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'Forgotten Password - Password Reset - '.config('app.name') ,
        ];
        return view('auth.recoverpassword',$viewData);
    }
    public function confirmationNeeded($email)
    {
        $user= Auth::user();
        $webSettings = GeneralSetting::findOrFail(1);
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'Account Recovery',
            'email'=>$user->email
        ];
        return view('auth.confirm_reset',$viewData);
    }
    public function doRecover(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['bail','required','email','exists:users,email'],
        ])->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $user = User::where('email',$request->email)->where('status',1)->first();
        if (empty($user)){
            return $this->sendError('Inactive account',['error'=>'Account is deactivated. Contact support'],'422','Inactive account');
        }
        event(new AccountRecoveryMail($user));
        $success['name']  = $user->name;
        $success['sent']  = true;
        return $this->sendResponse($success, 'Recovery Mail sent');
    }
    public function verifyReset($email,$hash)
    {
        $webSettings = GeneralSetting::findOrFail(1);
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'Password Reset - '.config('app.name'),
            'code'=>$hash,
            'email'=>$email
        ];
        return view('auth.reset_password',$viewData);
    }
    public function doReset(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['bail','required','email','exists:users,email'],
            'password' => ['bail','required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'code' => ['bail','required','string',],
        ])->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        //get code
        $exists = PasswordReset::where('email',$request->input('email'))->orderBy('id','desc')->first();
        if (!empty($exists)) {
             //check if the token matches the sent token
            $sysToken = sha1($exists->token);
            if($sysToken == $request->input('code')){
                if ($exists->codeExpires < time()) {
                    return $this->sendError('Error validation',['error'=>'Token has expired'],'422','Validation Failed');
                }
                $user = User::where('email',$request->input('email'))->first();
                $dataUser= [
                     'password'=>bcrypt($request->input('password'))
                ];
                $update = User::where('id',$user->id)->update($dataUser);
                if($update){
                    $user->notify(new PasswordChange($user->name));
                    $success['name']  = $user->name;
                    $success['changed']  = true;
                    $success['redirect_to']=url('login');
                    PasswordReset::where('email',$user->email)->delete();
                    return $this->sendResponse($success, 'Password Reset');
                }else{
                    return $this->sendError('Error validation',['error'=>'An error occurred.'],'422','Validation Failed');
                }
            }else{
                return $this->sendError('Error validation',['error'=>'Invalid Token submitted'],'422','Validation Failed');
            }
        }else{
            return $this->sendError('Error validation',['error'=>'Token unknown'],'422','Validation Failed');
        }
    }
}
