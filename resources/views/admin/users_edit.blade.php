<div class="container">
    <div class="row">
        <div class="col-2"></div>
                <div class="col-8">
                <h4>Редактирование профиля</h4>
                <form action="{{route('user_update',$user->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput2">Введите имя</label>
                        <input type="text" class="form-control" name="name" id="exampleFormControlInput2" placeholder="Введите имя" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput3">Введите пароль</label>
                        <input type="password" name="password" class="form-control" id="exampleFormControlInput3" placeholder="Введите пароль" >
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput4">Введите еще раз пароль</label>
                        <input type="password" name="password_confirmation" class="form-control" id="exampleFormControlInput4" placeholder="Подтверждение пароля">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Email адрес</label>
                        <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com" value="{{$user->email}}">
                    </div>
                    @canany(['edit_attr_admin'])
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Вырать роль пользователя</label>
                        <select name="role" class="form-control" id="exampleFormControlSelect1">
                            <option selected disabled value="{{$user->roles->first()->id}}">{{$user->roles->first()->name}}</option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endcanany
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Аватарка:</label><br>
                        @isset($avatar)

                            <img width="100" height="100" src="{{asset('/storage/'.$avatar->path)}}"> <br><br>
                        @endisset

                        <input type="file"  name="avatar" id="exampleFormControlInput1">
                    </div>
                {{--    <div class="form-group">
                        <label for="exampleFormControlSelect1">Вырать роль пользователя</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>Администратор</option>
                            <option>Менеджер</option>
                            <option>Автор</option>

                        </select>
                    </div>--}}
                    {{--    <div class="form-group">
                            <label for="exampleFormControlSelect2">Example multiple select</label>
                            <select multiple class="form-control" id="exampleFormControlSelect2">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>--}}
                    {{--   <div class="form-group">
                           <label for="exampleFormControlTextarea1">Example textarea</label>
                           <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                       </div>--}}
                    <div align="right" >
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <button class="btn btn-info">Сохранить</button>
                        {{--  <button class="btn">Import</button>
                          <button class="btn">Export</button>--}}
                    </div>
                </form>
                 </div>

    <div class="col-2"></div>
    </div>
</div>

