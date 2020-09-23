<div class="container">
    <h5 align="left">Блок атрибутов - {{$block_name->name}}</h5>
    <br/>

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
        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Название атрибута</th>
                    <th>Тип атрибута</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if($block_attr)
                    @foreach($block_attr as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>
                                @if($item->type == 'list')
                                        <span>Список</span>
                                @elseif($item->type == 'text')
                                    <span>Текстовое поле</span>
                                @elseif($item->type == 'upload')
                                    <span>Поле загрузки файла</span>
                                @endif
                            </td>
                            <td align="center"><a href="#">Редактировать</a></td>
                            <td align="center"><form action="{{route('del_attribute')}}" method="post">
                                    <input type="hidden" name="cat_attr_id" value="{{$block_name->id}}">
                                    <input type="hidden" name="attr_name" value="{{$item->name}}">
                                    @csrf
                                    <button onclick="return confirm('Удалить атрибут?')" aria-hidden="true" class="btn btn-danger">Удалить</button>
                                </form></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>

        </div>
    </div>
    <div class="row">
        <div class="col-10"></div>
        <div class="col-2"> <a href="{{route('add_attribute',$block_name->id)}}"  class="btn btn-info">Добавить атрибут</a></div>
    </div>
</div>