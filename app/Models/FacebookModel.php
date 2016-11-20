<?php

namespace App\Models;

use App\Helpers\TagsHelper;

class FacebookModel
{
    public static function searchPhotos($data, $tags, $text)
    {
        foreach ($data as &$album)
            if (isset($album['photos']))
                foreach ($album['photos']['data'] as $key => $photo)
                {
                    $photo_tags = TagsHelper::getContentTags($tags, $photo['id']);

                    if(stripos($photo_tags, $text) === false &&
                        stripos(@$photo['name'], $text) === false &&
                        stripos(@$photo['place']['location']['city'], $text) === false &&
                        stripos(@$photo['place']['location']['country'], $text) === false &&
                        stripos($photo['created_time'], $text) === false)
                    {
                        $isset_name = false;

                        if(isset($photo['tags']['data']))
                            foreach($photo['tags']['data'] as $people)
                                if(stripos($people['name'], $text) !== false)
                                {
                                    $isset_name = true;
                                    break;
                                }

                        if(!$isset_name)
                            unset($album['photos']['data'][$key]);
                    }
                }

        return $data;
    }
}