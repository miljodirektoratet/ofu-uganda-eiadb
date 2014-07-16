<?php

class ProjectController extends BaseController {

	// GET /resource
	public function index()
	{
		$withFunction = function ($query)
		{
			$query->select('id', 'name', 'city');
		};				

		$projects = Project::		
			with(array('organisation'=>$withFunction))			
			->get(array('id', 'title', 'location', 'organisation_id'));					
	
		return Response::json($projects->toArray(), 200); 
	}

	// GET /resource/:id
	public function show($id)
	{		
		$project = Project::with('organisation')->find($id);
		return Response::json($project, 200);
	}

	// POST /resource
	public function store()
	{		
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$inputData = Input::all();
		$project = new Project();	   
		$this->updateValuesInResource($project, $inputData);		
		$project->save();		

		return $this->show($project->id);
	}	

	// PUT/PATCH /resource/:id
	public function update($id)
	{		
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$project = Project::find($id);
		if (!$project)
		{
			return Response::json(array('error' => true, 'message' => 'not found'), 404);
		}

		$inputData = Input::all();		
		$this->updateValuesInResource($project, $inputData);
		$project->save();		
    return $this->show($project->id);
	}

	// DELETE /resource/:id
	public function destroy($id)
	{
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$project = Project::find($id);	 
		$project->delete();
		return Response::json(array('is_deleted' => true), 200);
	}

	private function updateValuesInResource($resource, $data)
	{		
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
				}	    	    		
			}	    	
		}
	}

	private function canSave()
	{
		return Auth::user()->hasRole("Role 1");
	}

	private function notAuthorized()
	{		
		return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
	}

}