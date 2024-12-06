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

    private $providedKey;
    private $filePath;
    private $entityMapping = [
        'projects' => ['model' => 'Project', 'override' => true],
        'organisations' => ['model' => 'Organisation'],
        'users' => ['model' => 'User'],
        'eiapermits' => ['model' => 'EiaPermit', 'override' => true],
        'permitlicence' => ['model' => 'PermitLicense', 'override' => true],
    ];

    public function __construct()
    {

        $this->providedKey = config('app.migration_key');
        $this->filePath =   url('/') . '/api/migration/file';
    }

    public function endpoint($entity)
    {
        $entity = strtolower($entity);
        $perPage = request()->get('per_page', 100);
        try {
            $results = $this->model($entity)
                ->paginate($perPage);
        } catch (\Exception $e) {
            if (env('APP_DEBUG') == true) {
                dd($e);
            }
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
    public function csvDownload($entity)
    {
        $perPage = request()->get('per_page', 100);
        $exportName = $entity . '_export.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$exportName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $columns = collect($this->model($entity)->first())->keys()->toArray();

        return Response::stream(function () use ($columns, $perPage, $entity) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $page = 1;
            while (true) {
                $data = $this->model($entity)->take(30)
                    ->paginate($perPage, ['*'], 'page', $page);
                foreach ($data as $datum) {
                    fputcsv($file, array_map(function ($value) {
                        if ($value === null) {
                            return 'null';
                        }
                        if (is_array($value) || is_object($value)) {
                            return json_encode($value);
                        }
                        return $value;
                    }, $datum->toArray()));
                }

                if ($page >= $data->lastPage()) break;

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
