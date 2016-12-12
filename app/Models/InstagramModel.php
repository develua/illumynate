<?php

namespace App\Models;

use App\Helpers\SocialHelper;
use App\Helpers\TagsHelper;

class InstagramModel
{
    public static function searchPhotos($data, $tags, $text)
    {
        foreach ($data as $key => $media)
            if($media['type'] == 'image')
            {
                $data_array = [
                    TagsHelper::getContentTags($tags, $media['id']),
                    @$media['caption']['text'],
                    @$media['location']['name'],
                    date('m/d/Y H:i:s', $media['created_time'])
                ];

                if(isset($media['users_in_photo']))
                    foreach($media['users_in_photo'] as $people)
                        $data_array[] = @$people['user']['username'];

                if(!SocialHelper::issetWordsInData($data_array, $text))
                    unset($data[$key]);
            }

        return $data;
    }

    public static function getNewContent($data, $last_view)
    {
        foreach ($data as $key => $media)
            if($last_view > strtotime($media['created_time']))
                unset($data[$key]);

        return $data;
    }
}