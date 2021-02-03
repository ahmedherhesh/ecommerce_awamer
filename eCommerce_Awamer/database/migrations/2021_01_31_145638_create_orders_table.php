<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->bigInteger('seller_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('users');
            $table->bigInteger('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->bigInteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('count')->default(1);
            $table->string('status')->default('new');
            $table->string('address')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('received_date')->nullable();

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
}
