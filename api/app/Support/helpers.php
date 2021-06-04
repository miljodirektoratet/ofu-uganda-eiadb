<?php

use Illuminate\Support\Facades\Input;

if (!function_exists('getSearchCriterias'))
{
    function getSearchCriterias(array $words)
    {
        $passedParams = collect(request()->query);
        $criterias = [];
        foreach ($words as $word)
        {
            $param = $passedParams->get($word);
            if ($param)
            {
                $criterias[$word] = param;
            }
        }
        return $criterias;
    }
}