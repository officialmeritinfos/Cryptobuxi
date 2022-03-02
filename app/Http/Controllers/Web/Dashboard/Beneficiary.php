<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Custom\GenerateUnique;
use App\Custom\Regular;
use App\Custom\Wallet;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\UserBeneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Beneficiary extends Controller
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
            'pageName'=>'Transfer Beneficiaries',
            'web'=>$web,
            'user'=>$user,
            'beneficiaries'=>UserBeneficiary::where('user',$user->id)->get()
        ];
        return view('dashboard.beneficiary',$viewData);
    }
}
