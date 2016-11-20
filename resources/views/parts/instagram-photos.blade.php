@foreach ($data as $media)
    @if($media['type'] == 'image')
            <a href="{{$media['images']['standard_resolution']['url'] }}" data-gallery="">
                <img src="{{$media['images']['standard_resolution']['url'] }}" height="150"/>
            </a>
            <div class="photo-caption">
                <input name="tags" type="text" placeholder="You Tags" data-role="tagsinput"
                       value="{{TagsHelper::getContentTags($tags, $media['id'])}}"
                       data-content-id="{{$media['id']}}" data-provider="instagram"/>
                @if(isset($media['caption']['text']))
                    <p>Caption: {{$media['caption']['text']}}</p>
                @endif
                @if(isset($media['location']['name']))
                    <p>Location: {{$media['location']['name']}}</p>
                @endif
                <p>Data: {{date('m/d/Y H:i:s', $media['created_time'])}}</p>
                @if($media['users_in_photo'])
                    <p>
                        People:
                        @foreach($media['users_in_photo'] as $people)
                            <a href="https://www.instagram.com/{{$people['user']['username']}}" target="_blank">{{$people['user']['username']}}</a>
                        @endforeach
                    </p>
                @endif
            </div>
        </figure>
    @endif
@endforeach