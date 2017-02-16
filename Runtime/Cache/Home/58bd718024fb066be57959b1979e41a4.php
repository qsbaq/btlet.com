<?php if (!defined('THINK_PATH')) exit(); switch($addons_config["comment_type"]): case "1": ?><!-- UY BEGIN -->
		<div id="uyan_frame"></div>
		<script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=<?php echo ($addons["config"]["comment_uid_youyan"]); ?>"></script>
		<!-- UY END --><?php break;?>
	<?php case "2": ?><!-- Duoshuo Comment BEGIN -->
		<div class="ds-thread" data-form-positon="<?php echo ($addons_config["comment_form_pos_duoshuo"]); ?>" data-limit="<?php echo ($addons_config["comment_data_list_duoshuo"]); ?>" data-order="<?php echo ($addons_config["comment_data_order_duoshuo"]); ?>"></div>
		<script type="text/javascript">
		var duoshuoQuery = { short_name: "<?php echo ($addons_config["comment_short_name_duoshuo"]); ?>"};
			(function() {
				var ds = document.createElement('script');
				ds.type = 'text/javascript';ds.async = true;
				ds.src = 'http://static.duoshuo.com/embed.js';
				ds.charset = 'UTF-8';
				(document.getElementsByTagName('head')[0]
				|| document.getElementsByTagName('body')[0]).appendChild(ds);
			})();
			</script>
		<!-- Duoshuo Comment END --><?php break; endswitch;?>