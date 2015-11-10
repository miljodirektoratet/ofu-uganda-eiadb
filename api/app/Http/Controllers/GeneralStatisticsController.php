<?php namespace App\Http\Controllers;

use Response;
use DB;
use Carbon\Carbon;

class GeneralStatisticsController extends Controller
{
// GET /resource/:id/subresource
    public function index()
    {
        $data = [];

        // Intro.
        $countProjects = DB::table('projects')->whereNull('deleted_at')->count();
        $countDevelopers = DB::table('organisations')->whereNull('deleted_at')->count();
        $countPractitioners = DB::table('practitioners')->whereNull('deleted_at')->count();
        $countEiasPermits = DB::table('eias_permits')->whereNull('deleted_at')->count();
        $countAuditsInspections = DB::table('audits_inspections')->whereNull('deleted_at')->count();

        $dataCounts = [
            "projects" => $countProjects,
            "developers" => $countDevelopers,
            "practitioners" => $countPractitioners,
            "eiaspermits" => $countEiasPermits,
            "auditsinspections" => $countAuditsInspections
        ];

        $data["timestamp"] = Carbon::now()->toDateTimeString(); // Utc date. The rest is fixed in javascript.
        $data["counts"] = $dataCounts;

        return Response::json($data, 200);
    }

}