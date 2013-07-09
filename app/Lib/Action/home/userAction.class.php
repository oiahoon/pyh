<?php

class userAction extends userbaseAction {
    public function _initialize() {   
        parent::_initialize();                
        $this->_config_seo(array('title'=>'会员中心'));
    }
    /**
     * 用户登录
     */
    public function login() {
        $this->visitor->is_login && $this->redirect('user/index');
        $this->_config_seo(array('title'=>'会员登录'));             
        if (IS_POST) {
            $username = $this->_post('username', 'trim');
            $password = $this->_post('password', 'trim');
            $type = $this->_post('type', 'trim', 'reg');
           
            $captcha = $this->_post('captcha', 'trim');
            if (session('captcha') != md5($captcha)&&C('pin_captcha_status')){
                $this->error(L('captcha_failed'));
            }

            $remember = $this->_post('remember');
            if (empty($username)) {
                IS_AJAX && $this->ajaxReturn(0, L('please_input').L('password'));
                $this->error(L('please_input').L('username'));
            }
            if (empty($username)) {
                IS_AJAX && $this->ajaxReturn(0, L('please_input').L('password'));
                $this->error(L('please_input').L('password'));
            }
            //连接用户中心
            $passport = $this->_user_server();
            $uid = $passport->auth($username, $password);
            if (!$uid) {
                IS_AJAX && $this->ajaxReturn(0, $passport->get_error());
                $this->error($passport->get_error());
            }
            //登录
            $this->visitor->login($uid, $remember);
            
            //登录完成钩子
            $tag_arg = array('uid'=>$uid, 'uname'=>$username, 'action'=>'login');
            tag('login_end', $tag_arg);
            //同步登录
            
            $synlogin = $passport->synlogin($uid);            
            if (IS_AJAX) {
                $this->ajaxReturn(1, L('login_successe').$synlogin);
            } else {
                //跳转到登录前页面（执行同步操作）
                $ret_url = $this->_post('ret_url', 'urldecode');                
                $this->success(L('login_successe').$synlogin, $ret_url);
            }
        } else {
            /* 同步退出外部系统 */
            if (!empty($_GET['synlogout'])) {
                $passport = $this->_user_server();
                $synlogout = $passport->synlogout();
            }
            if (IS_AJAX) {
                $resp = $this->fetch('dialog:login');
                $this->ajaxReturn(1, '', $resp);
            } else {
                //来路
                $ret_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : __APP__;
                $this->assign('ret_url', $ret_url);
                $this->assign('synlogout', $synlogout);
                $this->display();
            }
        }
    }

    /**
     * 用户退出
     */
    public function logout() {
        $this->visitor->logout();
        //同步退出
        $passport = $this->_user_server();
        $synlogout = $passport->synlogout();
        //跳转到退出前页面（执行同步操作）
        $this->success(L('logout_successe').$synlogout, $this->_request('ret_url', 'urldecode',U('index/index')));
    }

    /**
     * 用户绑定
     */
    public function binding() {
        $passport = $this->_user_server();
        $user_bind_info = object_to_array(cookie('user_bind_info'));
        
        $username=str_replace('%','',urldecode($user_bind_info["pin_user_name"]));
        
        if(strlen($username)>=15){            
            $username=trim(msubstr($username,10),".").rand(0,999);    
        } 
        $password=substr(md5($username),0,8);
        $email=$password."@xx.com";
        $uid = $passport->register($username, $password, $email,1);        
        !$uid && $this->error($passport->get_error());
                
        M('user_bind')->where("uid=$uid")->delete();
        M('user_bind')->add(array(
            'uid' => $uid,
            'type' => $user_bind_info['type'],
            'keyid' => $user_bind_info['keyid'],
            'info' => serialize($user_bind_info['bind_info']),
        ));                
        $user_bind_info = NULL;
        
        $synlogin = $passport->synlogin($uid);
        $this->visitor->login($uid);
        $this->success('登录成功' . $synlogin, u(MODULE_NAME.'/index')); 
    }

