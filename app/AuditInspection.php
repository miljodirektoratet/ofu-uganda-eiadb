<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class AuditInspection extends Model
{
    use SoftDeletes;
    use DateFormatTrait;

    protected $table = 'audits_inspections';
    protected $dates = ['deleted_at', 'date_carried_out', 'date_action_taken', 'date_deadline', 'date_closing'];
    protected $fillable = ['year', 'number', 'code', 'type', 'coordinated', 'advance_notice', 'date_carried_out', 'days', 'findings', 'recommendations', 'date_action_taken', 'action_taken', 'external_participants', 'date_deadline', 'date_closing', 'project_id', 'status', 'reason', 'file_metadata_id', 'file_metadata_report_id', 'remarks', 'lead_officer', 'performance_level'];
    protected $hidden = ['deleted_at'];

    private $migrationKey;
    private $filePath;

    public function __construct()
    {
        $this->migrationKey = config('app.migration_key');
        $this->filePath =   url('/') . '/api/migration/file';
    }
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function leadOfficer()
    {
        return $this->hasOne('App\User', 'id', 'lead_officer');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'audits_inspections_personnel');
    }

    public function leadagencies()
    {
        return $this->belongsToMany('App\LeadAgency', 'audits_inspections_lead_agencies');
    }

    public function actionTakenLetter()
    {
        return $this->hasOne('App\FileMetadata', 'id', 'file_metadata_id')->select(
            '*',
            \DB::raw("CONCAT('" . $this->filePath . "/',file_metadata.id, '?key=" . $this->migrationKey . "') as file_path")
        );
    }

    public function reportFile()
    {
        return $this->hasOne('App\FileMetadata', 'id', 'file_metadata_report_id')->select(
            '*',
            \DB::raw("CONCAT('" . $this->filePath . "/',file_metadata.id, '?key=" . $this->migrationKey . "') as file_path")
        );
    }

    public function documentation()
    {

        return $this->belongsToMany('App\FileMetadata', 'audits_inspections_documentation')->select(
            '*',
            \DB::raw("CONCAT('" . $this->filePath . "/',file_metadata.id, '?key=" . $this->migrationKey . "') as file_path")
        );
    }
}
