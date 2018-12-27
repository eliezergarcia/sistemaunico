<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('operation_id')->unsigned()->nullable();
            $table->string('cntr')->nullable();
            $table->string('seal_no')->nullable();
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->string('qty')->nullable();
            $table->string('modalidad')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('measures', 10, 2)->nullable();
            $table->date('proforma')->nullable();
            $table->date('pago_proforma')->nullable();
            $table->date('solicitud_transporte')->nullable();
            $table->date('despachado_puerto')->nullable();
            $table->date('port_etd')->nullable();
            $table->date('dlv_day')->nullable();
            $table->date('factura_unmx')->nullable();
            $table->date('fecha_factura')->nullable();
            $table->timestamps();
            $table->timestamp('canceled_at')->nullable();
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
        Schema::dropIfExists('containers');
    }
}
