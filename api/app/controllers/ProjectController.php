<?php

class ProjectController extends BaseController {

	// GET /resource
	public function index()
	{
		$countOnly = Input::get('countOnly');
		if ($countOnly)
		{
			return [Project::count()];
		}

		$count = Input::get('count');

		$withFunction = function ($query)
		{
			$query->select('id', 'name', 'city');
		};		
		$withFunction2 = function ($query)
		{
			$query->select('id', 'district');
		};				
		$withFunction3 = function ($query)
		{
			$query->select('id', 'description_short as description');
		};



		$projects = Project::		
			with(array('organisation'=>$withFunction, 'district'=>$withFunction2, 'category'=>$withFunction3))						
			->orderBy('id', 'desc')
			->take($count)
			->get(array('id', 'title', 'category_id', 'district_id', 'location', 'organisation_id'));
			
		return Response::json($projects->toArray(), 200); 
	}

	// GET /resource/:id
	public function show($id)
	{				
		$project = Project::
			with('districts') // I'd like to limit the belongsToMany to only the district id, but this is not currently possible in Laravel.
			->find($id);		
		$districtIds = array();
		foreach ($project->districts as $district) 
		{
			array_push($districtIds, $district->id);
		}		
		$project["district_ids"] = $districtIds;	
		unset($project["districts"]);
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
		$project->created_by = Auth::user()->full_name;
		$project->save();		
		$this->handleAdditionalDistricts($project, $inputData);
		return $this->show($project->id);
	}	

	// PUT/PATCH /resource/:id
	public function update($id)
	{		
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$project = Project::with('districts')->find($id);
		if (!$project)
		{
			return Response::json(array('error' => true, 'message' => 'not found'), 404);
		}

		$inputData = Input::all();		
		$this->updateValuesInResource($project, $inputData);		
		$this->handleAdditionalDistricts($project, $inputData);
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
			$resource["updated_by"] = Auth::user()->full_name;
			//$project->created_by = Auth::user()->full_name;
		}
	}

	private function canSave()
	{
		// TODO: Granulate this.
		return Auth::user()->hasRole("Role 1") || 
			Auth::user()->hasRole("Role 7");
	}

	private function notAuthorized()
	{		
		return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
	}

	private function log($text)
	{
		file_put_contents("C:\\Prosjekter\\serolog.txt", $text, FILE_APPEND | LOCK_EX);
	}
}