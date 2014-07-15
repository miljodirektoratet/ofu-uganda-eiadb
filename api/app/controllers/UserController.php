<?php

class UserController extends BaseController 
{

    public function getInfo()
    {
        $user = Auth::user();
        $info = array('email' => $user->email, 
            'full_name' => $user->full_name,
            'roles' => $this::getRoles($user));
        $info = array_merge($info, $this::getRolesInfo($user));            

        return Response::json($info, 200);
    }

    public function impersonate($id)
    {                    
        if (Auth::user()->hasRole("Role 8") && User::find($id))
        {            
            Auth::loginUsingId($id);     
        }
        return $this::getInfo();        
    }

    public function getAll()
    {
        $users = array();
        if (Auth::user()->hasRole("Role 8"))
        {
            $users = User::all(array("id", "full_name"));
        }        
        return Response::json($users, 200);
    }    

    public function signout()
    {
        Auth::logout();
        return Response::json(array("message"=>"Signed out"), 200);
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
            array_push($roles, array("id"=>$role->id, "name"=>$role->name, "name2"=>$role->name2));
        }        
        return $roles;
    }
}