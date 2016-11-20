<?php

namespace App\Models;

use App\Helpers\TagsHelper;

class PinterestModel
{
    public static function searchContent($data, $tags, $text)
    {
        foreach ($data as $key => $item)
        {
            $item_tags = TagsHelper::getContentTags($tags, $item->id);

            if(stripos($item_tags, $text) === false &&
                stripos($item->note, $text) === false)
                unset($data[$key]);
        }

        return $data;
    }
}