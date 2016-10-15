@extends('layouts.app')

@section('content')
    <div class="panel-heading">Pinterest</div>
    <div class="panel-body">
        @foreach ($data as $item)
            <div class="pocket-item">
                <a href="{{$item->given_url}}" target="_blank">
                    <span>{{$item->resolved_title}}</span>
                    <p>{{$item->excerpt}}</p>
                </a>
            </div>
        @endforeach
    </div>
@endsection
