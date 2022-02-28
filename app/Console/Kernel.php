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
use App\Console\Commands\processLoanReturns;
use App\Console\Commands\sendLoanReminder;

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
        $schedule->command('create:systemAccount')->everyFourMinutes()->withoutOverlapping();
        $schedule->command('create:systemTokenAccount')->everyFourMinutes()->withoutOverlapping();
        $schedule->command('create:userWallet')->everyMinute()->withoutOverlapping();
        $schedule->command('create:userTokenWallet')->everyMinute()->withoutOverlapping();
        $schedule->command('initialize:systemSubscription')->everyMinute()->withoutOverlapping();
        $schedule->command('initialize:userWalletSubscription')->everyMinute()->withoutOverlapping();
        $schedule->command('initialize:userTradingBalance')->everyFourMinutes()->withoutOverlapping();
        $schedule->command('initialize:userLoanBalance')->everyFourMinutes()->withoutOverlapping();
        $schedule->command('cache:cryptoRates')->everyMinute()->withoutOverlapping();
        $schedule->command('process:LoanReturns')->everyMinute()->withoutOverlapping();
        $schedule->command('send:LoanReminder')->twiceDailyAt('7','19')->withoutOverlapping();

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
