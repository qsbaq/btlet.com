<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php if( $the_title ){ echo $the_title.'_';} echo C('WEB_SITE_TITLE');?></title>
<meta name="keywords" content="<?php echo C('WEB_SITE_KEYWORD');?>" />
<meta name="description" content="<?php echo C('WEB_SITE_DESCRIPTION');?>" />
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link href="/Public/static/assets/css/core.css" rel="stylesheet">
<link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">

<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body>

	
	<!-- 主体 -->
	
<div id="main-container" class="container">
    <div class="row">
        
        <!-- 左侧 nav
        ================================================== -->

        
        
        <!-- Index
        ================================================== -->
    <div class="container-fluid content isIndex">
        <div class="row">
            <div class="col-xs-6 col-md-6">
                <div class="middle">
                    <div class="logo">
                        <a href="<?php echo U('/');;?>" title="<?php echo C('WEB_SITE_TITLE');?>"><img src="/Public/static/assets/img/logo.png" alt="<?php echo TITLE;?>" /></a>
                    </div>
                    <div class="middle title">
                        <!--<p><?php echo C('WEB_SITE_DESCRIPTION');?></p>-->
                    </div>
                    <div class="index-search">
                        <input type="text" class="form-control input-lg input-search square" id="search" name="q" placeholder="Movies,actors,or What do you want ?. . .">
                        <button type="submit" class="btn btn-lg btn-success square index-search-btn" onclick="onSearch(search,1,'x')">Search</button>
                    </div>

                    <div class="recommend" id="recommend-list">

                    </div>
                </div>
                <div class="middle search">
                    
                </div>
            </div>
        </div>
    </div>

    </div>
</div>


	<!-- /主体 -->

	<!-- 底部 -->
	
    <!-- 底部
    ================================================== -->
    
    
    <footer class="footer middle">
        <div class="container">
            <p><?php echo C('WEB_SITE_DESCRIPTION');?></p>

            <!--/友情链接开始-->
            <!--/友情链接结束-->

            <p class="text-muted">@2017 <a href="<?php echo U('/');;?>"><?php echo C('WEB_SITE_TITLE');?></a> E-mail:<?php echo C('EMAIL');;?></p>
            <p><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1261276505'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/stat.php%3Fid%3D1261276505%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script></p>
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
            var search = '<?php echo U("s/-keyword-");?>';
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
        })

        <?php if( isset($the_title )):?>
        $(document).ready(function(){
            var key = '<?php echo ($the_title); ?>';
            $('.isSearch #list-panel').highlight(key);//显示高亮
            $('#search').val(key);
        });
        <?php endif;?>   
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