<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Layout_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Layoutlog_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'layout/layout';
        $page_data['page_title'] = 'layout Log';
        $this->load->view('index',$page_data);
    }

    public function terminal_list()
    {
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'layout/terminal';
        $page_data['page_title'] = 'Terminal Log';
        $user_id = $this->session->userdata('user_id');
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
                            $json['details'] = $this->load->view('log/layout/template-details',array('gtdetails'=>$log),true);
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
                            $json['details'] = $this->load->view('log/layout/template-details1',array('tdetails'=>$log),true);
                            print_r($json['details']); 
                        }
                    } 

        public function get_layout_details(){
            valid_session($this->module_name,'read');
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            //$page_data['page_name'] = 'layout/terminal';
            $page_data['page_title'] = 'Playlist details';
            $id = $this->input->post('id');
            // print_r($id); exit();
            $id = decode_string($id);
            $layout = $this->CRUD->get_data_row(TBL_LAYOUT,array('id'=>$id));
            if($layout){
            // print_r($layout); exit();
            $json['status'] = 200;
            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
            $json['details1'] = $this->load->view('log/layout/layout_details',array('layout'=>$layout),true);
            print_r($json['details1']); 
            }
        } 
         

    public function pdf($id=0){
        $id = $this->uri->segment(3);
      
       // print_r($gid); 
        valid_session($this->module_name,'read');
        $log = $this->CRUD->get_data_row(TBL_LAYOUT_LOG,array('id' => $id));
        $html = $this->load->view('log/layout/template-pdf',array('log'=>$log),true);
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
