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
                    <select style="width: 33.5%" class="form-control" id="add_filter" attr_id="" name="add_filter">
                        <option id="default" selected>Выбрать</option>
                        <option id="static_name" value="static_name">Название</option>
                        <option id="static_author" value="static_author">Ответственный</option>
                        @foreach($filters as $filter)
                            <option id="filter_{{$filter->attr->id}}" attr_id="{{$filter->attr->id}}" value="{{\App\ObjectType::where('id',$filter->attr->attr_type)->first()->name}}">{{$filter->attr->attr_name}}</option>
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



      {{--  <table class="table">
            <thead>
            <tr>
                <th style="background:  #f6f6f6;border: none"  scope="col">Отображение результатов</th>
                <th style="background:  #f6f6f6;border: none"  scope="col">&nbsp;</th>
                <th style="background:  #f6f6f6;border: none"  scope="col">&nbsp;</th>
                <th style="background:  #f6f6f6;border: none"   scope="col">&nbsp;</th>

            </tr>
            </thead>
            <tr>

                <td>
                    <select id="available_op" class="form-control" style="min-width: 150px;min-height: 150px" name="available_op[]" multiple>
                        @foreach($filters as $filter)
                            <option id="filter_{{$filter->attr->attr_name}}" att_id_="{{$filter->attr->id}}" value="{{$filter->attr->attr_name}}">{{$filter->attr->attr_name}}</option>
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


                    --}}{{--    <option value="" disabled>Тема</option>
                        <option value="" disabled>Автор</option>--}}{{--

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
        </table>--}}


       @csrf


        <div style="margin-bottom: 25px" class="row">
            <div style="" class="col-4">
                <p id="submit_filter" class="btn btn-info">Применить</p>
                <p class="btn btn-danger"><a style="color: white" href="./preworks">Сбросить</a></p>
            </div>
            <div style="" class="col-4">&nbsp;</div>
            <div style="" class="col-4">

                @canany(['edit_attr_admin','edit_attr_manager'])
                <p style="float: right"><a class="btn btn-info" href="{{route('preworks.create')}}">Добавить работу</a></p>
                @endcanany
            </div>
        </div>
    </form>

    <script>
        let arr_option = [];
        let id_filter = [];
        // список действие
        $(document).on('change', '#select_row_filter', function (event) {

            let $data = {};


            let table = $(this).val();
            let filter_name = $(this).find(':selected').attr('attr_name');
            let id = $(this).find(':selected').attr('attr_id_filter');

            id_filter.push(id);
            arr_option.push(table);

            $("#select_row_filter option:selected").attr('disabled','true');
            $("#select_row_filter option:selected").prop('selected', false);

            // переберём все элементы input, textarea и select формы с id="myForm "
            $('#form-filter').find('input, textearea, select').each(function () {


                $data[this.name] = $(this).val();

            });

            console.log(arr_option);
            $.ajax({
                type: "POST",
                url: "preworks/filter-form",
                data: {
                    "table" : table,
                    "filter_name" : filter_name,
                    "id_filter" : id_filter,
                    "arr_option" : arr_option,
                    "data" : $data,
                    "_token": $("input[name='_token']").val()
                },
                success: function(msg){

                        let res = JSON.parse(msg);
                        $('#head_work').append(res.html_head);
                        $('#content_work').html(res.html_content);
                        $('.pagination').hide();
                }
            });
        });


    </script>
<table  class="table">

   @if($pre_works)
        <thead>
        <tr id="head_work">

            <th scope="col">№</th>
            <th scope="col">Название</th>
            <th scope="col">Ответственный</th>
            <th scope="col"><span style="float: left">Действие</span>
                <div class="select_row"><select style="width: 19px"  id="select_row_filter" name="select_row_filter" >
                <option selected>Выбрать</option>
                @foreach($filters as $filter)
                    <option  attr_id_filter="{{$filter->attr->id}}" attr_name="{{$filter->attr->attr_name}}" value="{{\App\ObjectType::find($filter->attr->attr_type)->name}}">{{$filter->attr->attr_name}}</option>
                @endforeach
                </select></div></th>

        </tr>
        </thead>
        <tbody id="content_work">

       @foreach($pre_works as $pre_work)
            <tr >

                <td style="width: 2%">{{$pre_work->id}}</td>

                <td style="width: 10%"><a href="{{route('preworks.show',$pre_work->id)}}">{{$pre_work->name}}</a></td>
                <td style="width: 10%">{{$pre_work->author->name}}</td>
                <td style="width: 10%;text-align: right;">

                    @canany(['edit_attr_admin', 'edit_attr_leader'])
                        <div style="margin-left: 0px" class="row">
                            <div style="width: 25px;" class="cols-1">
                                <a class="fa fa-pencil-square-o" style="color: #2fa360" href="{{route('preworks.edit',$pre_work->id)}}"></a> /

                            </div>
                            <div style="width: 25px;" class="cols-1">
                                <form id="delete-form" action="{{route('preworks.delete',$pre_work->id)}}" method="post">
                                    @csrf
                                    <button id="delete-confirm" data-id="{{$pre_work->id}}" style="margin-top: -4px;color:indianred"  class="btn btn-link fa fa-trash-o"></button>
                                </form>
                            </div>
                        </div>
                    @endcanany
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




