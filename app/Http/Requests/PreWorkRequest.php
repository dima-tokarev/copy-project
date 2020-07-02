<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


class PreWorkRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*  return \Auth::user()->canDo('EDIT_USERS');*/
        return true;
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();



        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      /*  $id = (isset($this->route()->parameter('users')->id)) ? $this->route()->parameter('users')->id : '';
*/


        return [
            'name_prework' => 'required|max:255',
            'desc_prework' => 'max:255',
            'responsible' => 'required'

            /* 'role_id' => 'required|integer',*/

        ];


    }
    public function messages()
    {
        return [
            'name_prework.required' => 'Не заполнено поле "Тема работы"',
            'responsible.required' => 'Выберите ответственного пользователя'
        /*    'name.max' => 'Превышено количество символов в имени, допустимый максимум 255 символов',
            'email.max' => 'Превышено количество символов в email, допустимый максимум 255 символов',
            'email.required' => 'Не заполнено поле "Email пользователя',
            'email.unique' => 'Данный email зарегистрирован',
            'password.required' => 'Не заполнено поле "Пароль"',
            'password.confirmed' => 'Введеные пароли не совпадают',
            'password.min' => 'Пароль должен быть минимум из 6 символов'*/


        ];

    }
}
