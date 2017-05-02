<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/26
 * Time: 11:49
 */

namespace Admin\Controller;


class CenterController extends AdminController
{
    public function index()
    {
        //查询数据
        $Center = M('Center');
        $count = $Center->where('id'>0)->count();
        $Page =new \Think\Page($count,2);
        $show = $Page->show();
        $list = $Center->where('status=1')->limit($Page->firstRow.','.$Page->listRows)->select();
        int_to_string($list,['status'=>[0=>'完成',1=>'未处理',2=>'处理中',3=>'处理完成']]);
        //分配数据
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add()
    {
        //判断接受方式
        if(IS_POST){
            //使用create方法,写入数据库
            $Center = D('Center');
            $data = $Center->create();
            if($data){
                $id = $Center->add();
                //判断是否有id
                if($id){
                    //成功跳转显示页面
                    $this->success('添加成功',U('index'));
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($Center->getError());
            }
        }
        $this->display();
    }


    public function edit($id = 0){
        if(IS_POST){
            $Center = D('Center');
            $data = $Center->create();
            if($data){
                if($Center->save()){
                    //记录行为
                    action_log('update_channel', 'channel', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Center->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Center')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $pid = I('get.pid', 0);
            //获取父导航
            if(!empty($pid)){
                $parent = M('Center')->where(array('id'=>$pid))->field('title')->find();
                $this->assign('parent', $parent);
            }

            $this->assign('pid', $pid);
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            $this->display('add');
        }
    }

    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('Center')->where($map)->delete()){
            //记录行为
            action_log('update_channel', 'channel', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
}