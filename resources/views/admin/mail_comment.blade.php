<div class="container">
    <div class="row">
        <div class="col-10">

            <br/> <br/>
            <p><b>Добавил пользователь:</b> {{$author}}</p>
            <p><b>Название:</b> {{$pre_work->name}} <b>#{{$id}}</b></p>
            <p>Для просмотра информации пройдите по ссылке<a href="{{asset('admin/preworks/'.$id)}}"> ссылка</a> </p>
        </div>
    </div>
</div>