<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_statements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->length(2)->nullable();
            $table->string('invoice')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('payment_month')->nullable();
            $table->string('expense_type')->nullable();
            $table->string('description')->nullable();
            $table->decimal('neto', 10, 2)->nullable();
            $table->decimal('vat', 10, 2)->nullable();
            $table->decimal('retention', 10, 2)->nullable();
            $table->decimal('others', 10, 2)->nullable();
            $table->string('payment_source')->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('solicited_by')->nullable();
            $table->string('currency')->nullable();
            $table->string('notes')->nullable();
            $table->string('additional_notes')->nullable();
            $table->string('expense_description')->nullable();
            $table->boolean('template')->nullable();
            $table->string('name_template')->nullable();
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
        Schema::dropIfExists('expense_statements');
    }
}
