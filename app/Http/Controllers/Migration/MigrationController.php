<?php

namespace App\Http\Controllers\Migration;

// use Response;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Migration\Modifiers;

class MigrationController extends Controller
{
    use Modifiers;

    private $entityMapping = [
        'projects' => ['model' => 'Project', 'override' => true],
        'organisations' => ['model' => 'Organisation'],
        'users' => ['model' => 'User'],
        'eiapermits' => ['model' => 'eiaPermit'],
    ];

    public function endpoint($entity)
    {
        $entity = strtolower($entity);
        $accessKey = config('app.migration_key');
        $providedKey =  request()->get('key');
        if ($accessKey !== $providedKey) {
            return Response::json(array('error' => true, 'message' => 'Forbidden'), 403);
        }

        $perPage = request()->get('per_page', 100);
        try {
            $results = $this->model($entity)
                ->paginate($perPage);
        } catch (\Exception $e) {
            return Response::json(array('error' => true, 'message' => 'No such resource'), 404);
        }

        return [
            'error' => false,
            'message' => "List of $entity",
            'totalCount' => $results->total(),
            'totalPages' => $results->lastPage(),
            'currentPage' => $results->currentPage(),
            'payload' => $results->items(),
        ];
    }
    public function csvDownload()
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


    private function model($entity)
    {
        if (!in_array($entity, array_keys($this->entityMapping))) {
            throw new \Exception("Model $entity does not exist.");
        }
        $modelName = $this->entityMapping[$entity]['model'];
        $hasModelOverride = isset($this->entityMapping[$entity]['override']);
        $model = ($hasModelOverride) ?  $modelName . "Model" : $modelName;
        $class = "\\App\\" . $model;

        if (! $hasModelOverride && class_exists($class)) {
            return $class::orderBy('created_at', 'ASC')->select();
        } else if ($hasModelOverride && method_exists($this, $model)) {
            return $this->{$model}();
        }


        throw new \Exception("Model $class does not exist.");
    }
}
