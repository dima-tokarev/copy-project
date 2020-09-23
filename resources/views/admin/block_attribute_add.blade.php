<div class="container">
    <h5 >Добавление блока:</h5>
    <hr>
    <br />
    <form action="{{route('store_block')}}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 add_attr">

                <div class="row">

                    <div class="col-4 input_opt" >
                        <div><b>Название блока</b></div>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="col-4">
                        <div>&nbsp;</div>
                        <input type="text" name="cat"  class="form-control" value="" placeholder="Привязать к категории" disabled>
                    </div>

                    <div class="col-4">
                        <div>&nbsp;</div>
                        <button type="submit" class="btn btn-info">Добавить блок</button>
                    </div>




                </div>

            </div>

        </div>
        <div style="margin-top: 10px;" class="row">
            <div id class="col-6">
                {{-- <a href="javascript:void(0)" id="add_attr" class="btn btn-info">Добавить еще атрибут</a>--}}
            </div>
            <div align="right" class="col-6">


            </div>
        </div>
        @csrf
    </form>
</div>

