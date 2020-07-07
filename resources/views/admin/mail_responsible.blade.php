<div class="container">
    <div class="row">
        <div class="col-10">

            <br/> <br/>


            <p> <b>Название: </b>{{$title}} <b> #{{$id}}</b></p>
            <p> <b>Пользователь: </b>{{$author->name}}</p>
            <p>Для просмотра информации пройдите по ссылке<a href="{{asset('admin/preworks/'.$id)}}"> ссылка</a> </p>
        </div>
    </div>
</div>