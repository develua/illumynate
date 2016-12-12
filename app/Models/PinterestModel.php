<?php

namespace App\Models;

use App\Helpers\SocialHelper;
use App\Helpers\TagsHelper;

class PinterestModel
{
    public static function searchContent($data, $tags, $text)
    {
        foreach ($data as $key => $item)
        {
            $data_array = [
                TagsHelper::getContentTags($tags, $item->id),
                $item->note
            ];

            if(!SocialHelper::issetWordsInData($data_array, $text))
                unset($data[$key]);
        }

        return $data;
    }

    public static function getNewContent($data, $last_view)
    {
        foreach ($data as $key => $item)
            if($last_view > strtotime($item->created_at))
                unset($data[$key]);

        return $data;
    }
}