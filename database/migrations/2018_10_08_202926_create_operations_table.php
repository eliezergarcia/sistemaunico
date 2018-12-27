<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('shipper')->unsigned();
            $table->integer('master_consignee')->unsigned();
            $table->integer('house_consignee')->unsigned();
            $table->date('etd');
            $table->date('eta');
            $table->string('impo_expo');
            $table->string('pol');
            $table->string('pod');
            $table->string('destino');
            $table->string('incoterm');
            $table->string('booking')->nullable();
            $table->date('custom_cutoff')->nullable();
            $table->string('vessel');
            $table->string('o_f')->nullable();
            $table->string('aa');
            $table->string('m_bl');
            $table->string('h_bl');
            $table->string('c_invoice');
            $table->date('recibir')->nullable();
            $table->date('revision')->nullable();
            $table->date('mandar')->nullable();
            $table->date('revalidacion')->nullable();
            $table->date('toca_piso')->nullable();

            $table->date('booking_expo')->nullable();
            $table->date('conf_booking')->nullable();
            $table->date('prog_recoleccion')->nullable();
            $table->date('recoleccion')->nullable();
            $table->date('llegada_puerto')->nullable();
            $table->date('cierre_documental')->nullable();
            $table->date('pesaje')->nullable();
            $table->date('ingreso')->nullable();
            $table->date('despacho')->nullable();
            $table->date('zarpe')->nullable();
            $table->date('envio_papelera')->nullable();

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
        Schema::dropIfExists('operations');
    }
}
