<?php

namespace App\Models;

use App\Helpers\SocialHelper;
use App\Helpers\TagsHelper;

class FacebookModel
{
    public static function searchPhotos($data, $tags, $text)
    {
        foreach ($data as $key => $photo)
        {
            $data_array = [
                TagsHelper::getContentTags($tags, $photo['id']),
                @$photo['name'],
                @$photo['place']['name'],
                /*@$photo['place']['location']['country'],
                @$photo['place']['location']['state'],
                @$photo['place']['location']['city'],
                @$photo['place']['location']['street'],*/
                @$photo['event']['name'],
                /*@$photo['event']['location']['country'],
                @$photo['event']['location']['state'],
                @$photo['event']['location']['city'],
                @$photo['event']['location']['street'],*/
                $photo['created_time']
            ];

            if(isset($photo['tags']['data']))
                foreach($photo['tags']['data'] as $people)
                    $data_array[] = $people['name'];

            if(!SocialHelper::issetWordsInData($data_array, $text))
                unset($data[$key]);
        }

        return $data;
    }

    public static function getNewContent($data, $last_view)
    {
        foreach ($data as $key => $photo)
            if($last_view > strtotime($photo['created_time']))
                unset($data[$key]);

        return $data;
    }
}