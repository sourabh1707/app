<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Alarm_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Alarmlog_model','Model');
    }
    /*public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'alarm/list';
        $page_data['page_title'] = 'Alarm Log';
        $this->load->view('index',$page_data);
    }*/

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


    public function pdf($id=0){
        $id = $this->uri->segment(3);
      
       // print_r($gid); 
        valid_session($this->module_name,'read');
        $log = $this->CRUD->get_data_row(TBL_ALARM_LOG,array('id' => $id));
        $html = $this->load->view('log/alarm/template-pdf',array('log'=>$log),true);
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
