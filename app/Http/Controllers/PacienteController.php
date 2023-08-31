<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Controllers\Reportes\ReportePaciente;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\RoleUser;
use App\User;
use Illuminate\Support\Facades\Hash;
use Session;

class PacienteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where = "";

        if (auth()->user()->hasRole('doctor') || auth()->user()->hasRole('secretaria')) {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
            $where .= " and p.id_especialidad = $id_especialidad";
        }

        $users = \DB::select("SELECT p.*,r.name rol, u.*, e.especialidad
                        from users u
                        join persona p on p.id_user=u.id
                        join roles r on p.id_role = r.id
                        join especialidad e on p.id_especialidad=e.id
                        where u.state=1 and r.id = 4
                        $where
                        order by u.id desc");
        return view('paciente.listar')->with('users', $users);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mes = \DB::select("SELECT * FROM mes");
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");

        return view('paciente.crear')
            ->with("mes", $mes)
            ->with("especialidad", $especialidad);
    }

    public function store(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'nombre' => 'required',
            'ci' => 'required|numeric|digits_between:1, 10',
            'domicilio' => 'required',
            'email' => 'required|email|unique:users,email',
            'id_especialidad' => 'required',
            'genero' => 'required',
            'edad' => 'required|numeric|digits_between:1, 3',
            'dia_nac' => 'required',
            'mes_nac' => 'required',
            'anio_nac' => 'required',
            "telefono" => "nullable|numeric|digits_between:1, 10"
        ]);

        if ($validator->fails()) {
            \Session::flash('mensaje', 'No se realizo la acción de registrar.');
            \Session::flash('class-alert', 'danger');
            return redirect('paciente-nuevo')
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
        $persona->fecha_nacimiento = $request->anio_nac . "-" . $request->mes_nac . "-" . $request->dia_nac;
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

        \Session::flash('mensaje', 'Se registro correctamente el usuario.');
        \Session::flash('class-alert', 'success');
        return redirect('paciente-modificar/' . $user->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = Usuario::find($id);
        $mes = \DB::select("SELECT * FROM mes");
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");
        $persona = \DB::select("SELECT p.* FROM persona p
                                where p.id_user=$id")[0];
        if (!empty($persona->foto)) {
            $persona->foto = url("fotoPersona/" . $persona->foto);
        } else {
            $persona->foto = url("img/user-avatar.png");
        }
        return view('paciente.editar')
            ->with("persona", $persona)
            ->with("mes", $mes)
            ->with("especialidad", $especialidad)
            ->with("user", $user);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required',
            'ci' => 'required',
            'domicilio' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'id_especialidad' => 'required',
            'genero' => 'required',
            'edad' => 'required',
            'dia_nac' => 'required',
            'mes_nac' => 'required',
            'anio_nac' => 'required',
        ]);

        if ($validator->fails()) {
            \Session::flash('mensaje', 'No se realizo la acción de actualización.');
            \Session::flash('class-alert', 'danger');
            return redirect("paciente-modificar/" . $id)
                ->withErrors($validator)
                ->withInput();
        }


        $id_persona = \DB::select("SELECT id from persona where id_user=$id")[0]->id;

        $persona = Persona::find($id_persona);

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
        $persona->fecha_nacimiento = $request->anio_nac . "-" . $request->mes_nac . "-" . $request->dia_nac;
        $persona->id_role = 4;

        if (!empty($request->foto)) {
            //creacion de nombre para el archivo
            $nombre_imagen = time() . "_" . $request->foto->getClientOriginalName();
            //asignacion del nombre
            $persona->foto = $nombre_imagen;
            //guardar el archivo
            \Storage::disk("public_img")->put("fotoPersona/" . $nombre_imagen, file_get_contents($request->foto->getRealPath()));
        }

        //$persona->estado = 'ACTIVO';
        $persona->save();


        $user = Usuario::find($id);
        $user->name = trim($request->email);
        $user->email = trim($request->email);

        if (!empty($request->password)) {
            $user->password = \Hash::make($request->password);
        }


        $user->save();


        //\DB::select("UPDATE role_user set role_id={$request->id_role} where user_id=$id");
        \Session::flash('mensaje', 'Se actualizo correctamente los datos del Paciente.');
        \Session::flash('class-alert', 'success');

        return redirect('paciente-modificar/' . $id);
    }

    public function show($id)
    {
        $user = Usuario::find($id);
        $mes = \DB::select("SELECT * FROM mes");
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");
        $persona = \DB::select("SELECT p.* FROM persona p
                                where p.id_user=$id")[0];
        if (!empty($persona->foto)) {
            $persona->foto = url("fotoPersona/" . $persona->foto);
        } else {
            $persona->foto = url("img/user-avatar.png");
        }
        return view('paciente.ver')
            ->with("persona", $persona)
            ->with("mes", $mes)
            ->with("especialidad", $especialidad)
            ->with("user", $user);
    }

    public function delete($id)
    {
        \DB::select("UPDATE users set state = 0 where id=$id");
        \Session::flash('mensaje', 'Se elimino correctamente el registro.');
        \Session::flash('class-alert', 'success');

        return redirect('paciente-form-buscar');
    }


    public function reportePaciente($id)
    {

        $data = (object) array();

        $data->resultado = \DB::select("SELECT p.*, u.*,e.especialidad, p.email
                                    FROM users u
                                    join persona p on p.id_user = u.id
                                    join especialidad e on p.id_especialidad=e.id
                                    where u.id = $id")[0];
        $data->tipo = "I";

        $reporte = new ReportePaciente();
        $reporte->reporte($data);
    }

    public function reportePacienteDatosRegistro()
    {

        $id = auth()->user()->id;

        $data = (object) array();

        $data->resultado = \DB::select("SELECT p.*, u.*,e.especialidad, p.email
                                    FROM users u
                                    join persona p on p.id_user = u.id
                                    join especialidad e on p.id_especialidad=e.id
                                    where u.id = $id")[0];
        $data->tipo = "I";

        $reporte = new ReportePaciente();
        $reporte->reporte($data);
    }

    public function historialGetPacienteByIdEspecialidad($id_especialidad)
    {

        $where = "";
        if ($id_especialidad != "todos") {
            $where = " and hc.id_especialidad=$id_especialidad";
        }
        $paciente = \DB::select("SELECT u.name, p.id, p.paterno, p.materno, p.nombre
                                    FROM persona p
                                    join users u on p.id_user = u.id
                                    join historial_clinico hc on p.id=hc.id_persona
                                    where 1=1 $where
                                    group by u.name, p.id, p.paterno, p.materno, p.nombre");
        return response()->json(["paciente" => $paciente], 200);
    }

    public function seguimientoGetPacienteByIdEspecialidad($id_especialidad)
    {

        $where = "";
        if ($id_especialidad != "todos") {
            $where = " and s.id_especialidad=$id_especialidad";
        }
        $paciente = \DB::select("SELECT u.name, p.id, p.paterno, p.materno, p.nombre
                                    FROM persona p
                                    join users u on p.id_user = u.id
                                    join seguimiento s on p.id=s.id_persona
                                    where 1=1 $where
                                    group by u.name, p.id, p.paterno, p.materno, p.nombre");
        return response()->json(["paciente" => $paciente], 200);
    }
}
