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
        $recKeys = C('RECOMMEND_KEYS');
        $this->assign('reckeys',$recKeys);
        $this->display();
    }
    
    // 搜索列表
    public function search(){
        $s = I("s");
        $black_list = C('KEY_BLACK_LIST');
        if( in_array($s,$black_list) ){
            $this->error('Blacklist','/',3);
            return ;
        }
        $MShipInfo = M('infohash');
        $lists = $this->lists($MShipInfo,array('name|files' => array('like','%'.$s.'%'),'status'=>1),'id DESC');
        $this->assign('the_title',$s);
    	$this->assign('list',$lists);
    	$this->display();
    }
    
    //  详情页
    public function show(){
        $data = M('infohash')->where(array(
            'infohash'  =>  I('hash'),
            'status'    => 1
        ))->find();
        //print_r($data);
        $this->assign('the_title',$data['name']);
        $this->assign('data',$data);
        $this->display();
    }
    
}