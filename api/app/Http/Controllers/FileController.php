<?php namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class FileController extends Controller
{

    public function index()
    {
        //$entries = Fileentry::all();

//        return Response::json($entries->toArray(), 200);
    }

    public function upload()
    {
        $file = Request::file('file');
        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put($file->getFilename() . '.' . $extension, File::get($file));
        //$entry = new Fileentry();
        //$entry->mime = $file->getClientMimeType();
        //$entry->original_filename = $file->getClientOriginalName();
        //$entry->filename = $file->getFilename() . '.' . $extension;
        //$entry->save();

        return [$file->getClientOriginalName(), $file->getClientMimeType()];

    }
}