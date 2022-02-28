<?php

namespace App\Console\Commands;

use App\Models\FiatLoan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class processLoanReturns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:LoanReturns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command processes the loans and calculates how much that is due for a particular day';

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
        $loans = FiatLoan::where('isPaid',2)->where('status',2)->get();
        if ($loans->count()>0) {
            foreach ($loans as $loan) {
                $moment =time();
                if ($moment > $loan->timeToAdd) {
                    $currentRepeat = $loan->currentRepeat;
                    $currentBill = $loan->currentBill;
                    $newRepeat = $currentRepeat+1;
                    $newCurrentBill= $currentBill+$loan->dailyAddition;

                    $dataLoan =[
                        'currentBill'=>$newCurrentBill,
                        'currentRepeat'=>$newRepeat,
                        'timeToAdd'=>strtotime('tomorrow',time())
                    ];

                    //update the loan
                    FiatLoan::where('id',$loan->id)->update($dataLoan);
                }
            }
        }else{
            Log::alert($loans->count());
        }
    }
}
