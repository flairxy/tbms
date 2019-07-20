<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_interests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('child_id');
            $table->decimal('amount');
            $table->decimal('interest');
            $table->timestamps();

            $table->foreign('child_id')->references('user_id')->on('referrals')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_interests');
    }
}
