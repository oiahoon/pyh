<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html xmlns:wb="http://open.weibo.com/wb"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link href="__ROOT__/bootstrap/bootstrap.min.css" rel="stylesheet" media="screen"><link rel="stylesheet" type="text/css" href="__ROOT__/static/css/default/css/base.css" /><link rel="stylesheet" type="text/css" href="__ROOT__/static/css/default/css/style.css" /><script type="text/javascript" src="__ROOT__/static/js/jquery/jquery.js"></script><script type="text/javascript" src="__ROOT__/static/js/jquery/plugins/jquery.cookie.js"></script><script type="text/javascript" src="__ROOT__/static/js/common.js"></script><title>cjpyh bootstrap <?php echo ($page_seo["title"]); ?></title><meta name="keywords" content="<?php echo ($page_seo["keywords"]); ?>" /><meta name="description" content="<?php echo ($page_seo["description"]); ?>" /><script type="text/javascript"><?php if($visitor): ?>var IS_LOGIN=true;
    <?php else: ?>    var IS_LOGIN=false;<?php endif; ?>    var def=<?php echo ($def); ?>;
	</script></head><body><script src="http://code.jquery.com/jquery.js"></script><script src="__ROOT__/bootstrap/js/bootstrap.min.js"></script><!--头部开始--><div class="header_wrap"><div class="headertopbox"><div class="headertop clearfix"><div class="toplogo fl"><a href="./"><img class="fl" src="./data/upload/misc/<?php echo c('pin_site_logo');?>"/></a></div><?php if(empty($visitor)): ?><div class="login" id="nologin"><a href="<?php echo u('user/register');?>" class="regbtn">注册</a><div class="loginbtn"><a href="<?php echo u('user/login');?>" class="login_btn">登录</a><ul class="loginsub"><li class="wzdl"><a href="<?php echo u('user/login');?>">网站登录</a></li><li class="dsfdl">第三方登录</li><?php if(is_array($oauth_list)): $i = 0; $__LIST__ = $oauth_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="<?php echo ($val["code"]); ?>" style="background-image: url('static/images/oauth/<?php echo ($val["code"]); ?>/icon.png');"><a href="<?php echo u('oauth/index',array('mod'=>$val['code']));?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div></div><?php else: ?><div class="login" id="yetlogin"><span><?php echo ($visitor["username"]); ?>欢迎您！</span>|
                <a href="<?php echo u('user/index');?>">个人中心</a>|
                <a href="<?php echo u('user/logout');?>">注销</a></div><?php endif; ?><div class="topRightShare"><!-- Baidu Button BEGIN --><div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"><span class="fl" style="display: block;padding-top: 6px;">分享到：</span><a class="bds_qzone"></a><a class="bds_tsina"></a><a class="bds_tqq"></a><span class="bds_more"></span></div><script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=758194" ></script><script type="text/javascript" id="bdshell_js"></script><script type="text/javascript">    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script><!-- Baidu Button END --></div><div class="menutop"><ul><li><a href="<?php echo u('mall/index');?>" target="_blank">商家导航</a>|</li><li><a href="<?php echo u('post/submit');?>" target="_blank">我要爆料</a></li></ul></div></div></div><!--推荐类别开始--><div class="sidebox"><div class="side_head"><h3><a href="<?php echo u('post_cate/index',array('id'=>1));?>">推荐类别</a></h3></div><div class="side_body"><ul><?php if(is_array($recommend_cate)): $i = 0; $__LIST__ = $recommend_cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="sub<?php echo ($i); ?>"><a href="<?php echo u('post_cate/index',array('id'=>$val['id']));?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="side_foot"></div></div><!--推荐类别结束--></div><div class="main_content" style="padding-bottom: 0px;"><div id="main" style="z-index: 1000;"><div class="clearfix"><div class="logo"><a href="./">高性价比产品网购推荐，值得您经常来看看</a></div><div class="topAd"><div class="not_left_ce"><span class="not_a1" onmouseout="gstart()" onmouseover="gstop()" style="cursor:pointer;" onclick="goup()"><img src="http://www.smzdm.com/wp-content/themes/smzdm_v4/images/notice_left.png"></span><span class="not_a2" onmouseout="gstart()" onmouseover="gstop()" style="cursor:pointer;" onclick="godown()"><img src="http://www.smzdm.com/wp-content/themes/smzdm_v4/images/notice_right.png"></span></div><div id="news"><ul id="topAd" onmouseout="gstart()" onmouseover="gstop()" style="margin-top: 0px;"><?php if(is_array($gonggao_list)): $i = 0; $__LIST__ = $gonggao_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a href="<?php echo u('article/index',array('id'=>$val['id']));?>" target="_blank"><?php echo ($val["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div></div></div><div class="navbox"><div class="nav"><ul><li class="home"><a class="navicon current" href="./">首页</a></li><li class="tese J_top dropdown-submenu"><a class="navicon" href="<?php echo u('post_cate/index',array('id'=>2));?>">特色推荐</a><ul class="sub_menu dropdown-menu"><?php if(is_array($tese_cate)): $i = 0; $__LIST__ = $tese_cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a href="<?php echo u('post_cate/index',array('id'=>$val['id']));?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></li><?php if(is_array($main_nav_list)): $i = 0; $__LIST__ = $main_nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="<?php echo ($val["alias"]); ?>"><a class="navicon" href="<?php echo ($val["link"]); ?>" <?php if($val['target'] == 1): ?>target="_blank"<?php endif; ?>><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><div class="search fl"><form method="get" id="searchform" action="/"><input class="input_l" type="text" name="keyword" id="keyword" value="<?php echo ($search["keyword"]); ?>"/><input type="hidden" name="m" value="index"/><input type="hidden" name="a" value="index"/><input class="input_r" type="submit" name="" value=""/></form></div></div></div></div></div><!--头部结束--><!--内容页开始--><div class="main_content"><!--主部开始--><div id="main"><div class="contentbox clearfix"><div class="contentbox_l fl"><div class="leftinfo"><?php echo R('advert/index', array(1), 'Widget'); if($search['keyword']): ?><div class="clearfix crumbBox">当前位置:<a href="/">首页</a>>><strong>"<?php echo ($search["keyword"]); ?>"</strong>的搜索结果</div><?php endif; ?><div class="showinfo"><?php if(empty($search['keyword'])): ?><div class="hotactivity"><ul class="clearfix"><li class="hotTitle">当前热门活动</li><?php if(is_array($hot_list)): $i = 0; $__LIST__ = $hot_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a href="<?php echo u('post/index',array('id'=>$val['id']));?>" <?php if($val['tcolor']): ?>style="color: <?php echo ($val["tcolor"]); ?>;"<?php endif; ?> target="_blank" title="<?php echo ($val["title"]); ?>"><?php echo ($val["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><?php if(is_array($recommend_list)): $i = 0; $__LIST__ = $recommend_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="leftNotice"><h3><a href="<?php echo u('post/index',array('id'=>$val['id']));?>" target="_blank"><?php echo ($val["title"]); ?></a><span><?php echo ($val["prices"]); ?></span></h3></div><?php endforeach; endif; else: echo "" ;endif; endif; ?><!--产品展示方式开始--><div class="product_show" id="J_waterfall" data-uri="__ROOT__/index.php?m=<?php echo MODULE_NAME;?>&a=index&sort=<?php echo ($sort); ?>&p=<?php echo ($p); ?>&keyword=<?php echo ($search["keyword"]); ?>"><?php if(is_array($post_list)): $i = 0; $__LIST__ = $post_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="showitem J_item"><div class="showcont clearfix"><div class="showitemTitle clearfix"><h3 class="fl" sp="<?php echo ($req["sp"]); ?>"><a href="<?php echo post_url($val['id'],$val['post_key']);?>" target="_blank" <?php if($val['tcolor']): ?>style="color: <?php echo ($val["tcolor"]); ?>;"<?php endif; ?>><?php echo ($val["title"]); ?><span>&nbsp;&nbsp;<?php echo ($val["prices"]); ?></span></a></h3><div class="showitemTime"><?php echo date("m-d H:i",$val['add_time']);?></div></div><div style="width: 684px;height: 100%;"><div class="showcont_l fl"><div class="showtext"><div class="showtext_head clearfix"><span class="fl">分类：
                            <?php if(is_array($val['cate_list'])): $i = 0; $__LIST__ = $val['cate_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><a href="<?php echo u('post_cate/index',array('id'=>$c['cate_id']));?>" target="_blank"><?php echo ($c["cate"]["name"]); ?></a><?php if($i < count($val['cate_list'])): ?>,<?php endif; endforeach; endif; else: echo "" ;endif; ?></span><span class="fr">推荐人：<?php echo ($val["uname"]); ?></span></div></div></div><div class="showcont_r fr"><div class="product"><div class="like"><div class="collect"><a class="J_favs" data-id="<?php echo ($val["id"]); ?>"><?php echo ($val["favs"]); ?></a></div><div class="commentCount"><a href="<?php echo u('post/index',array('id'=>$val['id']));?>#J_messagebox"><?php echo ($val["comments"]); ?></a></div></div><div class="pro_img"><a href="<?php echo u('post/index',array('id'=>$val['id']));?>" class="proimg_pic"><img src="./data/upload/post/<?php echo ($val["img"]); ?>"/></a></div><div class="zhida" ><!-- <a rel="nofollow" href="<?php echo u('index/go',array('id'=>$val['id']));?>" class="border_radius_3" target="_blank">直 达 链 接</a> --><a rel="nofollow" href="go/<?php echo ($val["id"]); ?>" class="border_radius_3" target="_blank">直 达 链 接</a></div></div><div class="mall"><span>商城:<?php echo ($val["mall"]["title"]); ?></span></div></div><div class="showtext_body fl showcont_l"><?php echo ($val["info"]); ?></div><div class="clearfix toggle_wrap showcont_l" style="text-align: right;"><a onclick="toggle_content($(this))" class="short_content">展开全文</a></div></div></div><div class="score clearfix"><div class="score_l fl"><span class="evaluate_text">评价文本</span><div class="worth fl"><a class="worth_1" data-id="<?php echo ($val["id"]); ?>" data-type="rate_best" href="javascript:;" title="超值"><?php echo ($val["rate_best"]); ?></a><a class="worth_2" data-id="<?php echo ($val["id"]); ?>" data-type="rate_good" href="javascript:;" title="一般值"><?php echo ($val["rate_good"]); ?></a><a class="worth_3" data-id="<?php echo ($val["id"]); ?>" data-type="rate_bad" href="javascript:;" title="不值"><?php echo ($val["rate_bad"]); ?></a></div><span class="rating_text" id="J_rate_result_<?php echo ($val["id"]); ?>"><?php echo ($val["rate_best"]+$val["rate_good"]+$val["rate_bad"]); ?>位网友中的 <i><?php echo ($val["rate_best"]+$val["rate_good"]); ?></i> 位认为值得买！</span></div><div class="score_r fr"><!-- Baidu Button BEGIN --><div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" data="{'bdDes':'<?php echo ($val["title"]); ?>','text':'<?php echo ($val["title"]); ?>',pic:'http://<?php echo ($server["HTTP_HOST"]); ?>/data/upload/post/<?php echo ($val["img"]); ?>'}"><span class="fl" style="display: block;padding-top: 6px;">分享到：</span><a class="bds_qzone"></a><a class="bds_tsina"></a><a class="bds_tqq"></a><span class="bds_more"></span></div><script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=758194" ></script><script type="text/javascript" id="bdshell_js"></script><!-- Baidu Button END --></div></div></div><?php endforeach; endif; else: echo "" ;endif; ?></div><?php if(isset($show_load)): ?><div id="J_wall_loading" class="wall_loading tc gray"><span><?php echo L('loading');?></span></div><?php endif; if(isset($page_bar)): ?><div id="J_wall_page" class="wall_page" <?php if(isset($show_page)): ?>style="display:block;"<?php endif; ?>><div class="page"><?php echo ($page_bar); ?></div></div><?php endif; ?></div></div></div><div class="contentbox_r fr"><div class="rightinfo" id="rightinfo" style="height: 2000px;"><div class="blank"></div><div style="margin: 0px auto;"><?php if(C('pin_sina_follow_code')): ?><style type="text/css">    .WB_widget{
        width: 130px;
        overflow: hidden;
        float: left;
    }
    </style><script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script><?php echo C('pin_sina_follow_code'); endif; if(C('pin_qq_follow_code')): echo C('pin_qq_follow_code'); endif; ?></div><!-- Baidu Button BEGIN --><div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><a class="bds_taobao"></a><span class="bds_more"></span></div><script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script><script type="text/javascript" id="bdshell_js"></script><script type="text/javascript">document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script><!-- Baidu Button END --><?php if(MODULE_NAME == 'post'): echo R('advert/index', array(16), 'Widget'); else: echo R('advert/index', array(15), 'Widget'); endif; ?><div class="J_fixed" style="width: 250px;"><dl><dt class="clearfix"><h3 class="fl">最新内容</h3><a class="fr" href="<?php echo u('post_cate/index');?>" target="_blank">更多</a></dt><dd class="clearfix"><?php if(is_array($new_post_list)): $i = 0; $__LIST__ = $new_post_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a href="<?php echo u('post/index',array('id'=>$val['id']));?>" target="_blank"><img src="data/upload/post/<?php echo ($val["img"]); ?>"/></a><?php endforeach; endif; else: echo "" ;endif; ?></dd></dl><?php if(MODULE_NAME == 'post'): echo R('advert/index', array(3), 'Widget'); else: echo R('advert/index', array(2), 'Widget'); endif; ?></div><script type="text/javascript">$(function() {       
    if($.browser.safari){
        var orig_top=$('.J_fixed').offset().top;
        var offset=40;
        $(window).scroll(function(){
            var $jfix=$('.J_fixed');
            var scroll=$('body').scrollTop(); 
            var top=$jfix.offset().top-orig_top+40;
            var max_scroll=$('#J_waterfall').height()+400;
            //console.log('scroll:'+scroll+',top:'+top);
//            console.log('bottom:'+(top+$jfix.height())+",max_scroll:"+max_scroll);
            
            if(scroll<=orig_top){
                $jfix.css({
                    'position':'static'               
                });
            }
            else if(scroll>top&&$jfix.css('position')!='absolute'){
                if(scroll<max_scroll){
                    $jfix.css({
                        'position':'fixed',
                        'top':offset+'px',
                        'bottom':'auto',
                        'right':'auto'
                    });                
                }else{                
                    $jfix.css({
                        'position':'absolute',
                        'bottom':'20px',
                        'right':'20px',
                        'top':'auto'
                    });   
                }            
            }
            else if(scroll<top&&$jfix.css('position')=='absolute'){
                $jfix.css({
                    'position':'fixed',
                    'top':offset+'px',
                    'bottom':'auto',
                    'right':'auto'
                });  
            }      
        });          
    }else{
        $('.J_fixed').stickyScroll({bottomBoundary: 1116,topBoundary:270});
    }  
});
</script></div></div></div></div><!--主部结束--></div><div class="main_content"><div id="main"><?php echo R('advert/index', array(17), 'Widget');?></div></div><!--尾部开始--><div class="footer_wrap"><div id="footer"><div class="footercon"><ul class="help_list clearfix"><li class="item"><h3>发现值得买</h3><a href="<?php echo u('post_cate/index',array('id'=>2));?>">什么值得买</a><a href="<?php echo u('post_cate/index',array('id'=>4));?>">海外淘购</a><a href="<?php echo u('mall/index');?>">返利商家</a><a href="<?php echo u('post/submit');?>">我要爆料</a></li><li class="item"><h3>获取帮助</h3><a href="faq.html">常见问题</a><a href="fanli.html">商城返利</a><a href="weixin.html">微信二维码</a></li><li class="toplogo item"><a href="/" class=""><img class="fl" src="./data/upload/misc/<?php echo c('pin_site_logo');?>"/></a></li><li class="item"><h3>关于网站</h3><a href="about.html">关于我们</a><a href="contact.html">联系我们</a><a href="friends.html">合作伙伴</a><a href="flink.html">友情链接</a><a href="partner.html">商务合作</a></li><?php echo R('advert/index', array(8), 'Widget');?></ul><div class="flink"><strong>友情链接：</strong><?php if(is_array($flink_list)): $i = 0; $__LIST__ = $flink_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a href="<?php echo ($val["url"]); ?>" target="_blank"><?php echo ($val["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></div><p>© copyright 2010-2013 <?php echo C("pin_site_name");?>. All rights reserved. </p><p><?php echo C("pin_site_icp"); echo C("pin_statistics_code");?></p></div></div></div><!--尾部结束--><script>var PINER = {
    root: "__ROOT__",
    uid: "<?php echo $visitor['id'];?>", 
    async_sendmail: "<?php echo $async_sendmail;?>",
    config: {
        wall_distance: "<?php echo C('pin_wall_distance');?>",
        wall_spage_max: "<?php echo C('pin_wall_spage_max');?>"
    },
    //URL
    url: {}
};
//语言项目
var lang = {};
<?php $_result=L('js_lang');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>lang.<?php echo ($key); ?> = "<?php echo ($val); ?>";<?php endforeach; endif; else: echo "" ;endif; ?></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.tools.min.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.masonry.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.scrollTo.min.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/formvalidator.js"></script><script type="text/javascript" src="__STATIC__/js/jquery/plugins/jquery.stickyscroll.js"></script><script type="text/javascript" src="__STATIC__/js/fileuploader.js"></script><script type="text/javascript" src="__STATIC__/js/zhiphp.js"></script><script type="text/javascript" src="__STATIC__/js/front.js"></script><script type="text/javascript" src="__STATIC__/js/dialog.js"></script><script type="text/javascript" src="__STATIC__/js/wall.js"></script><script type="text/javascript" src="__STATIC__/js/comment.js"></script><script type="text/javascript" src="__STATIC__/js/user.js"></script><script type="text/javascript" src="__STATIC__/js/setting.js"></script><script type="text/javascript" src="__STATIC__/js/brivio.validate.js"></script></body></html>