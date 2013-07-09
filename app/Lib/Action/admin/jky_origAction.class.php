<?php

class jky_origAction extends backendAction{

    public function _initialize() {
        parent::_initialize();
    }

    public function _before_index() {
        $big_menu = array(
            'title' => L('添加商品来源'),
            'iframe' => U(MODULE_NAME.'/add'),
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
            $result = $this->_upload($_FILES['img'],MODULE_NAME, array('width'=>'48', 'height'=>'48'));
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

    public function ajax_check_name() {
        $name = $this->_get('name', 'trim');
        $id = $this->_get('id', 'intval');
        if (D('flink_cate')->name_exists($name, $id)) {
            $this->ajaxReturn(0, L('该商品来源已存在！'));
        } else {
            $this->ajaxReturn(1);
        }
    }
}