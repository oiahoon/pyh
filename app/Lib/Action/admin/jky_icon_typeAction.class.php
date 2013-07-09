<?php
class jky_icon_typeAction extends backendAction
{
    public function _initialize() {
        parent::_initialize();
    }

    public function _before_index() {
        $big_menu = array(
            'title' => L('添加图标'),
            'iframe' => U('jky_icon_type/add'),
            'id' => 'add',
            'width' => '500',
            'height' => '140'
        );
        $this->assign('big_menu', $big_menu);
        //默认排序
        $this->sort = 'id';
        $this->order = 'desc';
    }
    
   public function ajax_upload_img() {
        //上传图片
        if (!empty($_FILES['img']['name'])) {
            $result = $this->_upload($_FILES['img'], 'jky_icon_type');
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $data['img'] = $result['info'][0]['savename'];
                $this->ajaxReturn(1, L('operation_success'), $data['img']);
            }
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }
}