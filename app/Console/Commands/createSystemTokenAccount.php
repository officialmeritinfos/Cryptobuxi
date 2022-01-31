<?php

namespace App\Console\Commands;

use App\Custom\GenerateUnique;
use App\Custom\Wallet;
use App\Models\Coin;
use App\Models\SystemAccount;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class createSystemTokenAccount extends Command
{
    use GenerateUnique;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:systemTokenAccount';

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
        if ($coins->count() >0) {
            foreach ($coins as $coin) {
                //check if the coin has been added to the system
                $sysAccount = SystemAccount::where('asset',$coin->asset)->first();
                if(empty($sysAccount)){
                    //let us generate the wallets. We will split them into functions for ease
                    switch ($coin->asset) {
                        case 'USDT_TRON':
                            $this->generateUsdtWallet($coin);
                            break;
                        case 'BUSD_BSC':
                                $this->generateBusdWallet($coin);
                                break;
                    }
                }
            }
        }
    }
    public function generateUsdtWallet($coin)
    {
        $sysAccount = SystemAccount::where('asset','Tron')->first();
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
                        'availableBalance' => 0,
                        'priKey'=>'',
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>2,
                        'derivationKey'=>$generateAddress['derivationKey'],
                        'customId'=>$this->createUniqueRef('system_accounts','customId'),
                    ];
                    SystemAccount::create($dataAddress);
                }else{
                    Log::alert($generateAddress->json());
                }
            }else{
                Log::alert($account->json());
            }
        }
    }
    public function generateBusdWallet($coin)
    {
        $sysAccount = SystemAccount::where('asset','BSC')->first();
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
                        'availableBalance' => 0,
                        'priKey'=>'',
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>2,
                        'derivationKey'=>$generateAddress['derivationKey'],
                        'customId'=>$this->createUniqueRef('system_accounts','customId'),
                    ];
                    SystemAccount::create($dataAddress);
                }else{
                    Log::alert($generateAddress->json());
                }
            }else{
                Log::alert($account->json());
            }
        }
    }
}
