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

        $pockpack = new PockpackAuth();
        $request_token = $pockpack->connect(env('POCKET_CONSUMER_KEY'));
        $callback_url = env("POCKET_REDIRECT_URI").'?request_token='.$request_token;
        $redirect_url = 'https://getpocket.com/auth/authorize?request_token='.$request_token.'&redirect_uri='.$callback_url;

        return redirect($redirect_url);
    }

    public function callback($access_token = null)
    {
        try
        {
            if (!$access_token)
            {
                $request_token = Input::get('request_token');
                $pockpack = new PockpackAuth();
                $response_data = $pockpack->receiveTokenAndUsername(env('POCKET_CONSUMER_KEY'), $request_token);
                $user_social = new User();
                $user_social->token = $access_token = $response_data['access_token'];
                $name_arr = explode(' ', $response_data['username'], 2);
                $user_social['first_name'] = trim($name_arr[0]);
                $user_social['last_name'] = isset($name_arr[1]) ? trim($name_arr[1]) : null;
                $this->social_model->addOrUpdateSocialAccount($user_social, self::PROVIDER);
            }

            $pockpack = new Pockpack(env('POCKET_CONSUMER_KEY'), $access_token);
            $data = $pockpack->retrieve()->list;
            $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);

            return view('social.pocket', array('data' => $data, 'tags' => $tags));
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
                $pockpack = new Pockpack(env('POCKET_CONSUMER_KEY'), $social_account->access_token);
                $data = $pockpack->retrieve()->list;
                $tags = $this->content_tag_model->getProviderTegs(self::PROVIDER);

                $result_search = PocketModel::searchContent($data, $tags, $request->input('text_search'));
                return view('parts.pocket-content', array('data' => $result_search, 'tags' => $tags));
            }
        }
        catch (\Exception $ex)
        {
        }
    }
}
