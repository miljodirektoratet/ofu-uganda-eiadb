<?php

class PractitionerCertificate extends Eloquent 
{    
	protected $softDelete = true;    	
	protected $fillable = array('practitioner_id','year','date_of_entry','cert_type','number','cert_no','conditions','is_cancelled','remarks');
	protected $hidden = array('deleted_at'); 
	


		public function practitioner()
		{
				return $this->belongsTo('Practitioner');
		}
}