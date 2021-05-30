<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Terminal_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('terminallog_model','Model');
    }

 public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'terminal/terminal';
        $page_data['page_title'] = 'Terminal Log';
        $page_data['terminalInfo'] = $this->Model->dataList_terminal();
       // print_r($page_data['layoutInfo']);
        $this->load->view('index',$page_data);
    }

public function fetch_terminal_data(){
        $start_date = $this->input->post('fromDate');
        $end_date = $this->input->post('endDate');

         if(isset($_POST['submit'])){
           // $start_date=date("m/d/Y",strtotime($from_date));
           // $end_date=date("m/d/Y",strtotime($to_date));
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'terminal/terminal';
            $page_data['page_title'] = 'Terminal Log';
            $page_data['search_date'] = $this->Model->fetch_terminal($start_date,$end_date);
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
        $page_data['page_title'] = 'Terminal details';
        $id = $this->input->post('id');
        //   print_r($id); exit();
        $id = decode_string($id);
        $terminal = $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$id));
        if($terminal){
        // print_r($terminal); exit();
        $json['status'] = 200;
        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        $json['details1'] = $this->load->view('log/terminal/terminal_details',array('terminal'=>$terminal),true);
        print_r($json['details1']); 
        }
    } }      


