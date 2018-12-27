<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuaranteeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guarantee_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->length(2)->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('operation_id')->unsigned()->nullable();
            $table->integer('provider_id')->unsigned()->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('expense_tipe')->nullable();
            $table->decimal('neto', 10, 2)->nullable();
            $table->decimal('vat', 10, 2)->nullable();
            $table->decimal('retention', 10, 2)->nullable();
            $table->decimal('others', 10, 2)->nullable();
            $table->string('expense_description')->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('account_provider_id')->unsigned()->nullable();
            $table->string('m_bl')->nullable();
            $table->string('h_bl')->nullable();
            $table->date('eta')->nullable();
            $table->decimal('bank_commission', 10, 2)->nullable();
            $table->integer('priority')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('guarantee_request')->nullable();
            $table->timestamp('advance_request')->nullable();
            $table->timestamp('aut_oper')->nullable();
            $table->timestamp('aut_fin')->nullable();
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
        Schema::dropIfExists('guarantee_requests');
    }
}
