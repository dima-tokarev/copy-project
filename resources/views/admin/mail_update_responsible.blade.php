<div class="container">
    <div class="row">
        <div class="col-10">

            <br/> <br/>

            <p><b>Название: </b> {{$prework->name}} <b>#{{$id}}</b></p>
            <p><b>Ответственный пользователь изменен на:</b> {{$author->name}}</p>
            <p>Для просмотра информации пройдите по ссылке<a href="{{asset('admin/preworks/'.$id)}}"> ссылка</a> </p>
        </div>
    </div>
</div>