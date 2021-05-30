<?php defined('BASEPATH') OR exit('No direct script access allowed');
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

function UR_exists($url){
    
    $headers=get_headers($url);
    return stripos($headers[0],"200 OK")?true:false;
    
    /*
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $httpCode == 200 ? true : false;
    */
    //return is_file($url) && file_exists($url) ? true : false;
    //return file_get_contents($url) ? true : false;
}

if(!function_exists('encode_string')){
    function encode_string($string, $url_safe = TRUE) {
        $CI = & get_instance();
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
        return $ret;
    }
}
if(!function_exists('decode_string')){
    function decode_string($string) {
        $CI = & get_instance();
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
        return $CI->encrypt->decode($string, $key);
    }
}

if(!function_exists('display_datetime')){
    function display_datetime($datetime,$type='datetime'){
        $CI = & get_instance();
        $timezone = DISPLAY_TIMEZONE;
        $date_format = DISPLAY_DATE_FORMAT;
        $tformat = DISPLAY_TIME_FORMAT;
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
if (!function_exists('add_log')){
    function add_log($log_data,$type=1,$from=1,$user='',$terminal_id=0){
        $CI=& get_instance();
        if($user == ''){
            $user = $CI->session->userdata('user_id');
        }
        $data['type'] = $type;
        $data['from'] = $from;
        $data['log'] = serialize($log_data);
        $data['terminal_id'] = $terminal_id;
        $data['created_by'] = $user;
        $data['created_on'] = date(DB_DATETIME_FORMAT);
        
        $CI->load->database();
        $CI->db->insert(TBL_LOG,$data);
    }
}