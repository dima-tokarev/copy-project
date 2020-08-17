
<div style="max-width: 765px" class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="row">
            <div style="padding: 20px 45px 45px 45px" class="col-12">
    <br/>
    @if($pre_works)
    <div class="row">
        <div style="text-align: right;margin-bottom: 10px" class="col-12">

                <div>


                   @if(\Auth::user()->id == $pre_works->user_id || \Auth::user()->id == $pre_works->author_id)

                               <a class="fa fa-pencil-square-o" href="{{route('preworks.edit',$pre_works->id)}}"> Редактировать</a>

                   @elseif(\Gate::allows('edit_attr_admin') || \Gate::allows('edit_attr_leader'))

                           <a class="fa fa-pencil-square-o" href="{{route('preworks.edit',$pre_works->id)}}"> Редактировать</a>
                   @else
                   {{--    false --}}
                   @endif
                </div>

        </div>
    </div>

    <div class="row">

        <div class="col-7"><b>Название: </b>{{$pre_works->name}}</div>

        <div style="text-align: right" class="col-5"><b>Предварительная работа  #{{$pre_works->id}}</b></div>

    </div>

    <div class="row">
        <div class="col-12"></div>

    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12"><b>Автор: </b>{{$pre_works->user->name}} / <b>дата добавления: </b> {{date("d-m-Y", strtotime($pre_works->created_at))}}</div>

                    </div>
    <hr>
        <div class="row">
            <div class="col-12"><b>Ответственный: </b>{{$pre_works->author->name}}</div>

        </div>
    <hr>




    <div class="row">
        @foreach($attrs as $key => $items)

            @foreach($items as $item)

                @foreach($item as $attribute)
                    @if($attribute->object_type == 'custom')
                        <div class="col-12"><b>{{$attribute->attr_name}}:</b> <span>{{$attribute->value_table}}</span>
                            <hr>
                        </div>
                     @else
                        <div class="col-12"><b>{{$attribute->attr_name}}:</b> <span>{{$attribute->value}}</span>
                            <hr>
                        </div>
                    @endif
                 @endforeach
            @endforeach
        @endforeach
    </div>



                    <div class="row">
                        <div class="col-12">
                            <h6><b>Участники со стороны заказчика:</b></h6>
                            <br>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ФИО</th>
                                    <th>Должность</th>
                                    <th>Контактные данные</th>
                                    <th>Агент</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($participants)
                                    @foreach($participants as $participant)
                                        <tr>
                                            <td style="padding-top: 19px">{{$participant->id}}</td>
                                            <td><input disabled name="participants[fio][{{$participant->id}}]]" class="form-control" type="text" value="{{$participant->name}}"></td>
                                            <td><input disabled name="participants[position][{{$participant->id}}]]"class="form-control" type="text" value="{{$participant->position}}"></td>
                                            <td><input disabled name="participants[contacts][{{$participant->id}}]]"class="form-control" type="text" value="{{$participant->contacts}}"></td>
                                            <td>
                                                <select style="width: 73px;" disabled class="form-control" name="participants[is_agent][{{$participant->id}}]]">
                                                    <option selected>{{$participant->is_agent}}</option>
                                                    @if($participant->is_agent == 'Да')
                                                        <option>Нет</option>
                                                    @else
                                                        <option>Да</option>
                                                    @endif
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>



        <div  class="row">

                <div class="col"><b>Описание:</b></div>

        </div>
        <div class="row">
          <div class="col-12">
          <textarea id="textarea_comm" style="min-height: 100px" class="form-control" disabled>{!! $pre_works->description  !!}</textarea>
          </div>
              <br>

        </div>
                    <br>
                    @if(count($attachments) > 0)
        <div class="row">
            <div class="col"><b>Прикрепленные файлы:</b><br>
            @isset($attachments)
                @foreach($attachments as $attachment)
                   <a class="fa fa-cloud-upload" href="{{asset('/storage/app/public/'.$attachment->attachment->path)}}" target="_blank"> {{$attachment->attachment->filename}} </a> <span style="font-size: 10px">размер:{{$attachment->attachment->size}}кб / дата:{{date("d-m-Y", strtotime($attachment->created_at))}}</span>
                   <br/>
                @endforeach
            @endisset
            </div>
        </div>
                    @endif
{{--                    @if(count($reports) > 0)
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
                    @endif--}}
                    @if(count($history) > 0)

                     <br>
                        <div class="row">
                            <div class="col-12">
                             <b>История:</b>
                            </div>
                        </div>

                        <br>
                        @foreach($history as $value)
                    <div style="margin-bottom: 20px;background-color: #f5f5f5;padding: 11px;border-radius: 10px;" class="row">
                        <br>
                        <div   class="col-3">


                                <span>{{\App\User::find($value->author_id)->name}}</span>

                        </div>
                        <div class="col-9">
                            <div style="border-bottom: 1px solid #f6f6f6" class="row">
                                <div  class="col-9">
                                    <span>Добавлено:  {{date('d.n.Y h:m',strtotime($value->created_at))}}</span>
                                </div>
                            </div>
                            @if(count($value->historyEvent) > 0)
                                @foreach($value->historyEvent as $val)

                                    <span style="font-size: 10px">{{$val->event_comment}}</span><br>
                                    {{--         <tr>
                                             <td>{{$value->id}}</td>
                                             <td>
                                                 @if($value->event_comment == 'Добавление документа')
                                                 <a href="/storage/{{\App\Attachment_link::find($value->add_object_id)->first()->attachment->path}}"> {{$value->event_comment}} ({{\App\Attachment_link::find($value->add_object_id)->first()->attachment->filename}})</a>
                                                 @else
                                                     {{$values->event_comment}}
                                                 @endif
                                             </td>

                                             </tr>--}}

                                @endforeach
                            @endif

                            @if(count($value->historyComment) > 0)

                                <br><span>Комментарий: </span>
                                @foreach($value->historyComment as $val)

                                    <span style="font-size: 10px">{!! $val->comment !!} </span>
                                @endforeach
                            @endif
            </div>
        </div>
                        @endforeach
                    @endif
    {{--    <br>
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
        </div>--}}



    @endif
            </div>
        </div>
        <div class="wrap_result"></div>
    </div>
</div>



