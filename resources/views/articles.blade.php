@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
@endsection

@section('script')
    <script src="/js/bootstrap-tagsinput.js"></script>
    <script src="/js/tagsinput.js"></script>
@endsection

@section('content')
    <div class="panel-heading">Pocket <a href="/pocket/logout" class="btn btn-danger btn-xs">Logout</a></div>
    <div class="panel-body" id="pocket">
        <div class="articles-block pocket-block">
            {!! $pocket_data !!}
        </div>
    </div>

    <div class="panel-heading">Pinterest <a href="/pinterest/logout" class="btn btn-danger btn-xs">Logout</a></div>
    <div class="panel-body" id="pinterest">
        <div class="articles-block pinterest-block">
            {!! $pinterest_data !!}
        </div>
    </div>
@endsection