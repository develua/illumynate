<?php

namespace App\Models;

use App\Helpers\TagsHelper;

class PocketModel
{
    public static function searchContent($data, $tags, $text)
    {
        $data = get_object_vars($data);

        foreach ($data as $key => $item)
        {
            $item_tags = TagsHelper::getContentTags($tags, $item->item_id);

            if(stripos($item_tags, $text) === false &&
                    stripos($item->resolved_title, $text) === false &&
                    stripos($item->excerpt, $text) === false)
                unset($data[$key]);
        }

        return $data;
    }
}