<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_session_id')->nullable();
            $table->integer('school_semester_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('programme_id')->nullable();
            $table->integer('level')->nullable();
            
            $table->integer('admin_id')->nullable();
            $table->longText('timetable')->nullable();
            $table->date('deadline')->nullable();
            $table->text('courses')->nullable();
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
        Schema::dropIfExists('timetables');
    }
}
