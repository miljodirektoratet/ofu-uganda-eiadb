<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class ExternalAudit extends Model
{
    use SoftDeletes;
    use DateFormatTrait;

    protected $table = 'external_audits';
    protected $dates = ['deleted_at','date_inspection','date_response','date_deadline_compliance', 'date_invoice_payment', 'date_invoice_receipt_issued', 'date_create_invoice'];
    protected $fillable = ['project_id','teamleader_id','status','user_id','verification_inspection','date_inspection','date_response','file_metadata_response_id','response','review_findings','date_deadline_compliance', 'type', 'email_contact','date_invoice_payment', 'date_invoice_receipt_issued', 'date_create_invoice'];
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
        return $this->belongsToMany('App\User', 'external_audits_personnel');
    }

    public function teamleader()
    {
        return $this->belongsTo('App\Practitioner');
    }

    public function teammembers()
    {
        return $this->belongsToMany('App\Practitioner', 'team_members_external_audits');
    }

    public function documents()
    {
        return $this->hasMany('App\Document');
    }

    public function response_document()
    {
        return $this->hasOne('App\FileMetadata', 'id', 'file_metadata_response_id');
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