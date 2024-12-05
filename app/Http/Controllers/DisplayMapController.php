<?php namespace App\Http\Controllers;

class DisplayMapController extends Controller
{
    public function plotProjects()
    {
        return view('projects-map');
    }
}