<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class V1_Controller extends CI_Controller {
    var $terminal_id = '' ;
    var $terminal_folder = '' ;
    var $terminal_url = '' ;
    var $mmc_url = '/ador/';//xixun_realtime
    var $status = '500' ;
    var $message = 'Error' ;
    var $details = 'A unknown Error was encountered' ;
    var $html_folder = 'html/';
    var $image_folder = 'image/';
    var $video_folder = 'video/';
    var $file_folder = 'file/';
    var $pre_html = '';
    function __construct() {
        parent::__construct();
	$this->pre_html = '<link rel="stylesheet" href="'.base_url('fonts/index.css').'">';
        $class = $this->router->fetch_class();
        $method = $this->router->fetch_method();
        if($method!='index'){
            $terminal_id = $this->input->post('terminal_id');
            $terminal = $this->CRUD->get_data_row(TBL_TERMINAL,array('name' => $terminal_id, 'is_active' => '1'));
            if(empty($terminal)){
                $json = array();
                $json['status'] = $this->status;
                $json['message'] = $this->message;
                $json['details'] = 'Invalid Terminal Id';
                echo encode_json($json);exit;
            }
            $this->terminal_id = $terminal_id;
            $this->terminal_folder = $this->terminal_id.'/';
            $this->terminal_url = 'http://adorvms.com:8888/command/'.$this->terminal_id;
        }
    }
    public function post($url, $data) {
        $postdata = $data;
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/json; charset=utf-8',
                'content' => $postdata
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return decode_json($result);exit;
    }
    public function response() {
        $json = array(); 
        $json['status'] = $this->status;
        $json['message'] = $this->message;
        $json['details'] = $this->details;
        echo encode_json($json);exit;
    }
}
