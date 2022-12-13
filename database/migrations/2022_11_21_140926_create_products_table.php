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
        //Migración que genera la tabla products (Productos)
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_category')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('producer');
            $table->string('format');
            $table->decimal('unit_price', 6, 2);
            $table->boolean('stock');
            $table->binary('image');
            $table->timestamps(); //Genera en la tabla los campos created_at y updated_at
            $table->foreign('id_category')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
