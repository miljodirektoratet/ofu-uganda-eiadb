<?php namespace App\Http\Controllers;

use Response;
use Auth;
use Input;
use \DateTime;
use \App\Project;
use \App\PermitLicense;

class PermitLicenseController extends Controller
{

    // GET /resource/:id/subresource
    public function index($projectId)
    {
        if (Project::where('id', $projectId)->count() == 0)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        $withUserFunction = function ($query)
        {
            $query->select('id', 'name');
        };

        $rows = Project::find($projectId)
            ->permitlicenses()
            ->with(array('user' => $withUserFunction))
            ->get(array('id', 'status', 'date_submitted', 'user_id', 'decision', 'date_permit_license'));

        return Response::json($rows, 200);
    }

    // GET /resource/:id/subresource/:subid
    public function show($projectId, $id)
    {
        $row = Project::find($projectId)->permitlicenses()
            ->with('users')
            ->find($id);

        // Users (personnel).
        $userIds = array();
        foreach ($row->users as $user)
        {
            array_push($userIds, $user->id);
        }
        $row["user_ids"] = $userIds;
        unset($row["users"]);

        return Response::json($row, 200);
    }

    private function canSave()
    {
        // TODO: Granulate this.
        return Auth::user()->hasRole("Role 1") ||
        Auth::user()->hasRole("Role 2") ||
        Auth::user()->hasRole("Role 3") ||
        Auth::user()->hasRole("Role 4") ||
        Auth::user()->hasRole("Role 5");
    }

    private function notAuthorized()
    {
        return Response::json("Not authorized to perform this.", 403); // 403 Forbidden
    }
}