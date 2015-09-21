<?php namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use Response;
use Auth;
use Input;
use \DateTime;
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
        $code = Code::find($id);
        return Response::json($code, 200);
    }

    // POST /resource
    public function store()
    {
        $inputData = Input::all();
        $code = new Code();
        $this->updateValuesInResource($code, $inputData);
        $code->created_by = Auth::user()->name;
        $code->save();

        return $this->show($code->id);
    }

    // PUT/PATCH /resource/:id
    public function update($id)
    {
        $code = Code::find($id);
        if (!$code)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = Input::all();
        $this->updateValuesInResource($code, $inputData);
        $code->save();
        return $this->show($code->id);
    }

    // DELETE /resource/:id
    public function destroy($id)
    {
        $code = Code::find($id);
        $code->delete();
        return Response::json(array('is_deleted' => true), 200);
    }

    private function updateValuesInResource($resource, $data)
    {
        $dates = $resource->getDates();
        $changed = false;
        foreach ($data as $key => $value)
        {
            if (in_array($key, $resource["fillable"], true))
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
        }
    }

}