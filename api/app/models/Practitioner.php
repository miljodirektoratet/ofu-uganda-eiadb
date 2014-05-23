<?php

class Practitioner extends Eloquent {
 
    protected $table = 'practitioners';
    protected $softDelete = true;

    protected $fillable = array('person', 'tin', 'organisation_name', 'visiting_address', 'box_no', 'city', 'phone',
    	'fax', 'email', 'qualifications', 'expertise', 'remarks');
 
}