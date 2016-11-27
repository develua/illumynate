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
            {
                $isset_tag = false;

                if(isset($item->tags))
                    foreach ($item->tags as $tag_item)
                        if(stripos($tag_item->tag, $text) !== false)
                        {
                            $isset_tag = true;
                            break;
                        }

                if(!$isset_tag)
                    unset($data[$key]);
            }
        }

        return $data;
    }
}