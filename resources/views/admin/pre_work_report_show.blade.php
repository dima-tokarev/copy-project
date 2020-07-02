<div class="container">

    <div class="row">
        <div class="col-9">
            <h4>Отчет о выполненой работе</h4>
            <p><b>Ответственный: </b>{{$report->author->name}} / {{date('d.m.Y',strtotime($report->created_at))}} </p>
        </div>
            <div class="col-3" style="text-align: right">
                <p style="float:left"><a class="fa fa-pencil-square-o" href="{{route('prework-reports.edit',$report->id)}}"> Редактировать</a></p>
                <p><a class="fa fa-long-arrow-left" href="javascript:void(0)" onclick="window.history.back()"> Вернуться Назад</a> </p>
            </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-6">
            <div><b>Предварительная работа:</b></div>
            <div><b>Начата:</b></div>
            <div><b>Дата выполнения:</b></div>
            <div><b>Количество часов:</b></div>
            <div><b>Ответсвенный</b></div>
            <div><b>Объем затраченных денежных средств</b></div>
        </div>
        <div class="col-6">
            <div>{{$report->name}}</div>
            <div>{{$report->start_time}}</div>
            <div>{{$report->end_time}}</div>
            <div>{{$report->total_hours}}</div>
            <div>{{$report->author->name}}</div>
            <div>{{$report->budget}} ₽.</div>

        </div>
    </div>
    <hr>
    <br>
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
                        <td>{{$participant->id}}</td>
                        <td>{{$participant->name}}</td>
                        <td>{{$participant->position}}</td>
                        <td>{{$participant->contacts}}</td>
                        <td>{{$participant->is_agent}}</td>
                    </tr>
                 @endforeach
              @endisset
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <b>Комментарий к отчету:</b>
            <div style="min-height: 100px" class="form-control">
                {!! $report->description  !!}
            </div>
        </div>
    </div>
     <br/>
    <div class="row">
        <div class="col-12">
            <b>Прикрепленные файлы:</b>
            <div>
                @isset($attachments)
                    @foreach($attachments as $attachment)
                        <a class="fa fa-cloud-upload" href="{{asset('/storage/'.$attachment->attachment->path)}}" target="_blank"> {{$attachment->attachment->filename}} </a> <span style="font-size: 10px">размер:{{$attachment->attachment->size}}кб / дата:{{date("d-m-Y", strtotime($attachment->created_at))}}</span>
                        <br/>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
    <br/>
    <div class="row">

        <div class="col-12">
            <b>История:</b>
            @isset($history)
                <br>
                <table class="table">
                    <thead>
                    <th>#</th>
                    <th>Событие</th>
                    <th>Пользователь</th>
                    <th>Дата</th>
                    <th></th>
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
                            <td>{{\App\User::find($value->author_id)->first()->name}}</td>
                            <td>{{date('d.n.Y',strtotime($value->created_at))}}</td>
                        </tr>
                    @endforeach
                </table>
            @endisset
        </div>
    </div>


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

                            @include('admin.report_comment',['items' => $comments])

                        @endforeach

                    </ol>
            @endif
            <!-- START TRACKBACK & PINGBACK -->

                <ol class="trackbacklist"></ol>

                <!-- END TRACKBACK & PINGBACK -->
                <div id="respond">
                    <h6 id="reply-title"><b>Добавить  Комментарий</b> <small><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;">Отменить ответ</a></small></h6>
                    <form action="{{route('storeReport')}}" method="post" id="commentform">


                        <p class="comment-form-comment"><label for="comment"> </label><textarea style="width: 100%" id="comment" name="text" cols="45" rows="8" ></textarea></p>
                        <div class="clear"></div>
                        <input id="comment_pre_work_id" type="hidden" name="comment_pre_work_id" value="{{$report->id}}" />
                        <input id="object_type_id" type="hidden" name="object_type_id" value="{{$report->type_id}}" />
                        <input id="comment_parent" type="hidden" name="comment_parent" value="0" />


                        <input class="btn btn-info" name="submit" type="submit" id="submit" value="Добавить" />
                        {{csrf_field()}}
                    </form>

                </div>
                <!-- #respond -->
            </div>
            <!-- END COMMENTS -->
            <div class="wrap_result"></div>

        </div>
    </div>



</div>