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
        Schema::create('recepcions', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio',8,2)->default(0);
            $table->integer('dias')->default(1);
            $table->integer('cliente_id')->default(1);
            $table->integer('habitacion_id')->default(1);
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->text('hora_start')->nullable();
            $table->text('hora_end')->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('recepcions');
    }
};
