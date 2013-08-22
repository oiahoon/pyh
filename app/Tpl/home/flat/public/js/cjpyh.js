(function($) {
	// $(".tile img").each(function(index, el) {
	// 	var $this = $(this);
	// 	var $detail = $this.siblings('.item-detail')
	// 	$this.mousemove(function(event) {
	// 		$detail.attr('style', 'display:block');
	// 		$detail.animate({
				
	// 			top: '8px' ,
	// 		},'normal');
	// 	});
		
	// 	$this.parent('div.tile').mouseout(function(event) {
	// 		$detail.animate({
	// 			display: 'none',
	// 			top: '313px' ,
	// 		},'fast');
	// 		$detail.attr('style', 'display:none');
	// 	});
	// });
	
	/* 详情提示  */
    $("[data-toggle=detailtip]").tooltip("hide");

    // fix sub nav on scroll
    var $win = $(window)				//窗口对象
      , $topnav = $('.top-nav')			//顶部nav
      , $nav = $('.subnav')				//子nav
      , navTop = $('.subnav').length && $('.subnav').offset().top - 20
      , isFixed = 0
      , $winH = $win.height()				//获取窗口高度
	  , $img = $(".span-item img.item-image")
	  , $imgH = parseInt($img.height()/2)	//图片到一半的时候显示
	  , $srcDef = "/pyh/app/Tpl/home/flat/public/images/thumb.gif"

    processScroll()								//页面初始化
    $win.on('scroll', processScroll)			//页面滚动时

    $("#back-top").hide();
	
	$('#back-top a').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	$(".span-item").mouseover(function(event) {
		$(this).children('.bdshare').show();//removeClass('bdshare-hidden').addClass('bdshare-display');
	})
					.mouseleave(function(event) {
		$(this).children('.bdshare').hide(500);//removeClass('bdshare-display').addClass('bdshare-hidden');
	});
					
    function processScroll() {
    	/* 动态fix分类 */
		var i, scrollTop = $win.scrollTop()
		if (scrollTop >= navTop && !isFixed) {
		isFixed = 1
		$nav.addClass('subnav-fixed')
		// $topnav.removeClass('navbar-fixed-top')	//隐藏顶部nav
		} else if (scrollTop <= navTop && isFixed) {
		isFixed = 0
		$nav.removeClass('subnav-fixed')
		// $topnav.addClass('navbar-fixed-top')
		}
		/* 动态加载当前屏幕的图片 */
		$img.each(function(i){//遍历img
			var $src = $img.eq(i).attr("data-src");//获取当前img URL地址
			var $scroTop = $img.eq(i).offset();//获取图片位置
			if($scroTop.top + $imgH >= $(window).scrollTop() && $(window).scrollTop() + $winH >= $scroTop.top + $imgH){//判断窗口至上往下的位置
				if($img.eq(i).attr("src") == $srcDef){
					$img.eq(i).hide();
				}
				$img.eq(i).attr("src",function(){return $src}).fadeIn(300);//元素属性交换
			}
		});
		
		if (scrollTop > 100) {
			$('#back-top').fadeIn();
		} else {
			$('#back-top').fadeOut();
		}
    }
})(jQuery);