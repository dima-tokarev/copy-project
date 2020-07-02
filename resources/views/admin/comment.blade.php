
@foreach($items as $item)
    <li id="li-comment-{{ $item->id }}" class="comment even {{ ($item->author_id == $pre_works->author_id) ?  'bypostauthor odd' : ''}}">
        <div id="comment-{{ $item->id }}" class="comment-container">
            <div class="comment-author vcard">



                <img alt="" src="{{asset('/img/avatar.png')}}" class="avatar" height="75" width="75" />
                <cite class="fn">{{$item->user->name}}</cite>
            </div>
            <!-- .comment-author .vcard -->
            <div class="comment-meta commentmetadata">
                <div class="intro">
                    <div class="commentDate">
                        <a href="#comment-2">
                          <b>Дата добавления:</b>  {{ is_object($item->created_at) ? $item->created_at->format('m.d.y \в\ H:i') : ''}}</a>
                    </div>
                    <div class="commentNumber">#&nbsp;</div>
                </div>
                <div class="comment-body">
                    <p>{{$item->text}}</p>
                </div>
                <div class="reply group">
                    <a class="comment-reply-link" href="#respond" onclick="return addComment.moveForm(&quot;comment-{{$item->id}}&quot;, &quot;{{$item->id}}&quot;, &quot;respond&quot;, &quot;{{$item->article_id}}&quot;)">Ответить</a>
                </div>
                <!-- .reply -->
            </div>
            <!-- .comment-meta .commentmetadata -->
        </div>
        <!-- #comment-##  -->

        @if(isset($com[$item->id]))
            <ul class="children">
                @include('admin.comment',['items'=>$com[$item->id]])
            </ul>
        @endif

    </li>


@endforeach