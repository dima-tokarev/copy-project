<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="add_form" action="{{route('clients.store')}}" method="post" enctype="multipart/form-data">

            <div style="padding: 16px;" class="row">
                <div class="col-7">     <h5 class="modal-title" id="exampleModalLongTitle">Создание клиента</h5></div>

                {{--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>--}}

                <div  class="col-5">
                    <div class="form-group" style="color: darkred;margin-left: 5%;font-size: 14px"></div>
                </div>

            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label >Краткое название</label>
                    <br>
                    <input name="short_name" type="text" value="{{old('short_name')}}"  class="form-control" placeholder="Введите название"><br>

                    <label >Название</label>
                    <br>
                    <input name="name" type="text" value="{{old('name')}}"  class="form-control" placeholder="Введите название"><br>

                    <label >Код 1с</label>
                    <br>
                    <input name="code1c" type="text" value="{{old('code1c')}}"  class="form-control" placeholder="Введите название"><br>






                </div>


            </div>

            @csrf
            @canany(['edit_attr_admin'])
            <div class="modal-footer">
                <a href="{{route('clients.index')}}"  class="btn btn-secondary" data-dismiss="modal">Закрыть</a>

                <button id="add_work"  type="submit" class="btn btn-primary">Добавить</button>

            </div>

            @endcanany

        </form>
    </div>

</div>