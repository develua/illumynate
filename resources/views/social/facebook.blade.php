@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/plugins/photoswipe/photoswipe.css">
    <link rel="stylesheet" href="/plugins/photoswipe/default-skin/default-skin.css">
    <script src="/plugins/photoswipe/photoswipe.min.js"></script>
    <script src="/plugins/photoswipe/photoswipe-ui-default.min.js"></script>
    <script src="/js/photoswipe.js"></script>
@endsection

@section('content')
    <div class="panel-heading">Facebook</div>
    <div class="panel-body" id="gallery">
        @foreach ($data as $album)
            <h3>{{$album['name']}}</h3>
            <div class="photo-gallery" itemtype="http://schema.org/ImageGallery">
                @foreach ($album['photos']['data'] as $photo)
                    <figure itemprop="associatedMedia" itemtype="http://schema.org/ImageObject">
                        <a href="{{$photo['images'][0]['source']}}" itemprop="contentUrl" data-size="{{$photo['images'][0]['width']}}x{{$photo['images'][0]['height']}}">
                            <img src="{{$photo['images'][0]['source']}}" itemprop="thumbnail" height="150"/>
                        </a>
                    </figure>
                @endforeach
            </div>
        @endforeach
    </div>

@endsection