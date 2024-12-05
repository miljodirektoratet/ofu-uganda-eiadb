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

class OrganisationController extends Controller
{

    // GET /organisations
    public function organizationAPI()
    {
        $accessKey = config('app.migration_key');
        $providedKey =  request()->get('key');
        if ($accessKey !== $providedKey) {
            return Response::json(array('error' => true, 'message' => 'Forbidden'), 403);
        }

        $perPage = request()->get('per_page', 100);
        $organisations = $this->OrganisationModel()
            ->paginate($perPage);

        return [
            'error' => false,
            'message' => 'Organization list',
            'totalCount' => $organisations->total(),
            'totalPages' => $organisations->lastPage(),
            'currentPage' => $organisations->currentPage(),
            'payload' => $organisations->items(),
        ];
    }
    public function OrganisationDownload()
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
            "Content-Disposition" => "attachment; filename=organisation_export.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];
        // dd(collect($this->OrganisationModel())->toArray());
        $columns = collect($this->OrganisationModel()->first(1))->keys()->toArray();
        return Response::stream(function () use ($columns, $perPage) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $page = 1;
            while (true) {
                $organisations = $this->OrganisationModel()->take(30)
                    ->paginate($perPage, ['*'], 'page', $page);
                foreach ($organisations as $project) {
                    fputcsv($file, array_map(function ($value) {
                        return $value === null ? 'null' : $value;
                    }, $project->toArray()));
                }

                if ($page >= $organisations->lastPage()) break;
                // if ($page == 2) break;

                $page++;
            }

            fclose($file);
        }, 200, $headers);
    }


    private function OrganisationModel()
    {
        return  Organisation::orderBy('organisations.created_at', 'ASC')->select();
    }
}
