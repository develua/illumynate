<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\ContentTag;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(ContentTag $content_tag, Request $request)
    {
        $content_tag->updateTags($request->input());
    }
}
