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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->string('currency');
            $table->string('merchantOrderNumber', 50);
            $table->string('identifyNumber');
            $table->string('bank');
            $table->string('order_number',50);
            $table->text('order');
            $table->text('payer');
            $table->text('send_json');
            $table->text('result_json')->nullable();
            $table->string('return_url')->nullable();
            $table->string('notify_url')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
