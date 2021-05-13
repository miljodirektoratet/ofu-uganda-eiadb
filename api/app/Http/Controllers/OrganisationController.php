<?php namespace App\Http\Controllers;

use Auth;
use Input;
use Request;
use Response;
use \App\Organisation;
use \DateTime;

class OrganisationController extends Controller
{

    // GET /resource
    public function index(Request $request)
    {
        $offset = (int) (Input::get('offset')) ? Input::get('offset') : 0;
        // $query = Organisation::skip($offset)->take(20)->with('projects');
        $query = \DB::table('organisations as o')
            ->join('projects as p', 'o.id', '=', 'p.organisation_id')
            ->select('o.id', 'o.name', 'o.visiting_address',
                'o.city', 'o.tin', \DB::raw('COUNT(p.id) as projectCount'))
            ->whereNull('o.deleted_at')
            ->whereNull('p.deleted_at')
            ->groupBy('o.id')
            ->orderByRaw('COUNT(o.id) desc, o.name asc');

        if ($searchWord = Input::get('searchWord')) {
            $query = $query->where(function ($mainQuery) use ($searchWord) {

                $mainQuery->orWhere('name', 'LIKE', "%$searchWord%")
                    ->orWhere('tin', 'LIKE', "%$searchWord%")
                    ->orWhere('visiting_address', 'LIKE', "%$searchWord%")
                    ->orWhere('city', 'LIKE', "%$searchWord%");
            });
        }
        //not the best way to make the count TODO:Fix query above
        $totalCount = count($query->get());
        $query = $query->skip($offset)
            ->take(20);

        $organisations = $query
            ->get();
        $currentCount = count($organisations);

        $responsePayload = [[
            'organisations' => $organisations,
            'properties' => ['currentCount' => $currentCount, 'totalCount' => $totalCount],
        ]];

        return Response::json($responsePayload, 200);
    }

    // GET /resource/:id
    public function show($id)
    {
        $organisation = Organisation::find($id);
        return Response::json($organisation, 200);
    }

    // POST /resource
    public function store()
    {
        if (!$this::canSave()) {
            return $this::notAuthorized();
        }

        $inputData = Input::all();
        $organisation = new Organisation();
        $this->updateValuesInResource($organisation, $inputData);
        $organisation->created_by = Auth::user()->name;
        $organisation->save();

        return $this->show($organisation->id);
    }

    // PUT/PATCH /resource/:id
    public function update($id)
    {
        if (!$this::canSave()) {
            return $this::notAuthorized();
        }

        $organisation = Organisation::find($id);
        if (!$organisation) {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = Input::all();
        $this->updateValuesInResource($organisation, $inputData);
        $organisation->save();
        return $this->show($organisation->id);
    }

    // DELETE /resource/:id
    public function destroy($id)
    {
        if (!$this::canSave()) {
            return $this::notAuthorized();
        }

        $organisation = Organisation::find($id);
        $organisation->delete();
        return Response::json(array('is_deleted' => true), 200);
    }

    private function updateValuesInResource($resource, $data)
    {
        $dates = $resource->getDates();
        $changed = false;
        foreach ($data as $key => $value) {
            if (in_array($key, $resource->getFillable(), true)) {
                if ($value === "") {
                    $value = null;
                }
                if ($value && in_array($key, $dates)) {
                    $timestamp = strtotime($value);
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
        }
    }

    private function canSave()
    {
        // TODO: grade needs Role 7.
        return Auth::user()->hasRole("Role 1");
    }

    private function notAuthorized()
    {
        return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
    }

}
