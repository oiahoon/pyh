<?php
/**
 * +----------------------------------------------------------
 * 字符串截取，支持中文和其他编码
 * +----------------------------------------------------------
 * @static
 * @access public
 * +----------------------------------------------------------
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * +----------------------------------------------------------
 * @return string
 * +----------------------------------------------------------
 */
function msubstr($str, $length, $start = 0, $charset = "utf-8", $suffix = true) {
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    
    return strlen($str)>$length ? $slice . '...' : $slice;
}
function addslashes_deep($value) {
    $value = is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    return $value;
}

function stripslashes_deep($value) {
    if (is_array($value)) {
        $value = array_map('stripslashes_deep', $value);
    } elseif (is_object($value)) {
        $vars = get_object_vars($value);
        foreach ($vars as $key => $data) {
            $value->{$key} = stripslashes_deep($data);
        }
    } else {
        $value = stripslashes($value);
    }

    return $value;
}

function todaytime() {
    return mktime(0, 0, 0, date('m'), date('d'), date('Y'));
}

/**
 * 友好时间
 */
function fdate($time) {
    if (!$time)
        return false;
    $fdate = '';
    $d = time() - intval($time);
    $ld = $time - mktime(0, 0, 0, 0, 0, date('Y')); //年
    $md = $time - mktime(0, 0, 0, date('m'), 0, date('Y')); //月
    $byd = $time - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
    $yd = $time - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
    $dd = $time - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天
    $td = $time - mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')); //明天
    $atd = $time - mktime(0, 0, 0, date('m'), date('d') + 2, date('Y')); //后天
    if ($d == 0) {
        $fdate = '刚刚';
    } else {
        switch ($d) {
            case $d < $atd:
                $fdate = date('Y年m月d日', $time);
                break;
            case $d < $td:
                $fdate = '后天' . date('H:i', $time);
                break;
            case $d < 0:
                $fdate = '明天' . date('H:i', $time);
                break;
            case $d < 60:
                $fdate = $d . '秒前';
                break;
            case $d < 3600:
                $fdate = floor($d / 60) . '分钟前';
                break;
            case $d < $dd:
                $fdate = floor($d / 3600) . '小时前';
                break;
            case $d < $yd:
                $fdate = '昨天' . date('H:i', $time);
                break;
            case $d < $byd:
                $fdate = '前天' . date('H:i', $time);
                break;
            case $d < $md:
                $fdate = date('m月d H:i', $time);
                break;
            case $d < $ld:
                $fdate = date('m月d', $time);
                break;
            default:
                $fdate = date('Y年m月d日', $time);
                break;
        }
    }
    return $fdate;
}
function ftime($time){
    if($time<0)return '0天';
    
    $date=intval($time/(3600*24));
    $hour=intval(($time-$date*3600*24)/3600)>0?intval(($time-$date*3600*24)/3600):0;
    $minute=intval(($time-$date*3600*24-$hour*3600)/60)>0?intval(($time-$date*3600*24-$hour*3600)/60):0;
    return $date.'天'.$hour.'小时'.$minute.'分';
}
/**
 * 获取用户头像
 */
function avatar($uid, $size=40) {
    $avatar_size = explode(',', C('pin_avatar_size'));
    $size = in_array($size, $avatar_size) ? $size : '100';
    $avatar_dir = avatar_dir($uid);
    $avatar_file = $avatar_dir . md5($uid) . "_{$size}.jpg";
    if (!is_file(C('pin_attach_path') . 'avatar/' . $avatar_file)) {
        $avatar_file = "default_{$size}.jpg";
    }
    return __ROOT__ .'/' . C('pin_attach_path') . 'avatar/' . $avatar_file;
}

function avatar_dir($uid) {
    $uid = abs(intval($uid));
    $suid = sprintf("%09d", $uid);
    $dir1 = substr($suid, 0, 3);
    $dir2 = substr($suid, 3, 2);
    $dir3 = substr($suid, 5, 2);
    return $dir1 . '/' . $dir2 . '/' . $dir3 . '/';
}

