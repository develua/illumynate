@foreach ($data as $item)
    <div class="pinterest-item">
        <a href="{{$item->url}}" target="_blank">
            <img src="{{$item->image['original']['url']}}"/>
        </a>
        <span>{{$item->note}}</span>
        <input name="tags" type="text" placeholder="Custom Tags" data-role="tagsinput"
               value="{{TagsHelper::getContentTags($tags, $item->id)}}"
               data-content-id="{{$item->id}}" data-provider="pinterest"/>
    </div>
@endforeach

@include('parts.content-pagination')