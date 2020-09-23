<div class="container">
    <h5>Назначение блоков для категории</h5>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Названине
                        </th>
                        <th>
                            Настройка блоков
                        </th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($cat_block))
                    @foreach($cat_block as $cat)
                    <tr>
                        <td>
                          {{$cat->name}}
                        </td>
                        <td>
                          <a href="{{route('cat_block_show',$cat->id)}}">Назначить</a>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>