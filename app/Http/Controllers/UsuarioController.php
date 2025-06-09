<?php

namespace App\Http\Controllers;

use App\Models\HistorialAccion;
use App\Models\User;
use App\Models\Venta;
use App\Models\VentaLote;
use App\Services\HistorialAccionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use PgSql\Lob;

class UsuarioController extends Controller
{
    private $modulo = "USUARIOS";

    public $validacion = [
        "nombre" => "required|min:1",
        "paterno" => "required|min:1",
        "materno" => "nullable",
        "ci" => "required|min:1",
        "ci_exp" => "required|min:1",
        "dir" => "required|min:1",
        "correo" => "nullable|email",
        "fono" => "required|min:1",
        "acceso" => "required",
        "tipo" => "required",
        "foto" => "nullable",
    ];

    public $mensajes = [
        "nombre.required" => "Este campo es obligatorio",
        "nombre.min" => "Debes ingresar al menos :min caracteres",
        "paterno.required" => "Este campo es obligatorio",
        "paterno.min" => "Debes ingresar al menos :min caracteres",
        "ci.required" => "Este campo es obligatorio",
        "ci.min" => "Debes ingresar al menos :min caracteres",
        "ci_exp.required" => "Este campo es obligatorio",
        "ci_exp.min" => "Debes ingresar al menos :min caracteres",
        "dir.required" => "Este campo es obligatorio",
        "dir.min" => "Debes ingresar al menos :min caracteres",
        "fono.required" => "Este campo es obligatorio",
        "fono.min" => "Debes ingresar al menos :min caracteres",
        "acceso.required" => "Este campo es obligatorio",
        "acceso.min" => "Debes ingresar al menos :min caracteres",
        "tipo.required" => "Este campo es obligatorio",
    ];

    public function __construct(private HistorialAccionService $historialAccionService) {}

    public function index()
    {
        return Inertia::render("Admin/Usuarios/Index");
    }

    public function clientes()
    {
        return Inertia::render("Admin/Usuarios/Clientes");
    }

    public function listado()
    {
        $usuarios = User::where("id", "!=", 1)->where("status", 1)->get();
        return response()->JSON([
            "usuarios" => $usuarios
        ]);
    }

    public function byTipo(Request $request)
    {
        $usuarios = User::where("id", "!=", 1);
        if (isset($request->tipo) && trim($request->tipo) != "") {
            $usuarios = $usuarios->where("tipo", $request->tipo);
        }

        if ($request->order && $request->order == "desc") {
            $usuarios->orderBy("users.id", "desc");
        }

        $usuarios = $usuarios->where("status", 1)->get();

        return response()->JSON([
            "usuarios" => $usuarios
        ]);
    }

