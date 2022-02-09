<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Login;
use App\Models\UserActivitiy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Activities extends Controller
{
    public function index(){
        $generalSettings = GeneralSetting::where('id',1)->first();
        $user=Auth::user();
        $activities = UserActivitiy::where('user',$user->id)->orderBy('created_at','desc')->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Activities','slogan'=>'- Making safer transactions','user'=>$user,
            'activities'=>$activities,'siteName'=>$generalSettings->siteName];
        return view('dashboard.activities',$dataView);
    }
    public function logins(){
        $generalSettings = GeneralSetting::where('id',1)->first();
        $user=Auth::user();
        $logins = Login::where('user',$user->id)->orderBy('id','desc')->get();
        $dataView=['web'=>$generalSettings,'pageName'=>'Logins','slogan'=>'- Making safer transactions','user'=>$user,
            'logins'=>$logins,'siteName'=>$generalSettings->siteName];
        return view('dashboard.activities',$dataView);
    }
}
