<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    // get provider ID
    public static function getProviderID($provider)
    {
        return Provider::whereProvider($provider)->first()->id;
    }
}
