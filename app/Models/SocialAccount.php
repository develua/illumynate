<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Provider;

class SocialAccount extends Model
{

    protected $table = 'social_accounts';

    protected $fillable = [
        'user_id', 'provider_id', 'first_name', 'last_name', 'email', 'profile_photo', 'access_token'
    ];

    // get SocialAccount where provider
    public function getSocialAccount($provider)
    {
        $user_id = Auth::user()->id;
        $provider_id = Provider::getProviderID($provider);
        return SocialAccount::whereUserId($user_id)->whereProviderId($provider_id)->first();
    }

    // add Social Account
    public function addSocialAccount($user, $provider)
    {
        $user_id = Auth::user()->id;
        $provider_id = Provider::getProviderID($provider);

        SocialAccount::create([
            'user_id' => $user_id,
            'provider_id' => $provider_id,
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'email' => $user->email,
            'profile_photo' => $user->avatar,
            'access_token' => $user->token
        ]);
    }
}
