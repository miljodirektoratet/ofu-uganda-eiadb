<?php namespace App\Http\Controllers;

use App\EiaPermit;
use App\ExternalAudit;
use App\PermitLicense;
use App\AuditInspection;
use Response;
use Auth;
use \DateTime;
use \App\Project;
use DB;
use Illuminate\Http\Request;

class PirkingController extends Controller
{

    // GET /resource
    public function getEiasPermits(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $result = DB::table('eias_permits as ep')
            ->join('projects as p', 'ep.project_id', '=', 'p.id')
            ->leftJoin('codes as status', 'ep.status', '=', 'status.id')
            ->select('ep.id as eiapermit_id',
                'p.id as project_id',
                'p.title as project_title',
                'status.id as status_id',
                'status.description1 as status_description',
            'ep.updated_at as eiapermit_updated_at')
            ->whereNull('ep.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereBetween('ep.id', [$from, $to]);

        $result = $result->get();

        return Response::json($result, 200);
    }

    public function getEiasPermitsStats(Request $request)
    {
        return Response::json(EiaPermit::latest()->first()->id, 200);
    }

    // GET /resource
    public function getExternalAudit(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $result = DB::table('external_audits as ea')
            ->join('projects as p', 'ea.project_id', '=', 'p.id')
            ->leftJoin('codes as status', 'ea.status', '=', 'status.id')
            ->select('ea.id as externalaudit_id',
                'p.id as project_id',
                'p.title as project_title',
                'status.id as status_id',
                'status.description1 as status_description',
            'ea.updated_at as externalaudit_updated_at')
            ->whereNull('ea.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereBetween('ea.id', [$from, $to]);

        $result = $result->get();

        return Response::json($result, 200);
    }

    public function getExternalAuditStats(Request $request)
    {
        return Response::json(ExternalAudit::latest()->first()->id, 200);
    }

    public function getAuditInspection(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $result = DB::table('audits_inspections as ai')
            ->join('projects as p', 'ai.project_id', '=', 'p.id')
            ->leftJoin('codes as status', 'ai.status', '=', 'status.id')
            ->select('ai.id as auditsInspections_id',
                'p.id as project_id',
                'p.title as project_title',
                'status.id as status_id',
                'status.description1 as status_description',
            'ai.updated_at as auditsInspections_updated_at')
            ->whereNull('ai.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereBetween('ai.id', [$from, $to]);

        $result = $result->get();

        return Response::json($result, 200);
    }

    public function getAuditInspectionStats(Request $request)
    {
        return Response::json(AuditInspection::latest()->first()->id, 200);
    }

    public function getPermitLicense(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $result = DB::table('permits_licenses as pl')
            ->join('projects as p', 'pl.project_id', '=', 'p.id')
            ->leftJoin('codes as status', 'pl.status', '=', 'status.id')
            ->select('pl.id as permitLicense_id',
                'p.id as project_id',
                'p.title as project_title',
                'status.id as status_id',
                'status.description1 as status_description',
            'pl.updated_at as permitLicense_updated_at')
            ->whereNull('pl.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereBetween('pl.id', [$from, $to]);

        $result = $result->get();

        return Response::json($result, 200);
    }

    public function getPermitLicenseStats(Request $request)
    {
        return Response::json(PermitLicense::latest()->first()->id, 200);
    }
    // GET /resource/:id
    public function show($id)
    {
        $project = Project::find($id);

        if (!$project)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        return Response::json($project, 200);
    }


    private function notAuthorized()
    {
        return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
    }
}