<?php

namespace App\Http\Requests\Api;

class VerificationCodeRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '邮箱不能为空',
            'email.email'    => '邮箱格式不正确',
            'email.unique'   => '该邮箱已注册'
        ];
    }
}
