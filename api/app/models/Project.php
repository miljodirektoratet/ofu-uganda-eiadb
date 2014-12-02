<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Project extends Eloquent 
{        
    use SoftDeletingTrait;  
    protected $dates = ['deleted_at'];  
    protected $fillable = array('title','category_id','district_id','location','longitude','latitude','has_industrial_waste_water','grade','organisation_id','remarks');
    protected $hidden = array('deleted_at');	

    public function organisation()
    {
        return $this->belongsTo('Organisation');
    }

    public function district()
    {
        return $this->belongsTo('District');
    }

    public function districts()
    {
        return $this->belongsToMany('District', 'additional_districts');
    }        

    public function eiapermits()
    {
        return $this->hasMany('EiaPermit');
    }

    public static function boot()
    {        
        parent::boot();    
        
        // Soft delete children as well        
        static::deleted(function($project)
        {
            $project->eias_permits()->delete();            
        });
    }
}