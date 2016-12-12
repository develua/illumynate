@foreach ($data as $item)
    <div class="pocket-item">
        <a href="{{$item->given_url}}" target="_blank">
            <span>{{$item->resolved_title}}</span>
            <p>{{$item->excerpt}}</p>
            @if(isset($item->tags))
                <p class="pocket-tags">
                    @foreach ($item->tags as $tag_item)
                        <span>{{$tag_item->tag}}</span>
                    @endforeach
                </p>
            @endif
        </a>
        <input name="tags" type="text" placeholder="Custom Tags" data-role="tagsinput"
               value="{{TagsHelper::getContentTags($tags, $item->item_id)}}"
               data-content-id="{{$item->item_id}}" data-provider="pocket"/>
    </div>
@endforeach

@include('parts.content-pagination')