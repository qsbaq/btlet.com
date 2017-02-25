<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi as UserApi;

/**
 * 后台首页控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class IndexController extends AdminController {

    /**
     * 后台首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        if(UID){
            $data = M('statistics')->where()->order('date asc')->limit(30)->select();
            foreach($data as $k => $v){
                $date[] = $v["date"];
                $rows .= $v['number'].",";
                $all += $v['number'];
            }
            $this->meta_title = '管理首页';
            $this->assign('date',$date);
            $this->assign('rows',$rows);
            $this->assign('all',$all);
            $this->display();
        } else {
            $this->redirect('Public/login');
        }
    }

}
