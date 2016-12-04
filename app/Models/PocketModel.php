<?php

namespace App\Models;

use App\Helpers\SocialHelper;
use App\Helpers\TagsHelper;

class PocketModel
{
    public static function searchContent($data, $tags, $text)
    {
        $data = get_object_vars($data);

        foreach ($data as $key => $item)
        {
            $data_array = [
                TagsHelper::getContentTags($tags, $item->item_id),
                $item->resolved_title,
                $item->excerpt
            ];

            if(isset($item->tags))
                foreach ($item->tags as $tag_item)
                    $data_array[] = $tag_item->tag;

            if(!SocialHelper::issetWordsInData($data_array, $text))
                unset($data[$key]);
        }

        return $data;
    }
}