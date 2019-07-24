<?php

use Illuminate\Database\Seeder;

class StylesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $styles = [
            'daily',
            'weekly',
            'monthly'
        ];
        $compound = [
            1, 7, 30
        ];

//        $daily = new \App\Style();
//        $daily->name = 'Daily';
//        $daily->compound = 1;
//        $daily->save();

        $weekly = new \App\Style();
        $weekly->name = 'Weekly';
        $weekly->compound = 7;
        $weekly->save();

//        $monthly = new \App\Style();
//        $monthly->name = 'Monthly';
//        $monthly->compound = 30;
//        $monthly->save();
    }
}
