<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptsProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepts_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
            $table->string('curr')->nullable();
            $table->float('rate')->nullable();
            $table->timestamps();
            $table->timestamp('inactive_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concepts_providers');
    }
}
