<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\TransFormers\UserTransformer;
use App\Http\Requests\Api\UserRequest;

class UsersController extends Controller
{

    public function store(UserRequest $request)
    {
        $verifyData = cache()->get($request->verification_key);

        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            return $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create([
            'department_id' => $request->department_id,
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'sex'           => $request->sex,
            'identify'      => $request->identify,
        ]);

        // 清除验证码缓存
        cache()->forget($request->verification_key);

        return $this->response->item($user, new UserTransformer())->setStatusCode(201);
    }

    /**
     * 用户信息
     */
    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }
}
