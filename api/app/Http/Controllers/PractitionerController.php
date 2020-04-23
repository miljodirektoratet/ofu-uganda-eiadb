<?php namespace App\Http\Controllers;

use Auth;
use Input;
use Response;
use \App\Practitioner;
use \App\PractitionerCertificate;
use \DateTime;

class PractitionerController extends Controller
{
    // GET /resource
    public function index()
    {
        //return public list if user is not logged in
        if (!Auth::check()) {
            return  $this->getPublic();
        }

        $withFunction = function ($query) {
            //$year = intval(date("Y"));
            $query->select('id', 'practitioner_id', 'year', 'cert_type', 'conditions', 'is_cancelled');
            // ->where('year', '=', $year);
        };

        $practitioners = Practitioner::
            with(array('practitionerCertificates' => $withFunction))
            ->orderBy('person', 'ASC')
        //->take(3)
            ->get(array('id', 'person', 'organisation_name', 'visiting_address', 'city'));

        return Response::json($practitioners->toArray(), 200);
    }

    public function getPublic()
    {
        $practitioners = Practitioner::with('validCertificates')
            ->has('validCertificates')
            ->get(['id',
                'person',
                'tin',
                'organisation_name',
                'visiting_address',
                'box_no',
                'city',
                'phone',
                'fax',
                'email',
                'qualifications',
                'expertise',
                'remarks']);

//
        foreach ($practitioners as $p) {
            $cs = $p["validCertificates"];
            // 50 = EIA
            // 51 = EA
            // 52 = EP
            $eia = null;
            $ea = null;
            $ep = null;
            foreach ($cs as $c) {
                unset($c["practitioner_id"]);
                if (!$eia && $c->cert_type == 50) {
                    $eia = $c;
                }
                if (!$ea && $c->cert_type == 51) {
                    $ea = $c;
                }
                if (!$ep && $c->cert_type == 52) {
                    $ep = $c;
                }
            }

            unset($p["validCertificates"]);

            $p["certificate_eia"] = $eia;
            $p["certificate_ea"] = $ea;
            $p["certificate_ep"] = $ep;
        }

        return Response::json($practitioners->toArray(), 200);
    }

    // GET /resource/:id
    public function show($id)
    {
        // Make sure current user owns the requested resource
        // $practitioner = Practitioner::with('practitionerCertificates')
        //     ->where('id', $id)
        //     ->take(1)
        //     ->get();

        $practitioner = Practitioner::with(array('practitionerCertificates' => function ($query) {
            $query->orderBy('year', 'DESC')->orderBy('cert_type', 'DESC');
        }))->find($id);
        return Response::json($practitioner, 200);
    }

    // POST /resource
    public function store()
    {
        if (!$this::canSave()) {
            return $this::notAuthorized();
        }

        $inputData = Input::all();
        $practitioner = new Practitioner();
        $this->updateValuesInResource($practitioner, $inputData);
        $practitioner->created_by = Auth::user()->name;
        $practitioner->save();
        $this->handleCertificates($practitioner, $inputData);
        // Validation and Filtering is sorely needed!!

        return $this->show($practitioner->id);
    }

    // PUT/PATCH /resource/:id
    public function update($id)
    {
        if (!$this::canSave()) {
            return $this::notAuthorized();
        }

        $practitioner = Practitioner::with('practitionerCertificates')->find($id);
        if (!$practitioner) {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = Input::all();
        $this->updateValuesInResource($practitioner, $inputData);
        $practitioner->save();
        $certificatesChanged = $this->handleCertificates($practitioner, $inputData);
        if ($certificatesChanged) {
            $practitioner->updated_by = Auth::user()->name;
            $practitioner->save();
        }
        return $this->show($practitioner->id);
    }

    // DELETE /resource/:id
    public function destroy($id)
    {
        if (!$this::canSave()) {
            return $this::notAuthorized();
        }

        $practitioner = Practitioner::find($id);
        $practitioner->delete();
        return Response::json(array('is_deleted' => true), 200);
    }

    private function handleCertificates($practitioner, $inputData)
    {
        $changed = false;
        foreach ($inputData["practitioner_certificates"] as $certificateInputData) {
            $certificate = null;
            if (array_key_exists("id", $certificateInputData)) {
                $certificateId = $certificateInputData["id"];
                $certificate = $practitioner["practitionerCertificates"]->find($certificateId);
            }
            $isDeleted = array_key_exists("is_deleted", $certificateInputData) && $certificateInputData["is_deleted"] === true;
            if ($isDeleted) {
                if ($certificate) {
                    $certificate->delete();
                    $changed = true;
                } else {
                } // New and deleted, ignore
            } else {
                if (!$certificate) {
                    $certificate = new PractitionerCertificate;
                    $certificate->created_by = Auth::user()->name;
                    $certificate->practitioner()->associate($practitioner);
                }
                $certificateChanged = $this->updateValuesInResource($certificate, $certificateInputData);
                $certificate->save();
                if ($certificateChanged) {
                    $changed = true;
                }
            }
        }
        return $changed;
    }

    private function updateValuesInResource($resource, $data)
    {
        $dates = $resource->getDates();
        $changed = false;
        foreach ($data as $key => $value) {
            if (in_array($key, $resource["fillable"], true)) {
                if ($value === "") {
                    $value = null;
                }
                if ($value && in_array($key, $dates)) {
                    $timestamp = strtotime($value . " + 12 hours");
                    if ($timestamp === false) {
                        $value = null;
                    } else {
                        $value = new DateTime();
                        $value->setTimestamp($timestamp);
                    }
                }

                if ($resource[$key] != $value) {
                    // TODO: Validate.
                    $resource[$key] = $value;
                    $changed = true;
                }
            }
        }
        if ($changed) {
            $resource["updated_by"] = Auth::user()->name;
            //$project->created_by = Auth::user()->name;
            return true;
        } else {
            return false;
        }
    }

    private function canSave()
    {
        if($user = Auth::user()) {
            return $user->hasRole("Role 6");
        }
        return false;
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
