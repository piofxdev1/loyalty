<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('agency_id')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('customer_id');
            $table->bigInteger('phone');
            $table->bigInteger('credits')->default(0);
            $table->bigInteger('redeem')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reward');
    }
}
