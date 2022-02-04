<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Custom\Regular;
use App\Custom\Wallet as CustomWallet;
use App\Events\AccountActivity;
use App\Events\AdminNotification;
use App\Events\SendAdminNotification;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Home extends BaseController
{
    public $wallet;
    public $regular;
    public function __construct() {
        $this->wallet = new CustomWallet();
        $this->regular = new Regular();
    }
    public function index()
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $balances = Wallet::where('user',$user->id)->get();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Dashboard',
            'web'=>$web,
            'user'=>$user,
            'balances'=>$balances
        ];
        return view('dashboard.dashboard',$viewData);
    }
    public function setPin(Request $request){
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['pin' => ['bail','required','numeric','digits:6'],'confirm_pin' => ['bail','required','numeric','digits:6'],'password' => ['bail','required']],
            ['required'  =>':attribute is required'],
            ['pin'   =>'Transaction Pin','confirm_pin'=>'Confirm Transaction Pin']
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $hashed = Hash::check($request->input('password'),$user->password);
        if ($hashed){
            $dataUser =['transPin'=>bcrypt($request->input('pin')),'setPin'=>1];
            $update = User::where('id',$user->id)->update($dataUser);
            if (!empty($update)){
                $details = 'Your '.config('app.name').' Account pin was successfully set. Do not share this with anyone, and keep it safe.' ;
                $dataActivity = ['user' => $user->id, 'activity' => 'Security update', 'details' => $details, 'agent_ip' => $request->ip()];
                event(new AccountActivity($user, $dataActivity));
                event(new SendNotification($user,$details,'Account Security Update'));
                $success['completed']=true;
                return $this->sendResponse($success, 'Account Pin successfully updated');
            }else{
                return $this->sendError('Invalid Request',['error'=>'Unknown error encountered'],'422','Security update fail');
            }
        }
        return $this->sendError('Invalid Request',['error'=>'Invalid account password'],'422','Validation Failed');
    }
    public function verifyAccount(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'name' => ['bail', 'required', 'string'],
                'phone' => ['bail', 'required', 'numeric'],
                'zip' => ['bail', 'required', 'string'],
                'city' => ['bail', 'required', 'string'],
                'country' => ['bail', 'required', 'alpha'],
                'gender' => ['bail', 'required', 'alpha'],
                'state' => ['bail', 'required', 'string'],
                'address' => ['bail', 'required', 'string'],
                'address2' => ['bail', 'nullable', 'string'],
                'dob' => ['bail', 'required', 'date'],
                'bvn' => ['bail', 'nullable'],
                'fundSource' => ['bail', 'required', 'string'],
                'useFor' => ['bail', 'nullable', 'string'],
                'employmentStatus' => ['bail', 'required', 'string'],
                'occupation' => ['bail', 'required', 'string'],
                'idNo'=>['bail','required','string']
            ],
            ['required' => ':attribute is required'],
            ['fundSource' => 'Source of Fund','useFor' => 'Purpose of Usage','employmentStatus' => 'Employment Status',
                'idPhoto' => 'Id Photography','dob' => 'Date of Birth','bvn' => 'Bank Verification Number','zip'=>'Postal Code',
                'idNo'=>'Id number'
            ]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        if ($user->isVerified ==5){
            return $this->sendError('Error validation', ['error' => 'You have already submitted your details. Please
            upload the necessary documents.'], '422', 'Validation Failed');
        }
        if ($user->isVerified ==4){
            return $this->sendError('Error validation', ['error' => 'You have already submitted your documents for
            verification. You will receive a feedback soon from your account manager.'], '422', 'Validation Failed');
        }
        if (empty($request->input('bvn'))){
            $secret_id = '';
            $hasBvn = 2;
        }else{
            $secret_id = Crypt::encryptString($request->input('bvn'));
            $hasBvn = 1;
        }
        $phone = Str::of($request->phone)->ltrim('0');
        //check if the phone number is being used
        $phoneExists = User::where('phone',$phone)->where('id','!=',$user->id) ->first();
        if (!empty($phoneExists)) {
            return $this->sendError('Error validation',['error'=>'Mobile number already in use.'],'422','Validation Failed');
        }
        //check if the country selected is supported
        $countryExists = Countries::where('iso3',$request->input('country'))->first();
        if (empty($countryExists)) {
            return $this->sendError('Error validation', ['error' =>'Unsupported country selected'], '422', 'Validation Failed');
        }
        //get the user's currency from the list of currencies accepted
        //if the user's country currency is not available, then assign to a
        //generic currency
        $currencyAccepted = CurrencyAccepted::where('country',strtolower($countryExists->iso2))->first();
        $curr = (empty($currencyAccepted)) ? CurrencyAccepted::where('country','all')->first():$currencyAccepted;
            $dataUser = [
                'name'=>$request->input('name'),'phone'=>$request->input('phone'),'secret_id'=>$secret_id,'hasBvn'=>$hasBvn,
                'DOB'=>$request->input('dob'),'hasDob'=>1,'country'=>$countryExists->name,'countryCode'=>strtolower($countryExists->iso2),
                'countryCodeIso'=>$countryExists->iso3,'majorCurrency'=>$curr->code,'phoneCode'=>$countryExists->phonecode,
                'isVerified'=>5,'occupation'=>$request->input('occupation'),
                'address'=>$request->input('address'),'address2'=>$request->input('address2'),
                'zipCode'=>$request->input('zip'),'city'=>$request->input('city'),'state'=>$request->input('state'),
                'usingFor'=>$request->input('useFor'),'employmentStatus'=>$request->input('employmentStatus'),'fundSource'=>$request->input('fundSource'),
                'idNumber'=>$request->input('idNo')
            ];
            $update = User::where('id',$user->id)->update($dataUser);
            if (!empty($update)){
                $admin = User::where('is_admin',1)->first();
                $updated = User::where('id', $user->id)->update($dataUser);
                $details = 'Your ' . config('app.name') . ' verification documents has been submitted';
                $mailDetails = 'We have received your account verification request and will attend to it as soon as possible.
                Note however, that this might take upto 48 to 72 hours due to the influx of request we receive everyday; please
                be patient with us. If we however, take longer, reach your account manager to fasten the process.';
                $adminMail = 'An account verification request has been received from the user '.$user->name.' today '.date('d-m-Y h:i:s a',time()).'
                . Do well to attend to this in order to enable the user trade.';
                $dataActivity = ['user' => $user->id, 'activity' => 'Verification submission',
                    'details' => $details, 'agent_ip' => $request->ip()];
                event(new AccountActivity($user, $dataActivity));
                event(new SendNotification($user,$mailDetails,'Account Verification Request'));
                event(new AdminNotification($adminMail,'New Account Verification Request'));

                $success['submitted'] = true;
                return $this->sendResponse($success, 'Your verification data has been submitted. Your profile will be updated
                once verified. This can take up to 48 hours.');
            }else {
                return $this->sendError('File Error ', ['error' => 'An error occurred.
                Please try again or contact support'], '422', 'File Upload Fail');
            }
    }
    public function verifyAccountDoc(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'idPhoto' => ['bail', 'required', 'mimes:jpg,bmp,png,jpeg', 'max:5000'],
                'photo' => ['bail', 'required', 'mimes:jpg,bmp,png,jpeg', 'max:5000'],
            ],
            ['required' => ':attribute is required'],
            ['idPhoto' => 'Id Photography',]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        if ($user->isVerified ==4){
            return $this->sendError('Error validation', ['error' => 'You have already submitted your documents for
            verification. You will receive a feedback soon from your account manager.'], '422', 'Validation Failed');
        }

        //move the selfie
        $fileName1 = time().'_' . $request->file('photo')->getClientOriginalName();
        $move1 = $request->file('photo')->move(public_path('user/photos/'), $fileName1);
        //move the id image
        $fileName2 = time().'_' . $request->file('idPhoto')->getClientOriginalName();
        $move2 = $request->file('idPhoto')->move(public_path('user/photos/'), $fileName2);
        if ($move1){
            $dataUser = [
                'photo'=>$fileName1,'isUploaded'=>1,'idCard'=>$fileName2,
                'isVerified'=>4
            ];
            $update = User::where('id',$user->id)->update($dataUser);
            if (!empty($update)){
                $success['submitted'] = true;
                return $this->sendResponse($success, 'Your verification data has been submitted. Your profile will be updated
                once verified. This can take up to 48 hours.');
            }else {
                return $this->sendError('File Error ', ['error' => 'An error occurred.
                Please try again or contact support'], '422', 'File Upload Fail');
            }
        } else {
            return $this->sendError('File Error ', ['error' => $move1], '422', 'File Upload Fail');
        }
    }
    public function getReceiveWallet($coin)
    {
        $user = Auth::user();
        $wallet = Wallet::where('user',$user->id)->join('coins','wallets.asset','coins.asset')->where('wallets.asset',strtoupper($coin))->first();
        $address = $wallet->address;
        $currency = $user->majorCurrency;
        $balance = $wallet->availableBalance;

        $rate = $this->regular->getCryptoExchange($wallet->asset,$currency);

        $success['fetched'] = true;
        $success['address'] =$address;
        $success['coin']=$wallet->name;
        $success['balance']=number_format($balance,4);
        $success['note']=$wallet->note;
        $success['network']=strtoupper($wallet->network);
        $success['exRate']=$rate*$balance;
        $success['fiat']=$currency;
        return $this->sendResponse($success, 'Address Fetched');
    }
}
