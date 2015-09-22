<?php

use Illuminate\Support\Facades\Input;

if (!function_exists('getSearchCriterias'))
{


    /**
     * Assign high numeric IDs to a config item to force appending.
     *
     * @param  array $array
     * @return array
     */
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