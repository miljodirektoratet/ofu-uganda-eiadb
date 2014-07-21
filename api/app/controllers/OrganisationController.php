<?php

class OrganisationController extends BaseController {

	// GET /resource
	public function index()
	{	
		$organisations = Organisation::						
			get(array('id', 'name', 'visiting_address', 'city', 'contact_person'));
	
		return Response::json($organisations->toArray(), 200); 
	}

	// GET /resource/:id
	public function show($id)
	{		
		$organisation = Organisation::find($id);		
		return Response::json($organisation, 200);
	}

	// POST /resource
	public function store()
	{		
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$inputData = Input::all();
		$organisation = new Organisation();	   
		$this->updateValuesInResource($organisation, $inputData);		
		$organisation->save();		

		return $this->show($organisation->id);
	}	

	// PUT/PATCH /resource/:id
	public function update($id)
	{		
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$organisation = Organisation::find($id);
		if (!$organisation)
		{
			return Response::json(array('error' => true, 'message' => 'not found'), 404);
		}

		$inputData = Input::all();		
		$this->updateValuesInResource($organisation, $inputData);
		$organisation->save();		
    return $this->show($organisation->id);
	}

	// DELETE /resource/:id
	public function destroy($id)
	{
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$organisation = Organisation::find($id);	 
		$organisation->delete();
		return Response::json(array('is_deleted' => true), 200);
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
		// TODO: grade needs Role 7.
		return Auth::user()->hasRole("Role 1");
	}

	private function notAuthorized()
	{		
		return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
	}

}