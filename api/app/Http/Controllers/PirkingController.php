<?php namespace App\Http\Controllers;

use App\EiaPermit;
use Response;
use Input;
use Auth;
use \DateTime;
use \App\Project;
use DB;

class PirkingController extends Controller
{

    // GET /resource
    public function getEiasPermits()
    {
        $from = Input::get('from');
        $to = Input::get('to');

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

    // GET /resource
    public function getExternalAudit()
    {
        $from = Input::get('from');
        $to = Input::get('to');

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