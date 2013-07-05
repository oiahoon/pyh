<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="__ROOT__/bootstrap/css/bootstrap.min.css" />
    	
    <title>cjpyh bootstrap <?php echo ($page_seo["title"]); ?></title>    
    <meta name="keywords" content="<?php echo ($page_seo["keywords"]); ?>" />
    <meta name="description" content="<?php echo ($page_seo["description"]); ?>" />    
	<script type="text/javascript">	
    <?php if($visitor): ?>var IS_LOGIN=true;
    <?php else: ?>
    var IS_LOGIN=false;<?php endif; ?>    
    var def=<?php echo ($def); ?>;
   
	</script>
    <link rel="stylesheet" type="text/css" href="__ROOT__/bootstrap/css/bootstrap-responsive.min.css" />   
    <style>
    body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    .sidebar-nav {
        padding: 9px 0;
      }
    .sidebar {
        position: absolute;
        top: 100px;
        left: 30px;
    }
    @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    .hotactivity {
        margin: 5px 0;
        padding: 12px 0px 10px;
        background-color: #fff;
        border: 1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        }
    .hotactivity:after {
        content: "Example";
        position: absolute;
        top: -1px;
        left: -1px;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        color: #9da0a4;
        -webkit-border-radius: 4px 0 4px 0;
        -moz-border-radius: 4px 0 4px 0;
        border-radius: 4px 0 4px 0;
    }
    .hotactivity>ul>li {
        font-size: 12px;
        font-family: Arial,"SimSun";
        padding-left: 18px;
        height: 26px;
        width: 18%;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
        float: left;
        line-height: 26px;
    }
        /* Echo out a label for the example */
    .hotTitle { 
        width: 100%;
        height: 25px;
        line-height: 25px;
        font-family: "Microsoft YaHei","SimSun";
        font-size: 18px;
        font-weight: bold;
        color: #444;
        padding-left: 15px;
        }
    .productTitle {
        line-height: 20px;
    }
    .productTitle a {
        color: #000;
    }
    .productTitle a:hover {
        color: #000;
    }
    .dateTime {
        font-size: 14px;
        font-family: arial;
        width: 100px;
        color: #888;
        font-weight: normal;
        position: relative;
        top:-20px;
        right: 0;
        float: right;
        height: 0;
    }

    .bdshare {
        width: 188px;
    }
    #bdshare > p{
        padding-top: 6px!;
        width:auto!;
    }

    .ListRightBox {
        margin-bottom: 15px;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    .thumbnails>li {
         margin-left: 0px;
    }

    .like {

        float: left;
        width: 100%;
        height: 36px;
        background: #fff;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        margin: 0;
        padding: 0;
    }
    .like > li {
        text-align: center;
        line-height: 36px;
    }
    .like > li:hover{
        background: #08c;
    }
    .like > li > a {
        display: block;
        text-decoration: none;
        color: #555;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.2);
    }
    .like > li > a:hover {
        color: #fff;
    }
    .collect{
        -webkit-border-radius: 6px 0px 0 0;
        -moz-border-radius: 6px 0px 0 0;
        border-radius: 6px 0px 0 0;
        border-top-left-radius: 6px;
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
    }
    .commentCount {
        -webkit-border-radius: 0px 6px 0 0;
        -moz-border-radius: 0px 6px 0 0;
        border-radius: 0px 6px 0 0;
        border-top-left-radius: 0px;
        border-top-right-radius: 6px;
        border-bottom-right-radius: 0px;
        border-bottom-left-radius: 0px;
    }
    .forward {
         -webkit-border-radius: 0 0 6px 6px;
        -moz-border-radius: 0 0 6px 6px;
        border-radius: 0 0 6px 6px;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
        border-bottom-right-radius: 6px;
        border-bottom-left-radius: 6px;
        margin-top:-26px;
        line-height: 36px;
        background: #fff;
        cursor: pointer;
        text-align: center;
    }
    .forward > a {
        display: block;
        text-decoration: none;
        color: #555;
        text-shadow: 0 -1px 0 rgba(0,0,0,0.2);
    }
    .forward > a:hover {
        color: #fff;
    }
    .forward:hover{
        color:#fff;
        background: #08c;
    }
    .shop {
        text-align: center;
    }
    </style> 
    
</head>
<body>
    
<!--头部开始-->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <div class="span8 offset4">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="/"><?php echo ($page_seo["title"]); ?></a>
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">  
                <li class="divider-vertical"></li> 
                    <?php if(empty($visitor)): ?><li>
                            <ul class="nav">
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">登录<b class="caret"></b></a>
                                <ul class="dropdown-menu" style="float:left;">
                                    <li><a href="<?php echo u('user/login');?>">网站登录</a></li>
                                    <li>第三方登录</li>
                                    <?php if(is_array($oauth_list)): $i = 0; $__LIST__ = $oauth_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a href="<?php echo u('oauth/index',array('mod'=>$val['code']));?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo u('user/register');?>" class="regbtn">注册</a>
                        </li>
                        <li class="divider-vertical"></li>
                    <?php else: ?>
                        <li>
                            <a href="#" class="navbar-link"><?php echo ($visitor["username"]); ?></a> 
                        </li>
                        <li>
                            <a href="<?php echo u('user/index');?>"><i class="icon-user"></i> 个人中心</a>
                        </li>
                        <li>
                            <a href="<?php echo u('user/logout');?>">注销</a>
                        </li><?php endif; ?>
                </li>
            </ul>
            <ul class="nav">
                <li class="active"><a href="./">首页</a></li>
                <li class="dropdown"><a href="<?php echo u('post_cate/index',array('id'=>2));?>" class="dropdown-toggle" data-toggle="dropdown" data-target="#">特色推荐<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if(is_array($tese_cate)): $i = 0; $__LIST__ = $tese_cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a href="<?php echo u('post_cate/index',array('id'=>$val['id']));?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </li>
            </ul>
          </div><!--/.nav-collapse -->
      </div>
        </div><!--/.container-fluid -->
      </div><!--/.navbar-inner -->
    </div><!--/.navbar navbar-inverse navbar-fixed-top -->

	<div class="span2 sidebar"> <!-- 2单位宽度的侧边 -->
          <div class="well sidebar-nav affix">
            <ul class="nav nav-list">
              <li class="nav-header"><a href="<?php echo u('post_cate/index',array('id'=>1));?>">推荐类别</a></li>
              <?php if(is_array($recommend_cate)): $i = 0; $__LIST__ = $recommend_cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="sub<?php echo ($i); ?>"><a href="<?php echo u('post_cate/index',array('id'=>$val['id']));?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

    <!--推荐类别开始 侧边栏-->
	<div class="container-fluid"> <!-- 流式布局 -->
      <div class="row-fluid"> <!-- 栅格布局 -->
        <div class="span8 offset2"> <!-- 建立一个10单位宽度的div 来做container -->
        
	<!--推荐类别结束 侧边栏-->
    <div class="span12">
        <div class="row">
            <div class="navbar">
              <div class="navbar-inner">
                <ul class="nav">
                    <li><a href="./"><i class="icon-home"></i> 首页</a></li><li class="divider-vertical"></li>
                    <li class="dropdown">
                    <a href="<?php echo u('post_cate/index',array('id'=>2));?>" class="dropdown-toggle" data-toggle="dropdown" data-target="#"><i class="icon-heart"></i> 特色推荐<b class="caret"></b>
                    </a>
                        <ul class="dropdown-menu">
                            <?php if(is_array($tese_cate)): $i = 0; $__LIST__ = $tese_cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><a href="<?php echo u('post_cate/index',array('id'=>$val['id']));?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </li>
                    <?php if(is_array($main_nav_list)): $i = 0; $__LIST__ = $main_nav_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li class="divider-vertical"></li>
                        <li class="<?php echo ($val["alias"]); ?>"><a class="navicon" href="<?php echo ($val["link"]); ?>" <?php if($val['target'] == 1): ?>target="_blank"<?php endif; ?>><i class="icon-th-large"></i> <?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <ul class="nav pull-right">
                        <li>
                        <form  method="get" id="searchform" action="/" class="navbar-search">
                        <div class="input-prepend">
                          <span class="add-on"><i class="icon-search"></i></span>
                          <input type="text" placeholder="搜索" value="<?php echo ($search["keyword"]); ?>">
                        </div>
                          <input type="hidden" name="m" value="index"/>
                          <input type="hidden" name="a" value="index"/>
                        </form>
                    </li>
                </ul>
              </div>
            </div>
        </div> <!-- /div row-->

<!--头部结束-->

<div class="row">
<!--内容页开始-->
<div class="span9">
<!--主部开始-->
    <!-- 暂时去掉导航下广告位 -->
    <?php if($search['keyword']): ?><div class="clearfix">当前位置:<a href="/">首页</a>>><strong>"<?php echo ($search["keyword"]); ?>"</strong>的搜索结果</div><?php endif; ?>
    <?php if(empty($search['keyword'])): ?><div class="row-fluid pull-left hotactivity"><!-- 热门活动 -->
	<span class="hotTitle">当前热门活动</span>
	<ul class="breadcrumb">
		<?php if(is_array($hot_list)): $i = 0; $__LIST__ = $hot_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>
				<a href="<?php echo u('post/index',array('id'=>$val['id']));?>" <?php if($val['tcolor']): ?>style="color: <?php echo ($val["tcolor"]); ?>;"<?php endif; ?> target="_blank" title="<?php echo ($val["title"]); ?>"><i class="icon-chevron-right"></i> <?php echo ($val["title"]); ?></a>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>

</div><?php endif; ?>

    <!-- 产品展示方式开始 -->
    <div class="row-fluid">
        <?php if(is_array($post_list)): $i = 0; $__LIST__ = $post_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="row-fluid span12">
    <div class="row-fluid">
        <div class="span12 productTitle">
            <h3 sp="<?php echo ($req["sp"]); ?>"><a href="<?php echo post_url($val['id'],$val['post_key']);?>" target="_blank" <?php if($val['tcolor']): ?>style="color: <?php echo ($val["tcolor"]); ?>;"<?php endif; ?>><?php echo ($val["title"]); ?><span class="badge badge-important">&nbsp;&nbsp;<?php echo ($val["prices"]); ?></span></a></h3>
        </div>
        <div class="span3 offset9 dateTime">
            <?php echo date("m-d H:i",$val['add_time']);?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span9">
            <div class="row-fluid">
                <div class="span8">
                    <p>分类：
                        <?php if(is_array($val['cate_list'])): $i = 0; $__LIST__ = $val['cate_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><a href="<?php echo u('post_cate/index',array('id'=>$c['cate_id']));?>" target="_blank"><?php echo ($c["cate"]["name"]); ?></a>
                            <?php if($i < count($val['cate_list'])): ?>,<?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </p>
                </div>
                <div class="span4">
                    <p class="text-right">推荐人：<?php echo ($val["uname"]); ?></p>
                </div>
            </div>
            <div class="row-fluid">
                <?php echo ($val["info"]); ?>
                <div class="span3 offset9">
                    <a onclick="toggle_content($(this))" class="short_content">展开全文<i class="icon-chevron-down"></i></a>
                </div>
            </div>
        </div>
        <div class="span3">
            <div class="row-fluid ListRightBox">
                <div class="row-fluid like">
                    <ul class="like">
                        <li class="span6 collect"><a href="#" data-id="<?php echo ($val["id"]); ?>"><?php echo ($val["favs"]); ?></a></li>
                        <li class="span6 commentCount"><a href="<?php echo u('post/index',array('id'=>$val['id']));?>#J_messagebox"><?php echo ($val["comments"]); ?></a></li>
                    </ul>
                    
                </div>
                <div class="row-fluid">
                    <ul class="thumbnails">
                        <li>
                            <a href="<?php echo u('post/index',array('id'=>$val['id']));?>" class="thumbnail"><img src="./data/upload/post/<?php echo ($val["img"]); ?>"/></a>
                        </li>
                    </ul>
                </div>
                <div class="row-fluid forward">
                    <a rel="nofollow" href="go/<?php echo ($val["id"]); ?>" class="border_radius_3" target="_blank">直 达 链 接 &gt;</a>
                </div>
                 <div class="row-fluid shop">
                    <span class="muted">商城：<?php echo ($val["mall"]["title"]); ?></span>
                </div>
            </div>
            
        </div>
    </div>
    <div class="row-fluid">
        <div class="span8">
            <ul class="inline">
                <li><p>评价本文<i class="icon-chevron-right"></i> </p></li>
                <li>
                    <a class="worth_1" data-id="<?php echo ($val["id"]); ?>" data-type="rate_best" href="javascript:;" title="超值"><?php echo ($val["rate_best"]); ?></a>
                    <a class="worth_2" data-id="<?php echo ($val["id"]); ?>" data-type="rate_good" href="javascript:;" title="一般值"><?php echo ($val["rate_good"]); ?></a>
                    <a class="worth_3" data-id="<?php echo ($val["id"]); ?>" data-type="rate_bad" href="javascript:;" title="不值"><?php echo ($val["rate_bad"]); ?></a>
                </li>
                <li>
                    <span id="J_rate_result_<?php echo ($val["id"]); ?>"><?php echo ($val["rate_best"]+$val["rate_good"]+$val["rate_bad"]); ?>位网友中的 <i><?php echo ($val["rate_best"]+$val["rate_good"]); ?></i> 位认为值得买！</span>
                </li>
            </ul>
        </div>
        <div class="bdshare pull-right">
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="span12 bdshare_t bds_tools get-codes-bdshare" data="{'bdDes':'<?php echo ($val["title"]); ?>','text':'<?php echo ($val["title"]); ?>',pic:'http://<?php echo ($server["HTTP_HOST"]); ?>/data/upload/post/<?php echo ($val["img"]); ?>'}">
                <p class="muted share_direction" style="width:auto;">分享到：</p>
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
      <div class="span9">
        <div class="page"><?php echo ($page_bar); ?></div>
      </div>
    </div>
</div>
<!-- 右侧栏 -->
<div class="span3">
     <div class="blank"></div>
<div style="margin: 0px auto;">
    <?php if(C('pin_sina_follow_code')): ?><style type="text/css">
    .WB_widget{
        width: 130px;
        overflow: hidden;
        float: left;
    }
    </style>
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
    <?php echo C('pin_sina_follow_code'); endif; ?>
    <?php if(C('pin_qq_follow_code')): echo C('pin_qq_follow_code'); endif; ?>
</div>

<!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
<a class="bds_tsina"></a>
<a class="bds_qzone"></a>
<a class="bds_tqq"></a>
<a class="bds_renren"></a>
<a class="bds_taobao"></a>
<span class="bds_more"></span>
</div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END -->
<?php if(MODULE_NAME == 'post'): echo R('advert/index', array(16), 'Widget');?>
<?php else: ?>
<?php echo R('advert/index', array(15), 'Widget'); endif; ?>

<div class="J_fixed" style="width: 250px;">
    <dl>
        <dt class="clearfix"><h3 class="fl">最新内容</h3><a class="fr" href="<?php echo u('post_cate/index');?>" target="_blank">更多</a></dt>
        <dd class="clearfix">
            <?php if(is_array($new_post_list)): $i = 0; $__LIST__ = $new_post_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><a href="<?php echo u('post/index',array('id'=>$val['id']));?>" target="_blank"><img src="data/upload/post/<?php echo ($val["img"]); ?>"/></a><?php endforeach; endif; else: echo "" ;endif; ?>
        </dd>
    </dl>
    <?php if(MODULE_NAME == 'post'): echo R('advert/index', array(3), 'Widget');?>
    <?php else: ?>
    <?php echo R('advert/index', array(2), 'Widget'); endif; ?>
</div>
<script type="text/javascript">
$(function() {       
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
</script> 
</div>

    <!--主部结束-->
</div>	
</div> <!-- /div row -->
</div> <!-- /span 8 offset 2 -->




</div><!--/span-->
  </div><!--/row--><div>
    <footer>
    <p>&copy; Company 2013</p>
</footer>
</div>
</div><!--/.fluid-container-->

 <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
    <script type="text/javascript" src="__ROOT__/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>