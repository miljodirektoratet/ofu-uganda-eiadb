<?php namespace App\Http\Controllers;

use Auth;
use App;
use Response;
use \App\User;

class UserController extends Controller
{

    public function getInfo()
    {
        $user = Auth::user();
        $info = array('email' => $user->email,
            'name' => $user->name,
            'can_impersonate' => Auth::user()->hasRole("Role 8") && App::environment() !== "production",
            'roles' => $this::getRoles($user),
            'features' => $this->getFeatures());
    $info = array_merge($info, $this->getRolesInfo($user));
    return Response::json($info, 200);
  }

    public function impersonate($id)
    {
        if (Auth::user()->hasRole("Role 8") && \App\User::find($id))
        {
            Auth::loginUsingId($id);
        }
        return $this->getInfo();
    }

    public function getAll()
    {
        $users = array();
        if (Auth::user()->hasRole("Role 8"))
        {
            $users = User::all(array("id", "name"));
        }
        return Response::json($users, 200);
    }

    public function signout()
    {
        Auth::logout();
        return Response::json(array("message" => "Signed out"), 200);
    }

    private function getRolesInfo($user)
    {
        $roles = array();
        $roles["role_1"] = $user->hasRole("Role 1");
        $roles["role_2"] = $user->hasRole("Role 2");
        $roles["role_3"] = $user->hasRole("Role 3");
        $roles["role_4"] = $user->hasRole("Role 4");
        $roles["role_5"] = $user->hasRole("Role 5");
        $roles["role_6"] = $user->hasRole("Role 6");
        $roles["role_7"] = $user->hasRole("Role 7");
        $roles["role_8"] = $user->hasRole("Role 8");
        return $roles;
    }

    private function getRoles($user)
    {
        $roles = array();
        foreach ($user->roles as $role)
        {
            array_push($roles, array("id" => $role->id, "name" => $role->name, "display_name" => $role->display_name));
        }
        return $roles;
    }

    private function getFeatures()
    {
        $isDev = App::environment() === "local";
        //$isTest = App::environment() === "test";
        $isProduction = App::environment() === "production";

        $features = array();
        $features["notproduction"] = !$isProduction;
        //$features["fileupload"] = true;
        //$features["auditsinspections"] = true;
        //$features["search"] = true;
        //$features["advanced"] = $isDev;
        return $features;
    }
}
