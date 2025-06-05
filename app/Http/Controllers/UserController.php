<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function permisosUsuario(Request $request)
    {
        return response()->JSON([
            "permisos" => Auth::user()->getPermisos()
        ]);
    }

    public function getUser()
    {
        return response()->JSON([
            "user" => Auth::user()
        ]);
    }

    public static function getInfoBoxUser()
    {
        $permisos = [];
        $array_infos = [];
        if (Auth::check()) {
            $oUser = new User();
            $permisos = $oUser->getPermisos();
            if ($permisos == '*' || (is_array($permisos) && in_array('usuarios.index', $permisos))) {
                $array_infos[] = [
                    'label' => 'USUARIOS',
                    'cantidad' => User::where('id', '!=', 1)->count(),
                    'color' => 'bg-principal',
                    'icon' => "fa-users",
                    "url" => "usuarios.index"
                ];
            }

            if ($permisos == '*' || (is_array($permisos) && in_array('publicacions.index', $permisos))) {
                $publicacions = Publicacion::select("publicacions.id");

                $permisos = Auth::user()->permisos;
                if (is_array($permisos) && !in_array("publicacions.todos", $permisos)) {
                    $publicacions->where("user_id", Auth::user()->id);
                }
                $publicacions = $publicacions->count();

                $array_infos[] = [
                    'label' => 'PUBLICACIONES',
                    'cantidad' => $publicacions,
                    'color' => 'bg-principal',
                    'icon' => "fa-list",
                    "url" => "publicacions.index"
                ];
            }
        }


        return $array_infos;
    }
}