    /**
    * 用户注册
    */
    public function register() {
        $this->visitor->is_login && $this->redirect('user/index');
        $this->_config_seo(array('title'=>'会员注册'));
        if (IS_POST) {
            //方式
            $type = $this->_post('type', 'trim', 'reg');
            if ($type == 'reg') {
                //验证
                $agreement = $this->_post('agreement');
                !$agreement && $this->error(L('agreement_failed'));

                $captcha = $this->_post('captcha', 'trim');
                if(session('captcha') != md5($captcha)&&C('pin_captcha_status')){
                    $this->error(L('captcha_failed'));
                }
            }
            $username = $this->_post('username', 'trim');
            $email = $this->_post('email','trim');
            $password = $this->_post('password', 'trim');
            $repassword = $this->_post('repassword', 'trim');
            if ($password != $repassword) {
                $this->error(L('inconsistent_password')); //确认密码
            }
            $gender = $this->_post('gender','intval', '0');
            //用户禁止
            $ipban_mod = D('ipban');
            $ipban_mod->clear(); //清除过期数据
            $is_ban = $ipban_mod->where("(type='name' AND name='".$username."') OR (type='email' AND name='".$email."')")->count();
            $is_ban && $this->error(L('register_ban'));
            //连接用户中心
            $passport = $this->_user_server();
            //注册
            $uid = $passport->register($username, $password, $email, $gender);
            !$uid && $this->error($passport->get_error());
            //第三方帐号绑定
            if (cookie('user_bind_info')) {
                $user_bind_info = object_to_array(cookie('user_bind_info'));                
                $oauth = new oauth($user_bind_info['type']);
                $bind_info = array(
                    'pin_uid' => $uid,
                    'keyid' => $user_bind_info['keyid'],
                    'bind_info' => $user_bind_info['bind_info'],
                );
                $oauth->bindByData($bind_info);
                //临时头像转换
                $this->_save_avatar($uid, $user_bind_info['temp_avatar']);
                //清理绑定COOKIE
                cookie('user_bind_info', NULL);
            }
            //注册完成钩子
            $tag_arg = array('uid'=>$uid, 'uname'=>$username, 'action'=>'register');
            tag('register_end', $tag_arg);
            //登录
            $this->visitor->login($uid);
            //登录完成钩子
            $tag_arg = array('uid'=>$uid, 'uname'=>$username, 'action'=>'login');
            tag('login_end', $tag_arg);
            //同步登录
            $synlogin = $passport->synlogin($uid);
            $this->success(L('register_successe').$synlogin, U('user/index'));
        } else {
            //关闭注册
            if (!C('pin_reg_status')) {
                $this->error(C('pin_reg_closed_reason'));
            }
            $this->display();
        }
    }

    /**
     * 第三方头像保存
     */
    private function _save_avatar($uid, $img) {
        //获取后台头像规格设置
        $avatar_size = explode(',', C('pin_avatar_size'));
        //会员头像保存文件夹
        $avatar_dir = C('pin_attach_path') . 'avatar/' . avatar_dir($uid);
        !is_dir($avatar_dir) && mkdir($avatar_dir,0777,true);
        //生成缩略图
        $img = C('pin_attach_path') . 'avatar/temp/' . $img;
        foreach ($avatar_size as $size) {
            Image::thumb($img, $avatar_dir.md5($uid).'_'.$size.'.jpg', '', $size, $size, true);
        }
        @unlink($img);
    }
    
    /**
     * 用户消息提示 
     */
    public function msgtip() {
        $result = D('user_msgtip')->get_list($this->visitor->info['id']);
        $this->ajaxReturn(1, '', $result);
    }

