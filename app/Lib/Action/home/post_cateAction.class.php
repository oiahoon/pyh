<?php
class post_cateAction extends frontendAction {     
    public function index() {
        $this->_assign_hot_list();
        $cate_id=intval($_REQUEST['id']);
        $title=trim($_REQUEST['title']);        
        $this->assign('id',$cate_id);
        $info=D("post_cate")->where(array('id'=>$cate_id))->find();
        $this->assign('info',$info);
        $this->_config_seo(C('pin_seo_config.cate'),array('cate_name'=>$info['name'],
                'seo_title'=>$info['seo_title'],
                'seo_keywords'=>$info['seo_keys'],
                'seo_description'=>$info['seo_desc']));         

        $where="(select count(c.post_id) from ".table('post_cate_re')." as c where id=c.post_id and c.cate_id in(".implode(',',D('post_cate')->get_child_ids($cate_id,true))."))>0 
            and status=1 and post_time<=".time();        
        $this->_waterfall(D("post"),$where,'post_time desc');        
    }
}