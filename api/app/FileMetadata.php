<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileMetadata extends Model
{
    use SoftDeletes;

    protected $table = 'file_metadata';
    protected $dates = ['deleted_at'];
    protected $fillable = ['filename', 'storage_filename', 'extension', 'mime', 'size_bytes', 'size_human_readable'];
    protected $hidden = ['deleted_at'];
}