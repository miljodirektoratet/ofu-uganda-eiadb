<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model 
{        
  use SoftDeletes;  

  protected $dates = ['deleted_at'];
  protected $fillable = ['tin','name','visiting_address','box_no','city','phone','fax','email','contact_person','remarks'];
  protected $hidden = ['deleted_at'];


  public function projects()
  {
    return $this->hasMany('App\Project');
  }

  public static function boot()
  {        
    parent::boot();    
    
    // Soft delete children as well?
    static::deleted(function($organisation)
    {
      //$organisation->projects()->delete();
    });
  }
}