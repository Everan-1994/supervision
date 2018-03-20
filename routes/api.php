<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace'  => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings'] // 路由交给 DingoApi 处理，模型绑定的中间件并没有注册上。所以增加 bindings 中间件。
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle', // 调用接口限制
        'limit'      => config('api.rate_limits.sign.limit'), // 次数
        'expires'    => config('api.rate_limits.sign.expires'), // 时间
    ], function ($api) {
        // 邮箱验证码
        $api->post('verificationCodes', 'VerificationCodesController@sendCode')
            ->name('api.verificationCodes.sendCode');
        // 用户注册
        $api->post('users', 'UsersController@store')
            ->name('api.users.store');
        // 登录
        $api->post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');
        // 刷洗token
        $api->put('authorizations/current', 'AuthorizationsController@update')
            ->name('api.authorizations.update');
        // 删除token
        $api->delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('api.authorizations.destroy');

    });

    $api->group([
        'middleware' => 'api.throttle',
        'limit'      => config('api.rate_limits.access.limit'),
        'expires'    => config('api.rate_limits.access.expires'),
    ], function ($api) {
        // 游客可以访问的接口
        // 图片验证码
        $api->get('captchas/{captcha_key}', 'CaptchasController@store')
            ->name('api.captchas.store');
        // 系部列表
        $api->get('department', 'DepartmentController@index')
            ->name('api.department.index');

        // 需要 token 验证的接口
        $api->group(['middleware' => 'api.auth'], function ($api) {
            // 当前登录用户信息
            $api->get('user', 'UsersController@me')
                ->name('api.user.show');
            // 组织机构列表
            $api->get('departments', 'DepartmentController@departmentList')
                ->name('api.department.departmentList');
            // 获取组织机构
            $api->get('departments/{department}', 'DepartmentController@show')
                ->name('api.department.show');
            // 添加组织机构
            $api->post('departments', 'DepartmentController@store')
                ->name('api.department.store');
            // 更新组织机构
            $api->patch('departments/{department}', 'DepartmentController@update')
                ->name('api.department.update');
            // 删除组织机构
            $api->delete('departments/{id}', 'DepartmentController@destroy')
                ->name('api.department.destroy');
        });
    });

});