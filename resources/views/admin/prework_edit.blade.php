<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="row">
            <div style="padding: 45px" class="col-12">
    @if($pre_works)

        <form action="{{route('preworks.update',$pre_works->id)}}" method="post" enctype="multipart/form-data">
        <div class="row">

            <div class="col-7"><b>Название: </b>{{$pre_works->name}}</div>
            <div style="text-align: right" class="col-5"><b style="margin-right: 3px;">Предварительная работа #{{$pre_works->id}}</b></div>

        </div>

        <div class="row">
            <div class="col-12"></div>

        </div>
        <hr>
        <div class="row">
            <div  id="edit_user"  class="col-7">
                <label><b>Ответственный:</b> </label>
             {{--   <a class="fa fa-pencil-square-o" href="javascript:void(0)"></a>--}}
                <select id="responsible"  class="form-control" name="responsible" >
                    <option disabled value="{{$pre_works->author->id}}" selected> {{$pre_works->author->name}}</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
                </select>


            </div>
            <div style="text-align: right" class="col-5"> <b>Дата добавления: </b> {{date("d-m-Y", strtotime($pre_works->created_at))}}</div>

        </div>
        <hr>
        <br>


            @foreach($attrs as $key => $items)

                @foreach($items as $item)

                    @foreach($item as $attribute)


        <div class="row">
           <div class="col-10">
               <label><b>{{$attribute->attr_name}}:</b> </label><br>
            <div style="float:left;width:68%" id="add_content_att_{{$attribute->attr_id}}_{{$attribute->attr_id}}">

               @if($attribute->object_type == 'custom')
                <!-- Button trigger modal -->

                <select  style="width: 89%;  -webkit-appearance: none;  -moz-appearance: none; appearance: none;float: left;" id="select-attr-{{$attribute->attr_id}}" class="form-control " name="attr[{{$attribute->attr_id}}]">
                    <option id='val_{{$attribute->attr_id}}_{{$attribute->attr_id}}' selected  value="{{$attribute->value}}">{{$attribute->value_table}}</option>
                </select>
                    <button  attr_class="{{$key}}" attr_id="{{$attribute->attr_id}}" type="button" class="btn btn-primary elem" data-toggle="modal" data-target="#exampleModalCenter_{{$attribute->attr_id}}">
                        <i class="fa fa-search"></i>
                    </button>
                   @endif
                   @if($attribute->object_type == 'float')
                 <input id='val_{{$attribute->attr_id}}_{{$attribute->attr_id}}' class='form-control' type='text' name='float_attr[{{$attribute->attr_id}}]'  value="{{$attribute->value}}" >
               @endif
                   @if($attribute->object_type == 'int')
                       <input id='val_{{$attribute->attr_id}}_{{$attribute->attr_id}}' class='form-control' type='text' name='int_attr[{{$attribute->attr_id}}]'  value="{{$attribute->value}}" >
                   @endif
                   @if($attribute->object_type == 'string')
                       <input id='val_{{$attribute->attr_id}}_{{$attribute->attr_id}}' class='form-control' type='date' name='string_attr[{{$attribute->attr_id}}]'  value="{{$attribute->value}}" >
                   @endif
            </div>




            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter_{{$attribute->attr_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{$attribute->attr_name}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="content_attr_{{$attribute->attr_id}}" class="modal-body">

                            @include('admin.pagination_data')
                        </div>

                        <script>
                            $(document).ready( function() {
                                $(document).on('click', '.filed_{{$key}}', function (event) {
                                    event.preventDefault();
                                    let id = $(this).attr('id_attr');
                                    let name = $(this).val();
                                    let y_e = $(this).attr('y_e');


                                    $('#select-attr-{{$attribute->attr_id}}').html("<option id='val_{{$attribute->attr_id}}_{{$attribute->attr_id}}' class='form-control' type='text' value='"+id+"'></option> " )

                                    if(y_e) {
                                        $('#val_6_6').val(y_e);
                                    }
                                    $('#val_{{$attribute->attr_id}}_{{$attribute->attr_id}}').text(name);
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


                            $('#content_attr_{{$attribute->attr_id}}').append("<div id='preloader_malc'><div>Подождите, идет загрузка данных ... </div> </div>");

                            setTimeout(function() {
                                $('#preloader_malc').css('display' , 'none');

                            }, 3000);


                            let page = $(this).attr('href').split('page=')[1];
                            let name = '{{$key}}';
                            fetch_data(page, name);

                        });

                        function fetch_data(page, name) {
                            $.ajax({
                                url: "../attr-val/fetch_data?page=" + page + "&name=" + name,
                                success: function (data) {
                                    $('#content_attr_{{$attribute->attr_id}}').html(data);
                                }
                            })
                        }
                    });




                });


            </script>
           </div>
        </div>
                <hr>    @endforeach
                @endforeach
         @endforeach


         {{--   @foreach($attrs as $attr)
                <div class="row">

                <div id="attr-{{$attr->id_attr}}" class="col"><b>{{$attr->attr_name}}:</b>
           --}}{{--         <a class="fa fa-pencil-square-o"  href="javascript:void(0)"></a>--}}{{--
                   <select  style="width: 100%" id="select-attr-{{$attr->id_attr}}" class="form-control form-control-sm" name="attr[{{$attr->id_attr}}]" disabled>
                    <option selected value="{{$attr->value_type}}">{{$attr->value_attr}}</option>
                       @foreach($change_attrs[$attr->attr_type] as $item)
                        @if($attr->attr_type == 'source')
                         @if($item->parent_id == 0)
                           <option style="color:#000000;font-weight: bold" value="{{$item->id}}" disabled>{{$item->name}}</option>
                           @else
                               <option value="{{$item->id}}">{{$item->name}}</option>
                           @endif
                          @else
                               <option value="{{$item->id}}">{{$item->name}}</option>
                        @endif
                       @endforeach
                   </select>

                </div>

             <script>
                 $(document).ready(function () {

                     $('#attr-{{$attr->id_attr}}').on('click',function () {

                         $('#select-attr-{{$attr->id_attr}}').prop('disabled',false);
                     })

                 });
             </script>
                </div>
                <hr>
            @endforeach--}}

 {{--       <div class="row">

            @foreach($float_attr as $attr)

                <div id="attr-{{$attr->id_attr}}" class="col-12"><b>{{$attr->attr_name}}:</b>  --}}{{--<a class="fa fa-pencil-square-o"  href="javascript:void(0)"></a>--}}{{-- <input style="width: 33%" id="input-attr-{{$attr->id_attr}}"  class="form-control" name="float_attr[{{$attr->id_attr}}]" type="text" value="{{$attr->value_type}}" > <hr></div>
                <script>
                    $(document).ready(function () {

                        $('#attr-{{$attr->id_attr}}').on('click',function () {

                            $('#input-attr-{{$attr->id_attr}}').prop('disabled',false);
                        })

                    });
                </script>
            @endforeach

        </div>--}}

  {{--      <div class="row">
            @foreach($int_attr as $attr)

                <div id="attr-{{$attr->id_attr}}" class="col-12"><b>{{$attr->attr_name}}:</b>  --}}{{--<a class="fa fa-pencil-square-o"  href="javascript:void(0)"></a> --}}{{--<input style="width: 33%" id="input-attr-{{$attr->id_attr}}" class="form-control" name="int_attr[{{$attr->id_attr}}]" type="text" value="{{$attr->value_type}}" > <hr></div>
                <script>
                    $(document).ready(function () {

                        $('#attr-{{$attr->id_attr}}').on('click',function () {

                            $('#input-attr-{{$attr->id_attr}}').prop('disabled',false);
                        })

                    });
                </script>
            @endforeach
        </div>--}}
            @if($pre_works->author_id === \Auth::user()->id || $pre_works->user_id === \Auth::user()->id || \Gate::allows('edit_attr_admin') == true)
            <div class="row">
     {{--         @isset($string_attr)
                @foreach($string_attr as $attr)

                    <div id="attr-{{$attr->id_attr}}" class="col-12"><b>{{$attr->attr_name}}:</b> --}}{{-- <a class="fa fa-pencil-square-o" id="attr-{{$attr->id_attr}}" href="javascript:void(0)"></a>--}}{{-- <input style="width: 33%" id="input-attr-{{$attr->id_attr}}" class="form-control" name="string_attr[{{$attr->id_attr}}]" type="date" value="{{$attr->value_type}}" > <hr></div>
                    <script>
                        $(document).ready(function () {

                            $('#attr-{{$attr->id_attr}}').on('click',function () {

                                $('#input-attr-{{$attr->id_attr}}').prop('disabled',false);
                            })

                        });
                    </script>
                @endforeach
               @endisset--}}
            </div>
            @endif
        <div class="row">


        </div>
        @if($pre_works->author_id === \Auth::user()->id || $pre_works->user_id === \Auth::user()->id)
                @canany(['edit_attr_admin','edit_attr_manager'])
            <div class="row">
                <div class="col-12">
                    <h6><b>Участники со стороны заказчика:</b></h6>
                    <br>
                    <table class="table">
                        <thead>
                        <tr>
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

                                    <td><input name="participants[fio][{{$participant->id}}]]" class="form-control" type="text" value="{{$participant->name}}"></td>
                                    <td><input name="participants[position][{{$participant->id}}]]"class="form-control" type="text" value="{{$participant->position}}"></td>
                                    <td><input name="participants[contacts][{{$participant->id}}]]"class="form-control" type="text" value="{{$participant->contacts}}"></td>
                                    <td>
                                        <select style="width: 73px;" class="form-control" name="participants[is_agent][{{$participant->id}}]]">
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
                        <tr>
                            <td colspan="4">
                                <div class="row">
                                    <div class="col-12">
                                     <div id="add_participant_content"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> <a style="margin-left: -18px" id="add_participant" class="btn btn-link" href="javascript:void(0)">Добавить</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
              @endcanany
          @endif
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

        <br/>

            @if($pre_works->user_id === \Auth::user()->id)
                <div style="padding-left:15px;padding-right: 15px" id="desc_block" class="row">

                    <div class="col"><b>Описание:</b></div>




                    <textarea id="desc"  style="min-height: 100px" class="form-control" name="desc" disabled>{{$pre_works->description}}</textarea>
                    <br>


                </div>
            @endif

            <br> <br>
            <div class="row">

                <div class="col"><b>Добавить комментарий:</b></div>

            </div>
            <div style="margin: -1px" class="row">

                <textarea id="comment_textarea" style="margin: 13px;min-height: 100px" class="form-control" name="comment"></textarea>
                <br>

            </div>

            <br>
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
        <hr>
        <br>
        <div class="padding: 14px;" class="row">

            <div id="file_content" class="form-group">
                <label for="exampleFormControlFile1">  <b>Добавить файл:</b></label>
                <div><input type="file" name="file_pre_work[]" class="form-control-file" id="exampleFormControlFile1" multiple></div>



            </div>
        {{--   <a id="add_file" href="javascript:void(0)">Еще...</a>--}}
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

            @if(\Auth::user()->id == $pre_works->user_id || \Auth::user()->id == $pre_works->author_id)

            @csrf
            @method('PUT')

             <input type="hidden" name="pre_work_id" value="{{$pre_work_id}}">
   {{--       <div class="row">
              <div class="col-6">
                <button align="right" class="btn btn-info">Сохранить</button>
              </div>
              <div class="col-6">
                  <a style="margin-left: 70%" class="btn btn-info" href="{{asset('admin/preworks/'.$pre_work_id)}}">Отмена</a>

              </div>
          </div>--}}
            <br>
            <div class="row">

                    <div  class="col-4">
                        @canany(['edit_attr_admin','edit_attr_manager'])
                        <button name="agreement" value="agreement"  type="submit" class="btn btn-success">К согласованию</button>
                        @endcanany
                    </div>

                <div align="right" class="col-8">
                    <a href="{{asset('admin/preworks/'.$pre_work_id)}}"  class="btn btn-secondary" data-dismiss="modal">Закрыть</a>
                    <button id="add_work"  type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>


            @elseif(\Gate::allows('edit_attr_admin') || \Gate::allows('edit_attr_leader'))

                @csrf
                @method('PUT')

                <input type="hidden" name="pre_work_id" value="{{$pre_work_id}}">
          {{--      <div class="row">
                    <div class="col-6">
                        <button align="right" class="btn btn-info">Сохранить</button>
                    </div>
                    <div class="col-6">
                        <a style="margin-left: 70%" class="btn btn-info" href="{{asset('admin/preworks/'.$pre_work_id)}}">Отмена</a>

                    </div>
                </div>--}}

                <div class="row">
                    <div  class="col-4">
                    @canany(['edit_attr_admin','edit_attr_manager'])

                        <button name="agreement" value="agreement"  type="submit" class="btn btn-success">К согласованию</button>

                    @endcanany
                    </div>
                    <div align="right" class="col-8">
                        <a href="{{asset('admin/preworks/'.$pre_work_id)}}"  class="btn btn-secondary" data-dismiss="modal">Закрыть</a>
                        <button id="add_work"  type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>

            @else
                {{--    false --}}
            @endif

        </form>
    @endif
            </div>
        </div>
    </div>
