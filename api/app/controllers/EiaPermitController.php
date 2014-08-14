<?php

class EiaPermitController extends BaseController {

	// GET /resource/:id/subresource
	public function index($projectId)
	{		
		$withUserFunction = function ($query)
		{			
			$query->select('id', 'full_name');
		};		
		$withTeamLeaderFunction = function ($query)
		{			
			$query->select('id', 'person');
		};			

		$eiapermits = Project::find($projectId)
			->eiapermits()
			->with(array('user'=>$withUserFunction))
			->with(array('teamleader'=>$withTeamLeaderFunction))
			->get(array('id', 'status', 'teamleader_id', 'user_id'));					
		return Response::json($eiapermits, 200); 
	}

	// GET /resource/:id/subresource/:subid	
	public function show($projectId, $id)
	{						
		$withTeamLeaderFunction = function ($query)
		{			
			$query->select('id', 'person');
		};			
		$eiapermit = Project::find($projectId)->eiapermits()
		->with(array('teamleader'=>$withTeamLeaderFunction))
		->with('teammembers')
		->find($id);
		$teammemberIds = array();
		foreach ($eiapermit->teammembers as $practitioner) 
		{
			array_push($teammemberIds, $practitioner->id);
		}		
		$eiapermit["teammember_ids"] = $teammemberIds;	
		unset($eiapermit["teammembers"]);
		return Response::json($eiapermit, 200);
	}

	// POST /resource/:id/subresource
	public function store($projectId)
	{		
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$inputData = Input::all();
		$eiapermit = new EiaPermit();	   
		$this->updateValuesInResource($eiapermit, $inputData);
		$eiapermit->created_by = Auth::user()->full_name;

		$project = Project::find($projectId);
		$project->eiapermits()->save($eiapermit);		
		$this->handleTeamMembers($eiapermit, $inputData);
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

		$inputData = Input::all();		
		$this->updateValuesInResource($eiapermit, $inputData);		
		$this->handleTeamMembers($eiapermit, $inputData);
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
		$changes = count($res["attached"])+count($res["detached"])+count($res["updated"]);
		if ($changes > 0)
		{
			$eiapermit["updated_by"] = Auth::user()->full_name;
		}
	}

	private function updateValuesInResource($resource, $data)
	{		
		//$resource
		$changed = false;
		foreach ($data as $key => $value)
		{			
			if (in_array($key, $resource["fillable"], true))
			{				
				if ($value === "")
				{
					$value = null;
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
			$resource["updated_by"] = Auth::user()->full_name;
			//$project->created_by = Auth::user()->full_name;
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