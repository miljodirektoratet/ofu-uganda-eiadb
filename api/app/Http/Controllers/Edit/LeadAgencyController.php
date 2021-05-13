<?php namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use Response;
use Auth;
use Input;
use Hash;
use \DateTime;
use Carbon\Carbon;
use \App\LeadAgency;


class LeadAgencyController extends Controller
{

    // GET /resource
    public function index()
    {
        $las = LeadAgency::withTrashed()->get();
        return Response::json($las->toArray(), 200);
    }

    // GET /resource/:id
    public function show($id)
    {
        $la = LeadAgency::withTrashed()->find($id);
        if (!$la)
        {
            return $id;
        }
        return Response::json($la, 200);
    }

    // POST /resource
    public function store()
    {
        $la = new LeadAgency();
        $newId = LeadAgency::withTrashed()->max('id') + 1;
        $la->id = $newId;
        $la->created_by = $la->updated_by = Auth::user()->name;
        $la->save();

        return $this->show($newId);
    }

    // PUT/PATCH /resource/:id
    public function update($id)
    {
        $la = LeadAgency::withTrashed()->find($id);
        if (!$la)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = Input::all();

        $updatedAtFromInput = Carbon::parse($inputData["updated_at"]);
        $diff = $la->updated_at->diffInSeconds($updatedAtFromInput);
        if ($diff != 0)
        {
            return Response::json(array('error' => true, 'message' => 'conflict'), 409);
        }

        $this->updateValuesInResource($la, $inputData);
        $la->save();
        return $this->show($la->id);
    }

    // DELETE /resource/:id
    public function destroy($id)
    {
        $la = LeadAgency::find($id);
        $la->updated_by = Auth::user()->name;
        $la->save();
        $la->delete();
        return $this->show($la->id);
    }

    private function updateValuesInResource($resource, $data)
    {
        $dates = $resource->getDates();
        $changed = false;
        foreach ($data as $key => $value)
        {
            if (in_array($key, $resource->getFillable(), true))
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
    }

}