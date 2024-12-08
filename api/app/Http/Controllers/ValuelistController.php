<?php

namespace App\Http\Controllers;

use App\LeadAgency;
use Response;
use \App\Category;
use \App\Code;
use \App\District;
use \App\Practitioner;
use \App\User;

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
        $valuelists["eastatus"] = $this->eastatus();
        $valuelists["permitlicencestatus"] = $this->permitlicencestatus();
        $valuelists["auditinspectionstatus"] = $this->auditinspectionstatus();
        $valuelists["documenttype"] = $this->documenttype();
        $valuelists["documenttypeexternalaudits"] = $this->documenttypeexternalaudits();
        $valuelists["district"] = $this->district();
        $valuelists["category"] = $this->category();
        $valuelists["teamleader"] = $this->teamleader();
        $valuelists["teammember"] = $this->teammember();
        $valuelists["team_leader_eia_permit"] = $this->team_leader_eia_permit();
        $valuelists["officer_eia_permit"] = $this->officer_eia_permit();
        $valuelists["officer_audit_inspection"] = $this->officer_audit_inspection();
        $valuelists["executivedirector"] = $this->executivedirector();
        $valuelists["currency"] = $this->currency();
        $valuelists["auditinspectiontype"] = $this->auditinspectiontype();
        $valuelists["leadagency"] = $this->leadagency();
        $valuelists["actiontaken"] = $this->actiontaken();
        $valuelists["documentconclusion"] = $this->documentconclusion();

        $valuelists["audit_inspection_reason"] = $this->audit_inspection_reason();
        $valuelists["project_risk_level"] = $this->project_risk_level();
        $valuelists["external_audit_type"] = $this->external_audit_type();

        $valuelists["permit_license_ecosystem"] = $this->permit_license_ecosystem();
        $valuelists["permit_license_regulation_activity_wetland"] = $this->permit_license_regulation_activity_wetland();
        $valuelists["permit_license_regulations"] = $this->permit_license_regulations();
        $valuelists["permit_license_area_units"] = $this->permit_license_area_units();
        $valuelists["permit_license_waste_license_type"] = $this->permit_license_waste_license_type();
        $valuelists["permit_license_application_evaluation"] = $this->permit_license_application_evaluation();
        $valuelists["practitioner_title"] = $this->practitioner_title();

        return Response::json($valuelists, 200);
    }

    private function practitioner_title()
    {
        return $this->getCodesFromDrowdownName("practitioner_title");
    }
    private function permit_license_ecosystem()
    {
        return $this->getCodesFromDrowdownName("ecosystem");
    }

    private function permit_license_regulation_activity_wetland()
    {
        return $this->getCodesFromDrowdownName("regulation_activity_wetland");
    }

    private function permit_license_regulations()
    {
        return $this->getCodesFromDrowdownName("regulations");
    }

    private function permit_license_area_units()
    {
        return $this->getCodesFromDrowdownName("area_units");
    }

    private function permit_license_waste_license_type()
    {
        return $this->getCodesFromDrowdownName("waste_license_type");
    }

    private function permit_license_application_evaluation()
    {
        return $this->getCodesFromDrowdownName("application_evaluation");
    }

    // GET /resource/:id
    public function show($id)
    {
        if ($id === "all") {
            return $this->index();
        }

        // Not in use?
        $codes = array();
        if (method_exists($this, $id)) {
            $codes = call_user_func(array($this, $id));
        }
        return Response::json($codes, 200);
    }

    private function practitionertype()
    {
        return $this->getCodesFromDrowdownName("cert_type");
        //        return $this->getCodesFromArray(array(50, 51, 52));
    }

    private function practitionermembertype()
    {
        return $this->getCodesFromDrowdownName("practitioner");
        //        return $this->getCodesFromArray(array(38, 39, 53));
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

    private function eastatus()
    {
        return $this->getCodesFromDrowdownName("ea_status");
    }

    private function permitlicencestatus()
    {
        return $this->getCodesFromDrowdownName("permit_licence_status");
    }

    private function auditinspectionstatus()
    {
        return $this->getCodesFromDrowdownName("audit_inspection_status");
    }

    private function auditinspectiontype()
    {
        return $this->getCodesFromDrowdownName("audit_inspection_type");
    }

    //    private function documenttype()
    //    {
    //        return $this->getCodesFromArray(array(8, 9, 10, 11, 12, 13));
    //    }

    private function documenttype()
    {
        return $this->getCodesFromDrowdownName("document_type");
    }

    private function documenttypeexternalaudits()
    {
        return $this->getCodesFromDrowdownName("document_type_ea");
    }

    private function documentconclusion()
    {
        return $this->getCodesFromDrowdownName("document_conclusion");
    }

    private function district()
    {
        $districts = District::orderBy('district')
            ->get(array('id', 'district as description1'));
        return $districts;
    }

    private function category()
    {
        $districts = Category::get(array('id', 'description_long as description1'));
        return $districts;
    }

    private function teamleader()
    {
        return Practitioner::whereHas('practitionerCertificates', function ($q) {
                $q->whereRaw('conditions in (38)')->whereRaw('cert_type in (50,51)');
            })
            ->get(array('id', 'person as description1', \DB::raw("'false' as is_passive")));
    }

    private function teammember()
    {
        return Practitioner::whereHas('practitionerCertificates', function ($q) {
                $q->whereRaw('conditions in (38,39)')->whereRaw('cert_type in (50,51,148)');
            })
            ->get(array('id', 'person as description1', \DB::raw("'false' as is_passive")));
    }

    private function users_with_role($role)
    {

        $usersWithRequestedRoles = User::whereHas('roles', function ($q) use ($role) {
            $q->where('name', '=', $role);
        })->orderBy('name')
            ->get(array('id', 'name as description1', 'is_passive', 'job_position_code'))->toArray();

        $users = [];
        $activeUsers = [];
        $inActiveUsers = [];
        foreach ($usersWithRequestedRoles as $user) {
            if (strpos(strtolower($user['job_position_code']), ':non_essential') !== false) {
                continue;
            }

            if($user['is_passive'] === 0) {
                $activeUsers[] = $user;
            } else {
               $inActiveUsers[] = $user;
            }
        }
        $users = array_merge($users, $activeUsers);
        if(count($inActiveUsers)) {
            $users[] = [
                'id' => false,
                'is_passive' => true,
                'description1' => '- Inactive users below -',
            ];
            $users = array_merge($users, $inActiveUsers);
        }

        return $users;
    }

    private function team_leader_eia_permit()
    {
        return $this->users_with_role("Role 2");
    }

    private function officer_eia_permit()
    {
        return $this->users_with_role("Role 3");
    }

    private function officer_audit_inspection()
    {
        return $this->users_with_role("Role 7");
    }

    private function executivedirector()
    {
        $users = User::whereRaw("job_position_code in ('DED','ED')")
            ->get(array('id', 'name as description1'));
        return $users;
    }

    private function currency()
    {
        return $this->getCodesFromDrowdownName("currencies");
    }

    private function leadagency()
    {
        $la = LeadAgency::orderBy('short_name')
            ->get(array('id', 'short_name as description1', 'long_name as description2'));
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

    private function external_audit_type()
    {
        return $this->getCodesFromDrowdownName("external_audit_type");
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
