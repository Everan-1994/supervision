<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function($api) {
    // 验证码
    $api->post('verificationCodes', 'VerificationCodesController@sendCode')
        ->name('api.verificationCodes.sendCode');
});