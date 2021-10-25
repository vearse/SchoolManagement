<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matriculation_no')->nullable(); 
            $table->string('register_no')->nullable(); 
            $table->string('country')->nullable(); 
            $table->string('address')->nullable(); 
            $table->string('religion')->nullable(); 
            $table->string('photo')->nullable(); 
            $table->datetime('screaned_at')->nullable(); 
            $table->integer('degree_id')->nullable(); 
            $table->integer('fee_id')->nullable(); 
            $table->integer('acceptance_id')->nullable(); 
            $table->integer('department_id')->nullable();
            $table->integer('screaning_result_id')->nullable();
            $table->integer('highlevel_result_id')->nullable();
            $table->string('extra')->nullable();
            $table->string('extra1')->nullable();
            $table->string('extra2')->nullable();
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
        Schema::dropIfExists('admissions');
    }
}
