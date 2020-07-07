<?php

namespace App\Http\Controllers\Admin;

use App\Attachment_link;
use App\Attribute_Definition;
use App\Attribute_Scheme_Type;
use App\Custom_Type;
use App\Float_Type;
use App\History;
use App\Http\Controllers\Controller;
use App\Http\Requests\PreWorkRequest;
use App\ObjectType;
use App\PreWork;
use App\Repositories\PreWorkRepository;
use App\Client;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Str;
class PreWorkController extends AdminController

{
    protected $pre_rep;
    protected $attr_content;
    protected $object_type = [];


    public function __construct( PreWorkRepository $pre) {
        parent::__construct();

        /*   if (Gate::denies('EDIT_USERS')) {
                   abort(403);
               }*/

        $this->pre_rep = $pre;


        $this->template = 'admin.pre_work_rep';

    }


    /**
     * Display a listing of the resource.
     *
     * @param PreWork $preWork
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index()
    {
        //

        $pre_works = PreWork::where('author_id',Auth::user()->id)->paginate(50);

        $clients = Client::all();

        $statuses = Status::all();

        $users = User::all();

        $filters = Attribute_Definition::all();

        $this->content = view('admin.pre_work_show')->with(['pre_works' => $pre_works,'clients' => $clients,'statuses' => $statuses,'users' => $users,'filters' => $filters])->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param PreWork $preWork
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function create(PreWork $preWork)
    {
        //
        $this->title =  'Предварительные работы';

        $users = User::all();

        $attributes = $this->pre_rep->getAttr($preWork);


        $attributes =  Attribute_Definition::find($attributes);


        $this->content = view('admin.pre_work_create_content')->with(['attributes' => $attributes ,'object_id' => 1 ,'data'=> '','users' => $users])->render();

        return $this->renderOutput();



    }
/*
    public function getRoles() {
        return \App\Role::all();
    }*/

    public function getVal()
    {
        if($_POST['class'] == 'source') {
            $data = DB::table($_POST['class'])->orderBy('name')->paginate(15);

            $data = $data->groupBy('parent_id');
        }else{
            $data = DB::table($_POST['class'])->orderBy('name')->paginate(15);
        }


        return view('admin.pagination_data')->with(['data' => $data,'class' => $_POST['class']]);


    }

