
@if($data)



<div id="con_{{$class}}" class="table-responsive">
    @if($class == 'client')
        <div class="row">
            <div class="col-12">
                <input id="search_{{$class}}" class="form-control" name="search" value="{{isset($word) ? $word : ''}}" placeholder="поиск по названию">
            </div>
        </div>
        <br>
    @endif

    <table class="table table-striped table-bordered">
        <tr>
            <th width="38%">Название</th>
            <th width="5%">Выбрать</th>

        </tr>
        <tbody >
        @if($class == 'source')
                @foreach($data[0] as $row)


                    <tr>

                        <th>
                            <div>{{$row->name}}</div>

                        </th>

                    </tr>

                    @foreach($data[$row->id] as $val)

                    <tr>
                        <td>
                            <div style="margin-left: 10%">{{$val->name}}</div>
                         </td>
                        @if($val->parent_id != 0)
                    <td style="text-align: center;" >

                        <button data-dismiss="modal"  class="btn btn-info filed_{{$class}}" id_attr="{{$val->id}}" name='filed_{{$class}}' value='{{$val->name}}'><i class="fa fa-check"></i></button>
                    </td>
                     @else
                            <td style="text-align: center;" >
                                sfcsfsdf
                                sfcsfsdf
                            </td>
                        @endif


                     </tr>
                    @endforeach
                @endforeach

            @else
                    @foreach($data as $row)
                <tr>

                    <td>
                        <div>{{$row->name}}</div>

                    </td>
                   @if($class == 'prework_type')
                    <td style="text-align: center;" ><button data-dismiss="modal" onclick="add_item(this)" class="btn btn-info filed_{{$class}}" id_attr="{{$row->id}}" name='filed_{{$class}}' y_e="{{$row->y_e}}"  value='{{$row->name}}'><i class="fa fa-check"></i></button></td>
                   @else
                        <td style="text-align: center;" ><button data-dismiss="modal" onclick="add_item(this)" class="btn btn-info filed_{{$class}}" id_attr="{{$row->id}}" name='filed_{{$class}}'   value='{{$row->name}}'><i class="fa fa-check"></i></button></td>
                    @endif
                </tr>
                    @endforeach
            @endif

        </tbody>
    </table>
    @if($class != 'source')
    {!! $data->links() !!}
    @endif

{{--        <div style="justify-content: left;margin: 0px" class="modal-footer">
            <div  class="row">
                <div  class="col-12">
                    <label><b>Клиент:</b><a style="" id="add_participant1" class="btn btn-link" href="javascript:void(0)">Добавить</a></label>
                    <br>
                    <div id="add_participant_content1">
                    </div>

                </div>
            </div>

        </div>--}}
</div>

<script>

    /* поиск */
    $(document).ready(function () {

        $("#search_client").on('keyup',function () {

            let word = $(this).val();


            $.ajax({
                type: "POST",
                url: "../search-val",
                data: {
                    "class" : 'client',
                    "_token": $("input[name='_token']").val(),
                    "search" :word
                },
                success: function(msg){
                    console.log(msg);
                    $('#con_client').html(msg);
                    $('#search_client').val('').focus().val(word);


                }
            });
        });
    });

</script>
<script>
    $(document).ready(function () {


        $('html').on('click','#add_participant1',function () {

            $('#add_participant_content1').append('<div class="form-row">' +
                '<div class="form-group col-md-6">\n' +
                '                            <label for="inputFio">Название</label>\n' +
                '                            <input name="client[name]" type="text" class="form-control">\n' +
                '                        </div>\n' +
                '                        <div class="form-group col-md-4">\n' +
                '                            <label for="inputPosition">Код 1с</label>\n' +
                '                            <input name="client[с]" type="text" class="form-control">\n' +
                '                        </div>\n' +


                '<i style="margin-top: 40px;margin-left: 14px;" class="fa fa-times remove"></i><button class="btn btn-info">Добавить</button> </div>\n');
        });

        $('html').on('click','.remove',function () {

            $(this).parent().remove();

        });
    });

</script>
@endif

