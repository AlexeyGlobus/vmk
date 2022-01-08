<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaceRequest extends FormRequest
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

    /* Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        $charsRe = '/^[a-zA-ZабвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЭЮЯ]+$/';
        return [
            'name' => 'required|max:255|unique:places,name,' . ($this->id ?? 0),
            'coords' => 'regex:/^point\(\d+\.*\d+\s\d+\.*\d+\)/|nullable',
            'owners_email' => 'email:rfc,dns|nullable|unique:places,owners_email,' . ($this->id ?? 0),
            'owners_phone' => 'regex:/^\+*\d{10,11}?$/|nullable|unique:places,owners_phone,' . ($this->id ?? 0),
            'owners_name' => 'regex:' . $charsRe . '|nullable',
            'owners_surname' => 'required|regex:' . $charsRe . '|nullable',
            'owners_patronymic' => 'regex:' . $charsRe . '|nullable',
        ];
    }

    public function messages()
    {
        return [
            'regex' => __('The :attribute format is invalid'),
            'email' => __('The :attribute must be a valid email address'),
            'required' => __('The :attribute field is required'),
            'unique' => __('The :attribute has already been taken')
        ];
    }
}
