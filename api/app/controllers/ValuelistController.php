<?php

class ValuelistController extends BaseController {

	// GET /resource
	public function index()
	{		
		$valuelists = array();
		$valuelists["practitionertype"] = $this->practitionertype();
		$valuelists["practitionermembertype"] = $this->practitionermembertype();

		return Response::json($valuelists, 200); 
	}

	// GET /resource/:id
	public function show($id)
	{
		if ($id === "all")
		{
			return $this->index();
		}
		
		$codes = array();
		if (method_exists ($this, $id))
		{			
			$codes = call_user_func(array($this, $id));		
		}
		return Response::json($codes, 200);
	}

	private function practitionertype()
	{
		return $this->getCodesFromArray(array(10,12));		
	}

	private function practitionermembertype()
	{
		return $this->getCodesFromArray(array(38,39));
	}

	private function getCodesFromArray($codeIds)
	{
		return $codes = Code::whereRaw("id in (" . join(",", $codeIds) . ")")->get()->toArray();
	}
}