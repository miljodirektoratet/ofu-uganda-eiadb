<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{	
	protected $guarded = array('id', 'created_at', 'updated_at');	
}