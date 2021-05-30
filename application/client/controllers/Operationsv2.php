<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Operationsv2 extends MY_Controller {
    public $module_name = 'operationsv2';
    public $api_url = '';
    function __construct() {
        parent::__construct();
        $this->api_url = API_URL.'v2/';
        $this->load->model('Operationsv2_model','Model');
    }
    public function html(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'template-set_html';
        $page_data['page_title'] = 'operations';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        $this->load->view('index',$page_data);
    }
    public function marquee(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'template-set_marquee';
        $page_data['page_title'] = 'operations';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        $this->load->view('index',$page_data);
    }
    public function image(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'template-set_image';
        $page_data['page_title'] = 'operations';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        $this->load->view('index',$page_data);
    }
    public function url(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'template-set_url';
        $page_data['page_title'] = 'operations';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        $this->load->view('index',$page_data);
    }
    public function screenshot(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'template-screenshot';
        $page_data['page_title'] = 'operations';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        $this->load->view('index',$page_data);
    }
    public function video(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'template-set_video';
        $page_data['page_title'] = 'operations';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        $this->load->view('index',$page_data);
    }
    public function crud($type=''){
        $json = array();
        $json['status'] = 201;
        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        $json['details'] = array('Invalid Details');
        if($type=='get_api_response'){
            $action = $this->input->post('action');
            if($action!=''){
                $params = array();
                $response = array();
                $tresponse = array();
                $terminals = $this->input->post('terminal_id');
                if(isset($terminals)&&!empty($terminals)){
                    foreach ($terminals as $tkey => $tvalue) {
                        $params['terminal_id'] = $tvalue;
                        $api_url = '';
                        if($action=='set_html'){
                            $this->set_background($tvalue);
                            $api_url = $this->api_url.'set_html';
                            $params['html'] = $this->input->post('html_content',false);
                        }
                        else if($action=='set_marquee'){
                            $this->set_background($tvalue);
                            $api_url = $this->api_url.'set_marquee';
                            $params['html'] = $this->input->post('html_content',false);
                            $params['scrolldelay'] = $this->input->post('scrolldelay');
                            $params['loop'] = $this->input->post('loop');
                            $params['direction'] = $this->input->post('direction');
                            $params['align'] = $this->input->post('align');
                            $params['behavior'] = $this->input->post('behavior');
                        }
                        else if($action=='set_image'){
                            $this->set_background($tvalue);
                            $params['base64'] = $this->input->post('image',false);
                            $params['height'] = $this->input->post('height');
                            $params['width'] = $this->input->post('width');
                            $api_url = $this->api_url.'set_image';
                        }
                        else if($action=='set_url'){
                            $api_url = $this->api_url.'set_url';
                            $params['url'] = $this->input->post('url',false);
                        }
                        else if($action=='get_screenshot'){
                            $api_url = $this->api_url.'get_screenshot';
                        }
                        else if($action=='set_video'){
                            $this->set_background($tvalue);
                            
                            $sdpath = $this->input->post('url');
                            $api_url = $this->api_url.'upload_file/video';
                            
                            $params['terminal_id'] = $tvalue;
                            $params['path'] = $sdpath;
                            
                            $response = $this->terminal_response($api_url,$params);

                            if(isset($response['status']) && $response['status']==200){
                                $datails = json_decode($response['details']);
                                $sdpath = $datails->details;
                                /*for ($j = 0; $j < 5; $j++) {
                                    $params = array();
                                    $params['terminal_id'] = $terminal;
                                    $params['path'] = $sdpath;
                                    $api_url = $this->api_url.'get_file_size';
                                    $response = $this->terminal_response($api_url,$params);
                                    echo '<br/>'.$j.'Response => ';print_r($response);
                                    sleep(2);
                                }*/
                            }
                            
                            $api_url = $this->api_url.'play_video';
			   

                         
			$fname = end(explode("/", $this->input->post('url')));
            		$fdetail = explode(".", $fname);
           		$filename = $fdetail[0];
            		$extension = $fdetail[1];
            		$file_name = $filename . '.' . $extension;
			    //  $params['path'] = $sdpath;
			    $params['path'] = "file://mnt/sdcard/ador/video/".$file_name;
                            $params['width'] = $this->input->post('width');
                            $params['height'] = $this->input->post('height');
                            $params['loop'] = $this->input->post('loop');
                            $params['muted'] = $this->input->post('muted');
                        }
                        if($action=='get_screenshot'){
                            $tresponse[$tvalue]['type'] = 'screenshot';
                            $tresponse[$tvalue]['data'] = $this->terminal_screenshot_response($api_url,$params);
                        }
                        else{
                            $tresponse[$tvalue]['type'] = 'default';
                            $tresponse[$tvalue]['data'] = $this->terminal_response($api_url,$params);
                        }
                    }
                }
                if(!empty($tresponse)){
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->load->view($this->module_name.'/template-operations-response',array('response' => $tresponse),true);
                }
            }
        }
        echo encode_json($json);exit;
    }
    function terminal_response($api_url,$params){
        if($api_url!='' && !empty($params)){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            $response = curl_exec($ch);
            
            $log_data = array();
            $log_data['status'] = true;
            $log_data['response'] = $response;
            $log_data['api'] = str_replace($this->api_url, '', $api_url);
            $log_data['version'] = 'v2';
            $user_id = $this->session->userdata('user_id');
            $terminal_id = $this->CRUD->get_data_row(TBL_TERMINAL,array('name'=>$params['terminal_id']))->id;
            add_log($log_data,2,2,$user_id,$terminal_id);
            
            $return['status'] = 200;
            $return['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$return['status']))->row()->msg;
            $return['details'] = $response;
            return  $return;
        }
        return false;
    }
    function terminal_screenshot_response($api_url,$params){
        if($api_url!='' && !empty($params)){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            $response = curl_exec($ch);
            
            $log_data = array();
            $log_data['status'] = true;
            $log_data['response'] = $response;
            $log_data['api'] = str_replace($this->api_url, '', $api_url);
            $log_data['version'] = 'v2';
            $user_id = $this->session->userdata('user_id');
            $terminal_id = $this->CRUD->get_data_row(TBL_TERMINAL,array('name'=>$params['terminal_id']))->id;
            add_log($log_data,2,2,$user_id,$terminal_id);
            
            $response = json_decode($response);
            if(isset($response->status) && $response->status==200){
                $return['status'] = 200;
                $return['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$return['status']))->row()->msg;
                $return['details'] = '<img src="data:image/png;base64, '.$response->details.'" alt="screenshot" style="max-width:100%;height:auto;">';
            }
            else{
                $return['status'] = 205;
                $return['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$return['status']))->row()->msg;
                $return['details'] = '';
            }
            return  $return;
        }
        return false;
    }
    function set_background($terminal_id){
        $params = array();
        $params['color'] = $this->input->post('value');
        $params['terminal_id'] = $terminal_id;
        
        if($params['color']!='' && $params['terminal_id']!=''){
            $api_url = $this->api_url.'set_activity_background';            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            $response = curl_exec($ch);
            
            $log_data = array();
            $log_data['status'] = true;
            $log_data['response'] = $response;
            $log_data['api'] = str_replace($this->api_url, '', $api_url);
            $log_data['version'] = 'v2';
            $user_id = $this->session->userdata('user_id');
            $terminal_id = $this->CRUD->get_data_row(TBL_TERMINAL,array('name'=>$params['terminal_id']))->id;
            add_log($log_data,2,2,$user_id,$terminal_id);
            
            return  true;
        }
        return false;
    }
}
