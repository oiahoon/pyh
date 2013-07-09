<?php

class mallAction extends frontendAction {
    public function index() {

        $index_word = $this->_get('word');
        $cate_list = D('mall_cate')->where("status=1")->order('ordid')->select();
        foreach ($cate_list as $key => $val) {
            $cate_list[$key]['child'] = D('mall')->where("status=1  and  cid=$val[id]")->
                order('ordid')->select();
            $cate_list[$key]['mall_nums'] = D('mall')->where("status=1  and  cid=$val[id]")->
                count();
        }
        $get_cate_id = $this->_get('cate');

        if (C(DEFAULT_THEME) == "myzhide" || C(DEFAULT_THEME) == 'jiukuaiyou') {
            $where = '';
            if (!empty($get_cate_id)) {
                $show_cate_name = D('mall_cate')->where("`id`=$get_cate_id")->field("`title`")->
                    find();
            } else {
                $show_cate_name = array('title' => '所有商城');
            }
            $this->assign('show_cate_name', $show_cate_name);
            $number = D('mall')->count();
            if (!empty($index_word)) {
                $where = "`index`='$index_word'";
                $where1 = $where;
                $text = $index_word;
                $this->assign("text", $text);
            }
            if (!empty($get_cate_id)) {
                $where = "status=1 and `cid`=$get_cate_id";
                $number = D('mall')->where($where)->count();
                $where2 = $where;
                $cate = $get_cate_id;
                $this->assign("cate", $cate);
            }
            if (!empty($index_word) && !empty($get_cate_id)) {
                $where = $where1 . ' and ' . $where2;
            }
            $this->assign("number", $number);
            $this->_assign_list(D('mall'), $where);
            $this->assign('li_st', $cate_list);
        } else {
            $this->assign('list', $cate_list);
        }

        $this->_config_seo(C('pin_seo_config.mall'));
        $this->display();
    }
    public function info() {
        $id = intval($_REQUEST['id']);
        $res = D('mall')->where("id=$id")->find();
        if ($res) {
            $res['post_list'] = D('post')->where("mall_id=$res[id] and status=1 and post_time<=" .time())->limit('0,10')->select();
            $this->assign('info', $res);
            $this->_config_seo(C('pin_seo_config.mall_info'), array(
                'mall_title' => $res['title'],
                'seo_title' => $res['seo_title'],
                'seo_keywords' => $res['seo_keys'],
                'seo_description' => $res['seo_desc']));
			$re_mall_list = D("mall")->where("status=1 and cid=".$res['cid'])->limit(10)->select();
            $this->assign('re_mall_list', $re_mall_list);
            $res = D("mall")->where("id=$id")->setInc('hits');				
        } else {
            $this->error("商城不存在", u('index/index'));
        }
        $this->display();
    }
}
