<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Custom\GenerateUnique;
use App\Custom\Regular;
use App\Custom\Wallet;
use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\Deposit;
use App\Models\FiatLoan;
use App\Models\GeneralSetting;
use App\Models\Loan;
use App\Models\Wallet as ModelsWallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountWallet extends Controller
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
        $balances = ModelsWallet::where('user',$user->id)->get();
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Wallets',
            'web'=>$web,
            'user'=>$user,
            'balances'=>$balances
        ];
        return view('dashboard.wallets',$viewData);
    }
    public function details($custId,Request $request)
    {
        $web = GeneralSetting::where('id',1)->first();
        $user  = Auth::user();
        $balance = ModelsWallet::where('user',$user->id)->where('customId',$custId)->first();
        if (empty($balance)) {
            return back()->with('error','Invalid wallet selected');
        }
        $coin = Coin::where('asset',$balance->asset)->first();
        $deposits = Deposit::where('user',$user->id)->where('asset',$balance->asset)->get();
        $crypto_loans = Loan::where('asset',$balance->asset)->where('user',$request->user()->id)->orWhere('lender',$request->user()->id)->paginate(
            $perPage = 15, $columns = ['*'], $pageName = 'crypto_loans'
        );
        $fiat_loans = FiatLoan::where('user',$request->user()->id)->orWhere('lender',$request->user()->id)->where('asset',$balance->asset)->paginate(
            $perPage = 15, $columns = ['*'], $pageName = 'fiat_loans'
        );
        $withdrawals = Withdrawal::where('user',$user->id)->where('asset',$balance->asset)->paginate(
            $perPage = 15, $columns = ['*'], $pageName = 'withdrawals'
        );
        $viewData = [
            'siteName'=>$web->siteName,
            'pageName'=>'Wallet Activities',
            'web'=>$web,
            'user'=>$user,
            'balances'=>$balance,
            'deposits'=>$deposits,
            'crypto_loans'=>$crypto_loans,
            'withdrawals'=>$withdrawals,
            'fiat_loans'=>$fiat_loans,
            'coin'=>$coin
        ];
        return view('dashboard.wallet_details',$viewData);
    }
}
