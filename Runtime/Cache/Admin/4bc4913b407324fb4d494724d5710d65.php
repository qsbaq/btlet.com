<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|OneThink管理平台</title>
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
	<div class="main-title cf">
		<h2><?php if(ACTION_NAME == 'add'): ?>新增<?php else: ?>编辑<?php endif; ?>模型</h2>
	</div>

	<!-- 标签页导航 -->
	<div class="tab-wrap">
		<ul class="tab-nav nav">
			<li data-tab="tab1" class="current"><a href="javascript:void(0);">基 础</a></li>
			<li data-tab="tab2"><a href="javascript:void(0);">设 计</a></li>
			<li data-tab="tab3"><a href="javascript:void(0);">高 级</a></li>
		</ul>
		<div class="tab-content">
			<!-- 表单 -->
			<form id="form" action="<?php echo U('update');?>" method="post" class="form-horizontal doc-modal-form">
				<!-- 基础 -->
				<div id="tab1" class="tab-pane in tab1">
					<div class="form-item cf">
						<label class="item-label">模型标识<span class="check-tips">（请输入文档模型标识）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="name" value="<?php echo ($info["name"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">模型名称<span class="check-tips">（请输入模型的名称）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="title" value="<?php echo ($info["title"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">模型类型<span class="check-tips">（目前支持独立模型和文档模型）</span></label>
						<div class="controls">
							<select name="extend">
								<option value="0">独立模型</option>
								<option value="1">文档模型</option>
							</select>
						</div>
					</div>
				</div>

				<div id="tab2" class="tab-pane tab2">
					<div class="form-item cf">
						<label class="item-label">字段管理<span class="check-tips">（只有新增了字段，该表才会真正建立）</span></label>

						<div class="controls">
						<div class="form-item cf edit_sort edit_sort_l form_field_sort">
							<span>字段列表 		[ <a href="<?php echo U('Attribute/add?model_id='.$info['id']);?>" target="_balnk">新增</a>
							<a href="<?php echo U('Attribute/index?model_id='.$info['id']);?>" target="_balnk">管理</a> ] </span>
							<ul class="dragsort">
								<?php if(is_array($fields)): foreach($fields as $k=>$field): ?><li >
											<em ><?php echo ($field['title']); ?> [<?php echo ($field['name']); ?>]</em>
										</li><?php endforeach; endif; ?>
							</ul>
						</div>

						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">表单显示分组<span class="check-tips">（用于表单显示的分组，以及设置该模型表单排序的显示）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="field_group" value="<?php echo ($info["field_group"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
					<label class="item-label">表单显示排序<span class="check-tips">（直接拖动进行排序）</span></label>
					<?php $_result=parse_field_attr($info['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="form-item cf edit_sort edit_sort_l form_field_sort">
							<span><?php echo ($vo); ?></span>
							<ul class="dragsort needdragsort" data-group="<?php echo ($key); ?>">
								<?php if(is_array($fields)): foreach($fields as $k=>$field): if((($field['group'] == $key) or($i == 1 and !isset($field['group']))) and ($field['is_show'] == 1)): ?><li class="getSort">
											<em data="<?php echo ($field['id']); ?>"><?php echo ($field['title']); ?> [<?php echo ($field['name']); ?>]</em>
											<input type="hidden" name="field_sort[<?php echo ($key); ?>][]" value="<?php echo ($field['id']); ?>"/>
										</li><?php endif; endforeach; endif; ?>
							</ul>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>

					<div class="form-item cf">
						<label class="item-label">列表定义<span class="check-tips">（默认列表模板的展示规则）</span></label>
						<div class="controls">
							<label class="textarea input-large">
								<textarea name="list_grid"><?php echo ($info["list_grid"]); ?></textarea>
							</label>
						</div>
					</div>

					<div class="form-item cf">
						<label class="item-label">默认搜索字段<span class="check-tips">（默认列表模板的默认搜索项）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="search_key" value="<?php echo ($info["search_key"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">高级搜索字段<span class="check-tips">（默认列表模板的高级搜索项）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="search_list" value="<?php echo ($info["search_list"]); ?>">
						</div>
					</div>
				</div>

				<!-- 高级 -->
				<div id="tab3" class="tab-pane tab3">
					<div class="form-item cf">
						<label class="item-label">列表模板<span class="check-tips">（自定义的列表模板，放在Application\Admin\View\Think下，不写则使用默认模板）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="template_list" value="<?php echo ($info["template_list"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">新增模板<span class="check-tips">（自定义的新增模板，放在Application\Admin\View\Think下，不写则使用默认模板）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="template_add" value="<?php echo ($info["template_add"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">编辑模板<span class="check-tips">（自定义的编辑模板，放在Application\Admin\View\Think下，不写则使用默认模板）</span></label>
						<div class="controls">
							<input type="text" class="text input-large" name="template_edit" value="<?php echo ($info["template_edit"]); ?>">
						</div>
					</div>
					<div class="form-item cf">
						<label class="item-label">列表数据大小<span class="check-tips">（默认列表模板的分页属性）</span></label>
						<div class="controls">
							<input type="text" class="text input-small" name="list_row" value="<?php echo ($info["list_row"]); ?>">
						</div>
					</div>
				</div>

				<!-- 按钮 -->
				<div class="form-item cf">
					<label class="item-label"></label>
					<div class="controls edit_sort_btn">
						<input type="hidden" name="id" value="<?php echo ($info['id']); ?>"/>
						<button class="btn submit-btn ajax-post no-refresh" type="submit" target-form="form-horizontal">确 定</button>
						<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
					</div>
				</div>
			</form>
		</div>
	</div>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.onethink.cn" target="_blank">OneThink</a>管理平台</div>
                <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/index.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
<script type="text/javascript" src="/Public/static/jquery.dragsort-0.5.1.min.js"></script>
<script type="text/javascript" charset="utf-8">
Think.setValue("extend", <?php echo ((isset($info["extend"]) && ($info["extend"] !== ""))?($info["extend"]):0); ?>);

//导航高亮
highlight_subnav('<?php echo U('Model/index');?>');

$(function(){
	showTab();
})
//拖曳插件初始化
$(function(){
	$(".needdragsort").dragsort({
	     dragSelector:'li',
	     placeHolderTemplate: '<li class="draging-place">&nbsp;</li>',
	     dragBetween:true,	//允许拖动到任意地方
	     dragEnd:function(){
	    	 var self = $(this);
	    	 self.find('input').attr('name', 'field_sort[' + self.closest('ul').data('group') + '][]');
	     }
	 });
})
</script>

</body>
</html>