function attach($attach, $type,$full_url=false) {
    if(empty($attach)){
        return __ROOT__.'/'.C('pin_attach_path')."no_picture.gif";
    }    
    if (false === strpos($attach, 'http://')) {
        //本地附件
        if($full_url){
            return 'http://'.$_SERVER['HTTP_HOST'].($_SERVER["SERVER_PORT"]==80?'':':'.$_SERVER["SERVER_PORT"]).__ROOT__.'/' .C('pin_attach_path') . $type . '/' . $attach;
        }else{
            return __ROOT__.'/'.C('pin_attach_path') . $type . '/' . $attach;    
        }        
        //远程附件        
    } else {
        //URL链接
        return $attach;
    }
}

/*
 * 获取缩略图
 */

function get_thumb($img, $suffix = '_thumb') {
    if (false === strpos($img, 'http://')) {
        $ext = array_pop(explode('.', $img));
        $thumb = str_replace('.' . $ext, $suffix . '.' . $ext, $img);
    } else {
        if (false !== strpos($img, 'taobaocdn.com') || false !== strpos($img, 'taobao.com')) {
            //淘宝图片 _s _m _b
            switch ($suffix) {
                case '_s':
                    $thumb = $img . '_100x100.jpg';
                    break;
                case '_m':
                    $thumb = $img . '_210x1000.jpg';
                    break;
                case '_b':
                    $thumb = $img . '_480x480.jpg';
                    break;
            }
        }
    }
    return $thumb;
}

/**
 * 对象转换成数组
 */
