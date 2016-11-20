<?php

namespace App\Models;

use App\Helpers\TagsHelper;

class InstagramModel
{
    public static function searchPhotos($data, $tags, $text)
    {
        foreach ($data as $key => $media)
            if($media['type'] == 'image')
            {
                $photo_tags = TagsHelper::getContentTags($tags, $media['id']);

                if(stripos($photo_tags, $text) === false &&
                    stripos(@$media['caption']['text'], $text) === false &&
                    stripos(@$media['location']['name'], $text) === false &&
                    stripos(date('m/d/Y H:i:s', $media['created_time']), $text) === false)
                {
                    $isset_name = false;

                    if(isset($media['users_in_photo']))
                        foreach($media['users_in_photo'] as $people)
                            if(stripos(@$people['user']['username'], $text) !== false)
                            {
                                $isset_name = true;
                                break;
                            }

                    if(!$isset_name)
                        unset($data[$key]);
                }
            }

        return $data;
    }
}