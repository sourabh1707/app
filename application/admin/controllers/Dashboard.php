<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Dashboard extends MY_Controller {
    public $module_name = 'dashboard';
    function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model','Model');
    }
    public function index(){
    // $user_id = $this->session->userdata('user_id');
    //     $pass_status = $this->db->get_where(TBL_USER,array('id'=>$user_id))->row()->pass_status;
    //     if($pass_status==0)
    //     { 
    //         redirect(site_url('change_password'),'refresh');exit();
    //     }
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
        $api_url = API_URL.'v1/';
        $set_api_url = $api_url.'get_query_status';
        $ssparams = array();
        $ssparams['terminal_id'] = $this->input->post('terminal_id');
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
        $api_url = API_URL.'v2/';
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

            //echo '<pre>';print_r($response);echo '</pre>';
            // $myresponse = isset($response[0]) && !empty($response[0]) ? $response[0] : array();
            $myresponse = isset($response->details[0]) && !empty($response->details[0]) ? $response->details[0] : array();

            if(isset($myresponse->doorOpened) && $myresponse->doorOpened=='Open'){
                $fresponse['status'] = 201;
            }
            else if(isset($myresponse->doorOpened) && $myresponse->doorOpened=='Close'){
                $fresponse['status'] = 202;
            }
            else{
                $fresponse['status'] = 200;
            }
            //echo '<pre>';print_r($response);echo '</pre>';
            // print_r($response);
        }
        echo encode_json($fresponse);
    }
}