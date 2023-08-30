<?php

namespace App\Console\Commands;

use App\BotTelegram;
use App\Models\CitaMedica;
use App\PersonaTelegram;
use App\Recordatorio;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnviaRecordatorios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'envia:recordatorios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia recordatorios de citas médicas a los pacientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Recordatorio::enviaRecordatorios();
    }
}
