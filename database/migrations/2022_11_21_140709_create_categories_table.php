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
        //Migración que genera la tabla categories (Categorias)
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name')->unique();
            $table->binary('image');
            $table->timestamps(); //Genera en la tabla los campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
