<?php
class jky_itemAction extends backendAction
{
    var $list_relation=true;
    
    public function _initialize() {
        parent::_initialize();
        $this->_cate_mod = D('jky_cate');        
        $this->assign('img_dir','./data/upload/jiukuaiyou/');
        $this->py = new cls_pinyin();
        $res=D("jky_orig")->select();
        foreach($res as $key=>$val){
            $orig_list[$val['id']]=$val['name'];
        }
        $this->assign("orig_list",$orig_list);
    }

    public function _before_index() {        
        $res = D("mall")->field('id,title')->select();
        $mall_list = array();
        foreach ($res as $val) {
            $mall_list[$val['id']] = $val['title'];
        }
        $this->assign('mall_list', $mall_list);        

        //默认排序
        $this->sort = 'id';
        $this->order = 'desc';
        
        $list=array();   
        $res=D("jky_cate")->field("id,name")->where("pid=1 and status=1")->select();
        foreach($res as $key=>$val){
            $list[$val['id']]=$val['name'];
        }
        $this->assign('type_list',$list);
        $list=array();
        $res=D("jky_cate")->field("id,name")->where("pid=2 and status=1")->select();
        foreach($res as $key=>$val){
            $list[$val['id']]=$val['name'];
        }
        $this->assign('cate_list',$list);
    }

    protected function _search() {
        $where.="1 ";
        ($time_start = $this->_request('time_start', 'trim')) && $map['stime'][] = array('egt', strtotime($time_start));
        ($time_end = $this->_request('time_end', 'trim')) && $map['etime'][] = array('elt', strtotime($time_end)+(24*60*60-1));
        $status = $this->_request('status'); 
        if($status!=null){
            $where.=" and status=$status ";
        }
        ($keyword = $this->_request('keyword', 'trim')) &&$where.=" and title like '%$keyword%'";
        
        $mall_id=$this->_request('mall_id','intval');
        if($mall_id>0){
            $where.=" and mall_id=$mall_id";  
        }
        $cate_id=$_REQUEST['cate_id'];
        for($i=0;$i<2;$i++){
            $cid=intval($cate_id[$i]);
            if($cid>0){
                $where.=" and (select count(c.item_id) from ".table("jky_cate_re")." as c where c.item_id=".table("jky_item").".id and c.cate_id=$cid)>0 ";
            }
        }
        $this->assign('search', array(
            'time_start' => $time_start,
            'time_end' => $time_end,
            'cate_id[0]' => $cate_id[0],
            'cate_id[1]' => $cate_id[1],
            'selected_ids' => $selected_ids,
            'status'  => $status,
            'keyword' => $keyword,
            'mall_id'=>$mall_id
        ));
        return $where;
    }
    protected function _get_cate_tree($list,$checked_ids=array()){
        $html="";
        foreach($list as $key=>$val){
            $margin_left=$val['depth']*20;
            $html.="<div style='margin-left:".$margin_left."px;'>
                <input type='checkbox'";
            if(in_array($val['id'],$checked_ids)){
                $html.=" checked='checked' ";
            }                
            $html.=" name='cate_id[]' value='$val[id]'/>&nbsp;&nbsp;$val[name]</div>";
            $html.=$this->_get_cate_tree($val['child'],$checked_ids);
        }
        return $html;
    }
    public function _before_add()
    {              
        $info['uname'] = $_SESSION['admin']['username'];  
                      
        $this->assign('info',$info);
        $cate_tree=$this->_get_cate_tree(get_cate_tree($this->_cate_mod));              
        $this->assign('cate_tree',$cate_tree);
        
        $ico_table=D('jky_icon_type');
        $ico_tree=$ico_table->where("`status`=1")->field("`title`,`id`")->select();
        $this->assign('ico_tree',$ico_tree);
                      
    }

