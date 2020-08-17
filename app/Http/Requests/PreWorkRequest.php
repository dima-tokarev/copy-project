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
     /*       'responsible' => 'required',*/
        /*    'attr_simple.6.int_attribute_values' => 'required',*/
            'attr_simple.11.int_attribute_values' => 'required',
/*            'attr_simple.9.string_attribute_value' => 'required',
            'attr_simple.10.string_attribute_value' => 'required',*/
            'attr_custom.3.prework_type' => 'required',
            'attr_custom.2.client' => 'required',
            'attr_simple.1.float_attribute_values' => 'required',
            'attr_simple.8.float_attribute_values' => 'required',
            /* 'role_id' => 'required|integer',*/

        ];


    }
    public function messages()
    {
        return [
            'name_prework.required' => 'Поле "Название" не может быть пустым ',
           /*'responsible.required' => 'Выберите ответственного пользователя',*/
           /* 'attr_simple.9.string_attribute_value.required' => 'Выберите дату начала',
            'attr_simple.10.string_attribute_value.required' => 'Выберите дату выполнения',*/
           /*'attr_simple.6.int_attribute_values.required' => 'Поле оценка работы, у.е. не может быть пустым',*/
            'attr_simple.11.int_attribute_values.required' => 'Поле "Количество часов" не может быть пустым ',
            'attr_custom.3.prework_type.required' => 'Поле "Вид работ" не может быть пустым',
            'attr_custom.2.client.required' => 'Поле "Клиент" не может быть пустым ',
            'attr_simple.1.float_attribute_values.required' => 'Поле "Бюджет" не может быть пустым ',
            'attr_simple.8.float_attribute_values.required' => 'Поле "Фактический бюджет" не может быть пустым ',

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