    /**
    * 基本信息修改
    */
    public function index() {
        $info = $this->visitor->get();            
        $this->assign('info', $info);        
        $this->assign('favs_list',D("post_favs")->relation(true)->where(array('uid'=>$this->uid))->order("id desc")->limit(4)->select());
        $this->assign('message_num',D("message")->relation(true)->where(array('to_id'=>$this->uid,'status'=>'0'))->count());
        $this->display(); 
    }
    public function profile(){
        if( IS_POST ){
            foreach ($_POST as $key=>$val) {
                $_POST[$key] = Input::deleteHtmlTags($val);
            }
            $data['gender'] = $this->_post('gender', 'intval');
            $data['province'] = $this->_post('province', 'trim');
            $data['city'] = $this->_post('city', 'trim');
            $data['tags'] = $this->_post('tags', 'trim');
            $data['intro'] = $this->_post('intro', 'trim');
            $birthday = $this->_post('birthday', 'trim');
            $birthday = explode('-', $birthday);
            $data['byear'] = $birthday[0];
            $data['bmonth'] = $birthday[1];
            $data['bday'] = $birthday[2];
            if (false !== M('user')->where(array('id'=>$this->visitor->info['id']))->save($data)) {
                $msg = array('status'=>1, 'info'=>L('edit_success'));
            }else{
                $msg = array('status'=>0, 'info'=>L('edit_failed'));
            }  
                      
            $this->assign('msg', $msg);
            $this->success($msg['info']);
        }        
        $info = $this->visitor->get();            
        $this->assign('info', $info);
        $this->display();        
    } 
    /**
     * 修改头像
     */
    public function upload_avatar() {

        if (!empty($_FILES['avatar']['name'])) {
            //会员头像规格
            $avatar_size = explode(',', C('pin_avatar_size'));
            //回去会员头像保存文件夹
            $uid = abs(intval($this->visitor->info['id']));
            $suid = sprintf("%09d", $uid);
            $dir1 = substr($suid, 0, 3);
            $dir2 = substr($suid, 3, 2);
            $dir3 = substr($suid, 5, 2);
            $avatar_dir = $dir1.'/'.$dir2.'/'.$dir3.'/';
            //上传头像
            $suffix = '';
            foreach ($avatar_size as $size) {
                $suffix .= '_'.$size.',';
            }
            $result = $this->_upload($_FILES['avatar'], 'avatar/'.$avatar_dir, array(
                'width'=>C('pin_avatar_size'), 
                'height'=>C('pin_avatar_size'),
                'remove_origin'=>true, 
                'suffix'=>trim($suffix, ','),
                'ext' => 'jpg',
            ), md5($uid));
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $data = __ROOT__.'/data/upload/avatar/'.$avatar_dir.md5($uid).'_'.$size.'.jpg?'.time();
                D('user')->where("id=".$this->uid)->save(array('avatar'=>$avatar_dir.md5($uid)));
                $this->ajaxReturn(1, L('upload_success'), $data);
            }
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }

    /**
     * 修改密码
     */
    public function password() {
        if( IS_POST ){
            $oldpassword = $this->_post('oldpassword','trim');
            $password   = $this->_post('password','trim');
            $repassword = $this->_post('repassword','trim');
            !$password && $this->error(L('no_new_password'));
            $password != $repassword && $this->error(L('inconsistent_password'));
            $passlen = strlen($password);
            if ($passlen < 6 || $passlen > 20) {
                $this->error('password_length_error');
            }            
            //连接用户中心
            $passport = $this->_user_server();
            $result = $passport->edit($this->visitor->info['id'], $oldpassword, array('password'=>$password));
            if ($result) {
                $msg = array('status'=>1, 'info'=>L('edit_password_success'));
            } else {
                $msg = array('status'=>0, 'info'=>$passport->get_error());
            }
            $this->success($msg['info']);
            //$this->assign('msg', $msg);
        }
        
        $this->display();
    }

    /**
     * 帐号绑定
     */
    public function bind() {
        //获取已经绑定列表
        $bind_list = M('user_bind')->field('type')->where(array('uid'=>$this->visitor->info['id']))->select();
        $binds = array();
        if ($bind_list) {
            foreach ($bind_list as $val) {
                $binds[] = $val['type'];
            }
        }
        
        //获取网站支持列表
        $oauth_list = $this->oauth_list;
        foreach ($oauth_list as $type => $_oauth) {
            $oauth_list[$type]['isbind'] = '0';
            if (in_array($type, $binds)) {
                $oauth_list[$type]['isbind'] = '1';
            }
        }
        $this->assign('oauth_list', $oauth_list);
        
        $this->display();
    }

    /**
     * 个人空间banner背景设置
     */
    public function custom() {
        $cover = $this->visitor->get('cover');
        $this->assign('cover', $cover);
        
        $this->display();
    }

    /**
     * 取消封面
     */
    public function cancle_cover() {
        $result = M('user')->where(array('id'=>$this->visitor->info['id']))->setField('cover', '');
        !$result && $this->ajaxReturn(0, L('illegal_parameters'));
        $this->ajaxReturn(1, L('edit_success'));
    }

