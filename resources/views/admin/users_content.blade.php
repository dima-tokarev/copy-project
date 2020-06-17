<div class="container">

<div class="btn-toolbar">
    <a href="{{route('users.create')}}"> <button class="btn btn-primary">Добавить пользователя</button></a>
  {{--  <button class="btn">Import</button>
    <button class="btn">Export</button>--}}
</div>
    <br>
<div class="well">
    <table class="table">
        <thead>


        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>Email</th>
          {{--  <th style="width: 36px;"></th>--}}
        </tr>
        </thead>
        <tbody>
        @if($users)


            @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
        </tr>
        @endforeach
        </tbody>
        @endif
    </table>
</div>
</div>


{{--

                @if($users)


                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><a href="--}}
{{--{!! route('admin.users.edit',['users' => $user->id]),$user->name !!}--}}{{--
">{{$user->name}}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->login }}</td>
                            <td>--}}
{{--{{ $user->roles->implode('name', ', ') }}--}}{{--
</td>


                            <td>
                          --}}
{{--      {!! Form::open(['url' => route('admin.users.destroy',['users'=> $user->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
                                {{ method_field('DELETE') }}
                                {!! Form::button('Удалить', ['class' => 'btn btn-french-5','type'=>'submit']) !!}
                                {!! Form::close() !!}--}}{{--


                            </td>
                        </tr>
                    @endforeach

                @endif
            </table>
        </div>
    --}}
{{--    {!! Html::link(route('admin.users.create'),'Добавить  пользователя',['class' => 'btn btn-the-salmon-dance-3']) !!}
--}}{{--


--}}
