<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
.ad_focus{ width:<?php echo ($board_info["width"]); ?>px; height:<?php echo ($board_info["height"]); ?>px; position:relative; overflow:hidden;}
.ad_focus ul{ position:relative; z-index:5;}
.ad_focus ul li{ position:absolute; display:none;}
.ad_focus .num{ position:absolute;right:10px; bottom:10px; z-index:10;}
.ad_focus .num a{ width:15px; height:15px; line-height:15px; display:inline-block; text-align:center; margin:0 3px; cursor:pointer; text-decoration:none; background:#FFF;}
.ad_focus .num a.cur{ background:#ff6700;color:#fff;}
</style>

<!--广告焦点图-->
<div class="ad_focus">
    <ul>
        <?php if(is_array($ad_list)): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><li <?php if($i == 1): ?>style="display:block;"<?php endif; ?>>
            <?php echo ($ad["html"]); ?>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="num">
        <?php if(is_array($ad_list)): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ad): $mod = ($i % 2 );++$i;?><a <?php if($i == 1): ?>class="cur"<?php endif; ?>><?php echo ($i); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<script type="text/javascript">
$(function(){
    var sw = 0;
    $(".ad_focus .num a").mouseover(function(){
        sw = $(".num a").index(this);
        myShow(sw);
    });
    function myShow(i){
        $(".ad_focus .num a").eq(i).addClass("cur").siblings("a").removeClass("cur");
        $(".ad_focus ul li").eq(i).stop(true,true).fadeIn(600).siblings("li").fadeOut(600);
    }
    //滑入停止动画，滑出开始动画
    $(".demo").hover(function(){
        if(myTime){
           clearInterval(myTime);
        }
    },function(){
        myTime = setInterval(function(){
          myShow(sw)
          sw++;
          if(sw==3){sw=0;}
        } , 3000);
    });
    //自动开始
    var myTime = setInterval(function(){
       myShow(sw)
       sw++;
       if(sw==3){sw=0;}
    } , 3000);
});
</script>