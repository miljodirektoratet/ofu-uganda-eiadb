<?php

use Illuminate\Support\Facades\Input;

if (!function_exists('getSearchCriterias'))
{
    function getSearchCriterias(array $words)
    {
        $criterias = [];
        foreach ($words as $word)
        {
            $param = request()->input($word);
            if ($param)
            {
                $criterias[$word] = $param;
            }
        }
        return $criterias;
    }
}