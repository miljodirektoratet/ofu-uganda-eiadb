<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

  use Authenticatable, CanResetPassword;
  use SoftDeletes;
  use EntrustUserTrait;

  protected $table = 'users';
  protected $dates = ['deleted_at'];  
  
  // remember_token???
  protected $fillable = ['initials','name','job_position_code','job_position_name','email','password','remember_token','is_passive'];
  protected $hidden = ['password', 'remember_token', 'deleted_at'];

}
