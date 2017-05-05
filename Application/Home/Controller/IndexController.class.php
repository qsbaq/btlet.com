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
        $page_size = count( $recKeys );
        $topic = M('search_topic')->order('hits desc,update_time desc')->limit($page_size)->select();
        $this->assign('topic',$topic);
        $this->assign('reckeys',$recKeys);
        $this->display();
    }
    
    // 搜索列表
    public function search(){
        $s = I("s");
        
        // get client ip
        $data = array();
        $data['keyword'] = $s;
        $data['ip']  = get_client_ip().':'.$_SERVER['REMOTE_PORT'];
        $data['update_time'] = date("Y-m-d H:i:s");
        M('search_log')->add($data);
  
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
            $off=($nowPage-1)*$listRows;

            $sphinx = new \SphinxClient();
            $sphinx->setServer("127.0.0.1", 9312);
            $sphinx->setMatchMode(SPH_MATCH_EXTENDED);   //匹配模式 ANY为关键词自动拆词，ALL为不拆词匹配（完全匹配）
            $sphinx->SetFilter ('status',1);
            $sphinx->SetSortMode ( SPH_SORT_EXTENDED2, "hits DESC,update_time DESC" );
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
            $lists = M('infohash')->where($where)->order("hits DESC,update_time desc")->select();
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
        $recKeys = C('RECOMMEND_KEYS');
        $topic = M('search_topic')->order('hits desc,update_time desc')->limit(20)->select();
        $this->assign('reckeys',$recKeys);
        $this->assign('topic',$topic);
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
        $recKeys = C('RECOMMEND_KEYS');
        $topic = M('search_topic')->order('hits desc,update_time desc')->limit(20)->select();
        $this->assign('reckeys',$recKeys);
        $this->assign('topic',$topic);
        $this->assign('the_title',$data['name']);
        $this->assign('data',$data);
        $this->display();
    }
    
    // 统计排行榜的脚本
    public function ranking(){
        $n = I('get.n',0,int);
        $ary = M('search_log')->distinct(true)->field('keyword')->select();
        $countAry = count($ary);
        $now = date('Y-m-d H:i:s',time());
        if( $ary[$n] ){
            $k = $ary[$n]['keyword'];
//            var_dump($ary[$n]);
            $result = M('search_topic')->where(array('keyword'=>$k))->select();
            $hits = M('search_log')->where(array('keyword'=>$k))->count();
            if( $result ){
                echo 'Update : '.$k."\n";
                M('search_topic')->where('id='.$result['id'])->data(array('hits'=>$hits,'update_time'=>$now))->save();
            }else{
                echo 'Add : '.$k."\n";
                M('search_topic')->add(array('keyword'=>$k,'hits'=>$hits,'update_time'=>$now));
            }
            $this->success('Next KeyWord : '. $ary[$n+1]['keyword'],U('index/ranking',array('n'=>$n+1)));
        }else{
            $this->success('Finished.',U('/'));
        }
    }
    
}