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

class createUserWallet extends Command
{
    use GenerateUnique;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:userWallet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create User wallet for supported coins';

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
        //we need to depend on the system trading account to know which currencies are supported
        $coins = Coin::where('status',1)->where('mainNetwork',1)->get();
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
                                    case 'BTC':
                                        $this->generateBtcWallet($coin,$user);
                                        break;
                                    case 'BCH':
                                        $this->generateBchWallet($coin,$user);
                                        break;
                                    case 'ETH':
                                        $this->generateEthWallet($coin,$user);
                                        break;
                                    case 'LTC':
                                        $this->generateLtcWallet($coin,$user);
                                        break;
                                    case 'ADA':
                                        $this->generateAdaWallet($coin,$user);
                                        break;
                                    case 'MATIC':
                                        $this->generateMaticWallet($coin,$user);
                                        break;
                                    case 'TRON':
                                        $this->generateTronWallet($coin,$user);
                                        break;
                                    case 'BSC':
                                        $this->generateBscWallet($coin,$user);
                                        break;
                                    case 'DOGE':
                                        $this->generateDogeWallet($coin,$user);
                                        break;
                                    case 'SOL':
                                        $this->generateSolWallet($coin,$user);
                                        break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    //Generate BTC wallet
    public function generateBtcWallet($coin,$user)
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    //Generate BCH wallet
    public function generateBchWallet($coin,$user)
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateLtcWallet($coin,$user)
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateEthWallet($coin,$user)
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateMaticWallet($coin,$user)
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateTronWallet($coin,$user)
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateAdaWallet($coin,$user)
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateBscWallet($coin,$user)
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateDogeWallet($coin,$user)
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
                        'priKey'=>$new_prikey,
                        'mnemonic'=>$new_mnemonic,
                        'pubKey'=>$xpub,
                        'hasPriKey'=>$hasPriKey,
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
        }else{
            Log::alert($generate->json());
        }
    }
    public function generateSolWallet($coin,$user)
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
                        'priKey'=>$new_priKey,
                        'mnemonic'=>$new_priKey,
                        'pubKey'=>'',
                        'hasPriKey'=>$hasPriKey,
                        'derivationKey'=>0,
                        'customId'=>$this->createUniqueRef('system_accounts','customId'),
                        'walletType'=>1,
                        'user'=>$user->id
                    ];
                    ModelsWallet::create($dataAddress);
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