    /**
     * 上传封面图片
     */
    public function upload_cover() {
        if (!empty($_FILES['cover']['name'])) {
            $data_dir = date('ym/d');
            $file_name = md5($this->visitor->info['id']);
            $result = $this->_upload($_FILES['cover'], 'cover/'.$data_dir, array('width'=>'900', 'height'=>'330', 'remove_origin'=>true), $file_name);
            if ($result['error']) {
                $this->ajaxReturn(0, $result['info']);
            } else {
                $ext = array_pop(explode('.', $result['info'][0]['savename']));
                $cover = $data_dir.'/'.$file_name.'_thumb.'.$ext;
                $data = '<img src="./data/upload/cover/'.$data_dir.'/'.$file_name.'_thumb.'.$ext.'?'.time().'">';
                //更新数据
                M('user')->where(array('id'=>$this->visitor->info['id']))->setField('cover', $cover);
                $this->ajaxReturn(1, L('upload_success'), $data);
            }
        } else {
            $this->ajaxReturn(0, L('illegal_parameters'));
        }
    }

    /**
     * 收货地址
     */
    public function address() {
        $user_address_mod = M('user_address');
        $id = $this->_get('id', 'intval');
        $type = $this->_get('type', 'trim', 'edit');
        if ($id) {
            if ($type == 'del') {
                $user_address_mod->where(array('id'=>$id, 'uid'=>$this->visitor->info['id']))->delete();
                $msg = array('status'=>1, 'info'=>L('delete_success'));
                $this->assign('msg', $msg);
            } else {
                $info = $user_address_mod->find($id);
                $this->assign('info', $info);
            }
        }
        if (IS_POST) {
            $consignee = $this->_post('consignee', 'trim');
            $address = $this->_post('address', 'trim');
            $zip = $this->_post('zip', 'trim');
            $mobile = $this->_post('mobile', 'trim');
            $id = $this->_post('id', 'intval');
            if ($id) {
                $result = $user_address_mod->where(array('id'=>$id, 'uid'=>$this->visitor->info['id']))->save(array(
                    'consignee' => $consignee,
                    'address' => $address,
                    'zip' => $zip,
                    'mobile' => $mobile,
                ));
                if ($result) {
                    $msg = array('status'=>1, 'info'=>L('edit_success'));
                } else {
                    $msg = array('status'=>0, 'info'=>L('edit_failed'));
                }
            } else {
                $result = $user_address_mod->add(array(
                    'uid' => $this->visitor->info['id'],
                    'consignee' => $consignee,
                    'address' => $address,
                    'zip' => $zip,
                    'mobile' => $mobile,
                ));
                if ($result) {
                    $msg = array('status'=>1, 'info'=>L('add_address_success'));
                } else {
                    $msg = array('status'=>0, 'info'=>L('add_address_failed'));
                }
            }
            $this->assign('msg', $msg);
        }
        $address_list = $user_address_mod->where(array('uid'=>$this->visitor->info['id']))->select();
        $this->assign('address_list', $address_list);
        
        $this->display();
    }

    /**
     * 检测用户
     */
    public function ajax_check() {
        $type = $this->_get('type', 'trim', 'email');
        $user_mod = D('user');
        switch ($type) {
            case 'email':
                $email = $this->_get('J_email', 'trim');
                $user_mod->email_exists($email) ? $this->ajaxReturn(0) : $this->ajaxReturn(1);
                break;
            
            case 'username':
                $username = $this->_get('J_username', 'trim');
                $user_mod->name_exists($username) ? $this->ajaxReturn(0) : $this->ajaxReturn(1);
                break;
        }
    }

    /**
     * 关注
     */
    public function follow() {
        $uid = $this->_get('uid', 'intval');
        !$uid && $this->ajaxReturn(0, L('follow_invalid_user'));
        $uid == $this->visitor->info['id'] && $this->ajaxReturn(0, L('follow_self_not_allow'));
        $user_mod = M('user');
        if (!$user_mod->where(array('id'=>$uid))->count('id')) {
            $this->ajaxReturn(0, L('follow_invalid_user'));
        }
        $user_follow_mod = M('user_follow');
        //已经关注？
        $is_follow = $user_follow_mod->where(array('uid'=>$this->visitor->info['id'], 'follow_uid'=>$uid))->count();
        $is_follow && $this->ajaxReturn(0, L('user_is_followed'));
        //关注动作
        $return = 1;
        //他是否已经关注我
        $map = array('uid'=>$uid, 'follow_uid'=>$this->visitor->info['id']);
        $isfollow_me = $user_follow_mod->where($map)->count();
        $data = array('uid'=>$this->visitor->info['id'], 'follow_uid'=>$uid, 'add_time'=>time());
        if ($isfollow_me) {
            $data['mutually'] = 1; //互相关注
            $user_follow_mod->where($map)->setField('mutually', 1); //更新他关注我的记录为互相关注
            $return = 2;
        }
        $result = $user_follow_mod->add($data);
        !$result && $this->ajaxReturn(0, L('follow_user_failed'));
        //增加我的关注人数
        $user_mod->where(array('id'=>$this->visitor->info['id']))->setInc('follows');
        //增加Ta的粉丝人数
        $user_mod->where(array('id'=>$uid))->setInc('fans');
        //提醒被关注的人
        D('user_msgtip')->add_tip($uid, 1);
        //把他的微薄推送给我
        //TODO...是否有必要？
        $this->ajaxReturn(1, L('follow_user_success'), $return);
    }

