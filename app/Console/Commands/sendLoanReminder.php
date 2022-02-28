<?php

namespace App\Console\Commands;

use App\Models\FiatLoan;
use App\Models\User;
use App\Notifications\AccountNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class sendLoanReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:LoanReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends a reminder to the debtors to pay up their loan.';

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
       //get all loans not paid for
       $loans = FiatLoan::where('isPaid',2)->where('status',2)->get();
       if ($loans->count()>0) {
            //here we start sending mails
            //Lets create a time interval using the carbon library
            //we will excuse the day the loan was borrowed
            foreach ($loans as $loan) {
                $dateApproved = $loan->dateApproved;
                $paybackDate = $loan->payBackDate;
                $dateNow = time();
                $date= Carbon::createFromTimestamp($paybackDate);
                $dateNow= Carbon::createFromTimestamp($dateNow);
                //check the time differences
                $dateDiff = $dateNow->diffInDays($date);
                switch ($dateDiff) {
                    case '27':
                        $this->sendMonthMail($loan);
                        break;
                    case '14':
                        $this->sendTwoWeekMail($loan);
                        break;
                    case '7':
                        $this->sendWeekMail($loan);
                        break;
                    case '3':
                        $this->sendThreeDaysMail($loan);
                        break;
                    case '2':
                        $this->sendTwoDaysMail($loan);
                         break;
                    case '1':
                        $this->sendOneDayMail($loan);
                         break;
                    case '0':
                        $this->sendDeadlineMail($loan);
                        break;
                }
            }
       }
    }
    public function sendMonthMail($loan)
    {
        $user = User::where('id',$loan->user)->first();
        //send mail to User
        $messageToSend = "Your Loan of <b>".$loan->fiat.number_format($loan->fiatAmount,2)."</b> will be due for repayment in
        28 Days time. Endeavour to pay up before <b>".Carbon::createFromTimestamp($loan->payBackDate)->format('M d Y H:i:s a')."</b>
        to avoid losing your collateral.<br>Loan Reference: <b>".$loan->reference."</b>.";
        $url = url('account/login');
        $user->notify(new AccountNotification($user->name,$messageToSend,$url,'Loan Repayment Notification: 28 Days Reminder'));
    }
    public function sendTwoWeekMail($loan)
    {
        $user = User::where('id',$loan->user)->first();
        //send mail to User
        $messageToSend = "Your Loan of <b>".$loan->fiat.number_format($loan->fiatAmount,2)."</b> will be due for repayment in
        14 Days time. Endeavour to pay up before <b>".Carbon::createFromTimestamp($loan->payBackDate)->format('M d Y H:i:s a')."</b>
        to avoid losing your collateral.<br> Loan Reference: <b>".$loan->reference."</b>.";
        $url = url('account/login');
        $user->notify(new AccountNotification($user->name,$messageToSend,$url,'Loan Repayment Notification: 14 Days Reminder'));
    }
    public function sendWeekMail($loan)
    {
        $user = User::where('id',$loan->user)->first();
        //send mail to User
        $messageToSend = "Your Loan of <b>".$loan->fiat.number_format($loan->fiatAmount,2)."</b> will be due for repayment in
        7 Days time. Endeavour to pay up before <b>".Carbon::createFromTimestamp($loan->payBackDate)->format('M d Y H:i:s a')."</b>
        to avoid losing your collateral.<br> Loan Reference: <b>".$loan->reference."</b>.";
        $url = url('account/login');
        $user->notify(new AccountNotification($user->name,$messageToSend,$url,'Loan Repayment Notification: 7 Days Reminder'));
    }
    public function sendThreeDaysMail($loan)
    {
        $user = User::where('id',$loan->user)->first();
        //send mail to User
        $messageToSend = "Your Loan of <b>".$loan->fiat.number_format($loan->fiatAmount,2)."</b> will be due for repayment in
        3 Days time. Endeavour to pay up before <b>".Carbon::createFromTimestamp($loan->payBackDate)->format('M d Y H:i:s a')."</b>
        to avoid losing your collateral.<br>Loan Reference: <b>".$loan->reference."</b>.";
        $url = url('account/login');
        $user->notify(new AccountNotification($user->name,$messageToSend,$url,'Loan Repayment Notification: 3 Days Reminder'));
    }
    public function sendTwoDaysMail($loan)
    {
        $user = User::where('id',$loan->user)->first();
        //send mail to User
        $messageToSend = "Your Loan of <b>".$loan->fiat.number_format($loan->fiatAmount,2)."</b> will be due for repayment in
        2 Days time. Endeavour to pay up before <b>".Carbon::createFromTimestamp($loan->payBackDate)->format('M d Y H:i:s a')."</b>
        to avoid losing your collateral.<br>Loan Reference: <b>".$loan->reference."</b>.";
        $url = url('account/login');
        $user->notify(new AccountNotification($user->name,$messageToSend,$url,'Loan Repayment Notification: 2 Days Reminder'));
    }
    public function sendOneDayMail($loan)
    {
        $user = User::where('id',$loan->user)->first();
        //send mail to User
        $messageToSend = "Your Loan of <b>".$loan->fiat.number_format($loan->fiatAmount,2)."</b> will be due for repayment tomorrow.
        Endeavour to pay up before <b>".Carbon::createFromTimestamp($loan->payBackDate)->format('M d Y H:i:s a')."</b>
        to avoid losing your collateral.<br>Loan Reference: <b>".$loan->reference."</b>.";
        $url = url('account/login');
        $user->notify(new AccountNotification($user->name,$messageToSend,$url,'Loan Repayment Notification: A Day Reminder'));
    }
    public function sendDeadlineMail($loan)
    {
        $user = User::where('id',$loan->user)->first();
        //send mail to User
        $messageToSend = "Your Loan of <b>".$loan->fiat.number_format($loan->fiatAmount,2)."</b> will be due for repayment in few hours.
        Endeavour to pay up before <b>".Carbon::createFromTimestamp($loan->payBackDate)->format('M d Y H:i:s a')."</b>
        to avoid losing your collateral.<br> Loan Reference: <b>".$loan->reference."</b>.";
        $url = url('account/login');
        $user->notify(new AccountNotification($user->name,$messageToSend,$url,'Loan Repayment Notification: A Day Reminder'));
    }
}
