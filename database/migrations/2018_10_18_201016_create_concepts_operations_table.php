<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptsOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepts_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('operation_id')->nullable();
            $table->integer('debit_note_id')->nullable();
            $table->integer('prefacture_id')->nullable();
            $table->integer('concept_id')->nullable();
            $table->string('curr')->nullable();
            $table->decimal('rate', 10, 2)->nullable();
            $table->decimal('iva', 10, 2)->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('foreign', 10, 2)->nullable();
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
        Schema::dropIfExists('concepts_operations');
    }
}
