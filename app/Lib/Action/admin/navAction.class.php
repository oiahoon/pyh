<?php
class navAction extends backendAction {

    protected function _search() {
        $map['type'] = $this->_get('type', 'trim', 'main');
        return $map;
    }

    public function _before_index() {
        $this->sort = 'ordid';
        $this->order = 'ASC';
        $big_menu = array(
            'title' => L('nav_add'),
            'iframe' => U('nav/add'),
            'id' => 'add',
            'width' => '500',
            'height' => '200'
        );
        $this->assign('big_menu', $big_menu);
    }
    function _after_insert($id){
        $this->parse_info($id);
    }
    function _after_update($id){
        $this->parse_info($id);
    }
    private function parse_info($id){
        if($this->_post('homepage','intval')>0){
            D('nav')->where("id<>$id")->save(array('homepage'=>0));
        }
    }
}