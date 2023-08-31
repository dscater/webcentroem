<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Reportes\ReporteSeguimiento;
use App\Http\Controllers\Reportes\ReporteReceta;
use App\Http\Controllers\Reportes\ReporteFactura;

use App\Helpers\FuncionesComunes;

use App\Models\Configuracion;
use App\Models\Factura;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\CitaMedica;
use Illuminate\Support\Facades\Hash;
use Session;

class FacturaController extends Controller
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

        if (auth()->user()->hasRole("administrador")) {
        } else if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
            $where = " and f.id_especialidad=$id_especialidad ";
        }
        // por paciente
        else {
            $where = " u.id=" . auth()->user()->id;
        }

        $factura = \DB::select("SELECT f.*
                        FROM factura f
                        where f.state=1
                        $where
                        order by f.fecha_factura");
        return view('factura.listar')->with('factura', $factura);
    }

    public function buscarPorFecha($fecha)
    {
        $where = "";

        if (auth()->user()->hasRole("administrador")) {
        } else if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
            $where = " and f.id_especialidad=$id_especialidad ";
        }
        // por paciente
        else {
            $where = " u.id=" . auth()->user()->id;
        }

        $factura = \DB::select("SELECT f.*
                        FROM factura f
                        where f.state=1 and f.fecha_factura='$fecha'
                        $where
                        order by f.fecha_factura");
        return view('factura.listar')->with('factura', $factura);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('factura.crear');
    }

    public function store(Request $request)
    {

        if ($request->tipo_paciente == 'PACIENTE ASEGURADO') {
            $validator = \Validator::make($request->all(), [
                "tipo_paciente" => "required",
                "institucion" => "required|min:2",
                "fecha_factura" => "required|date",
                "paciente_ci" => "required",
                "paciente_nombre" => "required",
                "concepto" => "required|max:300",
                "monto" => "required|numeric",
            ]);
        } else {
            $validator = \Validator::make($request->all(), [
                "tipo_paciente" => "required",
                "fecha_factura" => "required|date",
                "paciente_ci" => "required",
                "paciente_nombre" => "required",
                "concepto" => "required|max:300",
                "monto" => "required|numeric",
            ]);
        }

        if ($validator->fails()) {
            \Session::flash('mensaje', 'No se realizo la acción de registrar.');
            \Session::flash('class-alert', 'danger');
            return redirect('factura-nuevo')
                ->withErrors($validator)
                ->withInput();
        }

        $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
        $nro_factura = \DB::select("SELECT case when max(nro_factura) is null then 1 else max(nro_factura)+1 end nro_factura from factura")[0]->nro_factura;
        $configuracion = Configuracion::find(1);

        $s = new Factura();

        $s->id_especialidad = $id_especialidad;
        $s->tipo_paciente = $request->tipo_paciente;
        if ($request->tipo_paciente == 'PACIENTE ASEGURADO') {
            $s->institucion = strtoupper($request->institucion);
        }
        $s->fecha_factura = $request->fecha_factura;
        $s->nro_factura = $nro_factura;
        $s->paciente_ci = strtoupper(trim($request->paciente_ci));
        $s->numero_autorizacion = $configuracion->numero_autorizacion;
        $s->fecha_limite_emision = $configuracion->fecha_limite_emision;
        $s->codigo_control = FuncionesComunes::getPartCodCtr() . "-" . FuncionesComunes::getPartCodCtr() . "-" . FuncionesComunes::getPartCodCtr() . "-" . FuncionesComunes::getPartCodCtr() . "-" . FuncionesComunes::getPartCodCtr();
        $s->paciente_nombre = strtoupper(trim($request->paciente_nombre));
        $s->concepto = strtoupper(trim($request->concepto));
        $s->monto = $request->monto;
        $s->state = 1;

        $s->save();


        \Session::flash('mensaje', 'Se registro correctamente.');
        \Session::flash('class-alert', 'success');


        return redirect('factura-ver/' . $s->id);
    }

    /**
     * Show the form for creating a new resource.
     *l
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $factura = Factura::find($id);

        return view('factura.editar')
            ->with("factura", $factura);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            "fecha_factura" => "required|date",
            "paciente_ci" => "required",
            "paciente_nombre" => "required",
            "concepto" => "required|max:300",
            "monto" => "required|numeric",
        ]);

        if ($validator->fails()) {
            \Session::flash('mensaje', 'No se realizo la acción de registrar.');
            \Session::flash('class-alert', 'danger');
            return redirect('factura-nuevo')
                ->withErrors($validator)
                ->withInput();
        }




        $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;


        $configuracion = Configuracion::find(1);

        $s = Factura::find($id);


        $s->fecha_factura = $request->fecha_factura;
        //$s->nro_factura = $nro_factua;
        $s->paciente_ci = strtoupper(trim($request->paciente_ci));
        $s->numero_autorizacion = $configuracion->numero_autorizacion;
        $s->fecha_limite_emision = $configuracion->fecha_limite_emision;
        $s->codigo_control = FuncionesComunes::getPartCodCtr() . "-" . FuncionesComunes::getPartCodCtr() . "-" . FuncionesComunes::getPartCodCtr() . "-" . FuncionesComunes::getPartCodCtr() . "-" . FuncionesComunes::getPartCodCtr();
        $s->paciente_nombre = strtoupper(trim($request->paciente_nombre));
        $s->concepto = strtoupper(trim($request->concepto));
        $s->monto = $request->monto;
        $s->state = 1;

        $s->save();


        \Session::flash('mensaje', 'Se registro correctamente.');
        \Session::flash('class-alert', 'success');


        return redirect('factura-modificar/' . $id);
    }

    public function show($id)
    {


        $factura = Factura::find($id);

        return view('factura.ver')
            ->with("factura", $factura);
    }

    public function delete($id)
    {
        \DB::select("UPDATE factura set state=0 where id=$id");
        \Session::flash('mensaje', 'Se elimino correctamente el registro.');
        \Session::flash('class-alert', 'success');

        return redirect('factura-form-buscar');
    }

    public function reporteFactura($id)
    {

        $data = (object) array();

        $data->factura = Factura::find($id);

        $reporte = new ReporteFactura();
        $reporte->reporte($data);
    }
}
