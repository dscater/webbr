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
        Schema::create('terrenos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("municipio_id");
            $table->unsignedBigInteger("urbanizacion_id");
            $table->unsignedBigInteger("manzano_id");
            $table->string("nombre");
            $table->string("tipo_calle");
            $table->string("ancho_calle");
            $table->string("conectividad");
            $table->string("trafico");
            $table->string("tipo_zona");
            $table->integer("agua_potable");
            $table->integer("alcantarillado");
            $table->integer("energia_electrica");
            $table->integer("gas_natural");
            $table->integer("alumbrado");
            $table->integer("recoleccion_basura");
            $table->integer("conexion_internet");
            $table->integer("escuelas");
            $table->integer("centros_educativos");
            $table->integer("hospitales");
            $table->integer("centros_salud");
            $table->integer("centros_comerciales");
            $table->integer("mercados");
            $table->integer("tiendas");
            $table->integer("parques");
            $table->integer("plazas");
            $table->integer("espacios_recreativos");
            $table->integer("iglesias");
            $table->integer("oficinas_gubarnamentales");
            $table->integer("oficinas_servicios");
            $table->integer("bancos");
            $table->string("areas_verdes");
            $table->string("nivel_urbanizacion");
            $table->integer("seguro");
            $table->integer("limpio");
            $table->integer("en_desarrollo");
            $table->integer("viviendas");
            $table->integer("negocios");
            $table->integer("bodegas");
            $table->integer("galpones");
            $table->integer("terrenos_baldios");
            $table->string("topografia_entorno");
            $table->string("superficie_terreno");
            $table->decimal("costo_contado", 24, 2);
            $table->decimal("costo_credito", 24, 2);
            $table->string("publicar");
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("municipio_id")->on("municipios")->references("id");
            $table->foreign("urbanizacion_id")->on("urbanizacions")->references("id");
            $table->foreign("manzano_id")->on("manzanos")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terrenos');
    }
};
