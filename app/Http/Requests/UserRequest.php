<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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

	    $validator->sometimes('password', 'required|min:6|confirmed', function($input)
	    {

			if(!empty($input->password) || ((empty($input->password) && $this->route()->getName() !== 'admin.users.update'))) {
				return TRUE;
			}

			return FALSE;
	    });

	    return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = (isset($this->route()->parameter('users')->id)) ? $this->route()->parameter('users')->id : '';



		return [
             'name' => 'required|max:255',
		/*	 'login' => 'required|max:255',*/
			/* 'role_id' => 'required|integer',*/
             'email' => 'required|email|max:255|unique:users,email,'.$id
        ];


    }
    public function messages()
    {
        return [
            'name.required' => 'Не заполнено поле "Имя пользователя"',
            'name.max' => 'Превышено количество символов в имени, допустимый максимум 255 символов',
            'email.max' => 'Превышено количество символов в email, допустимый максимум 255 символов',
            'email.required' => 'Не заполнено поле "Email пользователя',
            'email.unique' => 'Данный email зарегистрирован',
            'password.required' => 'Не заполнено поле "Пароль"',
            'password.confirmed' => 'Введеные пароли не совпадают',
            'password.min' => 'Пароль должен быть минимум из 6 символов'


        ];

    }
}
