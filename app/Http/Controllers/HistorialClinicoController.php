<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Reportes\ReporteHistorialClinico;

use App\Models\Usuario;
use App\Models\Persona;
use App\Models\HistorialClinico;
use Illuminate\Support\Facades\Hash;
use Session;

class HistorialClinicoController extends Controller
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
        $historial_clinico = \DB::select("SELECT p.*,r.name rol, u.*, hc.*, hc.id, hc.created_at, e.especialidad
                        from users u
                        join persona p on p.id_user=u.id
                        join roles r on p.id_role = r.id
                        join historial_clinico hc on p.id=hc.id_persona
                        join especialidad e on hc.id_especialidad=e.id
                        where u.state=1 and p.id_role = 4
                        and hc.state = 1
                        order by hc.updated_at desc");
        return view('historial-clinico.listar')->with('historial_clinico',$historial_clinico);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $where = "";

        if(auth()->user()->hasRole('doctor')){
            $id_persona_doctor = \DB::select("SELECT id from persona where id_user=".auth()->user()->id)[0]->id;
            $where .= " and p.id_especialidad in (SELECT id_especialidad from asignacion_especialidad where id_persona=$id_persona_doctor)";
        }

        $paciente = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 4
                                    $where");
        
        return view('historial-clinico.crear')
                    ->with("paciente", $paciente);
    }
    
    public function store(Request $request)
    {   
        $validator = \Validator::make($request->all(),[
            'id_persona' => 'required',
            'motivo_consulta' => 'required', 
            'dolencia_actual' => 'required',
            'antecedente_familiar' => 'required', 
            'antecedente_personal' => 'required',
            'diagnostico' => 'required', 
            'fecha' => 'required|date',
            'hora' => 'required|numeric|integer|min:0|max:23', 
            'minuto' => 'required|numeric|integer|min:0|max:59',
        ]);
        
        if ($validator->fails()) {
            \Session::flash('mensaje','No se realizo la acción de registrar.');
            \Session::flash('class-alert','danger');
            return redirect('historial-clinico-nuevo')
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

        $hc = new HistorialClinico();
        $hc->id_persona = $request->id_persona;
        $hc->id_especialidad = $persona->id_especialidad;
        $hc->id_persona_doctor = $doctor->id;
        $hc->motivo_consulta = strtoupper(trim($request->motivo_consulta));
        $hc->dolencia_actual = strtoupper(trim($request->dolencia_actual));
        $hc->antecedente_familiar = strtoupper(trim($request->antecedente_familiar));
        $hc->antecedente_personal = strtoupper(trim($request->antecedente_personal));
        $hc->diagnostico = strtoupper(trim($request->diagnostico));
        $hc->fecha_hora = $request->fecha." $hora:$minuto:00";
        $hc->state = 1;
        $hc->save();
        

        \Session::flash('mensaje','Se registro correctamente.');
        \Session::flash('class-alert','success');
        
        return redirect('historial-clinico-modificar/'.$hc->id);
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = "";

        if(auth()->user()->hasRole('doctor')){
            $id_persona_doctor = \DB::select("SELECT id from persona where id_user=".auth()->user()->id)[0]->id;
            $where .= " and p.id_especialidad in (SELECT id_especialidad from asignacion_especialidad where id_persona=$id_persona_doctor)";
        }

        $paciente = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 4
                                    $where");
        
        $hc = HistorialClinico::find($id);

        return view('historial-clinico.editar')
                    ->with("paciente", $paciente)
                    ->with("historial_clinico", $hc);

    }

    public function update(Request $request, $id)
    {   
        $validator = \Validator::make($request->all(),[
            'id_persona' => 'required',
            'motivo_consulta' => 'required', 
            'dolencia_actual' => 'required',
            'antecedente_familiar' => 'required', 
            'antecedente_personal' => 'required',
            'diagnostico' => 'required', 
            'fecha' => 'required|date',
            'hora' => 'required|numeric|integer|min:0|max:23', 
            'minuto' => 'required|numeric|integer|min:0|max:59',
        ]);
        
        if ($validator->fails()) {
            \Session::flash('mensaje','No se realizo la acción de registrar.');
            \Session::flash('class-alert','danger');
            return redirect('historial-clinico-modificar/'.$id)
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

        $hc = HistorialClinico::find($id);
        $hc->id_persona = $request->id_persona;
        $hc->id_persona_doctor = $doctor->id;
        $hc->motivo_consulta = strtoupper(trim($request->motivo_consulta));
        $hc->dolencia_actual = strtoupper(trim($request->dolencia_actual));
        $hc->antecedente_familiar = strtoupper(trim($request->antecedente_familiar));
        $hc->antecedente_personal = strtoupper(trim($request->antecedente_personal));
        $hc->diagnostico = strtoupper(trim($request->diagnostico));
        $hc->fecha_hora = $request->fecha." $hora:$minuto:00";
        $hc->state = 1;
        $hc->save();
        

        \Session::flash('mensaje','Se registro correctamente.');
        \Session::flash('class-alert','success');
        
        return redirect('historial-clinico-modificar/'.$id);
    }

    public function show($id)
    {
        $paciente = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 4");
        
        $hc = HistorialClinico::find($id);

        return view('historial-clinico.ver')
                    ->with("paciente", $paciente)
                    ->with("historial_clinico", $hc);
    }

    public function delete($id)
    {
        \DB::select("UPDATE historial_clinico set state=0 where id=$id");
        \Session::flash('mensaje','Se elimino correctamente el registro.');
        \Session::flash('class-alert','success');

        return redirect('historial-clinico-form-buscar');
    }

    public function reporte($id) {
        
        $data = (object) array();

        $data->resultado = \DB::select("SELECT p.*, u.*,e.especialidad, 
                                    concat(concat(concat(concat(pd.nombre,' '),pd.paterno),' '),pd.materno) as doctor, 
                                    hc.*, p.email, hc.id nro_historial
                                    FROM users u
                                    join persona p on p.id_user = u.id 
                                    join historial_clinico hc on p.id=hc.id_persona 
                                    join especialidad e on hc.id_especialidad=e.id 
                                    join persona pd on hc.id_persona_doctor=pd.id
                                    where hc.id = $id")[0];
        //dd($data->resultado);
        $data->tipo = "I";

        $reporte = new ReporteHistorialClinico();
        $reporte->reporte($data);
    }   

}
