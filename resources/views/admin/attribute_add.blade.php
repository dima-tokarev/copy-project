<div class="container">
    <h5 >Добавление атрибута в блок: <b>{{$opt_cat->name}}</b></h5>
    <hr>
    <br />
    <form action="{{route('store_attribute')}}" method="post" enctype="multipart/form-data">
    <div class="row">
       <div class="col-12 add_attr">

        <div class="row">

            <div class="col-4 input_opt" >
                <div><b>Название атрибута</b></div>
               <input type="text" class="form-control" name="name" required>
            </div>

            <div class="col-4">
                <div><b>Тип</b></div>
                <select  class="form-control select_attr" name="type_attr">
                    <option value="text">Текстовое поле</option>
                    <option value="list">Список</option>
             {{--       <option value="upload">Вложение</option>--}}
                </select>
            </div>



        </div>

       </div>

    </div>
    <div style="margin-top: 10px;" class="row">
        <div id class="col-6">
           {{-- <a href="javascript:void(0)" id="add_attr" class="btn btn-info">Добавить еще атрибут</a>--}}
        </div>
        <div align="right" class="col-6">
            <input type="hidden" name="cat_attr_id" value="{{$opt_cat->id}}">
            <br/>
            <button type="submit" class="btn btn-info">Сохранить атрибуты</button>
        </div>
    </div>
    @csrf
    </form>
</div>

<script>

    $(document).ready(function () {

/*        $('#add_attr').on('click',function (e) {

            $('.add_attr').append('<div style="margin-top: 15px" class="row">\n' +
                '            <div class="col-4 input_opt" >\n' +
                '\n' +
                '               <input type="text" class="form-control" name="name[]" required>\n' +
                '            </div>\n' +
                '            <div class="col-4">\n' +
                '                <select  class="form-control select_attr" name="type_attr[]">\n' +
                '                    <option value="text">Текстовое поле</option>\n' +
                '                    <option value="list">Список</option>\n' +
                '                    <option value="upload">Вложение</option>\n' +
                '                </select>\n' +
                '            </div>\n' +
                '            <div  class="col-3 opt">\n' +
                '\n' +
                '               \n' +
                '            </div>\n' +
                '<div  class="col-1 opt">\n' +
            '                <a class="delete_item" href="javascript:void(0)" >Удалить</a>\n' +
            '            </div>\n' +

                '        </div>');

        })*/

      $('body').on('click','.delete_item',function () {
          $(this).closest('.row').remove();
      })

      $('.select_attr').on('change',function () {
         let select_type = $(this).val();

         if(select_type == 'list'){

             $('.add_attr').append('<div class="row opt">' +
                     '<div style="margin-top: 20px;" class="col-4">' +
                     '<input class="form-control" type="text" name="option_list[]" placeholder="Введите значение для поля списка ">' +
                     '</div>' +
                 '<div style="margin-top: 25px;" class="col-2"><i style="margin-right: 20px" class="fa fa-plus add_option"></i><i class="fa fa-times del_option"></i></div>' +

                 '</div>');
         }else{
             $('.opt').remove();
         }


      })

        $('body').on('click','.add_option',function () {
            $('.add_attr').append(
                '<div class="row"><div style="margin-top: 20px;" class="col-4"> \n' +
                '<input class="form-control" type="text" name="option_list[]" placeholder="Введите значение для поля списка ">\n' +
                '</div> \n' +
                '<div style="margin-top: 25px;" class="col-2"><i style="margin-right: 20px" class="fa fa-plus add_option"></i><i class="fa fa-times del_option"></i></div></div>');
        })

        $('body').on('click','.del_option',function () {
            $(this).closest('.row').remove();
        })




    })

</script>