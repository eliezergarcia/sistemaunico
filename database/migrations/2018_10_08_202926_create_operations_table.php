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
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('shipper')->nullable();
            $table->string('master_consigner')->nullable();
            $table->string('house_consigner')->nullable();
            $table->date('etd')->nullable();
            $table->date('eta')->nullable();
            $table->string('impo_expo')->nullable();
            $table->string('pol')->nullable();
            $table->string('pod')->nullable();
            $table->string('destino')->nullable();
            $table->string('incoterm')->nullable();
            $table->string('booking')->nullable();
            $table->date('custom_cutoff')->nullable();
            $table->string('vessel')->nullable();
            $table->string('o_f')->nullable();
            $table->string('c_invoice')->nullable();
            $table->string('m_bl')->nullable();
            $table->string('h_bl')->nullable();
            $table->string('cntr')->nullable();
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->string('qty')->nullable();
            $table->string('weight_measures')->nullable();
            $table->string('modalidad')->nullable();
            $table->string('aa')->nullable();
            $table->date('recibir')->nullable();
            $table->date('revision')->nullable();
            $table->date('mandar')->nullable();
            $table->date('revalidacion')->nullable();
            $table->date('toca_piso')->nullable();
            $table->date('proforma')->nullable();
            $table->date('pago_proforma')->nullable();
            $table->date('solicitud_transporte')->nullable();
            $table->date('despachado_puerto')->nullable();
            $table->date('port_etd')->nullable();
            $table->date('dlv_day')->nullable();
            $table->date('factura_unmx')->nullable();
            $table->date('fecha_factura')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('operations');
    }
}
