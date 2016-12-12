<?php

namespace App\Http\Controllers;

use App\Helpers\CacheFile;
use App\Http\Controllers\Social\FacebookController;
use App\Http\Controllers\Social\InstagramController;

class PhotosController extends Controller
{
    public function index()
    {
        $facebook_data = $instagram_data = 'Not found photos';

        if(CacheFile::issetContent(FacebookController::PROVIDER))
            $facebook_data = CacheFile::getContent(FacebookController::PROVIDER);

        if(CacheFile::issetContent(InstagramController::PROVIDER))
            $instagram_data = CacheFile::getContent(InstagramController::PROVIDER);

        return view('photos')
            ->withFacebookData($facebook_data)
            ->withInstagramData($instagram_data);
    }
}