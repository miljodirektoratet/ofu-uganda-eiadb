<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class LeadAgency extends Model
{
    use SoftDeletes;
    use DateFormatTrait;

//    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $fillable = ['short_name', 'long_name', 'deleted_at'];
//    protected $hidden = ['deleted_at'];
}