<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('parsley_error')){
    function parsley_error($str){
        if($str!=''){
            echo '<ul class="parsley-errors-list filled">'
                    .'<li class="parsley-required">'.$str.'</li>'
                .'</ul>';
        }
    }
}

if(!function_exists('create_dt_length_menu')){
    function create_dt_length_menu($rpp = ''){
        $list = array(10,20,25,50,100,500);
        if($rpp!=''){ $list[] = $rpp; }
        $list = array_unique($list); sort($list);
        $list = implode(",",$list);
        return '['.$list.']';
    }
}

if(!function_exists('google_recaptcha')){
    function google_recaptcha($id){
        if($id!=''){
            $CI=& get_instance();
            $CI->load->database();
            $keys = array('captcha_site_key','captcha_theme','captcha_size','captcha_type');
            $setting = $CI->CRUD->get_setting_row($keys);
            
            echo '<div class="g-recaptcha recaptcha" id="'.$id.'" data-sitekey="'.$setting->captcha_site_key.'" data-theme="'.$setting->captcha_theme.'" data-size="'.$setting->captcha_size.'" data-type="'.$setting->captcha_type.'" style="display: inline-block;"></div>';
            echo '<input id="txt_captch_error_'.$id.'" type="text" style="display:none;" data-parsley-errors-container="#captch_error_'.$id.'" data-parsley-required="true" value="">';
            echo '<span id="captch_error_'.$id.'"></span>';
            echo '<br/>';
        }
    }
}

if(!function_exists('valid_session')){
    function valid_session($module = '',$action = '') {
        $CI = & get_instance();
        $CI->load->helper('url');
        $CI->session->set_userdata('redirect_url',current_url());
        $user_id = $CI->session->userdata('admin_id');
        $role_id = $CI->session->userdata('role_id');
        if($user_id!=''){
            $permissions = array();
            if($role_id!=1){
                $permissions = $CI->session->userdata('permissions');
                $permissions = unserialize($permissions);
            }
            if($module=='dashboard' || $module=='profile'){ return true; }
            if(empty($permissions) || isset($permissions[$module][$action])){ }
            else{ redirect(site_url('dashboard'), 'refresh');exit; }
            return true;
        }
        else{
            redirect(site_url('login'), 'refresh');exit;
        }
    }
}

if(!function_exists('encode_json')){
    function encode_json($array=array()) {
        header('Content-type: application/json');
        return json_encode($array);
    }
}
if(!function_exists('decode_json')){
    function decode_json($array=array()) {
        return json_decode($array);
    }
}

if(!function_exists('encode_string')){
    function encode_string($string, $url_safe = TRUE) {
        /*$CI = & get_instance();
        $CI->load->library('encrypt');
        $key = $CI->config->item('encryption_key');
        $ret = $CI->encrypt->encode($string, $key);
        if ($url_safe) {
            $ret = strtr(
                $ret, array(
                    '+' => '.',
                    '=' => '-',
                    '=' => '_',
                    '/' => '~'
                )
            );
        }
        return $ret;*/
        return $string;
    }
}
if(!function_exists('decode_string')){
    function decode_string($string) {
        /*$CI = & get_instance();
        $CI->load->library('encrypt');
        $key = $CI->config->item('encryption_key');
        $string = strtr(
            $string, array(
                '.' => '+',
                '-' => '=',
                '_' => '=',
                '~' => '/'
            )
        );
        return $CI->encrypt->decode($string, $key);*/
        return $string;
    }
}

if(!function_exists('display_datetime')){
    function display_datetime($datetime,$type='datetime'){
        $CI = & get_instance();
        $timezone = $CI->session->userdata('timezone');
        $date_format = $CI->session->userdata('date_format');
        $tformat = $CI->session->userdata('time_format');
        $time_format = ($tformat=='12' ? DISPLAY_TIME_FORMAT_12 : DISPLAY_TIME_FORMAT_24);
        
        $time = date(DB_DATETIME_FORMAT, strtotime($datetime));
        $date = new DateTime($time, new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone($timezone));
        if($type=='datetime'){
            return $date->format($date_format.' '.$time_format);
        }
        if($type=='date'){
            return $date->format($date_format);
        }
        if($type=='time'){
            return $date->format($time_format);
        }
    }
}

