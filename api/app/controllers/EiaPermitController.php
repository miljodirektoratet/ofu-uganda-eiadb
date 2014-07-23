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
			->get(array('id', 'teamleader_id', 'user_id'));					
		return Response::json($eiapermits, 200); 
	}

	// GET /resource/:id/subresource/:subid	
	public function show($projectId, $id)
	{				
		$eiapermit = Project::find($projectId)->eiapermits()->find($id);
		return Response::json($eiapermit, 200);
	}

	// POST /resource/:id/subresource
	public function store()
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
		//$this->handleAdditionalDistricts($project, $inputData);
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
		//$this->handleAdditionalDistricts($project, $inputData);
		$eiapermit->save();				
    return $this->show($projectId, $id);
	}

	// DELETE /resource/:id/subresource/:subid	
	public function destroy($id)
	{
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$eiapermit = Project::find($projectId)->eiapermits()->find($id);
		$eiapermit->delete();
		return Response::json(array('is_deleted' => true), 200);
	}

	private function handleAdditionalDistricts($project, $inputData)
	{								
		$districtIds = array();
		if (array_key_exists("district_ids", $inputData))
		{
			$districtIds = $inputData["district_ids"];	
		}		
		$res = $project->districts()->sync($districtIds);	
		$changes = count($res["attached"])+count($res["detached"])+count($res["updated"]);
		if ($changes > 0)
		{
			$project["updated_by"] = Auth::user()->full_name;
		}
	}

	private function updateValuesInResource($resource, $data)
	{		
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