<?php namespace App\Http\Controllers;

use Response;
use Auth;
use Input;
use \DateTime;
use \App\Project;
use \App\Document;
use \App\Hearing;

class HearingController extends Controller
{

    // GET /resource/:id/subresource/:subid/level3resource/:level3id/level4resource
    public function index($projectId, $eiapermitId, $documentId)
    {
        $withAttachment = function ($query)
        {
            $query->select('id', 'filename');
        };

        $hearings = Project::find($projectId)
            ->eiapermits()->find($eiapermitId)
            ->documents()->find($documentId)
            ->hearings()
            ->with(array('attachment'=>$withAttachment))
            ->get(array('id', 'lead_agency', 'date_dispatched', 'date_expected', 'date_received', 'file_metadata_id'));
        return Response::json($hearings, 200);
    }

    // GET /resource/:id/subresource/:subid/level3resource/:level3id/level4resource/:level4id
    public function show($projectId, $eiapermitId, $documentId, $id)
    {
        $withAttachment = function ($query)
        {
            $query->select('id', 'filename');
        };

        $document = Project::find($projectId)
            ->eiapermits()->find($eiapermitId)
            ->documents()->find($documentId)
            ->hearings()
            ->with(array('attachment'=>$withAttachment))
            ->find($id);

        return Response::json($document, 200);
    }


    // POST /resource/:id/subresource/:subid/level3resource/:level3id/level4resource
    public function store($projectId, $eiapermitId, $documentId)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $inputData = Input::all();
        $hearing = new Hearing();
        $this->updateValuesInResource($hearing, $inputData);
        $hearing->created_by = Auth::user()->name;
        $project = Project::find($projectId);
        $project->eiapermits()->find($eiapermitId)
            ->documents()->find($documentId)
            ->hearings()->save($hearing);
        return $this->show($project->id, $eiapermitId, $documentId, $hearing->id);
    }

    // PUT/PATCH /resource/:id/subresource/:subid/level3resource/:level3id/level4resource/:level4id
    public function update($projectId, $eiapermitId, $documentId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $hearing = Project::find($projectId)
            ->eiapermits()->find($eiapermitId)
            ->documents()->find($documentId)
            ->hearings()->find($id);
        if (!$hearing)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = Input::all();
        $this->updateValuesInResource($hearing, $inputData);
        $hearing->save();
        return $this->show($projectId, $eiapermitId, $documentId, $id);
    }

    // DELETE /resource/:id/subresource/:subid/level3resource/:level3id/level4resource/:level4id
    public function destroy($projectId, $eiapermitId, $documentId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $hearing = Project::find($projectId)
            ->eiapermits()->find($eiapermitId)
            ->documents()->find($documentId)
            ->hearings()->find($id);
        $hearing->delete();
        return Response::json(array('is_deleted' => true), 200);
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
            //$project->created_by = Auth::user()->name;
        }
    }

    private function canSave()
    {
        // TODO: CHECK DOCUMENTATION!!!
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