<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Document extends Eloquent 
{            
    use SoftDeletingTrait;  
    protected $dates = ['deleted_at','date_submitted','date_sent_director','date_copies_coordinator','date_next_appointment','date_sent_from_dep','date_sent_officer'];  
    protected $fillable = array('date_submitted','sub_final','sub_copy_no','title','type','number','code','consultent','director_copy_no','date_sent_director','coordinator_copy_no','date_copies_coordinator','date_next_appointment','date_sent_from_dep','date_sent_officer','folio_no','conclusion','eia_permit_id','control_id','remarks');
    protected $hidden = array('deleted_at');    
	
    public function eiaPermit()
    {
        return $this->belongsTo('EiaPermit');
    }           

    public static function boot()
    {        
        parent::boot();    
        
        // Soft delete children as well        
        static::deleted(function($document)
        {
            //$document->hearings()->delete();
        });
    }
}