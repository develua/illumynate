<?php

/*
 * This file is part of Laravel Facebook.
 *
  * (c) Vincent Klaiber <hello@vinkla.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Facebook Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'app_id' => env('FACEBOOK_KEY'),
            'app_secret' => env('FACEBOOK_SECRET'),
            'default_graph_version' => 'v2.7',
            //'default_access_token' => null,
        ],

        'alternative' => [
            'app_id' => 'your-app-id',
            'app_secret' => 'your-app-scret',
            'default_graph_version' => 'v2.7',
            //'default_access_token' => null,
        ],

    ],

];