<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('transaction_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gateway_id');
            $table->string('currency1');
            $table->string('currency2');
            $table->decimal('charge');
            $table->boolean('status')->default(0);
            $table->boolean('payment')->default(0);
            $table->decimal('amount');
            $table->decimal('amount2', '5', '4');
            $table->decimal('net_amount');
            $table->string('details');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gateway_id')->references('id')->on('gateways')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
}
