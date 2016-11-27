<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;

use App\Models\PocketModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Duellsy\Pockpack\Pockpack;
use Duellsy\Pockpack\PockpackAuth;
use Duellsy\Pockpack\PockpackQueue;
use App\Models\SocialAccount;
use Laravel\Socialite\Two\User;
use App\Models\ContentTag;

class PocketController extends Controller
{
    const PROVIDER = 'pocket';
    private $social_model, $content_tag_model;

    public function __construct()
    {
        $this->social_model = new SocialAccount();
        $this->content_tag_model = new ContentTag();
    }

    public function index($search = null)
    {
        $social_account = $this->social_model->getSocialAccount(self::PROVIDER);

        if($social_account)
        {
            $pockpack = new Pockpack(env('POCKET_CONSUMER_KEY'), $social_account->access_token);
            $social_data = $pockpack->retrieve(['detailType' => 'complete'])->list;
            $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);

            if($search)
                $social_data = PocketModel::searchContent($social_data, $tags, $search);

            return view('parts.social.pocket-content')
                ->withData($social_data)
                ->withTags($tags);
        }

        return view('parts.button-auth')->withProvider(self::PROVIDER);
    }

    public function auth()
    {
        $pockpack = new PockpackAuth();
        $request_token = $pockpack->connect(env('POCKET_CONSUMER_KEY'));
        $callback_url = env("POCKET_REDIRECT_URI").'?request_token='.$request_token;
        $redirect_url = 'https://getpocket.com/auth/authorize?request_token='.$request_token.'&redirect_uri='.$callback_url;
        return redirect($redirect_url);
    }

    public function logout()
    {
        $this->social_model->getSocialAccount(self::PROVIDER)->delete();
        return redirect('articles');
    }

    public function callback()
    {
        try
        {
            $request_token = Input::get('request_token');
            $pockpack = new PockpackAuth();
            $response_data = $pockpack->receiveTokenAndUsername(env('POCKET_CONSUMER_KEY'), $request_token);
            $user_social = new User();
            $user_social->token = $response_data['access_token'];
            $name_arr = explode(' ', $response_data['username'], 2);
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
