<?php namespace App\Http\Controllers;

use Response;
use Auth;
use Input;
use \DateTime;
use \App\Project;
use \App\EiaPermit;

class EiaPermitController extends Controller
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

        $withCertificate = function ($query)
        {
            $query->select('id', 'filename');
        };


        $eiapermits = Project::find($projectId)
            ->eiapermits()
            ->with(array('user' => $withUserFunction))
            ->with(array('teamleader' => $withTeamLeaderFunction))
            ->with(array('certificate'=>$withCertificate))
            ->get(array('id', 'status', 'teamleader_id', 'user_id', 'decision', 'date_certificate', 'certificate_no', 'file_metadata_id', 'email_contact'));

        return Response::json($eiapermits, 200);
    }

    // GET /resource/:id/subresource/:subid
    public function show($projectId, $id)
    {
        $withTeamLeaderFunction = function ($query)
        {
            $query->select('id', 'person');
        };
        $withCertificate = function ($query)
        {
            $query->select('id', 'filename');
        };

        $eiapermit = Project::find($projectId)->eiapermits()
            ->with('users')
            ->with(array('teamleader' => $withTeamLeaderFunction))
            ->with(array('certificate' => $withCertificate))
            ->with('teammembers')
            ->find($id);

        if (!$eiapermit)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $teammemberIds = array();
        foreach ($eiapermit->teammembers as $practitioner)
        {
            array_push($teammemberIds, $practitioner->id);
        }
        $eiapermit["teammember_ids"] = $teammemberIds;
        unset($eiapermit["teammembers"]);

        // Users (personnel).
        $userIds = array();
        $eiaFee = $eiapermit->fee;
        $expectedJobCreated = $eiapermit->expected_jobs_created;
        ($eiaFee) ?
            $eiapermit->fee = number_format((float)$eiaFee, 2, '.', '') :$eiaFee;
        ($expectedJobCreated) ?
            $eiapermit->expected_jobs_created = number_format((float)$expectedJobCreated, 1, '.', '') :$expectedJobCreated;
        foreach ($eiapermit->users as $user)
        {
            array_push($userIds, $user->id);
        }
        $eiapermit["user_ids"] = $userIds;
        unset($eiapermit["users"]);

        return Response::json($eiapermit, 200);
    }

    // POST /resource/:id/subresource
    public function store($projectId)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $inputData = request()->all();
        $eiapermit = new EiaPermit();
        $this->updateValuesInResource($eiapermit, $inputData);
        $eiapermit->created_by = Auth::user()->name;

        $project = Project::find($projectId);
        $project->eiapermits()->save($eiapermit);
        $this->handleTeamMembers($eiapermit, $inputData);
        $this->handleUsers($eiapermit, $inputData);
        return $this->show($project->id, $eiapermit->id);
    }

    // PUT/PATCH /resource/:id/subresource/:subid
    public function update($projectId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $eiapermit = Project::find($projectId)->eiapermits()->find($id);
        if (!$eiapermit)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = request()->all();
        $this->updateValuesInResource($eiapermit, $inputData);
        $this->handleTeamMembers($eiapermit, $inputData);
        $this->handleUsers($eiapermit, $inputData);
        $eiapermit->save();
        return $this->show($projectId, $id);
    }

    // DELETE /resource/:id/subresource/:subid
    public function destroy($projectId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $eiapermit = Project::find($projectId)->eiapermits()->find($id);
        $eiapermit->delete();
        return Response::json(array('is_deleted' => true), 200);
    }

    private function handleTeamMembers($eiapermit, $inputData)
    {
        $teammemberIds = array();
        if (array_key_exists("teammember_ids", $inputData))
        {
            $teammemberIds = $inputData["teammember_ids"];
        }
        $res = $eiapermit->teammembers()->sync($teammemberIds);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0)
        {
            $eiapermit["updated_by"] = Auth::user()->name;
        }
    }

    private function handleUsers($eiapermit, $inputData)
    {
        $ids = array();
        if (array_key_exists("user_ids", $inputData))
        {
            $ids = $inputData["user_ids"];
        }
        $res = $eiapermit->users()->sync($ids);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0)
        {
            $eiapermit["updated_by"] = Auth::user()->name;
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