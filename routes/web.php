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
    Route::get('home', 'HomeController@index');
    Route::get('photos', 'PhotosController@index');
    Route::get('articles', 'ArticlesController@index');
    Route::get('settings', 'SettingsController@index');

    Route::match(['get', 'post'], 'search', 'SearchController@index');

    Route::match(['get', 'post'], 'facebook', 'Social\FacebookController@index');
    Route::get('facebook/auth', 'Social\FacebookController@auth');
    Route::get('facebook/logout', 'Social\FacebookController@logout');
    Route::get('facebook/callback', 'Social\FacebookController@callback');

    Route::match(['get', 'post'], 'instagram', 'Social\InstagramController@index');
    Route::get('instagram/auth', 'Social\InstagramController@auth');
    Route::get('instagram/logout', 'Social\InstagramController@logout');
    Route::get('instagram/callback', 'Social\InstagramController@callback');

    Route::match(['get', 'post'], 'pocket', 'Social\PocketController@index');
    Route::get('pocket/auth', 'Social\PocketController@auth');
    Route::get('pocket/logout', 'Social\PocketController@logout');
    Route::get('pocket/callback', 'Social\PocketController@callback');

    Route::match(['get', 'post'], 'pinterest', 'Social\PinterestController@index');
    Route::get('pinterest/auth', 'Social\PinterestController@auth');
    Route::get('pinterest/logout', 'Social\PinterestController@logout');
    Route::get('pinterest/callback', 'Social\PinterestController@callback');

    Route::post('tags/update', 'TagsController@update');

    Route::get('/', function()
    {
        return redirect('/home');
    });

});
