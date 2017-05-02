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
        //判断是否登录
        if($this->login()){
            //判断接收方式
            if(IS_POST){
                //实例化模型
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
/*        $articles = M('document')->select();
        $PicUrl = new PictureModel();
        foreach ($articles as &$article){
            $PicId = $PicUrl->where(['id'=>$article['cover_id']])->select();
            $article['path'] = $PicId[0]['path'];
        }
        $this->assign('articles',$articles);*/

        $list = D('document')->where(['category_id'])->page(I('p',1),C('LIST_ROWS'))->select();
/*        foreach($list as &$v){
            $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $v['path'] = get_cover($v['cover_id'],"path");
//            $v['url'] = U('index',"id=".$v['id']);
            $v['url'] = U('detail',['id'=>$v['id']]);
        }*/
        //判断ajax请求
        if(IS_AJAX){
            if(empty($list)){
                $this->error('并没有数据');
            }else{
                $this->success($list);
            }
        }
        $this->assign('list',$list);
        $this->display();
    }

    public function informC()
    {
        //获取通知ID
        $id = I('get.id');
        //查询文章表数据
        $article = M('document')->where(['id'=>$id])->find();
        //通过文章表uid 查找用户
        $member = M('member')->where(['id'=>$article['uid']])->find();
        //通过文章表id 查找文章详情
        $Art = M('document_article')->where(['id'=>$article['id']])->find();
        //拼接数据
        $article['nickname'] = $member['nickname'];
        $article['content'] = $Art['content'];
        //分配数据
        $this->assign('article',$article);
        $this->display();
    }

    //商家活动
    public function shop(){
        /*        $articles = M('document')->select();
                $PicUrl = new PictureModel();
                foreach ($articles as &$article){
                    $PicId = $PicUrl->where(['id'=>$article['cover_id']])->select();
                    $article['path'] = $PicId[0]['path'];
                }
                $this->assign('articles',$articles);*/

        $list = D('document')->where(['category_id'=>41])->page(I('p',1),C('LIST_ROWS'))->select();
        /*        foreach($list as &$v){
                    $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
                    $v['path'] = get_cover($v['cover_id'],"path");
        //            $v['url'] = U('index',"id=".$v['id']);
                    $v['url'] = U('detail',['id'=>$v['id']]);
                }*/
        //判断ajax请求
        if(IS_AJAX){
            if(empty($list)){
                $this->error('并没有数据');
            }else{
                $this->success($list);
            }
        }
        $this->assign('list',$list);
        $this->display();
    }

    public function shopC(){
        //获取通知ID
        $id = I('get.id');
        //查询文章表数据
        $article = M('document')->where(['id'=>$id])->find();
        //通过文章表uid 查找用户
        $member = M('member')->where(['id'=>$article['uid']])->find();
        //通过文章表id 查找文章详情
        $Art = M('document_article')->where(['id'=>$article['id']])->find();
        //拼接数据
        $article['nickname'] = $member['nickname'];
        $article['content'] = $Art['content'];
        //分配数据
        $this->assign('article',$article);
        $this->display();
    }
    //小区活动
    public function action(){
        /*        $articles = M('document')->select();
        $PicUrl = new PictureModel();
        foreach ($articles as &$article){
            $PicId = $PicUrl->where(['id'=>$article['cover_id']])->select();
            $article['path'] = $PicId[0]['path'];
        }
        $this->assign('articles',$articles);*/

        $list = D('document')->where(['category_id'=>42])->page(I('p',1),C('LIST_ROWS'))->select();
        /*        foreach($list as &$v){
                    $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
                    $v['path'] = get_cover($v['cover_id'],"path");
        //            $v['url'] = U('index',"id=".$v['id']);
                    $v['url'] = U('detail',['id'=>$v['id']]);
                }*/
        //判断ajax请求
        if(IS_AJAX){
            if(empty($list)){
                $this->error('并没有数据');
            }else{
                $this->success($list);
            }
        }
        $this->assign('list',$list);
        $this->display();
    }

    public function actionC(){
        //获取通知ID
        $id = I('get.id');
        //查询文章表数据
        $article = M('document')->where(['id'=>$id])->find();
        //通过文章表uid 查找用户
        $member = M('member')->where(['id'=>$article['uid']])->find();
        //通过文章表id 查找文章详情
        $Art = M('document_article')->where(['id'=>$article['id']])->find();
        //拼接数据
        $article['nickname'] = $member['nickname'];
        $article['content'] = $Art['content'];
        //分配数据
        $this->assign('article',$article);
        $this->display();
    }
}