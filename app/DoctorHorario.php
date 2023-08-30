<?php

namespace App;

use App\Models\CitaMedica;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Model;

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
            ->where("dia_num", $dia_num)->get();

        $horarios = [];
        foreach ($doctor_horarios as $doctor_horario) {
            $nuevo_horario = [];
            $nuevo_horario = [
                "maniana" => [
                    "doctor_id" => $doctor_horario->user_id,
                    "hora" => $doctor_horario->tm_hora_ini,
                    "label" => "De " . date("H:i", strtotime($doctor_horario->tm_hora_ini)) . ' a ' . date("H:i", strtotime($doctor_horario->tm_hora_fin)) . " - Dr(a). " . $doctor_horario->nombre . ' ' . $doctor_horario->paterno . ' ' . $doctor_horario->materno,
                    "estado" => "DISPONIBLE",
                    "value" => $doctor_horario->user_id . '-' . $doctor_horario->tm_hora_ini
                ],
                "tarde" => [
                    "doctor_id" => $doctor_horario->user_id,
                    "hora" => $doctor_horario->tt_hora_ini,
                    "label" => "De " . date("H:i", strtotime($doctor_horario->tt_hora_ini)) . ' a ' . date("H:i", strtotime($doctor_horario->tt_hora_fin)) . " - Dr(a). " . $doctor_horario->nombre . ' ' . $doctor_horario->paterno . ' ' . $doctor_horario->materno,
                    "estado" => "DISPONIBLE",
                    "value" => $doctor_horario->user_id . '-' . $doctor_horario->tt_hora_ini
                ],
            ];

            // validar estado
            $existe_cita = CitaMedica::where("fecha_cita", $fecha)->where("hora", $nuevo_horario["maniana"]["hora"])->get()->first();
            if ($existe_cita) {
                $nuevo_horario["maniana"]["estado"] = "OCUPADO";
            }

            $existe_cita = CitaMedica::where("fecha_cita", $fecha)->where("hora", $nuevo_horario["tarde"]["hora"])->get()->first();
            if ($existe_cita) {
                $nuevo_horario["tarde"]["estado"] = "OCUPADO";
            }

            $horarios[] = $nuevo_horario;
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
    }

    public function user()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }
}
