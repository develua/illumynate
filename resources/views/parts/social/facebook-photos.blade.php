@foreach ($data as $photo)
    <div class="content-item">
        <a href="{{$photo['images'][0]['source']}}" data-gallery="">
            <img src="{{$photo['images'][0]['source']}}"
                 class="{{$photo['images'][0]['height'] > $photo['images'][0]['width'] ? 'portrait' : ''}}"/>
        </a>
        <div class="photo-caption">
            <input name="tags" type="text" placeholder="Custom Tags" data-role="tagsinput"
                   value="{{TagsHelper::getContentTags($tags, $photo['id'])}}"
                   data-content-id="{{$photo['id']}}" data-provider="facebook"/>
            @if(isset($photo['name']))
                <p>Caption: {{$photo['name']}}</p>
            @endif
            <p>
                @if(isset($photo['place']['name']))
                    Location: {{$photo['place']['name']}}
                @endif

                @if(isset($photo['place']['location']['country']))
                    {{$photo['place']['location']['country']}}
                @endif

                @if(isset($photo['place']['location']['state']))
                    {{$photo['place']['location']['state']}}
                @endif

                @if(isset($photo['place']['location']['city']))
                    {{$photo['place']['location']['city']}}}
                @endif

                @if(isset($photo['place']['location']['street']))
                    {{$photo['place']['location']['street']}}
                @endif
            </p>
            <p>
                @if(isset($photo['event']) && isset($photo['event']['place']))
                    Event location: {{$photo['event']['place']['name']}}
                @endif

                @if(isset($photo['event']['location']['country']))
                    {{$photo['event']['location']['country']}}
                @endif

                @if(isset($photo['event']['location']['state']))
                    {{$photo['event']['location']['state']}}
                @endif

                @if(isset($photo['event']['location']['city']))
                    {{$photo['event']['location']['city']}}}
                @endif

                @if(isset($photo['event']['location']['street']))
                    {{$photo['event']['location']['street']}}
                @endif
            </p>
            <p>Date: {{date('m/d/Y H:i:s', strtotime($photo['created_time']))}}</p>
            @if(isset($photo['tags']['data']))
                <p>
                    People:
                    @foreach($photo['tags']['data'] as $people)
                        <a href="https://facebook.com/{{$people['id']}}" target="_blank">{{$people['name']}}</a>
                    @endforeach
                </p>
            @endif
        </div>
    </div>
@endforeach