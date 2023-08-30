<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use App\Models\Persona;
use App\Models\RoleUser;
use App\Recordatorio;
use Illuminate\Support\Facades\Hash;
use Session;


class WebController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Recordatorio::enviaRecordatorios();
        return view('web.inicio');
    }
    public function nosotros()
    {
        return view('web.nosotros');
    }

    public function quienesSomos()
    {
        return view('web.quienes-somos');
    }

    public function servicios()
    {
        return view('web.servicios');
    }

    public function registrarme()
    {
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");
        return view('web.registrarme')
            ->with("especialidad", $especialidad);
    }
    public function registrarmeGuardar(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'nombre' => 'required',
            'ci' => 'required|numeric|digits_between:1, 10',
            'domicilio' => 'required',
            'email' => 'required|email|unique:users',
            'id_especialidad' => 'required',
            'genero' => 'required',
            'edad' => 'required|numeric|digits_between:1, 3',
            'fecha_nacimiento' => 'required',
            "telefono" => "nullable|numeric|digits_between:1, 10"
        ]);

        // if (isset($request->telefono) && trim($request->telefono) != "") {
        //     $validator["telefono"] = "numeric|digits_between:1, 10";
        // }

        if ($validator->fails()) {
            \Session::flash('mensaje', 'No se realizo la acción de registrar.');
            \Session::flash('class-alert', 'danger');
            return redirect('registrarme')
                ->withErrors($validator)
                ->withInput();
        }

        $persona = new Persona();

        $persona->nombre = strtoupper(trim($request->nombre));
        $persona->paterno = strtoupper(trim($request->paterno));
        $persona->materno = strtoupper(trim($request->materno));
        $persona->ci = strtoupper(trim($request->ci));
        $persona->telefono = strtoupper($request->telefono);
        $persona->email = trim($request->email);
        $persona->domicilio = strtoupper(trim($request->domicilio));
        $persona->direccion = '';
        $persona->familiar_responsable = strtoupper(trim($request->familiar_responsable));
        if (!empty($request->estado_civil))
            $persona->estado_civil = strtoupper(trim($request->estado_civil));
        else
            $persona->estado_civil = '';
        $persona->edad = strtoupper(trim($request->edad));
        $persona->genero = strtoupper(trim($request->genero));
        $persona->lugar_nacimiento = strtoupper(trim($request->lugar_nacimiento));
        $persona->id_especialidad = strtoupper(trim($request->id_especialidad));
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->id_role = 4;


        if (!empty($request->foto)) {
            //creacion de nombre para el archivo
            $nombre_imagen = time() . "_" . $request->foto->getClientOriginalName();
            //asignacion del nombre
            $persona->foto = $nombre_imagen;
            //guardar el archivo
            \Storage::disk("public_img")->put("fotoPersona/" . $nombre_imagen, file_get_contents($request->foto->getRealPath()));
        }

        $persona->state = 1;
        $persona->save();

        $persona = Persona::find($persona->id);

        $string = $persona->ci;
        $ci_int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);

        $user = new Usuario();
        $user->name = trim($request->email);
        $user->email = trim($request->email);
        $user->password = \Hash::make($ci_int);
        $user->state = 1;
        $user->save();

        $persona->id_user = $user->id;
        $persona->save();


        $rolUser = new RoleUser();

        $rolUser->role_id = 4;
        $rolUser->user_id = $user->id;
        $rolUser->state = 1;
        $rolUser->save();

        \Session::flash('message', 'Se registro correctamente el usuario.');
        \Session::flash('class-alert', 'success');
        return redirect('login');
    }
}
