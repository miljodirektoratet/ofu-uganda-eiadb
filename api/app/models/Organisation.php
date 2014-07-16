<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Organisation extends Eloquent 
{        
    use SoftDeletingTrait;  
    protected $dates = ['deleted_at'];  
    protected $fillable = array('tin','name','visiting_address','box_no','city','phone','fax','email','contact_person','remarks');
    protected $hidden = array('deleted_at');
	

    public function projects()
    {
        return $this->hasMany('Project');
    }

    public static function boot()
    {        
        parent::boot();    
        
        // Soft delete children as well        
        static::deleted(function($organisation)
        {
            //$organisation->projects()->delete();            
        });
    }
}