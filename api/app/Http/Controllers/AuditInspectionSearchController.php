<?php namespace App\Http\Controllers;

use Response;
use DB;
use Input;

class AuditInspectionSearchController extends Controller
{
// GET /resource/:id/subresource
    public function index()
    {
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

        $criteriaDefinitions = array();
        $criteriaDefinitions["search"] = ["p.title"];
        $criteriaDefinitions["exact"] = ["ai.year"];
        $criteriaDefinitions["multiple"] = ["d.id"];
        $criterias = getSearchCriterias(['project_title', 'auditinspection_year', 'district_id']);

        foreach ($criterias as $word => $criteria)
        {
            $word = str_replace('project_', 'p.', $word);
            $word = str_replace('auditinspection_', 'ai.', $word);
            $word = str_replace('district_', 'd.', $word);

            if (in_array($word, $criteriaDefinitions["search"]))
            {
                $result = $result->where($word, 'like', '%' . $criteria . '%');
            }
            else if (in_array($word, $criteriaDefinitions["exact"]))
            {
                $result = $result->where($word, $criteria);
            }
            else if (in_array($word, $criteriaDefinitions["multiple"]))
            {
                $result = $result->whereIn($word, $criteria);
            }
        }

        //$result = $result->take(1);
        $result = $result->get();

        return Response::json($result, 200);
    }
}