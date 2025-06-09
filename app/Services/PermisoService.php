<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermisoService
{
    protected $arrayPermisos = [
        "GERENTE" => [
            "usuarios.api",
            "municipios.listado",
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

            "configuracions.index",
            "configuracions.create",
            "configuracions.edit",
            "configuracions.destroy",

            "reportes.usuarios",
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
