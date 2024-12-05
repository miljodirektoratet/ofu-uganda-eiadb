<?php namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use Response;
use DB;
use Input;

class ExportMapController extends Controller
{
// GET /resource/:id/subresource
    public function exportMap()
    {
//        DB::enableQueryLog();

        $result = DB::table('projects as p')
            ->join('organisations as o', 'p.organisation_id', '=', 'o.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('districts as d', 'p.district_id', '=', 'd.id')
            ->select('p.id as project_id',
                'p.title as project_name',
                'p.district_id as district_id',
                'd.district as district_name',
                'p.category_id as category_id',
                'c.description_long as category_description',
                'p.longitude as longitude',
                'p.latitude as latitude',
                'o.name as organisation_name'
            )
            ->whereNull('p.deleted_at')
            ->whereNull('o.deleted_at');

        $result = $result->get();

//        dd(DB::getQueryLog());

        return Response::json($result, 200);
    }
}