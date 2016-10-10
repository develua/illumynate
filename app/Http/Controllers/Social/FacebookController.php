<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use Vinkla\Facebook\Facades\Facebook;
use App\Models\SocialAccount;

class FacebookController extends Controller
{
    const PROVIDER = 'facebook';

    public function index(SocialAccount $social_model)
    {
        // get social account
        $social_account = $social_model->getSocialAccount(FacebookController::PROVIDER);

        if($social_account)
            return $this->callback($social_model, $social_account->access_token);
        else
            return Socialite::with(FacebookController::PROVIDER)->scopes(['public_profile ', 'email', 'user_photos'])->redirect();
    }

    public function callback(SocialAccount $social_model, $access_token = null)
    {
        if(!$access_token)
        {
            $user_social = Socialite::driver(FacebookController::PROVIDER)->user();
            $access_token = $user_social->token;
            $name_arr = explode(' ', $user_social->name, 2);
            $user_social['first_name'] = trim($name_arr[0]);
            $user_social['last_name'] = trim($name_arr[1]);
            $social_model->addSocialAccount($user_social, FacebookController::PROVIDER);
        }

        $social_data = Facebook::get('/me/albums?fields=id,name,privacy,photos.fields(id,name,images)', $access_token)->getDecodedBody();
        return view('social.facebook', array('data' => $social_data['data']));
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
