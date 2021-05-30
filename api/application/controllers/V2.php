<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/V2_Controller.php');
class V2 extends V2_Controller {
    function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->status = 200;
        $this->message = 'success';
        $this->details = 'V2 API Working successfully';
        $this->response();
    }
    public function get_width($return = false) {
        $data = json_encode(array(
            'type' => 'callCardService',
            'fn' => 'getScreenWidth'
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            if ($return) {
                return $response->result;
            }
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }
    public function get_height($return = false) {
        $data = json_encode(array(
            'type' => 'callCardService',
            'fn' => 'getScreenHeight'
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            if ($return) {
                return $response->result;
            }
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }
    public function get_screenshot() {
        $quality = $this->input->post('quality');
        if ($quality == '') {
            $quality = 100;
        }
        $scale = $this->input->post('scale');
        if ($scale == '') {
            $scale = 100;
        }

        $data = json_encode(array(
            'type' => 'callCardService',
            'fn' => 'screenshot',
            'arg1' => (int) $quality,
            'arg2' => (int) $scale
        ));
        $response = $this->post($this->terminal_url, $data);
        //return $response;exit;
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }
    public function start_activity() {
        $activity = $this->input->post('activity');
        if(!$activity){
            $activity = 'com.xixun.xy.xwalk';
        }
        $data = json_encode(array(
            'type' => 'startActivity',
            'apk' => $activity
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }
    public function set_activity_background() {
        $color = $this->input->post('color');
        $data = json_encode(array(
            "type" => "callXwalkFn",
            "fn" => "setBackgroundColor",
            "arg" => $color
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }
    public function set_html() {
        $html = $this->input->post('html', false);
        if ($html == '') {
            $this->details = 'Invalid HTML';
            $this->response();
        }
        $html_file_name = 'HTML_' . '_' . $this->terminal_id . '_' . date("Y-m-d_H-i-s") . '.html';
        
        $data = json_encode(array(
            "type" => "saveStringFile",
            "fileName" => $html_file_name,
            "content" => $this->pre_html.$html
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $url = 'file:///mnt/sdcard/xixun_realtime/'.$html_file_name;
            $response = $this->send_xwalk($url);
            if (isset($response->_type) && $response->_type == 'success') {
                $this->status = 200;
                $this->message = 'success';
                $this->details = '';
            }
        }
        $this->response();
    }
    
    public function set_marquee() {
        $scrolldelay = $this->input->post('scrolldelay');
        if ($scrolldelay == '') {
            $scrolldelay = 0;
        }
        $html = $this->input->post('html', false);
        if ($html == '') {
            $this->details = 'Invalid HTML';
            $this->response();
        }

        $behavior = $this->input->post('behavior');
        if ($behavior == '') {
            $behavior = 'scroll';
        }

        $scrolldelay = $this->input->post('scrolldelay');
        if ($scrolldelay == '') {
            $scrolldelay = 0;
        }
        
        $loop = $this->input->post('loop');
        if ($loop == '') {
            $loop = 'INFINITE';
        }
        
        $direction = $this->input->post('direction');
        if ($direction != 'left' && $direction != 'right') {
            $direction = 'left';
        }

        $align = $this->input->post('align');
        if ($align != 'top' && $align != 'middle' && $align != 'bottom') {
            $align = 'middle';
        }        
        $xhtml = '<marquee align="'.$align.'" loop="'.$loop.'" scrolldelay="'.$scrolldelay.'" behavior="'.$behavior.'" scrolldelay="'.$scrolldelay.'" direction="'.$direction.'">'.$html.'</marquee>';
        $html_file_name = 'HTML_' . '_' . $this->terminal_id . '_' . date("Y-m-d_H-i-s") . '.html';
        $data = json_encode(array(
            "type" => "saveStringFile",
            "fileName" => $html_file_name,
            "content" => $xhtml
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $url = 'file:///mnt/sdcard/xixun_realtime/'.$html_file_name;
            $response = $this->send_xwalk($url);
            if (isset($response->_type) && $response->_type == 'success') {
                $this->status = 200;
                $this->message = 'success';
                $this->details = '';
            }
        }
        $this->response();
    }
    public function set_image() {
        $base64 = $this->input->post('base64', false);
        if ($base64 == '') {
            $this->details = 'Invalid Base64';
            $this->response();
        }
        $background = $this->input->post('background');
        if ($background == '') {
            $background = '#000000';
        }
        $height = $this->input->post('height');
        if ($height == '') {
            $height = $this->get_height(true);
        }
        $width = $this->input->post('width');
        if ($width == '') {
            $width = $this->get_width(true);
        }
        $xhtml = '<!DOCTYPE html><style>body{padding:0;margin:0;}</style><html><body style="background-color:'.$background.';margin:auto;position:relative;"><img src="' . $base64 . '" style="height:' . $height . 'px;width:' . $width . 'px;"></body></html>';
        $html_file_name = 'HTML_' . '_' . $this->terminal_id . '_' . date("Y-m-d_H-i-s") . '.html';
        $data = json_encode(array(
            "type" => "saveStringFile",
            "fileName" => $html_file_name,
            "content" => $xhtml
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $url = 'file:///mnt/sdcard/xixun_realtime/'.$html_file_name;
            $response = $this->send_xwalk($url);
            if (isset($response->_type) && $response->_type == 'success') {
                $this->status = 200;
                $this->message = 'success';
                $this->details = '';
            }
        }
        $this->response();
    }
    public function set_url() {
        $url = $this->input->post('url', false);
        if ($url == '') {
            $this->details = 'Invalid URL';
            $this->response();
        }
        $response = $this->send_xwalk($url);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }
    public function upload_file($type = 'file') {
        $path = $this->file_folder;
        switch ($type) {
            case 'image' : $path = $this->image_folder; break;
            case 'html' : $path = $this->html_folder; break;
            case 'video' : $path = $this->video_folder; break;
            default : $path = $this->file_folder; break;
        }
        $url = $this->input->post('path', false);
        if ($url == '') {
            $this->details = 'Invalid Path';
            $this->response();
        } else {
            $fname = end(explode("/", $url));
            $fdetail = explode(".", $fname);
            $filename = $fdetail[0];
            $extension = $fdetail[1];
            //$file_name = $filename . '_' . date("Y-m-d_H-i-s") . '.' . $extension;
            $file_name = $filename . '.' . $extension;
        }

        $data = json_encode(array(
            "type" => "downloadFileToSD",
            "url" => $url,
            "path" => $this->mmc_url.$path.$file_name
        ));
	
        $response = $this->post($this->terminal_url, $data);
	sleep(10);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = 'file://'.$response->absolutePath;
        }
        $this->response();
	
    }
    public function delete_file_from_sd() {
        $path = $this->input->post('path');
        if ($path == '') {
            $this->details = 'Invalid Path';
            $this->response();
        }
        $data = json_encode(array(
            "type" => "deleteFileFromSD",
            "path" => $path
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }

    public function clear_terminal() {
        $response = $this->send_xwalk();
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }

    public function get_file_size($location = 'file') {
        $expath = $this->file_folder;
        switch ($location) {
            case 'image' : $expath = $this->image_folder; break;
            case 'html' : $expath = $this->html_folder; break;
            case 'video' : $expath = $this->video_folder; break;
            default : $expath = $this->file_folder; break;
        }
        
        $path = $this->input->post('path');
        $fname = end(explode("/", $path));
        $fdetail = explode(".", $fname);
        $filename = $fdetail[0];
        $extension = $fdetail[1];
        //$file_name = $filename . '_' . date("Y-m-d_H-i-s") . '.' . $extension;
        $file_name = $filename . '.' . $extension;
        
        if ($path == '') {
            $this->details = 'Invalid Path';
            $this->response();
        }
        //$path = str_replace('file:///mnt', '', $path);
       // $path = 'file:///mnt'.$this->mmc_url.$expath.$file_name;
        $path = '/'.$this->mmc_url.$expath.$file_name;
        $data = json_encode(array(
            "type" => "getFileLength",
            "url" => $path
        ));
        $response = $this->post($this->terminal_url, $data);
        //print_r($response);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->length;
        }
        $this->response();
    }

    public function get_gps_location() {
        $data = json_encode(array(
            "type" => "getGpsLocation"
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = array('lat' => $response->lat, 'lng' => $response->lng);
        }
        $this->response();
    }

    public function switch_terminal() {
        $status = $this->input->post('status');
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "setScreenOpen",
            "arg1" => ($status != 'on' ? false : true)
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }

    public function get_query_status() {
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "isScreenOpen"
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }

    public function set_brightness() {
        $para1 = $this->input->post('value'); //1-64
        if ($para1 >= 1 && $para1 <= 64) {
            $value = $para1;
        } else {
            $this->details = 'Invalid Value';
            $this->response();
        }
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "setBrightness",
            "arg1" => (int) $value
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }

    public function get_brightness() {
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "getBrightness"
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }

    public function set_volume() {
        $para1 = $this->input->post('value'); //0-15
        if ($para1 >= 0 && $para1 <= 15) {
            $value = $para1;
        } else {
            $this->details = 'Invalid Value';
            $this->response();
        }
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "setVolume",
            "arg1" => (int) $value
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }

    public function get_volume() {
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "getVolume"
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }

    public function get_network_type() {
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "getNetworkType"
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }

    public function set_ntp_server_or_timezone() {
        $server = $this->input->post('server');
        if ($server == '') {
            $this->details = 'Invalid server';
            $this->response();
        }

        $timezone = $this->input->post('timezone');
        if ($timezone == '') {
            $this->details = 'Invalid timezone';
            $this->response();
        }

        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "setTimeSync",
            "arg1" => $server,
            "arg2" => $timezone
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }

    public function get_ntp_server() {
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "getNtpServer"
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }

    public function get_timezone() {
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "getTimezone"
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }

    public function reboot_terminal() {
        $delay = $this->input->post('delay'); //in seconds
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "reboot",
            "arg1" => (int) $delay
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }

    public function get_apk_version() {
        $apk = $this->input->post('apk');
        if ($apk == '') {
            $this->details = 'Invalid APK';
            $this->response();
        }
        $data = json_encode(array(
            "type" => "getPackageVersion",
            "apk" => $apk
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response;
        }
        $this->response();
    }
    public function get_hardware_info() {
        $data = json_encode(array(
            "type" => "callCardService",
            "fn" => "getFpgaInfomation"
        ));

        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = $response->result;
        }
        $this->response();
    }
    public function play_video() {
        $path = $this->input->post('path');
        if ($path == '') {
            $this->details = 'Invalid path';
            $this->response();
        }
        $height = $this->input->post('height');
        if ($height == '') {
            $height = $this->get_height(true);
        }
        $width = $this->input->post('width');
        if ($width == '') {
            $width = $this->get_width(true);
        }
        $loop = $this->input->post('loop');
        if ($loop) {
            $loop = 'loop';
        }
        $muted = $this->input->post('muted');
        if ($muted) {
            $muted = 'muted';
        }
                
        $xhtml = $this->pre_html.'<!DOCTYPE html><style>body{padding:0;margin:0;}</style><html><body><video width="'.$width.'" height="'.$height.'" autoplay '.$loop.' '.$muted.'><source src="'.$path.'" type="video/mp4"><source src="'.$path.'" type="video/ogg"><source src="'.$path.'" type="video/webm">Your browser does not support the video tag.</video></body></html>';
        $html_file_name = 'HTML_' . '_' . $this->terminal_id . '_' . date("Y-m-d_H-i-s") . '.html';
        $data = json_encode(array(
            "type" => "saveStringFile",
            "fileName" => $html_file_name,
            "content" => $xhtml
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $url = 'file:///mnt/sdcard/xixun_realtime/'.$html_file_name;
            $response = $this->send_xwalk($url);
            if (isset($response->_type) && $response->_type == 'success') {
                $this->status = 200;
                $this->message = 'success';
                $this->details = '';
            }
        }
        $this->response();
    }
}
