<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\createSystemAccount;
use App\Console\Commands\createSystemTokenAccount;
use App\Console\Commands\createUserWallet;
use App\Console\Commands\createUserTokenAccount;
use App\Console\Commands\initializeSystemWalletSubscription;
use App\Console\Commands\initializeUserWalletSubscription;
use App\Console\Commands\initializeUserBalance;
use App\Console\Commands\initializeUserLoanBalance;
use App\Console\Commands\CacheRates;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('create:systemAccount')->everyMinute();
        $schedule->command('create:systemTokenAccount')->everyMinute();
        $schedule->command('create:userWallet')->everyMinute();
        $schedule->command('create:userTokenWallet')->everyMinute();
        $schedule->command('initialize:systemSubscription')->everyMinute();
        $schedule->command('initialize:userWalletSubscription')->everyMinute();
        $schedule->command('initialize:userTradingBalance')->everyMinute();
        $schedule->command('initialize:userLoanBalance')->everyMinute();
        $schedule->command('cache:cryptoRates')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