    protected function _before_insert($data) {                
        //上传图片
        if (!empty($_FILES['img']['name'])) {
            $art_add_time = date('ym/d');
            $result = $this->_upload($_FILES['img'], 'jiukuaiyou/' . $art_add_time);
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $data['img'] = $art_add_time .'/'. $result['info'][0]['savename'];
            }
        }
        if(empty($data['post_key'])){
            $data['post_key']=$this->py->tourl($data['title']);
        }
        if(D("jky_item")->where(array('post_key'=>trim($data['post_key'])))->count()>0){
            $data['post_key'].='_'.time();
        }
        $data['post_key']=str_replace($this->spec_chars,'',$data['post_key']);
        $data['stime']=strtotime($_REQUEST['stime']);
        $data['etime']=strtotime($_REQUEST['etime']);
        $data['add_time']=time();
        return $data;
    }
  
    protected function _after_insert($id) {
        $cids=$_REQUEST['cate_id'];
        foreach($cids as $key=>$val){
            D("jky_cate_re")->add(array(
                'item_id'=>$id,
                'cate_id'=>$val,
            ));
        } 
         $get_type_id=$this->_post('type_id');
         $add_ico=D('jky_icon');
         foreach($get_type_id as $val)
         {
            $add_arr=array('item_id'=>$id,'type_id'=>$val);
            $add_ico->add($add_arr);
         }
    }
    

    public function _before_edit(){
        $id=$this->_get('id','intval',0);
        $where=array('item_id'=>$id);
        $ids=array();                
        $list=D("jky_cate_re")->where($where)->select();        
        foreach($list as $key=>$val){
            $ids[]=$val['cate_id'];
        }        
        $cate_tree=$this->_get_cate_tree(get_cate_tree($this->_cate_mod),$ids);
                      
        $this->assign('cate_tree',$cate_tree);
        
        $ico_table=D('jky_icon_type');
        $ico_tree=$ico_table->where("`status`=1")->field("`title`,`id`")->select();
        foreach($ico_tree as $key=>$val){
            $ico_tree[$key]['flag']=D('jky_icon')->where("item_id=$id and type_id=$val[id]")->count()>0;
        }
        $this->assign('ico_tree',$ico_tree);    
    }

    protected function _before_update($data) {        
        D("jky_cate_re")->where(array('item_id'=>$data['id']))->delete();
        $cids=$_REQUEST['cate_id'];
        foreach($cids as $key=>$val){
           D("jky_cate_re")->add(array(
                'item_id'=>$data['id'],
                'cate_id'=>$val,
            ));
        }        
     
        if (!empty($_FILES['img']['name'])) {
            $art_add_time = date('ym/d');
            //删除原图
            $old_img = $this->_mod->where(array('id'=>$data['id']))->getField('img');
            $old_img = $this->_get_imgdir() . $old_img;
            is_file($old_img) && @unlink($old_img);
            
            //上传新图
            $result = $this->_upload($_FILES['img'], 'jiukuaiyou/' . $art_add_time);
            if ($result['error']) {
                $this->error($result['info']);
            } else {
                $data['img'] = $art_add_time .'/'. $result['info'][0]['savename'];
            }
        } else {
            unset($data['img']);
        }
        if(empty($data['post_key'])){
            $data['post_key']=$this->py->tourl($data['title']);
        }
        if(D("jky_item")->where("post_key='$data[post_key]' and id!=$data[id]")->count()>0){
            $data['post_key'].='_'.time();
        }        
        $data['post_key']=str_replace($this->spec_chars,'',$data['post_key']);
        $data['stime']=strtotime($_REQUEST['stime']);
        $data['etime']=strtotime($_REQUEST['etime']);
        
        D('jky_icon')->where("item_id=$data[id]")->delete();
        $get_type_id=$this->_post('type_id');
         foreach($get_type_id as $val)
         {
            $add_arr=array('item_id'=>$data['id'],'type_id'=>$val);
            D('jky_icon')->add($add_arr);
         }
        return $data;
    }
    public function _before_drop($ids){
        foreach ($ids as $val) {
            D("jky_cate_re")->where("item_id=$val")->delete();
            if ($info=M(MODULE_NAME)->where(array('id'=>$val))->find()) {                
                @unlink(attach($info['img'],MODULE_NAME,true));
            }
        }        
    }
    private function _get_imgdir() {
        static $dir = null;
        if ($dir === null) {
            $dir = './data/upload/jiukuaiyou/';
        }
        return $dir;
    }  
    public function ajax_mall_list(){
        $index=$this->_post('index','trim');
        $res=D("mall")->where(array('index'=>$index))->select();
        $data="";
        foreach($res as $key=>$val){
            $data.="<option value='$val[id]'>$val[title]</option>";
        }
        $this->ajaxReturn(1,'',$data);
    }  
    public function ajax_post_key(){        
        echo $this->py->tourl($this->_post('title'));         
    }

}