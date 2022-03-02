<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Custom\GenerateUnique;
use App\Custom\Regular;
use App\Custom\Wallet as CustomWallet;
use App\Events\AccountActivity;
use App\Events\AdminNotification;
use App\Events\SendAdminNotification;
use App\Events\SendNotification;
use App\Events\SendWelcomeMail;
use App\Events\UserCreated;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\Countries;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSetting;
use App\Models\PendingInternalTransfer;
use App\Models\SystemAccount;
use App\Models\User;
use App\Models\UserBalance;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Notifications\NotifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Home extends BaseController
{
    use GenerateUnique;
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
        $fiatBalances = UserBalance::where('user',$user->id)->get();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Dashboard',
            'web'=>$web,
            'user'=>$user,
            'balances'=>$balances,
            'fiatBalances'=>$fiatBalances
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
    public function getUserCurrency()
    {
        $user = Auth::user();
        $success['fiat']=$user->majorCurrency;
        return $this->sendResponse($success, 'Address Fetched');
    }
    //send coin from system
    public function sendAsset(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'base_curr' => ['bail', 'required', 'integer'],
                'asset' => ['bail', 'required', 'alpha_dash'],
                'amount' => ['bail', 'required', 'string'],
                'destination' => ['bail', 'required', 'integer'],
                'details' => ['bail','nullable', 'required_unless:destination,1', 'string'],
                'pin' => ['bail','required','numeric','digits:6'],
            ],
            ['required' => ':attribute is required'],
            [
                'base_curr' => 'Base Currency',
                'details' => 'To',
            ]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        $input = $request->input();
        //check for account Pin
        $hashed = Hash::check($input['pin'],$user->transPin);
        if (!$hashed) {
            return $this->sendError('Error validation', ['error' => 'Invalid Account Pin'], '422', 'Validation Failed');
        }
        $coin = strtoupper($input['asset']);
        //check if the asset is supported
        $coinExists = Coin::where('asset',$coin)->where('status',1)->first();
        if (empty($coinExists)) {
            return $this->sendError('Error validation', ['error' => 'Asset not supported'], '422', 'Validation Failed');
        }
        $fiat = $user->majorCurrency;
        $rate = $this->regular->getCryptoExchange($coin,$fiat);
        switch ($input['base_curr']) {
            case '1':
                $amount = str_replace(',','',$input['amount']);
                $fiatAmount = $amount*$rate;
                break;
            default:
                $fiatAmount = str_replace(',','',$input['amount']);
                $amount = $fiatAmount/$rate;
                break;
        }
        //check if the amount user wants to send is allowed
        $minimumSendable =$coinExists->minSend;
        if($minimumSendable > $amount){
            return $this->sendError('Error validation', ['error' => 'You can only send a minimum of '.$minimumSendable.' '.$coin
         ], '422', 'Validation Failed');
        }
        //get user's balance and check if the amount is up to the amount needed
        $userBalance = Wallet::where('asset',$coin)->first();
        $availableBalance = $userBalance->availableBalance;

        if ($amount > $availableBalance) {
            return $this->sendError('Error validation', ['error' => 'Insufficient balance'], '422', 'Validation Failed');
        }
        //check if user is allowed to transfer
        if($user->canSend != 1){
            return $this->sendError('Account Error', ['error' => 'There is an embargo placed on your account. You therefore, cannot
            transfer out assets at the moment. Please rectify this before proceeding'], '422', 'transfer.failed');
        }
        $input['amount']=$amount;
        $input['fiatAmount']=$fiatAmount;
        $input['reference']=$this->createUniqueRef('withdrawals','reference');
        //check for the destiantion type
        switch ($input['destination']) {
            case '1':
                $this->sendToTradeAccount($input,$coinExists,$userBalance,$user,$request);
                break;
            case '2':
                return $this->sendToUser($input,$coinExists,$userBalance,$user,$request);
                break;
            default:
                return $this->sendToExternalAddress($input,$coinExists,$userBalance,$user,$request);
                break;
        }
    }
    public function sendToTradeAccount($data,$coin,$balance,$user,$request)
    {
        $generalSettings = GeneralSetting::where('id',1)->first();
        //get system's wallet
        $systemWallet = SystemAccount::where('asset',$coin->asset)->first();
        //collate the withdrawal data
        $dataWithdrawal = [
            'user'=>$user->id,
            'amount'=>$data['amount'],
            'amountSent'=>'',
            'fiatAmount'=>$data['fiatAmount'],
            'asset'=>$coin->asset,
            'fiat'=>$user->majorCurrency,
            'accountId'=>$balance->accountId,
            'addressTo'=>$systemWallet->address,
            'memoTo'=>'',
            'hasMemo'=>$coin->hasMemo,
            'status'=>2,
            'destination'=>1,
            'isInternal'=>1,
            'timeToSend'=>strtotime($generalSettings->timeToSend,time()),
            'pending'=>2,
            'reference'=>$data['reference']
        ];
         //lets create the withdrawal
         $withdraw = Withdrawal::create($dataWithdrawal);
        if (!empty($withdraw)) {
            //update User Balance
            $newAccountBalance = $balance->availableBalance - $data['amount'];
            $dataNewBalance = ['availableBalance'=>$newAccountBalance];
            Wallet::where('id',$balance->id)->update($dataNewBalance);
            //send message to sender and add to activity
            $details ="Your ".$coin->asset." account on ".config('app.name')." has been debited of
            ".number_format($data['amount'],$coin->cryptoPrecision)." ".$coin->asset." to fund your trading account.
            This should reflect in your corresponding trading account after network confirmations.
            If this action was not carried out by you, please contact support for possible help.";
            $dataActivity = ['user' => $user->id, 'activity' => $coin->name.' Transfer to Trading account',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$details,$coin->name.' Withdrawal'));
            //send mail to admin
            $messageAdmin = "There is a new transfer on ".config('app.name')." to trading account.
            Withdrawal reference is ".$data['reference'];
            event(new AdminNotification($messageAdmin,'New Transfer to Trading account'));

            $success['sent']=true;
            return $this->sendResponse($success, 'Transfer sent; awaiting blockchain confirmations.');
        }
        return $this->sendError('Transfer Error', ['error' => 'Unable to process transfer request'], '422', 'transfer.failed');
    }
    public function sendToExternalAddress($data,$coin,$balance,$user,$request)
    {
        $generalSettings = GeneralSetting::where('id',1)->first();
        //collate the withdrawal data
        $dataWithdrawal = [
            'user'=>$user->id,
            'amount'=>$data['amount'],
            'amountSent'=>'',
            'fiatAmount'=>$data['fiatAmount'],
            'asset'=>$coin->asset,
            'fiat'=>$user->majorCurrency,
            'accountId'=>$balance->accountId,
            'addressTo'=>$data['details'] ,
            'memoTo'=>'',
            'hasMemo'=>$coin->hasMemo,
            'status'=>2,
            'destination'=>3,
            'isInternal'=>2,
            'timeToSend'=>strtotime($generalSettings->timeToSend,time()),
            'pending'=>2,
            'reference'=>$data['reference']
        ];
         //lets create the withdrawal
         $withdraw = Withdrawal::create($dataWithdrawal);
        if (!empty($withdraw)) {
            //update User Balance
            $newAccountBalance = $balance->availableBalance - $data['amount'];
            $dataNewBalance = ['availableBalance'=>$newAccountBalance];
            Wallet::where('id',$balance->id)->update($dataNewBalance);
            //send message to sender and add to activity
            $details ="Your ".$coin->asset." account on ".config('app.name')." has been debited of
            ".number_format($data['amount'],$coin->cryptoPrecision)." ".$coin->asset.". If this action was
            not carried out by you, please contact support for possible help.";
            $dataActivity = ['user' => $user->id, 'activity' => $coin->name.' Withdrawal',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$details,$coin->name.' Withdrawal'));
            //send mail to admin
            $messageAdmin = "There is a new withdrawal on ".config('app.name').". Withdrawal reference is ".$data['reference'];
            event(new AdminNotification($messageAdmin,'New External Transfer'));

            $success['sent']=true;
            return $this->sendResponse($success, 'Transfer sent; awaiting blockchain confirmations.');
        }
        return $this->sendError('Transfer Error', ['error' => 'Unable to process transfer request'], '422', 'transfer.failed');
    }
    public function sendToUser($data,$coin,$balance,$user,$request)
    {
        $generalSettings = GeneralSetting::where('id',1)->first();
        //validate the email
        if (!filter_var($data['details'], FILTER_VALIDATE_EMAIL)) {
            return $this->sendError('Account Error', ['error' => 'Invalid email address'], '422', 'transfer.failed');
        }
        $email = $data['details'];
        $userRef = $this->createUniqueRef('users','userRef');
        //check if we can see a user with the email
        $emailExists = User::where('email',$email)->first();
        if (!empty($emailExists)) {
            //get the user's wallet
            $receiverWallet = Wallet::where('user',$emailExists->id)->where('asset',$coin->asset)->first();
            $isUser = 1;
            //collate the withdrawal data
            $dataWithdrawal = [
                'user'=>$user->id,
                'amount'=>$data['amount'],
                'amountSent'=>'',
                'fiatAmount'=>$data['fiatAmount'],
                'asset'=>$coin->asset,
                'fiat'=>$user->majorCurrency,
                'accountId'=>$balance->accountId,
                'addressTo'=>$receiverWallet->address,
                'memoTo'=>$receiverWallet->memo,
                'hasMemo'=>$receiverWallet->hasMemo,
                'status'=>2,
                'destination'=>2,
                'isInternal'=>1,
                'timeToSend'=>strtotime($generalSettings->timeToSend,time()),
                'pending'=>2,
                'reference'=>$data['reference']
            ];
        } else {
            $isUser = 2;
            //we will send a link to the email so they can create their account
            $dataWithdrawal = [
                'user'=>$user->id,
                'amount'=>$data['amount'],
                'amountSent'=>'',
                'fiatAmount'=>$data['fiatAmount'],
                'asset'=>$coin->asset,
                'fiat'=>$user->majorCurrency,
                'accountId'=>$balance->accountId,
                'addressTo'=>'',
                'memoTo'=>'',
                'hasMemo'=>$coin->hasMemo ,
                'status'=>2,
                'destination'=>2,
                'isInternal'=>1,
                'timeToSend'=>strtotime($generalSettings->timeToRefund,time()),
                'pending'=>1,
                'reference'=>$data['reference']
            ];
        }
        //lets create the withdrawal
        $withdraw = Withdrawal::create($dataWithdrawal);
        if (!empty($withdraw)) {
            //update User Balance
            $newAccountBalance = $balance->availableBalance - $data['amount'];
            $dataNewBalance = ['availableBalance'=>$newAccountBalance];
            Wallet::where('id',$balance->id)->update($dataNewBalance);
            if ($isUser == 2) {
                //create the receiver
                $userData = ['name'=>$userRef,'email'=>$email,'phone'=>'','emailVerified'=>1,
                'twoWay'=>$generalSettings->twoWay,'password'=>'','creation_ip'=>'','userRef'=>$userRef,
                'country'=>'','countryCode'=>'','countryCodeIso'=>'','phoneCode'=>'','refBy'=>'','majorCurrency'=>''
                ];
                $timeRefund = strtotime($generalSettings->timeToRefund,time());
                $newUser = User::create($userData);
                if(!empty($newUser)) {

                    $dataPendingTransfer =[
                        'sender'=>$user->id,
                        'asset'=>$coin->asset,
                        'receiver'=>$newUser->id,
                        'withdrawalId'=>$withdraw->id,
                        'amount'=>$withdraw->amount,
                        'fiatAmount'=>$withdraw->fiatAmount,
                        'timeRefund'=>$timeRefund,
                    ];
                    PendingInternalTransfer::create($dataPendingTransfer);
                    $messageAdmin = "There is a new registration on ".config('app.name')." through internal transfer.
                    Account Reference Code is ".$userRef.". Withdrawal Reference is ".$data['reference'];
                    $messageToNewUser = "You have received ".number_format($data['fiatAmount'],2). " ".$user->majorCurrency."
                    worth  of ".$coin->name." from ".$generalSettings->userCode.$user->userRef." on ".config('app.name').". Click
                    the button below to complete your profile on ".config('app.name').". Endeavour  to do this before
                    ".date('d-m-Y h:i:s a',$timeRefund)." to avoid losing both your asset and account.";
                    $urlToCompleteProfile = route('complete-account',['id'=>$newUser->email,'hash'=>sha1($userRef)]);
                    //send mail to new user and initialize details
                    event(new SendWelcomeMail($newUser));
                    event(new UserCreated($newUser));
                    $newUser->notify(new NotifyUser($newUser->userRef,$messageToNewUser,'New '.$coin->name.' Transfer from '.config('app.name') ,$urlToCompleteProfile));
                    //send mail to admin
                    event(new AdminNotification($messageAdmin,'New Internal Transfer'));
                }
            }else{
                $messageAdmin = "There is a new Internal transfer on ".config('app.name').". Withdrawal reference is ".$data['reference'];
                $messageToReceiver = "You have received ".number_format($data['fiatAmount'],2). " ".$user->majorCurrency."
                    worth  of ".$coin->name." from ".$generalSettings->userCode.$user->userRef." on ".config('app.name').".
                    This should reflect on your corresponding account after blockchain confirmations.";
                    //send mail to receiver and admin
                event(new SendNotification($emailExists,$messageToReceiver,'Incoming '.$coin->name.' Deposit on '.config('app.name')));
                event(new AdminNotification($messageAdmin,'New Internal Transfer'));
            }
            //send message to sender and add to activity
            $details ="Your ".$coin->asset." account on ".config('app.name')." has been debited of
            ".number_format($data['amount'],$coin->cryptoPrecision)." ".$coin->asset.". If this action was not carried out by you,
            please contact support for possible help.";
            $dataActivity = ['user' => $user->id, 'activity' => $coin->name.' Withdrawal',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$details,$coin->name.' Withdrawal'));
            $success['sent']=true;
            return $this->sendResponse($success, 'Transfer sent; awaiting confirmations.');
        }
        return $this->sendError('Transfer Error', ['error' => 'Unable to process transfer request'], '422', 'transfer.failed');
    }
}
