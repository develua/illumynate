<?php

namespace App\Helpers;

class TagsHelper
{
    public static function getContentTags($tags, $content_id)
    {
        foreach($tags as $tag)
            if ($tag['original']['content_id'] == $content_id)
                return $tag['original']['tags'];

        return '';
    }
}