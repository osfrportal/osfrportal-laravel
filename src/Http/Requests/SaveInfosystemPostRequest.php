<?php

namespace Osfrportal\OsfrportalLaravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SaveInfosystemPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('infosystem-manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'isysid' => 'required|uuid',
            'isys_name' => 'required',
            'parent_isysid' => 'nullable|string',
            'syncWithIS' => 'required|boolean',
            'controllerNameSync' => 'nullable|required_if:syncWithIS,1|string'
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            '*.required' => 'Поле обязательно для заполнения',
            '*.url' => 'Поле должно иметь формат URL',
            '*.integer' => 'Поле должно содержать только цифры',
            '*.digits_between' => 'Не меньше :min цифры, не более :max.',
            '*.boolean' => 'Необходимо выбрать значение (Да или Нет)',
            '*.uuid' => 'Некорректный формат идентификатора',
            '*.string' => 'Поле должно иметь строковое значение',
            'controllerNameSync.required_if' => 'Необходимо заполнить значение т.к включена синхронизация с ИС'
        ];
    }
}
