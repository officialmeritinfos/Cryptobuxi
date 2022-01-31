<?php

namespace App\Console\Commands;

use App\Custom\GenerateUnique;
use App\Custom\Wallet;
use App\Models\Coin;
use App\Models\SystemAccount;
use App\Models\User;
use App\Models\Wallet as ModelsWallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class createUserTokenAccount extends Command
{
    use GenerateUnique;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:userTokenWallet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Initializing Main Network Tokens such as TRC20 and ERC20';
    public $wallet;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->wallet = new Wallet();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $coins = Coin::where('status',1)->where('mainNetwork',2)->get();
        if ($coins->count()>0) {
            foreach ($coins as $coin) {
                 //check if the coin has been initialized earlier
                $systemAccount = SystemAccount::where('asset',$coin->asset)->first();
                if (!empty($systemAccount)) {
                    //get a user
                    $users = User::where('status',1)->get();
                    if ($users->count()>0) {
                        foreach ($users as $user) {
                            $walletExists = ModelsWallet::where('user',$user->id)->where('asset',$coin->asset)->first();
                            if (empty($walletExists)) {
                                //let us generate the wallets. We will split them into functions for ease
                                switch ($coin->asset) {
                                    case 'USDT_TRON':
                                        $this->generateUsdtWallet($coin,$user);
                                        break;
                                    case 'BUSD_BSC':
                                            $this->generateBusdWallet($coin,$user);
                                            break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function generateUsdtWallet($coin,$user)
    {
        $sysAccount = ModelsWallet::where('asset','Tron')->first();
        if (!empty($sysAccount)) {

            //xpub and mnemonic
            $xpub = $sysAccount->pubKey;
            $mnemonic = Crypt::decryptString($sysAccount->mnemonic);
            $new_mnemonic =$sysAccount->mnemonic;
            $accountKey = $xpub;

            //generate an account for it
            $dataAccount = [
                'currency' => $coin->asset,
                'xpub' => $accountKey,
                'accountingCurrency' => 'USD'
            ];
            $account = $this->wallet->createAccount($dataAccount);
            if ($account->ok()) {
                $accountId = $account['id'];
                //create a deposit address
                $generateAddress = $this->wallet->generateAddress($accountId);
                if ($generateAddress->ok()) {
                    $dataAddress = [
                        'asset' => $coin->asset,
                        'accountId' => $accountId,
                        'address' => $generateAddress['address'],
                        'hasMemo' => $coin->hasMemo,
                        'memo'=>'',
                        'priKey'=>'',
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>2,
                        'derivationKey'=>$generateAddress['derivationKey'],
                        'customId'=>$this->createUniqueRef('system_accounts','customId'),
                        'walletType'=>1,
                        'user'=>$user->id
                    ];
                    ModelsWallet::create($dataAddress);
                }else{
                    Log::alert($generateAddress->json());
                }
            }else{
                Log::alert($account->json());
            }
        }
    }
    public function generateBusdWallet($coin,$user)
    {
        $sysAccount = ModelsWallet::where('asset','BSC')->first();
        if (!empty($sysAccount)) {

            //xpub and mnemonic
            $xpub = $sysAccount->pubKey;
            $mnemonic = Crypt::decryptString($sysAccount->mnemonic);
            $new_mnemonic =$sysAccount->mnemonic;
            $accountKey = $xpub;

            //generate an account for it
            $dataAccount = [
                'currency' => $coin->asset,
                'xpub' => $accountKey,
                'accountingCurrency' => 'USD'
            ];
            $account = $this->wallet->createAccount($dataAccount);
            if ($account->ok()) {
                $accountId = $account['id'];
                //create a deposit address
                $generateAddress = $this->wallet->generateAddress($accountId);
                if ($generateAddress->ok()) {
                    $dataAddress = [
                        'asset' => $coin->asset,
                        'accountId' => $accountId,
                        'address' => $generateAddress['address'],
                        'hasMemo' => $coin->hasMemo,
                        'memo'=>'',
                        'priKey'=>'',
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>2,
                        'derivationKey'=>$generateAddress['derivationKey'],
                        'customId'=>$this->createUniqueRef('system_accounts','customId'),
                        'walletType'=>1,
                        'user'=>$user->id
                    ];
                    ModelsWallet::create($dataAddress);
                }else{
                    Log::alert($generateAddress->json());
                }
            }else{
                Log::alert($account->json());
            }
        }
    }
}
