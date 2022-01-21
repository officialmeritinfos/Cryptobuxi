<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class Register extends Controller
{
    public function index()
    {
        $webSettings = GeneralSetting::findOrFail(1);
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'Account Registration Page',
        ];
        return view('auth.register',$viewData);
    }
}
