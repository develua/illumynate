<?php

namespace App\Http\Controllers\Social;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use Vinkla\Instagram\Facades\Instagram;
use League\OAuth2\Client\Token\AccessToken;
use App\Models\SocialAccount;

class InstagramController extends Controller
{
    const PROVIDER = 'instagram';

    public function index(SocialAccount $social_model)
    {
        // get social account
        $social_account = $social_model->getSocialAccount(self::PROVIDER);

        if($social_account)
            return $this->callback($social_model, $social_account->access_token);

        return Socialite::with(self::PROVIDER)->redirect();
    }

    public function callback(SocialAccount $social_model, $access_token = null)
    {
        if(!$access_token)
        {
            $user_social = Socialite::driver(self::PROVIDER)->user();
            $access_token = $user_social->token;
            $name_arr = explode(' ', $user_social->name, 2);
            $user_social['first_name'] = trim($name_arr[0]);
            $user_social['last_name'] = trim($name_arr[1]);
            $social_model->addSocialAccount($user_social, self::PROVIDER);
        }

        Instagram::setAccessToken(new AccessToken(["access_token" => $access_token]));
        $social_data = Instagram::users()->getMedia('self')->getRaw('data');
        return view('social.instagram', array('data' => $social_data));
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
