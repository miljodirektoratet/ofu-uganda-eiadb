<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Traits\DateFormatTrait;

class Code extends Model
{
    use SoftDeletes;
    // use DateFormatTrait;

    protected $table = 'codes';
    protected $dates = ['deleted_at'];
    protected $fillable = array('id', 'description1', 'description2', 'value1', 'dropdown_list', 'deleted_at');
    //protected $hidden = ['deleted_at'];
}