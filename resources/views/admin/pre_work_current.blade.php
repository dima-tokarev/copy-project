
<div style="max-width: 765px" class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="row">
            <div style="padding: 20px 45px 45px 45px" class="col-12">
    <br/>
    @if($pre_works)
    <div class="row">
        <div style="text-align: right;margin-bottom: 10px" class="col-12">

                <div>
                    <a class="fa fa-pencil-square-o" href="{{route('preworks.edit',$pre_works->id)}}"> Редактировать</a> /
                    <a class="fa fa-bookmark" href="{{route('prework-reports.all',$pre_works->id)}}"> Отразить результат</a>
                </div>

        </div>
    </div>

    <div class="row">

        <div class="col-7"><b>Тема: </b>{{$pre_works->name}}</div>

        <div style="text-align: right" class="col-5"><b>Предварительная работа  #{{$pre_works->id}}</b></div>

    </div>

    <div class="row">
        <div class="col-12"></div>

    </div>
    <hr>
        <div class="row">
            <div class="col-12"><b>Ответственный: </b>{{$pre_works->author->name}} / <b>дата добавления: </b> {{date("d-m-Y", strtotime($pre_works->created_at))}}</div>

        </div>
    <hr>
    <br/>
     <div style="margin-bottom: 23px" class="row">
         <div class="col-12">
             <b>Основные атрибуты:</b>
          
         </div>
         <br>
     </div>


    <div class="row">
        @foreach($attrs as $attr)
        <div class="col-12"><b>{{$attr->attr_name}}:</b> <span>{{$attr->value_attr}}</span>
            <hr>
        </div>

        @endforeach
    </div>

        <div class="row">

            @foreach($float_attr as $attr)
                <div class="col-12"><b>{{$attr->attr_name}}:</b> <span>{{$attr->value_type}}</span>
                    <hr>
                </div>

            @endforeach


                @foreach($int_attr as $attr)
                    <div class="col-12"><b>{{$attr->attr_name}}:</b> <span>{{$attr->value_type}}</span>
                        y.e
                    </div>
                @endforeach
        </div>
        <div class="row">



        </div>

        <hr>
        <br>
        <div  class="row">

                <div class="col"><b>Описание:</b></div>

        </div>
        <div class="row">

          <div  style="margin: 13px;min-height: 100px" class="form-control" disabled>{!! $pre_works->description  !!}</div>
        <br>

        </div>
                    @if(count($attachments) > 0)
        <div class="row">
            <div class="col"><b>Прикрепленные файлы:</b><br>
            @isset($attachments)
                @foreach($attachments as $attachment)
                   <a class="fa fa-cloud-upload" href="{{asset('/storage/'.$attachment->attachment->path)}}" target="_blank"> {{$attachment->attachment->filename}} </a> <span style="font-size: 10px">размер:{{$attachment->attachment->size}}кб / дата:{{date("d-m-Y", strtotime($attachment->created_at))}}</span>
                   <br/>
                @endforeach
            @endisset
            </div>
        </div>
                    @endif
                    @if(count($reports) > 0)
                    <hr>
        <div class="row">

            <div class="col"><b>Выполненые работы:</b></div>
        <br>
        </div>

         @if(isset($reports))
            @foreach($reports as $value)
                            <div  class="row">
                                    <div  class="col">
                                        <a class="fa fa-bookmark" href="{{route('prework-reports.show',$value->id)}}"> {{$value->name}}</a>
                                    </div>
                            </div>
             @endforeach


            @endif
                        <hr>
                    @endif
                    @if(count($history) > 0)


        <div class="row">

            <div class="col-12">
                <b>История:</b>

                <br>
                <table class="table">
                    <thead>
                        <td>#</td>
                        <th>Событие</th>
                        <th>Пользователь</th>
                        <th>Дата</th>

                    </thead>
                    @foreach($history as $value)
                        <tr>
                        <td>{{$value->id}}</td>
                        <td>
                            @if($value->event_comment == 'Добавление документа')
                            <a href="/storage/{{\App\Attachment_link::find($value->add_object_id)->first()->attachment->path}}"> {{$value->event_comment}} ({{\App\Attachment_link::find($value->add_object_id)->first()->attachment->filename}})</a>
                            @else
                                {{$value->event_comment}}
                            @endif
                        </td>
                        <td>{{\App\User::find($value->author_id)->name}}</td>
                        <td>{{date('d.n.Y',strtotime($value->created_at))}}</td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
                    @endif
        <br>
        <div class="row">
            <div class="col-12">

                <!-- START COMMENTS -->
                <div id="comments">
                    <h6 id="comments-title">
                        <b>{{ $count }} Комментарий(ев) </b>
                    </h6>
                    @if($count > 0)
                    <ol class="commentlist group">

                        @foreach($com as $k => $comments)

                            @if($k !== 0)
                                @break
                            @endif

                            @include('admin.comment',['items' => $comments])

                        @endforeach

                    </ol>
                    @endif
                    <!-- START TRACKBACK & PINGBACK -->

                    <ol class="trackbacklist"></ol>

                    <!-- END TRACKBACK & PINGBACK -->
                    <div id="respond">
                        <h6 id="reply-title"><b>Добавить  Комментарий</b> <small><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;">Отменить ответ</a></small></h6>
                        <form action="{{route('comment.store')}}" method="post" id="commentform">


                            <p class="comment-form-comment"><label for="comment"> </label><textarea style="width: 100%" id="comment" name="text" cols="45" rows="8" ></textarea></p>
                            <div class="clear"></div>
                            <input id="comment_pre_work_id" type="hidden" name="comment_pre_work_id" value="{{$pre_works->id}}" />
                                <input id="object_type_id" type="hidden" name="object_type_id" value="{{$pre_works->type_id}}" />
                            <input id="comment_parent" type="hidden" name="comment_parent" value="0" />


                                <input class="btn btn-info" name="submit" type="submit" id="submit" value="Добавить комментарий" />
                        {{csrf_field()}}
                        </form>

                    </div>
                    <!-- #respond -->
                </div>
                <!-- END COMMENTS -->


            </div>
        </div>



    @endif
            </div>
        </div>
        <div class="wrap_result"></div>
    </div>
</div>




