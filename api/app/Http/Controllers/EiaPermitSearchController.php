<?php namespace App\Http\Controllers;

use Response;
use DB;
use Input;

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
            ->select('ep.id as eiapermit_id',
                'p.id as project_id',
                'status.description1 as eiapermit_status',
                'u.name as eiapermit_officer_assigned',
                'p.title as project_title',
                'ep.certificate_no as eiapermit_certificate_no'
//                ,'doc.title'
//                ,'doc.code'
//                ,'doc.number'
            )
            ->whereNull('ep.deleted_at')
            ->whereNull('p.deleted_at')
            ->whereNull('u.deleted_at')
            ->whereNull('o.deleted_at');

        $criteriaDefinitions = array();
        $criteriaDefinitions["search"] = ["ep.certificate_no", "doc.title"];
        $criteriaDefinitions["exact"] = ["ep.id"];
        $criteriaDefinitions["multiple_text"] = []; // "ep.year"
        $criteriaDefinitions["multiple"] = ["ep.status"];
        $criteriaDefinitions["alias"] = ["personnel.user_id", "o.name", "p.title", "doc.code"];

        $criterias = getSearchCriterias([
            'project_title',
            'eiapermit_year',
            'eiapermit_certificate_no',
            'category_id',
            'developer_name',
            'personnel_user_id',
            'eiapermit_status',
            'eiapermit_id',
            'document_code',
            'document_title'
        ]);

        foreach ($criterias as $word => $criteria)
        {
            $word = str_replace('project_', 'p.', $word);
            $word = str_replace('eiapermit_', 'ep.', $word);
            $word = str_replace('district_', 'd.', $word);
            $word = str_replace('category_', 'c.', $word);
            $word = str_replace('developer_', 'o.', $word);
            $word = str_replace('personnel_', 'personnel.', $word);
            $word = str_replace('document_', 'doc.', $word);

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
                            ->whereIn("ep.user_id", [$criteria], 'or');
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
                elseif ($word === "doc.code")
                {
                    $result = $result->where(function ($query) use ($word, $criteria)
                    {
                        $query->where($word, '=', $criteria)
                            ->orWhere("doc.number", '=', $criteria);
                    });
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