if(!function_exists('create_datetime')){
    function create_datetime($datetime,$from_utc=true){
        $CI = & get_instance();
        $timezone = $CI->session->userdata('timezone');
        $date_format = $CI->session->userdata('date_format');
        $tformat = $CI->session->userdata('time_format');
        $time_format = ($tformat=='12' ? DISPLAY_TIME_FORMAT_12 : DISPLAY_TIME_FORMAT_24);
        if($from_utc){
            $time = date(DB_DATETIME_FORMAT, strtotime($datetime));
            $date = new DateTime($time, new DateTimeZone('UTC'));
            $date->setTimezone(new DateTimeZone($timezone));
            return  $date->format($date_format.' '.$time_format);
            
        }else{
            $time = date($date_format.' '.$time_format, strtotime($datetime));
            $date = new DateTime($time, new DateTimeZone($timezone));
            $date->setTimezone(new DateTimeZone('UTC'));
            return $date->format(DB_DATETIME_FORMAT);
        }
    }
}

if(!function_exists('gmt_timezone_list')){
    function gmt_timezone_list($return = true) {
        static $timezones = null;
        if ($timezones === null) {
            $timezones = [];
            $offsets = [];
            $now = new DateTime('now', new DateTimeZone('UTC'));
            foreach (DateTimeZone::listIdentifiers() as $timezone) {
                $now->setTimezone(new DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $hours = intval($offset / 3600);
                $minutes = abs(intval($offset % 3600 / 60));
                $gmt =  'UTC' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
                $timezone_name = $timezone;
                $timezone_name = str_replace('_', ' ', $timezone_name);
                $timezone_name = str_replace('St ', 'St. ', $timezone_name);
                $timezones[$timezone] = $timezone_name. ' (' . $gmt . ') ' ;
            }
            array_multisort($offsets, $timezones);
        }
        if($timezones){
            return $timezones;
        }
        echo $timezones;
    }
}

if(!function_exists('date_formats')){
    function date_formats($return = true) {
        $dates =  array();
        $dates['d-m-Y'] = 'd-m-Y';
        $dates['m-d-Y'] = 'm-d-Y';
        $dates['Y-m-d'] = 'Y-m-d';
        if($return){
            return $dates;
        }
        echo $dates;
    }
}

if(!function_exists('time_formats')){
    function time_formats($return = true) {
        $times =  array();
        $times['12'] = '12_hours';
        $times['24'] = '24_hours';
        if($return){
            return $times;
        }
        echo $times;
    }
}

if ( ! function_exists('recache')){
    function recache(){
        $CI=& get_instance();
        $CI->benchmark->mark_time();
        $files = glob(APPPATH.'cache/*');
        foreach($files as $file){
            if(is_file($file) && $file !== '.htaccess' && $file !== 'index.html' ){
                unlink($file);	  	
            }
        }
    }
}

if ( ! function_exists('translate')){
    function translate($word){
        $CI=& get_instance();
        $CI->load->database();
        
        if($set_lang = $CI->session->userdata('language')){} else {
            $set_lang = $CI->db->get_where(TBL_SETTINGS,array('key'=>'default_language'))->row()->value;
        }
        
        
        $r = $CI->db->get_where(TBL_LANGUAGE,array('slug'=>$set_lang,'is_active'=>'1'))->row();
        if($r){}else{
            $set_lang = $CI->db->get_where(TBL_SETTINGS,array('key'=>'default_language'))->row()->value;
            $CI->session->set_userdata('language',$set_lang);
        }
        
        
        $return = '';
        $result = $CI->db->get_where(TBL_LANGUAGE_TRANSLATION,array('word'=>$word));
        if(!empty($result) && $result->num_rows() > 0){
            if($result->row()->$set_lang !== NULL && $result->row()->$set_lang !== ''){
                $return = $result->row()->$set_lang;
                $lang = $set_lang;
            }
            else {
                $return = $result->row()->english;
                $lang = 'english';
            }
            $id = $result->row()->id;
        } else {
            $data['word'] = $word;
            $data['english'] = ucwords(str_replace('_', ' ', $word));
            $CI->db->insert(TBL_LANGUAGE_TRANSLATION,$data);
            $id = $CI->db->insert_id();
            $return = ucwords(str_replace('_', ' ', $word));
            $lang = 'english';
        }
        return $return;
    }
}

if(!function_exists('summernote_editor')){
    function summernote_editor($name,$placeholder='',$default_text='',$required=true){
        $uidx = date('YmdHis');
        $req = $required==true ? 'required' : '';
        $html ='<textarea class="summernote_editor" data-name="'.$name.'" data-placeholder="'.translate($placeholder).'" data-height="200" data-parsley-errors-container="#error_summernote_editor_'.$uidx.'" '.$req.'>'.$default_text.'</textarea>'
            .'<span id="error_summernote_editor_'.$uidx.'"></span>';
        return $html;
    }
}


if (!function_exists('add_log')){
    function add_log($log_data,$type=1,$from=1,$user='',$terminal_id=0){
        unset($log_data['response']);
        unset($log_data['status']);
        
        $CI=& get_instance();
        if($user == ''){
            $user = $CI->session->userdata('admin_id');
        }
        $data['type'] = $type;
        $data['from'] = $from;
        $data['log'] = serialize($log_data);
        $data['terminal_id'] = $terminal_id;
        $data['created_by'] = $user;
        $data['log_created_on'] = date(DB_DATETIME_FORMAT);
        
        $CI->load->database();
        $CI->db->insert(TBL_ADMIN_LOG,$data);
    }
}

if(!function_exists('add_log1')){
    function add_log1($log_data,$admin='',$ter_id,$gp_id,$user_id){
        unset($log_data['response']);
        unset($log_data['status']);
        
        $CI=& get_instance();
        if($admin == ''){
         $admin = $CI->session->userdata('user_id');
        }
        $data['message'] = serialize($log_data);
        $data['groupt_id'] = $gp_id;
        $data['user_id'] = $user_id;
        $data['terminal_id'] = $ter_id;
        $data['created_by'] = $admin;
        $data['log_created_on'] = date(DB_DATETIME_FORMAT);
        $CI->load->database();
        $CI->db->insert(TBL_TERMINAL_LOG,$data);
    }
}

if(!function_exists('schedule_log')){
    function schedule_log($log_data,$user='',$schedulep_id,$schedulel_id){
        unset($log_data['response']);
        unset($log_data['status']);
        
        $CI=& get_instance();
        if($user == ''){
            $user = $CI->session->userdata('admin_id');
        }
       //  $data['type'] = $type;
       // $data['from'] = $from;
        $data['message'] = serialize($log_data);
        $data['schedulel_id'] = $schedulel_id;
        $data['schedulep_id'] = $schedulep_id;
        $data['created_by'] = $user;
        $data['log_created_on'] = date(DB_DATETIME_FORMAT);
        
        $CI->load->database();
        $CI->db->insert(tbl_admin_schedule_log,$data);
    }

    if(!function_exists('playlist_log')){
    function playlist_log($log_data,$user='',$gp_id=0,$playlist_id,$starttime,$endtime,$hourdiff,$ter_id){
        unset($log_data['response']);
        unset($log_data['status']);
        
        $CI=& get_instance();
        if($user == ''){
            $user = $CI->session->userdata('admin_id');
        }
       //  $data['type'] = $type;
       // $data['from'] = $from;
        $data['message'] = serialize($log_data);
        $data['groupt_id'] = $gp_id;
        $data['playlist_id'] = $playlist_id;
        $data['terminal_id'] = $ter_id;
        $data['created_by'] = $user;
        $data['schedule_on'] = $starttime;
        $data['schedule_to'] = $endtime;
        $data['duration'] = $hourdiff;
        $data['log_created_on'] = date(DB_DATETIME_FORMAT);
        
        $CI->load->database();
        $CI->db->insert(TBL_ADMIN_PLAYLIST_LOG,$data);
    }
}
}

if(!function_exists('layout_log')){
    function layout_log($log_data,$user='',$gp_id=0,$layout_id,$starttime,$endtime,$hourdiff,$ter_id){
        unset($log_data['response']);
        unset($log_data['status']);
        
        $CI=& get_instance();
        if($user == ''){
            $user = $CI->session->userdata('admin_id');
        }
       //  $data['type'] = $type;
       // $data['from'] = $from;
        $data['message'] = serialize($log_data);
        $data['groupt_id'] = $gp_id;
        $data['layout_id'] = $layout_id;
        $data['terminal_id'] = $ter_id;
        $data['created_by'] = $user;
        $data['schedule_on'] = $starttime;
        $data['schedule_to'] = $endtime;
        $data['duration'] = $hourdiff;
        $data['log_created_on'] = date(DB_DATETIME_FORMAT);
        
        $CI->load->database();
        $CI->db->insert(TBL_ADMIN_LAYOUT_LOG,$data);
    }
}


if(!function_exists('client_log')){
    function client_log($log_data,$user='',$client=0,$user_id){
        unset($log_data['response']);
        unset($log_data['status']);
        
        $CI=& get_instance();
        if($user == ''){
            $user = $CI->session->userdata('admin_id');
        }
       //  $data['type'] = $type;
       // $data['from'] = $from;
        $data['message'] = serialize($log_data);
        $data['client_id'] = $client;
        $data['user_id'] = $user_id;
       // $data['terminal_id'] = $ter_id;
        $data['created_by'] = $user;
       // $data['schedule_on'] = $starttime;
       // $data['schedule_to'] = $endtime;
       // $data['duration'] = $hourdiff;
        $data['log_created_on'] = date(DB_DATETIME_FORMAT);
        
        $CI->load->database();
        $CI->db->insert(TBL_CLIENT_LOG,$data);
    }
}

