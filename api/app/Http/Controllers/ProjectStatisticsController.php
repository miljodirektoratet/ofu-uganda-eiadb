<?php namespace App\Http\Controllers;

use Response;
use DB;
use Input;
use \App\Project;

class ProjectStatisticsController extends Controller
{
// GET /resource/:id/subresource
    public function index()
    {
        $data = [];
        $data["data1"] = ["test1", "test2"];
        $data["data2"] = ["test3" => "test4"];
        $data["count"] = Project::all()->count();

        return Response::json($data, 200);

        $result = DB::table('audits_inspections as ai')
            ->join('projects as p', 'ai.project_id', '=', 'p.id')
            ->join('organisations as o', 'p.organisation_id', '=', 'o.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('districts as d', 'p.district_id', '=', 'd.id')
            ->leftJoin('codes as ai_type', 'ai.type', '=', 'ai_type.id')
            ->leftJoin('codes as action_taken', 'ai.action_taken', '=', 'action_taken.id')
            ->leftJoin('codes as grade', 'p.grade', '=', 'grade.id')
            ->select('ai.id as auditinspection_id',
                'ai.code as auditinspection_code',
                'ai_type.description1 as auditinspection_type',
                'action_taken.description1 as auditinspection_action_taken',
                'ai.date_deadline as auditinspection_date_deadline',
                'p.id as project_id',
                'p.title as project_title',
                'grade.description1 as project_grade',
                'o.name as organisation_name',
                'd.district as district_district',
                'c.description_short as category_description');


        $result = $result->take(1);
        $result = $result->get();

        return Response::json($result, 200);
    }
}