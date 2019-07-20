<?php

namespace App\Console\Commands;

use App\Account;
use App\Setting;
use Illuminate\Console\Command;

class CoinRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinRate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates users accounts based on the current coin rate';

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
        $exchange_rate = Setting::whereName('BKY_EXCHANGE_RATE')->first();
        $true_rate = $exchange_rate->value;

        $accounts = Account::all();
        foreach ($accounts as $account) {
            $account->bky = $true_rate * $account->bky2;
            $account->save();
        }
    }
}
