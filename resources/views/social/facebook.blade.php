@extends('layouts.app')

@section('content')
    <div class="panel-heading">Facebook</div>
    <div class="panel-body">
        @foreach ($data as $album)
            <h3>{{$album['name']}}</h3>
            @foreach ($album['photos']['data'] as $photo)
                <img src="{{$photo['images'][0]['source']}}" height="150"/>
            @endforeach
        @endforeach
    </div>
@endsection