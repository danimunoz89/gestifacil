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
        //Migración que genera la tabla salesorders (Pedidos)
        Schema::create('salesorders', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_client')->nullable();
            $table->date('order_date');
            $table->decimal('total_price', 12, 2);
            $table->string('note')->nullable();
            $table->timestamps(); //Genera en la tabla los campos created_at y updated_at
            $table->foreign('id_client')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salesorders');
    }
};
