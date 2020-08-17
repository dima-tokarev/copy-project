<?php

namespace App\Http\Controllers\Admin;

use App\Avatar;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepository;
use Gate;
use App\User;
use DB;




class UsersController extends AdminController
{

    protected $us_rep;
    protected $rol_rep;


    public function __construct(/*RolesRepository $rol_rep,*/ UsersRepository $us_rep) {
        parent::__construct();

 /*       if (Gate::denies('EDIT_USERS')) {
            abort(403);
        }*/

        $this->us_rep = $us_rep;
/*        $this->rol_rep = $rol_rep;*/

        $this->template = 'admin.users';

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = $this->us_rep->get();

        $this->content = view(env('THEME').'.admin.users_content')->with(['users'=>$users ])->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $this->title =  'Новый пользователь';

   /*     $roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);;*/

 /*       $this->content = view(env('THEME').'.admin.users_create_content')->with('roles',$roles)->render();*/


        $this->content = view(env('THEME').'.admin.users_create_content')->with(['title',$this->title,'roles' => $this->getRoles()])->render();
        return $this->renderOutput();
    }

    public function getRoles() {
        return \App\Role::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
        $result = $this->us_rep->addUser($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('admin/users')->with($result);
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
    public function edit($id)
    {
        /*$this->title =  'Редактирование пользователя - '. $user->name;*/

        $user = User::find($id);
        $avatar = Avatar::where('user_id',$id)->first();
  

/*        $roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);*/

        $this->content = view(env('THEME').'.admin.users_edit')->with(['user'=>$user,'avatar' => $avatar, 'roles' => $this->getRoles()])->render();

        return $this->renderOutput();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        //
        $result = $this->us_rep->updateUser($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin/preworks/')->with($result);
    }

    public function updateUser(UserRequest $request)
    {
        //
        $result = $this->us_rep->updateUser($request);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin/preworks/')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $result = $this->us_rep->deleteUser($user);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin')->with($result);
    }
}

