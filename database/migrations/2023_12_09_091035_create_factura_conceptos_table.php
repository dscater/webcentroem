<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factura_conceptos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_factura");
            $table->unsignedBigInteger("id_concepto");
            $table->string("concepto", 500);
            $table->decimal("costo", 24, 2);
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
        Schema::dropIfExists('factura_conceptos');
    }
}
