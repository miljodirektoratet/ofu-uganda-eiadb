<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadAgency extends Model 
{
  public $timestamps = false;
  protected $fillable = ['short_name', 'long_name'];  
}