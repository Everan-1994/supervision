<?php

namespace App\Http\Requests\Api;

class AuthorizationRequest extends Request
{
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string|between:6,18',
        ];
    }

    public function message()
    {
        return [
            'email.required'    => '邮箱不能为空',
            'email.email'       => '邮箱格式不正确',
            'password.required' => '密码不能为空',
            'password.between'  => '密码介于6 ~ 18位之间'
        ];
    }
}
