<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model 
{     
  use SoftDeletes;
  
  protected $dates = ['deleted_at'];
  protected $fillable = ['district','hasc','iso','fips','region'];
  protected $hidden = ['deleted_at'];

  public function projects()
  {
    return $this->hasMany('App\Project');
  } 
}