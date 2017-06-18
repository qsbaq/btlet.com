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
            $temp = explode(":",$list[$i]['ip']);
            $list[$i]['ip'] = $temp[0];
            $list[$i]['port'] = $temp[1];
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
        if($location===FALSE) return;     
        if (empty($location->desc)) {    
            $loc = $location->province.$location->city.$location->district.$location->isp;  
        }else{         
            $loc = $location->desc;    
        }    
        return $loc;
    }
    
    private function getIPLoc_baidu($queryIP){
        $url = 'https://api.map.baidu.com/location/ip?ak=RH2EBCLH760prU4rIiFtyq4KFApK2rf9&coor=bd09ll?ip='.$queryIP;    
        $ch = curl_init($url);     
        curl_setopt($ch,CURLOPT_ENCODING ,'utf8');     
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
        $location = curl_exec($ch);    
        $location = json_decode($location);    
        curl_close($ch);         
        $loc = "";   
        if($location===FALSE) return;   
//        var_dump($location);
        $loc = $location->address;    
        return $loc;
    }


}
