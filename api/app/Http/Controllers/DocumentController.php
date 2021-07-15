<?php namespace App\Http\Controllers;

use Response;
use Auth;
use Input;
use \DateTime;
use \App\Project;
use \App\Document;
use \App\EmailOrder;

class DocumentController extends Controller
{

    // GET /resource/:id/subresource/:subid/level3resource
    public function index($projectId, $eiapermitId)
    {
        $withAttachment = function ($query)
        {
            $query->select('id', 'filename');
        };

        $withResponseDocument = function ($query)
        {
            $query->select('id', 'filename');
        };

        $documents = Project::find($projectId)
            ->eiapermits()->find($eiapermitId)
            ->documents()
            ->with(array('attachment'=>$withAttachment))
            ->with(array('response_document'=>$withResponseDocument))
            ->get(array('id', 'date_submitted', 'title', 'code', 'date_sent_director', 'date_sent_from_dep', 'date_sent_officer', 'conclusion', 'file_metadata_id', 'file_metadata_response_id','type'));
        return Response::json($documents, 200);
    }

    // GET /resource/:id/subresource/:subid/level3resource/:level3id
    public function show($projectId, $eiapermitId, $id)
    {
        $withTeamLeaderFunction = function ($query)
        {
            $query->select('id', 'person');
        };

        $withAttachment = function ($query)
        {
            $query->select('id', 'filename');
        };

        $withResponseDocument = function ($query)
        {
            $query->select('id', 'filename');
        };

        $document = Project::find($projectId)
            ->eiapermits()->find($eiapermitId)
            ->documents()
            ->with(array('attachment'=>$withAttachment))
            ->with(array('response_document'=>$withResponseDocument))
            ->find($id);
        
        $emailOrder = EmailOrder::where('foreign_id', $document->id)->where('foreign_type', 'eia')->first();

        $document['email_order'] = $emailOrder;

        return Response::json($document, 200);
    }


    // POST /resource/:id/subresource/:subid/level3resource
    public function store($projectId, $eiapermitId)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $inputData = request()->all();
        $document = new Document();
        $this->updateValuesInResource($document, $inputData);
        $document->created_by = Auth::user()->name;
        $project = Project::find($projectId);
        $project->eiapermits()->find($eiapermitId)->documents()->save($document);
        return $this->show($project->id, $eiapermitId, $document->id);
    }

    // PUT/PATCH /resource/:id/subresource/:subid/level3resource/:level3id
    public function update($projectId, $eiapermitId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $document = Project::find($projectId)->eiapermits()->find($eiapermitId)->documents()->find($id);
        if (!$document)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = request()->all();
        $this->updateValuesInResource($document, $inputData);
        $document->save();
        return $this->show($projectId, $eiapermitId, $id);
    }

    // DELETE /resource/:id/subresource/:subid/level3resource/:level3id
    public function destroy($projectId, $eiapermitId, $id)
    {
        if (!$this::canSave())
        {
            return $this::notAuthorized();
        }

        $document = Project::find($projectId)->eiapermits()->find($eiapermitId)->documents()->find($id);
        $document->delete();
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