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

		$resources = Practitioner::
			with(array('practitionerCertificates'=>$withFunction))
			//->take(10)
			->get(array('id', 'person', 'organisation_name', 'visiting_address', 'city'));					
	
		return Response::json($resources->toArray(), 200);	 
	}


	/**
	 * Store a newly created resource in storage. POST /resource
	 *
	 * @return Response
	 */
	public function store()
	{		
		$data = Input::all();

		$resource = new Practitioner($data);	    
				 
		// Validation and Filtering is sorely needed!!
		// Seriously, I'm a bad person for leaving that out.
	 
		$resource->save();

		$resource = Practitioner::find($resource->id);
	 
		return Response::json($resource->toArray(), 200);
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
		// $resource = Practitioner::with('practitionerCertificates')
		// 	->where('id', $id)
		// 	->take(1)					
		// 	->get();
		
		$resource = Practitioner::where('id', $id)
			->take(1)
			->with('practitionerCertificates')			
			->get();			
		return Response::json($resource->toArray()[0], 200);
	}

	/**
	 * Update the specified resource in storage. PUT/PATCH /resource/:id
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$resource = Practitioner::find($id);

		if (!$resource)
		{
			return Response::json(array('error' => true, 'message' => 'not found'), 404);
		}

		$data = Input::all();
		$this->updateValuesInResource($resource, $data);	    

		$resource->save();

		return Response::json($resource->toArray(), 200);
	}

	private function updateValuesInResource($resource, $data)
	{
		foreach ($data as $key => $value)
		{
			if (in_array($key, $resource["fillable"], true))
			{    		
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
		$resource = Practitioner::find($id);	 
		$resource->delete();	 	 	
		return Response::json(array(
				'error' => false,
				'message' => 'resource deleted'),
				200
				);
	}
}