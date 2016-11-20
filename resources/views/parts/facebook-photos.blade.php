@foreach ($data as $album)
    @if(isset($album['photos']))
        @foreach ($album['photos']['data'] as $photo)
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
                @if(isset($photo['place']['location']['city']))
                    <p>Location: {{$photo['place']['location']['city']}} {{$photo['place']['location']['country']}}</p>
                @endif
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
    @endif
@endforeach
