<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('numero_usuario')->nullable();
            $table->string('servicio')->nullable();
            $table->string('concepto_pago')->nullable();
            $table->timestamp('inactive_at')->nullable();
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
        Schema::dropIfExists('expense_services');
    }
}
