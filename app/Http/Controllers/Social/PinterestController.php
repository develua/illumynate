<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;

use App\Models\PinterestModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use DirkGroenen\Pinterest\Pinterest;
use App\Models\SocialAccount;
use App\Models\ContentTag;

class PinterestController extends Controller
{
    const PROVIDER = 'pinterest';
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
            if (!$access_token)
            {
                $user_social = Socialite::driver(self::PROVIDER)->user();
                $access_token = $user_social->token;
                $name_arr = explode(' ', $user_social->name, 2);
                $user_social['first_name'] = trim($name_arr[0]);
                $user_social['last_name'] = isset($name_arr[1]) ? trim($name_arr[1]) : null;
                $this->social_model->addOrUpdateSocialAccount($user_social, self::PROVIDER);
            }

            $pinterest = new Pinterest(env('PINTEREST_KEY'), env('PINTEREST_SECRET'));
            $pinterest->auth->setOAuthToken($access_token);
            $data = $pinterest->users->getMePins(array('fields' => 'note,url,image'));
            $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);

            return view('social.pinterest', array('data' => $data, 'tags' => $tags));
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
                $pinterest = new Pinterest(env('PINTEREST_KEY'), env('PINTEREST_SECRET'));
                $pinterest->auth->setOAuthToken($social_account->access_token);
                $data = $pinterest->users->getMePins(array('fields' => 'note,url,image'));
                $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);

                $result_search = PinterestModel::searchContent($data, $tags, $request->input('text_search'));
                return view('parts.pinterest-content', array('data' => $result_search, 'tags' => $tags));
            }
        }
        catch (\Exception $ex)
        {
        }
    }
}
