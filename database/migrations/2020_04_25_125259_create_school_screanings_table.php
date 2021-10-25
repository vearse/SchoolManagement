<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolScreaningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_screanings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); 
            $table->char('shortname',7)->nullable();
            $table->text('description')->nullable(); 
            $table->integer('admin_id')->nullable();
            $table->string('extra')->nullable(); 
            $table->string('extra1')->nullable(); 
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
        Schema::dropIfExists('school_screanings');
    }
}
