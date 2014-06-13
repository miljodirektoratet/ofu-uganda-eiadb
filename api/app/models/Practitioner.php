<?php

class Practitioner extends Eloquent 
{    
    protected $softDelete = true;        
	protected $fillable = array('person','tin','organisation_name','visiting_address','box_no','city','phone','fax','email','qualifications','expertise','remarks');
    protected $hidden = array('deleted_at'); 

    public function practitionerCertificates()
    {
        return $this->hasMany('PractitionerCertificate');
    }
}