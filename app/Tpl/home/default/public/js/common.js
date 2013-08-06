$('.J_favs').live('click', function() {
	var $this = $(this);
	var id = $this.attr("data-id");
	$.get('index.php?m=user&a=favs_add', {
		id: id
	}, function(data) {
		$.ZhiPHP._tip({
			content: data.msg,
			status: data.status == 1
		});
		if (data.status == 1) {
			$this.html(data.data);
		}
	}, 'json');
});
$(document).ready(function() {
    $('#click_show').hover(function(){
        $('.content',this).show();
    },function(){
        $('.content',this).hide();
    });

  $('div.pic a.jky_buy_img img').each(function(){
    var $this=$(this);
    imgReady($this.attr('src'),function(){
      if(this.width>this.height){
        $this.addClass('img_h_220');
        $this.removeClass('img_w_220');
      }
    });
  });

});