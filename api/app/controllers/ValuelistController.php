<?php

class ValuelistController extends BaseController {

	// GET /resource
	public function index()
	{		
		$valuelists = array();
		$valuelists["practitionertype"] = $this->practitionertype();
		$valuelists["practitionermembertype"] = $this->practitionermembertype();
		$valuelists["yesno"] = $this->yesno();
		$valuelists["grade"] = $this->grade();
		$valuelists["decision"] = $this->decision();
		$valuelists["status"] = $this->status();
		$valuelists["documenttype"] = $this->documenttype();
		$valuelists["district"] = $this->district();
		$valuelists["category"] = $this->category();
		$valuelists["teamleader"] = $this->teamleader();
		$valuelists["teammember"] = $this->teammember();
		$valuelists["officer"] = $this->officer();		

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

	private function yesno()
	{
		return $this->getCodesFromArray(array(40,41,42));
	}

	private function grade()
	{
		return $this->getCodesFromArray(array(43,44,45,46,47));
	}

	private function decision()
	{
		return $this->getCodesFromArray(array(1,2,3));
	}	

	private function status()
	{
		return $this->getCodesFromArray(array(15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37));
	}

	private function documenttype()
	{
		return $this->getCodesFromArray(array(8,9,10,11,12));
	}

	private function district()
	{
		$districts = District::	
			get(array('id', 'district as description1'));
		return $districts;		
	}

	private function category()
	{
		$districts = Category::			
			get(array('id', 'description_long as description1'));
		return $districts;		
	}

	private function teamleader()
	{		
		$practitioners = Practitioner::
			whereHas('practitionerCertificates', function($q)
			{
				$year = intval(date("Y"));
    		$q
    			->where('year', '=', $year)
    			->where('is_cancelled', '=', false)
    			->where('conditions', '=', 38);
			})
			->get(array('id', 'person as description1'));
		return $practitioners;		
	}

	private function teammember()
	{		
		$practitioners = Practitioner::
			whereHas('practitionerCertificates', function($q)
			{
				$year = intval(date("Y"));
    		$q
    			->where('year', '=', $year)
    			->where('is_cancelled', '=', false);
			})
			->get(array('id', 'person as description1'));
		return $practitioners;		
	}

	private function officer()
	{
		$users = User::			
			whereRaw("job_position_code in ('EIAO','EIAC')")
			->get(array('id', 'full_name as description1'));
		return $users;		
	}

	private function getCodesFromArray($codeIds)
	{
		return $codes = Code::whereRaw("id in (" . join(",", $codeIds) . ")")
			->get(array('id', 'description1', 'description2'));
	}
}