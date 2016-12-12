@if($num_pages > 1)
    <div>
        <ul class="pagination" data-provider="{{$provider}}">

            @if($num_pages > 5)
                <li class="disabled"><a href="#{{$provider}}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
            @endif

            @for($i = 1; $i <= $num_pages; $i++)
                <li class="{{$i == 1 ? 'active' : ''}} disabled" style="{{$i > 5 ? 'display:none' : ''}}" data-num-page="">
                    <a href="#{{$provider}}">{{$i}}</a>
                </li>
            @endfor

            @if($num_pages > 5)
                <li class="disabled"><a href="#{{$provider}}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
            @endif
        </ul>
    </div>
@endif