<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PractitionerCertificate extends Model 
{    
  use SoftDeletes;
  
  protected $dates = ['deleted_at', 'date_of_entry']; 
  protected $fillable = ['year','date_of_entry','cert_type','number','cert_no','conditions','is_cancelled','remarks'];
  protected $hidden = ['deleted_at']; 
  
  public function practitioner()
  {
    return $this->belongsTo('Practitioner');
  }
}