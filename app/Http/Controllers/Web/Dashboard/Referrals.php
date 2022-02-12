<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserBalance;
use App\Models\UserReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Referrals extends Controller
{
    public function index(){
        $generalSettings = GeneralSetting::where('id',1)->first();
        $user=Auth::user();
        $referrals = User::where('refBy',$user->username)->get();
        $balance = UserBalance::where('user',$user->id)->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Referrals','siteName'=>$generalSettings->siteName,'user'=>$user,
            'referrals'=>$referrals,'balances'=>$balance];
        return view('dashboard.referrals',$dataView);
    }
     public function earnings(){
         $generalSettings = GeneralSetting::where('id',1)->first();
         $user=Auth::user();
         $ref_earning = UserReferral::where('referredBy',$user->id)->join('users','users.id','=','user_referrals.user')->get();
         $balance = UserBalance::where('user',$user->id)->get();
         $dataView=['web'=>$generalSettings,'pageName'=>'Referral Earnings','siteName'=>$generalSettings->siteName,'user'=>$user,
             'ref_trans'=>$ref_earning,'balances'=>$balance];
         return view('dashboard.referrals',$dataView);
     }
}
