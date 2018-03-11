<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;

class CaptchasController extends Controller
{
    public function store(Request $request, CaptchaBuilder $captchaBuilder)
    {
        // 已存在验证码 先清空缓存
        if ($request->captcha_key !== 'captcha-no') {
            cache()->forget($request->captcha_key);
        }

        $key = 'captcha-' . str_random(15);

        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(10);
        cache()->put($key, ['code' => $captcha->getPhrase()], $expiredAt);

        $result = [
            'captcha_key'           => $key,
            'expired_at'            => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];

        return $this->response->array($result)->setStatusCode(201);
    }
}
