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
    <h5>Назначение блоков для категории - <b>{{$catalog->name}}</b></h5>
    <br>
    <form action="{{route('store_cat_block')}}" method="post">
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        Названине
                    </th>
                    <th>
                        Назначить
                    </th>
                    <th>
                        Сортировка
                    </th>
                </tr>
                </thead>
                <tbody>
                @if(isset($blocks))

                    @foreach($blocks as $block)
                        <tr>
                            <td>
                                {{$block->name}}
                            </td>
                            <th>

                                @if($block->id == $catalog->blocks->contains('id',$block->id))
                                <input checked type="checkbox" name="{{$catalog->id}}[{{$block->id}}]" value="{{$block->id}}">
                                @else
                                    <input  type="checkbox" name="{{$catalog->id}}[{{$block->id}}]" value="{{$block->id}}">
                                @endif

                            </th>

                           @if(\App\CatBlock::where('product_cat_option_id',$block->id)->where('catalog_id',$catalog->id)->first())
                            <th style="width: 10%"><input class="form-control" type="number" name="sort[{{$block->id}}]" value="{{\App\CatBlock::where('product_cat_option_id',$block->id)->where('catalog_id',$catalog->id)->first()->sort}}"></th>
                           @else
                                <th style="width: 10%"><input class="form-control" type="number" name="sort[{{$block->id}}]" value=""></th>
                            @endif
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-10"></div>
        <div class="col-2">
            @csrf
            <input type="hidden" name="cat_id" value="{{$catalog->id}}">
            <button type="submit" class="btn btn-info">Обновить</button>
        </div>
    </div>
    </form>
</div>