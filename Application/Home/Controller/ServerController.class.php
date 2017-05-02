<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/5/2
 * Time: 18:34
 */

namespace Home\Controller;


use Home\Model\ServerModel;
use Symfony\Component\HttpFoundation\ServerBag;
use Think\Controller;

class ServerController extends Controller
{
    public function renzheng(){
        //判断是否登录
        if(is_login()){
            //判断接收方式
            if(IS_POST){
                //实例化模型
                $Center = new ServerModel();
                $data['uid'] = session('user_auth')['uid'];
                $data = $Center->create();
                if($data){
                    $id = $Center->add();
                    //判断是否有id
                    if($id){
                        //成功跳转显示页面
                        $this->success('认证成功',U('index'));
                    }else{
                        $this->error('认证失败');
                    }
                }else{
                    $this->error($Center->getError());
                }
            }else{
                $this->display();
            }
        }else{
            session('call_back','Server/renzheng');
            $this->redirect('User/login');
        }
    }
}