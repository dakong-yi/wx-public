<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use EasyWeChat\Factory as wechat;
use EasyWeChat;
use EasyWeChat\OfficialAccount\Application;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志
//        $wechat = wechat::officialAccount();
        $wechat = app('wechat.official_account');
        $wechat->server->push(function($message){
            return "欢迎关注 hello world！";
        });

        Log::info('return response.');

        return $wechat->server->serve();
    }
}
