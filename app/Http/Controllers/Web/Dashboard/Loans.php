<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Custom\GenerateUnique;
use App\Custom\Regular;
use App\Custom\Wallet;
use App\Events\AccountActivity;
use App\Events\AdminNotification;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\CryptoLoan;
use App\Models\CryptoLoanOffering;
use App\Models\CurrencyAccepted;
use App\Models\FiatLoan;
use App\Models\FiatLoanOffering;
use App\Models\FiatLoanReserve;
use App\Models\GeneralSetting;
use App\Models\Interval;
use App\Models\User;
use App\Models\UserBalance;
use App\Models\UserTradingBalance;
use App\Models\Wallet as ModelsWallet;
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
            'user_crypto_loan_offerings'=>CryptoLoanOffering::where('user',$user->id)->paginate(
                $perPage = 15, $columns = ['*'], $pageName = 'own_page'
            ),
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
            $details='A new crypto offering was created on your account.';
            //send message to sender and add to activity
            $mailMessage ="A new <b>".$coinExists->name."</b> Loan offering has been created on your
            ".config('app.name')." account. Your <b>".$coin."</b> Trading account was debited of
            <b>".$amount.$coinExists->icon."</b> to fund this offering. your new trading balance
            after this is ".$newBalance.$coin.". If this was not authorized by you, please contact support right away.";
            $dataActivity = ['user' => $user->id, 'activity' => 'New Crypto Loan Offering',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'New '.$coinExists->name.' Loan Offering'));

            $success['offered']=true;
            return $this->sendResponse($success, 'Offer created.');
        }
    }
    public function cryptoLoanOfferingDetails($ref)
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $loanOfferingExists = CryptoLoanOffering::where('reference',$ref)->first();
        if (empty($loanOfferingExists)) {
           return back()->with('error','Offer not found');
        }
        //get the user who made the offering available
        $offerOwner = User::where('id',$loanOfferingExists->user)->first();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Loan Offering Detail',
            'web'=>$web,
            'user'=>$user,
            'offering'=>$loanOfferingExists,
            'offerOwner'=>$offerOwner
        ];
        return view('dashboard.crypto_loan_offering_details',$viewData);
    }
    public function topUpCryptoLoanOffering(Request $request)
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
        $offerExists = CryptoLoanOffering::where('reference',$input['id'])->where('user',$user->id)->first();
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
        $amountListed = $offerExists->amount;
        $balance = $offerExists->availableBalance;
        //if everything checks out well
        $dataLoanOffering = [
            'amount'=>$amountListed+$amount,
            'availableBalance'=>$balance+$amount
        ];
        $newBalance = $userTradingBalance->availableBalance-$amount;
        $dataTradingBalance =[
            'availableBalance'=>$newBalance
        ];
        $create = CryptoLoanOffering::where('id',$offerExists->id)->update($dataLoanOffering);
        if (!empty($create)) {
            UserTradingBalance::where('id',$userTradingBalance->id)->update($dataTradingBalance);
            $details='Topup of Crypto Offering with Reference '.$input['id'].' by '.$amount.$coin;
            //send message to sender and add to activity
            $mailMessage ="A topup of the Crypto Loan Offering with reference <b>".$input['id']."</b> just took place
            on your ".config('app.name')." account. Your <b>".$coin."</b> Trading account was debited of
            <b>".$amount.$coinExists->icon."</b> to fund this topup. Your new trading balance
            after this is ".$newBalance.$coin.". If this was not authorized by you, please contact support right away.";
            $dataActivity = ['user' => $user->id, 'activity' => 'Crypto Loan Top',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'Crypto Loan Top Up'));

            $success['offered']=true;
            return $this->sendResponse($success, 'Offer topped up.');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
            '422', 'Validation Failed');
        }
    }
    public function cancelCryptoLoanOffering(Request $request)
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
        $offerExists = CryptoLoanOffering::where('reference',$input['id'])->where('user',$user->id)->first();
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
        $dataLoanOffering = [
            'status'=>3,
        ];
        $amount = $offerExists->availableBalance;
        $newBalance = $userTradingBalance->availableBalance+$amount;
        $dataTradingBalance =[
            'availableBalance'=>$newBalance
        ];
        $create = CryptoLoanOffering::where('id',$offerExists->id)->update($dataLoanOffering);
        if (!empty($create)) {
            UserTradingBalance::where('id',$userTradingBalance->id)->update($dataTradingBalance);
            $details='Cancellation fo Crypto Offering with Reference '.$input['id'];
            //send message to sender and add to activity
            $mailMessage ="Your Crypto Loan Offering with reference <b>".$input['id']."</b> has been cancelled.
            If this was not authorized by you, please contact support right away.";
            $dataActivity = ['user' => $user->id, 'activity' => 'Crypto Loan Cancellation',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'Crypto Loan Cancellation'));

            $success['offered']=true;
            return $this->sendResponse($success, 'Offer cancelled');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
            '422', 'Validation Failed');
        }
    }
    public function acceptCryptoLoanOffering(Request $request)
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
        $offerExists = CryptoLoanOffering::where('reference',$input['id'])->where('user', '!=',$user->id)->first();
        if (empty($offerExists)) {
            return $this->sendError('Error validation', ['error' => 'Unauthorized Action. Please contact support'],
            '422', 'Validation Failed');
        }
        if ($offerExists->status !=1) {
            return $this->sendError('Error validation', ['error' => 'You cannot accept a cancelled Offer'],
            '422', 'Validation Failed');
        }
        //check if user is on a loan before
        $userIsOnCryptoLoan = CryptoLoan::where('user',$user->id)->where('isPaidBack',2)->first();
        if (!empty($userIsOnCryptoLoan)) {
            return $this->sendError('Error validation', ['error' => 'You have an unpaid loan. Please clear up
            your loan(s) first before requesting for another one.'],'422', 'Validation Failed');
        }
        $coin = $offerExists->asset;
         //check if the asset is supported
         $coinExists = Coin::where('asset',$coin)->where('status',1)->first();
         if (empty($coinExists)) {
             return $this->sendError('Error validation', ['error' => 'Asset not supported'], '422', 'Validation Failed');
         }
        //get trading balance of the user
        $userTradingBalance = UserTradingBalance::where('user',$user->id)->where('asset',$coin)->first();
        $amountListed = $offerExists->amount;
        $balance = $offerExists->availableBalance;
        //check if the borrower's amount corresponds
        if($amountListed < $amount){
            return $this->sendError('Error validation', ['error' => 'Your requested amount is greater than the amount listed.'],
            '422', 'Validation Failed');
        }
        //check if user is allowed to make loan
        if ($user->canBorrow !=1) {
            return $this->sendError('Error validation', ['error' => 'Operation failed: user cannot accept loan offering'],
            '422', 'Validation Failed');
        }

        //if everything checks out well
        $reference = $this->createUniqueRef('crypto_loans','reference');
        $rate = $this->regular->getCryptoExchange($coin,$offerExists->fiat);
        $fiatAmount = $rate*$amount;
        $newBalance = $userTradingBalance->availableBalance+$amount;
        $dataLoan =[
            'reference'=>$reference,
            'offeringId'=>$offerExists->id,
            'user'=>$user->id,
            'asset'=>$coin,
            'amount'=>$amount,
            'apr'=>$offerExists->resellRate,
            'lender'=>$offerExists->user,
            'fiat'=>$offerExists->fiat,
            'fiatAmount'=>$fiatAmount,
            'status'=>2
        ];
        $newOfferBalance =$balance-$amount;
        $dataLoanOffering = [
            'availableBalance'=>$newOfferBalance
        ];
        $dataTradingBalance =[
            'availableBalance'=>$newBalance
        ];
        $offerOwner= User::where('id',$offerExists->user)->first();
        $create = CryptoLoan::create($dataLoan);
        if (!empty($create)) {
            UserTradingBalance::where('id',$userTradingBalance->id)->update($dataTradingBalance);
            CryptoLoanOffering::where('id',$offerExists->id)->update($dataLoanOffering);

            /* ========ADD ACTIVITIES TO BOTH PARTIES ================*/
            $borrowerDetails = 'A loan of '.number_format($amount,5).$coin.' was issued to you with reference '.$reference;
            $lenderDetails = 'A loan of '.number_format($amount,5).$coin.' has been issued from your offering with reference
            '.$offerExists->reference;
            $dataActivity = ['user' => $user->id, 'activity' => 'New Crypto Lending','details' => $borrowerDetails, 'agent_ip' => $request->ip()];
            $dataActivityOwner = ['user' => $offerOwner->id, 'activity' => 'New Crypto Lending Alert','details' => $lenderDetails, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new AccountActivity($offerOwner, $dataActivityOwner));

           /* ========SEND MAIL TO BOTH PARTIES AND ADMIN ================*/
           $mailToBorrower = 'Your loan request of <b>'.number_format($amount,5).$coin.'</b> has been approved and
           your <b>'.$coin.'</b> Trading account subsequently funded. Your Crypto Loan Reference is <b>'.$reference.'</b>.';
           $mailToLender = 'A loan request of <b>'.number_format($amount,5).$coin.'</b> from your offer with reference '.$offerExists->reference.'
           has been approved and offer debited. New Available balance is '.$newOfferBalance.'. Crypto Loan Reference is <b>'.$reference.'</b>';
           $mailToAdmin = 'A loan request of <b>'.number_format($amount,5).$coin.'</b> has been approved.
           Crypto Loan Reference is <b>'.$reference.'</b>.';

            event(new SendNotification($user,$mailToBorrower,'New Crypto Loan'));
            event(new SendNotification($offerOwner,$mailToLender,'New Crypto Loan Request'));

            event(new AdminNotification($mailToAdmin,'New Crypto Loan Request'));

            $success['credited']=true;
            return $this->sendResponse($success, 'Loan Credited');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
            '422', 'Validation Failed');
        }
    }
    /** ==================== FIAT LOAN SECTION ======================= */
    public function fiatLoanCenter()
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Fiat Loan Center',
            'web'=>$web,
            'user'=>$user,
            'fiat_loan_offerings'=>FiatLoanOffering::where('status',1)->where('user','!=',$user->id)->paginate(15),
            'user_fiat_loan_offerings'=>FiatLoanOffering::where('user',$user->id)->paginate(
                $perPage = 15, $columns = ['*'], $pageName = 'own_page'
            ),
            'fiats'=>CurrencyAccepted::where('status',1)->get(),
            'fiat_balances'=>UserBalance::where('user',$user->id)->get(),
            'intervals'=>Interval::where('status',1)->get(),
            'coins' =>Coin::where('status',1)->get()
        ];
        return view('dashboard.fiat_loan_center',$viewData);
    }
    public function createFiatOffering(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'currency' => ['bail', 'required', 'alpha'],
                'amount' => ['bail', 'required', 'string'],
                'apr' => ['bail', 'required', 'string'],
                'min_loan' => ['bail', 'required', 'string'],
                'max_loan' => ['bail', 'required', 'string'],
                'duration_type' => ['bail', 'required', 'numeric'],
                'duration' => ['bail', 'required', 'numeric'],
                'min_duration' => ['bail', 'required', 'numeric'],
                'max_duration' => ['bail', 'required', 'numeric'],
                'pin' => ['bail','required','numeric','digits:6'],
                'collateral'=>['bail', 'required', 'string'],
            ],
            ['required' => ':attribute is required'],
            [
                'duration_type' => 'Duration Type',
                'max_duration' => 'Maximum Loan Time',
            ]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        $input = $request->input();
        $currency = strtoupper($input['currency']);
        $amount = str_replace(',','',$input['amount']);
        $min_loan = str_replace(',','',$input['min_loan']);
        $max_loan = str_replace(',','',$input['max_loan']);
        //check if the pin is okay
        $hashed = Hash::check($input['pin'],$user->transPin);
        if (!$hashed) {
            return $this->sendError('Error validation', ['error' => 'Invalid Account Pin'], '422', 'Validation Failed');
        }
        //check if all is selected or a specific asset
        if ($input['collateral'] != 'all') {
            //check if coin is valid
            $coinExists = Coin::where('asset',$input['collateral'])->first();
            if (empty($coinExists)) {
                return $this->sendError('Error validation', ['error' => 'Collateral Asset not supported'], '422',
                'Validation Failed');
            }else{
                $acceptsAll = 2;
            }
        }else{
            $acceptsAll=1;
        }
        //check if the asset is supported
        $currencyExists = CurrencyAccepted::where('code',$currency)->where('status',1)->first();
        if (empty($currencyExists)) {
            return $this->sendError('Error validation', ['error' => 'Currency not supported'], '422', 'Validation Failed');
        }
        //check if the asset is supported
        $balanceExists = UserBalance::where('currency',$currency)->where('status',1)->first();
        if (empty($balanceExists)) {
            return $this->sendError('Error validation', ['error' => 'Balance not found'], '422', 'Validation Failed');
        }
        //check if the minimum loanable is up to the currency minimum loanable
        if ($currencyExists->minimumLoanable > $amount) {
            return $this->sendError('Error validation', ['error' => 'Amount is less than Minimum Loan Offerring for
            the selected currency'],'422', 'Validation Failed');
        }
        if ($currencyExists->minimumLoanable > $min_loan) {
            return $this->sendError('Error validation', ['error' => 'Your minimum loanable is less than the minimum loan
            offering amount for the currency selected.'],'422', 'Validation Failed');
        }
        if ($currencyExists->minimumLoanable > $max_loan) {
            return $this->sendError('Error validation', ['error' => 'Your maximum loanable is less than the minimum loan
            offering amount for the currency selected.'],'422', 'Validation Failed');
        }
        if ($max_loan > $amount) {
            return $this->sendError('Error validation', ['error' => 'Your maximum loanable is greater than the loan
            offering amount for the currency selected.'],'422', 'Validation Failed');
        }
        if ($min_loan > $max_loan) {
            return $this->sendError('Error validation', ['error' => 'Your minimum loanable is greater than the maximum loan
            offering amount for the currency selected.'],'422', 'Validation Failed');
        }
        if ($min_loan > $amount) {
            return $this->sendError('Error validation', ['error' => 'Your minimum loanable is greater than the loan
            offering amount for the currency selected.'],'422', 'Validation Failed');
        }
        if ($input['min_duration'] > $input['max_duration']) {
            return $this->sendError('Error validation', ['error' => 'Maximum Loan duration cannot be
            less than the minimum loan duration'],'422', 'Validation Failed');
        }
        if ($input['duration'] < $input['max_duration']) {
            return $this->sendError('Error validation', ['error' => 'Maximum Loan duration cannot be
            greater than the loan duration'],'422', 'Validation Failed');
        }
        if ($input['min_duration'] >$input['duration']) {
            return $this->sendError('Error validation', ['error' => 'Minimum Loan duration cannot be
            greater than the loan duration'],'422', 'Validation Failed');
        }

        $durationTypeExists = Interval::where('id',$input['duration_type'])->first();
        if (empty($durationTypeExists)) {
            return $this->sendError('Error validation', ['error' => 'Duration not supported'], '422', 'Validation Failed');
        }
        //check if the user has enough balance
        if($balanceExists->availableBalance < $amount){
            return $this->sendError('Error validation', ['error' => 'Insufficient balance in '.$balanceExists->currency.'
            Account. Please fund your '.$balanceExists->currency.' balance and try again.'],
            '422', 'Validation Failed');
        }
        //check if user is allowed to make loan
        if ($user->canLend !=1) {
            return $this->sendError('Error validation', ['error' => 'Operation failed: you cannot add loan offering'],
            '422', 'Validation Failed');
        }
        $reference = $this->createUniqueRef('fiat_loan_offerings','reference');
        //if everything checks out well
        $dataLoanOffering = [
            'user'=>$user->id,
            'reference'=>$reference,
            'currency'=>$currency,
            'amount'=>$amount,
            'apr'=>$input['apr'],
            'duration'=>$input['duration'],
            'minimumAmount'=>$min_loan,
            'maximumAmount'=>$max_loan,
            'minimumDuration'=>$input['min_duration'],
            'maximumDuration'=>$input['max_duration'],
            'status'=>1,
            'durationType'=>$durationTypeExists->name,
            'acceptsAll'=>$acceptsAll,
            'asset'=>$input['collateral']
        ];
        $newBalance = $balanceExists->availableBalance-$amount;
        $dataBalance =[
            'availableBalance'=>$newBalance
        ];
        $dataReserve =[
            'reference'=>$reference,
            'availableBalance'=>$amount,
            'user'=>$user->id
        ];

        $create = FiatLoanOffering::create($dataLoanOffering);
        if (!empty($create)) {
            FiatLoanReserve::create($dataReserve);
            UserBalance::where('id',$balanceExists->id)->update($dataBalance);
            $details='A new fiat offering was created on your account.';
            //send message to sender and add to activity
            $mailMessage ="A new <b>".$currencyExists->code."</b> Loan offering has been created on your
            ".config('app.name')." account. Your ".$currency." account was debited of ".$currency.$amount." to
            fund this offering. Your new balance after this is <b>".$currency.number_format($newBalance,2).".</b>
            If this was not authorized by you, please contact support right away. Your Reference Id is <b>".$reference."</b>";
            $dataActivity = ['user' => $user->id, 'activity' => 'New Fiat Loan Offering',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'New '.$currency.' Loan Offering'));

            $success['offered']=true;
            return $this->sendResponse($success, 'Offer created.');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
            '422', 'Validation Failed');
        }
    }
    public function fiatLoanOfferingDetails($ref)
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $loanOfferingExists = FiatLoanOffering::where('reference',$ref)->first();
        if (empty($loanOfferingExists)) {
           return back()->with('error','Offer not found');
        }
        //get the user who made the offering available
        $offerOwner = User::where('id',$loanOfferingExists->user)->first();
        $coins = ($loanOfferingExists->acceptsAll ==1 ) ?
        Coin::where('status',1)->get():
        Coin::where('status',1)->where('asset',$loanOfferingExists->asset) ->get();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Loan Offering Detail',
            'web'=>$web,
            'user'=>$user,
            'offering'=>$loanOfferingExists,
            'offerOwner'=>$offerOwner,
            'coins' =>Coin::where('status',1)->get(),
            'balance'=>FiatLoanReserve::where('reference',$ref)->first(),
            'crypto_balances'=>$coins,
        ];
        return view('dashboard.fiat_loan_offering_details',$viewData);
    }
    public function topUpFiatLoanOffering(Request $request)
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
        $offerExists = FiatLoanOffering::where('reference',$input['id'])->where('user',$user->id)->first();
        if (empty($offerExists)) {
            return $this->sendError('Error validation', ['error' => 'Unauthorized Action. Please contact support'],
            '422', 'Validation Failed');
        }
        if ($offerExists->status !=1) {
            return $this->sendError('Error validation', ['error' => 'You cannot top up a cancelled Offer'],
            '422', 'Validation Failed');
        }
        $currency = $offerExists->currency;
         //check if the asset is supported
         $currencyExists = CurrencyAccepted::where('code',$currency)->where('status',1)->first();
         if (empty($currencyExists)) {
             return $this->sendError('Error validation', ['error' => 'Currency not supported'], '422', 'Validation Failed');
         }
        //get trading balance of the user
        $userBalance = UserBalance::where('user',$user->id)->where('currency',$currency)->first();
        if($userBalance->availableBalance < $amount){
            return $this->sendError('Error validation', ['error' => 'Insufficient trading balance for '.$currencyExists->name.'
            Account Balance. Please fund your balance and try again.'],
            '422', 'Validation Failed');
        }
        //check if user is allowed to make loan
        if ($user->canLend !=1) {
            return $this->sendError('Error validation', ['error' => 'Operation failed: user cannot add loan offering'],
            '422', 'Validation Failed');
        }
        //get the Loan Reserve
        $offerReserve = FiatLoanReserve::where('reference',$offerExists->reference)->where('user',$user->id)->first();
        $amountListed = $offerExists->amount;
        $offerBalance = $offerReserve->availableBalance;
        //if everything checks out well
        $dataLoanOffering = [
            'amount'=>$amountListed+$amount,
        ];
        $dataLoanOfferingReserve = [
            'availableBalance'=>$offerBalance+$amount,
        ];

        $newBalance = $userBalance->availableBalance-$amount;
        $dataBalance =[
            'availableBalance'=>$newBalance
        ];
        $update = FiatLoanOffering::where('id',$offerExists->id)->update($dataLoanOffering);
        if (!empty($update)) {
            UserBalance::where('id',$userBalance->id)->update($dataBalance);
            FiatLoanReserve::where('id',$offerReserve->id)->update($dataLoanOfferingReserve);
            $details='Topup of Fiat Offering with Reference '.$input['id'].' by '.$currency.number_format($amount,2);
            //send message to sender and add to activity
            $mailMessage ="A topup of the Fiat Loan Offering with reference <b>".$input['id']."</b> just took place
            on your ".config('app.name')." account. Your <b>".$currency."</b> account was debited of
            <b>".number_format($amount,2)."</b> to fund this topup. Your new balance
            after this is ".$currency.number_format($newBalance,2).". If this was not authorized by you, please
            contact support right away.";
            $dataActivity = ['user' => $user->id, 'activity' => 'Fiat Loan Top',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'Fiat Loan Top Up'));

            $success['offered']=true;
            return $this->sendResponse($success, 'Offer topped up.');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
            '422', 'Validation Failed');
        }
    }
    public function cancelFiatLoanOffering(Request $request)
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
        $offerExists = FiatLoanOffering::where('reference',$input['id'])->where('user',$user->id)->first();
        if (empty($offerExists)) {
            return $this->sendError('Error validation', ['error' => 'Unauthorized Action. Please contact support'],
            '422', 'Validation Failed');
        }
        $currency = $offerExists->currency;
         //check if the asset is supported
         $currencyExists = CurrencyAccepted::where('code',$currency)->where('status',1)->first();
         if (empty($currencyExists)) {
             return $this->sendError('Error validation', ['error' => 'Currency not supported'], '422', 'Validation Failed');
         }
        //get trading balance of the user
        $userBalance = UserBalance::where('user',$user->id)->where('currency',$currency)->first();
        //if everything checks out well
        $dataLoanOffering = [
            'status'=>3,
        ];
        //get the Loan Reserve
        $offerReserve = FiatLoanReserve::where('reference',$offerExists->reference)->where('user',$user->id)->first();
        $amount = $offerReserve->availableBalance;
        $newBalance = $userBalance->availableBalance+$amount;
        $dataBalance =[
            'availableBalance'=>$newBalance
        ];
        $dataLoanOfferingReserve =[
            'availableBalance'=>0
        ];
        $update = FiatLoanOffering::where('id',$offerExists->id)->update($dataLoanOffering);
        if ($update) {
            UserBalance::where('id',$userBalance->id)->update($dataBalance);
            FiatLoanReserve::where('id',$offerReserve->id)->update($dataLoanOfferingReserve);

            $details='Cancellation fo Fiat Offering with Reference '.$input['id'];
            //send message to sender and add to activity
            $mailMessage ="Your Fiat Loan Offering with reference <b>".$input['id']."</b> has been cancelled.
            If this was not authorized by you, please contact support right away.";
            $dataActivity = ['user' => $user->id, 'activity' => 'Fiat Loan Cancellation',
                'details' => $details, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new SendNotification($user,$mailMessage,'Fiat Loan Cancellation'));

            $success['offered']=true;
            return $this->sendResponse($success, 'Offer cancelled');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
            '422', 'Validation Failed');
        }
    }
    public function acceptFiatLoanOffering(Request $request)
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
        $offerExists = CryptoLoanOffering::where('reference',$input['id'])->where('user', '!=',$user->id)->first();
        if (empty($offerExists)) {
            return $this->sendError('Error validation', ['error' => 'Unauthorized Action. Please contact support'],
            '422', 'Validation Failed');
        }
        if ($offerExists->status !=1) {
            return $this->sendError('Error validation', ['error' => 'You cannot accept a cancelled Offer'],
            '422', 'Validation Failed');
        }
        //check if user is on a loan before
        $userIsOnCryptoLoan = CryptoLoan::where('user',$user->id)->where('isPaidBack',2)->first();
        if (!empty($userIsOnCryptoLoan)) {
            return $this->sendError('Error validation', ['error' => 'You have an unpaid loan. Please clear up
            your loan(s) first before requesting for another one.'],'422', 'Validation Failed');
        }
        $coin = $offerExists->asset;
         //check if the asset is supported
         $coinExists = Coin::where('asset',$coin)->where('status',1)->first();
         if (empty($coinExists)) {
             return $this->sendError('Error validation', ['error' => 'Asset not supported'], '422', 'Validation Failed');
         }
        //get trading balance of the user
        $userTradingBalance = UserTradingBalance::where('user',$user->id)->where('asset',$coin)->first();
        $amountListed = $offerExists->amount;
        $balance = $offerExists->availableBalance;
        //check if the borrower's amount corresponds
        if($amountListed < $amount){
            return $this->sendError('Error validation', ['error' => 'Your requested amount is greater than the amount listed.'],
            '422', 'Validation Failed');
        }
        //check if user is allowed to make loan
        if ($user->canBorrow !=1) {
            return $this->sendError('Error validation', ['error' => 'Operation failed: user cannot accept loan offering'],
            '422', 'Validation Failed');
        }

        //if everything checks out well
        $reference = $this->createUniqueRef('crypto_loans','reference');
        $rate = $this->regular->getCryptoExchange($coin,$offerExists->fiat);
        $fiatAmount = $rate*$amount;
        $newBalance = $userTradingBalance->availableBalance+$amount;
        $dataLoan =[
            'reference'=>$reference,
            'offeringId'=>$offerExists->id,
            'user'=>$user->id,
            'asset'=>$coin,
            'amount'=>$amount,
            'apr'=>$offerExists->resellRate,
            'lender'=>$offerExists->user,
            'fiat'=>$offerExists->fiat,
            'fiatAmount'=>$fiatAmount,
            'status'=>2
        ];
        $newOfferBalance =$balance-$amount;
        $dataLoanOffering = [
            'availableBalance'=>$newOfferBalance
        ];
        $dataTradingBalance =[
            'availableBalance'=>$newBalance
        ];
        $offerOwner= User::where('id',$offerExists->user)->first();
        $create = CryptoLoan::create($dataLoan);
        if (!empty($create)) {
            UserTradingBalance::where('id',$userTradingBalance->id)->update($dataTradingBalance);
            CryptoLoanOffering::where('id',$offerExists->id)->update($dataLoanOffering);

            /* ========ADD ACTIVITIES TO BOTH PARTIES ================*/
            $borrowerDetails = 'A loan of '.number_format($amount,5).$coin.' was issued to you with reference '.$reference;
            $lenderDetails = 'A loan of '.number_format($amount,5).$coin.' has been issued from your offering with reference
            '.$offerExists->reference;
            $dataActivity = ['user' => $user->id, 'activity' => 'New Crypto Lending','details' => $borrowerDetails, 'agent_ip' => $request->ip()];
            $dataActivityOwner = ['user' => $offerOwner->id, 'activity' => 'New Crypto Lending Alert','details' => $lenderDetails, 'agent_ip' => $request->ip()];
            event(new AccountActivity($user, $dataActivity));
            event(new AccountActivity($offerOwner, $dataActivityOwner));

           /* ========SEND MAIL TO BOTH PARTIES AND ADMIN ================*/
           $mailToBorrower = 'Your loan request of <b>'.number_format($amount,5).$coin.'</b> has been approved and
           your <b>'.$coin.'</b> Trading account subsequently funded. Your Crypto Loan Reference is <b>'.$reference.'</b>.';
           $mailToLender = 'A loan request of <b>'.number_format($amount,5).$coin.'</b> from your offer with reference '.$offerExists->reference.'
           has been approved and offer debited. New Available balance is '.$newOfferBalance.'. Crypto Loan Reference is <b>'.$reference.'</b>';
           $mailToAdmin = 'A loan request of <b>'.number_format($amount,5).$coin.'</b> has been approved.
           Crypto Loan Reference is <b>'.$reference.'</b>.';

            event(new SendNotification($user,$mailToBorrower,'New Crypto Loan'));
            event(new SendNotification($offerOwner,$mailToLender,'New Crypto Loan Request'));

            event(new AdminNotification($mailToAdmin,'New Crypto Loan Request'));

            $success['credited']=true;
            return $this->sendResponse($success, 'Loan Credited');
        }else{
            return $this->sendError('Error validation', ['error' => 'Something went wrong. Please try again or contact support'],
            '422', 'Validation Failed');
        }
    }
}
