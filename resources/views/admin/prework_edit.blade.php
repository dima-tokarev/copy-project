<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="row">
            <div style="padding: 45px" class="col-12">
    @if($pre_works)

        <form action="{{route('preworks.update',$pre_works->id)}}" method="post" enctype="multipart/form-data">
        <div class="row">

            <div class="col-7"><b>Тема: </b>{{$pre_works->name}}</div>
            <div style="text-align: right" class="col-5"><b style="margin-right: 3px;">Предварительная работа #{{$pre_works->id}}</b></div>

        </div>

        <div class="row">
            <div class="col-12"></div>

        </div>
        <hr>
        <div class="row">
            <div class="col-7">
                <label><b>Ответственный:</b> </label>
                <a class="fa fa-pencil-square-o" id="edit_user" href="javascript:void(0)"></a>
                <select id="responsible" style="width: 80%;" class="form-control" name="responsible" disabled>
                    <option value="{{$pre_works->author->id}}" selected> {{$pre_works->author->name}}</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
                </select>


            </div>
            <div class="col-5"> <b>дата добавления: </b> {{date("d-m-Y", strtotime($pre_works->created_at))}}</div>

        </div>
        <hr>
        <br>
        <div class="row">

            @foreach($attrs as $attr)
                <div class="col"><b>{{$attr->attr_name}}:</b>
                   <select class="form-control form-control-sm" name="attr[{{$attr->id_attr}}]">
                    <option selected disabled>{{$attr->value_attr}}</option>
                       @foreach($change_attrs[$attr->attr_type] as $item)
                           <option value="{{$item->id}}">{{$item->name}}</option>
                       @endforeach
                   </select>
                </div>
            @endforeach
        </div>
        <br>
        <div class="row">

            @foreach($float_attr as $attr)
                <div class="col"><b>{{$attr->attr_name}}:</b> <input style="width: 33%" class="form-control" name="float_attr[{{$attr->id_attr}}]" type="number" value="{{$attr->value_type}}"></div>
            @endforeach
                @foreach($int_attr as $attr)
                    <div class="col"><b>{{$attr->attr_name}}:</b> <input style="width: 33%" class="form-control" name="int_attr[{{$attr->id_attr}}]" type="number" value="{{$attr->value_type}}"></div>
                @endforeach
        </div>
        <div class="row">

          {{--  <div class="col"><b>Оценка выполненой работы:</b> <span>10 y.e.</span></div>--}}

        </div>
        <hr>
        <br>
        <div class="row">

            <div class="col"><b>Описание:</b></div>

        </div>
        <div style="margin: -1px" class="row">

            <textarea style="margin: 13px;min-height: 100px" class="form-control" name="desc">{{$pre_works->description}}</textarea>
            <br>

        </div>
        <br>
        <div class="padding: 14px;" class="row">

            <div class="form-group">
                <label for="exampleFormControlFile1">  <b>Добавить файл:</b></label>
                <input type="file" name="file_pre_work" class="form-control-file" id="exampleFormControlFile1">
            </div>
        </div>


        <br>
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
            @csrf
            @method('PUT')

        <hr>
             <input type="hidden" name="pre_work_id" value="{{$pre_work_id}}">
          <div class="row">
              <div class="col-6">
                <button align="right" class="btn btn-info">Сохранить работу</button>
              </div>
              <div class="col-6">
                   <button style="margin-left: 70%" class="btn btn-info" onclick="window.history.back()">Отмена</button>
              </div>
          </div>


        </form>
    @endif
            </div>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        language:"ru",
        width:'100%'
    });

    $(document).ready(function () {

      $('#edit_user').on('click',function () {
          $('#responsible').prop('disabled',false);
      })

    });
</script>
