<?php

namespace App\Jobs;

use Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $code;
    protected $email;

    /**
     * 在一个任务重指定最大尝试次数可以通过 Artisan 命令的 --tries 选项 指定：
     * php artisan queue:work --tries=3
     * 你可能想通过任务类自身对最大任务尝试次数进行一个更颗粒化的处理。
     * 如果最大尝试次数是在任务类中定义的，它将优先于命令行中的值提供。
     * @var int
     */
    public $tries = 3;

    public function __construct($code, $email)
    {
        $this->code = $code;
        $this->email = $email;
    }

    public function handle()
    {
        $code = $this->code;
        $email = $this->email;
        Mail::send('emails.send_code', ['code' => $code], function ($message) use ($email) {
            $message->to($email)->subject('用户注册');
        });
    }
}
