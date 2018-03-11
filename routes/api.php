<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['serializer:array', 'bindings'] // 路由交给 DingoApi 处理，模型绑定的中间件并没有注册上。所以增加 bindings 中间件。
], function($api) {
    // 验证码
    $api->post('verificationCodes', 'VerificationCodesController@sendCode')
        ->name('api.verificationCodes.sendCode');
    // 用户注册
    $api->post('users', 'UsersController@store')
        ->name('api.users.store');
});