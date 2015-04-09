<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Practitioner extends Model 
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];  
  protected $fillable = ['person','tin','organisation_name','visiting_address','box_no','city','phone','fax','email','qualifications','expertise','remarks'];
  protected $hidden = ['deleted_at']; 

  public function practitionerCertificates()
  {
    return $this->hasMany('App\PractitionerCertificate');
  }

  public static function boot()
  {        
    parent::boot();    
    
    // Soft delete children as well        
    static::deleted(function($practitioner)
    {
      $practitioner->practitionerCertificates()->delete();            
    });
  }
}