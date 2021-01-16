<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EiaPermit extends Model
{
    use SoftDeletes;

    protected $table = 'eias_permits';
    protected $dates = ['deleted_at','date_inspection','date_sent_ded_approval','date_decision','date_fee_notification','date_fee_payed','date_certificate','date_cancelled'];
    protected $fillable = ['project_id','teamleader_id','cost','status','user_id','inspection_recommended','date_inspection','officer_recommend','fee','date_sent_ded_approval','decision','date_decision','date_fee_notification','date_fee_payed','fee_receipt_no','designation','date_certificate','certificate_no','date_cancelled','remarks','cost_currency', 'fee_currency', 'file_metadata_id', 'expected_jobs_created', 'email_contact'];
    protected $hidden = ['deleted_at'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'eias_permits_personnel');
    }

    public function teamleader()
    {
        return $this->belongsTo('App\Practitioner');
    }

    public function teammembers()
    {
        return $this->belongsToMany('App\Practitioner', 'team_members');
    }

    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function certificate()
    {
        return $this->hasOne('App\FileMetadata', 'id', 'file_metadata_id');
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