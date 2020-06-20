<div class="container">
<h4>Список работ:</h4>
    <br>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Название</th>
        <th scope="col">Автор</th>
        <th scope="col">Статус</th>
        <th scope="col">Дата</th>
    </tr>
    </thead>
    <tbody>

   @if($pre_works)
       @foreach($pre_works as $pre_work)
            <tr>
                <th scope="row">{{$pre_work->number}}</th>
                <td>{{$pre_work->name}}</td>
                <td>{{$pre_work->author->name}}</td>
                <td>{{$pre_work->status_id}}</td>
                <td>{{$pre_work->create_at}}</td>
            </tr>
        @endforeach
   @else
       <tr>
           <th colspan="4" scope="row">Работы не найдены</th>
       </tr>

   @endif
    </tbody>
</table>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
    Добавить работу
</button>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form  action="{{route('preworks.store')}}" method="post" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Предварительные работы #</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <h5 align="left">Название</h5>

                        <div class="form-group">

                        <label for="exampleFormControlInput1"></label>
                        <input type="text" class="form-control" name="name_prework" id="exampleFormControlInput1" placeholder="Введите название">
                    </div>

                    <br/>
                    <h4 align="center">Основные атрибуты</h4>
                    <br/>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Наименование</th>
                            <th scope="col">Значение</th>

                        </tr>
                        </thead>
                        <tbody>
                        @if($attributes)
                            @foreach ($attributes as $attribute)
                                @if($attribute->attr_type_id == 0)
                                    <tr>
                                        <th scope="row">{{$attribute->id}}</th>
                                        <td>{{$attribute->attr_name}}</td>
                                        <td>
                                            <input type="text" name="attr_simple[]" class="form-control" size="20" placeholder="Введите значение">
                                        </td>

                                    </tr>
                                @endif
                            @endforeach

                            @foreach ($attributes as $attribute)
                                @if($attribute->attr_type_id != 0)
                                    <tr>
                                        <th scope="row">{{$attribute->id}}</th>
                                        <td>{{$attribute->attr_name}}</td>
                                        <td>
                                            <input style="float:left" type="text" id="client" name="attr_custom[]"  class="form-control" size="20" value="" placeholder="Выберите клиента">

                                            <button style="margin-left:1px" id="elem" class="btn btn-primary" type="button" class_select="{{App\ObjectType::where('id',$attribute->attr_type_id)->first()->name}}" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </button>



                                            <br>
                                            <div style="clear: both" class="collapse" id="collapseExample">

                                                <div class="card card-body">

                                                    <select id="att_val" name="att_val">

                                                    </select>
                                                    <div>
                                                        <a style="float:left"   align="left" href="#">Добавить</a>/<a align="right" href="#" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Закрыть</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <th scope="row">&nbsp;</th>
                                <th scope="row">&nbsp;</th>
                                <th colspan="2">Атрибутов не найдено</th>
                                <th scope="row">&nbsp;</th>

                            </tr>
                        @endif
                        </tbody>
                    </table>


                    <h4>Описание</h4>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Краткое описание</label>
                        <textarea class="form-control" name="desc_prework" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>

                    <br/>
                    <h4 align="left">Прикрепить файлы</h4>
                    <div class="row">

                        <div class="col-sm">
                            <input name="doc_prework" type="file">
                        </div>


                    </div>



                </div>


            </div>
                @csrf
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button  type="submit" class="btn btn-primary">Добавить</button>

            </div>


            </form>
        </div>

    </div>
</div>


