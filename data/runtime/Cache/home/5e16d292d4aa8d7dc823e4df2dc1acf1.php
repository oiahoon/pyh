<?php if (!defined('THINK_PATH')) exit();?><li class="item">
    <h3>关注我们</h3>
    <?php if(is_array($ad_list)): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><a href="<?php echo U('advert/tgo', array('id'=>$ad['id']));?>" target="_blank"><img src="__UPLOAD__/advert/<?php echo ($ad["extimg"]); ?>" class="fl mr5" /><?php echo ($ad["html"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
</li>