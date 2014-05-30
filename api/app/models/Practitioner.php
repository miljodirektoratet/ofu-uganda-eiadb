<?php

class Practitioner extends Eloquent 
{    
    protected $softDelete = true;    
	protected $guarded = array('id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at');
    protected $hidden = array('deleted_at'); 

    public function practitionerCertificates()
    {
        return $this->hasMany('PractitionerCertificate');
    }

    public function validCertificate()
    {
        return $this->hasOne('PractitionerCertificate')
        	->where('is_cancelled', '=', 0)
			->orderBy('year', 'desc')
			->take(1);
    }
}