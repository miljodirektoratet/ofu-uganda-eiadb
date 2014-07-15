<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class PractitionerCertificate extends Eloquent 
{    
	use SoftDeletingTrait;  	
	protected $dates = ['deleted_at'];	
	protected $fillable = array('year','date_of_entry','cert_type','number','cert_no','conditions','is_cancelled','remarks');
	protected $hidden = array('deleted_at'); 
	
	public function practitioner()
	{
			return $this->belongsTo('Practitioner');
	}
}