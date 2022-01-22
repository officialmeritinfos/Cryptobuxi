<?php

namespace App\Http\Controllers\Web;

use App\Custom\GenerateUnique;
use App\Custom\Regular;
use App\Events\SendWelcomeMail;
use App\Events\UserCreated;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class Register extends BaseController
{
    use GenerateUnique;
    public function index()
    {
        $webSettings = GeneralSetting::findOrFail(1);
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'Account Registration Page',
        ];
        return view('auth.register',$viewData);
    }
    public function doRegister(Request $request)
    {
        $generalSettings = GeneralSetting::findOrFail(1);
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|string|max:50',
            'email' => ['bail','required','email','unique:users,email'],
            'phone' => ['bail','required','numeric'],
            'referral'=>['bail','nullable','alpha_num','exists:users,username'],
            'password' => ['bail','required',Password::min(8)->letters()->mixedCase()->numbers()->symbols(),],
        ])->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $phone = Str::of($request->phone)->ltrim('0');
        if (!empty($request->referral)){
            $referral = User::where('username',$request->referral)->first();
            $ref = $referral->username;
        }else{
            $ref = '';
        }
        $ipAddress = $request->ip();
        //get the user's country
        $ipDetector = new Regular();
        $location = $ipDetector->getUserCountry($ipAddress);
        if ($location->ok()){
            $location = $location->json();
            $country = $location['country_name'];
            $country_code = $location['country_code2'];
            $country_code3 = $location['country_code3'];
            $userIp = $ipAddress;
            $phoneCode = $location['calling_code'];
        }else{
            $country = '';
            $country_code = '';
            $country_code3 = '';
            $userIp = $ipAddress;
            $phoneCode = '';
        }
        //check if registration is on
        if ($generalSettings->siteRegistration != 1){
            return $this->sendError('Error Creating account', ['error'=>'New Registration is currently disabled.
            Please contact support for more information.'],'401','account error');
        }
        $userRef = $this->createUniqueRef('users','userRef');
        $validated = $validator->validated();

        $fiat =(!empty(strtolower($country_code))) ? CurrencyAccepted::where('country','all')->orWhere('country',strtolower($country_code))->where(function($query){
            $query->where('status',1);
        })->get() : CurrencyAccepted::where('status',1)->where('country','all')->get();

        $userData = ['name'=>$validated['name'],'email'=>$validated['email'],'phone'=>$phone,'emailVerified'=>$generalSettings->emailVerification,
            'twoWay'=>$generalSettings->twoWay,'password'=>bcrypt($validated['password']),'creation_ip'=>$userIp,'userRef'=>$userRef,
            'country'=>$country,'countryCode'=>$country_code,'countryCodeIso'=>$country_code3,'phoneCode'=>$phoneCode,'refBy'=>$ref,'majorCurrency'=>$fiat->code
        ];
        $user = User::create($userData);
        if(!empty($user)) {
            $admin = User::where('is_admin',1)->first();
            switch ($generalSettings->emailVerification){
                case 1:
                    event(new SendWelcomeMail($user));
                    event(new UserCreated($user,$admin));
                    $success['name']=$user->name;
                    $success['needVerification'] = false;
                    $message='Account successfully created, proceed to login';
                    break;
                case 2:
                    event(new UserCreated($user,$admin));
                    $success['name']=$user->name;
                    $success['needVerification'] = true;
                    $message='Account successfully created. Use the code sent to your mail to verify your account';
                    break;
            }
            return $this->sendResponse($success, $message);
        }else{
            return $this->sendError('Error Creating account', ['error'=>'An error has occurred while creating your
            account.'],'401','account error');
        }
    }
}
