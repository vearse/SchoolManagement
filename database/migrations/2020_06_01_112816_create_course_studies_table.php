<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_studies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->char('level',6);
            $table->char('shortname',9)->unique();
            $table->integer('unit')->nullable();
            $table->text('note')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('programme_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('course_studies');
    }
}
