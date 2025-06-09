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
        Schema::create('urbanizacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("municipio_id");
            $table->string("nombre");
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("municipio_id")->on("municipios")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urbanizacions');
    }
};
