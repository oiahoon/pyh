<?php
class tagAction extends frontendAction {     
    public function index() {    
        $this->_assign_hot_list();
        
        $where="1 ";
        if(($id=$this->_get('id','intval'))>0){
            $this->assign('id',$id);        
          
            $info=D('tag')->where(array('id'=>$id))->find(); 
            $this->_config_seo(array('title'=>$info['name'].'_标签'));  
             
            $where.=" and (select count(t.post_id) from ".table('post_tag')." as t where id=t.post_id and t.tag_id=$id)>0 ";  
             
        }elseif($uname=$this->_get('uname','trim')){            
            $uname=$this->_get('uname','trim');
            $this->assign('uname',$uname);  
            
            $this->_config_seo(array('title'=>$uname.'_推荐的商品'));   
            $where.= " and uname='$uname'";          
        }
             
        $this->_waterfall(D("post"),$where." and status=1 and post_time<=".time(),'post_time desc');        
    }
}