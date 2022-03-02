<?php

use App\Http\Controllers\Transactions;
use App\Http\Controllers\Web\Dashboard\AccountWallet;
use App\Http\Controllers\Web\Dashboard\Activities;
use App\Http\Controllers\Web\Dashboard\Beneficiary;
use App\Http\Controllers\Web\Dashboard\Home;
use App\Http\Controllers\Web\Dashboard\Loans;
use App\Http\Controllers\Web\Dashboard\Referrals;
use App\Http\Controllers\Web\Dashboard\Settings;
use App\Http\Controllers\Web\Dashboard\Support;
use App\Http\Controllers\Web\Dashboard\Trades;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\Login;
use App\Http\Controllers\Web\RecoverPassword;
use App\Http\Controllers\Web\Register;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',[HomeController::class,'index']);
Route::get('/index',[HomeController::class,'index']);
Route::get('about',[HomeController::class,'about']);
Route::get('team',[HomeController::class,'team']);
Route::get('career',[HomeController::class,'career']);
Route::get('wallet',[HomeController::class,'wallet']);
Route::get('contact',[HomeController::class,'contact']);
Route::get('legal',[HomeController::class,'legal']);
Route::get('privacy',[HomeController::class,'privacy']);
Route::get('aml',[HomeController::class,'aml']);
Route::get('buy',[HomeController::class,'buy']);
Route::get('affiliate',[HomeController::class,'affiliate']);
Route::get('earn',[HomeController::class,'earn']);
Route::get('help',[HomeController::class,'help']);
Route::get('supported_crypto',[HomeController::class,'supported_crypto']);
Route::get('supported_countries',[HomeController::class,'supported_countries']);
Route::get('lending',[HomeController::class,'lending']);
Route::get('peer',[HomeController::class,'peer']);
Route::get('fiat_to_crypto/{crypto}/{fiat}/{amount}',[HomeController::class,'getFiatToCryptoRate']);
Route::get('crypto_to_fiat/{crypto}/{fiat}/{amount}',[HomeController::class,'getCryptToFiatRate']);
Route::get('get_fiat_loan_computation/{reference}/{duration}/{amount}',[HomeController::class,'computeFiatLoanReturns']);
Route::middleware('checkCountry')->group(function(){
    Route::get('price',[HomeController::class,'pricing']);
});
/*===========AUTHENTICATION ROUTE======================*/
Route::get('register',[Register::class,'index']);
Route::post('register',[Register::class,'doRegister']);
Route::get('/email/verify/{id}/{hash}',[Register::class,'verifyEmail'])->name('complete-verification');
Route::get('/register/complete/{id}/{hash}',[Register::class,'completeAccount'])->name('complete-account');
Route::get('login',[Login::class,'index'])->name('login');
Route::post('login',[Login::class,'doLogin']);
Route::get('/login/verify/{id}/{hash}',[Login::class,'verifyLogin'])->name('complete-login');
Route::get('recoverpassword',[RecoverPassword::class,'index'])->name('recoverpassword');
Route::post('recoverpassword',[RecoverPassword::class,'doRecover']);
Route::get('/recoverpassword/verify/{id}/{hash}',[RecoverPassword::class,'verifyReset'])->name('complete-recover');
Route::middleware(['auth'])->group(function(){
    Route::get('register/confirm/{email}',[Register::class,'confirmationNeeded'])->name('emailVerify');
    Route::get('login/confirm/{email}',[Login::class,'confirmationNeeded'])->name('twoway');

    /*====================DASHBOARD ROUTE ============*/
    Route::middleware(['twoWay','emailVerify'])->prefix('account')->group(function (){
        /*============= DASHBOARD LANDING REQUESTS ================= */
        Route::get('dashboard',[Home::class,'index']);
        Route::get('index',[Home::class,'index']);
        Route::post('dashboard/set_pin',[Home::class,'setPin']);
        Route::post('dashboard/identity_verification',[Home::class,'verifyAccount']);
        Route::post('dashboard/identity_verification_doc',[Home::class,'verifyAccountDoc']);
        Route::get('dashboard/get_receive_wallet/{asset}',[Home::class,'getReceiveWallet']);
        Route::get('dashboard/get_user_fiat',[Home::class,'getUserCurrency']);
        Route::post('dashboard/send_asset',[Home::class,'sendAsset']);
        /*============= ACCOUNT SETTINGS REQUESTS ================= */
        Route::get('settings',[Settings::class,'index']);
        Route::post('settings/profile_change',[\App\Http\Controllers\Web\Dashboard\Settings::class,'updateProfilePic']);
        Route::post('settings/change_password',[\App\Http\Controllers\Web\Dashboard\Settings::class,'updatePassword']);
        Route::post('settings/update_profile',[\App\Http\Controllers\Web\Dashboard\Settings::class,'updateProfile']);
        Route::post('settings/change_account',[\App\Http\Controllers\Web\Dashboard\Settings::class,'switchAccount']);
        Route::post('settings/update_security',[\App\Http\Controllers\Web\Dashboard\Settings::class,'updateSecurity']);
        /*============ ACCOUNT ACTIVITIES ========================*/
        Route::get('activities',[Activities::class,'index']);
        Route::get('logins',[Activities::class,'logins']);
        /*=========== WALLET ROUTES =======================*/
        Route::get('account_wallet',[AccountWallet::class,'index']);
        Route::get('account_wallet/{ref}/details',[AccountWallet::class,'details']);
        /*=========== REFERRAL ROUTES =======================*/
        Route::get('referrals',[Referrals::class,'index']);
        Route::get('referrals/earnings',[Referrals::class,'earnings']);
        /*=========== LOAN ROUTES =======================*/
        Route::get('loans',[Loans::class,'index']);
        Route::get('loans/lended',[Loans::class,'lended']);
        Route::get('loans/fiat',[Loans::class,'fiat']);
        Route::get('loans/fiat_lended',[Loans::class,'fiatLended']);
        Route::get('loan_center',[Loans::class,'loanCenter']);
        Route::get('loan_center/{ref}/details',[Loans::class,'cryptoLoanOfferingDetails']);
        Route::post('loans/create_crypto_loan_offering',[Loans::class,'createCryptoOffering']);
        Route::post('loans/top_up_crypto_loan_offering',[Loans::class,'topUpCryptoLoanOffering']);
        Route::post('loans/cancel_crypto_loan_offering',[Loans::class,'cancelCryptoLoanOffering']);
        Route::post('loans/accept_crypto_loan_offering',[Loans::class,'acceptCryptoLoanOffering']);
        Route::get('fiat_loan_center',[Loans::class,'fiatLoanCenter']);
        Route::get('fiat_loan_center/{ref}/details',[Loans::class,'fiatLoanOfferingDetails']);
        Route::post('loans/create_fiat_loan_offering',[Loans::class,'createFiatOffering']);
        Route::post('loans/top_up_fiat_loan_offering',[Loans::class,'topUpFiatLoanOffering']);
        Route::post('loans/cancel_fiat_loan_offering',[Loans::class,'cancelFiatLoanOffering']);
        Route::post('loans/accept_fiat_loan_offering',[Loans::class,'acceptFiatLoanOffering']);
        //This section of the loan route, allows user to view details of thier borrowed loans
        Route::get('loans/sent/{ref}',[Loans::class,'sentCryptoLoanDetails']);
        Route::get('loans/collected/{ref}',[Loans::class,'borrowedCryptoLoanDetails']);
        Route::get('loans/fiat/sent/{ref}',[Loans::class,'sentFiatLoanDetails']);
        Route::get('loans/fiat/collected/{ref}',[Loans::class,'borrowedFiatLoanDetails']);
        Route::post('loans/repay_fiat_loan',[Loans::class,'repayLoan']);
        /*=========== SUPPORT ROUTES =======================*/
        Route::get('support',[Support::class,'index']);
        Route::get('support/all',[Support::class,'allSupport']);
        Route::post('support/create',[Support::class,'createNew']);
        Route::get('support/{ref}/details',[Support::class,'ticketDetails']);
        Route::post('support/reply',[Support::class,'replySupport']);
        Route::get('support/close/{ref}',[Support::class,'closeTicket']);
        /*=========== USER BENEFICIARY ROUTES =======================*/
        Route::get('beneficiary',[Beneficiary::class,'index']);
        /*=========== USER BENEFICIARY ROUTES =======================*/
        Route::get('trades',[Trades::class,'index']);

    });
    //Logout Route
    Route::get('account/logout',[Login::class,'logout']);
});
Route::post('resetpassword',[RecoverPassword::class,'doReset']);
Route::post('transactions/user/{customId}/account/{accountId}',[Transactions::class,'incoming']);

//Check and compare dates
Route::get('comparedates',[HomeController::class,'checkandCompareDates']);
