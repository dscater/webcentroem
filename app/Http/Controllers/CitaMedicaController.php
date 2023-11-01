<?php

namespace App\Http\Controllers;

use App\BotTelegram;
use App\DoctorHorario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Reportes\ReporteSeguimiento;
use App\Http\Controllers\Reportes\ReporteReceta;

use App\Helpers\FuncionesComunes;

use App\Models\Usuario;
use App\Models\Persona;
use App\Models\CitaMedica;
use App\PersonaTelegram;
use App\Recordatorio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;

class CitaMedicaController extends Controller
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
        Recordatorio::enviaRecordatorios();
        CitaMedica::citasNoAtendidas();
        $where = "";

        if (auth()->user()->hasRole("administrador")) {
        } else if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
            $where = " and cm.id_especialidad=$id_especialidad ";
        }
        // por paciente
        else {
            $where = " and u.id=" . auth()->user()->id;
        }

        $cita_medica = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name, u.email, e.especialidad, cm.*
                        FROM users u
                        join persona p on u.id=p.id_user
                        join cita_medica cm on p.id=cm.id_paciente
                        join especialidad e on cm.id_especialidad=e.id
                        where cm.state=1
                        $where
                        order by cm.fecha_cita, cm.hora");
        return view('cita_medica.listar')->with('cita_medica', $cita_medica);
    }

    public function buscarPorFecha($fecha)
    {
        $where = "";

        if (auth()->user()->hasRole("administrador")) {
        } else if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
            $where = " and cm.id_especialidad=$id_especialidad ";
        }
        // por paciente
        else {
            $where = " and u.id=" . auth()->user()->id;
        }

        $cita_medica = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name, u.email, e.especialidad, cm.*
                        FROM users u
                        join persona p on u.id=p.id_user
                        join cita_medica cm on p.id=cm.id_paciente
                        join especialidad e on cm.id_especialidad=e.id
                        where cm.state=1 and cm.fecha_cita='$fecha'
                        $where
                        order by cm.fecha_cita, cm.hora");
        return view('cita_medica.listar')->with('cita_medica', $cita_medica);
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

        $especialidad = \DB::select("SELECT * from especialidad where state=1");

        $date = date('Y-m-d');
        $fechas = [];
        for ($i = 0; $i < 7; $i++) {
            $fechas[] = (object) array();
            $fechas[$i]->fecha = date('Y-m-d', strtotime($date . '+ ' . $i . ' days'));
            $fechas[$i]->fecha_literal = FuncionesComunes::fecha_literal($fechas[$i]->fecha, 5);
        }

        return view('cita_medica.crear')
            ->with("paciente", $paciente)
            ->with("especialidad", $especialidad)
            ->with("fechas", $fechas);
    }

    public function store(Request $request)
    {
        $validacion = array('fecha_cita' => 'required', 'hora' => 'required');

        if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("administrador") || auth()->user()->hasRole("secretaria")) {
            $validacion["id_persona"] = "required";
        }

        if (auth()->user()->hasRole("administrador") || auth()->user()->hasRole("paciente")) {
            $validacion["id_especialidad"] = "required";
        }

        $validator = \Validator::make($request->all(), $validacion);

        if ($validator->fails()) {
            \Session::flash('mensaje', 'No se realizo la acción de registrar.');
            \Session::flash('class-alert', 'danger');
            return redirect('cita-medica-nuevo')
                ->withErrors($validator)
                ->withInput();
        }

        if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("administrador") || auth()->user()->hasRole("secretaria")) {
            $id_paciente = $request->id_persona;
        } else {
            $id_paciente = \DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id;
        }

        if (auth()->user()->hasRole("administrador") || auth()->user()->hasRole("paciente")) {
            $id_especialidad = $request->id_especialidad;
        } else {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
        }

        $existe = \DB::select("SELECT exists (select 1 from cita_medica 
                            where id_paciente=$id_paciente and fecha_cita='" . $request->fecha_cita . "') existe")[0]->existe;

        if ($existe) {
            \Session::flash('mensaje', 'Solo puede reservar una cita por dia');
            \Session::flash('class-alert', 'danger');
            return redirect('cita-medica-nuevo')
                ->withInput();
        }

        $array_hora = explode("-", $request->hora);
        $id_doctor = $array_hora[0];
        $hora = $array_hora[1];

        $s = new CitaMedica();
        $s->id_paciente = $id_paciente;
        $s->id_especialidad = $id_especialidad;
        $s->id_doctor = $id_doctor;
        $s->fecha_cita = $request->fecha_cita;
        $s->hora = $hora;
        $s->email_enviado = 0;
        $s->state = 1;

        $s->save();

        $fecha_hoy = date("Y-m-d");
        $maniana = date("Y-m-d", strtotime($fecha_hoy . '+1 days'));
        if ($s->fecha_cita == $maniana) {
            $persona_telegrams = PersonaTelegram::where("persona_id", $id_paciente)->get();
            foreach ($persona_telegrams as $pt) {
                $mensaje = "Hola " . $pt->persona->nombre . ($pt->persona->paterno && $pt->persona->paterno != '' && $pt->persona->paterno != null ? ' ' . $pt->persona->paterno : '') . ($pt->persona->materno && $pt->persona->materno != '' && $pt->persona->materno != null ? ' ' . $pt->persona->materno : '' . ".");
                $mensaje .= "\nTe envío este mensaje para recordarte que el día de mañana tienes una cita médica:";
                $especialidad = DB::select("SELECT * FROM especialidad WHERE id = $s->id_especialidad")[0];
                $mensaje .= "\n<b>Especialidad:</b> " . $especialidad->especialidad;
                $mensaje .= "\n<b>Fecha:</b> " . date("d/m/Y", strtotime($s->fecha_cita));
                $mensaje .= "\n<b>Hora:</b> " . date("H:i a", strtotime($s->hora));
                $datos = array(
                    'chat_id' => $pt->chat_id,
                    'text' => $mensaje,
                    'parse_mode' => 'HTML'
                );
                BotTelegram::send("sendMessage", $datos);
            }
        }

        \Session::flash('mensaje', 'Se registro correctamente.');
        \Session::flash('class-alert', 'success');

        if (!auth()->user()->hasRole("paciente")) {
            return redirect('cita-medica-modificar/' . $s->id);
        }
        return redirect('cita-medica-ver/' . $s->id);
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

        $especialidad = \DB::select("SELECT * from especialidad where state=1");
        $cita_medica = CitaMedica::find($id);

        $date = date('Y-m-d');
        $fechas = [];
        for ($i = 0; $i < 7; $i++) {
            $fechas[] = (object) array();
            $fechas[$i]->fecha = date('Y-m-d', strtotime($date . '+ ' . $i . ' days'));
            $fechas[$i]->fecha_literal = FuncionesComunes::fecha_literal($fechas[$i]->fecha, 5);
        }

        return view('cita_medica.editar')
            ->with("paciente", $paciente)
            ->with("especialidad", $especialidad)
            ->with("fechas", $fechas)
            ->with("cita_medica", $cita_medica);
    }

    public function update(Request $request, $id)
    {
        $validacion = array('fecha_cita' => 'required', 'hora' => 'required');

        if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("administrador") || auth()->user()->hasRole("secretaria")) {
            $validacion["id_persona"] = "required";
        }

        if (auth()->user()->hasRole("administrador") || auth()->user()->hasRole("paciente")) {
            $validacion["id_especialidad"] = "required";
        }

        $validator = \Validator::make($request->all(), $validacion);

        if ($validator->fails()) {
            \Session::flash('mensaje', 'No se realizo la acción de registrar.');
            \Session::flash('class-alert', 'danger');
            return redirect('cita-medica-modificar/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("administrador") || auth()->user()->hasRole("secretaria")) {
            $id_paciente = $request->id_persona;
        } else {
            $id_paciente = \DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id;
        }

        if (auth()->user()->hasRole("administrador") || auth()->user()->hasRole("paciente")) {
            $id_especialidad = $request->id_especialidad;
        } else {
            $id_especialidad = \DB::select("SELECT id_especialidad from persona where id_user=" . auth()->user()->id)[0]->id_especialidad;
        }

        $existe = \DB::select("SELECT exists (select 1 from cita_medica 
                            where id_paciente=$id_paciente and fecha_cita='" . $request->fecha_cita . "' and id!=$id) existe")[0]->existe;


        if ($existe) {
            \Session::flash('mensaje', 'Solo puede reservar una cita por dia');
            \Session::flash('class-alert', 'danger');
            return redirect('cita-medica-modificar/' . $id)
                ->withInput();
        }


        $array_hora = explode("-", $request->hora);
        $id_doctor = $array_hora[0];
        $hora = $array_hora[1];

        $s = CitaMedica::find($id);
        $s->id_paciente = $id_paciente;
        $s->id_doctor = $id_doctor;
        $s->id_especialidad = $id_especialidad;
        $s->fecha_cita = $request->fecha_cita;
        $s->hora = $hora;
        $s->email_enviado = 0;
        $s->state = 1;

        $s->save();


        \Session::flash('mensaje', 'Se registro correctamente.');
        \Session::flash('class-alert', 'success');

        if (!auth()->user()->hasRole("paciente")) {
            return redirect('cita-medica-modificar/' . $s->id);
        }
        return redirect('cita-medica-ver/' . $s->id);
    }

    public function show($id)
    {


        $cita_medica = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name, u.email, e.especialidad, cm.*
                                FROM users u
                                join persona p on u.id=p.id_user
                                join cita_medica cm on p.id=cm.id_paciente
                                join especialidad e on cm.id_especialidad=e.id
                                where cm.id=$id")[0];



        return view('cita_medica.ver')
            ->with("cita_medica", $cita_medica);
    }

    public function delete($id)
    {
        \DB::select("UPDATE cita_medica set state=0 where id=$id");
        \Session::flash('mensaje', 'Se elimino correctamente el registro.');
        \Session::flash('class-alert', 'success');

        return redirect('cita-medica-form-buscar');
    }

    public function atender($id)
    {
        \DB::select("UPDATE cita_medica set estado='ATENDIDO', updated_at='" . date("Y-m-d H:i:s") . "' where id=$id");
        \Session::flash('mensaje', 'El paciente fue atendido');
        \Session::flash('class-alert', 'success');

        return redirect('cita-medica-form-buscar');
    }

    public function getHorasByFecha($fecha, $id_especialidad)
    {
        if (auth()->user()->hasRole("doctor") || auth()->user()->hasRole("secretaria")) {
            $persona = Persona::find(\DB::select("SELECT id from persona where id_user=" . auth()->user()->id)[0]->id);
            $id_especialidad = $persona->id_especialidad;
        }
        $r = DoctorHorario::getHorariosFecha($id_especialidad, $fecha);
        return response()->json(["horas" => $r], 200);
    }

    public function enviarRecordatorio()
    {

        $schedule->call(function () {
            $fecha_actual = date('Y-m-d H:i:s');
            $fecha_24horas = date("Y-m-d H:i:s", strtotime('+24 hour', strtotime($fecha_actual)));
            $fecha_24horas = substr($fecha_24horas, 0, 13);
            $cita_medica = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, u.name, u.email, e.especialidad, cm.*
                                FROM users u
                                join persona p on u.id=p.id_user
                                join cita_medica cm on p.id=cm.id_paciente
                                join especialidad e on cm.id_especialidad=e.id
                                where (cm.email_enviado=0 and cm.state=1
                                and SUBSTRING(concat(fecha_cita,' ',hora),1,13)='$fecha_24horas') or 
                                (cm.email_enviado=0 and cm.state=1
                                and STR_TO_DATE(SUBSTRING(concat(fecha_cita,' ',hora),1,13),'%Y-%m-%d %H')<STR_TO_DATE('$fecha_24horas', '%Y-%m-%d %H'))");
            //la consulta ya esta
            //revisar el metodo schedule
            if (!empty($cita_medica)) {
                foreach ($cita_medica as $key => $value) {

                    $data = array("cita_medica" => $value);

                    \Mail::send('mails.recordatorio', $data, function ($message) use ($value) {
                        $message->from('webcentroem@gmail.com', 'WEBCENTROEM');
                        $message->to("ivanalfredomamaniochoa@gmail.com"); //$value->email
                        $message->subject("Recordatorio " . date("d-m-Y"));
                    });
                }
            }
        })->hourly();
    }
}
