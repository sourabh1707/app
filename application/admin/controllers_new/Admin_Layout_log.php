<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Admin_Layout_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Admin_Layout_model','Model');
        $this->load->library('excel');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'layout/layout';
        //$page_data['page_name'] = 'playlist/export';
        $page_data['page_title'] = 'Layout Log';
        $page_data['layoutInfo'] = $this->Model->dataList();
       // print_r($page_data['employeeInfo']);
        $this->load->view('index',$page_data);
    }

    public function fetch_data(){
         $start_date = $this->input->post('fromDate');
         $end_date = $this->input->post('endDate');
         if(isset($_POST['submit'])){
            //$start_date=date("m/d/Y",strtotime($from_date1));
           // $end_date=date("m/d/Y",strtotime($to_date1));
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'layout/layout';
            $page_data['search_date'] = $this->Model->fetch($start_date,$end_date);
           // print_r($page_data['search_date']); exit();
            $page_data['page_title'] = 'Layout Log';
            $this->load->view('index',$page_data);        
         }
    }


                    public function get_layout_details(){
                        valid_session($this->module_name,'read');
                        $page_data = array();
                        $page_data['module_name'] = $this->module_name;
                        //$page_data['page_name'] = 'playlist/terminal';
                        $page_data['page_title'] = 'Layout details';
                        $id = $this->input->post('id');
                       // print_r($id); exit();
                        $id = decode_string($id);
                        $playlist = $this->CRUD->get_data_row(TBL_LAYOUT,array('id'=>$id));
                        if($playlist){
                           // print_r($playlist); exit();
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details1'] = $this->load->view('log/layout/layout_details',array('layout'=>$playlist),true);
                            print_r($json['details1']); 
                        }
                    } 
         

    
    
}
