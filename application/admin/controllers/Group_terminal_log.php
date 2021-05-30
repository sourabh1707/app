<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Group_terminal_log extends MY_Controller {
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
        $page_data['page_name'] = 'terminal/group_terminal';
        $page_data['page_title'] = 'Group terminal Log';
        $page_data['terminalInfo'] = $this->Model->dataList_gterminal();
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
            $page_data['page_name'] = 'terminal/group_terminal';
            $page_data['page_title'] = 'Group terminal Log';
            $page_data['search_date'] = $this->Model->fetch_gterminal($start_date,$end_date);
           // print_r($page_data['page_name']); exit();
            $this->load->view('index',$page_data);        
         }
    }

   public function get_details(){
                valid_session($this->module_name,'read');
                $page_data = array();
                $page_data['module_name'] = $this->module_name;
                //$page_data['page_name'] = 'playlist/terminal';
                $page_data['page_title'] = 'Terminal details';
                $id = $this->input->post('id');
                $id = decode_string($id);
                $gtdetails = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$id));
               // print_r($gtdetails); exit();
                if($gtdetails){
                $json['status'] = 200;
                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                $json['details1'] = $this->load->view('log/terminal/group_details',array('gtdetails'=>$gtdetails),true);
                print_r($json['details1']); 
                }
            }


   }