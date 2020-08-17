<?php

namespace App\Repositories;

use App\Avatar;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersRepository extends Repository
{


    public function __construct(User $user) {
        $this->model  = $user;

    }

    public function addUser($request) {


   /*     if (\Gate::denies('create',$this->model)) {
            abort(403);
        }*/

        $data = $request->all();

        $user = $this->model->create([
            'name' => $data['name'],
         /* 'login' => $data['login'],*/
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if($user) {
            $user->roles()->attach($data['role']);
        }



        return ['status' => 'Пользователь добавлен'];

    }


    public function updateUser($request) {


   /*     if (\Gate::denies('edit',$this->model)) {
            abort(403);
        }*/

        $data = $request->all();

        $user = User::find($data['user_id']);


        $data2 = $request->except(['_token','user_id','avatar','password_confirmation']);

        if($data2['password'] == '') {
            $user->update([
                'name' => $data2['name'],
                'email' => $data2['email'],
            ]);
        }else{
            $user->update([
                'name' => $data2['name'],
                'email' => $data2['email'],
                'password' => bcrypt($data['password'])
            ]);
        }

        /*обновляем роль*/

        if(isset($data['role'])) {
            $user->roles()->sync($data['role']);
        }

        if($request->file('avatar')) {


            $img_name = $request->file('avatar')->getClientOriginalName();
            $path = $request->file('avatar')->store('avatars', 'public');

            $avatar = Avatar::where('user_id',$data['user_id'])->get();

            if(count($avatar) > 0){

                Avatar::where('user_id',$data['user_id'])->update([
                    'filename' => $img_name,
                    'path' => $path,
                    'user_id' => $data['user_id']

                ]);

            }else{
                Avatar::create([

                    'filename' => $img_name,
                    'path' => $path,
                    'user_id' => $data['user_id']

                ]);
            }



        }





     /*   $user->fill($data)->update();*/


        return ['status' => 'Профиль изменен'];

    }

    public function deleteUser($user) {

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
