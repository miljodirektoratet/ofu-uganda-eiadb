<?php namespace App\Http\Controllers;

use DB;
use Response;

class ExternalAuditSearchController extends Controller
{
    // GET /resource/:id/subresource
    public function index()
    {
//        DB::enableQueryLog();

        $result = DB::table('external_audits as ea')
            ->join('projects as p', 'ea.project_id', '=', 'p.id')
            ->join('organisations as o', 'p.organisation_id', '=', 'o.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('districts as d', 'p.district_id', '=', 'd.id')
            ->leftJoin('users as u', 'ea.user_id', '=', 'u.id')
            ->leftJoin('codes as status', 'ea.status', '=', 'status.id')
            ->leftJoin('external_audits_personnel as personnel', 'ea.id', '=', 'personnel.external_audit_id')
            ->leftJoin('documents as doc', 'ea.id', '=', 'doc.external_audit_id')
            ->leftJoin('users as handling_officer_list', 'handling_officer_list.id', '=', 'personnel.user_id')
            ->leftJoin(
                'codes as verification_inspection_list',
                'verification_inspection_list.id',
                '=',
                'ea.verification_inspection'
            )
            ->leftJoin('codes as ea_type_list', 'ea_type_list.id', '=', 'ea.type')
            ->leftJoin('codes as response_list', 'response_list.id', '=', 'ea.response')
            ->select(
                'ea.id as externalaudit_id',
                'p.id as project_id',
                'ea_type_list.description1 as ea_type',
                'u.name as team_leader',
                'status.description1 as externalaudit_status',
                'u.name as externalaudit_officer_assigned',
                'p.title as project_title',
                DB::raw('GROUP_CONCAT(DISTINCT handling_officer_list.name) as handling_officers'),
                'verification_inspection_list.description1 as verification_inspection',
                'ea.date_inspection as date_inspection',
                "ea.date_response as date_response",
                DB::raw('if(ea.file_metadata_response_id, "Yes", "No") as file_metadata_response_id'),
                "ea.date_deadline_compliance as date_deadline_compliance",
                "ea.review_findings as review_findings",
                "response_list.description1 as response",
                DB::raw('GROUP_CONCAT(DISTINCT doc.code) as doc_code'),
                'p.title as project_project_name',
                'o.name as organisation_name',
                'o.id as organisation_id',
                'd.district as district_district',
                'c.description_short as category_name',
                'ea.date_invoice_payment as date_invoice_payment',
                'ea.date_invoice_receipt_issued as date_invoice_receipt_issued',
                'ea.date_create_invoice as date_create_invoice'
                // , 'doc.title'
                //                ,'doc.code'
                //                ,'doc.number'
                //  ,'doc.date_submitted'
            )
            ->whereNull('ea.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereNull('u.deleted_at')
            ->whereNull('o.deleted_at')
            ->groupBy('externalaudit_id');

        $criteriaDefinitions = array();
        $criteriaDefinitions["search"] = ["doc.title"];
        $criteriaDefinitions["exact"] = ["ea.id", "doc.type"];
        $criteriaDefinitions["multiple_text"] = [];
        $criteriaDefinitions["multiple"] = ["ea.status", "c.id"];
        $criteriaDefinitions["alias"] = ["personnel.user_id", "o.name", "p.title", "doc.code"];
        $criteriaDefinitions["special"] = ["doc.year", "ea.date_submission_from", "ea.date_submission_to"];

        $criterias = getSearchCriterias([
            'project_title',
            'externalaudit_year',
            'externalaudit_date_submission_from',
            'externalaudit_date_submission_to',
            'category_id',
            'developer_name',
            'personnel_user_id',
            'externalaudit_status',
            'externalaudit_id',
            'document_code',
            'document_type',
            'document_title',
            'document_year',
        ]);

        foreach ($criterias as $word => $criteria) {
            $word = str_replace('project_', 'p.', $word);
            $word = str_replace('externalaudit_', 'ea.', $word);
            $word = str_replace('district_', 'd.', $word);
            $word = str_replace('category_', 'c.', $word);
            $word = str_replace('developer_', 'o.', $word);
            $word = str_replace('personnel_', 'personnel.', $word);
            $word = str_replace('document_', 'doc.', $word);

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
                            ->whereIn("ea.user_id", [$criteria], 'or');
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
                } elseif ($word === "doc.code") {
                    $result = $result->where(function ($query) use ($word, $criteria) {
                        $query->where($word, '=', $criteria)
                            ->orWhere("doc.number", '=', $criteria);
                    });
                }
            } elseif (in_array($word, $criteriaDefinitions["special"])) {
                if ($word === "doc.year") {
                    $result = $result->whereRaw("YEAR(doc.date_submitted)=?", [$criteria]);
                } elseif ($word === "ea.date_submission_from") {
                    $result = $result->where("doc.date_submitted", '>=', [$criteria]);
                } elseif ($word === "ea.date_submission_to") {
                    $result = $result->where("doc.date_submitted", '<=', [$criteria]);
                }
            }
        }

        // Need to have distinct because of leftJoin with audits_inspections_personnel.
        $result = $result->distinct();
        $result = $result->get();

//        dd(DB::getQueryLog());

        return Response::json($result, 200);
    }
}
