<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScheduleWorkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the schedule worker';

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
        $this->info("Shedule worker  started successfully.");

        while (true) {
            $this->info("Shedule worker  started successfully. [". date("H:i:s")."]");
            if (now()->second === 0) {
                $this->call('schedule:run');
            }
            sleep(1);
        }
    }
}
