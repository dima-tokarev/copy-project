<div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add_form" action="{{route('preworks.store')}}" method="post" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Предварительные работы</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">


                        <div class="form-group">

                            <label for="exampleFormControlInput1"></label>
                            <input type="text" class="form-control" name="name_prework" id="exampleFormControlInput1" placeholder="Введите название работы">
                        </div>
                        <div class="form-group">

                            <label for="exampleFormControlInput1">Ответственный</label>
                         @isset($users)
                            <select  name="responsible" class="form-control form-control-sm">
                                <option selected></option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                         @endisset
                        </div>

                        <br/>
                        <h5 align="center">Основные атрибуты</h5>
                        <br/>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Наименование</th>
                                <th scope="col">Значение</th>

                            </tr>
                            </thead>
                            <tbody>
                            @if($attributes)
                                @foreach ($attributes as $attribute)

                                    @if($attribute->attrType->name == 'float_attribute_values' or $attribute->attrType->name == 'int_attribute_values' )
                                        <tr>
                                            <th scope="row">{{$attribute->id}}</th>
                                            <td>{{$attribute->attr_name}}</td>
                                            <td>
                                                <input type="number" name="attr_simple[{{$attribute->id}}][{{$attribute->attrType->name}}]" value="0" class="form-control" size="20" placeholder="Введите значение">
                                                <input type="hidden" name="object_id" value="{{$object_id}}">
                                            </td>

                                        </tr>
                                    @endif
                                    @if($attribute->attrType->name == 'string_attribute_values')
                                        <tr>
                                            <th scope="row">{{$attribute->id}}</th>
                                            <td>{{$attribute->attr_name}}</td>
                                            <td>
                                                <input type="text" name="attr_simple[{{$attribute->id}}][{{$attribute->attrType->name}}]"  class="form-control" size="20" placeholder="Введите значение">
                                                <input type="hidden" name="object_id" value="{{$object_id}}">
                                            </td>

                                        </tr>
                                    @endif
                                    @if($attribute->attrType->name != 'string_attribute_values' && $attribute->attrType->name != 'float_attribute_values' && $attribute->attrType->name != 'int_attribute_values')
                                       @if($attribute->attr_name != 'Статус')
                                        <tr>

                                            <th scope="row">{{$attribute->id}}</th>
                                            <td>{{$attribute->attr_name}}</td>

                                            <td>

                                                <div style="float:left" id="add_content_att_{{$attribute->attrType->name}}_{{$attribute->id}}">
                                                    <!-- Button trigger modal -->

                                                </div>
                                                <button id="elem{{$attribute->id}}" attr_class="{{$attribute->attrType->name}}" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter_{{$attribute->id}}">
                                                    <i class="fa fa-search"></i>
                                                </button>



                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalCenter_{{$attribute->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">Атрибуты</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div id="content_attr_{{$attribute->id}}" class="modal-body">

                                                                    @include('admin.pagination_data')
                                                            </div>

                                                            <script>
                                                                $(document).ready( function() {
                                                                  $(document).on('click', '.filed_{{$attribute->attrType->name}}', function (event) {
                                                                        event.preventDefault();
                                                                        let id = $(this).attr('id_attr');
                                                                        let name = $(this).val();

                                                                      $('#add_content_att_{{$attribute->attrType->name}}_{{$attribute->id}}').html("<input id='val_{{$attribute->attrType->name}}_{{$attribute->id}}' class='form-control' type='text' name='attr_custom[{{$attribute->id}}][{{$attribute->attrType->name}}]["+id+"]'>")
                                                                      $('#val_{{$attribute->attrType->name}}_{{$attribute->id}}').val(name);
                                                                  });
                                                                });

                                                            </script>
                                                       {{--     <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                                                <button id="add_att_btn_{{$attribute->id}}" type="button"  data-dismiss="modal" class="btn btn-primary">Добавить</button>
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


                                                                $('#content_attr_{{$attribute->id}}').append("<div id='preloader_malc'><div>Подождите, идет загрузка данных ... </div> </div>");

                                                                setTimeout(function() {
                                                                    $('#preloader_malc').css('display' , 'none');

                                                                }, 3000);


                                                                let page = $(this).attr('href').split('page=')[1];
                                                                let name = '{{$attribute->attrType->name}}';
                                                                fetch_data(page, name);

                                                            });

                                                            function fetch_data(page, name) {
                                                                $.ajax({
                                                                    url: "attr-val/fetch_data?page=" + page + "&name=" + name,
                                                                    success: function (data) {
                                                                        $('#content_attr_{{$attribute->id}}').html(data);
                                                                    }
                                                                })
                                                            }
                                                        });


                                                        $("#elem{{$attribute->id}}").click(function () {

                                                            $.ajax({
                                                                type: "POST",
                                                                url: "attr-val",
                                                                data: {
                                                                    "class" : '{{$attribute->attrType->name}}',
                                                                    "_token": $("input[name='_token']").val()
                                                                },
                                                                success: function(msg){
                                                                    $('#content_attr_{{$attribute->id}}').html(msg);
                                                                }
                                                            });
                                                        });

                                                    });


                                                </script>

                                            </td>

                                        </tr>
                                    @endif

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


                        <h5>Описание</h5>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Краткое описание</label>
                            <textarea  style="width: 100%;" class="form-control" name="desc_prework" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>

                        <br/>
                        <h5 align="left">Прикрепить файлы</h5>
                        <div class="row">

                            <div class="col-sm">
                                <input name="doc_prework" type="file">
                            </div>


                        </div>



                    </div>


                </div>

                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button id="add_work"  type="submit" class="btn btn-primary">Добавить</button>

                </div>


            </form>
        </div>

    </div>






