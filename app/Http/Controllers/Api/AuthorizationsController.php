<?php

namespace App\Http\Controllers\Api;

use App\TransFormers\UserTransformer;
use App\Http\Requests\Api\AuthorizationRequest;

class AuthorizationsController extends Controller
{
    public function store(AuthorizationRequest $request)
    {
        $verifyData = \Cache::get($request->captcha_key);

        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        if (!hash_equals($verifyData['code'], $request->captcha)) {
            // 返回401
            return $this->response->errorUnauthorized('验证码错误');
        }

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        if (!$token = \Auth::guard('api')->attempt($credentials)) {
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->respondWithToken($token);

    }

    public function respondWithToken($token)
    {
        return $this->response->item(\Auth::guard('api')->user(), new UserTransformer())
            ->setMeta([
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'expires_in'   => \Auth::guard('api')->factory()->getTTL() * 60 * 2
            ])->setStatusCode(201);
    }

    public function update()
    {
        $token = \Auth::guard('api')->refresh();
        return $this->response->array([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => \Auth::guard('api')->factory()->getTTL() * 60 * 2
        ], 201);
    }

    public function destroy()
    {
        \Auth::guard('api')->logout();
        return $this->response->noContent();
    }
}