    public function api(Request $request)
    {
        $length = $request->input('length', 10); // Valor de `length` enviado por DataTable
        $start = $request->input('start', 0); // Índice de inicio enviado por DataTable
        $page = ($start / $length) + 1; // Cálculo de la página actual
        $search = $request->input('search');

        $usuarios = User::selectRaw("users.*, CONCAT(users.nombre,' ',users.paterno,' ',users.materno) as full_name, CONCAT(users.ci,' ',users.ci_exp) as full_ci")
            ->where("users.id", "!=", 1);
        if ($search && trim($search) != '') {
            $usuarios->where(function ($q) use ($search) {
                $q->where("users.usuario", "LIKE", "%$search%")
                    ->orWhereRaw("CONCAT(users.nombre,' ',users.paterno,' ',users.materno) LIKE ?", ["%$search%"]);
            });
        }

        // order
        if (isset($request->order)) {
            $order = $request->order;
            $nro_col = $order[0]["column"];
            $asc_desc = $order[0]["dir"];
            $columns = $request->columns;
            if ($columns[$nro_col]["data"]) {
                $col_data = $columns[$nro_col]["data"];
                $usuarios->orderBy($col_data, $asc_desc);
            }
        }

        $usuarios = $usuarios->where("status", 1)->paginate($length, ['*'], 'page', $page);

        return response()->JSON([
            'data' => $usuarios->items(),
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    public function paginado(Request $request)
    {
        $search = $request->search;
        $usuarios = User::where("id", "!=", 1);

        if (trim($search) != "") {
            $usuarios->where("nombre", "LIKE", "%$search%");
            $usuarios->orWhere("paterno", "LIKE", "%$search%");
            $usuarios->orWhere("materno", "LIKE", "%$search%");
            $usuarios->orWhere("ci", "LIKE", "%$search%");
        }

        $usuarios = $usuarios->where("status", 1)->paginate($request->itemsPerPage);
        return response()->JSON([
            'data' => $usuarios->items(),
            'recordsTotal' => $usuarios->total(),
            'recordsFiltered' => $usuarios->total(),
            'draw' => intval($request->input('draw')),
        ]);
    }

    public function store(Request $request)
    {
        $this->validacion["ci"] = "required|numeric|digits_between:6,10|unique:users,ci";
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $request['fecha_registro'] = date('Y-m-d');

            // crear el Usuario
            $nuevo_usuario = User::create([
                "usuario" => User::getNombreUsuario($request->nombre, $request->paterno),
                "nombre" => mb_strtoupper($request->nombre),
                "paterno" => mb_strtoupper($request->paterno),
                "materno" => mb_strtoupper($request->materno),
                "ci" => mb_strtoupper($request->ci),
                "ci_exp" => mb_strtoupper($request->ci_exp),
                "dir" => mb_strtoupper($request->dir),
                "correo" => $request->correo,
                "fono" => mb_strtoupper($request->fono),
                "password" => Hash::make($request->ci),
                "acceso" => $request->acceso,
                "tipo" => mb_strtoupper($request->tipo),
                "fecha_registro" => date("Y-m-d"),
            ]);

            if ($request->foto) {
                $file = $request->foto;
                $extension = "." . $file->getClientOriginalExtension();
                $nombre_archivo = time() . $nuevo_usuario->id . $extension;
                $file->move(public_path("imgs/users"), $nombre_archivo);
                $nuevo_usuario->foto = $nombre_archivo;
            }

            $nuevo_usuario->save();

            // registrar accion
            $this->historialAccionService->registrarAccion($this->modulo, "CREACIÓN", "REGISTRO UN USUARIO", $nuevo_usuario);

            DB::commit();
            return redirect()->route("usuarios.index")->with("bien", "Registro realizado");
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function show(User $user)
    {
        return response()->JSON($user);
    }

    public function actualizaAcceso(User $user, Request $request)
    {
        $user->acceso = $request->acceso;
        $user->save();
        return response()->JSON([
            "user" => $user,
            "message" => "Acceso actualizado"
        ]);
    }

    public function update(User $user, Request $request)
    {
        $this->validacion["ci"] = "required|numeric|digits_between:6,10|unique:users,ci," . $user->id;
        $request->validate($this->validacion, $this->mensajes);
        DB::beginTransaction();
        try {
            $old_user = clone $user;
            $user->update([
                "nombre" => mb_strtoupper($request->nombre),
                "paterno" => mb_strtoupper($request->paterno),
                "materno" => mb_strtoupper($request->materno),
                "ci" => mb_strtoupper($request->ci),
                "ci_exp" => mb_strtoupper($request->ci_exp),
                "dir" => mb_strtoupper($request->dir),
                "correo" => $request->correo,
                "fono" => mb_strtoupper($request->fono),
                "acceso" => $request->acceso,
                "tipo" => mb_strtoupper($request->tipo),
            ]);

            if ($request->foto) {
                if ($user->foto && $user->foto != 'default.png') {
                    \File::delete(public_path("imgs/users/" . $user->foto));
                }
                $file = $request->foto;
                $extension = "." . $file->getClientOriginalExtension();
                $nombre_archivo = time() . $user->id . $extension;
                $file->move(public_path("imgs/users"), $nombre_archivo);
                $user->foto = $nombre_archivo;
            }

            $user->save();

            // registrar accion
            $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ UN USUARIO", $old_user, $user->withoutRelations());

            DB::commit();
            return redirect()->route("usuarios.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function actualizaPassword(User $user, Request $request)
    {
        $request->validate([
            "password" => "required"
        ]);
        DB::beginTransaction();
        try {
            $old_user = clone $user;
            $user->password = Hash::make($request->password);
            $user->save();

            // registrar accion
            $this->historialAccionService->registrarAccion($this->modulo, "MODIFICACIÓN", "ACTUALIZÓ LA CONTRASEÑA DE UN USUARIO", $old_user, $user->withoutRelations());

            DB::commit();
            return redirect()->route("usuarios.index")->with("bien", "Registro actualizado");
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::debug($e->getMessage());
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $old_user = clone $user;
            $user->status = 0;
            $user->save();

            // registrar accion
            $this->historialAccionService->registrarAccion($this->modulo, "ELIMINACIÓN", "ELIMINÓ AL USUARIO " . $old_user->usuario, $old_user, $user);
            DB::commit();
            return response()->JSON([
                'sw' => true,
                'message' => 'El registro se eliminó correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' =>  $e->getMessage(),
            ]);
        }
    }
}
