
<div class="container">
    <button style="margin-left: 87%" class="btn badge-light" onclick="window.history.back()">Вернуться Назад</button>
    <h4>Отчеты о выполненной работе:</h4>
    <table id="content_work" class="table">
        <thead>
        <tr><th scope="col">#</th>
            <th scope="col">Название</th>
            <th scope="col">Ответственный</th>
        </tr></thead>
        <tbody>

          @foreach($pre_works_rep as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td><a href="{{route('prework-reports.show',$item->id)}}">{{$item->name}}</a></td>
                <td>{{$item->author->name}}</td>
            </tr>


          @endforeach

        </tbody>
    </table>
    <br/>
    <hr>
    <a href="{{route('prework-reports.create',$pre_works_rep_id)}}" class="btn btn-info">Создание отчета</a>
</div>