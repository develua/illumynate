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
        $this->middleware('auth');

        $this->social_model = new SocialAccount();
        $this->content_tag_model = new ContentTag();
    }

    public function index($innvalid = false)
    {
        // get social account
        $social_account = $this->social_model->getSocialAccount(self::PROVIDER);

        if($social_account && !$innvalid)
            return $this->callback($social_account->access_token);

        return Socialite::with(self::PROVIDER)->redirect();
    }

    public function callback($access_token = null)
    {
        try
        {
            if(!$access_token)
            {
                $user_social = Socialite::driver(self::PROVIDER)->user();
                $access_token = $user_social->token;
                $name_arr = explode(' ', $user_social->name, 2);
                $user_social['first_name'] = trim($name_arr[0]);
                $user_social['last_name'] = isset($name_arr[1]) ? trim($name_arr[1]) : null;
                $this->social_model->addOrUpdateSocialAccount($user_social, self::PROVIDER);
            }

            Instagram::setAccessToken(new AccessToken(["access_token" => $access_token]));
            $social_data = Instagram::users()->getMedia('self')->getRaw('data');
            $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);

            return view('social.instagram', array('data' => $social_data, 'tags' => $tags));
        }
        catch(\Exception $e)
        {
            return $this->index(true);
        }
    }

    public function search(Request $request)
    {
        try
        {
            // get social account
            $social_account = $this->social_model->getSocialAccount(self::PROVIDER);

            if($social_account)
            {
                Instagram::setAccessToken(new AccessToken(["access_token" => $social_account->access_token]));
                $social_data = Instagram::users()->getMedia('self')->getRaw('data');
                $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);
                $result_search = InstagramModel::searchPhotos($social_data, $tags, $request->input('text_search'));
                return view('parts.instagram-photos', array('data' => $result_search, 'tags' => $tags));
            }
        }
        catch (\Exception $ex)
        {
        }
    }
}
