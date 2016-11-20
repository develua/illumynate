@foreach ($data as $item)
    <div class="pocket-item">
        <a href="{{$item->given_url}}" target="_blank">
            <span>{{$item->resolved_title}}</span>
            <p>{{$item->excerpt}}</p>
        </a>
        <input name="tags" type="text" placeholder="You Tags" data-role="tagsinput"
               value="{{TagsHelper::getContentTags($tags, $item->item_id)}}"
               data-content-id="{{$item->item_id}}" data-provider="pocket"/>
    </div>
@endforeach