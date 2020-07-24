<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->unsigned();
            $table->integer('transaction_id');
            $table->string('payment_type');
            $table->string('gross_amount');
            $table->string('transaction_time');
            $table->string('transaction_status');
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
        Schema::dropIfExists('table_payments');
    }
}
