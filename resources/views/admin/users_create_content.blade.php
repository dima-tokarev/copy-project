<div class="container">
    <h4>Добавление нового пользователя</h4>
<form action="{{route('users.store')}}" method="post" >
    @csrf
    <div class="form-group">
        <label for="exampleFormControlInput2">Введите имя</label>
        <input type="text" class="form-control" name="name" id="exampleFormControlInput2" placeholder="Введите имя">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput3">Введите пароль</label>
        <input type="password" name="password" class="form-control" id="exampleFormControlInput3" placeholder="Введите пароль">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput4">Введите еще раз пароль</label>
        <input type="password" name="password_confirmation" class="form-control" id="exampleFormControlInput4" placeholder="Подтверждение пароля">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Email адрес</label>
        <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com">
    </div>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Вырать роль пользователя</label>
        <select class="form-control" id="exampleFormControlSelect1">
            <option>Администратор</option>
            <option>Менеджер</option>
            <option>Автор</option>

        </select>
    </div>
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
    <div class="btn-toolbar">
       <button class="btn btn-info">Добавить пользователя</button>
        {{--  <button class="btn">Import</button>
          <button class="btn">Export</button>--}}
    </div>
</form>
</div>
