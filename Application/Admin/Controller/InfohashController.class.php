<?php
/* 
 * List Infohash table
 * Author : 老季<laoji.org> <admin@laoji.org>
 */
namespace Admin\Controller;

class InfohashController extends AdminController {
    public function index(){
        $hash = I("hash");
        if( $hash ){
            $map['hash'] = (string)$hash;
        }
        
        $list  = $this->lists('Infohash', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = 'InfoHash信息';
        $this->display();
    }

}
