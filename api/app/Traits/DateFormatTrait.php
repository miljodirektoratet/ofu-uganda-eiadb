<?php
namespace App\Traits;

trait DateFormatTrait
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d 00:00:00');
    }
}