<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class Practitioner extends Model
{
    use SoftDeletes;
    use DateFormatTrait;

    protected $dates = ['deleted_at'];
    protected $fillable = ['practitioner_title_id', 'person', 'tin', 'organisation_name', 'visiting_address', 'box_no', 'city', 'phone', 'fax', 'email', 'qualifications', 'expertise', 'remarks'];
    protected $hidden = ['deleted_at'];

    public function practitionerCertificates()
    {
        return $this->hasMany('App\PractitionerCertificate');
    }

    public function validCertificates()
    {
        $year = intval(date("Y"));
        $currentMonth = intval(date("m"));
        $startingYr = ($currentMonth > 2)? $year : $year - 1;
        $endingYr = $year;
        return $this->hasMany('App\PractitionerCertificate')
            ->select('id', 'practitioner_id', 'year', 'cert_type', 'conditions', 'cert_no')
            ->whereIn('year', array($startingYr, $endingYr))
            ->where('is_cancelled', '=', false)
            ->orderBy('year', 'desc')
            ->orderBy('cert_type', 'asc')

//            ->groupBy('cert_type')
            ;
    }

    public static function boot()
    {
        parent::boot();

        // Soft delete children as well
        static::deleted(function ($practitioner)
        {
            if($practitioner->practitionerCertificates()->count()) {
                $practitioner->practitionerCertificates()->delete();
            }
        });
    }
}