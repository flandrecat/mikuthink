<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/28
 * Time: 11:12
 */

namespace Home\Controller;


use EasyWeChat\Foundation\Application;
use Think\Controller;
include './vendor/autoload.php';

class WechatController extends  Controller
{
    public function index(){
        $wachet = new Application(C('wechat'));

        // 从项目实例中得到服务端应用实例。
        $server = $wachet->server;

        $response = $server->serve();
        $response->send(); // Laravel 里请使用：return $response;*/

    }
}