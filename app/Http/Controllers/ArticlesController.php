<?php

namespace App\Http\Controllers;

use App\Helpers\CacheFile;
use App\Http\Controllers\Social\PinterestController;
use App\Http\Controllers\Social\PocketController;

class ArticlesController extends Controller
{
    public function index()
    {
        $pocket_data = $pinterest_data = 'Not found photos';

        if(CacheFile::issetContent(PocketController::PROVIDER))
            $pocket_data = CacheFile::getContent(PocketController::PROVIDER);

        if(CacheFile::issetContent(PinterestController::PROVIDER))
            $pinterest_data = CacheFile::getContent(PinterestController::PROVIDER);

        return view('articles')
            ->withPocketData($pocket_data)
            ->withPinterestData($pinterest_data);
    }
}