<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class Hearing extends Model
{
    use SoftDeletes;
    use DateFormatTrait;

    protected $dates = ['deleted_at', 'date_dispatched', 'date_expected', 'date_received'];
    protected $fillable = ['lead_agency', 'district_id', 'date_dispatched', 'date_expected', 'date_received', 'recommendations', 'document_id', 'remarks', 'file_metadata_id'];
    protected $hidden = ['deleted_at'];

    public function document()
    {
        return $this->belongsTo('App\Document');
    }

    public function attachment()
    {
        return $this->hasOne('App\FileMetadata', 'id', 'file_metadata_id');
    }

    public static function boot()
    {
        parent::boot();

        // Soft delete children as well
        static::deleted(function ($hearing)
        {
            //$document->hearings()->delete();
        });
    }
}