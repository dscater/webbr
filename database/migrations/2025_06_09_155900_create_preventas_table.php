<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('preventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("terreno_id");
            $table->unsignedBigInteger("cliente_id");
            $table->text("descripcion");
            $table->string("estado");
            $table->date("fecha_registro")->nullable();
            $table->timestamps();

            $table->foreign("terreno_id")->on("terrenos")->references("id");
            $table->foreign("cliente_id")->on("clientes")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preventas');
    }
};
