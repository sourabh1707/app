<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/V1_Controller.php');
class V1 extends V1_Controller {
    function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->status = 200;
        $this->message = 'success';
        $this->details = 'V1 API Working successfully';
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
    public function set_marquee() {
        $num = $this->input->post('num');
        if ($num == '') {
            $num = -1;
        }
        $html = $this->input->post('html', false);
        if ($html == '') {
            $this->details = 'Invalid HTML';
            $this->response();
        }
        $interval = $this->input->post('interval');
        if ($interval == '') {
            $interval = 50;
        }
        $step = $this->input->post('step');
        if ($step == '') {
            $step = 1;
        }
        $direction = $this->input->post('direction');
        if ($direction != 'left' && $direction != 'right') {
            $direction = 'left';
        }
        $align = $this->input->post('align');
        if ($align != 'top' && $align != 'center' && $align != 'bottom') {
            $align = 'center';
        }
        $data = json_encode(array(
            'type' => 'invokeBuildInJs',
            'method' => 'scrollMarquee',
            'num' => $num,
            'html' => $this->pre_html.$html,
            'interval' => $interval,
            'step' => $step,
            'direction' => $direction,
            'align' => $align,
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
            "fileName" => $this->pre_html.$html_file_name,
            "content" => $html
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $data = json_encode(array(
                "type" => "loadUrl",
                "url" => 'file:///sdcard/xixun_realtime/'.$html_file_name,
                "persistent" => false
            ));
            $response = $this->post($this->terminal_url, $data);
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
        $height = $this->input->post('height');
        if ($height == '') {
            $height = $this->get_height(true);
        }
        $width = $this->input->post('width');
        if ($width == '') {
            $width = $this->get_width(true);
        }
        $html_file_name = 'HTML_' . '_' . $this->terminal_id . '_' . date("Y-m-d_H-i-s") . '.html';
        $data = json_encode(array(
            "type" => "saveStringFile",
            "fileName" => $html_file_name,
            "content" => '<html><body style="background-color:#000;"><img src="' . $base64 . '" style="height:' . $height . 'px;width:' . $width . 'px;"></body></html>'
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $data = json_encode(array(
                "type" => "loadUrl",
                "url" => 'file:///sdcard/xixun_realtime/'.$html_file_name,
                "persistent" => false
            ));
            $response = $this->post($this->terminal_url, $data);
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
        $data = json_encode(array(
            "type" => "loadUrl",
            "url" => $url,
            "persistent" => false
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
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
        $data = json_encode(array(
            "type" => "clear"
        ));
        $response = $this->post($this->terminal_url, $data);
        if (isset($response->_type) && $response->_type == 'success') {
            $this->status = 200;
            $this->message = 'success';
            $this->details = '';
        }
        $this->response();
    }
    public function get_file_size() {
        $path = $this->input->post('path');
        if ($path == '') {
            $this->details = 'Invalid Path';
            $this->response();
        }
        $data = json_encode(array(
            "type" => "getFileLength",
            "url" => $path
        ));
        $response = $this->post($this->terminal_url, $data);
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
}
