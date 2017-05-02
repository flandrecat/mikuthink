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
        $app = new Application(C('wechat'));

        // 从项目实例中得到服务端应用实例。
        $server = $app->server;

        $response = $server->serve();
        $response->send(); // Laravel 里请使用：return $response;*/
    }

    public function getMenus(){
        $app =new Application(C('wechat'));
        $menu = $app->menu;
        $menus = $menu->all();
        var_dump($menus);
    }

    //设置菜单
    public function Menus()
    {
        $app = new Application(C('wechat'));
        $menu = $app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "热门商品",
                "key"  => "Goods"
            ],
            [
                "name"       => "个人中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "小区物业",
                        "url"  => U('Index/index','','',true),
                    ],
                    [
                        "type" => "view",
                        "name" => "我的订单",
                        "url"  => U('wechat/orders','','',true),
                    ],
                    [
                        "type" => "view",
                        "name" => "绑定账号",
                        "url"  => U('Wechat/bang','','',true),
                    ],
                ],
            ],
        ];
        $r = $menu->add($buttons);
        var_dump($r);
    }

    //绑定账号
    public function bang(){
        //判断session中是否有openid
        if(empty(session('openid'))){
            $app = new Application(C('wechat'));
            //发起授权
            $response = $app->oauth->scopes(['snsapi_userinfo'])
                ->redirect();
            $response->send();
            //设置回调地址,便于授权回调地址跳回当前页面
            session('back','Wechat/bang');
        }
        //var_dump(session('openid'));
        $openid = session('openid');

        $member = D('Member')->where(['openid'=>$openid])->find();
        //判断是否绑定过
        if($member){
            D('Member')->login($member['uid']);
            $this->redirect('Index/index');
        }

        $this->redirect('User/login');

    }
    public function deng(){
        $app = new Application(C('wechat'));
        //发起授权
        $response = $app->oauth->redirect();
        $response->send();
    }
    //回调授权
    public function callback(){
        $app = new Application(C('wechat'));
        $user = $app->oauth->user();
        //将用户的openid保存到session
        session('openid',$user->id);
        //保存回调地址
        $url = session('back');
        //判断是否有openid
        if(session('openid')){

            //清空session
            session('back',null);
            $this->redirect($url);
        }else{
            //$this->redirect(['wechat/bang']);
        }
    }



}