<?php namespace App\Http\Controllers;

use Response;
use Auth;
use Input;
use \DateTime;
use \App\Project;
use \App\PermitLicense;
use \App\EmailOrder;

class PermitLicenseController extends Controller
{

    // GET /resource/:id/subresource
    public function index($projectId)
    {
        if (Project::where('id', $projectId)->count() == 0)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $withUserFunction = function ($query)
        {
            $query->select('id', 'name');
        };

        $rows = Project::find($projectId)
            ->permitlicenses()
            ->with(array('user' => $withUserFunction))
            ->get();

        return Response::json($rows, 200);
    }

    // GET /resource/:id/subresource/:subid
    public function show($projectId, $id)
    {
        $row = Project::find($projectId)->permitlicenses()
            ->with('users')
            ->with('documentation')
            ->find($id);

        // Users (personnel).
        $userIds = array();
        foreach ($row->users as $user)
        {
            array_push($userIds, $user->id);
        }
        $row["user_ids"] = $userIds;
        unset($row["users"]);

        // Documentation
        $documentationIds = array();
        foreach ($row->documentation as $documentationEntity)
        {
            array_push($documentationIds, $documentationEntity->id);
        }
        $row["documentation_ids"] = $documentationIds;

        $emailOrder = EmailOrder::where('foreign_id', $row->id)->where('foreign_type', 'pl')->first();
        $row['email_order'] = $emailOrder;

        return Response::json($row, 200);
    }

    // POST /resource/:id/subresource
    public function store($projectId)
    {
        if (!$this::canSave('new'))
        {
            return $this::notAuthorized();
        }

        $inputData = request()->all();
        $row = new PermitLicense();
        $this->updateValuesInResource($row, $inputData);
        $row->created_by = Auth::user()->name;
        $project = Project::find($projectId);
        $project->permitlicenses()->save($row);
        $this->handleUsers($row, $inputData);
        $this->handleDocumentation($row, $inputData);
        return $this->show($project->id, $row->id);
    }

    // PUT/PATCH /resource/:id/subresource/:subid
    public function update($projectId, $id)
    {
        $row = Project::find($projectId)->permitlicenses()->find($id);
        if (!$row)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        if (!$this::canSave('update', $row))
        {
            return $this::notAuthorized();
        }

        $except = [];
        if (!$this::canSave('lead_officer'))
        {
            $except = ['lead_officer'];
        }

        $inputData = request()->all();
        $this->updateValuesInResource($row, $inputData, $except);
        $this->handleUsers($row, $inputData);
        $this->handleDocumentation($row, $inputData);
        $row->save();
        return $this->show($projectId, $id);
    }

    // DELETE /resource/:id/subresource/:subid
    public function destroy($projectId, $id)
    {
        $row = Project::find($projectId)->permitlicenses()->find($id);

        if (!$this::canSave('delete', $row))
        {
            return $this::notAuthorized();
        }

        $row->delete();
        return Response::json(array('is_deleted' => true), 200);
    }

    private function handleUsers($row, $inputData)
    {
        $ids = array();
        if (array_key_exists("user_ids", $inputData))
        {
            $ids = $inputData["user_ids"];
        }
        $res = $row->users()->sync($ids);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0)
        {
            $row["updated_by"] = Auth::user()->name;
        }
    }

    private function handleDocumentation($row, $inputData)
    {
        $ids = array();
        if (array_key_exists("documentation_ids", $inputData))
        {
            $ids = $inputData["documentation_ids"];

        }
        $res = $row->documentation()->sync($ids);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0)
        {
            $row["updated_by"] = Auth::user()->name;
        }
    }


    private function updateValuesInResource($resource, $data, $except = [])
    {
        $dates = $resource->getDates();
        $changed = false;
        foreach ($data as $key => $value)
        {
            if (in_array($key, $except))
            {
                continue;
            }
            if (in_array($key, $resource->getFillable(), true))
            {
                if ($value === "")
                {
                    $value = null;
                }
                if ($value && in_array($key, $dates))
                {
                    $timestamp = strtotime($value . " + 12 hours");
                    if ($timestamp === false)
                    {
                        $value = null;
                    }
                    else
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

    private function canSave()
    {
        // TODO: Granulate this.
        return Auth::user()->hasRole("Role 1") ||
        Auth::user()->hasRole("Role 2") ||
        Auth::user()->hasRole("Role 3") ||
        Auth::user()->hasRole("Role 4") ||
        Auth::user()->hasRole("Role 5");
    }

    private function notAuthorized()
    {
        return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
    }
}