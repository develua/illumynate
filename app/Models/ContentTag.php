<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Provider;

class ContentTag extends Model
{
    protected $table = 'content_tags';

    protected $fillable = [
        'id', 'user_id', 'provider_id', 'content_id', 'tags'
    ];

    // add or update tags
    public function updateTags($data)
    {
        $user_id = Auth::user()->id;
        $provider_id = Provider::getProviderID($data['provider']);

        $content_tags = self::firstOrNew(array(
            'user_id' => $user_id,
            'provider_id' => $provider_id,
            'content_id' => $data['content_id']
        ));

        $content_tags->tags = $data['tags'];
        $content_tags->save();
    }

    // get all tegs
    public function getProviderTegs($provider)
    {
        $user_id = Auth::user()->id;
        $provider_id = Provider::getProviderID($provider);

        return ContentTag::where(array(
            'user_id' => $user_id,
            'provider_id' => $provider_id
        ))->get();
    }
}
