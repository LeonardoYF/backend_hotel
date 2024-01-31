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
        Schema::create('recepcion_productos', function (Blueprint $table) {
            $table->id();
            $table->decimal('venta',8,2)->default(0);
            $table->integer('recepcion_id')->default(1);
            $table->integer('cantidad')->default(1);
            $table->integer('producto_id')->default(1);
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('recepcion_productos');
    }
};
