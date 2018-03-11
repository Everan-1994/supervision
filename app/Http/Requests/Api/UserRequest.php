<?php

namespace App\Http\Requests\Api;

class UserRequest extends Request
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'              => 'required|between:2,8',
                    'email'             => 'required|email|unique:users',
                    'password'          => 'required',
                    'sex'               => 'required',
                    'identify'          => 'required',
                    'verification_key'  => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
            case 'PATCH':
                return [
                    'name'  => 'between:3,25',
                    'email' => 'email',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'verification_key'  => '短信验证码 key',
            'verification_code' => '短信验证码',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => '姓名不能为空',
            'name.between'      => '姓名必须介于 2 - 4 个字符之间。',
            'email.required'    => '邮箱不能为空',
            'password.required' => '密码不能为空',
            'email.email'       => '邮箱格式不正确',
            'email.unique'      => '邮箱已被占用',
            'sex.required'      => '性别不能为空',
            'identify.required' => '注册身份不能为空'
        ];
    }
}
