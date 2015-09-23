<?php

use Illuminate\Support\Facades\Input;

if (!function_exists('getSearchCriterias'))
{
    function getSearchCriterias(array $words)
    {
        $criterias = [];
        foreach ($words as $word)
        {
            if (Input::has($word))
            {
                $criterias[$word] = Input::get($word);
            }
        }
        return $criterias;
    }
}