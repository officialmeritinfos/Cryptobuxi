<?php

use App\Http\Controllers\Web\Dashboard\Home;
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
Route::middleware('checkCountry')->group(function(){
    Route::get('price',[HomeController::class,'pricing']);
});
/*===========AUTHENTICATION ROUTE======================*/
Route::get('register',[Register::class,'index']);
Route::post('register',[Register::class,'doRegister']);
Route::get('/email/verify/{id}/{hash}',[Register::class,'verifyEmail'])->name('complete-verification');
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
        Route::get('dashboard',[Home::class,'index']);
        Route::post('dashboard/set_pin',[Home::class,'setPin']);
        Route::post('dashboard/identity_verification',[Home::class,'verifyAccount']);
        Route::post('dashboard/identity_verification_doc',[Home::class,'verifyAccountDoc']);
        Route::get('dashboard/get_receive_wallet/{asset}',[Home::class,'getReceiveWallet']);
        Route::get('dashboard/test_caching/{asset}',[Home::class,'testEndpointCache']);
    });
    //Logout Route
    Route::get('account/logout',[Login::class,'logout']);
});
Route::post('resetpassword',[RecoverPassword::class,'doReset']);
