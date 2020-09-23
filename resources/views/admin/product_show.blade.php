
<div class="container">
    <div class="row">
        <div  class="col-12">
            @if($message = Session::get('success'))
                <div class="alert alert-success">
                    <p> {{ $message }} </p>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="row">
                <div class="col-8">
                    <h4 style="color: black">{{$product->name}}</h4>
                </div>
                <div class="col-4">
                    <a style="margin-left: -15px;" class="fa fa-pencil-square-o" aria-hidden="true" href="{{route('edit_product',$product->id)}}" >Редактировать</a>
                </div>

            </div>

        </div>
        <div align="right" class="col-4">
            <form action="{{route('matching_product')}}" method="post">
                <input type="hidden" name="id" value="{{$product->id}}">
                @csrf
                <button type="submit" class="btn btn-info">Сопоставить с 1с</button>

            </form>

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
                        <table class="table table-hover">



                            <thead>
                            {{--     <tr>
                                     <th>Наименование</th>
                                     <th>Значение</th>
                                 </tr>--}}
                            </thead>
                            <tbody>
                     {{--       <tr>
                                <td>Название продукта</td>
                                <td><input class="form-control" type="text" name="name" placeholder="Введите название продукта"></td>
                            </tr>--}}
                            @if(isset($product_opt))
                                <div class="row">
                                @foreach($product_opt as $index => $val)

                                    <tr>
                                        <td colspan="2"><h4 style="color: black">{{\App\ProductCatOption::find($index)->name}}</h4></td>

                                    </tr>
                                   @foreach($val as $item)

                                        <tr>
                                            <td><b>{{$item->type_option_value}}</b></td>
                                            <td>
                                                <span>{{$item->value_option}}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif

                            </tbody>




                        </table><br/>
                    </div>
                <div class="row">
                    <div class="col-8"></div>
                    <div align="right" class="col-4">           <button class="btn btn-info">Добавить в корзину</button></div>
                </div>
                </div>


                </form>


            </div>

    </div>
</div>

<script>
    jQuery( document ).ready(function( $ ) {
        $( '#my-slider' ).sliderPro();
    });
</script>
