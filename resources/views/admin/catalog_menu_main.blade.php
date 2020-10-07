
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
        <div style="margin-bottom: 10px" class="col-4"> <h5 style="color: gray">Настройка меню "Каталог"</h5></div>
        <div style="margin-bottom: 10px;" class="col-6"><h5 style="color: gray">Карточки товаров</h5></div>
    </div>

    <div class="row">

    <div style="border: 1px solid #ccc;border-radius: 10px;" class="col-4">

        <div style="margin-top: 10px" align="right">
            @foreach($views as $view)

                <a href="{{route('catalog_menu',['id' => $view->id])}}">{{$view->name}}</a> /
            @endforeach
        </div>

        <form style="margin-top: 10px" action="{{route('store_cat')}}" method="post">
            <input style="width: 70%;float:left" class="form-control" type="text" name="name" placeholder="Добавить корневую категорию">
            <input type="hidden" name="view_id" value="{{$view_id}}">
            <input type="hidden" name="main_cat" value="1">
            @csrf
            <button style="margin-left: 2px" type="submit" class="btn btn-info">Добавить</button>
        </form>
        <!-- Left Side Of Navbar -->
        <ul  >
            @php
                function buildMenu($items, $parent)
                {
                    foreach ($items as $item) {

                        if (isset($item->children)) {

            @endphp
            <li style="padding: 5px" >
                <span id="hasSub-{{ $item->id }}">
                    <a class="select_cat_product" data-id-cat="{{ $item->id }}" view-id="{{$item->view_id}}" href="javascript:void(0)"> {{ $item->name }}</a>
                </span>
                @if($item->type == 'cat')

                    <i data-id="{{ $item->id }}" view-id="{{$item->view_id}}" style="margin-left: 5px;color: green" class="fa fa-plus add_catalog"  data-toggle="modal" data-target="#exampleModal" aria-hidden="true"></i>

                    <span data-id="{{ $item->id }}" style="margin-left: 5px;color: blue" view-id="{{$item->view_id}}" class="add_series"  data-toggle="modal" data-target="#exampleModal2" aria-hidden="true"><b>C</b></span>

                    <form action="/admin/catalog-delete-cat" method="post" style="display:  inline-flex">
                    <input type="hidden" name="del_cat" value="{{ $item->id }}">
                    <button type="submit" data-id="{{ $item->id }}" style="color: red" onclick="return confirm('Удалить категорию?')" class="fa fa-times delete-menu-catalog btn btn-link" aria-hidden="true"></button>
                    @csrf

                </form>
                @else

                    <i data-id="{{ $item->id }}" style="margin-left: 5px;color: green" class="fa fa-plus add_product" aria-hidden="true"></i>

                    <span data-id="{{ $item->id }}" style="margin-left: 10px;color: blue" view-id="{{$item->view_id}}" class="add_series"  data-toggle="modal" data-target="#exampleModal2" aria-hidden="true"><b>C</b></span>
                    <form action="/admin/catalog-delete-series" method="post" style="display:  inline-flex">
                        <input type="hidden" name="del_cat" value="{{ $item->id }}">
                        <button type="submit" data-id="{{ $item->id }}" style="color: red" onclick="return confirm('Удалить Серию?')" class="fa fa-times delete-menu-catalog btn btn-link" aria-hidden="true"></button>
                        @csrf

                    </form>

                @endif
                <ul style="margin-left: -25px;" id="subnav-{{ $item->id }}">
                    @php  buildMenu($item->children, 'subnav-'.$item->id) @endphp
                </ul>
            </li>
            @php
                } else {
            @endphp
            <li class="last-li" style="margin-top: 10px;">


                <a class="select_cat_product" view-id="{{$item->view_id}}" data-id-cat="{{ $item->id }}" href="javascript:void(0)"> {{ $item->name }}</a>

                @if($item->type == 'cat')
                <i data-id="{{ $item->id }}" style="margin-left: 5px;color: green" class="fa fa-plus add_catalog"  data-toggle="modal" data-target="#exampleModal" aria-hidden="true"></i>


                <span data-id="{{ $item->id }}" style="margin-left: 10px;color: blue" view-id="{{$item->view_id}}" class="add_series"  data-toggle="modal" data-target="#exampleModal2" aria-hidden="true"><b>C</b></span>

                    <form action="/admin/catalog-delete-cat" method="post" style="display:  inline-flex">
                    <input type="hidden" name="del_cat" value="{{ $item->id }}">
                        <input type="hidden" name="view_id" value="{{$item->view_id}}">
                    <button  data-id="{{ $item->id }}" style="color: red" onclick="return confirm('Удалить категорию?')" class="fa fa-times delete-menu-catalog btn btn-link" aria-hidden="true"></button>
                    @csrf
                </form>
                @else

                    @if($item->view_id == 1)
                    <a href="{{route('add_product',$item->id)}}"> <i data-id="{{ $item->id }}" style="margin-left: 5px;color: green" class="fa fa-plus add_product" aria-hidden="true"></i></a>
                    @else
                        <a href="javascript:void(0)"> <i data-id="{{ $item->id }}" style="margin-left: 5px;color: green" class="fa fa-plus add_product" data-toggle="modal" data-target="#exampleModal3" aria-hidden="true"></i></a>
                    @endif

                    <form action="/admin/catalog-delete-series" method="post" style="display:  inline-flex">
                        <input type="hidden" name="del_cat" value="{{ $item->id }}">
                        <input type="hidden" name="view_id" value="{{$item->view_id}}">
                        <button  data-id="{{ $item->id }}" style="color: red" onclick="return confirm('Удалить серию?')" class="fa fa-times delete-menu-catalog btn btn-link" aria-hidden="true"></button>
                        @csrf
                    </form>
                @endif
            </li>
            @php
                }
            }
        }

        buildMenu($menuitems, 'mainMenu')
            @endphp
        </ul>

    </div>
    <div id="content_catalog" style="border: 1px solid #ccc;border-radius: 10px" class="col-8">
        <br>
            @if(isset($products))
            <div class="container-fluid">   <div class="row">
                    <div  class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row">

                            @foreach ($products as $product)
                            @if(isset($product->productImg->first()->path))
                             @php $img = $product->productImg->first()->path; @endphp
                            @else
                             @php $img = '123.jpg'; @endphp
                            @endif


                            <!--1rd card-->
                            <div style="padding-top: 24px;" class="col=lg-4 col-md-4 order-md-3">
                                <div class="container block rounded-lg rounded-sm">
                                    <!--1st row--->
                                    <div class="row">

                                        <div class="col-lg-12 col-md-12 col-sm-12 img-catalog">
                                            <a href="{{route('show_product',$product->id)}}"><img  src="{{asset('/storage/app/public/'.$img)}}" alt="placeholder image"/></a>

                                        </div>
                                    </div>
                                    <!--2nd row--->
                                    <div class="row" >
                                        <div class="col-lg-12 col-md-12 col-sm-12 block2">
                                            <p><h6 style="color: #fff" class="mb-3">{{$product->name}}</h6></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


            @endforeach




                        </div>
                    </div>
                    <div style="margin: 20px">
                         {{ $products->links() }}
                    </div>
                    @endif
            </div>
        </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление категории</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('store_cat',$view_id)}}" method="post">
            <div class="modal-body">

                   <input class="form-control" name="name_cat" placeholder="Введите название категории">



            </div>
            <div class="f-cat"></div>
            <div class="modal-footer">
                @csrf
                <input type="hidden" name="type" value="cat">
                <input type="hidden" name="view_id" value="{{$view_id}}">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Добавить</button>

            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление серии</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('store_cat',$view_id)}}" method="post">
            <div class="modal-body">
                <input class="form-control" name="name_cat" placeholder="Введите название серии">
            </div>
            <div class="f-ser"></div>
            <div class="modal-footer">
                @csrf
                <input type="hidden" name="type" value="series">
                <input type="hidden" name="view_id" value="{{$view_id}}">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Копирование Продуктов</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('store_cat',$view_id)}}" method="post">
                <div class="modal-body">
                    <input class="form-control" name="name_cat" placeholder="Введите название серии">
                </div>
                <div class="f-ser"></div>
                <div class="modal-footer">
                    @csrf
                    <input type="hidden" name="type" value="series">
                    <input type="hidden" name="view_id" value="{{$view_id}}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>