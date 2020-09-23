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

    <h5 align="left">Блок категорий атрибутов</h5>
    <br/>


    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Название блока</th>
                        <th>Привязан к категории</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if($block_attr)
                   @foreach($block_attr as $item)
                    <tr>
                          <td><a href="{{route('block_attribute_show',$item->id)}}">{{$item->name}}</a> </td>
                          <td>Название категории</td>
                        <td><form action="#" method="post">
                                <input hidden="type" name="bock_id" value="{{$item->id}}">
                                <button onclick="return confirm('Удалить блок?')" aria-hidden="true" class="btn btn-danger">Удалить</button>
                            </form>
                        </td>
                      </tr>
                   @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-6"></div>
        <div align="right" class="col-6"><a href="{{route('add_block')}}" class="btn btn-info">Добавить блок</a></div>
    </div>
</div>