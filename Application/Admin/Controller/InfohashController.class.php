<?php
/* 
 * List Infohash table
 * Author : 老季<laoji.org> <admin@laoji.org>
 */
namespace Admin\Controller;

class InfohashController extends AdminController {
    public function index(){
        $hash = I("hash");
        $map = array();
        if( $hash ){
            $map['infohash'] = (string)$hash;
        }
        
        $list  = $this->lists('Infohash', $map);
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = 'InfoHash信息';
        $this->display();
    }
    
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] =   array('in',$id);
        switch ( strtolower($method) ){
            case 'forbidhash':
                $this->forbid('Infohash', $map );
                break;
            case 'resumehash':
                $this->resume('Infohash', $map );
                break;
            case 'deletehash':
                $this->delete('Infohash', $map );
                break;
            default:
                $this->error('参数非法');
        }
    }

}
