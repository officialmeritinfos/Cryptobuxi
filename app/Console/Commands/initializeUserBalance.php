<?php

namespace App\Console\Commands;

use App\Models\Coin;
use App\Models\SystemAccount;
use App\Models\User;
use App\Models\UserTradingBalance;
use Illuminate\Console\Command;

class initializeUserBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initialize:userTradingBalance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializes User Trading Balance and set them all to zero';

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
        //get the coin
        $coins = Coin::where('status',1)->get();
        if ($coins->count() >0) {
            foreach ($coins as $coin) {
                //check if the coin has been added to the system
                $sysAccount = SystemAccount::where('asset',$coin->asset)->first();
                if(!empty($sysAccount)){
                     //get a user
                    $users = User::where('status',1)->get();
                    if ($users->count()>0) {
                         foreach ($users as $user) {
                            $walletExists = UserTradingBalance::where('user',$user->id)->where('asset',$coin->asset)->first();
                            if (empty($walletExists)) {
                                $dataBalance = [
                                    'asset'=>$coin->asset,
                                    'user'=>$user->id,
                                    'icon'=>$coin->icon,
                                    'availableBalance'=>0,
                                    'pendingBalance'=>0
                                ];
                                UserTradingBalance::create($dataBalance);
                            }
                        }
                    }

                }
            }
        }
    }
}
