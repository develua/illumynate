@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="/css/bootstrap-tagsinput.css">
@endsection

@section('script')
    <script src="/js/bootstrap-tagsinput.js"></script>
    <script src="/js/tagsinput.js"></script>
@endsection

@section('content')
    <div class="panel-heading">Pinterest</div>
    <div class="panel-body">
        @include('parts.pinterest-content')
    </div>
@endsection
