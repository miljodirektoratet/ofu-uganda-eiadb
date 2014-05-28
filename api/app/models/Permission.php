<?php

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{			
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');	
}