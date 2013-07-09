<?php
/**
 * 访问者
 *
 * @author andery
 */
class user_visitor {

    public $is_login = false; //登录状态
    public $info = null;

    public function __construct() {
        $where="";
        
        if ($user_info=session('user_info')) {
            //已经登录
            $where="id=$user_info[id]";
        } elseif ($user_info = (array)cookie('user_info')) {
            $where="id=$user_info[id] and password='$user_info[password]'";
        } else {
            $this->is_login = false;
        }
        
        if(!empty($where)){
            $user_info = M('user')->field('id,username,password,score')->where($where)->find();
            if ($user_info) {
                //记住登录状态
                $this->assign_info($user_info);
                $this->is_login = true;
            }
        }
    }

    /**
     * 登录会话
     */
    function assign_info($user_info) {
        session('user_info', $user_info);
        $this->info =$this->parse_info($user_info);
    }

    /**
     * 记住密码
     */
    public function remember($user_info, $remember = null) {
        if ($remember) {
            $time = 3600 * 24 * 14; //两周
            cookie('user_info', array('id'=>$user_info['id'], 'password'=>$user_info['password']), $time);
        }
    }

    /**
     * 获取用户信息
     */
    public function get($key = null) {
        $info = null;
        if (is_null($key) && $this->info['id']) {
            $info = M('user')->find($this->info['id']);
        } else {
            if (isset($this->info[$key])) {
                return $this->info[$key];
            } else {
                //获取用户表字段
                $fields = M('user')->getDbFields();
                if (!is_null(array_search($key, $fields))) {
                    $info = M('user')->where(array('id' => $this->info['id']))->getField($key);
                }
            }
        }                
        return $this->parse_info($info);
    }

    /**
     * 登录
     */
    public function login($uid, $remember = null) {
        $user_mod = M('user');
        //更新用户信息
        $user_mod->where(array('id' => $uid))->save(array('last_time' => time(), 'last_ip' => get_client_ip()));
        $user_info = $user_mod->field('id,username,password,score')->find($uid);
        //保持状态
        //var_dump($user_info);exit();
        $this->assign_info($user_info);
        $this->remember($user_info, $remember);
    }
    private function parse_info($info){
        $info['msg_num']=D('message')->where("to_id=$info[id] and status=0")->count();
        return $info;
    }
    /**
     * 退出
     */
    public function logout() {
        session('user_info', null);
        cookie('user_info', null);
    }
}