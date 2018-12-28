<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseblsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('housebls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number')->nullable();
            $table->integer('operation_id')->unsigned();
            $table->string('shipper');
            $table->string('house_consignee');
            $table->string('notify_party');
            $table->string('no_pkgs');
            $table->text('description');
            $table->text('cargo_type');
            $table->text('freight_term');
            $table->text('service_term1');
            $table->text('service_term2');
            $table->text('description_header1');
            $table->text('description_header2');
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
        Schema::dropIfExists('housebls');
    }
}
