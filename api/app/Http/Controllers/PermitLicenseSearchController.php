<?php namespace App\Http\Controllers;

use DB;
use Response;

class PermitLicenseSearchController extends Controller
{
    // GET /resource/:id/subresource
    public function index()
    {
//        DB::enableQueryLog();

        $result = DB::table('permits_licenses as pl')
            ->join('projects as p', 'pl.project_id', '=', 'p.id')
            ->join('organisations as o', 'p.organisation_id', '=', 'o.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('districts as d', 'p.district_id', '=', 'd.id')
            ->leftJoin('users as u', 'pl.user_id', '=', 'u.id')
            ->leftJoin('codes as status', 'pl.status', '=', 'status.id')
            ->leftJoin('codes as regulation', 'pl.regulation', '=', 'regulation.id')
            ->leftJoin('codes as waste_license', 'pl.waste_license_type', '=', 'waste_license.id')
            ->leftJoin('codes as ecosystem', 'pl.ecosystem', '=', 'ecosystem.id')
            ->leftJoin('codes as regulation_activity', 'pl.regulation_activity', '=', 'regulation_activity.id')
            ->leftJoin('codes as unit', 'pl.unit', '=', 'unit.id')
            ->leftJoin('codes as inspection', 'pl.inspection_recommended', '=', 'inspection.id')
            ->leftJoin('permits_licenses_personnel as handling_officer', 'pl.id', '=', 'handling_officer.permit_license_id')
            ->leftJoin('users as handling_officer_users  ', 'handling_officer.user_id', '=', 'handling_officer_users.id')
            ->leftJoin('users as signature', 'signature.id', '=', 'pl.signature_on_permit_license')
            ->leftJoin('codes as decision', 'decision.id', '=', 'pl.decision')
            ->leftJoin('codes as evaluation_list', 'evaluation_list.id', '=', 'pl.application_evaluation_by_officer')
            ->leftJoin('permits_licenses_documentation as pld', 'pld.permit_license_id', '=', 'pl.id')
            ->leftJoin('file_metadata', 'file_metadata.id', '=', 'pld.file_metadata_id')
            ->select(
                'pl.id as permitlicense_id',
                'regulation.description1 as permitlicense_regulation',
                'p.id as project_id',
                'p.title as project_title',
                'pl.area as permitlicense_area',
                DB::raw('if(pl.approved_by_the_lc1, "Yes", "No") as permitlicense_approved_by_the_lc1'),
                DB::raw('if(pl.approved_by_the_dec, "Yes", "No") as permitlicense_approved_by_the_dec'),
                'pl.date_submitted as permitlicense_date_submitted',
                'pl.application_number as permitlicense_application_number',
                'pl.date_inspection as permitlicense_date_inspection',
                'pl.officer_recommend as permitlicense_officer_recommend',
                'pl.application_fee_receipt_number as permitlicense_application_fee_receipt_number',
                'pl.date_feedback_to_applicants as permitlicense_date_feedback_to_applicants',
                'pl.date_sent_to_director as permitlicense_date_sent_to_director',
                'pl.date_sent_from_dep as permitlicense_date_sent_from_dep',
                'pl.date_sent_officer as permitlicense_date_sent_officer',
                'pl.date_of_evaluation as permitlicense_date_of_evaluation',
                'pl.fee_receipt_no as permitlicense_fee_receipt_no',
                'pl.folio_no as permitlicense_folio_no',
                'pl.date_fee_payed as permitlicense_date_fee_payed',
                'pl.permit_license_no as permitlicense_permit_license_no',
                'pl.date_permit_license_expired as permitlicense_date_permit_license_expired',
                'pl.date_sent_to_ed_for_decision as permitlicense_date_sent_to_ed_for_decision',
                'pl.date_permit_license as permitlicense_date_permit_license',
                'signature.name as permitlicense_signature_on_permit_license',
                'decision.description1 as permitlicense_decision',
                'inspection.description1 as permitlicense_inspection_recommended',
                DB::raw('GROUP_CONCAT(DISTINCT handling_officer_users.name) as permitlicense_handling_officer'),
                DB::raw('GROUP_CONCAT(DISTINCT if(length(file_metadata.tag), file_metadata.tag, "No")) as permitlicense_documentation_files'),
                'evaluation_list.description1 as permitlicense_officer_evaluation',
                'status.description1 as permitlicense_status',
                'waste_license.description2 as permitlicense_waste_license_type',
                'ecosystem.description2 as permitlicense_ecosystem',
                'regulation_activity.description1 as permitlicense_regulation_activity',
                'unit.description1 as permitlicense_unit',
                'u.name as permitlicense_officer_assigned',
                'c.description_short as category_name',
                'd.district as district_district',
                'o.id as organisation_id',
                'o.name as organisation_name',
                'pl.date_feedback_to_applicants as permitlicense_date_feedback_to_applicants'
            )
            ->whereNull('pl.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereNull('u.deleted_at')
            ->whereNull('o.deleted_at')
            ->groupBy('permitlicense_id');

        $criteriaDefinitions = array();
        $criteriaDefinitions["search"] = [];
        $criteriaDefinitions["exact"] = ["pl.id", "pl.application_number", "pl.permit_license_no"];
        $criteriaDefinitions["multiple_text"] = [];
        $criteriaDefinitions["multiple"] = ["pl.status", "c.id", "pl.regulation", "pl.waste_license_type", "pl.ecosystem", "pl.regulation_activity"];
        $criteriaDefinitions["alias"] = ["handling_officer.user_id", "o.name", "p.title"];
        $criteriaDefinitions["special"] = ["pl.date_submission_from", "pl.date_submission_to"];
        $criterias = getSearchCriterias([
            'project_title',
            'permitlicense_date_submission_from',
            'permitlicense_date_submission_to',
            'category_id',
            'developer_name',
            'personnel_user_id',
            'permitlicense_status',
            'permitlicense_id',
            'permitlicense_regulation',
            'permitlicense_waste_license_type',
            'permitlicense_ecosystem',
            'permitlicense_regulation_activity',
            'permitlicense_application_number',
            'permitlicense_permit_license_no',
        ]);
        foreach ($criterias as $word => $criteria) {
            $word = str_replace('project_', 'p.', $word);
            $word = str_replace('permitlicense_', 'pl.', $word);
            $word = str_replace('district_', 'd.', $word);
            $word = str_replace('category_', 'c.', $word);
            $word = str_replace('developer_', 'o.', $word);
            $word = str_replace('personnel_', 'handling_officer.', $word);

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
                if ($word === "handling_officer.user_id") {
                    $result = $result->where(function ($query) use ($word, $criteria) {
                        $query->whereIn($word, [$criteria])
                            ->orWhereIn("pl.user_id", [$criteria]);
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
            } elseif (in_array($word, $criteriaDefinitions["special"])) {
                if ($word === "pl.year") {
                    $result = $result->whereRaw("YEAR(pl.date_submitted)=?", [$criteria]);
                } elseif ($word === "pl.date_submission_from") {
                    $result = $result->where("pl.date_submitted", '>=', [$criteria]);
                } elseif ($word === "pl.date_submission_to") {
                    $result = $result->where("pl.date_submitted", '<=', [$criteria]);
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
