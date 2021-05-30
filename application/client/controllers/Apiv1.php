<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Apiv1 extends MY_Controller {
    public $module_name = 'apiv1';
    public $api_url = '';
    function __construct() {
        parent::__construct();
        $this->api_url = API_URL.'v1/';
        $this->load->model('Apiv1_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'api';
        $page_data['page_title'] = 'Api';
        $this->load->view('index',$page_data);
    }
    public function crud($type=''){
        $json = array();
        $json['status'] = 201;
        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        $json['details'] = array('Invalid Details');
        if($type=='generate'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='get_api_form'){
                    $type = $this->input->post('type');
                    $page_data = array();
                    $is_valid = false;
                    $template = '';
                    switch ($type) {
                        case "get_width":
                            $template = 'template-get_width';
                            $is_valid = true;
                            break;
                        case "get_height":
                            $template = 'template-get_height';
                            $is_valid = true;
                            break;
                        case "set_html":
                            $template = 'template-set_html';
                            $is_valid = true;
                            break;
                        case "set_marquee":
                            $template = 'template-set_marquee';
                            $is_valid = true;
                            break;
                        case "set_image":
                            $template = 'template-set_image';
                            $is_valid = true;
                            break;
                        case "set_url":
                            $template = 'template-set_url';
                            $is_valid = true;
                            break;
                        case "clear_terminal":
                            $template = 'template-clear_terminal';
                            $is_valid = true;
                            break;
                        case "get_gps_location":
                            $template = 'template-get_gps_location';
                            $is_valid = true;
                            break;
                        case "get_query_status":
                            $template = 'template-get_query_status';
                            $is_valid = true;
                            break;
                        case "switch_terminal":
                            $template = 'template-switch_terminal';
                            $is_valid = true;
                            break;
                        case "get_brightness":
                            $template = 'template-get_brightness';
                            $is_valid = true;
                            break;
                        case "set_brightness":
                            $template = 'template-set_brightness';
                            $is_valid = true;
                            break;
                        case "get_volume":
                            $template = 'template-get_volume';
                            $is_valid = true;
                            break;
                        case "set_volume":
                            $template = 'template-set_volume';
                            $is_valid = true;
                            break;
                        case "get_network_type":
                            $template = 'template-get_network_type';
                            $is_valid = true;
                            break;
                        case "set_ntp_server_or_timezone":
                            $template = 'template-set_ntp_server_or_timezone';
                            $is_valid = true;
                            break;
                        case "get_ntp_server":
                            $template = 'template-get_ntp_server';
                            $is_valid = true;
                            break;
                        case "get_timezone":
                            $template = 'template-get_timezone';
                            $is_valid = true;
                            break;
                        case "reboot_terminal":
                            $template = 'template-reboot_terminal';
                            $is_valid = true;
                            break;
                        case "get_apk_version":
                            $template = 'template-get_apk_version';
                            $is_valid = true;
                            break;
                        case "get_hardware_information":
                            $template = 'template-get_hardware_information';
                            $is_valid = true;
                            break;
                        default:
                            $is_valid = false;
                    }
                    if($is_valid && $template!=''){
                        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/'.$template,$page_data,true);
                    }
                }
            }
        }
        if($type=='get_api_response'){
            $action = $this->input->post('action');
            if($action!=''){
                $params = array();
                $terminal_id = $this->input->post('terminal_id');
                if($terminal_id!=''){
                    $params['terminal_id'] = $this->input->post('terminal_id');
                }
                $api_url = '';
                if($action=='get_width'){
                    $api_url = $this->api_url.'get_width';
                }
                else if($action=='get_height'){
                    $api_url = $this->api_url.'get_height';
                }
                else if($action=='set_html'){
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
                else if($action=='clear_terminal'){
                    $api_url = $this->api_url.'clear_terminal';
                }
                else if($action=='get_gps_location'){
                    $api_url = $this->api_url.'get_gps_location';
                }
                else if($action=='get_query_status'){
                    $api_url = $this->api_url.'get_query_status';
                }
                else if($action=='switch_terminal'){
                    $api_url = $this->api_url.'switch_terminal';
                    $params['status'] = $this->input->post('status');
                }
                else if($action=='get_brightness'){
                    $api_url = $this->api_url.'get_brightness';
                }
                else if($action=='set_brightness'){
                    $api_url = $this->api_url.'set_brightness';
                    $params['value'] = $this->input->post('value');
                }
                else if($action=='get_volume'){
                    $api_url = $this->api_url.'get_volume';
                }
                else if($action=='set_volume'){
                    $api_url = $this->api_url.'set_volume';
                    $params['value'] = $this->input->post('value');
                }
                else if($action=='get_network_type'){
                    $api_url = $this->api_url.'get_network_type';
                }
                else if($action=='set_ntp_server_or_timezone'){
                    $api_url = $this->api_url.'set_ntp_server_or_timezone';
                    $params['server'] = $this->input->post('server');
                    $params['timezone'] = $this->input->post('timezone');
                }
                else if($action=='get_ntp_server'){
                    $api_url = $this->api_url.'get_ntp_server';
                }
                else if($action=='get_timezone'){
                    $api_url = $this->api_url.'get_timezone';
                }
                else if($action=='reboot_terminal'){
                    $api_url = $this->api_url.'reboot_terminal';
                    $params['delay'] = $this->input->post('delay');
                }
                else if($action=='get_apk_version'){
                    $api_url = $this->api_url.'get_apk_version';
                    $params['apk'] = $this->input->post('apk');
                }
                else if($action=='get_hardware_information'){
                    $api_url = $this->api_url.'get_hardware_info';
                }
                $response = $this->terminal_response($api_url,$params);
                if($response){
                    $json = $response;
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

            //print_r($response); exit();
            
            $log_data = array();
            $log_data['status'] = true;
            $log_data['response'] = $response;
            $log_data['api'] = str_replace($this->api_url, '', $api_url);
            $log_data['version'] = 'v1';
            $user_id = $this->session->userdata('user_id');
            $terminal_id = $this->CRUD->get_data_row(TBL_TERMINAL,array('name'=>$params['terminal_id']))->id;
            add_log($log_data,2,2,$user_id,$terminal_id);

            if($log_data['api']=='reboot_terminal'){
          $playlist = $this->db->query("SELECT name FROM TBL_TERMINAL where id = $terminal_id ");
          $insertId = $this->db->insert_id();

            foreach ($playlist->result() as $row) {
                    $name= $row->name;
                    }

          $playlist1 = $this->db->query("SELECT id FROM tbl_status_log where terminal_id = '$name' ");

            foreach ($playlist1->result() as $row1) {
                    $tid= $row1->id;
                    }

                    // print_r($tid); exit();

            $up_data = array();
            $up_data['closetime'] = date(DB_DATETIME_FORMAT);
            $up_data['door_status'] = "Closed";
            $up_data['status'] = "offline";
            $upd_id = $this->CRUD->update_data(TBL_ALARM_LOG,$up_data,array('id'=>$tid,'terminal_id'=>$name));
        }
            
            $return['status'] = 200;
            $return['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$return['status']))->row()->msg;
            $return['details'] = $this->load->view($this->module_name.'/template-api-response',array('response'=>$response),true);
                //$return['details'] = $response;
           
            
            return  $return;
            
        }
        return false;
    }
}