function object_to_array($obj) {
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    foreach ($_arr as $key => $val) {
        $val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
        $arr[$key] = $val;
    }
    return $arr;
}
function get_child_ids($mod,$id){
    $ids='';
    $list=$mod->where("pid=$id")->select();
    if($list){
        foreach($list as $key=>$val){
            $ids.=$val['id'].',';
            $ids.=get_child_ids($mod,$val['id']);
        }    
    }else{
        return '';
    }
    return trim($ids,',');    
}
function get_cate_tree($mod,$id){
    $where=array();
    if($id>0){
        $where['id']=$id;
    }else{
        $where['pid']=0;
    }
    $list=$mod->where($where)->select();
    foreach($list as $key=>$val){
        $list[$key]['depth']=0;
        $list[$key]['child']=get_child_tree($mod,$val['id'],0);
    }
    return $list;
}
function get_child_tree($mod,$pid,$depth=0){
    $where['pid']=$pid;
    $list=$mod->where($where)->select();
    if($list){
        $depth++;
        foreach($list as $key=>$val){
            $list[$key]['depth']=$depth;
            $list[$key]['child']=get_child_tree($mod,$val['id'],$depth);
        }    
    }else{
        return false;
    }
    return $list;  
}
function html_select($name,$list,$id=-1){  
    if($id==null){
        $id=-1;
    }
    $html="<select name='$name' id='$name'>";    
    $html.="<option value='-1'>请选择...</option>";    
    foreach($list as $key=>$val){
        $html.="<option value='$key'";
        if($key==$id){
            $html.=" selected='selected'";
        }
        $html.=">$val</option>";
    }
    $html.="</select>";
    return $html;
}
function html_radio($name,$list,$id=-1){
    $html="";
    //file_put_contents('./data.txt',var_dump($list));
    foreach($list as $key=>$val){
        $html.="<span><input type='radio' name='$name' value='$key'";
        if($key==$id){
            $html.=" checked='checked'";
        }
        $html.="/>$val</span>";
    }
    return $html;
}
function topinyin($title){
    include(APP_PATH.'Lib/Pinlib/pinyin.class.php');
    $py=new cls_pinyin();
    return $py->tourl($title);
}
function get_index(){
    $list=array();    
    $list[9]='0~9';
    for($i=65;$i<91;$i++){
        $list[chr($i)]=chr($i);
    }
    return $list;
}
function table($table) {
    return C('DB_PREFIX') . $table;
}
function get_baoliao_type($cid){
    switch($cid){
        case 0:return '爆料';
        case 1:return '投稿';
        case 2:return '建议';
    }
}
function user_level($level){    
    $sun_img='<img src="'.__ROOT__.'/static/images/sun.png'.'"/>';//16
    $moon_img='<img src="'.__ROOT__.'/static/images/moon.png'.'"/>';//4
    $star_img='<img src="'.__ROOT__.'/static/images/star.png'.'"/>';//1
    if(empty($level)){
        return $star_img;
    }    
    $sun=$level/16;
    $moon=($level%16)/4;
    $star=$level%16%4;
    return str_repeat($sun_img,$sun).str_repeat($moon_img,$moon).str_repeat($star_img,$star);
}
function post_url($info){    
    if(empty($info['post_key'])){
        return U('post/index',array('id'=>$info['id']));
    }else{
        return U('post/index',array('post_key'=>$info['post_key']));
    }
}
function parse_uri($url){
    $res=parse_url($url); 
    $list=explode('&',$res['query']);    
    foreach($list as $item){
        $kv=explode('=',$item);        
        $res['_query'][$kv[0]]=$kv[1];
    }
    return $res;
}
function mall_url($mall_info){
    if(empty($mall_info['url'])||empty($mall_info['url_'.$mall_info['url']])){
        return $mall_info['domain'];
    }
    if($mall_info['url']=='yqf'){
        $urls=parse_uri($mall_info['url_'.$mall_info['url']]);
        $url=$urls['scheme']."://".$urls['host'].$urls['path']."?";
        foreach(array('s','w','c','i','l','e','t') as $val){
            if($val=='w'){
                $url.="$val=".C('pin_cps_'.$mall_info['url'])."&";
            }else{
                $url.="$val=".$urls['_query'][$val]."&";    
            }
        }
        return trim($url,'&');
    }elseif($mall_info['url']=='other'){
        return $mall_info['url_'.$mall_info['url']];    
    }else{
        return $mall_info['url_'.$mall_info['url']].'&sid='.C('pin_cps_'.$mall_info['url']); 
    }        
}
function _exit($str){
    header("Content-Type: text/html; charset=utf-8");
    exit("<script>alert('$str');window.location.href='".u('user/logout')."';</script>");
}
function filter_data($data){
    foreach($data as $key=>$val){
        $data[$key]=strip_tags($val);
    }
    return $data;
}
function get_jky_state($info){
    if($info['stime']<=time()&&$info['etime']>=time()){
        return 'underway';
    }
    if($info['stime']>time()){
        return 'notstart';
    }
    if($info['etime']<time()){
        return 'end';
    }    
}
function get_ret_url(){
    $query_list=explode('&',$_SERVER['QUERY_STRING']);
    foreach($query_list as $key=>$val){
        $param=explode('=',$val);
        if($param[0]=='ret_url'){
            unset($query_list[$key]);
        }
    }
    $url='http://' . $_SERVER["HTTP_HOST"] . ($_SERVER["SERVER_PORT"] ==80 ? '' : ':' . $_SERVER["SERVER_PORT"]).$_SERVER['SCRIPT_NAME'].'?'.implode('&',$query_list);
    return urlencode($url);
}
function check_url($str){
    if(empty($str)){
        return "#";
    }
    $info=parse_url(ltrim($str,'.'));    
    
    empty($info['scheme'])&&$info['scheme']="http"; 
    if(empty($info['host'])){
        $host=$_SERVER['HTTP_HOST'];
    }else{
        $host=$info['host'];    
    }
    if(isset($info['port'])){
        $port=':'.$info['port'];
    }
    $url=$info['scheme']."://".$host.$port;
    
    if(empty($info['host'])){
        $url.=rtrim(__ROOT__,'/');    
    }    
        
    $url.='/'.ltrim($info['path'],'/');    
    if(!empty($info['query'])){
        $url.='?'.$info['query'];    
    }
    $url.$info['fragment'];    
    return $url;
}