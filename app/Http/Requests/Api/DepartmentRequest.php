<?php

namespace App\Http\Requests\Api;

class DepartmentRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'department' => 'required|unique:departments',
        ];
    }

    public function messages()
    {
        return [
            'department.required' => '组织机构不能为空',
            'department.unique'   => '组织机构已存在'
        ];
    }
}
