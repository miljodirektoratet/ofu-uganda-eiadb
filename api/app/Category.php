<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\DateFormatTrait;

class Category extends Model
{
    use SoftDeletes;
    use DateFormatTrait;

    protected $table = 'categories';
    protected $dates = ['deleted_at'];
    protected $fillable = ['description_short', 'description_long', 'consequence', 'deleted_at'];

    public function projects()
    {
        return $this->hasMany('Project');
    }
}