<?php

namespace App\Http\Controllers\Migration;

// use Response;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use \App\Project;
use \App\District;
use \App\User;
use \App\Organisation;
use \App\Code;
use \App\Category;
use Barryvdh\Reflection\DocBlock\Type\Collection;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{

    // GET /projects
    public function projectsAPI()
    {
        $accessKey = config('app.migration_key');
        $providedKey =  request()->get('key');
        if ($accessKey !== $providedKey) {
            return Response::json(array('error' => true, 'message' => 'Forbidden'), 403);
        }

        $perPage = request()->get('per_page', 100);
        $projects = $this->projectsModel()
            ->paginate($perPage);

        return [
            'error' => false,
            'message' => 'Project list',
            'totalCount' => $projects->total(),
            'totalPages' => $projects->lastPage(),
            'currentPage' => $projects->currentPage(),
            'payload' => $projects->items(),
        ];
    }
    public function projectsDownload()
    {
        $accessKey = config('app.migration_key');
        $providedKey = request()->get('key');

        if ($accessKey !== $providedKey) {
            return Response::json(['error' => true, 'message' => 'Forbidden'], 403);
        }
        $perPage = request()->get('per_page', 100);

        // Set up CSV response headers
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=projects_export.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];
        $columns = collect($this->projectsModel()->first(1))->keys()->toArray();
        return Response::stream(function () use ($columns, $perPage) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $page = 1;
            while (true) {
                $projects = $this->projectsModel()->take(30)
                    ->paginate($perPage, ['*'], 'page', $page);
                foreach ($projects as $project) {
                    fputcsv($file, array_map(function ($value) {
                        return $value === null ? 'null' : $value;
                    }, $project->toArray()));
                }

                if ($page >= $projects->lastPage()) break;
                // if ($page == 2) break;

                $page++;
            }

            fclose($file);
        }, 200, $headers);
    }


    private function projectsModel()
    {

        $districtStmt = config('stmts')['districts'];
        $categoriesStmt = config('stmts')['categories'];
        $codesStmt = config('stmts')['risk'];
        return  Project::orderBy('projects.created_at', 'ASC')

            ->join('organisations', 'projects.organisation_id', '=', 'organisations.id')
            ->join('categories', 'projects.category_id', '=', 'categories.id')

            ->join('districts', 'projects.district_id', '=', 'districts.id')

            ->select([
                \DB::raw("CONCAT('migrated/', projects.id) as application_number"),

                \DB::raw("CONCAT(title, ' (MIGRATED)') as name"),

                \DB::raw("NULL as countributing_team"),

                \DB::raw("0 as senior_gis_forwarded"),

                \DB::raw("0 as reviewer_forwarded"),

                \DB::raw("NULL as lead_agent_forwarded_at"),

                \DB::raw("0 as lead_agent_forwarded"),

                \DB::raw("0 as gis_forwarded"),

                \DB::raw("0 as counter_reviewer_forwarded"),

                \DB::raw("NULL as forward_before"),

                \DB::raw("'esia_approved' as status"),

                \DB::raw("NULL as value_id"),

                \DB::raw("NULL as value_of_murram"),

                \DB::raw("NULL as site_cost"),

                \DB::raw("NULL as restoration_cost"),

                \DB::raw("NULL as professional_fees"),

                \DB::raw("NULL as land_ownership"),

                \DB::raw("NULL as infracstructure_cost"),

                \DB::raw("NULL as equipment"),

                \DB::raw("NULL as employee_cost"),

                \DB::raw("NULL as cost_of_land"),

                \DB::raw("NULL as cost_of_installation"),

                \DB::raw("NULL as cost_of_equipment"),

                \DB::raw("NULL as cost_of_delivery"),

                \DB::raw("0 as burrow_pit"),

                \DB::raw("NULL as village_id"),

                \DB::raw($districtStmt),

                \DB::raw("NULL as plot_number"),

                \DB::raw("NULL as physical_address"),

                \DB::raw("NULL as parish_id"),

                \DB::raw("NULL as division_id"),

                \DB::raw("NULL as county_id"),

                \DB::raw("IF(projects.deleted_at IS NOT NULL, 1, 0) as deleted"),

                \DB::raw("0 as declaration"),

                \DB::raw("NULL as practitioner_id"),

                \DB::raw("NULL as other_water_supply_specify"),

                \DB::raw("NULL as other_utilities_specify"),

                \DB::raw("NULL as other_transport_infracstructure_specify"),

                \DB::raw("NULL as other_site_details"),

                \DB::raw("NULL as other_power_supply_specification"),

                \DB::raw("latitude as latitude"),

                \DB::raw("longitude as longitude"),

                \DB::raw("NULL as land_usage"),

                \DB::raw("0 as land_currently_in_use"),

                \DB::raw("NULL as fragile_ecosystem"),

                \DB::raw("NULL as distance_nearest_residential"),

                \DB::raw("0 as adjacent_fragile_eco_system"),

                \DB::raw("0 as eia_rate"),

                \DB::raw("0 as eia_fee"),

                \DB::raw("0 as certificate_fee"),

                \DB::raw("0 as assessed_amount"),

                \DB::raw("0 as workforce_size"),

                \DB::raw("CONCAT('Project has '," .

                    $codesStmt('has_industrial_waste_water') . ",' industrial waste water risk and generally has ', " . $codesStmt('risk_level') . ", ' risk level') as risks_and_hazards"),

                \DB::raw("'unknown' as social_studies"),

                \DB::raw("'unknown' as mitigation_measures"),

                \DB::raw("'unknown' as impact_description"),

                \DB::raw("'unknown' as health_social_impact"),

                \DB::raw("'unknown' as description"),

                \DB::raw("'unknown' as desc_workplace"),

                \DB::raw("'unknown' as desc_surrounding"),

                \DB::raw("'unknown' as company_role"),

                \DB::raw("organisations.name as company_name"),
                \DB::raw("organisations.email as developer_email"),

                \DB::raw("'unknown' as climate_studies"),

                \DB::raw("0 as climate_impact"),

                \DB::raw("null as developer_id"),

                \DB::raw("4 as created_by_id"),
                \DB::raw("1 as migrated"),

                \DB::raw("$categoriesStmt as category_id"),

                'organisations.physical_address as physical_address',

            ]);
    }
}
