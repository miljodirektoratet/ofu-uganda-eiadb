<?php namespace App\Http\Controllers;

use Response;
use DB;
use Input;

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
            ->leftJoin('permits_licenses_personnel as personnel', 'pl.id', '=', 'personnel.permit_license_id')
            ->select('pl.id as permitlicense_id',
                'regulation.description1 as permitlicense_regulation',
                'p.id as project_id',
                'status.description1 as permitlicense_status',
                'u.name as permitlicense_officer_assigned',
                'p.title as project_title'
                ,'pl.date_submitted as permitlicense_date_submitted'
            )
            ->whereNull('pl.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereNull('u.deleted_at')
            ->whereNull('o.deleted_at');

        $criteriaDefinitions = array();
        $criteriaDefinitions["search"] = [];
        $criteriaDefinitions["exact"] = ["pl.id", "pl.application_number", "pl.permit_license_no"];
        $criteriaDefinitions["multiple_text"] = [];
        $criteriaDefinitions["multiple"] = ["pl.status", "c.id", "pl.regulation", "pl.waste_license_type", "pl.ecosystem", "pl.regulation_activity"];
        $criteriaDefinitions["alias"] = ["personnel.user_id", "o.name", "p.title"];
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
            'permitlicense_permit_license_no'
        ]);

        foreach ($criterias as $word => $criteria)
        {
            $word = str_replace('project_', 'p.', $word);
            $word = str_replace('permitlicense_', 'pl.', $word);
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
                            ->whereIn("pl.user_id", [$criteria], 'or');
                    });
                }
                elseif ($word === "o.name")
                {
                    $result = $result->where(function ($query) use ($word, $criteria)
                    {
                        $query->where($word, 'like', '%' . $criteria . '%')
                            ->orWhere("o.id", '=', $criteria)
                            ->orWhere("o.tin", '=', $criteria);
                    });
                }
                elseif ($word === "p.title")
                {
                    $result = $result->where(function ($query) use ($word, $criteria)
                    {
                        $query->where($word, 'like', '%' . $criteria . '%')
                            ->orWhere("p.id", '=', $criteria);
                    });
                }
            }
            elseif (in_array($word, $criteriaDefinitions["special"]))
            {
                if ($word === "pl.year")
                {
                    $result = $result->whereRaw("YEAR(pl.date_submitted)=?", [$criteria]);
                }
                elseif ($word === "pl.date_submission_from")
                {
                    $result = $result->where("pl.date_submitted", '>=', [$criteria]);
                }
                elseif ($word === "pl.date_submission_to")
                {
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