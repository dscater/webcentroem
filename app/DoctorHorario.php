<?php

namespace App;

use App\Models\CitaMedica;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class DoctorHorario extends Model
{
    protected $fillable = [
        "user_id", "dia", "dia_num", "estado",
        "tm_hora_ini", "tm_hora_fin", "tt_hora_ini",
        "tt_hora_fin",
    ];

    public static function getHorariosFecha($especialidad_id, $fecha)
    {
        $dia_num = date("w", strtotime($fecha));
        $doctor_horarios = DoctorHorario::select("doctor_horarios.*", "persona.nombre", "persona.paterno", "persona.materno")
            ->join("users", "users.id", "=", "doctor_horarios.user_id")
            ->join("persona", "persona.id_user", "=", "users.id")
            ->where("id_especialidad", $especialidad_id)
            ->where("estado", "ACTIVO")
            ->where("dia_num", $dia_num)->get();

        $horarios = [];
        foreach ($doctor_horarios as $doctor_horario) {
            // VALIDAR CALENDARIO FECHAS
            $existe_calendario = CalendarioAtencion::where("user_id", $doctor_horario->user_id)
                ->where("fecha_ini", "<=", $fecha)
                ->where("fecha_fin", ">=", $fecha)->get()->first();
            if (!$existe_calendario) {
                $nuevo_horario = [];
                $inicio_maniana = date("H:i", strtotime($doctor_horario->tm_hora_ini));
                $fin_maniana = date("H:i", strtotime($doctor_horario->tm_hora_fin));
                $inicio_tarde = date("H:i", strtotime($doctor_horario->tt_hora_ini));
                $fin_tarde = date("H:i", strtotime($doctor_horario->tt_hora_fin));

                // horario doctor
                $nuevo_horario = [
                    "nom_doctor" => "Dr(a). " . $doctor_horario->nombre . ' ' . $doctor_horario->paterno . ' ' . $doctor_horario->materno,
                    "maniana" => [],
                    "tarde" => [],
                ];

                // intervalo doctor 
                $intervalo = 15;
                $ih = IntervaloHorario::where("user_id", $doctor_horario->user_id)->get()->first();
                if ($ih) {
                    $intervalo = $ih->intervalo ? $ih->intervalo : 15;
                }

                // horarios doctor
                // turno maniana
                if ($inicio_maniana != '00:00' && $fin_maniana != '00:00') {
                    $horario_generado = self::generarHorarios($inicio_maniana, $fin_maniana, $intervalo, $doctor_horario->user_id, $fecha);
                    $nuevo_horario["maniana"] = $horario_generado;
                }
                // turno tarde
                if ($inicio_tarde != '00:00' && $fin_tarde != '00:00') {
                    $horario_generado = self::generarHorarios($inicio_tarde, $fin_tarde, $intervalo, $doctor_horario->user_id, $fecha);
                    $nuevo_horario["tarde"] = $horario_generado;
                }
                $horarios[] = $nuevo_horario;
            }
        }

        return $horarios;
    }

    static function generarHorarios($intervaloInicio, $intervaloFin, $paso, $id_doctor, $fecha)
    {
        $horarios = [];
        list($inicioHora, $inicioMinuto) = explode(':', $intervaloInicio);
        list($finHora, $finMinuto) = explode(':', $intervaloFin);
        $pasoMinutos = (int)$paso;

        $horaActual = (int)$inicioHora;
        $minutoActual = (int)$inicioMinuto;
        $nueva_hora = sprintf('%02d:%02d', $horaActual, $minutoActual);
        $estado = "DISPONIBLE";
        // validar estado
        $id_paciente = 0;
        $existe_cita = CitaMedica::where("fecha_cita", $fecha)
            ->where("hora", $nueva_hora)
            ->where("id_doctor", $id_doctor)
            ->where("estado", "PENDIENTE")
            ->get()->first();
        if ($existe_cita) {
            $estado = "OCUPADO";
            $id_paciente = $existe_cita->id_paciente;
        }

        $horarios[] = [
            "value" => $id_doctor . '-' . $nueva_hora,
            "hora" => $nueva_hora,
            "estado" => $estado,
            "id_paciente" => $id_paciente
        ];
        while ($horaActual < $finHora || ($horaActual === $finHora && $minutoActual <= $finMinuto)) {
            $minutoActual += $pasoMinutos;
            if ($minutoActual >= 60) {
                $minutoActual -= 60;
                $horaActual += 1;
            }
            $nueva_hora = sprintf('%02d:%02d', $horaActual, $minutoActual);
            $estado = "DISPONIBLE";
            // validar estado
            $existe_cita = CitaMedica::where("fecha_cita", $fecha)
                ->where("hora", $nueva_hora)
                ->where("id_doctor", $id_doctor)
                ->where("estado", "PENDIENTE")
                ->get()->first();
            if ($existe_cita) {
                $estado = "OCUPADO";
                $id_paciente = $existe_cita->id_paciente;
            }

            $horarios[] = [
                "value" => $id_doctor . '-' . $nueva_hora,
                "hora" => $nueva_hora,
                "estado" => $estado,
                "id_paciente" => $id_paciente
            ];
        }

        return $horarios;
    }

    public static function verificaHorarios(Usuario $usuario)
    {
        $array_dias_txt = ["DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES"];
        $dias = [1, 2, 3, 4, 5]; //lunes,martes,miercoles,jueves
        foreach ($dias as $d) {
            $existe_horario = DoctorHorario::where("user_id", $usuario->id)
                ->where("dia_num", $d)
                ->get()->first();
            if (!$existe_horario) {
                DoctorHorario::create([
                    "user_id" => $usuario->id,
                    "dia" => $array_dias_txt[$d],
                    "dia_num" => $d,
                    "estado" => "ACTIVO",
                    "tm_hora_ini" => "08:00:00",
                    "tm_hora_fin" => "12:00:00",
                    "tt_hora_ini" => "14:00:00",
                    "tt_hora_fin" => "18:00:00",
                ]);
            }
        }
        self::verificaIntervaloHorario($usuario);
    }

    public static function verificaIntervaloHorario(Usuario $usuario)
    {
        $existe_intervalo = IntervaloHorario::where("user_id", $usuario->id)->get()->first();
        if (!$existe_intervalo) {
            IntervaloHorario::create([
                "user_id" => $usuario->id,
                "intervalo" => 15,
            ]);
        }
        return $existe_intervalo;
    }

    public function user()
    {
        return $this->belongsTo(Models\Usuario::class, 'user_id');
    }
}
