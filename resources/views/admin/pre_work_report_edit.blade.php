<div class="container">
   <form action="{{route('prework-reports.update')}}" method="post" enctype="multipart/form-data">
    <div class="row">

        <div class="col-12">
            <h4>Отчет о выполненой работе</h4>
            <p><b>Ответственный: </b>{{$report->author->name}} / {{date('d.m.Y',strtotime($report->created_at))}} </p>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-6">
            <div style="margin-bottom: 18px"><b>Предварительная работа:</b></div>
            <div style="margin-bottom: 18px"><b>Начата:</b></div>
            <div  style="margin-bottom: 18px"><b>Дата выполнения:</b></div>
            <div  style="margin-bottom: 18px"><b>Количество часов:</b></div>
            <div  style="margin-bottom: 18px"><b>Ответсвенный</b></div>
            <div  style="margin-bottom: 18px"><b>Объем затраченных денежных средств</b></div>
        </div>
        <div class="col-6">
            <div><input style="width: 50%" class="form-control" name="name_report" type="text" value="{{$report->name}}"></div>
            <div><input style="width: 50%" class="form-control"  type="date" value="{{$report->start_time}}" disabled></div>
            <input type="hidden" name="start_time" value="{{$report->start_time}}">
            <div><input style="width: 50%" class="form-control" name="end_time" type="date" value="{{$report->end_time}}"></div>
            <div><input style="width: 50%" class="form-control" name="total_hours" type="number" value="{{$report->total_hours}}"></div>
            <div><input style="width: 50%" class="form-control"  type="text" value="{{$report->author->name}}"  disabled></div>
            <input type="hidden" name="author_id" value="{{$report->author->id}}">
            <div><input style="width: 50%;float:left;margin-right: 5px;" class="form-control" name="budget" type="number" value="{{$report->budget}}"><span>руб.</span></div>

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
                            <td><input name="participants[fio][{{$participant->id}}]]" class="form-control" type="text" value="{{$participant->name}}"></td>
                            <td><input name="participants[position][{{$participant->id}}]]"class="form-control" type="text" value="{{$participant->position}}"></td>
                            <td><input name="participants[contacts][{{$participant->id}}]]"class="form-control" type="text" value="{{$participant->contacts}}"></td>
                            <td>
                               <select name="participants[is_agent][{{$participant->id}}]]">
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

    <div class="row">
        <div class="col-12">
            <b>Комментарий к отчету:</b>
            <textarea name="description" style="min-height: 300px" class="form-control">
                {{ $report->description }}
            </textarea>
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
    <br/>
    <div class="row">
        <div class="col-10">
            <b>Добавить файл:</b>
            <div>
                <input name="file_report" type="file">
            </div>
        </div>
        <div class="col-2">

            <div align="right">
               <button class="btn btn-info">Сохранить</button>
            </div>
        </div>
    </div>
    <input type="hidden" name="pre_work_report_id" value="{{$pre_work_report_id}}">
    @csrf
    <br/>
   </form>

</div>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        language:"ru",
        width:'100%'
    });
</script>
