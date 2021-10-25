<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHighLevelResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('high_level_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course1_name')->nullable(); 
            $table->string('course1_result')->nullable(); 
            $table->string('course2_name')->nullable(); 
            $table->string('course2_result')->nullable(); 
            $table->string('course3_name')->nullable(); 
            $table->string('course3_result')->nullable(); 
            $table->string('course4_name')->nullable(); 
            $table->string('course4_result')->nullable(); 
            $table->string('course5_name')->nullable(); 
            $table->string('course5_result')->nullable();
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
        Schema::dropIfExists('high_level_results');
    }
}
