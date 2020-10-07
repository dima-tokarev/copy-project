<div class="container">
    <div class="row">
        <div class="col-2"></div>
        <div  style="border: 1px solid #ccc;border-radius: 10px;padding-bottom: 24px" class="col-8">
            <br/><h4 style="color: black;margin-left: 12px;">Добавление продукта:</h4><br/>
            <div class="container-fluid">

                <div class="row">
                    <div  class="col-lg-12 col- md-12 col-sm-12">
                        @if(count($cat) > 0)
                        <div id="content_catalog" class="row">
                            <form action="{{route('store_product')}}" method="post" enctype="multipart/form-data">
                            <table class="table table-hover">



                                        <thead>
                                   {{--     <tr>
                                            <th>Наименование</th>
                                            <th>Значение</th>
                                        </tr>--}}
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Название продукта</td>
                                            <td><input class="form-control" type="text" name="name" placeholder="Введите название продукта"></td>
                                        </tr>

                                         @foreach($cat as $val)
                                            <tr>
                                                <td><h4 style="color: black">{{$val->name}}</h4></td>
                                                <td></td>
                                            </tr>
                                            @foreach($val->typeOption as $item)
                                                <tr>
                                                    <td>{{$item->name}}</td>
                                                    <td>
                                                        @if(count($item->optionType) > 0)
                                                           <select name="select_option[{{$val->id}}][{{$item->name}}]" class="form-control">
                                                              @foreach($item->optionType as $opt)
                                                              <option value="{{$opt->value_option}}">{{$opt->value_option}}</option>
                                                              @endforeach
                                                           </select>
                                                        @else
                                                            <input type="text" class="form-control" name="select_option[{{$val->id}}][{{$item->name}}]" value="">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                         @endforeach

                                        <tr>
                                            <td>
                                                <label><b>Добавить фото</b></label><br/>
                                                <input type="file" name="file_img[]" multiple></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                            </td>
                                            <td align="right">
                                                <input type="submit" class="btn btn-info" value="Добавить">
                                            </td>
                                        </tr>
                                        </tbody>



                                <input type='hidden' name='view_id' value='{{$view_id}}'>
                                        <input type='hidden' name='series_id' value='{{$series_id}}'>

                                    @csrf




                        </table><br/>

                            </form>
                        </div>

                    </div>
                    @else
                        <h5>У данной категории не назначены блоки атрибутов: <a href="{{route('cat_block_show',$series_id)}}">Перейти</a> </h5>
                    @endif

                </div>



            </div>
        </div>
        <div class="col-2"></div>
    </div>

</div>



