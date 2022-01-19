<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSetting;
use App\Models\TradingPair;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(6)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> config('app.name').' - Buy and Sell cryptocurrency, and with more trust',
            'trade_pairs'=>$tradingPairs,
            'pairs'=>$coins,
            'coins'=>$coins,
            'fiats'=>$fiats
        ];
        return view('home',$viewData);
    }
    public function about()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(6)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'About',
            'trade_pairs'=>$tradingPairs,
        ];
        return view('about',$viewData);
    }
}
