<?php namespace App\Http\Controllers\Edit;

use App\Http\Controllers\Controller;
use Response;
use Auth;
use Input;
use Hash;
use \DateTime;
use Carbon\Carbon;
use \App\User;


class UserController extends Controller
{

    // GET /resource
    public function index()
    {
        $users = User::withTrashed()->with('roles')->get();
        foreach($users as $user)
        {
            $this->addRolesAsString($user);
        }
        return Response::json($users->toArray(), 200);
    }

    // GET /resource/:id
    public function show($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user)
        {
            return $id;
        }
        $this->addRolesAsString($user);
        return Response::json($user, 200);
    }

    // POST /resource
    public function store()
    {
        $user = new User();
        $newId = User::withTrashed()->max('id') + 1;
        $user->id = $newId;
        $user->created_by = $user->updated_by = Auth::user()->name;
        $user->save();

        return $this->show($newId);
    }

    // PUT/PATCH /resource/:id
    public function update($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = request()->all();

        $updatedAtFromInput = Carbon::parse($inputData["updated_at"]);
        $diff = $user->updated_at->diffInSeconds($updatedAtFromInput);
        if ($diff != 0)
        {
            return Response::json(array('error' => true, 'message' => 'conflict'), 409);
        }

        $this->updateValuesInResource($user, $inputData);
        $user->save();
        return $this->show($user->id);
    }

    // DELETE /resource/:id
    public function destroy($id)
    {
        $user = User::find($id);
        $user->updated_by = Auth::user()->name;
        $user->save();
        $user->delete();
        return $this->show($user->id);
    }
    
    private function addRolesAsString($user)
    {
        $roleIds = array();
        foreach ($user->roles as $role)
        {
            array_push($roleIds, $role->id);
        }
        $user["role_ids"] = join(",", $roleIds);
        unset($user["roles"]);
    }

    private function updateValuesInResource($resource, $data)
    {
        $dates = $resource->getDates();
        $changed = false;
        foreach ($data as $key => $value)
        {
            if ($key === "password")
            {
                if ($value)
                {
                    $resource[$key] = Hash::make($value);
                    $changed = true;
                }
            }
            elseif ($key === "role_ids")
            {
                $roleIds = [];
                if (array_key_exists("role_ids", $data))
                {
                    if (!$data["role_ids"])
                    {
                        $roleIds = [];
                    }
                    else
                    {
                        $roleIds = array_map('intval', explode(',', $data["role_ids"]));
                    }
                }
                $res = $resource->roles()->sync($roleIds);
                $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
                
                if ($changes > 0)
                {
                    $changed = true;
                }
            }
            elseif (in_array($key, $resource->getFillable(), true))
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