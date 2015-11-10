<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'category_id', 'district_id', 'location', 'longitude', 'latitude', 'has_industrial_waste_water', 'organisation_id', 'remarks', 'risk_level'];
    protected $hidden = ['deleted_at'];

    public function organisation()
    {
        return $this->belongsTo('App\Organisation');
    }

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function districts()
    {
        return $this->belongsToMany('App\District', 'additional_districts');
    }

    public function eiapermits()
    {
        return $this->hasMany('App\EiaPermit');
    }

    public function auditinspections()
    {
        return $this->hasMany('App\AuditInspection');
    }

    public static function boot()
    {
        parent::boot();

        // Soft delete children as well
        static::deleted(function ($project)
        {
            $project->eias_permits()->delete();
        });
    }
}