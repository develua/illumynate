<?php

namespace App\Helpers;

class SocialHelper
{
    public static function issetWordsInData($data_array, $text)
    {
        $data_str = implode(' ', $data_array);
        $word_array = explode(' ', trim($text));

        foreach($word_array as $word)
        {
            if(empty($word) || strpos($data_str, $word) !== false)
                continue;

            return false;
        }

        return true;
    }
}