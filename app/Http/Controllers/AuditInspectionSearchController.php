<?php namespace App\Http\Controllers;

use DB;
use Response;

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
            ->leftJoin('codes as ai_reason', 'ai.reason', '=', 'ai_reason.id')
            ->leftJoin('codes as action_taken', 'ai.action_taken', '=', 'action_taken.id')
            ->leftJoin('codes as performance_level', 'ai.performance_level', '=', 'performance_level.id')
            ->leftJoin('codes as status', 'ai.status', '=', 'status.id')
            ->leftJoin('audits_inspections_personnel as personnel', 'ai.id', '=', 'personnel.audit_inspection_id')
            ->leftJoin('users as `lead_officer`', '`lead_officer`.id', '=', 'ai.lead_officer')
            ->leftJoin('users as other_personnel', 'other_personnel.id', '=', 'personnel.user_id')
            ->leftJoin('audits_inspections_lead_agencies as ai_lead_agency', 'ai.id', '=', 'ai_lead_agency.audit_inspection_id')
            ->leftJoin('lead_agencies as lead_agency', 'ai_lead_agency.lead_agency_id', '=', 'lead_agency.id')

            ->select(
                'ai.id as auditinspection_id',
                'ai.code as auditinspection_code',
                'ai.year as auditinspection_year',
                'ai.days as auditinspection_days',
                'ai.findings as auditinspection_findings',
                'ai.recommendations as auditinspection_recommendations',
                'ai.date_action_taken as auditinspection_date_action_taken',
                'ai.date_closing as auditinspection_date_closing',
                'ai.remarks as auditinspection_remarks',
                DB::raw('if(ai.coordinated, "Yes", "No") as auditinspection_coordinated'),
                'ai.external_participants as auditinspection_external_participants',
                'ai.date_carried_out as auditinspection_date_carried_out',
                'status.description1 as auditinspection_status',
                'ai_type.description1 as auditinspection_type',
                'ai_reason.description1 as auditinspection_reason',
                'action_taken.description1 as auditinspection_action_taken',
                'ai.date_deadline as auditinspection_date_deadline',
                DB::raw('if(ai.advance_notice, "Yes", "No") as auditinspection_advance_notice'),
                'p.id as project_id',
                'p.title as project_title',
                'performance_level.description1 as auditinspection_performance_level',
                DB::raw('CONCAT(o.name, " (id ", o.id, " )") AS developer_name'),
                'd.district as district_district',
                'c.description_short as category_description',
                'o.tin as developer_tin',
                '`lead_officer`.name as lead_officer_name',
                'o.id as organisation_id',
                DB::raw('GROUP_CONCAT(DISTINCT other_personnel.name) AS other_officer_name'),
                DB::raw('GROUP_CONCAT(DISTINCT lead_agency.long_name) AS lead_agency_name')
            )
            ->whereNull('ai.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereNull('o.deleted_at')
            ->groupBy('auditinspection_id');

        $criteriaDefinitions = array();
        $criteriaDefinitions["search"] = ["ai.code"];
        $criteriaDefinitions["exact"] = [];
        $criteriaDefinitions["multiple_text"] = ["ai.year"];
        $criteriaDefinitions["multiple"] = ["d.id", "ai.action_taken", "c.id", "ai.type", "ai.status", "ai.performance_level"];
        $criteriaDefinitions["alias"] = ["personnel.user_id", "o.name", "p.title"];

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
            'auditinspection_performance_level',
        ]);

        foreach ($criterias as $word => $criteria) {
            $word = str_replace('project_', 'p.', $word);
            $word = str_replace('auditinspection_', 'ai.', $word);
            $word = str_replace('district_', 'd.', $word);
            $word = str_replace('category_', 'c.', $word);
            $word = str_replace('developer_', 'o.', $word);
            $word = str_replace('personnel_', 'personnel.', $word);

            if (in_array($word, $criteriaDefinitions["search"])) {
                $result = $result->where($word, 'like', '%' . $criteria . '%');
            } elseif (in_array($word, $criteriaDefinitions["multiple_text"])) {
                $criteriaArray = explode(",", $criteria);
                $result = $result->whereIn($word, $criteriaArray);
            } elseif (in_array($word, $criteriaDefinitions["multiple"])) {
                $result = $result->whereIn($word, [$criteria]);
            } elseif (in_array($word, $criteriaDefinitions["exact"])) {
                $result = $result->where($word, '=', $criteria);
            }
            // Need to handle aliases special.
            elseif (in_array($word, $criteriaDefinitions["alias"])) {
                if ($word === "personnel.user_id") {
                    $result = $result->where(function ($query) use ($word, $criteria) {
                        $query->whereIn($word, [$criteria])
                            ->whereIn("ai.lead_officer", [$criteria], 'or');
                    });
                } elseif ($word === "o.name") {
                    $result = $result->where(function ($query) use ($word, $criteria) {
                        $query->where($word, 'like', '%' . $criteria . '%')
                            ->orWhere("o.id", '=', $criteria)
                        //->orWhere("o.tin", '=', $criteria);
                            ->orWhere(function ($query2) use ($criteria) {
                                $query2->where('o.tin', '>', 0)
                                    ->where('o.tin', '=', $criteria);
                            });
                    });
                } elseif ($word === "p.title") {
                    $result = $result->where(function ($query) use ($word, $criteria) {
                        $query->where($word, 'like', '%' . $criteria . '%')
                            ->orWhere("p.id", '=', $criteria);
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
