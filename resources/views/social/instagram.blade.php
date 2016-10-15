@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/plugins/photoswipe/photoswipe.css">
    <link rel="stylesheet" href="/plugins/photoswipe/default-skin/default-skin.css">
    <script src="/plugins/photoswipe/photoswipe.min.js"></script>
    <script src="/plugins/photoswipe/photoswipe-ui-default.min.js"></script>
    <script src="/js/photoswipe.js"></script>
@endsection

@section('content')
    <div class="panel-heading">Instagram</div>
    <div class="panel-body">
        <div class="photo-gallery" itemtype="http://schema.org/ImageGallery">
            @foreach ($data as $media)
                <figure itemprop="associatedMedia" itemtype="http://schema.org/ImageObject">
                    <a href="{{$media['images']['standard_resolution']['url'] }}" itemprop="contentUrl" data-size="{{$media['images']['standard_resolution']['width']}}x{{$media['images']['standard_resolution']['height']}}">
                        <img src="{{$media['images']['standard_resolution']['url'] }}" height="150" itemprop="thumbnail"/>
                    </a>
                </figure>
            @endforeach
        </div>
    </div>
@endsection
