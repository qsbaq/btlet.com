<?php
/* 
 * List Infohash table
 * Author : 老季<laoji.org> <admin@laoji.org>
 */
namespace Admin\Controller;

class SearchlogController extends AdminController {
    public function index(){

        $list  = $this->lists('search_log');
        for( $i=0;$i<count($list);$i++):
            $temp = split(":",$list[$i]['ip']);
            $list[$i]['location'] = $this->getIPLoc_sina($temp[0]);
        endfor;

        $this->assign('_list', $list);
        $this->meta_title = '用户搜索日志';
        $this->display();
    }
    
    private function getIPLoc_sina($queryIP){    
        $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP;    
        $ch = curl_init($url);     
        curl_setopt($ch,CURLOPT_ENCODING ,'utf8');     
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
        $location = curl_exec($ch);    
        $location = json_decode($location);    
        curl_close($ch);         
        $loc = "";   
        if($location===FALSE) return "";     
        if (empty($location->desc)) {    
            $loc = $location->province.$location->city.$location->district.$location->isp;  
        }else{         
            $loc = $location->desc;    
        }    
        return $loc;
    }
    
    private function getIPLoc_baidu($queryIP){
        $url = 'http://api.map.baidu.com/location/ip?ak=898ee94ce86557b46620bf4920fc8eac&coor=bd09ll?ip='.$queryIP;    
        $ch = curl_init($url);     
        curl_setopt($ch,CURLOPT_ENCODING ,'utf8');     
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
        $location = curl_exec($ch);    
        $location = json_decode($location);    
        curl_close($ch);         
        $loc = "";   
        $loc = $location->content->address;    
        return $loc;
    }


}
