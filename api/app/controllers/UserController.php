<?php

class UserController extends BaseController 
{

    public function getIndex()
    {
        return View::make('user');
    }

    public function postProfile()
    {
        return "postProfile";
    }

    public function getAdminProfile() 
    {
    	return "admin profile";
    }
}