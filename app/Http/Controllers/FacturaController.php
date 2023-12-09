<?php

namespace App\Http\Controllers;

use App\Concepto;
use App\FacturaConcepto;
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

        $factura = Factura::select("factura.*")
            ->where("factura.state", 1);
        if (auth()->user()->hasRole("administrador")) {
        } else if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
            $factura->where("factura.id_especialidad", $id_especialidad);
        }
        // por paciente
        else {
            $factura->where("factura.id_paciente",  auth()->user()->id);
        }

        $factura->orderBy("factura.fecha_factura");
        $factura = $factura->get();
        return view('factura.listar')->with('factura', $factura);
    }

    public function buscarPorFecha($fecha)
    {

        $factura = Factura::select("factura.*")
            ->where("factura.state", 1);

        if (auth()->user()->hasRole("administrador")) {
        } else if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
            $factura->where("factura.id_especialidad", $id_especialidad);
        }
        // por paciente
        else {
            $factura->where("factura.id_paciente",  auth()->user()->id);
        }
        $factura->where("factura.fecha_factura", $fecha);
        $factura->orderBy("factura.fecha_factura");
        $factura = $factura->get();
        return view('factura.listar')->with('factura', $factura);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1 order by especialidad");
        $id_especialidad = 0;
        if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $persona = Persona::find(\DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id);
            $id_especialidad  = $persona->id_especialidad;
        }
        return view('factura.crear', compact("especialidad", "id_especialidad"));
    }

    public function store(Request $request)
    {
        $datos_validacion = [
            "tipo_paciente" => "required",
            "fecha_factura" => "required|date",
            "paciente_ci" => "required",
            "paciente_nombre" => "required",
            "concepto_id" => "required|array|min:1",
            "concepto_id.*" => "required",
            // "concepto" => "required|max:300",
            "monto" => "required|numeric",
        ];

        if ($request->tipo_paciente == 'PACIENTE ASEGURADO') {
            $datos_validacion["institucion"] = "required|min:2";
        }

        if (!auth()->user()->hasRole("doctor") && !auth()->user()->hasRole("secretaria")) {
            $datos_validacion["id_especialidad"] = "required";
        }

        $validator = \Validator::make($request->all(), $datos_validacion);

        if ($validator->fails()) {
            \Session::flash('mensaje', 'No se realizo la acción de registrar.');
            \Session::flash('class-alert', 'danger');
            return redirect('factura-nuevo')
                ->withErrors($validator)
                ->withInput();
        }

        if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $persona = Persona::find(\DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id);
            $id_especialidad = $persona->id_especialidad;
        } else {
            $id_especialidad = $request->id_especialidad;
        }
        if ($id_especialidad) {
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
            if (auth()->user()->hasRole("doctor")) {
                $s->monto = $request->monto;
                $s->descuento = $request->descuento;
                $s->monto_total = (float)$request->monto - (float)$request->descuento;
            } else {
                $s->monto = $request->monto;
                $s->descuento = 0;
                $s->monto_total = $request->monto;
            }
            $s->state = 1;

            $s->save();

            // GUARDAR CONCEPTOS
            $concepto_id = $request->concepto_id;
            foreach ($concepto_id as $c) {
                $o_concepto = Concepto::find($c);
                FacturaConcepto::create([
                    "id_factura" => $s->id,
                    "id_concepto" => $c,
                    "concepto" => strtoupper(trim($o_concepto->nombre)),
                    "costo" => $o_concepto->costo,
                ]);
            }
            \Session::flash('mensaje', 'Se registro correctamente.');
            \Session::flash('class-alert', 'success');
            return redirect('factura-ver/' . $s->id);
        } else {
            \Session::flash('mensaje', 'Ocurrió un error. No se pudo registrar el pago debido a que no se seleccionó una especialidad o el usuario no tiene una especialidad asignada');
            \Session::flash('class-alert', 'danger');
            return redirect('factura-form-buscar');
        }
    }

    /**
     * Show the form for creating a new resource.
     *l
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $factura = Factura::find($id);
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1 order by especialidad");

        return view('factura.editar')
            ->with("factura", $factura)
            ->with("especialidad", $especialidad);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            "id_especialidad" => "required",
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
