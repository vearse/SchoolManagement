<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(); 
            $table->integer('pay1')->nullable(); 
            $table->integer('pay2')->nullable(); 
            $table->integer('admin_id')->nullable();
            $table->text('description')->nullable(); 
            $table->string('extra')->nullable(); 
            $table->string('action')->nullable(); 
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
        Schema::dropIfExists('payment_lists');
    }
}
