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
        Schema::create('stripeorders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->integer('customer_id');
            // $table->string('transaction_id');
            $table->string('status')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('address');
            $table->integer('sub_total');
            $table->integer('sales_discount')->nullable();
            $table->integer('coupon_discount')->nullable();
            $table->integer('delivery_charge')->nullable();
            $table->integer('total');
            $table->string('currency')->nullable();
            $table->string('company')->nullable();
            $table->integer('country_id');
            $table->integer('city_id');
            $table->string('zip')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('stripeorders');
    }
};
