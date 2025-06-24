<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermisoService
{
    protected $arrayPermisos = [
        "GERENTE" => [
            "usuarios.api",
            "usuarios.index",
            "usuarios.create",
            "usuarios.store",
            "usuarios.edit",
            "usuarios.show",
            "usuarios.update",
            "usuarios.destroy",
            "usuarios.password",

            "municipios.api",
            "municipios.listado",
            "municipios.index",
            "municipios.create",
            "municipios.store",
            "municipios.edit",
            "municipios.show",
            "municipios.update",
            "municipios.destroy",

            "urbanizacions.api",
            "urbanizacions.listado",
            "urbanizacions.index",
            "urbanizacions.create",
            "urbanizacions.store",
            "urbanizacions.edit",
            "urbanizacions.show",
            "urbanizacions.update",
            "urbanizacions.destroy",

            "manzanos.api",
            "manzanos.listado",
            "manzanos.index",
            "manzanos.create",
            "manzanos.store",
            "manzanos.edit",
            "manzanos.show",
            "manzanos.update",
            "manzanos.destroy",

            "terrenos.api",
            "terrenos.listado",
            "terrenos.index",
            "terrenos.create",
            "terrenos.store",
            "terrenos.edit",
            "terrenos.show",
            "terrenos.update",
            "terrenos.destroy",

            "clientes.api",
            "clientes.listado",
            "clientes.index",
            "clientes.create",
            "clientes.store",
            "clientes.edit",
            "clientes.show",
            "clientes.update",
            "clientes.destroy",

            "preventas.api",
            "preventas.listado",
            "preventas.listadoPorTerreno",
            "preventas.index",
            "preventas.create",
            "preventas.store",
            "preventas.edit",
            "preventas.show",
            "preventas.update",
            "preventas.destroy",

            "ventas.api",
            "ventas.listado",
            "ventas.index",
            "ventas.create",
            "ventas.store",
            "ventas.edit",
            "ventas.show",
            "ventas.update",
            "ventas.destroy",

            "configuracions.index",
            "configuracions.create",
            "configuracions.edit",
            "configuracions.update",
            "configuracions.destroy",

            "reportes.usuarios",
            "reportes.r_usuarios",
        ],
        "SECRETARIA" => [],
        "SUPERVISOR" => [],
        "VENDEDOR" => [],
    ];

    public function getPermisosUser()
    {
        $user = Auth::user();
        $permisos = [];
        if ($user) {
            return $this->arrayPermisos[$user->tipo];
        }

        return $permisos;
    }
}
