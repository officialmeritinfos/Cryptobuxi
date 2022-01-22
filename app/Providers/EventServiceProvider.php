<?php

namespace App\Providers;

use App\Events\AccountActivity;
use App\Events\AccountRecovery;
use App\Events\AccountRecoveryMail;
use App\Events\LoginMail;
use App\Events\SendGeneralMail;
use App\Events\SendNotification;
use App\Events\SendWelcomeMail;
use App\Events\TwoFactor;
use App\Events\UserCreated;
use App\Listeners\AccountNotification;
use App\Listeners\createBalance;
use App\Listeners\EmailVerification;
use App\Listeners\SendAccountLoginMail;
use App\Listeners\SendAccountRecoveryMail;
use App\Listeners\SendMail;
use App\Listeners\SendNotificationMail;
use App\Listeners\SendRecoveryMail;
use App\Listeners\SendTwoFactorMail;
use App\Listeners\UserActivity;
use App\Listeners\UserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserCreated::class => [
            createBalance::class,
            EmailVerification::class,
            UserNotification::class,
        ],
        SendWelcomeMail::class => [
            SendMail::class,
        ],
        TwoFactor::class => [
            SendTwoFactorMail::class,
        ],
        AccountRecovery::class =>[
            SendRecoveryMail::class
        ],
        AccountRecoveryMail::class =>[
            SendAccountRecoveryMail::class
        ],
        LoginMail::class => [
            SendAccountLoginMail::class,
        ],
        SendNotification::class =>[
            AccountNotification::class,
        ],
        AccountActivity::class =>[
            UserActivity::class,
        ],
        SendGeneralMail::class =>[
            SendNotificationMail::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
