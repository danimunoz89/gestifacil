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
        //Migración que genera la tabla clients (Clientes)
        Schema::create('clients', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('id_user')->nullable();
            $table->string('name');
            $table->string('cif', 10)->unique()->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 9)->nullable();
            $table->string('zip');
            $table->string('address');
            $table->string('town');
            $table->string('province');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('owner')->nullable();
            $table->date('visit_date')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('clients');
    }
};
