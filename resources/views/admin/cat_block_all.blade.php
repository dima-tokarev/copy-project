<div class="container">
    <div class="row">
        <div  class="col-12">
            <h5>Выберите каталог</h5>
            {{--  @include('admin.catalog_block_menu')--}}
            <table class="table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Перейти</th>
                </tr>
                <tbody>
                @foreach($catalogs as $catalog)
                    <tr>
                        <td>
                            {{$catalog->name}}
                        </td>
                        <td>
                            <a href="{{route('show_catalog',$catalog->id)}}">Перейти</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </thead>
            </table>
        </div>
    </div>
</div>