    /**
     * 取消关注
     */
    public function unfollow() {
        $uid = $this->_get('uid', 'intval');
        !$uid && $this->ajaxReturn(0, L('unfollow_invalid_user'));
        $user_follow_mod = M('user_follow');
        if ($user_follow_mod->where(array('uid'=>$this->visitor->info['id'], 'follow_uid'=>$uid))->delete()) {
            $user_mod = M('user');
            //他是否已经关注我
            $map = array('uid'=>$uid, 'follow_uid'=>$this->visitor->info['id']);
            $isfollow_me = $user_follow_mod->where($map)->count();
            if ($isfollow_me) {
                $user_follow_mod->where($map)->setField('mutually', 0); //更新他关注我的记录为互相关注
            }
            //减少我的关注人数
            $user_mod->where(array('id'=>$this->visitor->info['id']))->setDec('follows');
            //减少Ta的粉丝人数
            $user_mod->where(array('id'=>$uid))->setDec('fans');
            //删除我微薄中Ta的内容
            M('topic_index')->where(array('author_id'=>$uid, 'uid'=>$this->visitor->info['id']))->delete();
            $this->ajaxReturn(1, L('unfollow_user_success'));
        } else {
            $this->ajaxReturn(0, L('unfollow_user_failed'));
        }
    }

    /**
     * 移除粉丝
     */
    public function delfans() {
        $uid = $this->_get('uid', 'intval');
        !$uid && $this->ajaxReturn(0, L('delete_invalid_fans'));
        $user_follow_mod = M('user_follow');
        if ($user_follow_mod->where(array('follow_uid'=>$this->visitor->info['id'], 'uid'=>$uid))->delete()) {
            $user_mod = M('user');
            //减少我的粉丝人数
            $user_mod->where(array('id'=>$this->visitor->info['id']))->setDec('fans');
            //减少Ta的关注人数
            M('user')->where(array('id'=>$uid))->setDec('follows');
            //删除Ta微薄中我的内容
            M('topic_index')->where(array('author_id'=>$this->visitor->info['id'], 'uid'=>$uid))->delete();
            $this->ajaxReturn(1, L('delete_fans_success'));
        } else {
            $this->ajaxReturn(0, L('delete_fans_failed'));
        }
    }
    public function favs(){
        $id=$this->_post('id','intval');
        $act=$this->_post('act','trim');
        if($act=='del'){
            if($id>0){
                $res=D("post_favs")->where(array('id'=>$id,'uid'=>$this->uid))->delete();
               if($res){                                  
                    $this->ajaxReturn(1,'操作成功');
                } else {
                    $this->ajaxReturn(0, '操作失败');
                }
            }    
        }
        
        $where=array('uid'=>$this->uid);
        $count=D("post_favs")->where($where)->count();
        $pager=$this->_pager($count,8);
        $res=D("post_favs")->relation(true)
            ->limit($pager->firstRow . ',' . $pager->listRows)->order($order)
            ->where($where)->select();
            
        $this->assign('page', $pager->show());                
        $this->assign('list',$res);
        $this->display();
    }
    
