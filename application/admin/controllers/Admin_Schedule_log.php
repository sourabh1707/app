<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Admin_Schedule_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Admin_Schedule_model','Model');
    }
  
 public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'schedule/list';
        $page_data['page_title'] = 'Playlist Schedule Log';
        $page_data['employeeInfo'] = $this->Model->dataList();
       // print_r($page_data['employeeInfo']);
        $this->load->view('index',$page_data);
    }
 public function fetch_data(){
        $start_date = $this->input->post('fromDate');
        $end_date = $this->input->post('endDate');

         if(isset($_POST['submit'])){
           // $start_date=date("m/d/Y",strtotime($from_date));
           // $end_date=date("m/d/Y",strtotime($to_date));
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'schedule/list';
            $page_data['search_date'] = $this->Model->fetch($start_date,$end_date);
           // print_r($page_data['page_name']); exit();
            $page_data['page_title'] = 'Playlist Schedule Log';
            $this->load->view('index',$page_data);        
         }
    }
   
    public function get_playlist_details(){
                        valid_session($this->module_name,'read');
                        $page_data = array();
                        $page_data['module_name'] = $this->module_name;
                        //$page_data['page_name'] = 'playlist/terminal';
                        $page_data['page_title'] = 'Playlist details';
                        $id = $this->input->post('id');
                       // print_r($id); exit();
                        $id = decode_string($id);
                        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                        if($playlist){
                           // print_r($playlist); exit();
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details1'] = $this->load->view('log/schedule/playlist_details',array('playlist'=>$playlist),true);
                            print_r($json['details1']); 
                        }
                    }      

 
    
}
