<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class Organisation extends Model 
{        
  use SoftDeletes;
  use DateFormatTrait;

  protected $dates = ['deleted_at'];
  protected $table = 'organisations';
  protected $fillable = ['tin','name','visiting_address','physical_address','box_no','city','phone','fax','email','remarks'];
  protected $hidden = ['deleted_at'];


  public function projects()
  {
    return $this->hasMany('App\Project');
  }

//  public static function boot()
//  {
//    parent::boot();
//
//    // Soft delete children as well?
//    static::deleted(function($organisation)
//    {
//      //$organisation->projects()->delete();
//    });
//  }
}