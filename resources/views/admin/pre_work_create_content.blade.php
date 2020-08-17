<div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add_form" action="{{route('preworks.store')}}" method="post" enctype="multipart/form-data">

                <div style="padding: 16px;" class="row">
                    <div class="col-7">     <h5 class="modal-title" id="exampleModalLongTitle">Создание работы</h5></div>

                {{--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>--}}

                        <div  class="col-5">
                            <div class="form-group" style="color: darkred;margin-left: 5%;font-size: 14px"></div>
                        </div>

                </div>
                <div class="modal-body">

                    <div class="form-group">


                        <table class="table">
                 {{--           <thead>
                            <tr>

                                <th scope="col"></th>
                                <th scope="col"></th>

                            </tr>
                            </thead>--}}
                            <tbody>
                            <tr>

                                <td>Название</td>
                                <td><input  style="width: 89%" type="text" class="form-control" name="name_prework" id="exampleFormControlInput1" value="{{old('name_prework')}}" placeholder="Введите название работы"></td>
                            </tr>
                            <tr>

                                <td>Автор:</td>
                                <td><div style="width: 89%" class="form-control">{{\Auth::user()->name}}</div></td>

                            </tr>
                            <tr>
                                <td>Дата добавления</td>
                                <td><div style="width: 89%" class="form-control">{{date('m-d-Y')}}</div></td>
                            </tr>
                            <tr>
                                <td>Ответственный</td>
                                <td>
                                    @isset($users)
                                        <select style="width: 89%"  name="responsible" class="form-control">
                                            <option value="{{\Auth::user()->id}}" selected>{{\Auth::user()->name}}</option>
                                            @foreach($users as $user)
                                                <option  value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    @endisset
                                </td>
                            </tr>

                            @if($attributes)
                                @foreach ($attributes as $attribute)

                                    @if($attribute->attr->attr_type == 3 )
                                        <tr>

                                            <td>{{$attribute->attr->attr_name}}</td>
                                            <td>
                                                <input style="width: 89%;float: left;margin-right: 5px" type="text" id="attr_simple_{{$attribute->attr->id}}" name="attr_simple[{{$attribute->attr->id}}][{{\App\ObjectType::find($attribute->attr->attr_type)->name}}]" value="{{old('attr_simple.'.$attribute->attr->id.'.'.\App\ObjectType::find($attribute->attr->attr_type)->name) ?? '0'}}" class="form-control" size="20" placeholder="Введите значение">
                                                <input type="hidden" name="object_id" value="{{$object_id}}">
                                            </td>

                                        </tr>


                                    @endif

                                    @if($attribute->attr->attr_type == 4)
                                        <tr>

                                            <td>{{$attribute->attr->attr_name}}</td>
                                            <td>
                                                <input id="int_{{$attribute->attr->id}}" style="width: 89%;float: left;margin-right: 5px"  type="text" name="attr_simple[{{$attribute->attr->id}}][{{\App\ObjectType::find($attribute->attr->attr_type)->name}}]" value="{{old('attr_simple.'.$attribute->attr->id.'.'.\App\ObjectType::find($attribute->attr->attr_type)->name) ?? '0'}}" class="form-control" size="20" placeholder="Введите значение">
                                                <input type="hidden" name="object_id" value="{{$object_id}}">
                                            </td>

                                        </tr>


                                    @endif
                                    @if($attribute->attr->attr_type == 5)
                                        <tr>

                                            <td>{{$attribute->attr->attr_name}}</td>
                                            <td>
                                                <input style="width: 89%" type="date" name="attr_simple[{{$attribute->attr->id}}][{{\App\ObjectType::find($attribute->attr->attr_type)->name}}]" value="{{old('attr_simple.'.$attribute->attr->id.'.'.\App\ObjectType::find($attribute->attr->attr_type)->name) ?? ''}}" class="form-control" size="20" placeholder="Введите значение">
                                                <input type="hidden" name="object_id" value="{{$object_id}}">
                                            </td>

                                        </tr>
                                    @endif
                                    @if($attribute->attr->attr_type != 3 && $attribute->attr->attr_type != 4 && $attribute->attr->attr_type != 5 )

                                        <tr>


                                            <td>{{$attribute->attr->attr_name}}</td>

                                            <td>

                                                <div style="float:left;width:79%" id="add_content_att_{{$attribute->attr->id}}_{{$attribute->attr->id}}">


                                                    <!-- Button trigger modal -->
                                                    @if($attribute->attr->attr_type == 7)
                                                        <input id='val_{{$attribute->attr->id}}_{{$attribute->attr->id}}' class='form-control' type='text' name='attr_custom[{{$attribute->attr->id}}][{{\App\ObjectType::find($attribute->attr->attr_type)->name}}]' value="{{old('attr_custom.'.$attribute->attr->id.'.'.\App\ObjectType::find($attribute->attr->attr_type)->name) ?? \App\Status::find(1)->name}}" >
                                                    @else
                                                        <input id='val_{{$attribute->attr->id}}_{{$attribute->attr->id}}' class='form-control' type='text' name='attr_custom[{{$attribute->attr->id}}][{{\App\ObjectType::find($attribute->attr->attr_type)->name}}]' value="{{old('attr_custom.'.$attribute->attr->id.'.'.\App\ObjectType::find($attribute->attr->attr_type)->name) ?? ''}}" >
                                                    @endif
                                                </div>

                                                <button  attr_class="{{\App\ObjectType::find($attribute->attr->attr_type)->name}}" attr_id="{{$attribute->attr->id}}" type="button" class="btn btn-primary elem" data-toggle="modal" data-target="#exampleModalCenter_{{$attribute->attr->id}}" value="attr_custom[{{$attribute->attr->id}}][{{\App\ObjectType::find($attribute->attr->attr_type)->name}}]" >
                                                    <i class="fa fa-search"></i>
                                                </button>



                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalCenter_{{$attribute->attr->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">{{$attribute->attr->attr_name}}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div id="content_attr_{{$attribute->attr->id}}" class="modal-body">

                                                                    @include('admin.pagination_data_create')
                                                            </div>

                                                            <script>
                                                                $(document).ready( function() {
                                                                  $(document).on('click', '.filed_{{\App\ObjectType::find($attribute->attr->attr_type)->name}}', function (event) {
                                                                        event.preventDefault();
                                                                        let id = $(this).attr('id_attr');
                                                                        let name = $(this).attr('name_attr');
                                                                        let y_e = $(this).attr('y_e');

                                                                      $('#val_{{$attribute->attr->id}}_{{$attribute->attr->id}}').val(name);
                                                                      if(y_e) {
                                                                          $('#int_6').val(y_e);
                                                                      }


                                                                  });
                                                                });

                                                            </script>
                                                       {{--     <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                                <button id="add_att_btn_{{$attribute->attr->id}}" type="button"  data-dismiss="modal" class="btn btn-primary">Добавить</button>
                                                            </div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- / Modal -->




                                                <script>
                                                    $(document).ready( function() {

                                                        $(document).ready( function() {
                                                            $(document).on('click', '.pagination a', function (event) {

                                                                event.preventDefault();


                                                                $('#content_attr_{{$attribute->attr->id}}').append("<div id='preloader_malc'><div>Подождите, идет загрузка данных ... </div> </div>");

                                                                setTimeout(function() {
                                                                    $('#preloader_malc').css('display' , 'none');

                                                                }, 3000);


                                                                let page = $(this).attr('href').split('page=')[1];
                                                                let name = '{{\App\ObjectType::find($attribute->attr->attr_type)->name}}';
                                                                fetch_data(page, name);

                                                            });

                                                            function fetch_data(page, name) {
                                                                $.ajax({
                                                                    url: "attr-val/fetch_data?page=" + page + "&name=" + name,
                                                                    success: function (data) {
                                                                        $('#content_attr_{{$attribute->attr->id}}').html(data);
                                                                    }
                                                                })
                                                            }
                                                        });




                                                    });


                                                </script>

                                            </td>

                                        </tr>


                                    @endif
                                @endforeach


                            @else
                                <tr>
                                    <th scope="row">&nbsp;</th>
                                    <th scope="row">&nbsp;</th>
                                    <th colspan="2">Атрибутов не найдено</th>
                                    <th scope="row">&nbsp;</th>

                                </tr>
                            @endif
                            </tbody>
                        </table>

                           <div  style="padding: 0.75rem;"  class="row">
                              <div class="col-12">
                                  <label><b>Участники со стороны заказчика:</b><a style="" id="add_participant" class="btn btn-link" href="javascript:void(0)">Добавить</a></label>
                                <br>
                                <div id="add_participant_content">
                                    @if(old('participants.fio'))
                                        @foreach(old('participants.fio') as $item)
                                            <div class="form-row"><div class="form-group col-md-4">
                                                    <label for="inputFio">Фамилия</label>
                                                    <input name="participants[fio][{{$loop->index}}]" type="text" value="{{old('participants.fio.'.$loop->index) ?? ''}}" class="form-control">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="inputPosition">Должность</label>
                                                    <input name="participants[position][{{$loop->index}}]" value="{{old('participants.position.'.$loop->index) ?? ''}}" type="text" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="inputContact">Контакты</label>
                                                    <input name="participants[contacts][{{$loop->index}}]" value="{{old('participants.contacts.'.$loop->index) ?? ''}}" type="text" class="form-control">
                                                </div>   <div class="form-group col-md-2">
                                                    <label for="inputContact">Агент</label>
                                                    <select name="participants[is_agent][{{$loop->index}}]"  class="form-control">
                                                        <option value="{{old('participants.is_agent.'.$loop->index) ?? ''}}">{{old('participants.is_agent.'.$loop->index) ?? ''}}</option>
                                                    </select>
                                                </div><i style="margin-top: 40px;margin-left: 14px;" class="fa fa-times remove"></i></div>


                                        @endforeach

                                            <script>
                                                $(document).ready(function () {


                                                    $('html').on('click','#add_participant',function () {

                                                        $('#add_participant_content').append('<div class="form-row">' +
                                                            '<div class="form-group col-md-4">\n' +
                                                            '                            <label for="inputFio">Фамилия</label>\n' +
                                                            '                            <input name="participants[fio][]" type="text" class="form-control">\n' +
                                                            '                        </div>\n' +
                                                            '                        <div class="form-group col-md-2">\n' +
                                                            '                            <label for="inputPosition">Должность</label>\n' +
                                                            '                            <input name="participants[position][]" type="text" class="form-control">\n' +
                                                            '                        </div>\n' +
                                                            '                        <div class="form-group col-md-3">\n' +
                                                            '                            <label for="inputContact">Контакты</label>\n' +
                                                            '                            <input name="participants[contacts][]" type="text" class="form-control" >\n' +
                                                            '                        </div>' +
                                                            '   <div class="form-group col-md-2">\n' +
                                                            '                                <label for="inputContact">Агент</label>\n' +
                                                            '                                    <select name="participants[is_agent][]"  class="form-control" >\n' +
                                                            '                                    <option value="Да">Да</option>\n' +
                                                            '                                    <option value="Нет" selected>Нет</option>\n' +
                                                            '                                </select> \n' +
                                                            '                            </div>' +
                                                            '<i style="margin-top: 40px;margin-left: 14px;" class="fa fa-times remove"></i></div>\n');
                                                    });

                                                    $('html').on('click','.remove',function () {

                                                        $(this).parent().remove();

                                                    });
                                                });

                                            </script>

                                    @else
                                        <script>
                                            $(document).ready(function () {


                                                $('html').on('click','#add_participant',function () {

                                                    $('#add_participant_content').append('<div class="form-row">' +
                                                        '<div class="form-group col-md-4">\n' +
                                                        '                            <label for="inputFio">Фамилия</label>\n' +
                                                        '                            <input name="participants[fio][]" type="text" class="form-control">\n' +
                                                        '                        </div>\n' +
                                                        '                        <div class="form-group col-md-2">\n' +
                                                        '                            <label for="inputPosition">Должность</label>\n' +
                                                        '                            <input name="participants[position][]" type="text" class="form-control">\n' +
                                                        '                        </div>\n' +
                                                        '                        <div class="form-group col-md-3">\n' +
                                                        '                            <label for="inputContact">Контакты</label>\n' +
                                                        '                            <input name="participants[contacts][]" type="text" class="form-control" >\n' +
                                                        '                        </div>' +
                                                        '   <div class="form-group col-md-2">\n' +
                                                        '                                <label for="inputContact">Агент</label>\n' +
                                                        '                                    <select name="participants[is_agent][]"  class="form-control" >\n' +
                                                        '                                    <option value="Да">Да</option>\n' +
                                                        '                                    <option value="Нет" selected>Нет</option>\n' +
                                                        '                                </select> \n' +
                                                        '                            </div>' +
                                                        '<i style="margin-top: 40px;margin-left: 14px;" class="fa fa-times remove"></i></div>\n');
                                                });

                                                $('html').on('click','.remove',function () {

                                                    $(this).parent().remove();

                                                });
                                            });

                                        </script>

                                    @endif

                                </div>

                             </div>
                           </div>



                        <div  style="padding: 0.75rem;"  class="row">
                            <div class="col-12">
                            <h6>Описание</h6>
                            <div class="form-group">
                                <textarea  style="width: 100%;" class="form-control" name="desc_prework" id="exampleFormControlTextarea1" rows="3" >{{old('desc_prework') ?? ''}}</textarea>
                            </div>


                            </div>
                        </div>




                        <div  class="row">
                            <div style="margin-left: 11px;" class="col-12">
                            <div id="file_content" class="form-group">
                                <label for="exampleFormControlFile1">  <b>Добавить файл:</b></label>
                                <div><input type="file" name="file_pre_work[]"  class="form-control-file" id="exampleFormControlFile1"></div>



                            </div>
                            <a id="add_file" href="javascript:void(0)">Еще...</a>
                            <script>
                                $(document).ready(function () {
                                    $('#add_file').on("click",function () {

                                        $('#file_content').append('<div style="margin-top:5px;"><input style="width: 250px;float: left" type="file" name="file_pre_work[]" class="form-control-file" id="exampleFormControlFile1"><i class="fa fa-times remove_file"></i></div>');
                                    }) ;

                                    $('html').on('click','.remove_file',function () {

                                        $(this).parent().remove();

                                    });

                                });

                            </script>
                            </div>
                        </div>


                    </div>


                </div>

                @csrf
                <div class="modal-footer">
                    <a href="{{route('preworks.index')}}"  class="btn btn-secondary" data-dismiss="modal">Закрыть</a>
                    <button id="add_work"  type="submit" class="btn btn-primary">Добавить</button>

                </div>



            </form>
        </div>

    </div>

<script>
    $(document).ready(function () {

    $(".elem").click(function () {

        let attr = $(this).attr('attr_class');
        let id = $(this).attr('attr_id');
        $.ajax({
            type: "POST",
            url: "attr-val",
            data: {
                "class" : attr,
                "_token": $("input[name='_token']").val()
            },
            success: function(msg){
                $('#content_attr_'+id).html(msg);
            }
        });
     });

        $("#attr_simple_1").on("keyup change", function() {
            var that = $(this);
            var validValue = that.data("validValue") || "";
            var newValue = that.val();
            if (newValue.match(/^\d+\.?\d*$/)) {
                that.data("validValue", that.val());
            } else {
                that.val(validValue);
            }
        });

        $("#attr_simple_8").on("keyup change", function() {
            var that = $(this);
            var validValue = that.data("validValue") || "";
            var newValue = that.val();
            if (newValue.match(/^\d+\.?\d*$/)) {
                that.data("validValue", that.val());
            } else {
                that.val(validValue);
            }
        });

        $("#int_6").on("keyup change", function() {
            var that = $(this);
            var validValue = that.data("validValue") || "";
            var newValue = that.val();
            if (newValue.match(/^\d+\.?\d*$/)) {
                that.data("validValue", that.val());
            } else {
                that.val(validValue);
            }
        });

        $("#int_11").on("keyup change", function() {
            var that = $(this);
            var validValue = that.data("validValue") || "";
            var newValue = that.val();
            if (newValue.match(/^\d+\.?\d*$/)) {
                that.data("validValue", that.val());
            } else {
                that.val(validValue);
            }
        });




    });
</script>






