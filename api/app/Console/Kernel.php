<?php namespace App\Console;

use App\AuditInspection;
use App\Organisation;
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
        'App\Console\Commands\EmailOrder',
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

        $schedule->call(function ()
        {
            $this->deleteOrganisationIslands();
        })->daily();
    }

    private function setDeadlinePassedStatus()
    {
        // 73 = Deadline passed
        AuditInspection::where('date_deadline', '<', date('Y-m-d'))
            ->where('status', '<', 73)
            ->where('status', '!=', 73)
            ->update(['status' => 73]);
    }

    private function deleteOrganisationIslands()
    {
        Organisation::where('deleted_at', '=', null)
            ->whereRaw('id not in (select p.organisation_id from projects p where p.deleted_at is null)')
            ->delete();
    }
}