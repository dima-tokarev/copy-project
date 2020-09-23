<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="modal-dialog" role="document">
                <div style="border: none" class="modal-content">

                    <div  class="row">
                        <div  class="col-7">     <h5 class="modal-title" id="exampleModalLongTitle"><b>Каталог</b></h5></div>

                        {{--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>--}}

                        <div  class="col-5">
                            <div class="form-group" style="color: darkred;margin-left: 5%;font-size: 14px"></div>
                        </div>

                    </div>
                    <div class="modal-body">

                        <div class="form-group">

                            @include('admin.menu_catalog_1c')

                            <div style="border: none" class="modal-footer">






                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
        <div class="modal-dialog" role="document">    <div class="row">
                <div  class="col-12">
                    @if($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p> {{ $message }} </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="modal-content">


                    <div style="padding: 16px;" class="row">
                        <div class="col-12">     <h5 class="modal-title" id="exampleModalLongTitle">Сопоставление карточки - <b>"{{$product->name}}"</b> <b style="color: red"></b></h5></div>

                        {{--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>--}}

                    {{--    <div  class="col-2">
                            <div class="form-group" style="color: darkred;margin-left: 5%;font-size: 14px"></div>
                        </div>--}}

                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                     {{--      <div class="row">
                                <div class="col-8">
                                    <input class="form-control" name="search" placeholder="поиск">
                                </div>
                                <div class="col-4">
                                    <select class="form-control">
                                        <option>Фильтры</option>
                                    </select>
                                </div>
                           </div>--}}
                            <br/>
                            <table class="table content_1c_catalog">
                                <thead>
                                    <th>Название</th>
                                    <th>Код 1с</th>
                                    <td align="center"><b>Выбрать</b></td>
                                </thead>
                                <tbody >
                                    @if(count($products) > 0)
                                        @foreach($products as $product)
                                        <tr>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->code_1c}}</td>
                                            <td align="center">
                                                <input type="checkbox" onclick="add_item(this)" data-name="{{$product->name}}" data-1c="{{$product->code_1c}}" id="product_{{$product->id}}"  data-id="{{$product->id}}" name="product"></td>
                                        </tr>
                                            <script>
                                              $(document).ready(function () {

                                                  if($("#select_{{$product->id}}").length) {
                                                      $('#product_{{$product->id}}').prop('checked', true);
                                                  }
                                              })

                                            </script>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                           {{-- {{$products->links()}}--}}

                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Выбранные карточки</a>
                                        </li>

                                    </ul>
                                    <form action="{{route('matching_store')}}" method="post">
                                    <div class="row">
                                        <div style="padding: 20px;"  class="col-4"><b>Название</b></div>
                                        <div style="padding: 20px;"  class="col-4"><b>Основная</b></div>
                                        <div style="padding: 20px;"  class="col-4"></div>
                                    </div>
                                    <div class="tab-content" id="myTabContent">

                                        <div  class="tab-pane fade show active myTabContent" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            @if(count($matching_products) > 0)
                                                @foreach($matching_products as $matching)
                                                    <div id='select_row_{{$matching->p_1c->id}}' class='row'>
                                                        <div class='col-4'>
                                                            <input name='select_product[{{$matching->p_1c->id}}][{{$matching->p_1c->code_1c}}]'  class='form-control' id='select_{{$matching->p_1c->id}}' type='text'  value='{{$matching->p_1c->name}}'>
                                                        </div>
                                                        <div align="center" class="col-2">
                                                            @if($matching->is_base == null)
                                                            <input type='radio' id='radio_{{$matching->p_1c->id}}' value="{{$matching->p_1c->id}}" name='main'>
                                                            @else
                                                                <input type='radio' id='radio_{{$matching->p_1c->id}}' value="{{$matching->p_1c->id}}" checked  name='main'>
                                                            @endif
                                                        </div>
                                                        <div class='col-2'><a  data-remove-id='{{$matching->p_1c->id}}' class='remove' href='javascript:void(0)'>Убрать</a>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            @endif
                                        </div>


                                    </div>
                                        <div align="right">
                                            <br>
                                            <button type="submit"  class="btn btn-info" >Сохранить</button>
                                        </div>
                                        <input type="hidden" name="product_id" value="{{$product_id}}">
                                        @csrf
                                    </form>


                                </div>
                            </div>

                            <div style="border: none" class="modal-footer">




                               {{-- <button id="add_work"  type="submit" class="btn btn-primary">Добавить</button>--}}

                            </div>


                     </div>

                </div>
            </div>
        </div>

        <script>
            function add_item(val) {



                let id = $(val).attr('data-id');
                let name = $(val).attr('data-name');
                let code = $(val).attr('data-1c');
                console.log(code);


                if ($(val).is(':checked')){
                    $('.myTabContent').append("" +
                        "<div id='select_row_"+id+"' class='row'>" +
                        "<div class='col-4'>" +
                        "<input name='select_product["+id+"]["+code+"]' class='form-control' id='select_"+id+"' type='text'  value='" + name + "'>" +
                        "</div>" +
                        "<div align='center' class='col-2'><input type='radio' id='radio_"+id+"' name='main' value='"+id+"'></div>" +
                        "<div class='col-2'> " +
                        "<a  data-remove-id='"+id+"' class='remove' href='javascript:void(0)'>Убрать</a>" +
                        "</div>" +
                        "</div>");
                    $('#del_input_'+id).remove();
                } else {
                    $('#select_row_'+id).remove();
                    $('#select_'+id).remove();

                    $('.myTabContent').append("<input id='del_input_"+id+"' type='hidden' name='del_id[]' value='"+id+"'>");
                }




            }

            $('html').on('click','.remove',function () {

                let id =  $(this).attr('data-remove-id');
                $('.myTabContent').append("<input id='del_input_"+id+"' type='hidden' name='del_id[]' value='"+id+"'>");
                $('#product_'+id).prop('checked', false);
                $('#select_row_'+id).remove();
            })

        </script>
        </div>
    </div>
</div>

