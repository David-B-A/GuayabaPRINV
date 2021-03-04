<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->biginteger('product')->unsigned();
            $table->biginteger('sale')->unsigned()->nullable();
            $table->biginteger('purchase')->unsigned()->nullable();
            $table->biginteger('process')->unsigned()->nullable();
            $table->double('ammount',15,2);
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product')->references('id')->on('products');
            $table->foreign('sale')->references('id')->on('sales');
            $table->foreign('purchase')->references('id')->on('purchases');
            $table->foreign('process')->references('id')->on('processes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
}
