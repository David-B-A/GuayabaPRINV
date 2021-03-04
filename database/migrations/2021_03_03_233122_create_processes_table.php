<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->biginteger('user')->unsigned()->default(0);
            $table->biginteger('responsible')->unsigned()->default(0);
            $table->biginteger('process_template')->unsigned()->default(0);
            $table->string('comments')->nullable();
            $table->string('status');
            $table->json('inputs');
            $table->json('outputs');
            $table->json('metadata');
            $table->date('scheduled_date');
            $table->date('executed_date');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user')->references('id')->on('users');
            $table->foreign('responsible')->references('id')->on('users');
            $table->foreign('process_template')->references('id')->on('process_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('processes');
    }
}
