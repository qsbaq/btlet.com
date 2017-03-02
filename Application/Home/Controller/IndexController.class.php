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
        
        if( C('USE_SPHINX') ){
            import('Vendor.Sphinxapi');
            $nowPage = I('p');//当前页
            import('ORG.Util.Page');
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
            $nowPage = $nowPage>1 ? $nowPage : 1;
            $off=($nowPage-1)*$PageSize;

            $sphinx = new \SphinxClient();
            $sphinx->setServer("localhost", 9312);
            $sphinx->setMatchMode(SPH_MATCH_EXTENDED);   //匹配模式 ANY为关键词自动拆词，ALL为不拆词匹配（完全匹配）
            $sphinx->SetFilter ('status',1);
            $sphinx->SetSortMode ( SPH_SORT_ATTR_DESC, "update_time" );
            $sphinx->SetArrayResult ( true );	//返回的结果集为数组
            $sphinx->SetLimits($off,$listRows);//传递当前页面所需的数据条数的参数
            $result = $sphinx->query( $s ,"*");	//星号为所有索引源
            $total=$result['total'];		//查到的结果条数
            $time=$result['time'];		//耗时
            $lists=$result['matches'];		//结果集
            //var_dump($result);
            foreach($result['matches'] as $id => $ret){
		$ids .= $ret["id"].",";
            }
            $ids = rtrim($ids,',');
            $where =array();
            $where['id'] = array('in',$ids);
            $lists = M('infohash')->where($where)->order("update_time desc")->select();
            $sphinx->close();
            $page = new \Think\Page($total, $listRows);
            $p = $page->show();
            $this->assign('_page', $p? $p: '');
            $this->assign('_total',$total);
            $this->assign('_time',$time);
      
        }else{
            $MShipInfo = M('infohash');
            $lists = $this->lists($MShipInfo,array('name|files' => array('like','%'.$s.'%'),'status'=>1),'id DESC');
        }
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