<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Client_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Client_log_model','Model');
    }
  
public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'client/list';
        $page_data['page_title'] = 'Client Log';
        $page_data['clientInfo'] = $this->Model->dataList_client();
       // print_r($page_data['layoutInfo']);
        $this->load->view('index',$page_data);
    }

     public function fetch_client_data(){
        $start_date = $this->input->post('fromDate');
        $end_date = $this->input->post('endDate');

         if(isset($_POST['submit'])){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'client/list';
            $page_data['page_title'] = 'Client Log';
            $page_data['search_date'] = $this->Model->fetch_client($start_date,$end_date);
           // print_r($page_data['page_name']); exit();
            $this->load->view('index',$page_data);        
         }
    }

   public function get_details(){
        //echo "hello"; exit();
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        //$page_data['page_name'] = 'terminal/terminal_details';
        $page_data['page_title'] = 'Client Details';
        $id = $this->input->post('id');
        //   print_r($id); exit();
        $id = decode_string($id);
        $client = $this->CRUD->get_data_row(TBL_CLIENT,array('id'=>$id));
        if($client){
        // print_r($client); exit();
        $json['status'] = 200;
        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        $json['details1'] = $this->load->view('log/client/template-client',array('client'=>$client),true);
        print_r($json['details1']); 
        }
    } 

    
}
