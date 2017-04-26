<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/4/26
 * Time: 11:51
 */

namespace Admin\Model;
use Think\Model;

class CenterModel extends Model
{
    protected $_validate =array(
        array('name','require','报修人不能为空'),
        array('tel','require','电话不能为空'),
        array('address','require','地址不能为空'),
        array('title','require','标题不能为空'),
        array('content','require','内容不能为空'),
    );

    protected $_auto = array(
        array('addtime', NOW_TIME, self::MODEL_INSERT),
        array('status', '1', self::MODEL_INSERT),
        array('sn','auth_key',self::MODEL_INSERT,'callback')
    );

    //拼接保修单号
    public function auth_key(){
        $chars  = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $chars  = substr(str_shuffle($chars),0,10);
        $chars  = 'IT'.$chars.'MarThu'.rand(10000,99999);
        return $chars;
    }
}