<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div  class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="content_attr" attr_class_modal="" class="modal-body">

               @include('admin.pagination_data_filter')
            </div>

            <script>

                    function attr_class(elmnt) {

                        let attr_class = elmnt.getAttribute('attr_class');

                        // список фильтров
                        $.ajax({
                            type: "POST",
                            url: "preworks/attr-val-filter",
                            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            data: {
                                "class" : attr_class,
                            },
                            success: function(msg){
                                $('#content_attr').attr('attr_class_modal',attr_class)
                                $('#content_attr').html(msg);
                            }
                        });




                    }

                    function add_item(val) {

                        let attr_class_b = $('#content_attr').attr('attr_class_modal');

                        let id = $(val).attr('id_attr');
                        let name = $(val).val();

                        if ($(val).is(':checked')){
                            $('#select_'+attr_class_b).append("<input style='width:13%;display: inline;border-radius:20px;background: #bde0fd' class='form-control' id='select_"+attr_class_b+id+"' type='text'  value='" + name + "'>");
                            $('#form-filter').append("<input id='" + attr_class_b + id+"' type='hidden' name='"+attr_class_b+"][" + id + "]' value='" + id + "'>");
                        } else {
                            $("#"+attr_class_b+id).remove();
                            $('#select_'+attr_class_b+id).remove();


                        }



                    }



                    $(document).ready( function() {
                        $(document).on('click', '.pagination a', function (event) {

                            event.preventDefault();


                            $('#content_attr').append("<div id='preloader_malc'><div>Подождите, идет загрузка данных ... </div> </div>");

                            setTimeout(function() {
                                $('#preloader_malc').css('display' , 'none');

                            }, 3000);


                            let page = $(this).attr('href').split('page=')[1];
                            let name = $('#content_attr').attr('attr_class_modal');
                            fetch_data(page, name);

                        });

                        function fetch_data(page, name) {
                            $.ajax({
                                url: "preworks/attr-val/fetch_data?page=" + page + "&name=" + name,
                                success: function (data) {
                                    $('#content_attr').html(data);
                                }
                            })
                        }
                    });



            </script>

   <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                     <button id="add_att_btn" type="button"  data-dismiss="modal" class="btn btn-info">Выбрать</button>
                 </div>

        </div>
    </div>
</div>
<!-- / Modal -->



<script>



    $(document).ready(function () {

      // список фильтров


        // по умолчанию атрибут
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
           let id = $(this).find(':selected').attr('attr_id');


           $("#add_filter option:selected").attr('disabled','true');
           $("#add_filter option:selected").prop('selected', false);

           $.ajax({
               type: "POST",
               url: "preworks/add-filter",
               data: {
                   "class" : select,
                   "filter_id" : id,
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
      /*    let arr_option = [];
            let arr_id_attr = [];*/
            // переберём все элементы input, textarea и select формы с id="myForm "
            $('#form-filter').find('input, textearea, select').each(function () {


                $data[this.name] = $(this).val();

            });

            let arr_opt = $('select[name=select_op] > option').toArray();


/*
            for (let i = 0; i < arr_opt.length; i++) {

                arr_option.unshift(arr_opt[i].value);

            }*/


            $.ajax({
                type: "POST",
                url: "preworks/filter-form",
                data: {
              /*      "options" : arr_option,*/
                    "data" : $data,
                    "id_filter" : id_filter,
                    "arr_option" : arr_option,
                    "_token": $("input[name='_token']").val()
                },
                success: function(msg){
                let res = JSON.parse(msg);
                console.log(res);
                  $('#content_work').html(res.html_content);
                  $('.pagination').hide();
                }
            });
        });





    });



</script>






