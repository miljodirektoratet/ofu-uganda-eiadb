<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class District extends Eloquent 
{    	
	use SoftDeletingTrait;	
	protected $dates = ['deleted_at'];
	protected $guarded = array('id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at');
	protected $hidden = array('deleted_at'); 

  public function projects()
  {
      return $this->hasMany('Project');
  }	
}