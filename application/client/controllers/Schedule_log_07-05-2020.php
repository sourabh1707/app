<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Schedule_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Schedulelog_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'schedule/list';
        $page_data['page_title'] = 'Schedule Log';
        $this->load->view('index',$page_data);
    }

    public function pdf($id=0){
        $id = $this->uri->segment(3);
        valid_session($this->module_name,'read');
        $log = $this->CRUD->get_data_row(tbl_schedule_log,array('id' => $id));
        $html = $this->load->view('log/schedule/template-pdf',array('log'=>$log),true);
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

    public function get_playlist_details(){
                        valid_session($this->module_name,'read');
                        $page_data = array();
                        $page_data['module_name'] = $this->module_name;
                        //$page_data['page_name'] = 'billing/terminal';
                        $page_data['page_title'] = 'Playlist details';
                        $id = $this->input->post('id');
                       //print_r($id); exit();
                        $id = decode_string($id);
                        $playlist = $this->CRUD->get_data_row(TBL_SCHEDULE,array('id'=>$id));
                        if($playlist){
                           // print_r($playlist); exit();
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details1'] = $this->load->view('log/schedule/playlist_details',array('playlist'=>$playlist),true);
                            print_r($json['details1']); 
                        }
                    } 

    public function get_playlist_details1(){
                valid_session($this->module_name,'read');
                $page_data = array();
                $page_data['module_name'] = $this->module_name;
                //$page_data['page_name'] = 'billing/terminal';
                $page_data['page_title'] = 'Playlist details';
                $id = $this->input->post('id');
               // print_r($id); exit();
                $id = decode_string($id);
                $playlist = $this->CRUD->get_data_row(TBL_SCHEDULE_L,array('id'=>$id));
                if($playlist){
                // print_r($playlist); exit();
                $json['status'] = 200;
                 $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                $json['details2'] = $this->load->view('log/schedule/playlist_details',array('playlist1'=>$playlist),true);
                print_r($json['details2']);
                }
            } 
    
}
