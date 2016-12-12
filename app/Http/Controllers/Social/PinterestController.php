<?php

namespace App\Http\Controllers\Social;

use App\Helpers\CacheFile;
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
        $this->social_model = new SocialAccount();
        $this->content_tag_model = new ContentTag();
    }

    public function index(Request $request)
    {
        $social_account = $this->social_model->getSocialAccount(self::PROVIDER);

        if($social_account)
        {
            $pinterest = new Pinterest(env('PINTEREST_KEY'), env('PINTEREST_SECRET'));
            $pinterest->auth->setOAuthToken($social_account->access_token);
            $social_data = $pinterest->users->getMePins(array('fields' => 'note,url,image,created_at'));
            $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);

            $text_search = $request->input('text-search');
            $new_content = $request->input('new-content');

            if(!empty($text_search))
                $social_data = PinterestModel::searchContent($social_data, $tags, $request->input('text-search'));
            else if(!empty($new_content))
            {
                $social_data = PinterestModel::getNewContent($social_data, $social_account['last_view']);
                SocialAccount::updateTimeLastView(self::PROVIDER);
            }

            $num_pages = round(count($social_data) / 9, 0, PHP_ROUND_HALF_UP);
            $content = CacheFile::tremSpace(view('parts.social.pinterest-content')
                ->withData($social_data)
                ->withTags($tags)
                ->withProvider(self::PROVIDER)
                ->withNumPages($num_pages));

            if(empty($text_search) && empty($new_content))
                CacheFile::saveContent(self::PROVIDER, $content);

            return $content;
        }

        return view('parts.button-auth')->withProvider(self::PROVIDER);
    }

    public function auth()
    {
        return Socialite::with(self::PROVIDER)->redirect();
    }

    public function logout()
    {
        $social_account = $this->social_model->getSocialAccount(self::PROVIDER);
        if($social_account)
        {
            $social_account->delete();
            CacheFile::deleteCache(self::PROVIDER);
        }
        return redirect('articles');
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

        return redirect('articles');
    }

}
