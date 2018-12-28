<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrefacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefactures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->nullable();
            $table->integer('operation_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('priority')->unsigned()->nullable();
            $table->timestamps();
            $table->timestamp('canceled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prefactures');
    }
}
