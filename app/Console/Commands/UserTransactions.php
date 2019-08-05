<?php

namespace App\Console\Commands;

use App\Driver;
use App\Deposit;
use App\Referral;
use App\ReferralCount;
use App\Setting;
use App\User;
use Illuminate\Console\Command;

class UserTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:transact';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Controls user profits and referrals';

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
        //check all deposits that status has been confirmed and get the user_ids
        $deposits = Deposit::whereStatus(1)->pluck('user_id');
        if ($deposits) {
            $referral_rate = Setting::whereName('REFERRAL_BONUS')->value('value');
            $rate = (int)$referral_rate / 100;
            $exchange_rate = Setting::whereName('BKY_EXCHANGE_RATE')->first();
            $true_rate = $exchange_rate->value;
//            get user whose id is found in the deposits
            $users = User::whereIn('id', $deposits)->get();
            foreach ($users as $user) {
                //was this user referred
                $referred = Referral::whereUserId($user->id)->first();
                if ($referred) {
//                    check is the referrer got a referral bonus from this user
                    $count = ReferralCount::whereReferralId($referred->id)->first();
                    if (!$count) {
                        $get_deposit = Deposit::whereUserId($user->id)->first();
                        $referral_interest = new ReferralCount();
                        $referral_interest->user_id = $user->id;
                        $referral_interest->referral_id = $referred->id;
                        $referral_interest->amount = $get_deposit->net_amount * $rate;
                        $referral_interest->count++;
                        $referral_interest->save();

                        $bonus = $get_deposit->net_amount * $rate;
                        $user_parent_account = Driver::whereUserId($referred->parent_id)->first();
                        $user_parent_account->bky += $bonus;
                        $user_parent_account->bky2 += $bonus / $true_rate;
                        $user_parent_account->save();
                        return response('Referral Bonus deposited');
                    }
                }
            }
        }
    }
}
