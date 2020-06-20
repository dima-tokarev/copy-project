<?php

namespace App\Http\Controllers\Admin;

use App\Attribute_Definition;
use App\Attribute_Scheme_Type;
use App\Http\Controllers\Controller;
use App\Http\Requests\PreWorkRequest;
use App\ObjectType;
use App\PreWork;
use App\Repositories\PreWorkRepository;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PreWorkController extends AdminController
{
    protected $pre_rep;
    protected $attr_content;
    protected $object_type = [];

    public function __construct(/*RolesRepository $rol_rep,*/ PreWorkRepository $pre) {
        parent::__construct();

        /*       if (Gate::denies('EDIT_USERS')) {
                   abort(403);
               }*/

        $this->pre_rep = $pre;
        /*        $this->rol_rep = $rol_rep;*/

        $this->template = 'admin.pre_work';

    }


    /**
     * Display a listing of the resource.
     *
     * @param PreWork $preWork
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index(PreWork $preWork)
    {
        //
       $pre_works = $this->pre_rep->get();

        $attributes = $this->pre_rep->getAttr($preWork);

        $attributes =  Attribute_Definition::find($attributes);

        $this->content = view('admin.pre_work_show')->with(['pre_works' => $pre_works, 'attributes' => $attributes ])->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param PreWork $preWork
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function create()
    {
        //
        $this->title =  'Добавить работу';





        /*     $roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
                 $returnRoles[$role->id] = $role->name;
                 return $returnRoles;
             }, []);;*/


    }

    public function getRoles() {
        return \App\Role::all();
    }

    public function getVal()
    {

      $clients = DB::table($_POST['class'])->select('name')->get();

        $html = ' <option selected disabled>по умолчанию </option>';
          foreach ($clients as $client)
          {
              $html .= "<option value='$client->name'>$client->name</option>";
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pre_work $pre_work)
    {
        /*$this->title =  'Редактирование пользователя - '. $pre_work->name;

        $roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);

        $this->content = view(env('THEME').'.admin.users_create_content')->with(['roles'=>$roles,'user'=>$user])->render();

        return $this->renderOutput();*/

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PreWorkRequest $request, Pre_work $pre_work)
    {
        //
/*        $result = $this->us_rep->updateUser($request,$user);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pre_work $pre_work)
    {
/*        $result = $this->us_rep->deleteUser($user);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);*/
    }
}
