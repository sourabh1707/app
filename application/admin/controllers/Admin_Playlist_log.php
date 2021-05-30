<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Admin_Playlist_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Admin_Playlist_model','Model');
    }
     public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'playlist/playlist';
        $page_data['page_title'] = 'Playlist Log';
        $page_data['employeeInfo'] = $this->Model->dataList();
        //print_r($page_data['employeeInfo']); exit();
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
            $page_data['page_name'] = 'playlist/playlist';
            $page_data['search_date'] = $this->Model->fetch($start_date,$end_date);
           // print_r($page_data['page_name']); exit();
            $page_data['page_title'] = 'Playlist Log';
            $this->load->view('index',$page_data);        
         }
    }


    public function terminal_list()
    {
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'playlist/terminal';
        $page_data['page_title'] = 'Terminal Log';
        $user_id = $this->session->userdata('admin_id');
        $page_data['terminals'] = $this->CRUD->get_data(TBL_GROUP_TERMINAL,array('is_active'=>'1','is_delete'=>'1','user_id'=>$user_id));
        $this->load->view('index',$page_data);
}


    public function get_details(){
                        valid_session($this->module_name,'read');
                        $page_data = array();
                        $page_data['module_name'] = $this->module_name;
                        //$page_data['page_name'] = 'playlist/terminal';
                        $page_data['page_title'] = 'Terminal List';
                        $id = $this->input->post('id');
                       // print_r($id); exit();
                        $id = decode_string($id);
                        $log = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$id));
                        if($log){
                            //print_r($log); exit();
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view('log/playlist/template-details',array('gtdetails'=>$log),true);
                        print_r($json['details']); 
                        }
                    } 


                    public function get_details1(){
                        valid_session($this->module_name,'read');
                        $page_data = array();
                        $page_data['module_name'] = $this->module_name;
                        //$page_data['page_name'] = 'playlist/terminal';
                        $page_data['page_title'] = 'Single Terminal List';
                        $id = $this->input->post('id');
                       // print_r($id); exit();
                        $id = decode_string($id);
                        $log = $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$id));
                        if($log){
                            //print_r($log); exit();
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view('log/playlist/template-details1',array('tdetails'=>$log),true);
                        print_r($json['details']); 
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
         $json['details1'] = $this->load->view('log/playlist/playlist_details',array('playlist'=>$playlist),true);
         print_r($json['details1']); 
        }
    }

    public function pdf($id=0){
        $id = $this->uri->segment(3);
      
       // print_r($gid); 
        valid_session($this->module_name,'read');
        $log = $this->CRUD->get_data_row(TBL_ADMIN_PLAYLIST_LOG,array('id' => $id));
        $html = $this->load->view('log/playlist/template-pdf',array('log'=>$log),true);
       // print_r($log);exit;
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Log Report');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Ador');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Log_Report.pdf', 'I');
    }
    
}
