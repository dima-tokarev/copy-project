<?php

namespace App\Http\Controllers\Admin;

use App\Attachment_link;
use App\Attribute_Definition;
use App\Attribute_Scheme_Type;
use App\Custom_Type;
use App\Float_Type;
use App\History;
use App\HistoryEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PreWorkRequest;
use App\ObjectType;
use App\PreWork;
use App\PreWorkReportParticipants;
use App\Repositories\PreWorkRepository;
use App\Client;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Str;
use Gate;
use Arr;
class PreWorkController extends AdminController

{
    protected $pre_rep;
    protected $attr_content;
    protected $object_type = [];


    public function __construct( PreWorkRepository $pre) {
        parent::__construct();



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

        $filters = Attribute_Scheme_Type::all();


        $this->content = view('admin.pre_work_show')->with(['pre_works' => $pre_works,'clients' => $clients,'statuses' => $statuses,'users' => $users,'filters' => $filters,'data' => ''])->render();

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
            return view('admin.pagination_data_create')->with(['data' => $data,'class' => $_POST['class']]);


        }elseif($_POST['class'] == 'static_author'){
            $data = DB::table('users')->select('*')->orderBy('name')->get();
            return view('admin.pagination_data_filter')->with(['data' => $data,'class' => $_POST['class']]);
        }
        else{

                $data = DB::table($_POST['class'])->orderBy('id')->paginate(15);

                return view('admin.pagination_data_create')->with(['data' => $data, 'class' => $_POST['class']]);

        }


    }

    public function filterSearchVal()
    {


        if(isset($_POST['search'])) {


            $data = DB::table('client')->where('name', 'like', $_POST['search'].'%')->orderBy('name')->paginate(15);


            return view('admin.pagination_data_filter')->with(['data' => $data,'class' => 'client','word' => $_POST['search']]);

        }

    }



    public function editGetVal()
    {

        if($_POST['class'] == 'source') {
            $data = DB::table($_POST['class'])->orderBy('name')->paginate(15);
            $data = $data->groupBy('parent_id');
            return view('admin.pagination_data_create')->with(['data' => $data,'class' => $_POST['class']]);


        }elseif($_POST['class'] == 'static_author'){
            $data = DB::table('users')->select('*')->orderBy('name')->get();
            return view('admin.pagination_data_filter')->with(['data' => $data,'class' => $_POST['class']]);
        }
        else{

            $data = DB::table($_POST['class'])->orderBy('id')->paginate(15);

            return view('admin.pagination_data')->with(['data' => $data, 'class' => $_POST['class']]);

        }


    }


    public function searchVal()
    {


            if(isset($_POST['search'])) {


                $data = DB::table('client')->where('name', 'like', $_POST['search'].'%')->orderBy('name')->paginate(15);


                return view('admin.pagination_data')->with(['data' => $data,'class' => 'client','word' => $_POST['search']]);

            }


    }

    public function createSearchVal()
    {


        if(isset($_POST['search'])) {


            $data = DB::table('client')->where('name', 'like', $_POST['search'].'%')->orderBy('name')->paginate(15);


            return view('admin.pagination_data_create')->with(['data' => $data,'class' => 'client','word' => $_POST['search']]);

        }


    }



    public function getValFilter()
    {
        if($_POST['class'] == 'source') {
            $data = DB::table($_POST['class'])->orderBy('name')->paginate(15);
            $data = $data->groupBy('parent_id');
            return view('admin.pagination_data_filter')->with(['data' => $data,'class' => $_POST['class']]);


        }elseif($_POST['class'] == 'static_author'){
            $data = DB::table('users')->select('*')->orderBy('name')->get();
            return view('admin.pagination_data_filter')->with(['data' => $data,'class' => $_POST['class']]);
        }
        else{
            $data = DB::table($_POST['class'])->orderBy('name')->get();
            return view('admin.pagination_data_filter')->with(['data' => $data,'class' => $_POST['class']]);
        }


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
                      <i class="fa fa fa-times remove"></i>
                    <label class="label-add">Название</label>


                    <select name="operator_'.$_POST["class"].'"   class="form-control select-add">
                        <option value="=" selected>Содержит</option>
                        <option value="!=">Не содержит</option>

                    </select>
                      
                    <input  class="form-control input-add" type="text" name="input_'.$_POST["class"].'"  placeholder="Введите текст">
                    </td>';




        }


        if($_POST['class'] == 'static_author'){

            $data = DB::table('users')->where('id','!=',Auth::user()->id)->get();


            $html .= '<tr relate_option="'.$_POST['class'].'">
                <td>
                   <!-- <button class="remove">-</button>-->
                    <i class="fa fa-times remove"></i>
                    <label style="width: 14%"  class="label-add">Ответственный</label>


                    <select  name="operator_'.$_POST["class"].'"    class="form-control select-add">
                        <option value="=" selected>Соответствует</option>
                        <option value="!=">Не соответствует</option>

                    </select>';
            $html .='<div class="form-control" style="display:inline;border: none" id="select_'.$_POST['class'].'">
                <input style="width:13%;display: inline;border-radius:20px;background: #bde0fd" class="form-control" id="select_'.$_POST['class'].Auth::user()->id.'" type="text" value="'.Auth::user()->name.'">
                <input id="'.$_POST['class'].Auth::user()->id.'" type="hidden" name="'.$_POST['class'].']['.Auth::user()->id.']" value="'.Auth::user()->id.'">
                </div>';


            $html .= ' 
                     <span id="elem_'.$_POST['class'].'" onclick="attr_class(this)" attr_class="'.$_POST['class'].'" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                         <strong>. . .</strong>
                     </span>

 
 </td></tr>';

        }


        if($_POST['class'] == 'float_attribute_values') {


            $data = DB::table($_POST['class'])->select('*')->get();
            $name_table = Attribute_Definition::find($_POST['filter_id']);


            $html .= '<tr relate_option="'.$_POST['class'].'">
                <td>
                      <i class="fa fa-times remove"></i>
                    <label style="width: 14%"class="label-add">' . $name_table->attr_name. '</label>


                    <select name="operator_'.$_POST["class"].'"   class="form-control select-add">
                        <option value="=" selected>Равно</option>
                        <option value="!=">Не равно</option>
                        <option value=">">Больше</option>
                        <option value="<">Меньше</option>

                    </select>
                       <input type="hidden" name="'.$_POST["class"].'_attr_id" value="'.$_POST["filter_id"].'">
                    <input  class="form-control input-add" type="number" name="input_'.$_POST["class"].'"  placeholder="Введите число">
                    </td>';


        }

        if($_POST['class'] == 'string_attribute_value') {


            $data = DB::table($_POST['class'])->select('*')->get();
            $name_table = Attribute_Definition::find($_POST['filter_id']);


            $html .= '<tr relate_option="'.$_POST['class'].'">
                <td>
                      <i class="fa fa-times remove"></i>
                    <label style="width: 14%"class="label-add">' . $name_table->attr_name. '</label>


                    <select name="operator_'.$_POST["class"].'"   class="form-control select-add">
                         <option value="=" selected>Соответствует</option>
                        <option value="!=">Не соответствует</option>
                    </select>
                       <input type="hidden" name="'.$_POST["class"].'_attr_id" value="'.$_POST["filter_id"].'">
                    <input  class="form-control input-add" type="date" name="input_'.$_POST["class"].'"  placeholder="Введите число">
                    </td>';


        }



        if($_POST['class'] == 'int_attribute_values') {


            $data = DB::table($_POST['class'])->select('*')->get();
            $name_table = Attribute_Definition::find($_POST['filter_id']);


            $html .= '<tr relate_option="'.$_POST['class'].'">
                <td>
                      <i class="fa fa-times remove"></i>
                    <label style="width: 14%" class="label-add">' . $name_table->attr_name. '</label>


                    <select name="operator_'.$_POST["class"].'"   class="form-control select-add">
                        <option value="=" selected>Равно</option>
                        <option value="!=">Не равно</option>

                    </select>
                       <input type="hidden" name="'.$_POST["class"].'_attr_id" value="'.$_POST['filter_id'].'">
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
                    <i class="fa fa-times remove"></i>
                    <label style="width: 14%" class="label-add">' . $name_table->attr()->first()->attr_name . '</label>


                    <select name="operator_'.$_POST["class"].'"    class="form-control select-add">
                        <option value="=" selected>Соответствует</option>
                        <option value="!=">Не соответствует</option>

                    </select>
                    <input type="hidden" name="'.$_POST["class"].'_attr_id" value="'.$name_table->attr()->first()->id.'">';

            $html .='<div class="form-control" style="display:inline;border: none" id="select_'.$_POST['class'].'"></div>';


            $html .= ' 
                     <span id="elem_'.$_POST['class'].'" onclick="attr_class(this)" attr_class="'.$_POST['class'].'" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                         <strong>. . .</strong>
                     </span>';

            $html .= ' </td></tr>';
        }
            echo $html;

    }



    public function getAttr(){
        $html ='';

        if($_POST['class'] == 'static_author') {
           $items = DB::table('users')->where('id', Auth::user()->id)->get();
        }



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

     /*   dump($_POST['data']);*/

    /*    dd($request->all());*/
         $sql_2 = DB::table('prework as p');

         $arr = array('p.*');
         if(isset($_POST['arr_option'])) {

            $i = 0;



            foreach ($_POST['arr_option'] as $item) {


                    if ($item == 'client') {




                        $sql_2->join('custom_attribute_value as cp'.$i, function ($join) use($i) {
                            $join->on('cp'.$i.'.object_id', '=', 'p.id')
                                ->on('p.type_id', '=', 'cp'.$i.'.object_type_id')
                                ->where('cp'.$i.'.attr_id', '=', $_POST['id_filter'][$i]);


                        })->leftJoin('client as cl'.$i, 'cl'.$i.'.id', '=', 'cp'.$i.'.value');

                        array_push($arr, "cl".$i.".name as client_value");


                    }

                    if ($item == 'source') {



                        $sql_2->join('custom_attribute_value as so'.$i, function ($join) use($i)  {

                            $join->on('so'.$i.'.object_id', '=', 'p.id')
                                ->on('p.type_id', '=', 'so'.$i.'.object_type_id')
                                ->where('so'.$i.'.attr_id', '=', $_POST['id_filter'][$i]);


                        })->leftJoin('source as sou'.$i, 'sou'.$i.'.id',  '=', 'so'.$i.'.value');

                        array_push($arr, "sou".$i.".name as source_value");


                    }

                    if ($item == 'prework_type') {


                        $sql_2->join('custom_attribute_value as cus'.$i, function ($join) use($i)  {
                            $join->on('cus'.$i.'.object_id', '=', 'p.id')
                                ->on('p.type_id', '=', 'cus'.$i.'.object_type_id')
                                ->where('cus'.$i.'.attr_id', '=', $_POST['id_filter'][$i]);


                        })->leftJoin('prework_type as pre'.$i, 'pre'.$i.'.id', '=', 'cus'.$i.'.value');

                        array_push($arr, "pre".$i.".name as prework_type_value");


                    }


                    if ($item == 'status') {


                        $sql_2->join('custom_attribute_value as st'.$i, function ($join) use($i)  {
                            $join->on('st'.$i.'.object_id', '=', 'p.id')
                                ->on('p.type_id', '=', 'st'.$i.'.object_type_id')
                                ->where('st'.$i.'.attr_id', '=', $_POST['id_filter'][$i]);


                        })->join('status as sta'.$i, 'sta'.$i.'.id', '=', 'st'.$i.'.value');

                        array_push($arr, "sta".$i.".name as status_value");


                    }


                    if ($item == 'float_attribute_values') {


                        $sql_2->join('float_attribute_values as flo'.$i, function ($join) use($i)  {
                            $join->on('flo'.$i.'.object_id', '=', 'p.id')
                                ->on('p.type_id', '=', 'flo'.$i.'.object_type_id')
                                ->where('flo'.$i.'.attr_id', '=', $_POST['id_filter'][$i]);


                        });

                        array_push($arr, "flo".$i.".value as float_value".$i);


                    }

                    if ($item == 'string_attribute_value') {


                        $sql_2->join('string_attribute_value as str'.$i, function ($join) use($i)  {
                            $join->on('str'.$i.'.object_id', '=', 'p.id')
                                ->on('p.type_id', '=', 'str'.$i.'.object_type_id')
                                ->where('str'.$i.'.attr_id', '=', $_POST['id_filter'][$i]);


                        });

                        array_push($arr, "str".$i.".value as string_value".$i);


                    }

                    if ($item == 'int_attribute_values') {


                        $sql_2->join('int_attribute_values as int'.$i, function ($join) use($i)  {
                            $join->on('int'.$i.'.object_id', '=', 'p.id')
                                ->on('p.type_id', '=', 'int'.$i.'.object_type_id')
                                ->where('int'.$i.'.attr_id', '=', $_POST['id_filter'][$i]);


                        });

                        array_push($arr, "int".$i.".value as int_value".$i);


                    }

                    $i++;
                }


                /* $result2 = $sql_2->get($arr);*/



         }

        /* фильтры  */

        $sql = $sql_2;



        if(isset($_POST['data'])) {



            if (isset($_POST['data']['operator_static_author']) && isset($_POST['data']['static_author'])) {


                if($_POST['data']['operator_static_author'] == '=')
                {

                    $sql->whereIn('author_id', $_POST['data']['static_author']);
                }else{
                    $sql->whereNotIn('author_id', $_POST['data']['static_author']);
                }



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



            if (isset($_POST['data']['client_attr_id']) && isset($_POST['data']['client'])) {

                if($_POST['data']['operator_client']  == '=') {
                    $sql->join('custom_attribute_value as c', function ($join) {
                        $join->on('c.object_id', '=', 'p.id')
                            ->on('p.type_id', '=', 'c.object_type_id')
                            ->where('c.attr_id', '=', $_POST['data']['client_attr_id'])
                            ->whereIn('c.value', $_POST['data']['client']);
                    });
                }else{
                    $sql->join('custom_attribute_value as c', function ($join) {
                        $join->on('c.object_id', '=', 'p.id')
                            ->on('p.type_id', '=', 'c.object_type_id')
                            ->where('c.attr_id', '=', $_POST['data']['client_attr_id'])
                            ->whereNotIn('c.value', $_POST['data']['client']);
                    });
                }



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

            if (isset($_POST['data']['string_attribute_value_attr_id'])) {
                $sql->leftJoin('string_attribute_value as str_i', function ($join) {
                    $join->on('str_i.object_id', '=', 'p.id')
                        ->on('p.type_id', '=', 'str_i.object_type_id')
                        ->where('str_i.attr_id', '=', $_POST['data']['string_attribute_value_attr_id'])
                        ->where('str_i.value', $_POST['data']['operator_string_attribute_value'], $_POST['data']['input_string_attribute_value']);
                });
            }



            if (isset($_POST['data']['prework_type_attr_id']) && isset($_POST['data']['prework_type'])) {
                if($_POST['data']['operator_prework_type']  == '=') {
                    $sql->join('custom_attribute_value as pre', function ($join) {
                        $join->on('pre.object_id', '=', 'p.id')
                            ->on('p.type_id', '=', 'pre.object_type_id')
                            ->where('pre.attr_id', '=', $_POST['data']['prework_type_attr_id'])
                            ->whereIn('pre.value', $_POST['data']['prework_type']);
                    });
                }else{
                    $sql->join('custom_attribute_value as pre', function ($join) {
                        $join->on('pre.object_id', '=', 'p.id')
                            ->on('p.type_id', '=', 'pre.object_type_id')
                            ->where('pre.attr_id', '=', $_POST['data']['prework_type_attr_id'])
                            ->whereNotIn('pre.value', $_POST['data']['prework_type']);
                    });
                }
            }
            if (isset($_POST['data']['source_attr_id']) && isset($_POST['data']['source'])) {

                if($_POST['data']['operator_source']  == '=') {
                    $sql->join('custom_attribute_value as s', function ($join) {
                        $join->on('s.object_id', '=', 'p.id')
                            ->on('p.type_id', '=', 's.object_type_id')
                            ->where('s.attr_id', '=', $_POST['data']['source_attr_id'])
                            ->whereIn('s.value', $_POST['data']['source']);
                    });
                }else{
                    $sql->join('custom_attribute_value as s', function ($join) {
                        $join->on('s.object_id', '=', 'p.id')
                            ->on('p.type_id', '=', 's.object_type_id')
                            ->where('s.attr_id', '=', $_POST['data']['source_attr_id'])
                            ->whereNotIn('s.value', $_POST['data']['source']);
                    });
                }
            }
            if (isset($_POST['data']['status_attr_id']) && isset($_POST['data']['status'])) {
                if($_POST['data']['operator_status']  == '=') {
                    $sql->join('custom_attribute_value as stat', function ($join) {
                        $join->on('stat.object_id', '=', 'p.id')
                            ->on('p.type_id', '=', 'stat.object_type_id')
                            ->where('stat.attr_id', '=', $_POST['data']['status_attr_id'])
                            ->whereIn('stat.value', $_POST['data']['status']);
                    });
                }else{
                    $sql->join('custom_attribute_value as stat', function ($join) {
                        $join->on('stat.object_id', '=', 'p.id')
                            ->on('p.type_id', '=', 'stat.object_type_id')
                            ->where('stat.attr_id', '=', $_POST['data']['status_attr_id'])
                            ->whereNotIn('stat.value', $_POST['data']['status']);
                    });
                }
            }



        }
        $result2 = $sql->get($arr);



        /* фильтры*/

        $html_content = '';
        $html_head = '';


       if(isset($_POST['table'])) {
           $html_head .= '<th scope="col">'.$_POST["filter_name"].'</th>';
       }



        if(isset($_POST['arr_option'])) {




                    foreach ($result2 as $item) {
                        $html_content .='<tr>';

                        $html_content .= '<td style="width: 2%">' . $item->id . '</td>';
                        $html_content .= '<td style="width: 10%"><a href="./preworks/'.$item->id.'">' . $item->name . '</a></td>';
                        $html_content .= '<td style="width: 10%">' . User::where('id', $item->author_id)->first()->name . '</td>';
                        $html_content .= '<th  style="width: 10%;text-align: right">';

                        if(\Gate::allows('edit_attr_admin') || \Gate::allows('edit_attr_leader') || $item->user_id == \Auth::user()->id ){

                            $html_content .='<div  style="margin-left: 0px" class="row">
                                                <div >      <a class="fa fa-pencil-square-o" style="color: #2fa360" href="preworks/'.$item->id.'/edit"></a> /
                        
                                                </div>
                                                <div >
                                                    <form id="delete-form" action="preworks-delete/'.$item->id.'" method="post">
                                                        '.csrf_field().'<button id="delete-confirm" style="margin-top: -4px;color:indianred"  onclick="return confirm(\'Удалить работу?\')" class="btn btn-link fa fa-trash-o"></button>
                                                    </form>
                                                </div>
                                        </div>';

                        }
                        $html_content .= '</th>';
                    $k = 0;
                    foreach ($_POST['arr_option'] as $val) {
                        if ($val == 'int_attribute_values') {
                            $val = 'int_value'.$k;
                            $html_content .= '<td style="width: 10%;text-align: center">' . $item->$val.'</td>';
                        }
                        if ($val == 'status') {
                            $html_content .= '<td style="width: 10%">' . $item->status_value . '</td>';
                        }
                        if ($val == 'source') {
                            $html_content .= '<td style="width: 10%">' . $item->source_value . '</td>';
                        }
                        if ($val == 'client') {
                            $html_content .= '<td style="width: 10%">' . $item->client_value . '</td>';
                        }
                        if ($val == 'prework_type') {
                            $html_content .= '<td style="width: 10%">' . $item->prework_type_value . '</td>';
                        }
                        if ($val == 'float_attribute_values') {

                            $val = 'float_value'.$k;
                            $html_content .= '<td style="width: 10%">' . $item->$val.'</td>';
                        }
                        if ($val == 'string_attribute_value') {
                            $val = 'string_value'.$k;
                            $html_content .= '<td style="width: 10%">' . $item->$val.'</td>';
                        }
                    $k++;
                        }
                        $html_content .='</tr>';
                    }







            $arr_rows = [];
            $arr_rows['html_head'] = $html_head;
            $arr_rows['html_content'] = $html_content;

           echo json_encode($arr_rows);

        }else{


            foreach ($result2 as $item) {
                $html_content .= '<tr>';
                $html_content .= '<td style="width: 2%">' . $item->id . '</td>';
                $html_content .= '<td style="width: 10%"><a href="./preworks/'.$item->id.'">' . $item->name . '</a></td>';
                $html_content .= '<td style="width: 10%">' . User::where('id', $item->author_id)->first()->name . '</td>';
                $html_content .= '<th  style="width: 10%;text-align: right">';
                if(\Gate::allows('edit_attr_admin') || \Gate::allows('edit_attr_leader') || $item->user_id == \Auth::user()->id){

                    $html_content .='<div  style="margin-left: 0px" class="row">
                                                <div >      <a class="fa fa-pencil-square-o" style="color: #2fa360" href="preworks/'.$item->id.'/edit"></a> /
                        
                                                </div>
                                                <div >
                                                    <form id="delete-form" action="preworks-delete/'.$item->id.'" method="post">
                                                        '.csrf_field().'<button id="delete-confirm" style="margin-top: -4px;color:indianred" onclick="return confirm(\'Удалить работу?\')" class="btn btn-link fa fa-trash-o"></button>
                                                    </form>
                                                </div>
                                        </div>';

                }
                $html_content .= '</th>';
                $html_content .= '</tr>';
            }

            $arr_rows = [];

            $arr_rows['html_content'] = $html_content;

            echo json_encode($arr_rows);

        }



    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PreWork $preWork ,$id)
    {

        $attribute_cust = '';
        $aliases = [];


        $attributes = $this->pre_rep->getAttr($preWork);

        $attr_sort = [];

        foreach ($attributes as $attribute){
            $obj = ObjectType::find($attribute->attr()->get()->first()->attr_type);
            $attr_def = $attribute->attr()->get()->first()->attr_name;

            if($obj->type == 'custom') {

                $query = DB::table('custom_attribute_value')->where('object_id', $id)->where('object_type_id', 1)->where('attr_id', $attribute->attr()->get()->first()->id)->get();

                $query2 = DB::table($obj->name)->where('id',$query[0]->value)->first();

                $query[0]->value_table = isset($query2->name) ? $query2->name : '';
                $query[0]->attr_name = $attr_def;
                $query[0]->object_type = $obj->type;


                $attr_sort[$obj->name][] = $query;


            }
            if($obj->type == 'float') {
                $query = DB::table($obj->name)->where('object_id', $id)->where('object_type_id', 1)->where('attr_id', $attribute->attr()->get()->first()->id)->get();
                $query[0]->attr_name = $attr_def;
                $query[0]->object_type = $obj->type;
                $attr_sort[$obj->name][] = $query;
            }
            if($obj->type == 'int') {
                $query = DB::table($obj->name)->where('object_id', $id)->where('object_type_id', 1)->where('attr_id', $attribute->attr()->get()->first()->id)->get();
                $query[0]->attr_name = $attr_def;
                $query[0]->object_type = $obj->type;
                $attr_sort[$obj->name][] = $query;


            }
            if($obj->type == 'string') {
                $query = DB::table($obj->name)->where('object_id', $id)->where('object_type_id', 1)->where('attr_id', $attribute->attr()->get()->first()->id)->get();
                $query[0]->attr_name = $attr_def;
                $query[0]->object_type = $obj->type;
                $attr_sort[$obj->name][] = $query;


            }

        }



        $pre_work = PreWork::find($id);



        $attachments = Attachment_link::where('object_id',$id)->get();

        $history = History::where('object_id',$id)->where('object_type_id',1)->get();


      /*  $com = $pre_work->commentsPreWork->where('object_type_id',1)->groupBy('parent_id');*/

     /*   $count = count($pre_work->commentsPreWork->where('object_type_id',1));*/

        $participants = PreWorkReportParticipants::where('prework_id',$id)->get();

        $this->content = view('admin.pre_work_current')->with([

            'pre_works' => $pre_work,
            'attrs' => $attr_sort,
            'history' => $history,
            'attachments' => $attachments,
            'reports' => '',
            'com' => '',
            'count' => '',
            'participants' => $participants


        ])->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PreWork $preWork, $id)
    {

        $attributes = $this->pre_rep->getAttr($preWork);

        $attr_sort = [];

        foreach ($attributes as $attribute){
          $obj = ObjectType::find($attribute->attr()->get()->first()->attr_type);
          $attr_def = $attribute->attr()->get()->first()->attr_name;
            $pre = PreWork::find($id);
            if($obj->type == 'custom') {


              $query = DB::table('custom_attribute_value')->where('object_id', $id)->where('object_type_id', 1)->where('attr_id', $attribute->attr()->get()->first()->id)->get();

              $query2 = DB::table($obj->name)->where('id',$query[0]->value)->first();

                $query[0]->value_table = isset($query2->name) ? $query2->name : '';
                $query[0]->attr_name = $attr_def;
                $query[0]->object_type = $obj->type;



                if($obj->name == 'status' && Gate::allows('edit_attr_leader') == true || Gate::allows('edit_attr_admin') == true  || Gate::allows('edit_attr_manager') == true ) {
                    $attr_sort[$obj->name][] = $query;
                }else{
                    if(Gate::allows('edit_attr_admin') == true  || Gate::allows('edit_attr_manager') == true || Auth::user()->id == $pre->user_id || Auth::user()->id == $pre->author_id){
                        $attr_sort[$obj->name][] = $query;
                    }
                }

            }
            if($obj->type == 'float') {
                $query = DB::table($obj->name)->where('object_id', $id)->where('object_type_id', 1)->where('attr_id', $attribute->attr()->get()->first()->id)->get();
                $query[0]->attr_name = $attr_def;
                $query[0]->object_type = $obj->type;
                $attr_sort[$obj->name][] = $query;
            }
            if($obj->type == 'int') {

                $query = DB::table($obj->name)->where('object_id', $id)->where('object_type_id', 1)->where('attr_id', $attribute->attr()->get()->first()->id)->get();
                $query[0]->attr_name = $attr_def;
                $query[0]->object_type = $obj->type;


                if($query[0]->attr_id == 6 && Gate::allows('edit_attr_leader') == true || Gate::allows('edit_attr_admin') == true  || Gate::allows('edit_attr_manager') == true ) {
                    $attr_sort[$obj->name][] = $query;
                }else{
                    if(Gate::allows('edit_attr_admin') == true  || Gate::allows('edit_attr_manager') == true || Auth::user()->id == $pre->user_id || Auth::user()->id == $pre->author_id){
                        $attr_sort[$obj->name][] = $query;
                    }
                }


            }
            if($obj->type == 'string') {
                $query = DB::table($obj->name)->where('object_id', $id)->where('object_type_id', 1)->where('attr_id', $attribute->attr()->get()->first()->id)->get();
                $query[0]->attr_name = $attr_def;
                $query[0]->object_type = $obj->type;

                if(Gate::allows('edit_attr_admin') == true  || Gate::allows('edit_attr_manager') == true) {
                    $attr_sort[$obj->name][] = $query;
                }

            }

        }


        $pre_work = PreWork::find($id);

        $attachments = Attachment_link::where('object_id',$id)->get();



        $participants = PreWorkReportParticipants::where('prework_id',$id)->get();

        $users = User::all();


            $this->content = view('admin.prework_edit')->with([

                'pre_works' => $pre_work,
                'attrs' => $attr_sort,
                'participants' => $participants,
                'attachments' => $attachments,
                'pre_work_id' => $id ,
                'data' => '',
                'users' => $users])->render();




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
