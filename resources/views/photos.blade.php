@extends('layouts.app')
@extends('parts.photo-slider')

@section('style')
    <link rel="stylesheet" href="/css/blueimp-gallery.css">
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
@endsection

@section('script')
    <script src="/js/blueimp-helper.js"></script>
    <script src="/js/blueimp-gallery.js"></script>
    <script src="/js/jquery.blueimp-gallery.js"></script>
    <script src="/js/bootstrap-tagsinput.js"></script>
    <script src="/js/tagsinput.js"></script>
@endsection

@section('content')
    <div class="panel-heading">Facebook <a href="/facebook/logout" class="btn btn-danger btn-xs">Logout</a></div>
    <div class="panel-body" id="facebook">
        <div class="photo-gallery facebook-block">
            {!! $facebook_data !!}
        </div>
    </div>

    <div class="panel-heading">Instagram <a href="/instagram/logout" class="btn btn-danger btn-xs">Logout</a></div>
    <div class="panel-body" id="instagram">
        <div class="photo-gallery instagram-block">
            {!! $instagram_data !!}
        </div>
    </div>
@endsection