<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', function () {
        return view('home');
    });

    Route::get('photos', function()
    {
        return view('photos');
    });

    Route::get('articles', function()
    {
        return view('articles');
    });

    Route::get('search/{search?}', function()
    {
        return view('search');
    });

    Route::get('settings', 'SettingsController@index');

    Route::get('facebook', 'Social\FacebookController@index');
    Route::get('facebook/index/{search?}', 'Social\FacebookController@index');
    Route::get('facebook/auth', 'Social\FacebookController@auth');
    Route::get('facebook/logout', 'Social\FacebookController@logout');
    Route::get('facebook/callback', 'Social\FacebookController@callback');

    Route::get('instagram', 'Social\InstagramController@index');
    Route::get('instagram/index/{search?}', 'Social\InstagramController@index');
    Route::get('instagram/auth', 'Social\InstagramController@auth');
    Route::get('instagram/logout', 'Social\InstagramController@logout');
    Route::get('instagram/callback', 'Social\InstagramController@callback');

    Route::get('pocket', 'Social\PocketController@index');
    Route::get('pocket/index/{search?}', 'Social\PocketController@index');
    Route::get('pocket/auth', 'Social\PocketController@auth');
    Route::get('pocket/logout', 'Social\PocketController@logout');
    Route::get('pocket/callback', 'Social\PocketController@callback');

    Route::get('pinterest', 'Social\PinterestController@index');
    Route::get('pinterest/index/{search?}', 'Social\PinterestController@index');
    Route::get('pinterest/auth', 'Social\PinterestController@auth');
    Route::get('pinterest/logout', 'Social\PinterestController@logout');
    Route::get('pinterest/callback', 'Social\PinterestController@callback');

    Route::get('tags/update', 'TagsController@update');

});
