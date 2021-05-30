<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Alarm_log extends MY_Controller {
    public $module_name = 'user_log';
    function __construct() {
        parent::__construct();
        $this->load->model('Alarmlog_model','Model');
    }
 
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'alarm/list';
        //$page_data['page_name'] = 'playlist/export';
        $page_data['page_title'] = 'Alarm Log';
        $page_data['logInfo'] = $this->Model->dataList();
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
            $page_data['page_name'] = 'alarm/list';
            $page_data['search_date'] = $this->Model->fetch_log($start_date,$end_date);
           // print_r($page_data['search_date']); exit();
            $page_data['page_title'] = 'Alarm Log';
            $this->load->view('index',$page_data);        
         }
    }

    
 
}
