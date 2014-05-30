<?php

class PractitionerController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
			$resources = Practitioner::all();
	
			return Response::json($resources->toArray(),
					200		
				);	 
	}


	/**
	 * Store a newly created resource in storage.
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
	 * Display the specified resource.
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
			->with('validCertificate')			
			->get();			
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
			$resource = Practitioner::find($id);

			if (!$resource)
			{
				return Response::json(array(
						'error' => true,
						'message' => 'not found'),
						404
				);
			}

			$data = Input::all();
			$this->updateValuesInResource($resource, $data);	    

			$resource->save();

			return Response::json($resource->toArray(), 200);
	}


	/**
	 * Remove the specified resource from storage.
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