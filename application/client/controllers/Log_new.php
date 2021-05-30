<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Log_model','Model');
        $this->load->library('excel');
    }
 
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'operation/list';
        $page_data['page_title'] = 'Operation Log';
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
            $page_data['page_name'] = 'operation/list';
            $page_data['search_date'] = $this->Model->fetch_log($start_date,$end_date);
           // print_r($page_data['search_date']); exit();
            $page_data['page_title'] = 'Operation Log';
            $this->load->view('index',$page_data);        
         }
    }

    
 /*   public function pdf($id=0){
        valid_session($this->module_name,'read');
        $log = $this->CRUD->get_data_row(TBL_LOG,array('id' => $id));
        $html = $this->load->view($this->module_name.'/operation/template-pdf',array('log'=>$log),true);
        //echo $html;exit;
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
*/
   /* public function crud($type='',$id=''){
        $id = $id!='' ? decode_string($id) : '';
        $json = array();
        $json['status'] = 201;
        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        $json['details'] = array('Invalid Details');

        
        if($type=='list'){
            $json = array();
            $data = array();
            $data_array = array();

            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order_array = $this->input->post('order');
            $search_array = $this->input->post('search');
            $draw = $this->input->post('draw');


            $where = array();
            $where['start'] = $start;
            $where['length'] = $length;
            if(isset($order_array[0]['column']) && $order_array[0]['column']!=0){
                $col_id = $order_array[0]['column'];
                if($col_id==2){
                    $where['order'] = 'name';
                }
            }
            if(isset($search_array['value']) && $search_array['value']!=''){
                $where['search'] = $search_array['value'];
            }

            $all_count = $this->Model->get_all_count();
            $filtered_count = $this->Model->get_filtered_count($where);

            $data_array = $this->Model->get_datatable($where);
            if(isset($data_array) && !empty($data_array)){
                foreach ($data_array as $d) {
                    $start++;
                    switch ($d->from) {
                        case 1: $from = 'Web';break;
                        case 2: $from = 'WebAPI';break;
                        case 3: $from = 'WebOperations';break;
                        case 4: $from = 'API';break;
                        default: $from = 'Unknown';break;
                    }
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';

                    $pdf = '<a href="'. site_url('log/pdf/'.encode_string($d->id)).'" target="_blank" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="'. translate('pdf').'"><i class="fa fa-file-pdf-o"></i></a>';
                    $row = array();
                    $row[] = $start;
                    $row[] = $d->type==1 ? 'Authanticate' : 'VMS Request';
                    $row[] = $from;
                    $row[] = $this->CRUD->get_data_row(TBL_USER,array('id'=>$d->created_by))->name;
                    $row[] = $d->created_on;
                    $row[] = $details.' '.$pdf;
                    $data[] = $row;
                }
            }
            $json['draw'] = intval($draw);
            $json['recordsTotal'] = intval($all_count);
            $json['recordsFiltered'] = intval($filtered_count);
            $json['data'] = $data;
        }
        
        if($type=='details'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='get_details'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $log = $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$id));
                    if($log){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/operation/template-details',array('terminal'=>$log),true);
                    }
                }
            }
        }
        echo encode_json($json);exit;
    } */
}
