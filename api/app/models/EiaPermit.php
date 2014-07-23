<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class EiaPermit extends Eloquent 
{        
    protected $table = 'eias_permits';
    use SoftDeletingTrait;  
    protected $dates = ['deleted_at'];  
    protected $fillable = array('project_id','teamleader_id','cost','status','user_id','inspection_recommended','date_inspection','officer_recommend','fee','date_sent_ded_approval','decision','date_decision','date_fee_notification','date_fee_payed','fee_receipt_no','designation','date_certificate','certificate_no','date_cancelled','remarks');
    protected $hidden = array('deleted_at');
	
    public function project()
    {
        return $this->belongsTo('Project');
    }    

    public function user()
    {
        return $this->belongsTo('User');
    }    

        public function teamleader()
    {
        return $this->belongsTo('Practitioner');
    }  

    public static function boot()
    {        
        parent::boot();    
        
        // Soft delete children as well        
        static::deleted(function($eiapermit)
        {
            //$eiapermit->documents()->delete();
        });
    }
}