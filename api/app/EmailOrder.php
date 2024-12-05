<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Traits\DateFormatTrait;
use Carbon\Carbon;

class EmailOrder extends Model
{
    use SoftDeletes;
    // use DateFormatTrait;

    protected $table = 'email_orders';
    protected $fillable = [
        'number_of_attempts',
        'remarks_from_service',
        'remarks',
        'order_status',
        'updated_by',
        'recipient',
        'deleted_at'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $appends = [
        'formatted_created_at',
        'formatted_updated_at',
        'formatted_deleted_at',
        'unformatted_body'
    ];

    public function getFormattedCreatedAtAttribute()
    {
        try {
            if($this->created_at) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y-m-d');
            }
        } catch(\Exception $e) {
            return null;
        }
    }

    public function getFormattedUpdatedAtAttribute()
    {
        try {
            if($this->updated_at) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('Y-m-d');
            }
        } catch(\Exception $e) {
            return null;
        }
    }

    public function getFormattedDeletedAtAttribute()
    {
        try {
            if($this->deleted_at) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $this->deleted_at)->format('Y-m-d');
            }
        } catch(\Exception $e) {
            return null;
        }
    }

    public function getUnformattedBodyAttribute()
    {
        return str_replace('<br>', '',$this->body);
    }
}
