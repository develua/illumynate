@foreach ($data as $photo)
    <a href="{{$photo['images'][0]['source']}}" data-gallery="">
        <img src="{{$photo['images'][0]['source']}}" height="150"/>
    </a>
    <div class="photo-caption">
        <input name="tags" type="text" placeholder="You Tags" data-role="tagsinput"
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
        <p>Data: {{date('m/d/Y H:i:s', strtotime($photo['created_time']))}}</p>
        @if(isset($photo['tags']['data']))
            <p>
                People:
                @foreach($photo['tags']['data'] as $people)
                    <a href="https://facebook.com/{{$people['id']}}" target="_blank">{{$people['name']}}</a>
                @endforeach
            </p>
        @endif
    </div>
@endforeach