<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Admin\Model\CenterModel;
use Admin\Model\PictureModel;
use Home\Model\DocumentModel;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){

        $category = D('Category')->getTree();
        $lists    = D('Document')->lists(null);

        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $this->assign('page',D('Document')->page);//分页

                 
        $this->display();
    }

    public function online(){
/*        //从session中获取用户ID
        $uid = session('user_auth.uid');
        //查找是否有该用户
        $member = M('Member')->where(['id'=>$uid])->select();*/
        if($this->login()){
            if(IS_POST){
                $Center = new CenterModel();
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
        }
        $this->display();
    }

    //小区通知
    public function inform(){
        $articles = M('document')->select();
        $PicUrl = new PictureModel();
        foreach ($articles as &$article){
            $PicId = $PicUrl->where(['id'=>$article['cover_id']])->select();
            $article['path'] = $PicId[0]['path'];
        }
        $this->assign('articles',$articles);
        $this->display();
    }

    public function informC()
    {
        $id = I('get.id');
        $article = M('document')->where(['id'=>$id])->find();
        $member = M('member')->where(['id'=>$article['uid']])->find();
        $Art = M('document_article')->where(['id'=>$article['id']])->find();
        $article['nickname'] = $member['nickname'];
        $article['content'] = $Art['content'];
        $this->assign('article',$article);
        $this->display();
    }

}