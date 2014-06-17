<?php

class PractitionerController extends BaseController {

	/**
	 * Display a listing of the resource. GET /resource
	 *
	 * @return Response
	 */
	public function index()
	{
		$withFunction = function ($query)
		{
			$query->select('id', 'practitioner_id', 'year', 'cert_type')
				->where('year', '=', 2013);
		};				

		$practitioners = Practitioner::
			with(array('practitionerCertificates'=>$withFunction))
			//->take(10)
			->get(array('id', 'person', 'organisation_name', 'visiting_address', 'city'));					
	
		return Response::json($practitioners->toArray(), 200); 
	}


	/**
	 * Store a newly created resource in storage. POST /resource
	 *
	 * @return Response
	 */
	public function store()
	{		
		$data = Input::all();

		$practitioner = new Practitioner($data);	    
				 
		// Validation and Filtering is sorely needed!!
		// Seriously, I'm a bad person for leaving that out.
	 
		$practitioner->save();

		$practitioner = Practitioner::find($practitioner->id);
	 
		return Response::json($practitioner->toArray(), 200);
	}


	/**
	 * Display the specified resource. GET /resource/:id
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Make sure current user owns the requested resource
		// $practitioner = Practitioner::with('practitionerCertificates')
		// 	->where('id', $id)
		// 	->take(1)					
		// 	->get();
		
		$practitioner = Practitioner::where('id', $id)
			->take(1)
			->with('practitionerCertificates')			
			->get();			
		return Response::json($practitioner[0], 200);
	}

	/**
	 * Update the specified resource in storage. PUT/PATCH /resource/:id
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{		
		$practitioner = Practitioner::with('practitionerCertificates')->find($id);
		if (!$practitioner)
		{
			return Response::json(array('error' => true, 'message' => 'not found'), 404);
		}

		$inputData = Input::all();
		$this->updateValuesInResource($practitioner, $inputData);
		$this->handleCertificates($practitioner, $inputData);

		/*
    $rules = array('city' => 'required|min:2');
    $validator = Validator::make($data, $rules);
    if ($validator->fails())
    {
  		var_dump($validator);
  		exit();
    }*/

		$practitioner->save();

		$practitioner = Practitioner::with('practitionerCertificates')->find($id);		
		return Response::json($practitioner->toArray(), 200);
		//return Response::json(array('message' => "Could not save."), 500);
	}

	private function handleCertificates($practitioner, $inputData)
	{						
		foreach ($inputData["practitioner_certificates"] as $certificateInputData) 
		{			
			$certificateId = $certificateInputData["id"];
			if ($certificateId)
			{
				$certificate = $practitioner["practitioner_certificates"]->find($certificateId);
				$isDeleted = array_key_exists("is_deleted", $certificateInputData) && $certificateInputData["is_deleted"]===true;
				if ($isDeleted)
				{
					$certificate->delete();					
					continue;
				}
			}
			else
			{				
				$certificate = new PractitionerCertificate;				
				$certificate->practitioner()->associate($practitioner);
			}

			$this->updateValuesInResource($certificate, $certificateInputData);		
			$certificate->save();	
		}
	}

	private function updateValuesInResource($resource, $data)
	{		
		foreach ($data as $key => $value)
		{			
			if (in_array($key, $resource["fillable"], true))
			{				
				if ($value == "")
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


	/**
	 * Remove the specified resource from storage. DELETE /resource/:id
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$practitioner = Practitioner::find($id);	 
		$practitioner->delete();	 	 	
		return Response::json(array(
				'error' => false,
				'message' => 'resource deleted'),
				200
				);
	}
}