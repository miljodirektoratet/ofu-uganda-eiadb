<?php namespace App\Http\Controllers;

use Response;
use Auth;
use Input;
use \DateTime;
use \App\Project;
use \App\AuditInspection;

class AuditInspectionController extends Controller
{
    public function __construct()
    {
//        if (\App::environment() !== "production")
//        {
//            sleep(2);
//        }
    }

// GET /resource/:id/subresource
    public function index($projectId)
    {
        if (Project::where('id', $projectId)->count() == 0)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $withFileMetadata = function ($query)
        {
            $query->select('id', 'filename');
        };

        $auditinspections = Project::find($projectId)
            ->auditinspections()
            ->with(array('reportFile' => $withFileMetadata))
            ->get();
        return Response::json($auditinspections, 200);
    }

    // GET /resource/:id/subresource/:subid
    public function show($projectId, $id)
    {
        $withActionTakenLetter = function ($query)
        {
            $query->select('id', 'filename');
        };

        $withFileMetadata = function ($query)
        {
            $query->select('id', 'filename');
        };

        $auditinspection = Project::find($projectId)->auditinspections()
            ->with('users')
            ->with('leadagencies')
            ->with(array('actionTakenLetter' => $withFileMetadata))
            ->with(array('reportFile' => $withFileMetadata))
            ->with('documentation')
            ->find($id);

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

        // Documentation
        $documentationIds = array();
        foreach ($auditinspection->documentation as $documentationEntity)
        {
            array_push($documentationIds, $documentationEntity->id);
        }
        $auditinspection["documentation_ids"] = $documentationIds;
        //unset($auditinspection["documentation"]);

        return Response::json($auditinspection, 200);
    }

    // POST /resource/:id/subresource
    public function store($projectId)
    {
        if (!$this::canSave('new'))
        {
            return $this::notAuthorized();
        }

        $inputData = Input::all();
        $auditinspection = new AuditInspection();
        $this->updateValuesInResource($auditinspection, $inputData);
        $this->generateCode($auditinspection);
        $auditinspection->created_by = Auth::user()->name;
        $project = Project::find($projectId);
        $project->auditinspections()->save($auditinspection);
        $this->handleUsers($auditinspection, $inputData);
        $this->handleLeadAgencies($auditinspection, $inputData);
        $this->handleDocumentation($auditinspection, $inputData);
        return $this->show($project->id, $auditinspection->id);
    }

    // PUT/PATCH /resource/:id/subresource/:subid
    public function update($projectId, $id)
    {
        $auditinspection = Project::find($projectId)->auditinspections()->find($id);
        if (!$auditinspection)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        if (!$this::canSave('update', $auditinspection))
        {
            return $this::notAuthorized();
        }

        $except = [];
        if (!$this::canSave('lead_officer'))
        {
            $except = ['lead_officer'];
        }

        $inputData = Input::all();
        $this->updateValuesInResource($auditinspection, $inputData, $except);
        $this->generateCode($auditinspection);
        $this->handleUsers($auditinspection, $inputData);
        $this->handleLeadAgencies($auditinspection, $inputData);
        $this->handleDocumentation($auditinspection, $inputData);
        $auditinspection->save();
        return $this->show($projectId, $id);
    }

    // DELETE /resource/:id/subresource/:subid
    public function destroy($projectId, $id)
    {
        $auditinspection = Project::find($projectId)->auditinspections()->find($id);

        if (!$this::canSave('delete', $auditinspection))
        {
            return $this::notAuthorized();
        }

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

    private function handleDocumentation($auditinspection, $inputData)
    {
        $ids = array();
        if (array_key_exists("documentation_ids", $inputData))
        {
            $ids = $inputData["documentation_ids"];
        }
        $res = $auditinspection->documentation()->sync($ids);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0)
        {
            $auditinspection["updated_by"] = Auth::user()->name;
        }
    }

    private function generateCode($auditinspection)
    {
        $year = $auditinspection->year;
        $maxNumber = AuditInspection::where('year', $year)->withTrashed()->max('number');
        $number = $maxNumber + 1;
        $auditinspection->number = $number;
        $auditinspection->code = sprintf("%d.%03d", $year, $number);
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

    private function canSave($field, $resource=null)
    {
        if ($field == "new")
        {
            return Auth::user()->hasRole("Role 7");
        }
        if (Auth::user()->hasRole("Role 8"))
        {
            return true;
        }
        if ($field == "lead_officer")
        {
            return false;
        }
        if ($resource)
        {
            return Auth::user()->id === $resource['lead_officer'];
        }
        return false;
    }

    private function notAuthorized()
    {
        return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
    }
}