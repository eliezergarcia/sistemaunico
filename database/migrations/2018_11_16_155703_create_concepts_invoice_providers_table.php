<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptsInvoiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepts_invoice_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('operation_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('concept_id')->nullable();
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
        Schema::dropIfExists('concepts_invoice_providers');
    }
}