</div>

<script>


    $(document).ready(function () {

      $('#edit_user').on('click',function () {
          $('#responsible').prop('disabled',false);
      })
        $('#desc_block').on('click',function () {
            $('#desc').prop('disabled',false);
        })



        $(".elem").click(function () {

        let attr = $(this).attr('attr_class');
        let id = $(this).attr('attr_id');
            $.ajax({
                type: "POST",
                url: "../edit-attr-val",
                data: {
                    "class" : attr,
                    "_token": $("input[name='_token']").val()
                },
                success: function(msg){
                    $('#content_attr_'+id).html(msg);
                }
            });
        });

        tinymce.init({
            selector: '#comment_textarea',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
            language:"ru",
            width:'100%'
        })

      /* маска к полю */

        $("#val_1_1").on("keyup change", function() {
            var that = $(this);
            var validValue = that.data("validValue") || "";
            var newValue = that.val();
            if (newValue.match(/^\d+\.?\d*$/)) {
                that.data("validValue", that.val());
            } else {
                that.val(validValue);
            }
        });

        $("#val_8_8").on("keyup change", function() {
            var that = $(this);
            var validValue = that.data("validValue") || "";
            var newValue = that.val();
            if (newValue.match(/^\d+\.?\d*$/)) {
                that.data("validValue", that.val());
            } else {
                that.val(validValue);
            }
        });

        $("#val_6_6").on("keyup change", function() {
            var that = $(this);
            var validValue = that.data("validValue") || "";
            var newValue = that.val();
            if (newValue.match(/^\d+\.?\d*$/)) {
                that.data("validValue", that.val());
            } else {
                that.val(validValue);
            }
        });


        $("#val_11_11").on("keyup change", function() {
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
