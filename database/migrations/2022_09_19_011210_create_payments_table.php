<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_id');
            $table->string('merchantTid');
            $table->string('channel')->nullable();
            $table->string('channel_ext')->nullable();
            $table->string('merchant_order_id');
            $table->string('merchant_user_id');
            $table->string('currency')->nullable()->default("MOP");
            $table->integer('amount');
            $table->integer('timeout');
            $table->string('notify_url');
            $table->string('return_url');
            $table->string('sign');
            $table->string('status')->nullable();
            $table->string('result')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
