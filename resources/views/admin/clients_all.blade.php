<div class="container">
    <div class="col-12">
        @if($message = Session::get('success'))
            <div class="alert alert-success">
                <p> {{ $message }} </p>
            </div>
            <br>
        @endif

            @canany(['edit_attr_admin'])
                <div class="row">

                    <div class="col-4"><a href="{{route('clients.create')}}" class="btn btn-info">Добавить клиента</a></div>

                </div>
                <br>
            @endcanany
        <form action="{{route('search_name')}}" method="post">
            <input style="width: 93%;float: left;margin-right: 5px;" class="form-control" type="text" name="search" placeholder="Поиск по названию">
            @csrf
            <button type="submit" class="btn btn-info">Найти</button>
        </form>
        <table  class="table">

            <br>
            @if($clients)
                <thead>
                <tr id="head_work">

                    <th scope="col">№</th>
                    <th scope="col">Название</th>

                    <th scope="col"><span style="float: left">Действие</span>
                        <div class="select_row"><select style="width: 19px"  id="select_row_filter" name="select_row_filter" >

                            </select></div></th>

                </tr>
                </thead>
                <tbody >

                @foreach($clients as $client)
                    <tr >

                        <td style="width: 6%">{{$client->id}}</td>

                        <td style="width: 80%">{{--<a href="{{route('clients.show',$client->id)}}">--}}{{$client->name}}{{--</a>--}}</td>

                        <td style="width: 10%;text-align: right;">

                            @canany(['edit_attr_admin', 'edit_attr_leader'])
                                <div style="margin-left: 0px" class="row">
                                    <div style="width: 25px;" class="cols-1">
                                        <a class="fa fa-pencil-square-o" style="color: #2fa360" href="{{route('clients.edit',$client->id)}}"></a> /

                                    </div>
                                    <div style="width: 25px;" class="cols-1">
                                        <form id="delete-form" action="{{route('clients.destroy',$client->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button id="delete-confirm" data-id="{{$client->id}}" style="margin-top: -4px;color:indianred"  class="btn btn-link fa fa-trash-o"></button>
                                        </form>
                                    </div>
                                </div>
                            @endcanany
                        </td>

                    </tr>
                @endforeach

                @else
                    <tr>
                        <th colspan="4" scope="row">Работы не найдены</th>
                    </tr>
                </tbody>
            @endif

        </table>

    </div>
    @canany(['edit_attr_admin'])
        <div class="row">
            <div class="col-10">{{$clients->links()}}</div>
        </div>
    @endcanany
</div>
