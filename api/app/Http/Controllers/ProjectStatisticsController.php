<?php namespace App\Http\Controllers;

use Response;
use DB;
use \App\Project;
use \App\Category;

class ProjectStatisticsController extends Controller
{
// GET /resource/:id/subresource
    public function index()
    {
        $data = [];

        $countProjects = DB::table('projects')->count();
        $countDevelopers = DB::table('organisations')->count();

        $data["counts"] = [
            "projects" => $countProjects,
            "developers" => $countDevelopers
        ];


        $categoriesConsideredForEia = DB::table('categories')->where('consequence', 6)->get();
        $categoriesLikelyExemptedFromEia = DB::table('categories')->where('consequence', 7)->get();

        $result = DB::table('categories as c')
            ->leftJoin('projects as p', 'c.id', '=', 'p.category_id')
            ->select('c.id', 'c.description_long as description', 'c.consequence', DB::raw('COUNT(p.id) as count'))
            ->groupBy('c.id')
            ->orderByRaw('COUNT(p.id) desc, c.description_long asc')
            ->get();
        $data["categoryEiaYes"] = [];
        $data["categoryEiaNo"] = [];
        foreach ($result as $row)
        {
            $key = "categoryEiaNo";
            if ($row->consequence == 6)
            {
                $key = "categoryEiaYes";
            }
            unset($row->consequence);
            $data[$key] [] = $row;
        }

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


        $result = $result->get();

        return Response::json($result, 200);
    }
}