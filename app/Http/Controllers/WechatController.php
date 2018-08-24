<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class WechatController extends Controller
{
    private $wechat;

    /**
     * WechatController constructor.
     */
    public function __construct()
    {
        $this->wechat = app('wechat.official_account');
    }

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

    /**
     *
     */
    public function createMenu()
    {
        $buttons = [
            [
                "type" => "click",
                "name" => "今日歌曲",
                "key"  => "V1001_TODAY_MUSIC"
            ],
            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "搜索",
                        "url"  => "http://www.soso.com/"
                    ],
                    [
                        "type" => "view",
                        "name" => "视频",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
        ];
        return $this->wechat->menu->create($buttons);
    }

    /**
     * @return mixed
     */
    public function menu()
    {
        $current = $this->wechat->menu->current();
        return $current;
    }
}
