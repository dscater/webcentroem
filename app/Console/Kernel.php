<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ScheduleWorkCommand::class,
        Commands\EnviaRecordatorios::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            \DB::insert("INSERT into prueba (saludo) values('hola')");
            $fecha_actual = date('Y-m-d H:i:s');
            $fecha_24horas = date("Y-m-d H:i:s", strtotime('+24 hour', strtotime($fecha_actual)));
            $fecha_24horas = substr($fecha_24horas, 0, 13);
            $cita_medica = \DB::select("SELECT p.nombre, p.paterno, p.materno, p.ci, p.id id_persona, 
                                u.name, u.email, e.especialidad, cm.*
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
                    \DB::update("UPDATE cita_medica set email_enviado=1 where id={$value->id}");
                    \Mail::send('mails.recordatorio', $data, function ($message) use ($value) {
                        $message->from($value->email, 'WEBCENTROEM');
                        $message->to($value->email); //$value->email
                        $message->subject("Recordatorio " . date("d-m-Y"));
                    });
                }
            }
        })->everyMinute();

        $schedule->command("envia:recordatorios")->cron('* * * * *');
        // $schedule->command("envia:recordatorios")->cron('* * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
