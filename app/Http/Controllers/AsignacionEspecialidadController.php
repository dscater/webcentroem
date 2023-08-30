<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\AsignacionEspecialidad;
use Illuminate\Support\Facades\Hash;
use Session;

class AsignacionEspecialidadController extends Controller
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
        $users = \DB::select("SELECT p.*,r.name rol, u.*, e.especialidad, p.id, p.updated_at
                        from users u
                        join persona p on p.id_user=u.id
                        join roles r on p.id_role = r.id
                        join especialidad e on p.id_especialidad=e.id
                        where u.state=1 and r.id = 2
                        order by p.paterno, p.materno, p.nombre");
        return view('asignacion-especialidad.listar')->with('users',$users);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctor = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 2 and id_especialidad is null");
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");
        
        return view('asignacion-especialidad.crear')
                    ->with("doctor", $doctor)
                    ->with("especialidad", $especialidad);
    }
    
    public function store(Request $request)
    {   

        $validator = \Validator::make($request->all(),[
            'id_persona' => 'required',
            'id_especialidad' => 'required', 
        ]);
        
        if ($validator->fails()) {
            \Session::flash('mensaje','No se realizo la acción de registrar.');
            \Session::flash('class-alert','danger');
            return redirect('asignacion-especialidad-nuevo')
                        ->withErrors($validator)
                        ->withInput();
        }

        

        $id_persona = $request->id_persona;
        $id_especialidad = $request->id_especialidad;
        $existe = \DB::select("SELECT exists (select 1 from persona where id=$id_persona and id_especialidad is not null) existe")[0]->existe;
        
        if ($existe){
            \Session::flash('mensaje','La persona tiene asignada una especialidad, edite la especialidad.');
            \Session::flash('class-alert','danger');
            return redirect('asignacion-especialidad-nuevo')
                        ->withErrors($validator)
                        ->withInput();
        }

        $persona = Persona::find($request->id_persona);
        $persona->id_especialidad = $request->id_especialidad;
        $persona->save();

        
        \Session::flash('mensaje','Se registro correctamente la asignación.');
        \Session::flash('class-alert','success');
        return redirect('asignacion-especialidad-modificar/'.$persona->id);
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $doctor = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 2");
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");

        $persona = Persona::find($id);
        
        return view('asignacion-especialidad.editar')
                    ->with("doctor", $doctor)
                    ->with("especialidad", $especialidad)
                    ->with("persona", $persona);
    }

    public function update(Request $request, $id)
    {   
        $validator = \Validator::make($request->all(),[
            'id_especialidad' => 'required', 
        ]);
        
        if ($validator->fails()) {
            \Session::flash('mensaje','No se realizo la acción de actualización.');
            \Session::flash('class-alert','danger');
            return redirect("asignacion-especialidad-modificar/".$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $id_especialidad = $request->id_especialidad;
        
        
        
        
        $persona = persona::find($id);
        $persona->id_especialidad = $id_especialidad;
        $persona->save();

        \Session::flash('mensaje','Se actualizo correctamente los datos de la asignación.');
        \Session::flash('class-alert','success');

        return redirect('asignacion-especialidad-modificar/'.$id);    
    }

    public function show($id)
    {
        $doctor = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 2");
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");

        $persona = Persona::find($id);
        
        return view('asignacion-especialidad.ver')
                    ->with("doctor", $doctor)
                    ->with("especialidad", $especialidad)
                    ->with("persona", $persona);
        
    }

    public function delete($id)
    {
        
        \DB::select("UPDATE persona set id_especialidad=null  where id=$id");
        \Session::flash('mensaje','Se elimino correctamente el registro.');
        \Session::flash('class-alert','success');

        return redirect('asignacion-especialidad-form-buscar');
    }

}
