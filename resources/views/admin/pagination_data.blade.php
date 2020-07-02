

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


@if($data)

<div class="table-responsive">
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
                        <button data-dismiss="modal"  class="btn btn-info filed_{{$class}}" id_attr="{{$val->id}}" name='filed_{{$class}}' value='{{$val->name}}'><i class="fa fa-check"></i></button>
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
                    <td style="text-align: center;" ><button data-dismiss="modal"  class="btn btn-info filed_{{$class}}" id_attr="{{$row->id}}" name='filed_{{$class}}' value='{{$row->name}}'><i class="fa fa-check"></i></button></td>

                </tr>
                    @endforeach
            @endif


    </table>
    @if($class != 'source')
    {!! $data->links() !!}
    @endif
</div>

@endif



