<?php

use App\Http\Controllers\Web\HomeController;
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
    Route::get('register',[Register::class,'index']);
});
