<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class PermitLicense extends Model
{
    use SoftDeletes;
    use DateFormatTrait;

    protected $table = 'permits_licenses';
    protected $dates = ['date_submitted','date_feedback_to_applicants','date_sent_to_director','date_sent_from_dep','date_sent_officer','date_of_evaluation','date_inspection','date_fee_payed','date_sent_for_decision','date_decision','date_permit_license','date_permit_license_expired'];
    protected $fillable = ['project_id','status','regulation','date_submitted','waste_license_type','ecosystem','regulation_activity','area','unit','approved_by_the_lc1','approved_by_the_dec','application_number','application_fee_receipt_number','date_feedback_to_applicants','date_sent_to_director','date_sent_from_dep','date_sent_officer','user_id','application_evaluation_by_officer','date_of_evaluation','folio_no','inspection_recommended','date_inspection','officer_recommend','fee_receipt_no','date_fee_payed','date_sent_for_decision','decision','date_decision','signature_on_permit_license','date_permit_license','permit_license_no','date_permit_license_expired', 'email_contact'];
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
        return $this->belongsToMany('App\User', 'permits_licenses_personnel');
    }

    public function documentation()
    {
        return $this->belongsToMany('App\FileMetadata', 'permits_licenses_documentation')->select(array('file_metadata_id as id', 'filename', 'file_metadata.tag'));
    }
}
