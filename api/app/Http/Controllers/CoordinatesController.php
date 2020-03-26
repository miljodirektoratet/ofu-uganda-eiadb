<?php namespace App\Http\Controllers;

class CoordinatesController extends Controller
{
    public function fetchTile($fileName)
    {
        return file_get_contents('./app/vendor/tiles/'.$fileName);
    }
}