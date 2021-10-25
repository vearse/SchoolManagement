<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->string('name');
            $table->string('email')->unique();
            $table->char('phone', 20)->unique(); 
            $table->integer('prospective')->default(0);
            $table->enum('gender', ['male', 'female']); 
            $table->date('dob')->nullable(); 
            $table->integer('admin_id')->default(0); 
            $table->integer('session_id')->nullable();
            $table->integer('admission_id')->default(0);
            $table->integer('school_id')->default(0);
            $table->timestamp('student_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('students');
    }
}
