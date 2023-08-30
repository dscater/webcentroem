<?php

namespace App\Http\Controllers\ModuloPlanilla;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\ModuloPlanilla\GenerarPlanilla\GenerarPlanilla;
use App\Http\Controllers\ModuloPlanilla\GenerarPlanilla\GenerarPlanillaAguinaldo;

use App\Models\Consultas;
use App\Models\Planilla;
use App\Models\PlanillaCabecera;
use App\Models\PlanillaParametros;
use App\Models\PlanillaDescuento;
use App\Models\Catalogos;
use App\Helpers\FuncionesComunes;
use Illuminate\Support\Facades\Validator;


class PlanillaController extends Controller
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

    public function nuevo()
    {
        $gestion = date("Y");
        $mes = (int) date("m");
        $meses = Catalogos::getCatalogo("mes", "id, mes","state=true");
        $tipo_planilla = Catalogos::getCatalogo("tipo_planilla", "id, tipo","state=true");
        /*$tipo_contrato = Catalogos::getCatalogo("tipo_contrato", "id, tipo_contrato","state=true");*/
        
        return view('planilla/nuevo')
                    ->with("gestion",$gestion)
                    ->with("mes",$mes)
                    ->with("meses",$meses)
                    ->with("tipo_planilla",$tipo_planilla);
                    /*->with("tipo_contrato",$tipo_contrato);*/
    }


    public function registrarNuevo(Request $request){

        $validator = Validator::make($request->all(),[
            'gestion' => 'required|numeric',
            'mes' => 'required|numeric',
            'codigo_planilla' => 'required',
            'id_tipo_planilla' => 'required|numeric',
            /*'id_tipo_contrato' => 'required|numeric',*/
            'fecha_limite_contrato' => 'required|numeric',
        ]);
        
        if ($validator->fails()) { 
            return redirect('planilla-nuevo')
                        ->withErrors($validator)
                        ->withInput();
        }
        $existe = \DB::select("SELECT exists(SELECT 1 
                        from planilla_cabecera 
                        where codigo_planilla='{$request->codigo_planilla}') existe")[0]->existe;
        if($existe){
            \Session::flash('mensaje', ["El codigo de planilla ya existe"]);
            \Session::flash('class-alert', "danger");
            return redirect('planilla-nuevo')
                        ->withInput();
        }

        $id_planilla_parametros = \DB::select("SELECT id
                        from planilla_parametros 
                        where state=1")[0]->id;
        
        $pc = new PlanillaCabecera();
        $pc->gestion = $request->gestion;
        $pc->mes = $request->mes;
        $pc->id_tipo_planilla = $request->id_tipo_planilla;
        /*$pc->id_tipo_contrato = $request->id_tipo_contrato;*/
        $pc->codigo_planilla = $request->codigo_planilla;
        $pc->fecha_limite_contrato = $request->fecha_limite_contrato;
        $pc->id_planilla_parametros = $id_planilla_parametros;       
        $pc->save();
        return redirect("planilla-modificar/".$pc->id);
    }
    public function modificar($id){
        $gestion = date("Y");
        $mes = (int) date("m");
        $meses = Catalogos::getCatalogo("mes", "id, mes","state=true");
        $tipo_planilla = Catalogos::getCatalogo("tipo_planilla", "id, tipo","state=true");
        /*$tipo_contrato = Catalogos::getCatalogo("tipo_contrato", "id, tipo_contrato","state=true");*/
        $planilla_cabecera = PlanillaCabecera::find($id);
        return view('planilla/modificar')
                    ->with("gestion",$gestion)
                    ->with("mes",$mes)
                    ->with("meses",$meses)
                    ->with("tipo_planilla",$tipo_planilla)
                    /*->with("tipo_contrato",$tipo_contrato)*/
                    ->with("planilla_cabecera",$planilla_cabecera);

    }

    public function registrarModificacion(Request $request, $id){
        
        $validator = Validator::make($request->all(),[
            'gestion' => 'required|numeric',
            'mes' => 'required|numeric',
            'codigo_planilla' => 'required',
            'id_tipo_planilla' => 'required|numeric',
            /*'id_tipo_contrato' => 'required|numeric',*/
            'fecha_limite_contrato' => 'required|numeric',
        ]);
        

        if ($validator->fails()) {
            return redirect('planilla-modficicar/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $pc = PlanillaCabecera::find($id);
        $pc->gestion = $request->gestion;
        $pc->mes = $request->mes;
        $pc->id_tipo_planilla = $request->id_tipo_planilla;
        //$pc->id_tipo_contrato = $request->id_tipo_contrato;
        $pc->codigo_planilla = $request->codigo_planilla;
        $pc->fecha_limite_contrato = $request->fecha_limite_contrato;
        //$pc->id_planilla_parametros = $id_planilla_parametros;       
        $pc->save();
        
        return redirect("planilla-modificar/".$pc->id);

    }

    public function generarPlanillaV1(Request $request) {
        
        $id = $request->id_planilla_cabecera;
        $planilla_cabecera = \DB::select("SELECT * FROM planilla_cabecera 
                                    where id=$id")[0];
        //$fecha_limite_contrato = $planilla_cabecera->fecha_limite_contrato;
        //dd($planilla_cabecera);

        /*$contratos = \DB::select("SELECT * FROM contrato_personal 
                                    where estado_contrato='VIGENTE'");*/
        $gp = new GenerarPlanillaCaso1($planilla_cabecera);
        $gp->validar();
        $gp->procesar();
        die;
        
    }

    public function generarPlanilla(Request $request) {
        
        $planilla_cabecera = PlanillaCabecera::find($request->id_planilla_cabecera);

        $meses = FuncionesComunes::getMeses();
        $planilla_model = new Planilla();
        $planillaResponse = $planilla_model->getPlanillaByCodigoPlanillaGestionMes($planilla_cabecera->codigo_planilla, $planilla_cabecera->gestion, $planilla_cabecera->mes);
        
        $generarPlanilla = new GenerarPlanilla($planilla_cabecera);
        $errors = $generarPlanilla->validar();
        

        if(!empty($errors)){
            \Session::flash('mensaje', $errors);
            \Session::flash('class-alert', "danger");
            return view("planilla/form-buscar")
                    ->with('meses',$meses)
                    ->with('mes',$planilla_cabecera->mes)
                    ->with('gestion',$planilla_cabecera->gestion)
                    ->with('codigo_planilla',$planilla_cabecera->codigo_planilla)
                    ->with('planilla_cabecera',$planillaResponse);
        }

        $generarPlanilla->procesar();

        
        \Session::flash('mensaje', ["La planilla se genero correctamente."]);
        \Session::flash('class-alert', "success");
        return view("planilla/form-buscar")
                    ->with('meses',$meses)
                    ->with('mes',$planilla_cabecera->mes)
                    ->with('gestion',$planilla_cabecera->gestion)
                    ->with('codigo_planilla',$planilla_cabecera->codigo_planilla)
                    ->with('planilla_cabecera',$planillaResponse);
    }

    public function generarPlanillaAguinaldo(Request $request) {
        
        $planilla_cabecera = PlanillaCabecera::find($request->id_planilla_cabecera);

        $meses = FuncionesComunes::getMeses();
        $planilla_model = new Planilla();
        $planillaResponse = $planilla_model->getPlanillaByCodigoPlanillaGestionMes($planilla_cabecera->codigo_planilla, $planilla_cabecera->gestion, $planilla_cabecera->mes);
        
        $generarPlanilla = new GenerarPlanillaAguinaldo($planilla_cabecera);
        $errors = $generarPlanilla->validar();
        

        if(!empty($errors)){
            \Session::flash('mensaje', $errors);
            \Session::flash('class-alert', "danger");
            return view("planilla/form-buscar")
                    ->with('meses',$meses)
                    ->with('mes',$planilla_cabecera->mes)
                    ->with('gestion',$planilla_cabecera->gestion)
                    ->with('codigo_planilla',$planilla_cabecera->codigo_planilla)
                    ->with('planilla_cabecera',$planillaResponse);
        }

        $generarPlanilla->procesar();

        
        \Session::flash('mensaje', ["La planilla de aguinaldo se genero correctamente."]);
        \Session::flash('class-alert', "success");
        return view("planilla/form-buscar")
                    ->with('meses',$meses)
                    ->with('mes',$planilla_cabecera->mes)
                    ->with('gestion',$planilla_cabecera->gestion)
                    ->with('codigo_planilla',$planilla_cabecera->codigo_planilla)
                    ->with('planilla_cabecera',$planillaResponse);
    }

    public function aprobarPlanilla(Request $request){

        $pc = PlanillaCabecera::find($request->id_planilla_cabecera);
        
        $planilla_model = new Planilla();

        $meses = FuncionesComunes::getMeses();
        $mes = (int) date('m');
        $gestion = date('Y');

        if($pc->estado_planilla == "PENDIENTE" && ($request->caso==2||$request->caso==3)){
            $planilla_cabecera = $planilla_model->getPlanillaByCodigoPlanillaGestionMes($pc->codigo_planilla, $pc->gestion, $pc->mes);
            \Session::flash('mensaje', ["El estado de la planilla debe ser APROBADO."]);
            \Session::flash('class-alert', "danger");
            return view("planilla/form-buscar")
                    ->with('meses',$meses)
                    ->with('mes',$request->mes)
                    ->with('gestion',$request->gestion)
                    ->with('codigo_planilla',$request->codigo_planilla)
                    ->with('planilla_cabecera',$planilla_cabecera);
                        
        }
        switch ($request->caso) {
            case 1:
                $pc->estado_planilla = "APROBADO";
                break;
            case 2:
                $pc->pago_banco = "AUTORIZADO";
                break;
            case 3:
                $pc->pago_caja = "AUTORIZADO";
                break;
            default:
                # code...
                break;
        }
        $pc->save();
        
        $planilla_model = new Planilla();
        $planilla_cabecera = $planilla_model->getPlanillaByCodigoPlanillaGestionMes($pc->codigo_planilla, $pc->gestion, $pc->mes);
        $meses = FuncionesComunes::getMeses();
        $mes = (int) date('m');
        $gestion = date('Y');
        return view("planilla/form-buscar")
                    ->with('meses',$meses)
                    ->with('mes',$mes)
                    ->with('gestion',$gestion)
                    ->with('codigo_planilla',$request->codigo_planilla)
                    ->with('planilla_cabecera',$planilla_cabecera);
    }

    public function formularioBuscar(){        
        $meses = FuncionesComunes::getMeses();
        $mes = (int) date('m');
        $gestion = date('Y');
        return view("planilla/form-buscar")
                    ->with('meses',$meses)
                    ->with('mes',$mes)
                    ->with('gestion',$gestion);
    }
    
    public function buscarByGestionMes(Request $request){
        
        $validator = Validator::make($request->all(),[
            'gestion' => 'required|numeric',
            'mes' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return redirect('planilla-form-buscar')
                        ->withErrors($validator)
                        ->withInput();
        }
        $planilla_model = new Planilla();
        
        if(!empty($request->codigo_planilla)){
            $planilla_cabecera = $planilla_model->getPlanillaByCodigoPlanillaGestionMes($request->codigo_planilla, $request->gestion, $request->mes);    
        }
        else{
            $planilla_cabecera = $planilla_model->getPlanillaByGestionMes($request->gestion, $request->mes);
        }
            
        $meses = FuncionesComunes::getMeses();
        return view("planilla/form-buscar")
                    ->with('meses',$meses)
                    ->with('mes',$request->mes)
                    ->with('gestion',$request->gestion)
                    ->with('codigo_planilla',$request->codigo_planilla)
                    ->with('planilla_cabecera',$planilla_cabecera);
        
    }

    public function eliminar(Request $request, $id){
        $pc = PlanillaCabecera::find($id);
        if($pc->estado_planilla == "APROBADO"){
            \Session::flash('mensaje', ["La planilla no se puede eliminar con estado APROBADO."]);
            \Session::flash('class-alert', "danger");
            return redirect("planilla-form-buscar");
        }

        \DB::select("DELETE FROM planilla_cabecera where id=$id");
        \DB::select("DELETE FROM planilla where id_planilla_cabecera=$id");
        \DB::select("DELETE FROM planilla_tributaria where id_planilla_cabecera=$id");
        \DB::select("DELETE FROM planilla_trabajo where id_planilla_cabecera=$id");
        \Session::flash('mensaje', ["Se eliminó el registro correctamente."]);
        \Session::flash('class-alert', "success");
        return redirect("planilla-form-buscar");
    }

    
}
