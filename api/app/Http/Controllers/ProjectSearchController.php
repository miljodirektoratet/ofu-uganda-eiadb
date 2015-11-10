<?php namespace App\Http\Controllers;

use Response;
use DB;
use Input;

class ProjectSearchController extends Controller
{
// GET /resource/:id/subresource
    public function index()
    {
        $result = DB::table('projects as p')
            ->join('organisations as o', 'p.organisation_id', '=', 'o.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('districts as d', 'p.district_id', '=', 'd.id')
            ->select('p.id as project_id',
                'p.title as project_title',
                'p.location as project_location',
                'o.name as developer_name',
                'd.district as district_district',
                'c.description_short as category_description')
            ->whereNull('p.deleted_at')
            ->whereNull('o.deleted_at');

        $criteriaDefinitions = array();
        $criteriaDefinitions["search"] = ["p.title", "o.name", "p.location"];
        $criteriaDefinitions["exact"] = [];
        $criteriaDefinitions["multiple_text"] = ["p.id"];
        $criteriaDefinitions["multiple"] = ["d.id", "c.id", "o.id", "p.has_industrial_waste_water"];
        $criterias = getSearchCriterias([
            'project_title',
            'district_id',
            'category_id',
            'developer_name',
            'project_location',
            'project_id',
            'developer_id',
            'project_has_industrial_waste_water'
        ]);

        foreach ($criterias as $word => $criteria)
        {
            $word = str_replace('project_', 'p.', $word);
            $word = str_replace('district_', 'd.', $word);
            $word = str_replace('category_', 'c.', $word);
            $word = str_replace('developer_', 'o.', $word);

            if (in_array($word, $criteriaDefinitions["search"]))
            {
                $result = $result->where($word, 'like', '%' . $criteria . '%');
            }
            else if (in_array($word, $criteriaDefinitions["multiple_text"]))
            {
                $criteriaArray = explode(",", $criteria);
                $result = $result->whereIn($word, $criteriaArray);
            }
            else if (in_array($word, $criteriaDefinitions["multiple"]))
            {
                $result = $result->whereIn($word, [$criteria]);
            }
            else if (in_array($word, $criteriaDefinitions["exact"]))
            {
                $result = $result->where($word, $criteria);
            }
        }

        $result = $result->orderBy('p.id', 'desc');
        $result = $result->get();

        return Response::json($result, 200);
    }
}