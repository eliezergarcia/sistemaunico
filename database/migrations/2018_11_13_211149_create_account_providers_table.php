<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->unsigned()->nullable();
            $table->string('account')->nullable();
            $table->string('currency')->nullable();
            $table->string('name_bank')->nullable();
            $table->timestamps();
            $table->timestamp('inactive_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_providers');
    }
}
