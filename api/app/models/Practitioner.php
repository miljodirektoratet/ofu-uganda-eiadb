<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Practitioner extends Eloquent 
{        
    use SoftDeletingTrait;  
    protected $dates = ['deleted_at'];  
	protected $fillable = array('person','tin','organisation_name','visiting_address','box_no','city','phone','fax','email','qualifications','expertise','remarks');
    protected $hidden = array('deleted_at'); 

    public function practitionerCertificates()
    {
        return $this->hasMany('PractitionerCertificate');
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