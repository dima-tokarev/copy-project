
{{--

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
--}}


@if($data)
<div id="con_{{$class}}" >
    <div class="table-responsive prokrutka">
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

                            <td style="text-align: center;" >
                                @if($val->parent_id != 0)
                                    <input type="checkbox" {{--data-dismiss="modal"--}} onclick="add_item(this)" class="filed_{{$class}}{{$val->id}}" id_attr="{{$val->id}}" name='filed_{{$class}}' value='{{$val->name}}'>
                                @endif

                            </td>
                        </tr>
                        <script>
                            if ($("#{{$class}}{{$val->id}}").length){


                                $(".filed_{{$class}}{{$val->id}}").prop('checked', true);
                            }

                        </script>
                    @endforeach

                @endforeach
            @else
                @foreach($data as $row)
                    <tr>

                        <td>
                            <div>{{$row->name}}</div>

                        </td>
                        <td style="text-align: center;" ><input type="checkbox" {{--data-dismiss="modal"--}} onclick="add_item(this)" class="filed_{{$class}}{{$row->id}}" id_attr="{{$row->id}}" name='filed_{{$class}}' value='{{$row->name}}1111'></td>

                    </tr>
                    <script>



                          if ($("#{{$class}}{{$row->id}}").length){


                              $(".filed_{{$class}}{{$row->id}}").prop('checked', true);
                          }





                    </script>


                @endforeach
            @endif


        </table>

    </div>

    <script>
        /* поиск */
        $(document).ready(function () {

            $("#search_client").on('keyup',function () {

                let word = $(this).val();


                $.ajax({
                    type: "POST",
                    url: "preworks/filter-search-val",
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
</div>
@endif



