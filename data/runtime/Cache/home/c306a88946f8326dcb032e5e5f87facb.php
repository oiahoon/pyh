<?php if (!defined('THINK_PATH')) exit(); if(is_array($post_list)): $i = 0; $__LIST__ = $post_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="showitem J_item">
    <div class="showcont clearfix">
        <div class="showitemTitle clearfix">
            <h3 class="fl" sp="<?php echo ($req["sp"]); ?>"><a href="<?php echo post_url($val['id'],$val['post_key']);?>" target="_blank" <?php if($val['tcolor']): ?>style="color: <?php echo ($val["tcolor"]); ?>;"<?php endif; ?>><?php echo ($val["title"]); ?><span>&nbsp;&nbsp;<?php echo ($val["prices"]); ?></span></a></h3>
            <div class="showitemTime"><?php echo date("m-d H:i",$val['add_time']);?></div>
        </div>
        <div style="width: 684px;height: 100%;">
            <div class="showcont_l fl">
                <div class="showtext">
                    <div class="showtext_head clearfix">
                        <span class="fl">分类：
                            <?php if(is_array($val['cate_list'])): $i = 0; $__LIST__ = $val['cate_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><a href="<?php echo u('post_cate/index',array('id'=>$c['cate_id']));?>" target="_blank"><?php echo ($c["cate"]["name"]); ?></a>
                            <?php if($i < count($val['cate_list'])): ?>,<?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </span>
                        <span class="fr">推荐人：<?php echo ($val["uname"]); ?></span>
                    </div>
                </div>
            </div>
            <div class="showcont_r fr">
                <div class="product">
                    <div class="like">
                        <div class="collect"><a class="J_favs" data-id="<?php echo ($val["id"]); ?>"><?php echo ($val["favs"]); ?></a></div>
                        <div class="commentCount">
                            <a href="<?php echo u('post/index',array('id'=>$val['id']));?>#J_messagebox"><?php echo ($val["comments"]); ?></a>
                        </div>
                    </div>
                    <div class="pro_img">
                        <a href="<?php echo u('post/index',array('id'=>$val['id']));?>" class="proimg_pic"><img src="./data/upload/post/<?php echo ($val["img"]); ?>"/></a>
                    </div>
                    <div class="zhida" >
                        <!-- <a rel="nofollow" href="<?php echo u('index/go',array('id'=>$val['id']));?>" class="border_radius_3" target="_blank">直 达 链 接</a> -->
                        <a rel="nofollow" href="go/<?php echo ($val["id"]); ?>" class="border_radius_3" target="_blank">直 达 链 接</a>
                    </div>
                </div>
                <div class="mall"><span>商城:<?php echo ($val["mall"]["title"]); ?></span></div>
            </div>
            <div class="showtext_body fl showcont_l">
                <?php echo ($val["info"]); ?>
            </div>
            <div class="clearfix toggle_wrap showcont_l" style="text-align: right;">
                <a onclick="toggle_content($(this))" class="short_content">展开全文</a>                    
            </div>                
        </div>        
    </div>
    <div class="score clearfix">
        <div class="score_l fl">
            <span class="evaluate_text">评价文本</span>
            <div class="worth fl">
                <a class="worth_1" data-id="<?php echo ($val["id"]); ?>" data-type="rate_best" href="javascript:;" title="超值"><?php echo ($val["rate_best"]); ?></a>
                <a class="worth_2" data-id="<?php echo ($val["id"]); ?>" data-type="rate_good" href="javascript:;" title="一般值"><?php echo ($val["rate_good"]); ?></a>
                <a class="worth_3" data-id="<?php echo ($val["id"]); ?>" data-type="rate_bad" href="javascript:;" title="不值"><?php echo ($val["rate_bad"]); ?></a>
            </div>
            <span class="rating_text" id="J_rate_result_<?php echo ($val["id"]); ?>"><?php echo ($val["rate_best"]+$val["rate_good"]+$val["rate_bad"]); ?>位网友中的 <i><?php echo ($val["rate_best"]+$val["rate_good"]); ?></i> 位认为值得买！</span>
        </div>
        <div class="score_r fr">
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" data="{'bdDes':'<?php echo ($val["title"]); ?>','text':'<?php echo ($val["title"]); ?>',pic:'http://<?php echo ($server["HTTP_HOST"]); ?>/data/upload/post/<?php echo ($val["img"]); ?>'}">
                <span class="fl" style="display: block;padding-top: 6px;">分享到：</span>
                <a class="bds_qzone"></a>
                <a class="bds_tsina"></a>
                <a class="bds_tqq"></a>
                <span class="bds_more"></span>
            </div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=758194" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <!-- Baidu Button END -->
        </div>
    </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>