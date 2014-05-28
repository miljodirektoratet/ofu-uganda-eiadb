<?php

class District extends Eloquent 
{    
    protected $softDelete = true;
		protected $guarded = array('id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at');
    protected $hidden = array('deleted_at'); 
}