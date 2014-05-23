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
	 
	    return Response::json(array(
	        'error' => false,
	        'resource' => $resource->toArray()),
	        200
	    );
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
	    $resource = Practitioner::where('id', $id)
	            ->take(1)
	            ->get();
	 
	    return Response::json(array(
	        'error' => false,
	        'resource' => $resource->toArray()),
	        200
	    );
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
	 
	    if ( Request::get('person') )
	    {
	        $resource->person = Request::get('person');
	    }
	 
	    if ( Request::get('email') )
	    {
	        $resource->email = Request::get('email');
	    }
	 
	    $resource->save();
	 
	    return Response::json(array(
	        'error' => false,
	        'resource' => $resource->toArray(),
	        'message' => 'resource updated'),
	        200
	    );
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