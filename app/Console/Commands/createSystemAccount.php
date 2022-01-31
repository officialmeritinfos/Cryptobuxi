<?php

namespace App\Console\Commands;

use App\Custom\GenerateUnique;
use App\Custom\Wallet;
use App\Models\Coin;
use App\Models\SystemAccount;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class createSystemAccount extends Command
{
    use GenerateUnique;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:systemAccount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates and initializes System Account for Cryptocurrencies accepted. This serves as the base
    account for all trading to avoid double spending';

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
        $coins = Coin::where('status',1)->where('mainNetwork',1)->get();
        if ($coins->count() >0) {
            foreach ($coins as $coin) {
                //check if the coin has been added to the system
                $sysAccount = SystemAccount::where('asset',$coin->asset)->first();
                if(empty($sysAccount)){
                    //let us generate the wallets. We will split them into functions for ease
                    switch ($coin->asset) {
                        case 'BTC':
                            $this->generateBtcWallet($coin);
                            break;
                        case 'BCH':
                            $this->generateBchWallet($coin);
                            break;
                        case 'ETH':
                            $this->generateEthWallet($coin);
                            break;
                        case 'LTC':
                            $this->generateLtcWallet($coin);
                            break;
                        case 'ADA':
                            $this->generateAdaWallet($coin);
                            break;
                        case 'MATIC':
                            $this->generateMaticWallet($coin);
                            break;
                        case 'TRON':
                            $this->generateTronWallet($coin);
                            break;
                        case 'BSC':
                            $this->generateBscWallet($coin);
                            break;
                        case 'DOGE':
                            $this->generateDogeWallet($coin);
                            break;
                        case 'SOL':
                                $this->generateSolWallet($coin);
                                break;
                    }
                }
            }
        }
    }
    //Generate BTC wallet
    public function generateBtcWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //xpub and mnemonic
            $xpub = $walletResult['xpub'];
            $mnemonic = $walletResult['mnemonic'];
            $new_mnemonic = Crypt::encryptString($mnemonic);
            $accountKey = $xpub;
            //generate private key
            $dataPrivateKey = [
                'index' => 1,
                'mnemonic' => $mnemonic
            ];
            $generatePrivateKey = $this->wallet->generatePriv($coin->urlCode, $dataPrivateKey);
            if ($generatePrivateKey->ok()) {
                $privateKeyResult = $generatePrivateKey->json();
                $priKey = $privateKeyResult['key'];
                $new_prikey = Crypt::encryptString($priKey);
                $hasPriKey = 1;
            }else {
                $hasPriKey = 2;
                $new_prikey='';
                Log::alert($generate->json());
            }
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    //Generate BCH wallet
    public function generateBchWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //xpub and mnemonic
            $xpub = $walletResult['xpub'];
            $mnemonic = $walletResult['mnemonic'];
            $new_mnemonic = Crypt::encryptString($mnemonic);
            $accountKey = $xpub;
            //generate private key
            $dataPrivateKey = [
                'index' => 1,
                'mnemonic' => $mnemonic
            ];
            $generatePrivateKey = $this->wallet->generatePriv($coin->urlCode, $dataPrivateKey);
            if ($generatePrivateKey->ok()) {
                $privateKeyResult = $generatePrivateKey->json();
                $priKey = $privateKeyResult['key'];
                $new_prikey = Crypt::encryptString($priKey);
                $hasPriKey = 1;
            }else {
                $hasPriKey = 2;
                $new_prikey='';
                Log::alert($generate->json());
            }
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
                        'address' => str_replace('bitcoincash:','',$generateAddress['address']),
                        'hasMemo' => $coin->hasMemo,
                        'memo'=>'',
                        'availableBalance' => 0,
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateLtcWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //xpub and mnemonic
            $xpub = $walletResult['xpub'];
            $mnemonic = $walletResult['mnemonic'];
            $new_mnemonic = Crypt::encryptString($mnemonic);
            $accountKey = $xpub;
            //generate private key
            $dataPrivateKey = [
                'index' => 1,
                'mnemonic' => $mnemonic
            ];
            $generatePrivateKey = $this->wallet->generatePriv($coin->urlCode, $dataPrivateKey);
            if ($generatePrivateKey->ok()) {
                $privateKeyResult = $generatePrivateKey->json();
                $priKey = $privateKeyResult['key'];
                $new_prikey = Crypt::encryptString($priKey);
                $hasPriKey = 1;
            }else {
                $hasPriKey = 2;
                $new_prikey='';
                Log::alert($generate->json());
            }
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateEthWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //xpub and mnemonic
            $xpub = $walletResult['xpub'];
            $mnemonic = $walletResult['mnemonic'];
            $new_mnemonic = Crypt::encryptString($mnemonic);
            $accountKey = $xpub;
            //generate private key
            $dataPrivateKey = [
                'index' => 1,
                'mnemonic' => $mnemonic
            ];
            $generatePrivateKey = $this->wallet->generatePriv($coin->urlCode, $dataPrivateKey);
            if ($generatePrivateKey->ok()) {
                $privateKeyResult = $generatePrivateKey->json();
                $priKey = $privateKeyResult['key'];
                $new_prikey = Crypt::encryptString($priKey);
                $hasPriKey = 1;
            }else {
                $hasPriKey = 2;
                $new_prikey='';
                Log::alert($generate->json());
            }
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateMaticWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //xpub and mnemonic
            $xpub = $walletResult['xpub'];
            $mnemonic = $walletResult['mnemonic'];
            $new_mnemonic = Crypt::encryptString($mnemonic);
            $accountKey = $xpub;
            //generate private key
            $dataPrivateKey = [
                'index' => 1,
                'mnemonic' => $mnemonic
            ];
            $generatePrivateKey = $this->wallet->generatePriv($coin->urlCode, $dataPrivateKey);
            if ($generatePrivateKey->ok()) {
                $privateKeyResult = $generatePrivateKey->json();
                $priKey = $privateKeyResult['key'];
                $new_prikey = Crypt::encryptString($priKey);
                $hasPriKey = 1;
            }else {
                $hasPriKey = 2;
                $new_prikey='';
                Log::alert($generate->json());
            }
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateTronWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //xpub and mnemonic
            $xpub = $walletResult['xpub'];
            $mnemonic = $walletResult['mnemonic'];
            $new_mnemonic = Crypt::encryptString($mnemonic);
            $accountKey = $xpub;
            //generate private key
            $dataPrivateKey = [
                'index' => 1,
                'mnemonic' => $mnemonic
            ];
            $generatePrivateKey = $this->wallet->generatePriv($coin->urlCode, $dataPrivateKey);
            if ($generatePrivateKey->ok()) {
                $privateKeyResult = $generatePrivateKey->json();
                $priKey = $privateKeyResult['key'];
                $new_prikey = Crypt::encryptString($priKey);
                $hasPriKey = 1;
            }else {
                $hasPriKey = 2;
                $new_prikey='';
                Log::alert($generate->json());
            }
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateAdaWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //xpub and mnemonic
            $xpub = $walletResult['xpub'];
            $mnemonic = $walletResult['mnemonic'];
            $new_mnemonic = Crypt::encryptString($mnemonic);
            $accountKey = $xpub;
            //generate private key
            $dataPrivateKey = [
                'index' => 1,
                'mnemonic' => $mnemonic
            ];
            $generatePrivateKey = $this->wallet->generatePriv($coin->urlCode, $dataPrivateKey);
            if ($generatePrivateKey->ok()) {
                $privateKeyResult = $generatePrivateKey->json();
                $priKey = $privateKeyResult['key'];
                $new_prikey = Crypt::encryptString($priKey);
                $hasPriKey = 1;
            }else {
                $hasPriKey = 2;
                $new_prikey='';
                Log::alert($generatePrivateKey->json());
            }
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateBscWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //xpub and mnemonic
            $xpub = $walletResult['xpub'];
            $mnemonic = $walletResult['mnemonic'];
            $new_mnemonic = Crypt::encryptString($mnemonic);
            $accountKey = $xpub;
            //generate private key
            $dataPrivateKey = [
                'index' => 1,
                'mnemonic' => $mnemonic
            ];
            $generatePrivateKey = $this->wallet->generatePriv($coin->urlCode, $dataPrivateKey);
            if ($generatePrivateKey->ok()) {
                $privateKeyResult = $generatePrivateKey->json();
                $priKey = $privateKeyResult['key'];
                $new_prikey = Crypt::encryptString($priKey);
                $hasPriKey = 1;
            }else {
                $hasPriKey = 2;
                $new_prikey='';
                Log::alert($generatePrivateKey->json());
            }
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateDogeWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //xpub and mnemonic
            $xpub = $walletResult['xpub'];
            $mnemonic = $walletResult['mnemonic'];
            $new_mnemonic = Crypt::encryptString($mnemonic);
            $accountKey = $xpub;
            //generate private key
            $dataPrivateKey = [
                'index' => 1,
                'mnemonic' => $mnemonic
            ];
            $generatePrivateKey = $this->wallet->generatePriv($coin->urlCode, $dataPrivateKey);
            if ($generatePrivateKey->ok()) {
                $privateKeyResult = $generatePrivateKey->json();
                $priKey = $privateKeyResult['key'];
                $new_prikey = Crypt::encryptString($priKey);
                $hasPriKey = 1;
            }else {
                $hasPriKey = 2;
                $new_prikey='';
                Log::alert($generatePrivateKey->json());
            }
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateSolWallet($coin)
    {
        $generate = $this->wallet->generateWallet($coin->urlCode);
        if ($generate->ok()) {
            $walletResult = $generate->json();
            //address and privatekey
            $address = $walletResult['address'];
            $privKey = $walletResult['privateKey'];
            $new_priKey = Crypt::encryptString($privKey);
            $accountKey = $address;

            $hasPriKey = 1;
            //generate an account for it
            $dataAccount = [
                'currency' => $coin->asset,
                'accountingCurrency' => 'USD'
            ];
            $account = $this->wallet->createAccount($dataAccount);
            if ($account->ok()) {
                $accountId = $account['id'];
                //assign address to the account ID
                $assignAddress = $this->wallet->assignAddressToAccount($accountId,$accountKey);
                if ($assignAddress->ok()) {
                    $dataAddress = [
                        'asset' => $coin->asset,
                        'accountId' => $accountId,
                        'address' => $assignAddress['address'],
                        'hasMemo' => $coin->hasMemo,
                        'memo'=>'',
                        'availableBalance' => 0,
                        'priKey'=>$new_priKey,
                        'mnemonic'=>$new_priKey,
                        'pubKey'=>'',
                        'hasPriKey'=>$hasPriKey,
                        'derivationKey'=>0,
                        'customId'=>$this->createUniqueRef('system_accounts','customId'),
                    ];
                    SystemAccount::create($dataAddress);
                }else{
                    Log::alert($assignAddress->json());
                }
            }else{
                Log::alert($account->json());
            }
        }else{
            Log::alert($generate->json());
        }
    }
}
