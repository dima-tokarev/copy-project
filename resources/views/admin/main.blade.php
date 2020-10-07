
<<<<<<< HEAD
    <div id="catalog" data='{{$catalog}}'></div>
=======
        <div style="border: 1px solid #ccc;border-radius: 10px;" class="col-4">
            <br>

            {{--<input class="form-control" style="width: 100%" type="text" name="search" placeholder="Поиск"><br>--}}
           <div align="right">
            @foreach($views as $view)

            <a href="{{route('catalog_index',['id' => $view->id])}}">{{$view->name}}</a> /
            @endforeach
           </div>
            <div class="col-12">

            </div>
            @include('admin.menu_catalog')
        </div>
        <div  style="border: 1px solid #ccc;border-radius: 10px;padding-bottom: 24px" class="col-8">
            <div class="container-fluid">

                <div class="row">
                    <div  class="col-lg-12 col- md-12 col-sm-12">
                        <div id="content_catalog" class="row">

                        <h5 align="center" style="padding: 20px;">Выберите категорию</h5>


                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>

</div>
>>>>>>> 3d9391b20c20d20076df558e8ce3a7470262c232
