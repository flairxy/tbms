<?php

namespace App\Console\Commands;

use App\Account;
use App\Plan;
use App\Setting;
use App\Style;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Investment;

class UserInvestment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:investment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        //get all investments
        $investments = Investment::whereStatus(0)->pluck('user_id');
        $users = User::whereIn('id', $investments)->get();
        foreach ($users as $user) {
            $user_investments = Investment::whereUserId($user->id)->whereStatus(0)->get();
//            get the start and end dateDeposit
            foreach ($user_investments as $investment) {
                $start = new Carbon($investment->last_profit);
                $end = new Carbon($investment->end);
                $plan = Plan::findOrFail($investment->plan_id);
                $duration = $plan->duration;
                $style = Style::findOrFail($plan->style_id);
//            profit based on the plan
                $profit = ($plan->percentage / 100) * $investment->amount;
                $exchange_rate = Setting::whereName('BKY_EXCHANGE_RATE')->first();
                $true_rate = $exchange_rate->value;

//            Profit should be credited on the last day of the plan style->compound
                switch ($style->compound) {
                    case 1:
//                    Add the profit to the user account daily
                        $now = Carbon::now();
                        for ($i = 1; $i <= $duration; $i++) {
                            if ($now >= $start) {
                                $account = Account::whereUserId($user->id)->first();
                                $account->bky += $profit;
                                $account->bky2 += $profit / $true_rate;
                                $account->save();
                                $investment->last_profit = $start->addDay();
                                $investment->save();
                            }

                        }
                        break;
                    case 7:
                        $now = Carbon::now();
                        for ($i = 1; $i <= $duration; $i++) {
                            $account = Account::whereUserId($user->id)->first();
                            if ($now >= $start && $start <= $end) {
                                $account->bky += $profit;
                                $account->bky2 += $profit / $true_rate;
                                $account->count++;
                                $account->save();

                                $investment->last_profit = $start->addWeek();
                                $investment->save();
                            }
                        }
                        break;
                    case 30:
                        $now = Carbon::now();
                        for ($i = 1; $i <= $duration; $i++) {
                            if ($now >= $start) {
                                $account = Account::whereUserId($user->id)->first();
                                $account->bky += $profit;
                                $account->bky2 += $profit / $true_rate;
                                $account->save();
                                $investment->last_profit = $start->addMonth();
                                $investment->save();
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }

    }
}
