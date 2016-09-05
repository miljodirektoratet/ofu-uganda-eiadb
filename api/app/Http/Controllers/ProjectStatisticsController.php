<?php namespace App\Http\Controllers;

use Response;
use DB;
use Carbon\Carbon;

class ProjectStatisticsController extends Controller
{
// GET /resource/:id/subresource
    public function index()
    {
        $data = [];

        // Intro.
        $countProjects = DB::table('projects')->whereNull('deleted_at')->count();
        $countDevelopers = DB::table('organisations')->whereNull('deleted_at')->count();

        $dataCounts = [
            "projects" => $countProjects,
            "developers" => $countDevelopers
        ];


        // Part 1 and 2.
        $categoriesResult = DB::table('categories as c')
            ->leftJoin('projects as p', 'c.id', '=', 'p.category_id')
            ->select('c.id', 'c.description_long as description', 'c.consequence', DB::raw('COUNT(p.id) as count'))
            ->whereNull('p.deleted_at')
            ->whereNull('c.deleted_at')
            ->groupBy('c.id')
            ->orderByRaw('COUNT(p.id) desc, c.description_long asc')
            ->get();
        $dataCategoryEiaYes = [];
        $dataCategoryEiaNo = [];
        foreach ($categoriesResult as $dbRow)
        {
            $row = $this::createResultRow($dbRow);
            $row["search"] = "category_id=" . $dbRow->id;

            if ($dbRow->consequence == 6)
            {
                $dataCategoryEiaYes [] = $row;
            } else
            {
                $dataCategoryEiaNo [] = $row;
            }
        }


        // Part 3.
        $countProjectsWithoutCoordinates = DB::table('projects')
            ->whereNull('deleted_at')
            ->whereRaw('latitude is null or longitude is null')
            ->count();
        $countProjectsWithCoordinates = $countProjects - $countProjectsWithoutCoordinates;

        $dataCoordinates = [
            ["description" => "Yes", "count" => $countProjectsWithCoordinates],
            ["description" => "No", "count" => $countProjectsWithoutCoordinates]
        ];


        // Part 4.
        $countProjectsWithWasteWater = DB::table('projects')
            ->whereNull('deleted_at')
            ->where('has_industrial_waste_water', 40)
            ->count();
        $countProjectsWithoutWasteWater = DB::table('projects')
            ->whereNull('deleted_at')
            ->where('has_industrial_waste_water', 41)
            ->count();
        $countProjectsUnknownWasteWater = $countProjects - $countProjectsWithWasteWater - $countProjectsWithoutWasteWater;

        $dataWasteWater = [
            ["id" => 40, "description" => "Yes", "count" => $countProjectsWithWasteWater, "search" => "project_has_industrial_waste_water=40"],
            ["id" => 42, "description" => "Unknown", "count" => $countProjectsUnknownWasteWater, "search" => "project_has_industrial_waste_water=42"],
            ["id" => 41, "description" => "No", "count" => $countProjectsWithoutWasteWater, "search" => "project_has_industrial_waste_water=41"]
        ];


        // Part 5.
        $developersResult = DB::table('organisations as o')
            ->join('projects as p', 'o.id', '=', 'p.organisation_id')
            ->select('o.id', 'o.name as description', DB::raw('COUNT(p.id) as count'))
            ->whereNull('o.deleted_at')
            ->whereNull('p.deleted_at')
            ->groupBy('o.id')
            ->orderByRaw('COUNT(o.id) desc, o.name asc')
            ->take(10)
            ->get();

        $dataDevelopers = [];
        foreach ($developersResult as $dbRow)
        {
            $row = $this::createResultRow($dbRow);
            $row["search"] = "developer_id=" . $dbRow->id;
            $dataDevelopers [] = $row;
        }

        // Part 6.
        $riskLevelResult = DB::table('codes as c')
            ->leftJoin('projects as p', 'c.id', '=', 'p.risk_level')
            ->select('c.id', 'c.description1 as description', DB::raw('COUNT(p.risk_level) as count'))
            ->whereNull('p.deleted_at')
            ->whereNull('c.deleted_at')
            ->where('c.dropdown_list', '=', 'project_risk_level')
            ->groupBy('c.id')
            ->orderByRaw('c.id asc')
            ->get();

        $dataRiskLevels = [];
        foreach ($riskLevelResult as $dbRow)
        {
            $row = $this::createResultRow($dbRow);
            $row["search"] = "project_risk_level=" . $dbRow->id;
            $dataRiskLevels [] = $row;
        }


        $data["timestamp"] = Carbon::now()->toDateTimeString(); // Utc date. The rest is fixed in javascript.
        $data["intro"] = ["title" => sprintf("The EIA database has %d projects and %d developers. The statistics below shows the number of projects for some key elements.", $countProjects, $countDevelopers), "counts" => $dataCounts];
        $data["parts"] = [];
        $data["parts"]["categoryEiaYes"] = ["title" => 'The number of projects per category, where the category is "Considered for EIA"', "label1" => "Category", "label2" => "Number", "rows" => $dataCategoryEiaYes];
        $data["parts"]["categoryEiaNo"] = ["title" => 'The number of projects per category, where the category is "Likely exempted from EIA"', "label1" => "Category", "label2" => "Number", "rows" => $dataCategoryEiaNo];
        $data["parts"]["coordinates"] = ["title" => "The number of projects with and without coordinates", "label1" => "Coordinates present", "label2" => "Number", "rows" => $dataCoordinates];
        $data["parts"]["wasteWater"] = ["title" => "The number of projects with and without industrial waste water", "label1" => "Industrial waste water", "label2" => "Number", "rows" => $dataWasteWater];
        $data["parts"]["developers"] = ["title" => "The number of projects per developer. The list will show the ten developers with most number of projects", "label1" => "Top ten developers", "label2" => "Number", "rows" => $dataDevelopers];
        $data["parts"]["riskLevel"] = ["title" => "The number of projects per risk level", "label1" => "Risk level", "label2" => "Number", "rows" => $dataRiskLevels];

        return Response::json($data, 200);
    }

    private function createResultRow($dbRow)
    {
        $row = [];
        $row["id"] = $dbRow->id;
        $row["description"] = $dbRow->description;
        $row["count"] = $dbRow->count;
        return $row;
    }
}