<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Dashboard extends MY_Controller {
    public $module_name = 'dashboard';
    function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model','Model');
    }
    public function index(){
        valid_session($this->module_name);
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = 'Dashboard';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','type'=>'1'));
        $page_data['boards'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','type'=>'2'));
        $this->load->view('index',$page_data);
    }
    public function get_status(){
        $user_id = $this->session->userdata('admin_id');
        $api_url = API_URL.'v1/';
        //$set_api_url = $api_url.'get_hardware_info';  //get_query_status
        $set_api_url = $api_url.'get_query_status';  //get_hardware_info
        $ssparams = array();
        $id=$this->input->post('terminal_id');
        $ssparams['terminal_id'] = $this->input->post('terminal_id');
        //print_r($ssparams['terminal_id']); exit();
        if($ssparams['terminal_id']!=''){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $set_api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ssparams));
            $response = curl_exec($ch);
            $response = decode_json($response);
        }

        echo encode_json($response);
        
    }

    public function get_door_status(){
        $fresponse['status'] = 200;
        $api_url = API_URL.'v1/';
        $set_api_url = $api_url.'get_hardware_info';
        $ssparams = array();
        $ssparams['terminal_id'] = $this->input->post('terminal_id');
        if($ssparams['terminal_id']!=''){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $set_api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ssparams));
            $response = curl_exec($ch);
            $response= decode_json($response);

            // echo '<pre>';print_r($response);echo '</pre>';
            // echo '<pre>';print_r($response->details[0]->doorOpened);echo '</pre>';

            $myresponse = isset($response->details[0]) && !empty($response->details[0]) ? $response->details[0] : array();
            // $myresponse = isset($response[0]) && !empty($response[0]) ? $response[0] : array();
            // echo '<pre>';print_r($myresponse->doorOpened);echo '</pre>';

            if(isset($myresponse->doorOpened) && $myresponse->doorOpened=='Open'){
                $fresponse['status'] = 201;
            }
            else if(isset($myresponse->doorOpened) && $myresponse->doorOpened=='Close'){
                $fresponse['status'] = 202;
            }
            else{
                $fresponse['status'] = 200;
            }
            // echo '<pre>';print_r($response);echo '</pre>';
            // print_r($response);
        }
        echo encode_json($fresponse);
    } 
    
}