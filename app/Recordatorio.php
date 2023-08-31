<?php

namespace App;

use App\Models\CitaMedica;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Recordatorio extends Model
{
    protected $fillable = [
        "fecha"
    ];

    public static function enviaRecordatorios()
    {
        Log::debug("enviara");
        $hoy = date("Y-m-d");
        $existe = Recordatorio::where("fecha", $hoy)->get()->first();
        if (!$existe) {
            $fecha_actual = date("Y-m-d");
            $fecha_dia_despues = date("Y-m-d", strtotime($fecha_actual . '+1 days'));
            $citas = CitaMedica::where("fecha_cita", $fecha_dia_despues)->where("state", 1)->get();

            foreach ($citas as $cita) {
                // Log::debug("aa");
                $persona_telegrams = PersonaTelegram::where("persona_id", $cita->id_paciente)->get();
                foreach ($persona_telegrams as $pt) {
                    $mensaje = "Hola " . $pt->persona->nombre . ($pt->persona->paterno && $pt->persona->paterno != '' && $pt->persona->paterno != null ? ' ' . $pt->persona->paterno : '') . ($pt->persona->materno && $pt->persona->materno != '' && $pt->persona->materno != null ? ' ' . $pt->persona->materno : '' . ".");
                    $mensaje .= "\nTe envío este mensaje para recordarte que el día de mañana tienes una cita médica:";
                    $especialidad = DB::select("SELECT * FROM especialidad WHERE id = $cita->id_especialidad")[0];
                    $mensaje .= "\n<b>Especialidad:</b> " . $especialidad->especialidad;
                    $mensaje .= "\n<b>Fecha:</b> " . date("d/m/Y", strtotime($cita->fecha_cita));
                    $mensaje .= "\n<b>Hora:</b> " . date("H:i a", strtotime($cita->hora));
                    $datos = array(
                        'chat_id' => $pt->chat_id,
                        'text' => $mensaje,
                        'parse_mode' => 'HTML'
                    );
                    BotTelegram::send("sendMessage", $datos);
                }
            }
            Recordatorio::create([
                "fecha" => $hoy
            ]);
        }
        return true;
    }
}
