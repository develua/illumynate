<?php

namespace App\Http\Controllers\Social;

use App\Models\InstagramModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use Vinkla\Instagram\Facades\Instagram;
use League\OAuth2\Client\Token\AccessToken;
use App\Models\SocialAccount;
use App\Models\ContentTag;

class InstagramController extends Controller
{
    const PROVIDER = 'instagram';
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
            Instagram::setAccessToken(new AccessToken(['access_token' => $social_account->access_token]));
            $social_data = Instagram::users()->getMedia('self')->getRaw('data');
            $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);

            if(!empty($request->input('text-search')))
                $social_data = InstagramModel::searchPhotos($social_data, $tags, $request->input('text-search'));

            return view('parts.social.instagram-photos')
                ->withData($social_data)
                ->withTags($tags);
        }

        return view('parts.button-auth')->withProvider(self::PROVIDER);
    }

    public function auth()
    {
        return Socialite::with(self::PROVIDER)->redirect();
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
