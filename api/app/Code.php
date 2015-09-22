<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    use SoftDeletes;

    protected $table = 'codes';
    protected $dates = ['deleted_at'];
    protected $fillable = array('id', 'description1', 'description2', 'value1', 'dropdown_list');
    //protected $hidden = ['deleted_at'];
}