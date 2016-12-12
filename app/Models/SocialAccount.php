<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Provider;

class SocialAccount extends Model
{

    protected $table = 'social_accounts';

    protected $fillable = [
        'user_id', 'provider_id', 'first_name', 'last_name', 'email', 'profile_photo', 'access_token', 'last_view'
    ];

    // get SocialAccount where provider
    public function getSocialAccount($provider)
    {
        $user_id = Auth::user()->id;
        $provider_id = Provider::getProviderID($provider);
        return SocialAccount::whereUserId($user_id)->whereProviderId($provider_id)->first();
    }

    // add Social Account
    public function addOrUpdateSocialAccount($user, $provider)
    {
        $user_id = Auth::user()->id;
        $provider_id = Provider::getProviderID($provider);

        $social_account = SocialAccount::firstOrNew(array(
            'user_id' => $user_id,
            'provider_id' => $provider_id
        ));

        $social_account['first_name'] = $user['first_name'];
        $social_account['last_name'] = $user['last_name'];
        $social_account['email'] = $user->email;
        $social_account['profile_photo'] = $user->avatar;
        $social_account['access_token'] = $user->token;
        $social_account->save();
    }

    // update time last view
    public static function updateTimeLastView($provider)
    {
        $provider_id = Provider::getProviderID($provider);
        self::where([
            'user_id' => Auth::user()->id,
            'provider_id' => $provider_id
        ])->update(['last_view' => time()]);
    }

}
