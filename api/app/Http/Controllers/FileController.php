<?php namespace App\Http\Controllers;

use Request;
use Response;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\FileMetadata;

// Nginx: https://rtcamp.com/tutorials/php/increase-file-upload-size-limit/
// Apache:

class FileController extends Controller
{
    public function upload()
    {
        $file = Request::file('file');
        $tag = Request::input('tag');

        // When testing uploading of files.
        if ($file->getClientOriginalName() == "SKAL FEILE.pdf")
        {
            return Response::json(array('error' => true, 'message' => 'failed for some reason'), 503);
        }

        $extension = $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();
        $filename = self::createAsciiFilename($file->getClientOriginalName());
        $tempFilename = $file->getFilename();
        $size = $file->getSize();
        $sizeHumanReadable = self::convertToHumanFilesize($size);
        $storageFilename = self::createStorageFilename($filename, $tempFilename, $extension);

        $fileMetadata = new FileMetadata();
        $fileMetadata->filename = $filename;
        $fileMetadata->extension = $extension;
        $fileMetadata->mime = $mime;
        $fileMetadata->size_bytes = $size;
        $fileMetadata->size_human_readable = $sizeHumanReadable;
        $fileMetadata->tag = $tag;
        $fileMetadata->storage_filename = $storageFilename;
        $fileMetadata->updated_by = Auth::user()->name;
        $fileMetadata->created_by = Auth::user()->name;
        $fileMetadata->save();

        Storage::disk('local')->put($storageFilename, File::get($file));

        return Response::json($fileMetadata, 200);
    }

    public function download($id)
    {
        $fileMetadata = FileMetadata::find($id);

        if (!$fileMetadata)
        {
            return Response::json(array('error' => true, 'message' => 'not found'), 404);
        }

        //$file = Storage::disk('local')->get($fileMetadata->storage_filename);
        $pathToFile = self::getPathToStorageFile($fileMetadata);

        return response()->download($pathToFile, $fileMetadata->filename);
    }

    private function getPathToStorageFile($fileMetadata)
    {
        return storage_path("app/" . $fileMetadata->storage_filename);
    }

    private function createStorageFilename($filename, $tempFilename, $extension)
    {
        $storageFilename = $filename . '_' . $tempFilename . '.' . $extension;
        return $storageFilename;
    }

    private function createAsciiFilename($filename)
    {
        return preg_replace(array('/[^\w \(\).-]/i', '/(_)\1+/'), '_', $filename);
    }

    private function convertToHumanFilesize($bytes, $decimals = 2)
    {
        // http://jeffreysambells.com/2012/10/25/human-readable-filesize-php
        $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        // @ is sipressing any errors. Bad practise, but leave for now.
        return sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
}