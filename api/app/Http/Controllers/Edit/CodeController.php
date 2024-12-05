<?php namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use Response;
use Auth;
use Input;
use \DateTime;
use Carbon\Carbon;
use \App\Code;


class CodeController extends Controller
{

    // GET /resource
    public function index()
    {
        $codes = Code::withTrashed()->get();
        return Response::json($codes->toArray(), 200);
    }

    // GET /resource/:id
    public function show($id)
    {
        $code = Code::withTrashed()->find($id);
        if (!$code)
        {
            return $id;
        }
        return Response::json($code, 200);
    }

    // POST /resource
    public function store()
    {
        $code = new Code();
        $newId = Code::withTrashed()->max('id') + 1;
        $code->id = $newId;
        $code->created_by = $code->updated_by = Auth::user()->name;
        $code->save();

        return $this->show($newId);
    }

    // PUT/PATCH /resource/:id
    public function update($id)
    {
        $code = Code::withTrashed()->find($id);
        if (!$code)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = request()->all();

        $updatedAtFromInput = Carbon::parse($inputData["updated_at"]);
        $diff = $code->updated_at->diffInSeconds($updatedAtFromInput);
        if ($diff != 0)
        {
            return Response::json(array('error' => true, 'message' => 'conflict'), 409);
        }

        $resource = $this->updateValuesInResource($code, $inputData);
        $code->save();
        return $this->show($code->id);
    }

    // DELETE /resource/:id
    public function destroy($id)
    {
        $code = Code::find($id);
        $code->updated_by = Auth::user()->name;
        $code->save();
        $code->delete();
        return $this->show($code->id);
    }

    private function updateValuesInResource($resource, $data)
    {
        $dates = $resource->getDates();
        $changed = false;
        foreach ($data as $key => $value)
        {
            if (in_array($key,  $resource->getFillable(), true))
            {
                if ($value === "")
                {
                    $value = null;
                }
                if ($value && in_array($key, $dates))
                {
                    $timestamp = strtotime($value);
                    if ($timestamp === false)
                    {
                        $value = null;
                    } else
                    {
                        $value = new DateTime();
                        $value->setTimestamp($timestamp);
                    }
                }

                if ($resource[$key] != $value)
                {
                    // TODO: Validate.
                    $resource[$key] = $value;
                    $changed = true;
                }
            }
        }
        if ($changed)
        {
            $resource["updated_by"] = Auth::user()->name;
            $resource["updated_at"] = Carbon::now();
        }
        return $resource;
    }

}