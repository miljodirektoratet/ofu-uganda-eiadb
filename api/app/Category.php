<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model 
{
  protected $fillable = ['description_short','description_long','consequence','is_passive'];
  public $timestamps = false;

  public function projects()
  {
    return $this->hasMany('Project');
  } 
}