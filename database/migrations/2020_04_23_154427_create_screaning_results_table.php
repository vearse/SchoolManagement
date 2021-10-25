<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreaningResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screaning_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('test1_name')->nullable(); 
            $table->string('test1_result')->nullable(); 
            $table->string('test2_name')->nullable(); 
            $table->string('test2_result')->nullable(); 
            $table->string('test3_name')->nullable(); 
            $table->string('test3_result')->nullable(); 
            $table->string('test4_name')->nullable(); 
            $table->string('test4_result')->nullable(); 
            $table->string('test5_name')->nullable(); 
            $table->string('test5_result')->nullable(); 
            $table->string('file1')->nullable(); 
            $table->string('file2')->nullable(); 
            $table->string('total_result')->nullable(); 
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
        Schema::dropIfExists('screaning_results');
    }
}
