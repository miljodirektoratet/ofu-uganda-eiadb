<?php namespace App\Http\Controllers;

use App\LeadAgency;
use Response;
use \App\Practitioner;
use \App\Code;
use \App\User;
use \App\District;
use \App\Category;

class ValuelistController extends Controller
{


    // GET /resource
    public function index()
    {
        $valuelists = array();
        $valuelists["practitionertype"] = $this->practitionertype();
        $valuelists["practitionermembertype"] = $this->practitionermembertype();
        $valuelists["yesno"] = $this->yesno();
        $valuelists["grade"] = $this->grade();
        $valuelists["decision"] = $this->decision();
        $valuelists["eiastatus"] = $this->eiastatus();
        $valuelists["auditinspectionstatus"] = $this->auditinspectionstatus();
        $valuelists["documenttype"] = $this->documenttype();
        $valuelists["district"] = $this->district();
        $valuelists["category"] = $this->category();
        $valuelists["teamleader"] = $this->teamleader();
        $valuelists["teammember"] = $this->teammember();
        $valuelists["officer"] = $this->officer();
        $valuelists["executivedirector"] = $this->executivedirector();
        $valuelists["currency"] = $this->currency();
        $valuelists["auditinspectiontype"] = $this->auditinspectiontype();
        $valuelists["leadagency"] = $this->leadagency();
        $valuelists["actiontaken"] = $this->actiontaken();
        $valuelists["documentconclusion"] = $this->documentconclusion();

        $valuelists["audit_inspection_reason"] = $this->audit_inspection_reason();
        $valuelists["project_risk_level"] = $this->project_risk_level();


        return Response::json($valuelists, 200);
    }

    // GET /resource/:id
    public function show($id)
    {
        if ($id === "all")
        {
            return $this->index();
        }

        // Not in use?
        $codes = array();
        if (method_exists($this, $id))
        {
            $codes = call_user_func(array($this, $id));
        }
        return Response::json($codes, 200);
    }

    private function practitionertype()
    {
        return $this->getCodesFromArray(array(50, 51, 52));
    }

    private function practitionermembertype()
    {
        return $this->getCodesFromArray(array(38, 39, 53));
    }

    private function yesno()
    {
        return $this->getCodesFromArray(array(40, 41, 42));
    }

    private function grade()
    {
        return $this->getCodesFromArray(array(43, 44, 45, 46, 47));
    }

    private function decision()
    {
        return $this->getCodesFromArray(array(1, 2, 3));
    }

    private function eiastatus()
    {
        return $this->getCodesFromDrowdownName("eia_status");
    }

    private function auditinspectionstatus()
    {
        return $this->getCodesFromDrowdownName("audit_inspection_status");
    }

    private function auditinspectiontype()
    {
        return $this->getCodesFromDrowdownName("audit_inspection_type");
    }

    private function documenttype()
    {
        return $this->getCodesFromArray(array(8, 9, 10, 11, 12, 13));
    }

    private function documentconclusion()
    {
        return $this->getCodesFromDrowdownName("document_conclusion");
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
        whereHas('practitionerCertificates', function ($q)
        {
            $year = intval(date("Y"));
            $q
                ->whereIn('year', array($year - 1, $year))
                ->where('is_cancelled', '=', false)
                ->whereRaw('conditions in (38,53)');
        })
            ->get(array('id', 'person as description1'));
        return $practitioners;
    }

    private function teammember()
    {
        $practitioners = Practitioner::
        whereHas('practitionerCertificates', function ($q)
        {
            $year = intval(date("Y"));
            $q
                ->whereIn('year', array($year - 1, $year))
                ->where('is_cancelled', '=', false);
        })
            ->get(array('id', 'person as description1'));
        return $practitioners;
    }

    private function officer()
    {
        $users = User::
        whereRaw("job_position_code in ('SEAO','EAM','EMO','SEI','NRM(B&R)','NRM(Aq)','EIAA','EAAA','EIAO','EAMA')")
            ->get(array('id', 'name as description1'));
        return $users;
    }

    private function executivedirector()
    {
        $users = User::
        whereRaw("job_position_code in ('DED','ED')")
            ->get(array('id', 'name as description1'));
        return $users;
    }

    private function currency()
    {
        return $this->getCodesFromDrowdownName("currencies");
    }

    private function leadagency()
    {
        $la = LeadAgency::get(array('id', 'short_name as description1', 'long_name as description2'));
        return $la;
    }

    private function actiontaken()
    {
        return $this->getCodesFromDrowdownName("action_taken");
    }

    private function audit_inspection_reason()
    {
        return $this->getCodesFromDrowdownName("audit_inspection_reason");
    }

    private function project_risk_level()
    {
        return $this->getCodesFromDrowdownName("project_risk_level");
    }

    private function getCodesFromArray($codeIds)
    {
        return Code::whereRaw("id in (" . join(",", $codeIds) . ")")
            ->get(array('id', 'description1', 'description2'));
    }

    private function getCodesFromDrowdownName($dropdownName)
    {
        return Code::where("dropdown_list", "=", $dropdownName)
            ->get(array('id', 'description1', 'description2', 'value1'));
    }
}