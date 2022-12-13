<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Migración que genera la tabla details (Detalles de Pedido)
        Schema::create('details', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_order');
            $table->integer('id_product')->nullable();
            $table->string('name_product');
            $table->decimal('unit_price', 12, 2);
            $table->integer('quantity');
            $table->timestamps(); //Genera en la tabla los campos created_at y updated_at
            $table->foreign('id_order')->references('id')->on('salesorders')->onDelete('cascade');
            $table->foreign('id_product')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
    }
};
