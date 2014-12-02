<?php

class Category extends Eloquent 
{        
	protected $guarded = array('id');
	public $timestamps = false;

 	public function projects()
  {
    return $this->hasMany('Project');
  }	
}