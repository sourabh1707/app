<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Billing_log extends MY_Controller {
    public $module_name = 'user_log';
    function __construct() {
        parent::__construct();
        $this->load->model('Billinglog_model','Model');
        $this->load->library('excel');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'billing/list';
        //$page_data['page_name'] = 'playlist/export';
        $page_data['page_title'] = 'Billing Log';
        $page_data['employeeInfo'] = $this->Model->dataList();
       // print_r($page_data['employeeInfo']);
        $this->load->view('index',$page_data);
    }

     public function cal(){
                        valid_session($this->module_name,'read');
                        /*$page_data = array();
                        $page_data['module_name'] = $this->module_name;
                        $page_data['page_name'] = 'billing/calculate';
                        $page_data['page_title'] = 'Playlist details';
                        */
                        $user_id = $this->session->userdata('user_id');
                        $updated_on= date(DB_DATETIME_FORMAT); 
                        $rate = $this->input->post('rate');
                        $time = $this->input->post('time');
                        $total = $this->input->post('answer');
                       // $aa=$this->input->post('$timediff');
                        $pid = $this->uri->segment(6);
                        $playlistid = $this->uri->segment(4);
                        $duration = $this->uri->segment(5);
                        $terminalid = $this->uri->segment(3);
                       // print_r($dd['duration']); exit();
                       // $page_data['dd'] = $this->uri->segment(5);
                        $this->load->view('log/billing/calculate', true);
                      if(isset($_POST['submit'])){
                        $data = array();
                        $data['rate'] = $rate;
                        $data['time'] = $time;
                        $data['total'] = $total;
                        $data['created_by'] = $user_id;
                        $data['created_on'] = $updated_on;
                        $data['playlist_log_id'] = $pid;
                        $data['terminal_id'] = $terminalid;
                        $data['playlist_id'] = $playlistid;
                        $data['duration'] = $duration;
                        $data['flag'] = '1';

                       // print_r( $data); exit();
                 // $upd_id = $this->CRUD->update_data(TBL_ALARM_LOG,$data,array('id'=>$id));
                  $upd_id = $this->CRUD->insert_data(tbl_billing_log,$data);
                 // print_r($upd_id); exit();
                //  $insert=$this->db->insert('tbl_status_log', $data);
                  // echo json_encode($upd_id);
                  if($upd_id){
                    $message = "Successfully Inserted.";
                     //echo 'You have registered successfully.';
                    echo "<script type='text/javascript'>alert('$message');</script>";
                  // redirect('http://localhost:8080/app/billing_log.html', 'refresh'); 
                     redirect(base_url().'billing_log','refresh');
                     }
                   /*  else{
                        $message = "Incorrect data...Please check Again.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                     } */
                    }                  
                    }

 

    public function fetch_data(){
        $start_date = $this->input->post('fromDate');
        $end_date = $this->input->post('endDate');

         if(isset($_POST['submit'])){
           // $start_date=date("m/d/Y",strtotime($from_date));
           // $end_date=date("m/d/Y",strtotime($to_date));
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'billing/list';
            $page_data['search_date'] = $this->Model->fetch($start_date,$end_date);
           // print_r($page_data['page_name']); exit();
            $page_data['page_title'] = 'Billing Log';
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
                            $json['details1'] = $this->load->view('user_log/billing/playlist_details',array('playlist'=>$playlist),true);
                            print_r($json['details1']); 
                        }
                    } 
         

    
    
}
