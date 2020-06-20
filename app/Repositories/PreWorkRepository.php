<?php

namespace App\Repositories;

use App\Attribute_Scheme_Type;
use App\ObjectType;
use App\PreWork;

class PreWorkRepository extends Repository
{
    protected $arr_attr = [];


    public function __construct(PreWork $pre_work) {
        $this->model  = $pre_work;

    }

    public function addPreWork($request) {


        /*     if (\Gate::denies('create',$this->model)) {
                 abort(403);
             }*/

        $data = $request->all();

        $arr_str = [];
        $arr_int = [];
        $arr_float = [];
        $arr_custom = [];

        foreach ($data['attr_simple'] as $items)
        {
            if(is_string($items)){

            }elseif (is_int($items)){

            }elseif (is_float($items)){

            }
        }

     /*   foreach ($data as $key => $item)
        {
            dd(is_string($item));
        }*/

        $pre_work = $this->model->create([
            'name' => $data['nam_prework'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);


        return ['status' => 'Работа добавлена'];

    }

    public function sortAttr($attr)
    {


        return;
    }


    public function getAttr($preWork)
    {
        $classname = mb_strtolower((new \ReflectionClass($preWork))->getShortName());

        $object = ObjectType::where('name',$classname)->first();
        $attrs = Attribute_Scheme_Type::where('type_id',$object->id)->get();

        foreach ($attrs as $attr)
        {
            $this->arr_attr[] = $attr->attr_id;
        }


        return $this->arr_attr;


    }



    public function updatePreWork($request, $user) {


        /*     if (\Gate::denies('edit',$this->model)) {
                 abort(403);
             }*/

        $data = $request->all();

        if(isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->fill($data)->update();
        $user->roles()->sync([$data['role_id']]);

        return ['status' => 'Пользователь изменен'];

    }

    public function deletePreWork($user) {

        if (Gate::denies('edit',$this->model)) {
            abort(403);
        }


        $user->roles()->detach();

        if($user->delete()) {
            return ['status' => 'Пользователь удален'];
        }
    }




}

?>
