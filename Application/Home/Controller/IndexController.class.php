<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){
        $this->display();
    }
    
    
    
    public function search(){
        $MShipInfo = M('infohash');
        $s = I("s");
        $lists = $this->lists($MShipInfo,array('files' => array('like','%'.$s.'%')),'id DESC');
        $this->assign('title',$s);
    	$this->assign('list',$lists);
    	$this->display();
        
    }
}