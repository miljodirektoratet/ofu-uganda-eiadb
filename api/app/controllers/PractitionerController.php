<?php

class PractitionerController extends BaseController {

	// GET /resource
	public function index()
	{
		$withFunction = function ($query)
		{
			$year = intval(date("Y"));
			$query->select('id', 'practitioner_id', 'year', 'cert_type', 'is_cancelled')
				->where('year', '=', $year);
		};

		$practitioners = Practitioner::
			with(array('practitionerCertificates'=>$withFunction))
			//->take(3)
			->get(array('id', 'person', 'organisation_name', 'visiting_address', 'city'));					
	
		return Response::json($practitioners->toArray(), 200); 
	}

	// GET /resource/:id
	public function show($id)
	{
		// Make sure current user owns the requested resource
		// $practitioner = Practitioner::with('practitionerCertificates')
		// 	->where('id', $id)
		// 	->take(1)					
		// 	->get();		
		$practitioner = Practitioner::with('practitionerCertificates')->find($id);
		return Response::json($practitioner, 200);
	}

	// POST /resource
	public function store()
	{		
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$inputData = Input::all();
		$practitioner = new Practitioner();	   
		$this->updateValuesInResource($practitioner, $inputData);		
		$practitioner->save();		 		
		$this->handleCertificates($practitioner, $inputData);
		// Validation and Filtering is sorely needed!!		

		return $this->show($practitioner->id);
	}	

	// PUT/PATCH /resource/:id
	public function update($id)
	{		
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$practitioner = Practitioner::with('practitionerCertificates')->find($id);
		if (!$practitioner)
		{
			return Response::json(array('error' => true, 'message' => 'not found'), 404);
		}

		$inputData = Input::all();		
		$this->updateValuesInResource($practitioner, $inputData);
		$practitioner->save();
		$this->handleCertificates($practitioner, $inputData);
    return $this->show($practitioner->id);
	}

	// DELETE /resource/:id
	public function destroy($id)
	{
		if (!$this::canSave())
		{
			return $this::notAuthorized();
		}

		$practitioner = Practitioner::find($id);	 
		$practitioner->delete();
		return Response::json(array('is_deleted' => true), 200);
	}	

	private function handleCertificates($practitioner, $inputData)
	{						
		foreach ($inputData["practitioner_certificates"] as $certificateInputData) 
		{
			$certificate = null;
			if (array_key_exists("id", $certificateInputData))
			{
				$certificateId = $certificateInputData["id"];
				$certificate = $practitioner["practitioner_certificates"]->find($certificateId);	
			}			
			$isDeleted = array_key_exists("is_deleted", $certificateInputData) && $certificateInputData["is_deleted"]===true;
			if ($isDeleted)
			{				
				if ($certificate)
				{
					$certificate->delete();					
				}
				else {} // New and deleted, ignore
			}
			else
			{
				if (!$certificate)
				{														
					$certificate = new PractitionerCertificate;
					$certificate->practitioner()->associate($practitioner);										
				}				
				$this->updateValuesInResource($certificate, $certificateInputData);		
				$certificate->save();	
			}		
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
					$timestamp = strtotime($value);
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
		return Auth::user()->hasRole("Role 6");
	}

	private function notAuthorized()
	{		
		return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
	}

}


		/*
    $rules = array('city' => 'required|min:2');
    $validator = Validator::make($data, $rules);
    if ($validator->fails())
    {
  		var_dump($validator);
  		exit();
    }*/		
    //return Response::json(array('message' => "Could not save."), 500);