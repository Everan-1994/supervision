<?php

namespace App\Http\Controllers\Api;

use App\Jobs\SendEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Requests\Api\VerificationCodeRequest;

class VerificationCodesController extends Controller implements ShouldQueue
{
    /**
     * 发送验证码
     */
    public function sendCode(VerificationCodeRequest $request)
    {
        $email = $request->email;

        // 生成6位随机数，左侧补0
        $code = str_pad(random_int(1, 999999), 6, 0, STR_PAD_LEFT);

        if (!app()->environment('production')) {
            $code = '123456';
        } else {
            // 发送验证码
            SendEmail::dispatch($code, $email);
        }
//        try {
//            Mail::send('emails.send_code', ['code' => $code], function ($message) use ($email) {
//                $message->to($email)->subject('督导处 - 广西机电职业技术学院');
//            });
//        } catch (ClientException $exception) {
//            $response = $exception->getResponse();
//            $result = json_decode($response->getBody()->getContents(), true);
//            return $this->response->errorInternal($result['msg'] ?: '验证码发送异常');
//        }

        $key = 'verification_' . str_random(15);
        $expiredAt = now()->addMinutes(3); // 有效期3分钟
        cache()->put($key, ['email' => $email, 'code' => $code], $expiredAt);

        return $this->response->array([
            'key'        => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }


}
