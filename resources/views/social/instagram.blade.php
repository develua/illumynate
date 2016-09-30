@extends('layouts.app')

@section('content')
    <div class="panel-heading">Instagram</div>
    <div class="panel-body">
        @foreach ($data as $media)
            <img src="{{ $media['images']['standard_resolution']['url'] }}" height="150"/>
        @endforeach
    </div>
@endsection
