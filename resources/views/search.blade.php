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
    <div class="panel-heading">Facebook</div>
    <div class="panel-body" id="facebook">
        <div class="photo-gallery facebook-block">
            Not found photos
        </div>
    </div>

    <div class="panel-heading">Instagram</div>
    <div class="panel-body" id="instagram">
        <div class="photo-gallery instagram-block">
            Not found photos
        </div>
    </div>

    <div class="panel-heading">Pocket</div>
    <div class="panel-body" id="pocket">
        <div class="articles-block pocket-block">
            Not found articles
        </div>
    </div>

    <div class="panel-heading" id="pinterest">Pinterest</div>
    <div class="panel-body">
        <div class="articles-block pinterest-block">
            Not found articles
        </div>
    </div>
@endsection