    public function comments(){        
        $mod=new Model();
        $where=" where uid=".$this->uid;
        $sql="select *,'post_comment' as m from ".table('post_comment')." $where union select *,'jky_comment' as m from ".table(jky_comment)." $where";
        $res=$mod->query("select count(id) as total from ($sql) as res");
        $count=$res[0]['total'];

        import("ORG.Util.Page");        
        $pager =$this->_pager($res[0]['total'], 8);
        $res=$mod->query($sql." order by add_time desc "." limit ".$pager->firstRow . ',' .$pager->listRows);
        
        foreach($res as $key=>$val){
            $res[$key]=D($val['m'])->relation(true)->where("id=$val[id]")->find();        
            $res[$key]['m']=$val['m'];
        }
                           
        $this->assign('list',$res);
        $this->assign('page',$pager->show());
        $this->display();
    }
    public function message(){
        $where=array('to_id'=>$this->uid);
        $this->_assign_list(D("message"),$where,8,true);
        
        D('message')->where($where)->save(array('status'=>1));                
        $this->display();
    }    
    public function favs_add(){
        $id=$this->_get('id','intval');
        $uid=$this->visitor->info['id'];
        
        if(D("post_favs")->where(array('post_id'=>$id,'uid'=>$uid))->find()){
            $this->ajaxReturn(0,'已经添加了');
        }else{
            D("post_favs")->add(array(
                'post_id'=>$id,
                'uid'=>$uid,
                'add_time'=>time(),
                'ip'=>$_SERVER["REMOTE_ADDR"]
            ));
            $tag_arg = array('uid'=>$this->visitor->info['id'], 
                'uname'=>$this->visitor->info['username'], 
                'action'=>'favs');
            tag('favs_end', $tag_arg);         
                   
            D("post")->where(array('id'=>$id))->setInc('favs');            
            $this->ajaxReturn(1,'添加成功',D("post")->where(array('id'=>$id))->getField('favs'));            
        }      
    }
    public function baoliao(){
        $type=$this->_get('type','intval',0);
        $this->_assign_list(D("post_baoliao"),"type=$type and uid=".$this->uid);
        $this->assign('type',$type);
        $this->display();
    }

    public function anhao() {
        $where = array('uid'=>$this->uid);
        $count = M('jky_anhao')->where($where)->count();
        $pager = $this->_pager($count,8);
        $res = D('jky_anhao')->relation(true)
            ->limit($pager->firstRow . ',' . $pager->listRows)->order('id DESC')
            ->where($where)->select();
        $this->assign('page', $pager->show());
        $this->assign('list',$res);

        $this->display();
    }

    /**
     * 积分订单
     */
    public function score_order() {
        $map = array();
        $map['uid'] = $this->uid;
        $score_order_mod = M('score_order');
        $pagesize = 20;
        $count = $score_order_mod->where($map)->count('id');
        $pager = $this->_pager($count, $pagesize);
        $order_list = $score_order_mod->field('id,order_sn,item_id,item_name,order_score,status,add_time')->where($map)->limit($pager->firstRow.','.$pager->listRows)->order('id DESC')->select();
        $this->assign('order_list', $order_list);
        $this->assign('page_bar', $pager->fshow());
        $this->_config_seo();
        $this->display();
    }

    public function score_log(){
        $this->_assign_list(D("score_log"),"uid=".$this->uid);
        $this->assign('l',L('score_lang'));
        $this->display();
    }

    public function qiandao() {
        if ($this->_check_num($this->visitor->info['id'], 'qiandao')) {
            $tag_arg = array(
                'uid'=>$this->visitor->info['id'],
                'uname'=>$this->visitor->info['username'],
                'action'=>'qiandao'
            );
            tag('qiandao_end', $tag_arg);
            $this->ajaxReturn(1, '签到成功');
        }
        $this->ajaxReturn(0, '你已经签到过了');
    }

    /**
     * 检查次数限制
     */
    private function _check_num($uid, $action){
        $return = false;
        $user_stat_mod = D('user_stat');
        //登录次数限制
        $max_num = C('pin_score_rule.'.$action.'_nums');
        //先检查统计信息
        $stat = $user_stat_mod->field('num,last_time')->where(array('uid'=>$uid, 'action'=>$action))->find();
        if (!$stat) {
            $user_stat_mod->create(array('uid'=>$uid, 'action'=>$action));
            $user_stat_mod->add();
        }
        if ($max_num == 0) {
            $return = true; //为0则不限制
        } else {
            if ($stat['last_time'] < todaytime()) {
                $return = true;
            } else {
                $return = $stat['num'] >= $max_num ? false : true;
            }
        }
        return $return;
    }
}