    public function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table($_GET['name'])->orderBy('name')->paginate(10);
            return view('admin.pagination_data')->with(['data' => $data,'class' => $_GET['name']])->render();
        }
    }




    public function addFilter()
    {


        $html = '';


        if($_POST['class'] == 'static_name'){

            $html .= '<tr relate_option="'.$_POST['class'].'">
                <td>
                      <i class="fa fa-minus-square remove"></i>
                    <label class="label-add">Тема</label>


                    <select name="operator_'.$_POST["class"].'"   class="form-control select-add">
                        <option value="=" selected>Содержит</option>
                        <option value="!=">Не Содержит</option>

                    </select>
                      
                    <input  class="form-control input-add" type="text" name="input_'.$_POST["class"].'"  placeholder="Введите текст">
                    </td>';

        }


        if($_POST['class'] == 'static_author'){

            $data = DB::table('users')->where('id','!=',Auth::user()->id)->get();


            $html .= '<tr relate_option="'.$_POST['class'].'">
                <td>
                   <!-- <button class="remove">-</button>-->
                    <i class="fa fa-minus-square remove"></i>
                    <label class="label-add">Ответственный</label>


                    <select name="operator_'.$_POST["class"].'"    class="form-control select-add">
                        <option value="=" selected>Соответствует</option>
                        <option value="!=">Не соответствует</option>

                    </select>
                    
                    <select  name="value_select_'.$_POST["class"].'"   id="inputState" class="form-control select-add">';

            $html .= '<option selected value ="' . Auth::user()->id . '">' . Auth::user()->name . '</option >';
            foreach ($data as $item) {
                $html .= '<option value ="' . $item->id . '">' . $item->name . '</option >';
            }
            $html .= ' </select></td></tr>';

        }


        if($_POST['class'] == 'float_attribute_values') {


            $data = DB::table($_POST['class'])->select('*')->get();
            $name_table = ObjectType::where('name', $_POST['class'])->first();


            $html .= '<tr relate_option="'.$_POST['class'].'">
                <td>
                      <i class="fa fa-minus-square remove"></i>
                    <label class="label-add">' . $name_table->attr()->first()->attr_name. '</label>


                    <select name="operator_'.$_POST["class"].'"   class="form-control select-add">
                        <option value="=" selected>Равно</option>
                        <option value="!=">Не равно</option>

                    </select>
                       <input type="hidden" name="'.$_POST["class"].'_attr_id" value="'.$name_table->attr()->first()->id.'">
                    <input  class="form-control input-add" type="number" name="input_'.$_POST["class"].'"  placeholder="Введите число">
                    </td>';
        }
        if($_POST['class'] == 'int_attribute_values') {


            $data = DB::table($_POST['class'])->select('*')->get();
            $name_table = ObjectType::where('name', $_POST['class'])->first();


            $html .= '<tr relate_option="'.$_POST['class'].'">
                <td>
                      <i class="fa fa-minus-square remove"></i>
                    <label style="width: 22%"  class="label-add">' . $name_table->attr()->first()->attr_name. '</label>


                    <select name="operator_'.$_POST["class"].'"   class="form-control select-add">
                        <option value="=" selected>Равно</option>
                        <option value="!=">Не равно</option>

                    </select>
                       <input type="hidden" name="'.$_POST["class"].'_attr_id" value="'.$name_table->attr()->first()->id.'">
                    <input  class="form-control input-add" type="number" name="input_'.$_POST["class"].'"  placeholder="Введите число">
                    </td>';
        }


        if($_POST['class'] == 'client' or $_POST['class'] == 'prework_type' or  $_POST['class'] == 'source' or $_POST['class'] == 'status') {

            if($_POST['class'] =='source'){
                $data = DB::table($_POST['class'])->select('*')->where('parent_id','!=',0)->get();
            }else{
                $data = DB::table($_POST['class'])->select('*')->get();
            }


            $name_table = ObjectType::where('name', $_POST['class'])->first();

            $html .= '<tr relate_option="'.$_POST['class'].'">
                <td>
                   <!-- <button class="remove">-</button>-->
                    <i class="fa fa-minus-square remove"></i>
                    <label class="label-add">' . $name_table->attr()->first()->attr_name . '</label>


                    <select name="operator_'.$_POST["class"].'"    class="form-control select-add">
                        <option value="=" selected>Соответствует</option>
                        <option value="!=">Не соответствует</option>

                    </select>
                    <input type="hidden" name="'.$_POST["class"].'_attr_id" value="'.$name_table->attr()->first()->id.'">
                    <select  name="value_select_'.$_POST["class"].'"   id="inputState" class="form-control select-add">';

            foreach ($data as $item) {
                $html .= '<option value ="' . $item->id . '">' . $item->name . '</option >';
            }
            $html .= ' </select></td></tr>';
        }
            echo $html;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PreWorkRequest $request)
    {
        //
        $result = $this->pre_rep->addPreWork($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('admin/preworks')->with($result);
    }


    public function storeFilter(Request $request){


        /* запрос по фильтрам */




         $sql_2 = DB::table('prework as p');

         $arr = array('p.*');
         if(isset($_POST['options'])) {



             foreach ($_POST['options'] as $item) {

                 if ($item == 'client') {


                     $sql_2 ->join('custom_attribute_value as cp', function ($join) {
                         $join->on('cp.object_id', '=', 'p.id')
                             ->on('p.type_id', '=', 'cp.object_type_id')
                             ->where('cp.attr_id', '=', 2);


                     })->join('client', 'client.id', '=', 'cp.value');

                     array_push($arr, "client.name as client_value");


                 }

                 if ($item == 'source') {


                     $sql_2 ->join('custom_attribute_value as so', function ($join) {

                         $join->on('so.object_id', '=', 'p.id')
                             ->on('p.type_id', '=', 'so.object_type_id')
                             ->where('so.attr_id', '=', 4);


                     })->join('source', 'source.id', '=', 'so.value');

                     array_push($arr, "source.name as source_value");


                 }

                 if ($item == 'prework_type') {


                     $sql_2 ->join('custom_attribute_value', function ($join) {
                         $join->on('custom_attribute_value.object_id', '=', 'p.id')
                             ->on('p.type_id', '=', 'custom_attribute_value.object_type_id')
                             ->where('custom_attribute_value.attr_id', '=', 3);


                     })->join('prework_type', 'prework_type.id', '=', 'custom_attribute_value.value');

                     array_push($arr, "prework_type.name as prework_type_value");


                 }


                 if ($item == 'status') {


                     $sql_2 ->join('custom_attribute_value as st', function ($join) {
                         $join->on('st.object_id', '=', 'p.id')
                             ->on('p.type_id', '=', 'st.object_type_id')
                             ->where('st.attr_id', '=', 5);


                     })->join('status', 'status.id', '=', 'st.value');

                     array_push($arr, "status.name as status_value");


                 }


                 if ($item == 'float_attribute_values') {


                     $sql_2 ->join('float_attribute_values', function ($join) {
                         $join->on('float_attribute_values.object_id', '=', 'p.id')
                             ->on('p.type_id', '=', 'float_attribute_values.object_type_id')
                             ->where('float_attribute_values.attr_id', '=', 1);


                     });

                     array_push($arr, "float_attribute_values.value as float_value");


                 }

                 if ($item == 'int_attribute_values') {


                     $sql_2 ->join('int_attribute_values', function ($join) {
                         $join->on('int_attribute_values.object_id', '=', 'p.id')
                             ->on('p.type_id', '=', 'int_attribute_values.object_type_id')
                             ->where('int_attribute_values.attr_id', '=', 6);


                     });

                     array_push($arr, "int_attribute_values.value as int_value");


                 }


             }


            /* $result2 = $sql_2->get($arr);*/




         }

        /* фильтры  */

        $sql = $sql_2;

        if(isset($_POST['data'])) {



            if (isset($_POST['data']['operator_static_author'])) {

                $sql->where('author_id', $_POST['data']['operator_static_author'], $_POST['data']['value_select_static_author']);

            }

            if (isset($_POST['data']['operator_static_name'])) {

                if($_POST['data']['operator_static_name'] == '=')
                {
                    $op = 'like';
                }else{
                    $op = 'not like';
                }



                $sql->where('p.name',$op,'%'.$_POST['data']['input_static_name'].'%');

            }



            if (isset($_POST['data']['client_attr_id'])) {
                $sql->join('custom_attribute_value as c', function ($join) {
                    $join->on('c.object_id', '=', 'p.id')
                        ->on('p.type_id', '=', 'c.object_type_id')
                        ->where('c.attr_id', '=', $_POST['data']['client_attr_id'])
                        ->where('c.value', $_POST['data']['operator_client'], $_POST['data']['value_select_client']);
                });
            }
            if (isset($_POST['data']['float_attribute_values_attr_id'])) {
                $sql->join('float_attribute_values as f', function ($join) {
                    $join->on('f.object_id', '=', 'p.id')
                        ->on('p.type_id', '=', 'f.object_type_id')
                        ->where('f.attr_id', '=', $_POST['data']['float_attribute_values_attr_id'])
                        ->where('f.value', $_POST['data']['operator_float_attribute_values'], $_POST['data']['input_float_attribute_values']);
                });
            }
            if (isset($_POST['data']['int_attribute_values_attr_id'])) {
                $sql->join('int_attribute_values as i', function ($join) {
                    $join->on('i.object_id', '=', 'p.id')
                        ->on('p.type_id', '=', 'i.object_type_id')
                        ->where('i.attr_id', '=', $_POST['data']['int_attribute_values_attr_id'])
                        ->where('i.value', $_POST['data']['operator_int_attribute_values'], $_POST['data']['input_int_attribute_values']);
                });
            }
            if (isset($_POST['data']['prework_type_attr_id'])) {
                $sql->join('custom_attribute_value as pre', function ($join) {
                    $join->on('pre.object_id', '=', 'p.id')
                        ->on('p.type_id', '=', 'pre.object_type_id')
                        ->where('pre.attr_id', '=', $_POST['data']['prework_type_attr_id'])
                        ->where('pre.value', $_POST['data']['operator_prework_type'], $_POST['data']['value_select_prework_type']);
                });
            }
            if (isset($_POST['data']['source_attr_id'])) {
                $sql->join('custom_attribute_value as s', function ($join) {
                    $join->on('s.object_id', '=', 'p.id')
                        ->on('p.type_id', '=', 's.object_type_id')
                        ->where('s.attr_id', '=', $_POST['data']['source_attr_id'])
                        ->where('s.value', $_POST['data']['operator_source'], $_POST['data']['value_select_source']);
                });
            }
            if (isset($_POST['data']['status_attr_id'])) {
                $sql->join('custom_attribute_value as st', function ($join) {
                    $join->on('st.object_id', '=', 'p.id')
                        ->on('p.type_id', '=', 'st.object_type_id')
                        ->where('st.attr_id', '=', $_POST['data']['status_attr_id'])
                        ->where('st.value', $_POST['data']['operator_status'], $_POST['data']['value_select_status']);
                });
            }



        }
        $result2 = $sql->get($arr);



        /* фильтры*/

        $html_content = '';
        $html_head = '';

        $html_head .= '<thead>
                    <tr>
                    
                        <th scope="col">#</th>
                        <th scope="col">Тема</th>
                        <th scope="col">Ответственный</th>';
       if(isset($_POST['options'])) {
           foreach ($_POST['options'] as $option) {
               if ($option == 'status') {
                   $html_head .= '<th scope="col">Статус</th>';
               }
               if ($option == 'source') {
                   $html_head .= '<th scope="col">Источник</th>';
               }
               if ($option == 'prework_type') {
                   $html_head .= '<th scope="col">Вид работ</th>';
               }
               if ($option == 'client') {
                   $html_head .= '<th scope="col">Клиент</th>';
               }
               if ($option == 'float_attribute_values') {
                   $html_head .= '<th scope="col">Бюджет</th>';
               }
               if ($option == 'int_attribute_values') {
                   $html_head .= '<th scope="col">Оценка выполненной работы</th>';
               }
           }
       }
        $html_head .= '<th></th>';
        $html_head .= '</tr></thead>';

        if(isset($_POST['options'])) {
            foreach ($result2 as $item) {
                $html_content .= '<tr style="width: 1%">';
                $html_content .= '<td style="width: 10%">' . $item->id . '</td>';
                $html_content .= '<td style="width: 20%"><a href="./preworks/'.$item->id.'"">' . $item->name . '</a></td>';
                $html_content .= '<td style="width: 20%">' . User::where('id', $item->author_id)->first()->name . '</td>';
                if (isset($_POST['options'])) {
                    foreach ($_POST['options'] as $option) {
                        if ($option == 'float_attribute_values') {
                            $html_content .= '<td style="width: 10%">' . $item->float_value . '</td>';
                        }
                        if ($option == 'int_attribute_values') {
                            $html_content .= '<td style="width: 10%;text-align: center">' . $item->int_value . '</td>';
                        }
                        if ($option == 'status') {
                            $html_content .= '<td style="width: 10%">' . $item->status_value . '</td>';
                        }
                        if ($option == 'source') {
                            $html_content .= '<td style="width: 20%">' . $item->source_value . '</td>';
                        }
                        if ($option == 'client') {
                            $html_content .= '<td style="width: 10%">' . $item->client_value . '</td>';
                        }
                        if ($option == 'prework_type') {
                            $html_content .= '<td style="width: 20%">' . $item->prework_type_value . '</td>';
                        }
                    }
                }
                $html_content .= '<td style="width: 10%;text-align: right"">   <div class="row">
                        <div class="cols-2">
                            <a class="fa fa-pencil-square-o" style="color: #2fa360" href="preworks/'.$item->id.'/edit"></a> /

                        </div>
                        <div class="cols-2">
                            <form id="delete-form" action="preworks-delete/'.$item->id.'" method="post">
                            '.csrf_field().'
                         
                               <button id="delete-confirm" style="margin-top: -8px;color:indianred"  class="btn btn-link fa fa-trash-o"></button>
                            </form>
                        </div>
                    </div></td>';
                $html_content .= '</tr>';
            }

        }else{
            foreach ($result2 as $item) {
                $html_content .= '<tr>';
                $html_content .= '<td style="width: 1%">' . $item->id . '</td>';
                $html_content .= '<td style="width: 40%"><a href="./preworks/'.$item->id.'">' . $item->name . '</a></td>';
                $html_content .= '<td style="width: 40%">' . User::where('id', $item->author_id)->first()->name . '</td>';
                $html_content .= '         <td style="text-align: right">
                    <div class="row">
                        <div class="cols-2">
                            <a class="fa fa-pencil-square-o" style="color: #2fa360" href="preworks/'.$item->id.'/edit"></a> /

                        </div>
                        <div class="cols-2">
                            <form id="delete-form" action="/preworks-delete/'.$item->id.'" method="post">
                                  '.csrf_field().'<button id="delete-confirm" style="margin-top: -8px;color:indianred" class="btn btn-link fa fa-trash-o"></button>
                            </form>
                        </div>
                    </div>
                   </td>';
                $html_content .= '</tr>';
            }
        }
           echo $html_head.$html_content;


    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $attribute_cust = '';
        $aliases = [];

         $pre_work = PreWork::find($id);

         $attr = Custom_Type::where('object_id',$id)->get();
         $attr2 = Float_Type::where('object_id',$id)->get();

        /*custom type*/
         $sql = DB::table('custom_attribute_value');
         $sql->join('attribute_definitions','attribute_definitions.id','=','custom_attribute_value.attr_id')
                 ->where('custom_attribute_value.object_id','=',$id)
                    ->join('object_types','object_types.id','=','attribute_definitions.attr_type');

        $attr = $sql->get(array('attribute_definitions.attr_name as attr_name','custom_attribute_value.value as value_type','object_types.name as  attr_type','attribute_definitions.id as id_attr'));

        $i = 0;
        foreach ($attr as $custom){

            $value = DB::table($custom->attr_type)->select('name')->where('id',$custom->value_type)->first();

            $attr[$i]->value_attr = $value->name;
            $i++;
        }
        /*float type*/
        $sql2 = DB::table('float_attribute_values');
        $sql2->join('attribute_definitions','attribute_definitions.id','=','float_attribute_values.attr_id')
          ->where('float_attribute_values.object_id','=',$id)
          ->join('object_types','object_types.id','=','attribute_definitions.attr_type');

        $attr2 = $sql2->get(array('attribute_definitions.attr_name as attr_name','float_attribute_values.value as value_type','object_types.name as  attr_type','attribute_definitions.id as id_attr'));


        /*int type*/
        $sql3 = DB::table('int_attribute_values');
        $sql3->join('attribute_definitions','attribute_definitions.id','=','int_attribute_values.attr_id')
            ->where('int_attribute_values.object_id','=',$id)
            ->join('object_types','object_types.id','=','attribute_definitions.attr_type');

        $attr3 = $sql3->get(array('attribute_definitions.attr_name as attr_name','int_attribute_values.value as value_type','object_types.name as  attr_type','attribute_definitions.id as id_attr'));




        $attachments = Attachment_link::where('object_id',$id)->get();

        $history = History::where('object_id',$id)->where('object_type_id',1)->get();


        $com = $pre_work->commentsPreWork->where('object_type_id',1)->groupBy('parent_id');
        $count = count($pre_work->commentsPreWork->where('object_type_id',1));


        $this->content = view('admin.pre_work_current')->with([

            'pre_works' => $pre_work,
            'attrs' => $attr,
            'float_attr' => $attr2,
            'int_attr' => $attr3,
            'history' => $history,
            'attachments' => $attachments,
            'reports' => $pre_work->report()->get(),
            'com' => $com,
            'count' => $count


        ])->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute_cust = '';
        $aliases = [];
        $change_attr = [];


        $pre_work = PreWork::find($id);

        $attr = Custom_Type::where('object_id',$id)->get();
        $attr2 = Float_Type::where('object_id',$id)->get();

        /*custom type*/
        $sql = DB::table('custom_attribute_value');
        $sql->join('attribute_definitions','attribute_definitions.id','=','custom_attribute_value.attr_id')
            ->where('custom_attribute_value.object_id','=',$id)
            ->join('object_types','object_types.id','=','attribute_definitions.attr_type');

        $attr = $sql->get(array('attribute_definitions.attr_name as attr_name','custom_attribute_value.value as value_type','object_types.name as  attr_type','attribute_definitions.id as id_attr'));

        $i = 0;
        foreach ($attr as $custom){

            $value = DB::table($custom->attr_type)->select('name')->where('id',$custom->value_type)->first();

            $attr[$i]->value_attr = $value->name;
            $i++;
        }
        /*float type*/
        $sql2 = DB::table('float_attribute_values');
        $sql2->join('attribute_definitions','attribute_definitions.id','=','float_attribute_values.attr_id')
            ->where('float_attribute_values.object_id','=',$id)
            ->join('object_types','object_types.id','=','attribute_definitions.attr_type');

        $attr2 = $sql2->get(array('attribute_definitions.attr_name as attr_name','float_attribute_values.value as value_type','object_types.name as  attr_type','attribute_definitions.id as id_attr'));


        /*int type*/
        $sql3 = DB::table('int_attribute_values');
        $sql3->join('attribute_definitions','attribute_definitions.id','=','int_attribute_values.attr_id')
            ->where('int_attribute_values.object_id','=',$id)
            ->join('object_types','object_types.id','=','attribute_definitions.attr_type');

        $attr3 = $sql3->get(array('attribute_definitions.attr_name as attr_name','int_attribute_values.value as value_type','object_types.name as  attr_type','attribute_definitions.id as id_attr'));


        $attachments = Attachment_link::where('object_id',$id)->get();


        foreach ($attr as $item)
        {

            if($item->attr_type == 'source'){
                $c_attr = DB::table($item->attr_type)->where('id','!=',$item->value_type)->where('parent_id','!=',0)->get();
                $change_attr[$item->attr_type] = $c_attr;
            }else{

                $c_attr = DB::table($item->attr_type)->where('id','!=',$item->value_type)->get();
                $change_attr[$item->attr_type] = $c_attr;
            }

        }


        $users = User::all();

        $this->content = view('admin.prework_edit')->with(['pre_works' => $pre_work,'attrs' => $attr,'float_attr' => $attr2,'int_attr' => $attr3, 'attachments' => $attachments,'change_attrs' => $change_attr, 'pre_work_id' => $id ,'users' => $users])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();


        $result = $this->pre_rep->updatePreWork($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('admin/preworks/'.$data['pre_work_id'])->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


/*        $result = $this->us_rep->deleteUser($user);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);*/
    }

    public function delete($id)
    {

               $result = $this->pre_rep->deletePreWork($id);
                if(is_array($result) && !empty($result['error'])) {
                    return back()->with($result);
                }
                return redirect('/admin/preworks')->with($result);


    }

}
