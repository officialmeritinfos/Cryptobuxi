<?php

namespace App\Http\Controllers\Web;

use App\Custom\Regular;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSetting;
use App\Models\TradingPair;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public $regular;
    public function __construct() {
        $this->regular = new Regular();
    }
    public function index()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
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
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
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
    public function team()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'Executive Team',
            'trade_pairs'=>$tradingPairs,
        ];
        return view('team',$viewData);
    }
    public function career()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'Join us',
            'trade_pairs'=>$tradingPairs,
        ];
        return view('career',$viewData);
    }
    public function wallet()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> $webSettings->siteName.' Wallet',
            'trade_pairs'=>$tradingPairs,
            'coins'=>$coins,
        ];
        return view('wallet',$viewData);
    }
    public function contact()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> $webSettings->siteName.' Wallet',
            'trade_pairs'=>$tradingPairs,
            'coins'=>$coins,
        ];
        return view('contact',$viewData);
    }
    public function legal()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> $webSettings->siteName.' Terms',
            'trade_pairs'=>$tradingPairs,
            'coins'=>$coins,
        ];
        return view('terms',$viewData);
    }
    public function privacy()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> $webSettings->siteName.' Privacy Policy',
            'trade_pairs'=>$tradingPairs,
            'coins'=>$coins,
        ];
        return view('privacy',$viewData);
    }

    public function aml()
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> $webSettings->siteName.' Anti-money Laundering Policy',
            'trade_pairs'=>$tradingPairs,
            'coins'=>$coins,
        ];
        return view('aml',$viewData);
    }
    public function pricing(Request $request)
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = ($request->has('country')) ? CurrencyAccepted::where('country','all')->orWhere('country',$request->get('country'))->where(function($query){
                $query->where('status',1);
            })->get() : CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> $webSettings->siteName.' Pricing',
            'trade_pairs'=>$tradingPairs,
            'coins'=>$coins,
            'fiats'=>$fiats
        ];
        return view('pricing',$viewData);
    }
    public function affiliate(Request $request)
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = ($request->has('country')) ? CurrencyAccepted::where('country','all')->orWhere('country',$request->get('country'))->where(function($query){
                $query->where('status',1);
            })->get() : CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> $webSettings->siteName.' Affiliate',
            'trade_pairs'=>$tradingPairs,
            'coins'=>$coins,
            'fiats'=>$fiats
        ];
        return view('affiliate',$viewData);
    }
    public function earn(Request $request)
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = ($request->has('country')) ? CurrencyAccepted::where('country','all')->orWhere('country',$request->get('country'))->where(function($query){
                $query->where('status',1);
            })->get() : CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> $webSettings->siteName.' Referral',
            'trade_pairs'=>$tradingPairs,
            'coins'=>$coins,
            'fiats'=>$fiats
        ];
        return view('earn',$viewData);
    }
    public function supported_crypto(Request $request)
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = ($request->has('country')) ? CurrencyAccepted::where('country','all')->orWhere('country',$request->get('country'))->where(function($query){
                $query->where('status',1);
            })->get() : CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> 'Supported Assets',
            'trade_pairs'=>$tradingPairs,
            'coins'=>$coins,
            'fiats'=>$fiats
        ];
        return view('supported-assets',$viewData);
    }
    public function buy(Request $request)
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
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
        return view('buy',$viewData);
    }
    public function lending(Request $request)
    {
        $webSettings = GeneralSetting::where('id',1)->first();
        $tradingPairs = TradingPair::where('status',1)->limit(5)->inRandomOrder()->get();
        $coins = Coin::where('status',1)->get();
        $fiats = CurrencyAccepted::where('status',1)->get();
        $viewData=[
            'siteName'=>$webSettings->siteName,
            'web'=>$webSettings,
            'pageName'=> ' Borrow from '.config('app.name').', pay back later.',
            'trade_pairs'=>$tradingPairs,
            'pairs'=>$coins,
            'coins'=>$coins,
            'fiats'=>$fiats
        ];
        return view('borrow',$viewData);
    }
    public function getCryptToFiatRate($crypto,$fiat,$amount)
    {
        //check if fiat is supported
        $currencySupported = CurrencyAccepted::where('code',strtoupper($fiat))->first();
        if (empty($currencySupported)) {
            return $this->sendError('validation Error ', ['error' => 'Unsupported fiat'], '422', 'Fiat not supported');
        }
        //check if crypto is supported
        $coin = Coin::where('asset',strtoupper($crypto))->where('status',1)->first();
        if(empty($coin)){
            return $this->sendError('validation Error ', ['error' => 'Unsupported asset'], '422', 'Asset not supported');
        }
        $cryptoRate = $this->regular->getCryptoExchange(strtoupper($crypto),strtoupper($fiat));
        $amount = str_replace(',','',$amount);
        //check if the amount is numeric
        if (!is_numeric($amount)) {
            return $this->sendError('validation Error ', ['error' => 'Amount must be numeric'], '422', 'Asset not supported');
        }
        //get the rate
        $rate = $amount *$cryptoRate;
        $success['fetched'] = true;
        $success['rate']=$rate;
        return $this->sendResponse($success, 'Fetched');
    }
    public function getFiatToCryptoRate($crypto,$fiat,$amount)
    {
        //check if fiat is supported
        $currencySupported = CurrencyAccepted::where('code',strtoupper($fiat))->first();
        if (empty($currencySupported)) {
            return $this->sendError('validation Error ', ['error' => 'Unsupported fiat'], '422', 'Fiat not supported');
        }
        //check if crypto is supported
        $coin = Coin::where('asset',strtoupper($crypto))->where('status',1)->first();
        if(empty($coin)){
            return $this->sendError('validation Error ', ['error' => 'Unsupported asset'], '422', 'Asset not supported');
        }
        $cryptoRate = $this->regular->getCryptoExchange(strtoupper($crypto),strtoupper($fiat));
        $amount = str_replace(',','',$amount);
        //check if the amount is numeric
        if (!is_numeric($amount)) {
            return $this->sendError('validation Error ', ['error' => 'Amount must be numeric'], '422', 'Asset not supported');
        }
        //get the rate
        $rate = $amount /$cryptoRate;
        $success['fetched'] = true;
        $success['rate']=$rate;
        return $this->sendResponse($success, 'Fetched');
    }
}
