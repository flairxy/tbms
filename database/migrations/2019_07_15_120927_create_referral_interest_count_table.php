<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralInterestCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_interest_count', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('referral_id');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('amount');
            $table->unsignedBigInteger('count')->default(0);
            $table->timestamps();

            $table->foreign('referral_id')->references('id')->on('referrals')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('referrals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_interest_count');
    }
}
