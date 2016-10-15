@extends('layouts.app')

@section('content')
    <div class="panel-heading">Pinterest</div>
    <div class="panel-body">
        @foreach ($data as $pin)
            <div class="pinterest-item">
                <a href="{{$pin->url}}" target="_blank">
                    <img src="{{$pin->image['original']['url']}}"/>
                </a>
                <span>{{$pin->note}}</span>
            </div>
        @endforeach
    </div>
@endsection
