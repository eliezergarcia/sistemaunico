<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('factura');
            $table->integer('operation_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->string('tipo');
            $table->string('lugar');
            $table->string('moneda');
            $table->decimal('neto', 10, 2);
            $table->decimal('iva', 10, 2);
            $table->date('fecha_factura');
            $table->string('comentarios')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
