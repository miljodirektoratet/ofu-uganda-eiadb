<?php namespace App\Console;

use App\AuditInspection;
use DB;
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
        'App\Console\Commands\Inspire',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function ()
        {
            $this->setDeadlinePassedStatus();
        })->everyTenMinutes();
    }

    private function setDeadlinePassedStatus()
    {
        // 73 = Deadline passed
        AuditInspection::where('date_deadline', '<', date('Y-m-d'))
            ->where('status', '<', 73)
            ->where('status', '!=', 73)
            ->update(['status' => 73]);
    }
}

