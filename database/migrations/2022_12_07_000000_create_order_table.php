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
            $table->varchar('currency');
            $table->varchar('merchantOrderNumber', 50);
            $table->string('identifyNumber');
            $table->varchar('bank');
            $table->varchar('order_number',50);
            $table->text('order');
            $table->text('payer');
            $table->text('send_json');
            $table->text('result_json')->nullable();
            $table->varchar('return_url')->nullable();
            $table->varchar('notify_url')->nullable();
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
