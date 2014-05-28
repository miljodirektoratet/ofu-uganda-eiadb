<?php

class Code extends Eloquent 
{
    protected $softDelete = true;
		protected $guarded = array('id');
		public $timestamps = false;
}