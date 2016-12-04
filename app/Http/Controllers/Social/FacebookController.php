<?php

namespace App\Http\Controllers\Social;

use App\Models\FacebookModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use Vinkla\Facebook\Facades\Facebook;
use App\Models\SocialAccount;
use App\Models\ContentTag;

class FacebookController extends Controller
{
    const PROVIDER = 'facebook';
    private $social_model, $content_tag_model;

    public function __construct()
    {
        $this->social_model = new SocialAccount();
        $this->content_tag_model = new ContentTag();
    }

    public function index(Request $request)
    {
        $social_account = $this->social_model->getSocialAccount(self::PROVIDER);

        if($social_account)
        {
            $social_data = Facebook::get('me/photos?fields=id,name,images,created_time,event,name_tags,place,tags&type=uploaded&limit=1000', $social_account->access_token)->getDecodedBody();
            $social_data_uploaded = Facebook::get('me/photos?fields=id,name,images,created_time,event,name_tags,place,tags&limit=1000', $social_account->access_token)->getDecodedBody();
            $social_data = array_merge($social_data['data'], $social_data_uploaded['data']);

            $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);

            if(!empty($request->input('text-search')))
                $social_data['data'] = FacebookModel::searchPhotos($social_data, $tags, $request->input('text-search'));

            return view('parts.social.facebook-photos')
                ->withData($social_data)
                ->withTags($tags);
        }

        return view('parts.button-auth')->withProvider(self::PROVIDER);
    }

    public function auth()
    {
        return Socialite::with(self::PROVIDER)->scopes(['public_profile ', 'email', 'user_photos', 'user_events'])->redirect();
    }

    public function logout()
    {
        $this->social_model->getSocialAccount(self::PROVIDER)->delete();
        return redirect('photos');
    }

    public function callback()
    {
        try
        {
            $user_social = Socialite::driver(self::PROVIDER)->user();
            $name_arr = explode(' ', $user_social->name, 2);
            $user_social['first_name'] = trim($name_arr[0]);
            $user_social['last_name'] = isset($name_arr[1]) ? trim($name_arr[1]) : null;
            $this->social_model->addOrUpdateSocialAccount($user_social, self::PROVIDER);
        }
        catch(\Exception $e)
        {
        }

        return redirect('photos');
    }

}
