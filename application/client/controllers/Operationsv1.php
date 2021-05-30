<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Operationsv1 extends MY_Controller {
    public $module_name = 'operationsv1';
    public $api_url = '';
    function __construct() {
        parent::__construct();
        $this->api_url = API_URL.'v1/';
        $this->load->model('Operationsv1_model','Model');
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
                $terminals = $this->input->post('terminal_id');
                if(isset($terminals)&&!empty($terminals)){
                    foreach ($terminals as $tkey => $tvalue) {
                        $params['terminal_id'] = $tvalue;
                        $api_url = '';
                        if($action=='set_html'){
                            $api_url = $this->api_url.'set_html';
                            $params['html'] = $this->input->post('html_content',false);
                        }
                        else if($action=='set_marquee'){
                            $api_url = $this->api_url.'set_marquee';
                            $params['html'] = $this->input->post('html_content',false);
                            $params['num'] = $this->input->post('num');
                            $params['interval'] = $this->input->post('interval');
                            $params['steps'] = $this->input->post('steps');
                            $params['direction'] = $this->input->post('direction');
                            $params['align'] = $this->input->post('align');
                        }
                        else if($action=='set_image'){
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
                        
                        if($action=='get_screenshot'){
                            $response[$tvalue]['type'] = 'screenshot';
                            $response[$tvalue]['data'] = $this->terminal_screenshot_response($api_url,$params);
                        }
                        else{
                            $response[$tvalue]['type'] = 'default';
                            $response[$tvalue]['data'] = $this->terminal_response($api_url,$params);
                        }
                    }
                }
                if(!empty($response)){
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->load->view($this->module_name.'/template-operations-response',array('response' => $response),true);
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
            $log_data['version'] = 'v1';
            add_log($log_data,3,2);
            
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
            $log_data['version'] = 'v1';
            add_log($log_data,3,2);
            
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
}
