$(document).ready(function () {
 /* admin catalog menu*/
    $('.add_catalog').on('click',function () {

        let id = $(this).attr('data-id');
        let view_id = $(this).attr('view-id');
        $('.f-cat').html('<input name="parent_id" type="hidden" value="'+id+'">');
  /*      $.ajax({

            url:'catalog-add-cat',
            data:{'add_cat': id,'add_view_id':view_id},
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:'POST',
            datatype:'html',
            success: function(html) {

                $('#content_catalog').html(html);

            }


        });*/
    })


    $('.add_series').on('click',function () {

        let id = $(this).attr('data-id');
        let view_id = $(this).attr('view-id');
        $('.f-ser').html('<input name="parent_id" type="hidden" value="'+id+'">');
   /*     $.ajax({

            url:'catalog-add-series',
            data:{'add_series': id,'add_view_id':view_id},
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:'POST',
            datatype:'html',
            success: function(html) {

                $('#content_catalog').html(html);

            }


        });*/
    })


    $('.add_product').on('click',function () {

        let id = $(this).attr('data-id');


        $.ajax({

            url:'catalog-add-product',
            data:{'add_series': id},
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:'POST',
            datatype:'html',
            success: function(html) {

                $('#content_catalog').html(html);

            }


        });
    })


    $('.select_cat_product').on('click',function () {

        let id = $(this).attr('data-id-cat');
        let view_id = $(this).attr('view-id');

        console.log(id);


        $.ajax({

            url:'catalog-select-product',
            data:{'select_id': id,'view_id':view_id},


            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:'POST',
            datatype:'html',
            success: function(html) {

                $('#content_catalog').html(html);

            }


        });
    })







    /* end admin catalog menu*/
    /* user  catalog menu*/

    $('.user_select_cat_product').on('click',function () {

        let id = $(this).attr('data-id-cat');
        let view_id = $(this).attr('view-id');
        console.log(id);


        $.ajax({

            url:'catalog-select-product',
            data:{'select_id': id,'view_id':view_id},
           headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:'POST',
            datatype:'html',
            success: function(html) {

                $('#content_catalog').html(html);

            }


        });
    })

    /* and user  catalog menu*/

    /* 1c  catalog menu*/

    $('.select_cat_1c_product').on('click',function () {


      let id = $(this).attr('data-id-cat');



        $.ajax({

            url:'matching-catalog-1c',
            data:{'cat_1c_product_id': id},
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type:'POST',
            datatype:'html',
            success: function(html) {

                $('.content_1c_catalog').html(html);

            }


        });
    })

    /* 1c   catalog menu*/






})








