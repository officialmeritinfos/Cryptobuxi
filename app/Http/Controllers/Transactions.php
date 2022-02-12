<?php

namespace App\Http\Controllers;

use App\Events\AccountActivity;
use App\Models\ChargeClearance;
use App\Models\ChargeWallet;
use App\Models\Coin;
use App\Models\Deposit;
use App\Models\PendingClearance;
use App\Models\SystemAccount;
use App\Models\SystemIncoming;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletBalance;
use App\Models\WalletTransaction;
use App\Notifications\AccountNotification;
use Illuminate\Http\Request;

class Transactions extends Controller
{
    public function incoming(Request $request, $customId,$accountId)
    {
        //get the payload from tatum.io
        $asset=$request->input('currency');
        $amount=$request->input('amount');
        $id=$request->input('accountId');
        $datePaid=$request->input('date');
        $txId=$request->input('txId');
        $blockHeight=$request->input('blockHeight');
        if ($request->has('from')){
            $addressFrom=$request->input('from');
        }else{
            $addressFrom='';
        }
        if ($request->has('blockHash')){
            $blockHash=$request->input('blockHash');
        }else{
            $blockHash='';
        }
        $addressTo=$request->input('to');
        $memo=$request->input('memo');

        //check if the currency has memo
        $coin = Coin::where('asset',strtoupper($asset))->first();
        //get the balance that has the address
        $wallet = Wallet::where('accountId',$id)->first();
        //calculate charges
        $coinExist = Coin::where('asset',strtoupper($asset))->first();
        $amountReceived = $request->input('amount');
        $amountToCredit = $amountReceived;
        $user = User::where('id',$wallet->user)->first();
        //admin
        $admin = User::where('is_admin',1)->first();
        if (!empty($wallet)) {
            $balance = Wallet::where('user',$wallet->user)->where('asset',$wallet->asset)->first();

            $admin = User::where('is_admin',1)->first();
            $newBalance = $balance->availableBalance+$amountToCredit;
            $dataBalance = ['availableBalance'=>$newBalance];
            $dataDeposit =[
                'user'=>$wallet->user,
                'asset'=>strtoupper($asset),
                'addressFrom'=>$addressFrom,
                'addressTo'=>$addressTo,
                'accountId'=>$id,
                'transHash'=>$txId,
                'blockHeight'=>$blockHeight,
                'blockHash'=>$blockHash,
                'status'=>1,
                'amount'=>$amountToCredit
            ];
            $dataWalletTransaction =[
                'user'=>$wallet->user,
                'asset'=>strtoupper($asset),
                'transType'=>1,
                'networkFee'=>0,
                'amount'=>$amountToCredit,
                'accountId'=>$wallet->accountId,
                'customId'=>$wallet->customId,
                'transId'=>$txId,
                'transHash'=>$txId,
                'status'=>1,
                'walletType'=>1,
                'walletId'=>$wallet->id,
            ];
            $addToSyStemWallet = 2;
            //check if this transaction already exists
            $depositExists = Deposit::where('user',$wallet->user)->where('transHash',$txId)->first();
            if (!empty($depositExists)) {
                //check if the amount is the same
                if ($amountToCredit == $depositExists->amount) {
                    $add = 2;
                }else{
                    $add = 1;
                }
            }else{
                $add = 1;
            }
            if($add == 1){
                $update = Wallet::where('id',$balance->id)->update($dataBalance);
                if ($update) {
                    Deposit::create($dataDeposit);
                    WalletTransaction::create($dataWalletTransaction);
                    $message ='Your '.config('app.name').' account has received some token. '.$amountToCredit.$asset.' was successfully deposited
                    into your account.';
                    $url = url('account/login');
                    $user->notify(new AccountNotification($user->name,$message,$url,'New Deposit of '.$amountToCredit.$asset));
                    $details = 'Your '.config('app.name').' account received a deposit of '.$amountToCredit.$asset;
                    $dataActivity = ['user' => $user->id, 'activity' => $asset.' Deposit', 'details' => $details, 'agent_ip' => $request->ip()];
                    event(new AccountActivity($user, $dataActivity));
                }
            }
        }
    }

}
