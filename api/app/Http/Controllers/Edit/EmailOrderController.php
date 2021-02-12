<?php namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use Response;
use Auth;
use Input;
use \DateTime;
use Carbon\Carbon;
use \App\EmailOrder;


class EmailOrderController  extends Controller
{

    // GET /resource
    public function index()
    {
        $emailOrders = EmailOrder::withTrashed()->orderBy('updated_at', 'DESC')->get();
        return Response::json($emailOrders->toArray(), 200);
    }

    // GET /resource/:id
    public function show($id)
    {
        $emailOrder = EmailOrder::withTrashed()->find($id);
        if (!$emailOrder)
        {
            return $id;
        }
        return Response::json($emailOrder, 200);
    }

    // PUT/PATCH /resource/:id
    public function update($id)
    {
        $emailOrder = EmailOrder::withTrashed()->find($id);
        if (!$emailOrder)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = Input::all();

        $updatedAtFromInput = Carbon::parse($inputData["updated_at"]);
        $diff = $emailOrder->updated_at->diffInSeconds($updatedAtFromInput);
        if ($diff != 0)
        {
            return Response::json(array('error' => true, 'message' => 'conflict'), 409);
        }

        $this->updateValuesInResource($emailOrder, $inputData);
        $emailOrder->save();
        return $this->show($emailOrder->id);
    }

    // DELETE /resource/:id
    public function destroy($id)
    {
        $emailOrder = EmailOrder::find($id);
        $emailOrder->updated_by = Auth::user()->name;
        $emailOrder->save();
        $emailOrder->delete();
        return $this->show($emailOrder->id);
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
            $resource["user_id"] = Auth::user()->id;
            $resource["updated_by"] = Auth::user()->name;
            $resource["updated_at"] = Carbon::now();
        }
    }

}