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
            ->leftJoin('codes as performance_level', 'ai.performance_level', '=', 'performance_level.id')
            ->leftJoin('codes as status', 'ai.status', '=', 'status.id')
            ->leftJoin('audits_inspections_personnel as personnel', 'ai.id', '=', 'personnel.audit_inspection_id')
            ->select('ai.id as auditinspection_id',
                'ai.code as auditinspection_code',
                'ai_type.description1 as auditinspection_type',
                'action_taken.description1 as auditinspection_action_taken',
                'ai.date_deadline as auditinspection_date_deadline',
                'p.id as project_id',
                'p.title as project_title',
                'performance_level.description1 as auditinspection_performance_level',
                'o.name as developer_name',
                'd.district as district_district',
                'c.description_short as category_description')
            ->whereNull('ai.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereNull('o.deleted_at');

        $criteriaDefinitions = array();
        $criteriaDefinitions["search"] = ["p.title", "o.name", "ai.code"];
        $criteriaDefinitions["exact"] = [];
        $criteriaDefinitions["multiple_text"] = ["ai.year"];
        $criteriaDefinitions["multiple"] = ["d.id", "ai.action_taken", "c.id", "ai.type", "ai.status", "ai.performance_level"];
        $criteriaDefinitions["alias"] = ["personnel.user_id"];

        $criterias = getSearchCriterias([
            'project_title',
            'auditinspection_year',
            'district_id',
            'auditinspection_action_taken',
            'category_id',
            'developer_name',
            'auditinspection_code',
            'auditinspection_type',
            'personnel_user_id',
            'auditinspection_status',
            'auditinspection_performance_level'
        ]);

//        if (array_key_exists('personnel_user_id', $criterias))
//        {
////            $criterias['auditinspection_'] = $criterias['personnel_user_id'];
//        }

        foreach ($criterias as $word => $criteria)
        {
            $word = str_replace('project_', 'p.', $word);
            $word = str_replace('auditinspection_', 'ai.', $word);
            $word = str_replace('district_', 'd.', $word);
            $word = str_replace('category_', 'c.', $word);
            $word = str_replace('developer_', 'o.', $word);
            $word = str_replace('personnel_', 'personnel.', $word);

            if (in_array($word, $criteriaDefinitions["search"]))
            {
                $result = $result->where($word, 'like', '%' . $criteria . '%');
            }

            elseif (in_array($word, $criteriaDefinitions["multiple_text"]))
            {
                $criteriaArray = explode(",", $criteria);
                $result = $result->whereIn($word, $criteriaArray);
            }
            elseif (in_array($word, $criteriaDefinitions["multiple"]))
            {
                $result = $result->whereIn($word, [$criteria]);
            }
            elseif (in_array($word, $criteriaDefinitions["exact"]))
            {
                $result = $result->where($word, '=', $criteria);
            }
            // Need to handle aliases special.
            elseif (in_array($word, $criteriaDefinitions["alias"]))
            {
                if ($word === "personnel.user_id")
                {
                    $result = $result->where(function ($query) use ($word, $criteria)
                    {
                        $query->whereIn($word, [$criteria])
                            ->whereIn("ai.lead_officer", [$criteria], 'or');
                    });
                }
            }
        }

        // Need to have distinct because of leftJoin with audits_inspections_personnel.
        $result = $result->distinct();
        $result = $result->get();

        return Response::json($result, 200);
    }
}