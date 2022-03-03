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
use App\Models\CurrencyAccepted;
use App\Models\FiatLoan;
use App\Models\FiatLoanOffering;
use App\Models\FiatLoanReserve;
use App\Models\GeneralSetting;
use App\Models\Interval;
use App\Models\Trade;
use App\Models\TradeOffering;
use App\Models\User;
use App\Models\UserBalance;
use App\Models\UserTradingBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Trades extends BaseController
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
            'pageName'=>'Trades',
            'web'=>$web,
            'user'=>$user,
            'sales'=>Trade::where('trader',$user->id)->get(),
            'purchases'=>Trade::where('user',$user->id)->paginate(),
            'balances'=>UserTradingBalance::where('user',$user->id)->get()
        ];
        return view('dashboard.trades',$viewData);
    }
    public function center(){
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Trades',
            'web'=>$web,
            'user'=>$user,
            'offerings'=>TradeOffering::where('user','!=',$user->id)->where('status',1)->where('currency',$user->majorCurrency)
                ->orderBy('rate','ASC')->orderBy('availableBalance','desc')->paginate(
                $perPage = 15, $columns = ['*'], $pageName = 'offers'
            ),
            'personalOfferings'=>TradeOffering::where('user',$user->id)->orderBy('rate','ASC')->paginate(15),
            'fiats'=>CurrencyAccepted::where('status',1)->get(),
            'trading_balances'=>UserTradingBalance::where('user',$user->id)->get()
        ];
        return view('dashboard.trade_center',$viewData);
    }
    public function createOffer(Request $request)
    {
        $web = GeneralSetting::where('id',1)->first();
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'fiat' => ['bail', 'required', 'alpha'],
                'asset' => ['bail', 'required', 'alpha_dash'],
                'amount' => ['bail', 'required', 'string'],
                'percent' => ['bail', 'nullable', 'numeric','integer'],
                'pin' => ['bail','required','numeric','digits:6'],
            ],
            ['required' => ':attribute is required'],
            [
                'duration_type' => 'Duration Type',
                'percent' => 'Rate',
            ]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        $input = $request->input();
        $currency = strtoupper($input['fiat']);
        $coin = strtoupper($input['asset']);
        $amount = str_replace(',','',$input['amount']);
        //check if the pin is okay
        $hashed = Hash::check($input['pin'],$user->transPin);
        if (!$hashed) {
            return $this->sendError('Error validation', ['error' => 'Invalid Account Pin'], '422', 'Validation Failed');
        }
        //check if all is selected or a specific asset
        if ($input['fiat'] != 'all') {
            //check if coin is valid
            $currencyExists = CurrencyAccepted::where('code',$currency)->first();
            if (empty($currencyExists)) {
                return $this->sendError('Error validation', ['error' => 'Currency not supported'], '422',
                    'Validation Failed');
            }else{
                $acceptsAll = 2;
            }
        }else{
            $acceptsAll=1;
        }
        //check if the asset is supported
        $coinExist = Coin::where('asset',$coin)->where('status',1)->first();
        if (empty($coinExist)) {
            return $this->sendError('Error validation', ['error' => 'Asset not supported'], '422', 'Validation Failed');
        }
        //check if the asset is supported
        $balanceExists = UserTradingBalance::where('asset',$coin)->first();
        if (empty($balanceExists)) {
            return $this->sendError('Error validation', ['error' => 'Balance not found'],
                '422', 'Validation Failed');
        }
        //check if the user has enough balance
        if($balanceExists->availableBalance < $amount){
            return $this->sendError('Error validation', ['error' => 'Insufficient balance in
            '.$coinExist->asset.' Trading Account. Please fund your '.$coinExist->asset.' trading
            balance and try again.'],'422', 'Validation Failed');
        }
        //check if the user is on loan
        $hasLoan = CryptoLoan::where('user',$user->id)->where('asset',$coinExist->asset)->where('isPaidBack','!=',1)->first();
        if (!empty($hasLoan)){
            $hasLoan = 1;
        }else{
            $hasLoan = 2;
        }
        //check if rate is included
        if (empty($input['percent'])){
            $userRate = $currencyExists->rateUsd;
        }else{
            $userRate = $input['percent'];
        }
        //calculate the rate the user is using
        $systemRate = $currencyExists->rateUsd;
        $rateDiff = $userRate-$systemRate;
        $rate = ($rateDiff/$systemRate)*100;
        $reference = $this->createUniqueRef('fiat_loan_offerings','reference');
        //if everything checks out well
        $dataOffering = [
            'user'=>$user->id,
            'reference'=>$reference,
            'asset'=>$coin,
            'amount'=>$amount,
            'isLoan'=>$hasLoan,
            'rate'=>$rate,
            'availableBalance'=>$amount,
            'currency'=>$currency,
            'acceptsAll'=>$acceptsAll,
            'status'=>1
        ];
        $newBalance = $balanceExists->availableBalance-$amount;
        $dataBalance =[
            'availableBalance'=>$newBalance
        ];

        $create = TradeOffering::create($dataOffering);
        if (!empty($create)) {
            UserTradingBalance::where('id',$balanceExists->id)->update($dataBalance);
            $details='A new trade listing was created on your account.';
            //send message to sender and add to activity
            $mailMessage ="A new <b>".$coin."</b> Trade listing has been created on your
            ".config('app.name')." account. Your ".$coin." trading account was debited of <b>".$amount.$coin."</b>
            to fund this listing. Your new balance after this is <b>".number_format($newBalance,5).$coin.".</b>
            If this was not authorized by you, please contact support right away. Your Reference Id is <b>".$reference."</b>";
            $dataActivity = ['user' => $user->id, 'activity' => 'New Trade Listing',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'New '.$coin.' Trade Listing'));

            $success['offered']=true;
            return $this->sendResponse($success, 'Offer created.');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
                '422', 'Validation Failed');
        }
    }
    //view sent Fiat Loans
    public function details($ref)
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $offerExists = TradeOffering::where('reference',$ref)->first();
        if (empty($offerExists)) {
            return back()->with('error','Offer not found');
        }
        //get the user who made the loan available
        $offerOwner = User::where('id',$offerExists->user)->first();
        $currency = CurrencyAccepted::where('status',1)->where('code',$offerExists->currency) ->first();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Trade List Detail',
            'web'=>$web,
            'user'=>$user,
            'offering'=>$offerExists,
            'offerOwner'=>$offerOwner,
            'currency' =>$currency,
            'trades'=>Trade::where('offerId',$offerExists->id)->where('status',1)->get(),
            'coin'=>Coin::where('asset',$offerExists->asset)->first()
        ];
        return view('dashboard.trade_offer_details ',$viewData);
    }
    public function topUpOffer(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'id' => ['bail', 'required', 'numeric'],
                'amount' => ['bail', 'required', 'string'],
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
        $amount = str_replace(',','',$input['amount']);
        //check if the pin is okay
        $hashed = Hash::check($input['pin'],$user->transPin);
        if (!$hashed) {
            return $this->sendError('Error validation', ['error' => 'Invalid Account Pin'], '422', 'Validation Failed');
        }
        $offerExists = TradeOffering::where('reference',$input['id'])->where('user',$user->id)->first();
        if (empty($offerExists)) {
            return $this->sendError('Error validation', ['error' => 'Unauthorized Action. Please contact support'],
                '422', 'Validation Failed');
        }
        if ($offerExists->status !=1) {
            return $this->sendError('Error validation', ['error' => 'You cannot top up a cancelled Offer'],
                '422', 'Validation Failed');
        }
        $coin = $offerExists->asset;
        //check if the asset is supported
        $coinExists = Coin::where('asset',$coin)->where('status',1)->first();
        if (empty($coinExists)) {
            return $this->sendError('Error validation', ['error' => 'Asset not supported'], '422', 'Validation Failed');
        }
        //get trading balance of the user
        $userBalance = UserTradingBalance::where('user',$user->id)->where('asset',$coin)->first();
        if($userBalance->availableBalance < $amount){
            return $this->sendError('Error validation', ['error' => 'Insufficient trading balance for '.$coinExists->name.'
            Trading Balance. Please fund your balance and try again.'],
                '422', 'Validation Failed');
        }

        $amountListed = $offerExists->amount;
        $offerBalance = $offerExists->availableBalance;
        //if everything checks out well
        $dataOffering = [
            'amount'=>$amountListed+$amount,
            'availableBalance'=>$offerBalance+$amount,
        ];
        $newBalance = $userBalance->availableBalance-$amount;
        $dataBalance =[
            'availableBalance'=>$newBalance
        ];
        $update = TradeOffering::where('id',$offerExists->id)->update($dataOffering);
        if (!empty($update)) {
            UserTradingBalance::where('id',$userBalance->id)->update($dataBalance);
            $details='Topup of Trade Listing with Reference '.$input['id'].' by '.number_format($amount,5).$coin;
            //send message to sender and add to activity
            $mailMessage ="A topup of the Trade Listing with reference <b>".$input['id']."</b> just took place
            on your ".config('app.name')." account. Your <b>".$coin."</b> atrading ccount was debited of
            <b>".number_format($amount,5)."</b> to fund this topup. Your new balance
            after this is ".number_format($newBalance,5).$coin.". If this was not authorized by you, please
            contact support right away.";
            $dataActivity = ['user' => $user->id, 'activity' => 'Trade List Topup',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'Trade List Topup'));

            $success['topup']=true;
            return $this->sendResponse($success, 'Offer topped up.');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
                '422', 'Validation Failed');
        }
    }
    public function cancelOffer(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'id' => ['bail', 'required', 'numeric'],
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
        //check if the pin is okay
        $hashed = Hash::check($input['pin'],$user->transPin);
        if (!$hashed) {
            return $this->sendError('Error validation', ['error' => 'Invalid Account Pin'], '422', 'Validation Failed');
        }
        $offerExists = TradeOffering::where('reference',$input['id'])->where('user',$user->id)->first();
        if (empty($offerExists)) {
            return $this->sendError('Error validation', ['error' => 'Unauthorized Action. Please contact support'],
                '422', 'Validation Failed');
        }
        $coin = $offerExists->asset;
        //check if the asset is supported
        $coinExists = Coin::where('asset',$coin)->where('status',1)->first();
        if (empty($coinExists)) {
            return $this->sendError('Error validation', ['error' => 'Asset not supported'], '422', 'Validation Failed');
        }
        //get trading balance of the user
        $userTradingBalance = UserTradingBalance::where('user',$user->id)->where('asset',$coin)->first();
        //if everything checks out well
        $amount = $offerExists->availableBalance;
        $dataOffer = [
            'status'=>3,
            'availableBalance'=>$offerExists->availableBalance-$amount,
        ];
        $newBalance = $userTradingBalance->availableBalance+$amount;
        $dataTradingBalance =[
            'availableBalance'=>$newBalance
        ];
        $update = TradeOffering::where('id',$offerExists->id)->update($dataOffer);
        if ($update) {
            UserTradingBalance::where('id',$userTradingBalance->id)->update($dataTradingBalance);
            $details='Cancellation fo Trade Listing with Reference '.$input['id'];
            //send message to sender and add to activity
            $mailMessage ="Your Trade listing with reference <b>".$input['id']."</b> has been cancelled.
            If this was not authorized by you, please contact support right away.";
            $dataActivity = ['user' => $user->id, 'activity' => 'Trade List Cancellation',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'Trade List Cancellation'));

            $success['cancelled']=true;
            return $this->sendResponse($success, 'Offer cancelled');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
                '422', 'Validation Failed');
        }
    }
    public  function buyTrade(Request $request){
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'id' => ['bail', 'required', 'numeric'],
                'amount' => ['bail', 'required', 'string'],
                'details' => ['bail', 'nullable', 'string'],
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
        $amount = str_replace(',','',$input['amount']);
        //check if the pin is okay
        $hashed = Hash::check($input['pin'],$user->transPin);
        if (!$hashed) {
            return $this->sendError('Error validation', ['error' => 'Invalid Account Pin'], '422', 'Validation Failed');
        }
        $offerExists = TradeOffering::where('reference',$input['id'])->where('status',1)->first();
        if (empty($offerExists)) {
            return $this->sendError('Error validation', ['error' => 'Listing not found. Please contact support'],
                '422', 'Validation Failed');
        }
        $coin = $offerExists->asset;
        $currency = $offerExists->currency;
        //check if the asset is supported
        $coinExists = Coin::where('asset',$coin)->where('status',1)->first();
        if (empty($coinExists)) {
            return $this->sendError('Error validation', ['error' => 'Asset not supported'],
                '422', 'Validation Failed');
        }
        //get the buyer account balance
        $buyerAccountBalance = UserBalance::where('user',$user->id)->where('currency',$offerExists->currency)->first();
        //check if the buyer has enough balance to cover for this action
        $buyerBalance = $buyerAccountBalance->availableBalance;
        if ($amount > $buyerBalance){
            return $this->sendError('Error validation', ['error' => 'Insufficient Balance. Please fund your
            account before proceeding.'],'422', 'Validation Failed');
        }
        $newBuyerBalance = $buyerBalance - $amount;
        //get the coin equivalence of the amount
        //First we get the trade offer rate
        $sellerRate = $this->regular->getTradeOfferrate($offerExists->id);
        //get the exchange rate
        $systemRate = $this->regular->getCryptoExchangeUserRate($coin,$currency,$sellerRate);
        $coinAmount = $amount/$systemRate;
        //check if the offer has up to this amount in it
        if ($coinAmount > $offerExists->availableBalance){
            return $this->sendError('Error validation', ['error' => 'Purchase amount is higher than the
            listed amount.'],'422', 'Validation Failed');
        }
        //get the charge
        $charge = $this->regular->calculateTradeFee($amount);
        $amountAfterCharge = $amount-$charge;
        //check if the trader has a loan
        $hasLoan = CryptoLoan::where('user',$offerExists->user)->where('asset',$offerExists->asset)->first();
        if (!empty($hasLoan)){
            $resellRate = $amountAfterCharge*($hasLoan->apr/100);
            $amountToTrader = $resellRate;
            $amountToLender = $amountAfterCharge - $resellRate;
            $loanDat=1;
        }else{
            $resellRate =0;
            $amountToTrader = $amountAfterCharge;
            $amountToLender=0;
            $loanDat=2;
        }
        $sellerBalance = UserBalance::where('currency',$offerExists->currency)->where('user',$offerExists->user)->first();
        $newSellerBalance = $sellerBalance->availableBalance + $amountToTrader;
        $sellerBalanceData = [
            'availableBalance'=>$newSellerBalance
        ];
        $buyerBalanceData=[
            'availableBalance'=>$newBuyerBalance
        ];
        $offerBalance = $offerExists->availableBalance;
        $newOfferBalance = $offerBalance - $coinAmount;
        $offerData=[
            'availableBalance'=>$newOfferBalance
        ];
    }
}
