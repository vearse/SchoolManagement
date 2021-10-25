<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('note')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('programme_id')->nullable();
            $table->integer('type')->default(1);

            $table->integer('admin_id')->nullable();
            $table->integer('student_id')->nullable();
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
        Schema::dropIfExists('session_events');
    }
}
