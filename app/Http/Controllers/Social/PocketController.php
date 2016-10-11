<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Duellsy\Pockpack\Pockpack;
use Duellsy\Pockpack\PockpackAuth;
use Duellsy\Pockpack\PockpackQueue;
use App\Models\SocialAccount;
use Laravel\Socialite\Two\User;

class PocketController extends Controller
{
    const PROVIDER = 'pocket';

    public function index(SocialAccount $social_model)
    {
        // get social account
        $social_account = $social_model->getSocialAccount(self::PROVIDER);

        if($social_account)
            return $this->callback($social_model, $social_account->access_token);

        $pockpack = new PockpackAuth();
        $request_token = $pockpack->connect(env('POCKET_CONSUMER_KEY'));
        $callback_url = env("POCKET_REDIRECT_URI").'?request_token='.$request_token;
        $redirect_url = 'https://getpocket.com/auth/authorize?request_token='.$request_token.'&redirect_uri='.$callback_url;
        return redirect($redirect_url);
    }

    public function callback(SocialAccount $social_model, $access_token = null)
    {
        if(!$access_token)
        {
            $request_token = Input::get('request_token');
            $pockpack = new PockpackAuth();
            $response_data = $pockpack->receiveTokenAndUsername(env('POCKET_CONSUMER_KEY'), $request_token);
            $user_social = new User();
            $user_social->token = $access_token = $response_data['access_token'];
            $name_arr = explode(' ', $response_data['username'], 2);
            $user_social['first_name'] = trim($name_arr[0]);
            $user_social['last_name'] = isset($name_arr[1]) ? trim($name_arr[1]) : null;
            $social_model->addSocialAccount($user_social, self::PROVIDER);
        }

        $pockpack = new Pockpack(env('POCKET_CONSUMER_KEY'), $access_token);
        $data = $pockpack->retrieve();
        return view('social.pocket', array('data' => $data->list));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
