<?php namespace App\Http\Controllers;

use DB;
use Response;

class EiaPermitSearchController extends Controller
{
    // GET /resource/:id/subresource
    public function index()
    {
//        DB::enableQueryLog();
        $result = DB::table('eias_permits as ep')
            ->join('projects as p', 'ep.project_id', '=', 'p.id')
            ->join('organisations as o', 'p.organisation_id', '=', 'o.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('districts as d', 'p.district_id', '=', 'd.id')
            ->leftJoin('users as u', 'ep.user_id', '=', 'u.id')
            ->leftJoin('codes as status', 'ep.status', '=', 'status.id')
            ->leftJoin('eias_permits_personnel as personnel', 'ep.id', '=', 'personnel.eia_permit_id')
            ->leftJoin('documents as doc', 'ep.id', '=', 'doc.eia_permit_id')
            ->leftJoin('practitioners', 'ep.teamleader_id', '=', 'practitioners.id')
            ->leftJoin('codes as cost_currency', 'ep.cost_currency', '=', 'cost_currency.id')
            ->leftJoin('users as team_leader', 'ep.user_id', '=', 'team_leader.id')
            ->leftJoin('eias_permits_personnel as ep_personnel', 'ep.id', '=', 'ep_personnel.eia_permit_id')
            ->leftJoin('users as handle_officers', 'handle_officers.id', '=', 'ep_personnel.user_id')
            ->leftJoin('codes as inspection_recommendation_list', 'inspection_recommendation_list.id', '=', 'ep.inspection_recommended')
            ->leftJoin('codes as decision_list', 'decision_list.id', '=', 'ep.decision')
            ->leftJoin('users as designation_list', 'designation_list.id', '=', 'ep.designation')
            ->leftJoin('documents', 'documents.eia_permit_id', '=', 'ep.id')
            ->select(
                'ep.id as eiapermit_id',
                'ep.date_inspection as eiapermit_date_inspection',
                'ep.fee as eiapermit_fee',
                'ep.date_fee_payed as eiapermit_date_fee_payed',
                'ep.fee_receipt_no as eiapermit_fee_receipt_no',
                'ep.date_certificate as eiapermit_date_certificate',
                'ep.date_cancelled as eiapermit_date_cancelled',
                'ep.remarks as eiapermit_remarks',
                'decision_list.description1 as eiapermit_decision',
                'designation_list.name as eiapermit_designation',
                'ep.date_decision as eiapermit_date_decision',
                'ep.date_fee_notification as eiapermit_date_fee_notification',
                'ep.expected_jobs_created as eiapermit_expected_jobs_created',
                'ep.date_sent_ded_approval as eiapermit_date_sent_ded_approval',
                'p.id as project_id',
                'status.description1 as eiapermit_status',
                'u.name as eiapermit_officer_assigned',
                'p.title as project_title',
                'ep.certificate_no as eiapermit_certificate_no',
                'practitioners.person as practitioner_teamleader',
                'ep.cost as cost',
                'cost_currency.description1 as eiapermit_cost_currency',
                'team_leader.name as team_leader_name',
                DB::raw('GROUP_CONCAT(DISTINCT handle_officers.name) as personnel_officers_name'),
                DB::raw('GROUP_CONCAT(DISTINCT documents.code) as document_codes'),
                'inspection_recommendation_list.description1 as eias_permits_inspection_recommendation',
                'o.id as developer_id',
                'o.name as developer_name',
                'd.district as district_district',
                'p.category_id as project_category_id',
                'c.description_short as category_description'

//                ,'doc.title'
                //                ,'doc.code'
                //                ,'doc.number'
                // ,'doc.date_submitted'
            )
            ->whereNull('ep.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereNull('u.deleted_at')
            ->whereNull('o.deleted_at')
            ->groupBy('eiapermit_id');

        $criteriaDefinitions = array();
        $criteriaDefinitions["search"] = ["ep.certificate_no", "doc.title"];
        $criteriaDefinitions["exact"] = ["ep.id", "doc.type"];
        $criteriaDefinitions["multiple_text"] = [];
        $criteriaDefinitions["multiple"] = ["ep.status", "c.id"];
        $criteriaDefinitions["alias"] = ["personnel.user_id", "o.name", "p.title", "doc.code"];
        $criteriaDefinitions["special"] = ["doc.year", "ep.date_submission_from", "ep.date_submission_to"];

        $criterias = getSearchCriterias([
            'project_title',
            'eiapermit_year',
            'eiapermit_certificate_no',
            'eiapermit_date_submission_from',
            'eiapermit_date_submission_to',
            'category_id',
            'developer_name',
            'personnel_user_id',
            'eiapermit_status',
            'eiapermit_id',
            'document_code',
            'document_type',
            'document_title',
            'document_year',
        ]);

        foreach ($criterias as $word => $criteria) {
            $word = str_replace('project_', 'p.', $word);
            $word = str_replace('eiapermit_', 'ep.', $word);
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
                            ->whereIn("ep.user_id", [$criteria], 'or');
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
                } elseif ($word === "ep.date_submission_from") {
                    $result = $result->where("doc.date_submitted", '>=', [$criteria]);
                } elseif ($word === "ep.date_submission_to") {
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
