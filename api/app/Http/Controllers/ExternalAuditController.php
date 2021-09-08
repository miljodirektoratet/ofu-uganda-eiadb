<?php namespace App\Http\Controllers;

use Response;
use Auth;
use Input;
use \DateTime;
use \App\Project;
use \App\ExternalAudit;
use \App\EmailOrder;

class ExternalAuditController extends Controller
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
        $withTeamLeaderFunction = function ($query)
        {
            $query->select('id', 'person');
        };

        $withResponseDocument = function ($query)
        {
            $query->select('id', 'filename');
        };

        $withDocument = function ($query)
        {
            $query->orderBy('date_submitted', 'desc')
                ->select();
        };

        $rows = Project::find($projectId)
            ->externalaudits()
            ->with(array('documents' => $withDocument))
            ->with(array('user' => $withUserFunction))
            ->with(array('teamleader' => $withTeamLeaderFunction))
            ->with(array('response_document'=>$withResponseDocument))
            ->get();

        return Response::json($rows, 200);
    }

    // GET /resource/:id/subresource/:subid
    public function show($projectId, $id)
    {
        $withTeamLeaderFunction = function ($query)
        {
            $query->select('id', 'person');
        };
        $withResponseDocument = function ($query)
        {
            $query->select('id', 'filename');
        };
        $withDocument = function ($query)
        {
            $query->orderBy('date_submitted', 'desc')
                ->select();
        };

        $row = Project::find($projectId)->externalaudits()
            ->with('users')
            ->with(array('documents' => $withDocument))
            ->with(array('teamleader' => $withTeamLeaderFunction))
            ->with(array('response_document' => $withResponseDocument))
            ->with('teammembers')
            ->find($id);

        if (!$row)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $teammemberIds = array();
        foreach ($row->teammembers as $practitioner)
        {
            array_push($teammemberIds, $practitioner->id);
        }
        $row["teammember_ids"] = $teammemberIds;
        unset($row["teammembers"]);

        // Users (personnel).
        $userIds = array();
        foreach ($row->users as $user)
        {
            array_push($userIds, $user->id);
        }
        $row["user_ids"] = $userIds;
        unset($row["users"]);

        $emailOrder = EmailOrder::where('foreign_id', $row->id)->where('foreign_type', 'ea')->first();

        $row['email_order'] = $emailOrder;

        return Response::json($row, 200);
    }

    // POST /resource/:id/subresource
    public function store($projectId)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $inputData = request()->all();
        $row = new ExternalAudit();
        $this->updateValuesInResource($row, $inputData);
        $row->created_by = Auth::user()->name;

        $project = Project::find($projectId);
        $project->externalaudits()->save($row);
        $this->handleTeamMembers($row, $inputData);
        $this->handleUsers($row, $inputData);
        return $this->show($project->id, $row->id);
    }

    // PUT/PATCH /resource/:id/subresource/:subid
    public function update($projectId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $row = Project::find($projectId)->externalaudits()->find($id);
        if (!$row)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = request()->all();
        $this->updateValuesInResource($row, $inputData);
        $this->handleTeamMembers($row, $inputData);
        $this->handleUsers($row, $inputData);
        $row->save();
        return $this->show($projectId, $id);
    }

    // DELETE /resource/:id/subresource/:subid
    public function destroy($projectId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $row = Project::find($projectId)->externalaudits()->find($id);
        $row->delete();
        return Response::json(array('is_deleted' => true), 200);
    }

    private function handleTeamMembers($externalaudit, $inputData)
    {
        $teammemberIds = array();
        if (array_key_exists("teammember_ids", $inputData))
        {
            $teammemberIds = $inputData["teammember_ids"];
        }
        $res = $externalaudit->teammembers()->sync($teammemberIds);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0)
        {
            $row["updated_by"] = Auth::user()->name;
        }
    }

    private function handleUsers($externalaudit, $inputData)
    {
        $ids = array();
        if (array_key_exists("user_ids", $inputData))
        {
            $ids = $inputData["user_ids"];
        }
        $res = $externalaudit->users()->sync($ids);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0)
        {
            $externalaudit["updated_by"] = Auth::user()->name;
        }
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
            if (!isset($data["pirking"]))
            {
                $resource["updated_by"] = Auth::user()->name;
                //$project->created_by = Auth::user()->name;
            }
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