<?php

class jky_commentAction extends backendAction
{
    var $list_relation=true;
    public function _before_index() {
        //默认排序
        $this->sort = 'id';
        $this->order = 'desc';
    }    
    protected function _search() {
        ($keyword = $this->_request('keyword', 'trim')) && $map['info|uname'] = array('like', '%'.$keyword.'%');      
        $this->assign('search', array(
            'keyword' => $keyword,
        ));
        return $map;
    }      
}
