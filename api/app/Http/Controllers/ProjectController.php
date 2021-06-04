<?php namespace App\Http\Controllers;

use Auth;
use Input;
use Response;
use \App\Organisation;
use \App\Project;
use \DateTime;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    // GET /resource
    public function index(Request $request)
    {
        $offset = (int) $request->input('offset');
        $countOnly = $request->input('countOnly');
        $searchWord = $request->input('searchWord');
        if ($countOnly) {
            return [Project::count()];
        }

        $count = $request->input('count');

        $criterias = getSearchCriterias(['title', 'location']);

        // dd($criterias);

        $withFunction = function ($query) use ($searchWord) {
            if ($searchWord) {
                $query->where('name', 'LIKE', "%$searchWord%");
            }
            $query->select('id', 'name', 'city');

        };
        $withFunction2 = function ($query) use ($searchWord) {

            $query->select('id', 'district');
        };
        $withFunction3 = function ($query) use ($searchWord) {
            $query->select('id', 'description_short as description');
        };

        $projects = Project::with(array('organisation' => $withFunction, 'district' => $withFunction2, 'category' => $withFunction3));
        foreach ($criterias as $word => $criteria) {
            $projects = $projects->where($word, 'like', '%' . $criteria . '%');
        }

        $projects = $projects->orderBy('id', 'desc');
        $projects = $projects->take($count);
        if ($offset) {
            $projects = $projects->skip($offset);
        }
        if ($searchWord) {
            $projects = $projects->where(function ($mainQuery) use ($searchWord) {

                $mainQuery->orWhere('title', 'LIKE', "%$searchWord%")
                    ->orWhere('location', 'LIKE', "%$searchWord%");
            });
        }

        $projects = $projects->get(array('id', 'title', 'category_id', 'district_id', 'location', 'organisation_id'));

        /*foreach ($projects as $project)
        {
        $project["testy1"] = "hei";
        //print($project);
        //exit();
        } */

        return Response::json($projects->toArray(), 200);
    }

    // GET /resource/:id
    public function show($id)
    {
        $project = Project::
            with('districts') // I'd like to limit the belongsToMany to only the district id, but this is not currently possible in Laravel.
            ->find($id);

        if (!$project) {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $districtIds = array();
        foreach ($project->districts as $district) {
            array_push($districtIds, $district->id);
        }
        $project["district_ids"] = $districtIds;
        unset($project["districts"]);
        return Response::json($project, 200);
    }

    // POST /resource
    public function store()
    {
        if (!$this::canSave()) {
            return $this::notAuthorized();
        }

        $inputData = Input::all();
        $project = new Project();
        $this->updateValuesInResource($project, $inputData);
        $project->created_by = Auth::user()->name;
        $project->save();
        $this->handleAdditionalDistricts($project, $inputData);
        return $this->show($project->id);
    }

    // PUT/PATCH /resource/:id
    public function update($id)
    {
        if (!$this::canSave()) {
            return $this::notAuthorized();
        }

        $project = Project::with('districts')->find($id);
        if (!$project) {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $inputData = Input::all();

        $oldOrganisationId = $project->organisation_id;
        $newOrganisationId = $inputData['organisation_id'];

        $this->updateValuesInResource($project, $inputData);
        $this->handleAdditionalDistricts($project, $inputData);
        $project->save();

        if ($oldOrganisationId != $newOrganisationId) {
            $oldOrganisation = Organisation::find($oldOrganisationId);
            if ($oldOrganisation->projects()->count() === 0) {
                $oldOrganisation->delete();
            }
        }

        return $this->show($project->id);
    }

    // DELETE /resource/:id
    public function destroy($id)
    {
        if (!$this::canSave()) {
            return $this::notAuthorized();
        }

        $project = Project::find($id);

        if ($project->eiapermits()->count() > 0 || $project->auditinspections()->count() > 0) {
            return $this::notAuthorized();
        }

        $organisation = Organisation::find($project->organisation_id);

        $project->delete();

        if ($organisation->projects()->count() === 0) {
            $organisation->delete();
        }

        return Response::json(array('is_deleted' => true), 200);
    }

    private function handleAdditionalDistricts($project, $inputData)
    {
        $districtIds = array();
        if (array_key_exists("district_ids", $inputData)) {
            $districtIds = $inputData["district_ids"];
        }
        $res = $project->districts()->sync($districtIds);
        $changes = count($res["attached"]) + count($res["detached"]) + count($res["updated"]);
        if ($changes > 0) {
            $project["updated_by"] = Auth::user()->name;
        }
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
        }
    }

    private function canSave()
    {
        // TODO: Granulate this.
        return Auth::user()->hasRole("Role 1") ||
        Auth::user()->hasRole("Role 7");
    }

    private function notAuthorized()
    {
        return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
    }

    private function log($text)
    {
        file_put_contents("C:\\Prosjekter\\serolog.txt", $text, FILE_APPEND | LOCK_EX);
    }
}
