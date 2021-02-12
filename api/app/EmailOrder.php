<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailOrder extends Model
{
    use SoftDeletes;
    protected $fillable = ['number_of_attempts', 'remarks_from_service', 'remarks', 'order_status', 'updated_by', 'recipient'];
}
