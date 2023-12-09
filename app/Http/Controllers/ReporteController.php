<?php

namespace App\Http\Controllers;

use App\FacturaConcepto;
use Illuminate\Http\Request;

use App\Models\Consultas;
use App\Models\Persona;

use App\Models\Usuario;
use App\Models\Venta;
use App\Models\Sucursal;


use App\Models\Catalogos;
use App\Helpers\FuncionesComunes;
use Illuminate\Support\Facades\Validator;


use App\Http\Controllers\Reportes\ReporteUsuarios;
use App\Http\Controllers\Reportes\ReporteHistoriaClinica;
use App\Http\Controllers\Reportes\ReporteSeguimientoControl;
use App\Http\Controllers\Reportes\ReportePacientes;
use App\Http\Controllers\Reportes\ReporteCantidadPaciente;
use App\Http\Controllers\Reportes\ReporteCantidadVentas;
use App\Http\Controllers\Reportes\ReporteCantidadSolicitudesPedido;
use App\Http\Controllers\Reportes\reporteCitaMedica;
use App\Http\Controllers\Reportes\ReporteFacturas;
use App\Models\Factura;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Storage;

class ReporteController extends Controller
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

    public function usuarios()
    {
        $role = \DB::select("SELECT * from roles where id!=4");

        return view("reportes/usuarios")
            ->with("role", $role);
    }

    public function historialClinico()
    {
        /*$paciente = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 4
                                    order by u.name desc");*/
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1 order by especialidad");

        return view("reportes/historial-clinico")
            /*->with("paciente",$paciente)*/
            ->with("especialidad", $especialidad);
    }
    public function SeguimientoControl()
    {
        /*$paciente = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name 
                                    FROM users u
                                    join persona p on u.id=p.id_user
                                    where u.state=1 and p.id_role = 4
                                    order by u.name desc");*/
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1 order by especialidad");

        return view("reportes/seguimiento-control")
            /*->with("paciente",$paciente)*/
            ->with("especialidad", $especialidad);
    }

    public function paciente()
    {
        $especialidad = [];
        if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $persona = Persona::find(\DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id);
            $id_especialidad = $persona->id_especialidad;
            $especialidad = \DB::select("SELECT * FROM especialidad where state=1 AND id= $id_especialidad");
        } else {
            $especialidad = \DB::select("SELECT * FROM especialidad where state=1 order by especialidad");
        }
        return view("reportes/paciente")
            ->with("especialidad", $especialidad);
    }

    public function cantidadPaciente()
    {
        return view("reportes/cantidad-paciente");
    }

    public function citaMedica()
    {
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1 order by especialidad");

        return view("reportes/cita-medica")
            ->with("especialidad", $especialidad);
    }

    public function factura()
    {
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1 order by especialidad");

        return view("reportes/factura")
            ->with("especialidad", $especialidad);
    }


    public function graficoPagos()
    {
        $gestion_min = Factura::orderBy("created_at", "asc")->get()->first();
        $gestion_max = Factura::orderBy("created_at", "asc")->get()->last();
        $gestion_min = date("Y", strtotime($gestion_min->created_at));
        $gestion_max = date("Y", strtotime($gestion_max->created_at));
        $array_gestiones = [$gestion_min];
        if ($gestion_min != $gestion_max) {
            $array_gestiones = [];
            for ($i = (int)$gestion_min; $i <= (int)$gestion_max; $i++) {
                $array_gestiones[] = $i;
            }
        }

        $especialidad = [];
        if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $persona = Persona::find(\DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id);
            $id_especialidad = $persona->id_especialidad;
            $especialidad = \DB::select("SELECT * FROM especialidad where state=1 AND id= $id_especialidad");
        } else {
            $especialidad = \DB::select("SELECT * FROM especialidad where state=1 order by especialidad");
        }


        return view("reportes.grafico_pagos")->with("especialidad", $especialidad)->with("array_gestiones", $array_gestiones);
    }

    public function infoGraficoPagos(Request $request)
    {
        $id_especialidad = $request->id_especialidad;
        $gestion = $request->gestion;

        $especialidad = DB::select("SELECT * FROM especialidad WHERE id = ? LIMIT 1", [$id_especialidad]);

        $gestion_max = Factura::orderBy("created_at", "asc")->get()->last();
        $gestion_max = date("Y", strtotime($gestion_max->created_at));
        $gestion_buscar = $gestion_max;
        $meses = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
        $meses_texto = [
            "01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo",
            "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre"
        ];

        if ($gestion != '') {
            $gestion_buscar = $gestion;
        }

        $data = [];
        foreach ($meses as $mes) {
            $fecha_like = $gestion_buscar . '-' . $mes;
            $sum = Factura::where("fecha_factura", "LIKE", "$fecha_like%")->sum("monto");
            if ($id_especialidad != "todos") {
                $sum = Factura::where("fecha_factura", "LIKE", "$fecha_like%")->where("id_especialidad", $id_especialidad)->sum("monto");
            }
            $data[] = [
                $meses_texto[$mes], (float)$sum
            ];
        }
        // return response()->JSON($especialidad[0]);
        return response()->JSON([
            "data" => $data,
            "gestion" => $gestion_buscar,
            "nombre" => count($especialidad) > 0 ? $especialidad[0]->especialidad : 'TODOS'

        ]);
    }


    public function reporteUsuarios()
    {
        $id_role = $_GET["id_role"];
        $desde = $_GET["desde"];
        $hasta = $_GET["hasta"];

        $where = ($id_role == "todos") ? "" : " and r.id=$id_role ";




        $where .= ($desde == "") ? "" : " and '$desde'<=p.created_at ";
        $where .= ($hasta == "") ? "" : " and '$hasta 23:59:59'>=p.created_at ";


        $data = (object) array();

        $data->resultado = \DB::select("SELECT u.name, p.paterno, p.materno, p.nombre, p.ci,
                                            r.name role, p.telefono, p.celular, p.email, p.direccion, p.created_at
                                        FROM users u
                                        join persona p on p.id_user = u.id
                                        join roles r  on p.id_role = r.id
                                        where r.id!=4 and p.state=1 $where
                                        order by r.id, p.id, p.paterno, p.materno, p.nombre");
        $data->tipo = "I";

        $reporte = new ReporteUsuarios();
        $reporte->reporte($data);
    }



    public function reporteHistorialClinico()
    {

        if (auth()->user()->hasRole('paciente')) {
            $id_persona = \DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id;
            $id_especialidad = "todos";
        } else {
            $errors = [];

            if (empty($_GET["id_especialidad"])) {
                $errors[] = "EL CAMPO ESPECIALIDAD ES REQUERIDO";
            }
            if (empty($_GET["id_persona"])) {
                $errors[] = "EL CAMPO PACIENTE ES REQUERIDO";
            }
            if (!empty($errors)) {
                return view('error.error')
                    ->with("errors", $errors);
            }
            $id_persona = $_GET["id_persona"];
            $id_especialidad = $_GET["id_especialidad"];
        }




        $where = "";
        $where .= ($id_persona == "todos") ? "" : " and p.id=$id_persona ";
        $where .= ($id_especialidad == "todos") ? "" : " and hc.id_especialidad=$id_especialidad ";


        $data = (object) array();
        $data->resultado = \DB::select("SELECT u.name, p.paterno, p.materno, p.nombre, p.ci,
                                     p.telefono, hc.*, 
                                     ud.name name_doctor, d.paterno paterno_doctor, d.materno materno_doctor, d.nombre nombre_doctor, d.ci ci_doctor,
                                     e.especialidad
                                    FROM users u
                                    join persona p on p.id_user = u.id
                                    join historial_clinico hc on p.id=hc.id_persona
                                    join especialidad e on hc.id_especialidad=e.id
                                    join persona d on hc.id_persona_doctor=d.id
                                    join users ud on d.id_user=ud.id
                                    where p.id_role=4 and hc.state=1 and e.state=1 and p.state=1 $where
                                    order by u.name, e.especialidad, hc.fecha_hora");
        $data->tipo = "I";

        $reporte = new ReporteHistoriaClinica();
        $reporte->reporte($data);
    }

    public function reporteSeguimientoControl()
    {
        if (auth()->user()->hasRole('paciente')) {
            $id_persona = \DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id;
            $id_especialidad = "todos";
        } else {
            $errors = [];

            if (empty($_GET["id_especialidad"])) {
                $errors[] = "EL CAMPO ESPECIALIDAD ES REQUERIDO";
            }
            if (empty($_GET["id_persona"])) {
                $errors[] = "EL CAMPO PACIENTE ES REQUERIDO";
            }
            if (!empty($errors)) {
                return view('error.error')
                    ->with("errors", $errors);
            }
            $id_persona = $_GET["id_persona"];
            $id_especialidad = $_GET["id_especialidad"];
        }


        $where = "";
        $where .= ($id_persona == "todos") ? "" : " and p.id=$id_persona ";
        $where .= ($id_especialidad == "todos") ? "" : " and s.id_especialidad=$id_especialidad ";


        $data = (object) array();
        $data->resultado = \DB::select("SELECT u.name, p.paterno, p.materno, p.nombre, p.ci,
                                     p.telefono, s.*, 
                                     ud.name name_doctor, d.paterno paterno_doctor, d.materno materno_doctor, d.nombre nombre_doctor, d.ci ci_doctor,
                                     e.especialidad
                                    FROM users u
                                    join persona p on p.id_user = u.id
                                    join seguimiento s on p.id=s.id_persona
                                    join especialidad e on s.id_especialidad=e.id
                                    join persona d on s.id_persona_doctor=d.id
                                    join users ud on d.id_user=ud.id
                                    where p.id_role=4 and s.state=1 and e.state=1 and p.state=1 $where
                                    order by u.name, e.especialidad, s.fecha_hora");
        $data->tipo = "I";

        $reporte = new ReporteSeguimientoControl();
        $reporte->reporte($data);
    }

    public function reportePaciente()
    {
        $id_especialidad = $_GET["id_especialidad"];
        $desde = $_GET["desde"];
        $hasta = $_GET["hasta"];

        $where = ($id_especialidad == "todos") ? "" : " and e.id=$id_especialidad ";




        $where .= ($desde == "") ? "" : " and '$desde'<=p.updated_at ";
        $where .= ($hasta == "") ? "" : " and '$hasta 23:59:59'>=p.updated_at ";


        $data = (object) array();

        if (auth()->user()->hasRole('doctor') || auth()->user()->hasRole('secretaria')) {
            $persona = Persona::find(\DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id);
            $id_especialidad = $persona->id_especialidad;
            $data->resultado = \DB::select("SELECT u.name, 
                                                r.name role, p.*, p.created_at, e.especialidad
                                            FROM users u
                                            join persona p on p.id_user = u.id
                                            join roles r  on p.id_role = r.id
                                            join especialidad e on p.id_especialidad=e.id
                                            where r.id=4 and p.state=1 and e.state=1 and p.id_especialidad = $id_especialidad $where 
                                            order by p.paterno, p.materno, p.nombre");
        } else {
            $data->resultado = \DB::select("SELECT u.name, 
                                            r.name role, p.*, p.created_at, e.especialidad
                                        FROM users u
                                        join persona p on p.id_user = u.id
                                        join roles r  on p.id_role = r.id
                                        join especialidad e on p.id_especialidad=e.id
                                        where r.id=4 and p.state=1 and e.state=1 $where
                                        order by p.paterno, p.materno, p.nombre");
        }
        $data->tipo = "I";

        $reporte = new ReportePacientes();
        $reporte->reporte($data);
    }

    public function reporteHtmlCantidadPaciente()
    {
        $desde = $_GET["desde"];
        $hasta = $_GET["hasta"];

        $where = "";


        $where .= ($desde == "") ? "" : " and '$desde'<=p.updated_at ";
        $where .= ($hasta == "") ? "" : " and '$hasta 23:59:59'>=p.updated_at ";

        $user = Auth::user();
        if ($user->hasRole('doctor') || $user->hasRole('secretaria')) {
            $resultado = \DB::select("SELECT e.id, e.especialidad, count(*) pacientes
            from persona p
            join especialidad e on p.id_especialidad= e.id
            where 1=1 and p.state=1 and e.state=1 and p.id_role=4 and p.id_especialidad=" . $user->persona->id_especialidad . " " . $where . "
            group by e.id, e.especialidad
            order by e.especialidad");
        } else {
            $resultado = \DB::select("SELECT e.id, e.especialidad, count(*) pacientes
            from persona p
            join especialidad e on p.id_especialidad= e.id
            where 1=1 and p.state=1 and e.state=1 and p.id_role=4 $where
            group by e.id, e.especialidad
            order by e.especialidad");
        }

        return view("reportes.reporte-html-cantidad-paciente")
            ->with("resultado", $resultado);
    }

    public function reporteCantidadPaciente()
    {
        $desde = $_GET["desde"];
        $hasta = $_GET["hasta"];

        $where = "";


        $where .= ($desde == "") ? "" : " and '$desde'<=p.updated_at ";
        $where .= ($hasta == "") ? "" : " and '$hasta 23:59:59'>=p.updated_at ";



        $data = (object) array();

        $user = Auth::user();
        if ($user->hasRole('doctor') || $user->hasRole('secretaria')) {
            $data->resultado = \DB::select("SELECT e.id, e.especialidad, count(*) pacientes
            from persona p
            join especialidad e on p.id_especialidad= e.id
            where 1=1 and p.state=1 and e.state=1 and p.id_role=4 and p.id_especialidad=" . $user->persona->id_especialidad . " " . $where . "
            group by e.id, e.especialidad
            order by e.especialidad");
        } else {
            $data->resultado = \DB::select("SELECT e.id, e.especialidad, count(*) pacientes
            from persona p
            join especialidad e on p.id_especialidad= e.id
            where 1=1 and p.state=1 and e.state=1 and p.id_role=4 $where
            group by e.id, e.especialidad
            order by e.especialidad");
        }



        $data->tipo = "I";

        $reporte = new ReporteCantidadPaciente();
        $reporte->reporte($data);
    }

    public function reporteCitaMedica()
    {

        $desde = $_GET["desde"];
        $hasta = $_GET["hasta"];


        if (auth()->user()->hasRole("administrador") || auth()->user()->hasRole("paciente")) {
            $id_especialidad = $_GET["id_especialidad"];
            $where = ($id_especialidad == "todos") ? "" : " and cm.id_especialidad=$id_especialidad ";
        } else {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
            $where = " and cm.id_especialidad=$id_especialidad ";
        }

        $where .= ($desde == "") ? "" : " and '$desde'<=cm.fecha_cita ";
        $where .= ($hasta == "") ? "" : " and '$hasta 23:59:59'>=cm.fecha_cita ";


        $data = (object) array();

        $data->resultado = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name, u.email, e.especialidad, cm.*, p.telefono
                                        FROM users u
                                        join persona p on u.id=p.id_user
                                        join cita_medica cm on p.id=cm.id_paciente
                                        join especialidad e on cm.id_especialidad=e.id
                                        where cm.state=1 $where
                                        order by cm.fecha_cita, p.paterno, p.materno, p.nombre");
        $data->tipo = "I";

        $reporte = new ReporteCitaMedica();
        $reporte->reporte($data);
    }


    public function reporteFactura()
    {

        $desde = $_GET["desde"];
        $hasta = $_GET["hasta"];
        $tipo_paciente = $_GET["tipo_paciente"];

        $res_factura = Factura::select("factura.*")
            ->join("especialidad", "especialidad.id", "=", "factura.id_especialidad")
            ->where("factura.state", 1);

        if (auth()->user()->hasRole("administrador") || auth()->user()->hasRole("paciente")) {
            $id_especialidad = $_GET["id_especialidad"];
            if ($id_especialidad != "todos") {
                $res_factura->where("factura.id_especialidad", $id_especialidad);
            }
        } else {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
            $res_factura->where("factura.id_especialidad", $id_especialidad);
        }

        if ($desde != "") {
            $res_factura->where("factura.fecha_factura", ">=", $desde);
        }
        if ($hasta != "") {
            $res_factura->where("factura.fecha_factura", "<=", $hasta);
        }

        if ($tipo_paciente != 'todos') {
            $res_factura->where("factura.tipo_paciente",  $tipo_paciente);
        }

        $res_factura->orderBy("especialidad.especialidad", "asc");
        $res_factura->orderBy("nro_factura", "asc");
        $res_factura = $res_factura->get();

        $data = (object) array();
        $data->resultado = $res_factura;

        $data->tipo = "I";
        $data->tipo_paciente = $tipo_paciente;
        $reporte = new ReporteFacturas();
        $reporte->reporte($data);
    }
}
