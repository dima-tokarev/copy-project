<div class="container">
    <button style="margin-left: 70%" class="btn badge-light" onclick="window.history.back()">Вернуться Назад</button>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h4 style="width: 68%;">Создание отчета</h4>


            <div>
                <form action="{{route('prework-reports.store')}}" method="post" enctype="multipart/form-data">
                    <label >Название</label>
                    <br>
                    <input name="pre_work_report_name" type="text" value="{{old('pre_work_report_name')}}"  class="form-control" placeholder="Введите название"><br>
                    <label >Количество часов</label>
                    <br>
                    <input name="pre_work_report_hours" value="{{old('pre_work_report_hours')}}"   type="number" class="form-control" placeholder="Введите число"><br>
                    <label >Дата выполнения:</label>
                    <br>
                    <input name="pre_work_report_name_date" value="{{old('pre_work_report_name_date')}}"  type="date" class="form-control" placeholder="Введите дату"><br>
                    <label >Объем затраченных денежных средств:</label>
                    <br>
                    <input  name="pre_work_report_name_budget"  type="number" value="{{old('pre_work_report_name_budget') ?? '0'}}" class="form-control" placeholder="Введите число"><br>
                    <label >Прикрепить файл</label>
                    <br>
                    <input name="pre_work_file_report" type="file"><br>
                    <br>
                    <label >Описание отчета</label>
                    <br>
                    <textarea name="desc_report">{{old('desc_report')}}</textarea><br>



                    <label>Участники со стороны заказчика</label>
                    <br>
                    <div id="add_participant_content">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputFio">Фамилия</label>
                                <input name="participants[fio][]" type="text" class="form-control" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputPosition">Должность</label>
                                <input name="participants[position][]" type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputContact">Контакты</label>
                                <input name="participants[contacts][]" type="text" class="form-control" >
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputContact">Агент</label>
                                <select name="participants[is_agent][]"  class="form-control" >
                                    <option value="Да">Да</option>
                                    <option value="Нет" selected>Нет</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div  class="form-row">
                        <a style="margin-left: 74%" id="add_participant" class="btn btn-link" href="javascript:void(0)">Добавить еще участника</a>
                    </div>
                    <input type="hidden" name="pre_work_rep_id" value="{{$pre_work_rep_id}}">
                    @csrf
                    <button type="submit" class="btn btn-info">Добавить отчет</button>
                </form>
            </div>
            <div class="col-2"></div>
            <br>

        </div>

    </div>

</div>

<script>
    $('document').ready(function () {

        $('#add_participant').on('click',function () {

            $('#add_participant_content').append('<div class="form-row">' +
                '<div class="form-group col-md-4">\n' +
                '                            <label for="inputFio">Фамилия</label>\n' +
                '                            <input name="participants[fio][]" type="text" class="form-control">\n' +
                '                        </div>\n' +
                '                        <div class="form-group col-md-2">\n' +
                '                            <label for="inputPosition">Должность</label>\n' +
                '                            <input name="participants[position][]" type="text" class="form-control">\n' +
                '                        </div>\n' +
                '                        <div class="form-group col-md-4">\n' +
                '                            <label for="inputContact">Контакты</label>\n' +
                '                            <input name="participants[contacts][]" type="text" class="form-control" >\n' +
                '                        </div>' +
                '   <div class="form-group col-md-2">\n' +
                '                                <label for="inputContact">Агент</label>\n' +
                '                                    <select name="participants[is_agent][]"  class="form-control" >\n' +
                '                                    <option value="Да">Да</option>\n' +
                '                                    <option value="Нет" selected>Нет</option>\n' +
                '                                </select> \n' +
                '                            </div>' +
                '</div>');
        })



    });


    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        language:"ru",
        width:'100%'
    });


</script>





