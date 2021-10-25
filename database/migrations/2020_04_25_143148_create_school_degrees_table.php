<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_degrees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(); 
            $table->integer('admin_id')->nullable();
            $table->char('shortname',7);
            $table->text('description')->nullable(); 
            $table->text('tution')->nullable(); 
            $table->integer('year')->nullable(); 
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
        Schema::dropIfExists('school_degrees');
    }
}
