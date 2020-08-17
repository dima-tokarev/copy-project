
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
            <th>


            </th>
        </tr>

        @foreach($data[$row->id] as $val)

        <tr>
            <td>
                <div style="margin-left: 10%">{{$val->name}}</div>
            </td>

            <td style="text-align: center;" >
                @if($val->parent_id != 0)
                <button data-dismiss="modal"  class="btn btn-info filed_{{$class}}" id_attr="{{$val->id}}" name='filed_{{$class}}' name_attr="{{$val->name}}" value='{{$val->name}}'><i class="fa fa-check"></i></button>
                @endif

            </td>

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
            <td style="text-align: center;" ><button data-dismiss="modal" onclick="add_item(this)" class="btn btn-info filed_{{$class}}" id_attr="{{$row->id}}" name='filed_{{$class}}' y_e="{{$row->y_e}}" name_attr="{{$row->name}}"  value='{{$row->name}}'><i class="fa fa-check"></i></button></td>
            @else
            <td style="text-align: center;" ><button data-dismiss="modal" onclick="add_item(this)" class="btn btn-info filed_{{$class}}" id_attr="{{$row->id}}" name='filed_{{$class}}' name_attr="{{$row->name}}"   value='{{$row->name}}'><i class="fa fa-check"></i></button></td>
            @endif
        </tr>
        @endforeach
        @endif

        </tbody>
    </table>
    @if($class != 'source')
    {!! $data->links() !!}
    @endif

</div>

<script>

    /* поиск */
    $(document).ready(function () {

        $("#search_client").on('keyup',function () {

            let word = $(this).val();


            $.ajax({
                type: "POST",
                url: "create-search-val",
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

@endif

