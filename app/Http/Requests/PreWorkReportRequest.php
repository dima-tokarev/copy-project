<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreWorkReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pre_work_report_name' => 'required|max:255',
            'pre_work_report_name_date' => 'required|max:255',
            'pre_work_report_hours' => 'required|max:255',
            'pre_work_report_hours' => 'required|max:255',



            /* 'role_id' => 'required|integer',*/

        ];

    }

    public function messages()
    {
        return [
            'pre_work_report_name.required' => 'Не заполнено поле "Название отчета"',
            'pre_work_report_name_date.required' => 'Не заполнена "дата выполнения"',
            'pre_work_report_hours.required' => 'Не указано количество часов',


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
