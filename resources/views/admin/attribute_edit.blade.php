<div class="container">
    <h5 >Редактирование атрибутов блока: <b>{{$cat->name}}</b></h5>
    <hr>
    <br />

    <div class="row">
        <div  class="col-12">
            @if($message = Session::get('success'))
                <div class="alert alert-success">
                    <p> {{ $message }} </p>
                </div>
            @endif
        </div>
    </div>

    <form action="{{route('update_attribute')}}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 add_attr">

                <div class="row">
                @if($type_opt->type == 'text' )
                    <div class="col-4 input_opt" >
                        <div><b>Название атрибута</b></div>
                        <input type="text" class="form-control" name="name" value="{{$type_opt->name}}">
                    </div>
                @else
                        <div class="col-4 input_opt" >
                            <div><b>Название атрибута</b></div>
                            <input type="text" class="form-control" name="name" value="{{$type_opt->name}}">
                        </div>
                        <div class="col-8">
                            <div class="edit_list"><b>Значение списка</b>

                                @foreach($options as $option)

                                    <div class="row">
                                        <div class="col-9">
                                            <input class="form-control" type="text"  name="option_list[{{$option->id}}]" value="{{$option->value_option}}">
                                            </div>
                                        <div class="col-3"><i style="margin-right: 20px" class="fa fa-plus add_option"></i><i data-del="{{$option->id}}" data-val="{{$option->value_option}}" class="fa fa-times del_option"></i></div>

                                        </div>
                                @endforeach
                            </div>
                        </div>
                    @endif




                </div>

            </div>

        </div>
        <div style="margin-top: 10px;" class="row">
            <div id class="col-6">
                {{-- <a href="javascript:void(0)" id="add_attr" class="btn btn-info">Добавить еще атрибут</a>--}}
            </div>
            <div align="right" class="col-6">
                <input type="hidden" name="attr_id" value="{{$type_opt->id}}">
                <br/>
                <button type="submit" class="btn btn-info">Сохранить атрибуты</button>
            </div>
        </div>
        @csrf
    </form>
</div>

<script>

    $(document).ready(function () {


        $('body').on('click','.delete_item',function () {
            $(this).closest('.row').remove();
        })


        $('body').on('click','.add_option',function () {
            $('.edit_list').append(
                '<div class="row"><div  class="col-9"> \n' +
                '<input class="form-control" type="text" name="option_list[]" placeholder="Введите значение для поля списка ">\n' +
                '</div> \n' +
                '<div  class="col-3"><i style="margin-right: 20px" class="fa fa-plus add_option"></i><i class="fa fa-times del_option"></i></div></div>');
        })

        $('body').on('click','.del_option',function () {

            let del = $(this).attr('data-del');
            let val = $(this).attr('data-val');
            $('.edit_list').append('' +
                '<input type="hidden" name="del_list['+del+']" value="'+val+'">');

            $(this).closest('.row').remove();
        })




    })

</script>