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
            $table->biginteger('product')->unsigned()->default(0);
            $table->biginteger('sale')->unsigned()->default(0);
            $table->biginteger('purchase')->unsigned()->default(0);
            $table->biginteger('process')->unsigned()->default(0);
            $table->double('ammount',15,2);
            $table->json('metadata');
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
