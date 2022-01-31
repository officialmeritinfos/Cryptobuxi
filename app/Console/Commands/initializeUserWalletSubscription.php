<?php

namespace App\Console\Commands;

use App\Custom\Wallet;
use App\Models\Wallet as ModelsWallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class initializeUserWalletSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initialize:userWalletSubscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Subscription for all the coins supported by the system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $systemAccounts = ModelsWallet::where('hasSub','!=',1)->get();
        if($systemAccounts->count() > 0){
            foreach ($systemAccounts as $systemAccount) {
                $incomingLink = 'https://webhook.site/0395057d-2546-44d2-8683-6ed0e6435d47';
                //url('transactions/user/'.$systemAccount->customId.'/account/'.$systemAccount->accountId);;
                $dataIncoming=[
                    'type'              => 'ACCOUNT_INCOMING_BLOCKCHAIN_TRANSACTION',
                    'attr'              =>[
                        'id'            =>$systemAccount->accountId,
                        'url'           =>$incomingLink
                    ]
                ];
                $wallet=new Wallet();
                $incomingData=$wallet->createSubscription($dataIncoming);
                if ($incomingData->ok()){
                    $incomings=$incomingData->json();
                    $dataSub=[
                        'subId'=>$incomings['id'],
                        'hasSub'=>1
                    ];
                    //update the data
                    ModelsWallet::where('id',$systemAccount->id)->update($dataSub);
                }else{
                    Log::alert($incomingData->json());
                }
            }
        }
    }
}