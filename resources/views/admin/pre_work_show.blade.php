<div class="container">


    <form id="form-filter" action="{{route('filter_form')}}" method="post" enctype="multipart/form-data">


        <table class="table">
            <thead>
            <tr>
                <th style="background:  #f6f6f6;border: none" scope="col">Поиск по фильтрам</th>

            </tr>
            </thead>
            <tr>
                <td style="border-top:0px;">
                    <br>
                    <span  style="margin-right: 5px;">Добавить фильтр: </span>
                    <select id="add_filter" name="add_filter">
                        <option id="default" selected>Выбрать</option>
                        <option id="static_name" value="static_name">Тема</option>
                        <option id="static_author" value="static_author">Ответственный</option>
                        @foreach($filters as $filter)
                            <option id="{{$filter->attrType->name}}" value="{{$filter->attrType->name}}">{{$filter->attr_name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
            <tr>
                &nbsp;
            </tr>
            </thead>
            <tbody id="add_content_table">


            {{-- контент фильтров--}}
            </tbody>
        </table>



        <table class="table">
            <thead>
            <tr>
                <th style="background:  #f6f6f6;border: none"  scope="col">Отображение результатов</th>
                <th style="background:  #f6f6f6;border: none"  scope="col">&nbsp;</th>
                <th style="background:  #f6f6f6;border: none"  scope="col">&nbsp;</th>
                <th style="background:  #f6f6f6;border: none"   scope="col">&nbsp;</th>

            </tr>
            </thead>
            <tr>

                <td >
                    <select id="available_op" class="form-control" style="min-width: 150px;min-height: 150px" name="available_op[]" multiple>
                        @foreach($filters as $filter)
                            <option id="{{$filter->attrType->name}}" att_id_="{{$filter->id}}" value="{{$filter->attrType->name}}">{{$filter->attr_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td style="width: 1%">
                    <br/>
                    <p id="add_left" class="btn btn-info">←</p><br>
                    <p id="add_right" class="btn btn-info">→</p>
                </td>
                <td >
                    <select name="select_op" id="select_op" class="form-control" style="min-width: 150px;min-height: 150px"   id="select_row" name="" multiple>
            @if($pre_works)


                    {{--    <option value="" disabled>Тема</option>
                        <option value="" disabled>Автор</option>--}}

            @else
                <option>
                   не выбрано
                </option>

                @endif
                    </select>

                </td>
                <td>
                    <br/>
                    <p id="up"  class="btn badge-light">↑</p><br>
                    <p id="down" class="btn badge-light">↓</p>
                </td>
            </tr>
        </table>


       @csrf


        <div class="row">
            <div style="" class="col-4">
                <p id="submit_filter" class="btn btn-info">Применить</p>
                <p class="btn btn-danger"><a style="color: white" href="./preworks">Сбросить</a></p>
            </div>
            <div style="" class="col-4">&nbsp;</div>
            <div style="" class="col-4">


                <p style="float: right"><a class="btn btn-info" href="{{route('preworks.create')}}">Добавить работу</a></p>
            </div>
        </div>
    </form>

<table id="content_work" class="table">

   @if($pre_works)
        <thead>
        <tr>
            <th scope="col">#</th>

            <th scope="col">Тема</th>
            <th scope="col">Ответственный</th>
            <th></th>

        </tr>
        </thead>
        <tbody>
       @foreach($pre_works as $pre_work)
            <tr>
                <td>{{$pre_work->id}}</td>

                <td><a href="{{route('preworks.show',$pre_work->id)}}">{{$pre_work->name}}</a></td>
                <td>{{$pre_work->author->name}}</td>
                <td style="text-align: right">
                    <div class="row">
                        <div class="cols-2">
                            <a class="fa fa-pencil-square-o" style="color: #2fa360" href="{{route('preworks.edit',$pre_work->id)}}"></a> /

                        </div>
                        <div class="cols-2">
                            <form id="delete-form" action="{{route('preworks.delete',$pre_work->id)}}" method="post">
                                @csrf
                                <button id="delete-confirm" data-id="{{$pre_work->id}}" style="margin-top: -8px;color:indianred"  class="btn btn-link fa fa-trash-o"></button>
                            </form>
                        </div>
                    </div>
                   </td>

            </tr>
        @endforeach

   @else
       <tr>
           <th colspan="4" scope="row">Работы не найдены</th>
       </tr>
        </tbody>
   @endif

</table>
    <div class="row">
        <div style="" class="col-12">{{$pre_works->links()}}</div>
    </div>


</div>


<script>
    $(document).ready(function () {

      // список фильтров
        $.ajax({
            type: "POST",
            url: "preworks/add-filter",
            data: {
                "class" : 'static_author',
                "_token": $("input[name='_token']").val()
            },
            success: function(msg){
                $("#static_author").attr('disabled','true');
                $('#add_content_table').append(msg);
            }
        });


       $('#add_filter').change(function () {

           let select = $(this).val();

           $("#add_filter option:selected").attr('disabled','true');
           $("#add_filter option:selected").prop('selected', false);

           $.ajax({
               type: "POST",
               url: "preworks/add-filter",
               data: {
                   "class" : select,
                   "_token": $("input[name='_token']").val()
               },
               success: function(msg){

                   $('#add_content_table').append(msg);
               }
           });


       });


        // работа с столбцами
        $('#available_op').change(function () {


            $(document).on('click', '#add_right', function (event) {
                event.preventDefault();

                $('#select_op').append($('#available_op option:selected'));




            });

        });


        // работа с столбцами
        $('#select_op').change(function () {
            $(document).on('click', '#add_left', function (event) {

                event.preventDefault();

                $('#available_op').append($('#select_op option:selected'));
          /*      $('#select_op option').prop('selected', true);*/

            });

        });

        // блокировка option

        $(document).on('click', '.remove', function (event) {

            event.preventDefault();

            let opt = $(this).parents('tr').attr('relate_option');
            $("#"+opt).removeAttr('disabled');

            $(this).closest('tr').remove();
        });



        // отправка формы
        $(document).on('click', '#submit_filter', function (event) {

            let $data = {};
            let arr_option = [];
            let arr_id_attr = [];
            // переберём все элементы input, textarea и select формы с id="myForm "
            $('#form-filter').find('input, textearea, select').each(function () {


                $data[this.name] = $(this).val();

            });

            let arr_opt = $('select[name=select_op] > option').toArray();



            for (let i = 0; i < arr_opt.length; i++) {

                arr_option.unshift(arr_opt[i].value);

            }


            $.ajax({
                type: "POST",
                url: "preworks/filter-form",
                data: {
                    "options" : arr_option,
                    "data" : $data,
                    "_token": $("input[name='_token']").val()
                },
                success: function(msg){

                 console.log(msg);
                  $('#content_work').html(msg);
                  $('.pagination').hide();
                }
            });
        });





    });



</script>






