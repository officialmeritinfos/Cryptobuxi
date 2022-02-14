<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Custom\GenerateUnique;
use App\Custom\Regular;
use App\Custom\Wallet;
use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\CryptoLoan;
use App\Models\CryptoLoanOffering;
use App\Models\CurrencyAccepted;
use App\Models\FiatLoan;
use App\Models\GeneralSetting;
use App\Models\UserTradingBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Loans extends BaseController
{
    use GenerateUnique;
    public $wallet;
    public $regular;
    public function __construct() {
        $this->wallet = new Wallet();
        $this->regular = new Regular();
    }
    public function index()
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Borrowed Crypto Asset',
            'web'=>$web,
            'user'=>$user,
            'crypto_loans'=>CryptoLoan::where('user',$user->id)->get(),
        ];
        return view('dashboard.loans',$viewData);
    }
    public function lended()
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Lended Crypto Assets',
            'web'=>$web,
            'user'=>$user,
            'lended_crypto'=>CryptoLoan::where('lender',$user->id)->get(),
        ];
        return view('dashboard.loans',$viewData);
    }
    public function fiat()
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Received Fiat Loans',
            'web'=>$web,
            'user'=>$user,
            'fiat_loans'=>FiatLoan::where('user',$user->id)->get(),
        ];
        return view('dashboard.loans',$viewData);
    }
    public function fiatLended()
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Lended Fiats',
            'web'=>$web,
            'user'=>$user,
            'lended_fiat'=>FiatLoan::where('lender',$user->id)->get(),
        ];
        return view('dashboard.loans',$viewData);
    }
    public function loanCenter()
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Crypto Loan Center',
            'web'=>$web,
            'user'=>$user,
            'crypto_loan_offerings'=>CryptoLoanOffering::where('status',1)->where('user','!=',$user->id)->paginate(15),
            'user_crypto_loan_offerings'=>CryptoLoanOffering::where('user',$user->id)->get(),
            'fiats'=>CurrencyAccepted::where('status',1)->get(),
            'trading_balances'=>UserTradingBalance::where('user',$user->id)->get()
        ];
        return view('dashboard.loan_center',$viewData);
    }
    public function createCryptoOffering(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'fiat' => ['bail', 'required', 'alpha'],
                'asset' => ['bail', 'required', 'alpha_dash'],
                'amount' => ['bail', 'required', 'string'],
                'percent' => ['bail', 'required', 'numeric'],
                'pin' => ['bail','required','numeric','digits:6'],
            ],
            ['required' => ':attribute is required'],
            [
                'percent' => 'Resale Rate',
                'details' => 'To',
            ]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        $input = $request->input();
        $coin = strtoupper($input['asset']);
        $amount = str_replace(',','',$input['amount']);
        //check if the pin is okay
        $hashed = Hash::check($input['pin'],$user->transPin);
        if (!$hashed) {
            return $this->sendError('Error validation', ['error' => 'Invalid Account Pin'], '422', 'Validation Failed');
        }
        //check if the asset is supported
        $coinExists = Coin::where('asset',$coin)->where('status',1)->first();
        if (empty($coinExists)) {
            return $this->sendError('Error validation', ['error' => 'Asset not supported'], '422', 'Validation Failed');
        }
        if ($coinExists->minimumLoanable > $amount) {
            return $this->sendError('Error validation', ['error' => 'Amount is less than Minimum Loan Offer'],
            '422', 'Validation Failed');
        }
        //get trading balance of the user
        $userTradingBalance = UserTradingBalance::where('user',$user->id)->where('asset',$coin)->first();
        if($userTradingBalance->availableBalance < $amount){
            return $this->sendError('Error validation', ['error' => 'Insufficient trading balance for '.$coinExists->name.'
            Trading Account. Please fund your trading balance and try again.'],
            '422', 'Validation Failed');
        }
        //check if user is allowed to make loan
        if ($user->canLend !=1) {
            return $this->sendError('Error validation', ['error' => 'Operation failed: user cannot add loan offering'],
            '422', 'Validation Failed');
        }
        //if everything checks out well
        $dataLoanOffering = [
            'user'=>$user->id,
            'reference'=>$this->createUniqueRef('crypto_loan_offerings','reference'),
            'asset'=>$coin,
            'amount'=>$amount,
            'fiat'=>$input['fiat'],
            'resellRate'=>$input['percent'],
            'availableBalance'=>$amount
        ];
        $newBalance = $userTradingBalance->availableBalance-$amount;
        $dataTradingBalance =[
            'availableBalance'=>$newBalance
        ];
        $create = CryptoLoanOffering::create($dataLoanOffering);
        if (!empty($create)) {
            UserTradingBalance::where('id',$userTradingBalance->id)->update($dataTradingBalance);
            $details='A new ccrypto offering was created on your account.';
            //send message to sender and add to activity
            $mailMessage ="A new ".$coinExists->name." Loan offering has been created on your ".config('app.name')." account. Your
            ".$coin." Trading account was debited of ".$amount.$coinExists->icon." to fund this offering. your new trading balance
            after this is ".$newBalance.$coin.". If this was not authorized by you, please contact support right away.";
            $dataActivity = ['user' => $user->id, 'activity' => 'New Crypto Loan Offering',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'New '.$coinExists->name.' Loan Offering'));

            $success['offered']=true;
            return $this->sendResponse($success, 'Offer created.');
        }
    }
}
