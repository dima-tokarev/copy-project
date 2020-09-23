
<div class="container">
    <div class="row">
        <div  class="col-11">
            @if($message = Session::get('success'))
                <div class="alert alert-success">
                    <p> {{ $message }} </p>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-10">
            <h4 style="color: black">{{$product->name}}</h4>
        </div>
        <div align="right" class="col-2">
        {{--    <form action="{{route('matching_product')}}" method="post">
                <input type="hidden" name="id" value="{{$product->id}}">
                @csrf
                <button type="submit" class="btn btn-info">Сопоставить с 1с</button>
            </form>--}}

        </div>
    </div>
    <div style="margin-top: 20px" class="row">

        <br>
        <div  class="col-5">

            <div class="slider-pro" id="my-slider">
                <div class="sp-slides">

                    @if($product_img)
                        @foreach($product_img as $img)

                            <div class="sp-slide">
                                <a href="{{asset('/storage/app/public/'.$img->path)}}" rel="lightbox" > <img class="sp-image" src="path/to/blank.gif" data-src="{{asset('/storage/app/public/'.$img->path)}}"/></a>
                            </div>
                        @endforeach
                </div>
                <div  class="sp-thumbnails">
                    @foreach($product_img as $img)

                        <img class="sp-thumbnail" rel="lightbox[roadtrip]" src="path/to/blank.gif" data-src="{{asset('/storage/app/public/'.$img->path)}}"/>
                    @endforeach
                </div>
                @endif
            </div>


        </div>

        <div  class="col-7">


            <div class="col-12">
                <form action="{{route('upd_product')}}" method="post" enctype="multipart/form-data">
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
                                <td><input class="form-control" type="text" name="name" placeholder="Введите название продукта" value="{{$product->name}}"></td>
                            </tr>
                            @if(isset($cat))
                                @foreach($cat as $val)
                                    <tr>
                                        <td colspan="2"><h4 style="color:black">{{$val->name}}</h4></td>

                                    </tr>
                                    @foreach($val->typeOption as $item)
                                        <tr>
                                            <td style="width: 50%">{{$item->name}}</td>
                                            <td style="width: 50%">
                                                @if(count($item->optionType) > 0)
                                                    <select name="select_option[{{$val->id}}][{{$item->name}}]" class="form-control">
                                                        @if(isset(\App\ProductSelectOption::where('type_option_value',$item->name)->where('product_id',$product_id)->first()->value_option))
                                                        <option selected>{{\App\ProductSelectOption::where('type_option_value',$item->name)->where('product_id',$product_id)->first()->value_option}}</option>
                                                        @else
                                                            <option selected>Выбрать значение</option>
                                                        @endif
                                                            @foreach($item->optionType as $opt)
                                                            @isset(\App\ProductSelectOption::where('type_option_value',$item->name)->where('product_id',$product_id)->first()->value_option)
                                                             @if(\App\ProductSelectOption::where('type_option_value',$item->name)->where('product_id',$product_id)->first()->value_option != $opt->value_option)
                                                            <option value="{{$opt->value_option}}">{{$opt->value_option}}</option>
                                                            @endisset
                                                           @endif
                                                        @endforeach
                                                    </select>
                                                @else
                                                    @if(isset(\App\ProductSelectOption::where('type_option_value',$item->name)->where('product_id',$product_id)->first()->value_option))
                                                    <input type="text" class="form-control" name="select_option[{{$val->id}}][{{$item->name}}]" value="{{\App\ProductSelectOption::where('type_option_value',$item->name)->where('product_id',$product_id)->first()->value_option}}">
                                                    @else
                                                        <input type="text" class="form-control" name="select_option[{{$val->id}}][{{$item->name}}]" value="">
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
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

                                    <input type='hidden' name='product_id' value='{{$product_id}}'>
                                    <input type='hidden' name='series_id' value='{{$series_id}}'>

                                    @csrf
                                    <input type="submit" class="btn btn-info" value="Сохранить">
                                </td>
                            </tr>
                            </tbody>








                </table><br/>
                </form>
            </div>
            <div class="row">
                <div class="col-8"></div>
                <div align="right" class="col-4">          {{-- <button class="btn btn-info">Добавить в корзину</button><--}}</div>
            </div>
        </div>




    </div>

</div>
</div>

<script>
    jQuery( document ).ready(function( $ ) {
        $( '#my-slider' ).sliderPro();
    });
</script>
