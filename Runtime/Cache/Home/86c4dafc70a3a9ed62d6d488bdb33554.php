<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php if( $title ){ echo $title.'_';} echo C('WEB_SITE_TITLE');?></title>
<meta name="keywords" content="<?php echo C('WEB_SITE_KEYWORD');?>" />
<meta name="description" content="<?php echo C('WEB_SITE_DESCRIPTION');?>" />
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link href="/Public/static/assets/css/core.css" rel="stylesheet">
<link rel="shortcut icon" href="/Public/static/assets/img/favicon.ico" />
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>

	
	<!-- 主体 -->
	
<div id="main-container" class="container">
    <div class="row">
        
        <!-- 左侧 nav
        ================================================== -->
            <div class="span3 bs-docs-sidebar">
                
                <ul class="nav nav-list bs-docs-sidenav">
                    <?php echo W('Category/lists', array($category['id'], ACTION_NAME == 'index'));?>
                </ul>
            </div>
        
        
        <!-- Index
        ================================================== -->


    <div class="container-fluid content isSearch">
        <!-- 导航条
================================================== -->

        <div class="header">
            <nav>
                <div class="navbar-header">
                    <a href="<?php echo U('Index/Index');;?>" title="<?php echo C('WEB_SITE_TITLE');?>"><img src="/Public/static/assets/img/logo.png" alt="<?php echo C('WEB_SITE_TITLE');?>" /></a>
                </div>
                <div class="collapse navbar-collapse">
                    <div class="navbar-form  search-title">
                        <input type="text" class="form-control input-md input-search square search-title-input" id="search" placeholder="Movies,actors,or What do you want ?. . .">
                        <button class="btn btn-md btn-success search-btn square" onclick="onSearch(search,1,'')">Search</button>
                    </div>
                </div>
            </nav>
        </div>
        <div class="row  custom-panel">
            <div class="col-xs-6 col-md-7">
                <div id="list-panel">
                    <p id="search-count">Found <?php echo ($_total); ?> items for <?php echo ($title); ?></p><br/>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><h5><a href="#" class="result-title"title="<?php echo ($data['name']); ?>"><?php echo ($data['name']); ?></a></h5>
                    By Time:<span class="listinfo"><?php echo ($data["update_time"]); ?></span>
                    <p></p><br><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <nav class="middle">
                    <ul class="pagination result-pagination">
                        <?php echo ($_page); ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
        

    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	
    <!-- 底部
    ================================================== -->
    
    
    <footer class="footer middle">
        <div class="container">
            <p><?php echo C('WEB_SITE_TITLE');?> is a Torrent Search Engine based on DHT protocol. All resources are automatically indexed from the DHT network. Instead of torrent files, we store meta information only for indexing.</p>
            <p><?php echo C('WEB_SITE_TITLE');?> Total indexing : <?php echo number_format($total);?> </p>
            <!--/友情链接开始-->
            <p>Links：<?php foreach($friendLink as $jLink => $jName):?><a href="<?php echo $jLink?>" target="_blank"><?php echo $jName;?></a> <?php endforeach;?></p>
            <!--/友情链接结束-->
            <p class="text-muted">
                @2016 <a href="<?php echo U(Index/Index);;?>"><?php echo TITLE;?></a>  | <a href="<?php echo DOMAIN_PATH;?>about.php">About</a>
            </p>
            <?php echo STATISTICS;?>
        </div>
    </footer>
    
    
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/clipboard.js/1.5.10/clipboard.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="/Public/static/assets/js/jquery.highlight.js"></script>

    <script type="text/javascript">   
        window.onload = function() {
            document.getElementById("search").focus();
        };
        $("#search").keypress(function() {
            if (event.which == 13) {
                onSearch(search, 1, "")
            }
        });
        function onSearch(id, page, order) {
            var keyword = trim($(id).val());
            console.log(keyword,1);
            if (keyword === "") {
                return;
            }
            var search = '<?php echo U("Index/Search",array("s"=>"-keyword-"));?>';
            url = search.replace("-keyword-", keyword); 
            console.log( url );
            window.location.href = url;
        }
        function trim(str){ //删除左右两端的空格
            return str.replace(/(^\s*)|(\s*$)/g, "");
        }
        var clipboard = new Clipboard('#btnCopy');
        clipboard.on('success', function(e) {
            $('#btnCopy').tooltip('show');
//            setTimeout(sharedModal, 1000);
        })
//        $('#btnCopy').on('hidden.bs.tooltip', function() {
//            $('#btnCopy').tooltip('destroy');
//        })

        <?php if( isset($keyword )):?>
        $(document).ready(function(){
            var key = '<?php echo $keyword;?>';
            $('.isSearch #list-panel').highlight(key);//显示高亮
            $('#search').val(key);
        });
        <?php endif;?>   
    </script>

    
<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "", //当前网站地址
		"APP"    : "", //当前项目地址
		"PUBLIC" : "/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->

<!--
 * 开发：老季
 * 网址：http://laoji.org
 * 日期：2017/2/16
 * >>>本程序为开源作品，如发生法律纠纷与作者无关!<<<
-->
</body>
</html>