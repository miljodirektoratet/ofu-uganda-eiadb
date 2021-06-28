<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class EmailOrder extends Model
{
    use SoftDeletes;
    use DateFormatTrait;

    protected $table = 'email_orders';
    protected $fillable = ['number_of_attempts', 'remarks_from_service', 'remarks', 'order_status', 'updated_by', 'recipient', 'deleted_at'];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
