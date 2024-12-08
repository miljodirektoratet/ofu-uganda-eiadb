<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class Document extends Model
{
    use SoftDeletes;
    use DateFormatTrait;

    protected $dates = ['deleted_at', 'date_submitted', 'date_sent_director', 'date_copies_coordinator', 'date_next_appointment', 'date_sent_from_dep', 'date_sent_officer', 'date_conclusion'];
    protected $fillable = ['date_submitted', 'sub_copy_no', 'title', 'type', 'number', 'code', 'consultent', 'director_copy_no', 'date_sent_director', 'coordinator_copy_no', 'date_copies_coordinator', 'date_next_appointment', 'date_sent_from_dep', 'date_sent_officer', 'folio_no', 'conclusion', 'eia_permit_id', 'control_id', 'remarks', 'file_metadata_id', 'file_metadata_response_id', 'date_conclusion', 'external_audit_id', 'remarks_director', 'remarks_team_leader'];
    protected $hidden = ['deleted_at'];

    //    public function eiaPermit()
    //    {
    //        return $this->belongsTo('App\EiaPermit');
    //    }

    public function attachment()
    {
        $providedKey = config('app.migration_key');
        $filePath =   url('/') . '/api/migration/file';
        return $this->hasOne('App\FileMetadata', 'id', 'file_metadata_id')->select(
            '*',
            \DB::raw("CONCAT('" . $filePath . "/',file_metadata.id, '?key=" . $providedKey . "') as file_path")
        );
    }

    public function response_document()
    {
        $providedKey = config('app.migration_key');
        $filePath =   url('/') . '/api/migration/file';
        return $this->hasOne('App\FileMetadata', 'id', 'file_metadata_response_id')->select(
            '*',
            \DB::raw("CONCAT('" . $filePath . "/',file_metadata.id, '?key=" . $providedKey . "') as file_path")
        );
    }

    public function hearings()
    {
        return $this->hasMany('App\Hearing');
    }

    public function eiaPermit()
    {
        return $this->belongsTo('App\EiaPermit');
    }

    public function externalAudit()
    {
        return $this->belongsTo('App\ExternalAudit');
    }

    public static function boot()
    {
        parent::boot();

        // Soft delete children as well
        static::deleted(function ($document) {
            //$document->hearings()->delete();
        });
    }
}
