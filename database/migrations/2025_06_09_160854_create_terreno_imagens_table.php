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
        Schema::create('terreno_imagens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("terreno_id");
            $table->string("imagen", 255);
            $table->timestamps();

            $table->foreign("terreno_id")->on("terrenos")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terreno_imagens');
    }
};
