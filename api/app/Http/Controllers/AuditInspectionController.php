<?php namespace App\Http\Controllers;

use Response;
use Auth;
use Input;
use \DateTime;
use \App\Project;
use \App\AuditInspection;

class AuditInspectionController extends Controller
{

// GET /resource/:id/subresource
    public function index($projectId)
    {
        $auditinspections = Project::find($projectId)
            ->auditinspections()
            ->get(array('id', 'status', 'year', 'number'));
        return Response::json($auditinspections, 200);
    }

    // GET /resource/:id/subresource/:subid
    public function show($projectId, $id)
    {
        $auditinspection = Project::find($projectId)->auditinspections()
            ->with('users')
            ->with('leadagencies')
            ->find($id);
        $Ids = array();

        // Users (personnel).
        $userIds = array();
        foreach ($auditinspection->users as $user)
        {
            array_push($userIds, $user->id);
        }
        $auditinspection["user_ids"] = $userIds;
        unset($auditinspection["users"]);

        // Lead Agencies
        $leadagencyIds = array();
        foreach ($auditinspection->leadagencies as $leadagency)
        {
            array_push($leadagencyIds, $leadagency->id);
        }
        $auditinspection["leadagency_ids"] = $leadagencyIds;
        unset($auditinspection["leadagencies"]);

        return Response::json($auditinspection, 200);
    }

    // POST /resource/:id/subresource
    public function store($projectId)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $inputData = Input::all();
        $auditinspection = new AuditInspection();
        $this->updateValuesInResource($auditinspection, $inputData);
        $auditinspection->created_by = Auth::user()->name;

        $project = Project::find($projectId);
        $project->auditinspections()->save($auditinspection);
        $this->handleUsers($auditinspection, $inputData);
        $this->handleLeadAgencies($auditinspection, $inputData);
        return $this->show($project->id, $auditinspection->id);
    }

    // PUT/PATCH /resource/:id/subresource/:subid
    public function update($projectId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $auditinspection = Project::find($projectId)->auditinspections()->find($id);
        if (!$auditinspection)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = Input::all();
        $this->updateValuesInResource($auditinspection, $inputData);
        $this->handleUsers($auditinspection, $inputData);
        $this->handleLeadAgencies($auditinspection, $inputData);
        $auditinspection->save();
        return $this->show($projectId, $id);
    }

    // DELETE /resource/:id/subresource/:subid
    public function destroy($projectId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $auditinspection = Project::find($projectId)->auditinspections()->find($id);
        $auditinspection->delete();
        return Response::json(array('is_deleted' => true), 200);
    }

    private function handleUsers($auditinspection, $inputData)
    {
        $ids = array();
        if (array_key_exists("user_ids", $inputData))
        {
            $ids = $inputData["user_ids"];
        }
        $res = $auditinspection->users()->sync($ids);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0)
        {
            $auditinspection["updated_by"] = Auth::user()->name;
        }
    }

    private function handleLeadAgencies($auditinspection, $inputData)
    {
        $ids = array();
        if (array_key_exists("leadagency_ids", $inputData))
        {
            $ids = $inputData["leadagency_ids"];
        }
        $res = $auditinspection->leadagencies()->sync($ids);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0)
        {
            $auditinspection["updated_by"] = Auth::user()->name;
        }
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
                    $timestamp = strtotime($value . " + 12 hours");
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

    private function canSave()
    {
        return Auth::user()->hasRole("Role 7");
    }

    private function notAuthorized()
    {
        return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
    }
}