<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Reportes\ReporteSeguimiento;
use App\Http\Controllers\Reportes\ReporteReceta;

use App\Models\Usuario;
use App\Models\Persona;
use App\Models\Seguimiento;
use Illuminate\Support\Facades\Hash;
use Session;

class SeguimientoController extends Controller
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

        if(auth()->user()->hasRole('doctor')){
            $id_persona_doctor = \DB::select("SELECT id from persona where id_user=".auth()->user()->id)[0]->id;
            $where .= " and s.id_especialidad in (SELECT id_especialidad from asignacion_especialidad where id_persona=$id_persona_doctor)";
        }

        $seguimiento = \DB::select("SELECT p.*,r.name rol, u.*, s.*, s.id, s.created_at, e.especialidad
                        from users u
                        join persona p on p.id_user=u.id
                        join roles r on p.id_role = r.id
                        join seguimiento s on p.id=s.id_persona
                        join especialidad e on s.id_especialidad=e.id
                        where u.state=1 and p.id_role = 4
                        and s.state = 1
                        $where
                        order by s.updated_at desc");
        return view('seguimiento.listar')->with('seguimiento',$seguimiento);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paciente = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 4");
        
        return view('seguimiento.crear')
                    ->with("paciente", $paciente);
    }
    
    public function store(Request $request)
    {   
        $validator = \Validator::make($request->all(),[
            'id_persona' => 'required',
            'tratamiento' => 'required', 
            'descripcion_evolucion' => 'required',
            'medicamento' => 'required', 
            'fecha' => 'required|date',
            'hora' => 'required|numeric|integer|min:0|max:23', 
            'minuto' => 'required|numeric|integer|min:0|max:59',
        ]);
        
        if ($validator->fails()) {
            \Session::flash('mensaje','No se realizo la acción de registrar.');
            \Session::flash('class-alert','danger');
            return redirect('seguimiento-nuevo')
                        ->withErrors($validator)
                        ->withInput();
        }


        $hora = $request->hora;
        $minuto = $request->minuto;

        if($request->hora<10){
            $hora = "0"+$request->hora;
        }

        if($request->minuto<10){
            $minuto = "0"+$request->minuto;
        }

        $persona = Persona::find($request->id_persona);

        $doctor = Persona::find(\DB::select("SELECT id from persona where id_user=".auth()->user()->id)[0]->id);
        
        $s = new Seguimiento();
        $s->id_persona = $request->id_persona;
        $s->id_especialidad = $persona->id_especialidad;
        $s->id_persona_doctor = $doctor->id;
        $s->tratamiento = strtoupper(trim($request->tratamiento));
        $s->descripcion_evolucion = strtoupper(trim($request->descripcion_evolucion));
        $s->medicamento = strtoupper(trim($request->medicamento));
        $s->fecha_hora = $request->fecha." $hora:$minuto:00";
        $s->state = 1;
        $s->save();
        

        \Session::flash('mensaje','Se registro correctamente.');
        \Session::flash('class-alert','success');
        
        return redirect('seguimiento-modificar/'.$s->id);
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $paciente = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 4");
        
        $s = Seguimiento::find($id);

        return view('seguimiento.editar')
                    ->with("paciente", $paciente)
                    ->with("seguimiento", $s);

    }

    public function update(Request $request, $id)
    {   
        $validator = \Validator::make($request->all(),[
            'id_persona' => 'required',
            'tratamiento' => 'required', 
            'descripcion_evolucion' => 'required',
            'medicamento' => 'required', 
            'fecha' => 'required|date',
            'hora' => 'required|numeric|integer|min:0|max:23', 
            'minuto' => 'required|numeric|integer|min:0|max:59',
        ]);
        
        if ($validator->fails()) {
            \Session::flash('mensaje','No se realizo la acción de registrar.');
            \Session::flash('class-alert','danger');
            return redirect('seguimiento-modificar/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }


        $hora = $request->hora;
        $minuto = $request->minuto;

        if($request->hora<10){
            $hora = "0"+$request->hora;
        }

        if($request->minuto<10){
            $minuto = "0"+$request->minuto;
        }

        $doctor = Persona::find(\DB::select("SELECT id from persona where id_user=".auth()->user()->id)[0]->id);

        $s = Seguimiento::find($id);
        $s->id_persona = $request->id_persona;
        $s->id_persona_doctor = $doctor->id;
        $s->tratamiento = strtoupper(trim($request->tratamiento));
        $s->descripcion_evolucion = strtoupper(trim($request->descripcion_evolucion));
        $s->medicamento = strtoupper(trim($request->medicamento));
        $s->fecha_hora = $request->fecha." $hora:$minuto:00";
        $s->save();
        

        \Session::flash('mensaje','Se registro correctamente.');
        \Session::flash('class-alert','success');
        
        return redirect('seguimiento-modificar/'.$id);
    }

    public function show($id)
    {
        $paciente = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 4");
        
        $s = Seguimiento::find($id);

        return view('seguimiento.ver')
                    ->with("paciente", $paciente)
                    ->with("seguimiento", $s);
    }

    public function delete($id)
    {
        \DB::select("UPDATE seguimiento set state=0 where id=$id");
        \Session::flash('mensaje','Se elimino correctamente el registro.');
        \Session::flash('class-alert','success');

        return redirect('seguimiento-form-buscar');
    }

    public function reporte($id) {
        
        $data = (object) array();

        $data->resultado = \DB::select("SELECT p.*, u.*,e.especialidad, 
                                    concat(concat(concat(concat(pd.nombre,' '),pd.paterno),' '),pd.materno) as doctor, 
                                    s.*, p.email, s.id nro_seguimiento
                                    FROM users u
                                    join persona p on p.id_user = u.id 
                                    join seguimiento s on p.id=s.id_persona 
                                    join especialidad e on s.id_especialidad=e.id 
                                    join persona pd on s.id_persona_doctor=pd.id
                                    where s.id = $id")[0];
        //dd($data->resultado);
        $data->tipo = "I";

        $reporte = new ReporteSeguimiento();
        $reporte->reporte($data);
    }

    public function reporteReceta($id) {
        
        $data = (object) array();

        $data->resultado = \DB::select("SELECT p.*, u.*,e.especialidad, 
                                    concat(concat(concat(concat(pd.nombre,' '),pd.paterno),' '),pd.materno) as doctor, 
                                    s.*, p.email, s.id nro_seguimiento
                                    FROM users u
                                    join persona p on p.id_user = u.id 
                                    join seguimiento s on p.id=s.id_persona 
                                    join especialidad e on s.id_especialidad=e.id 
                                    join persona pd on s.id_persona_doctor=pd.id
                                    where s.id = $id")[0];
        //dd($data->resultado);
        $data->tipo = "I";

        $reporte = new ReporteReceta();
        $reporte->reporte($data);
    }

}
