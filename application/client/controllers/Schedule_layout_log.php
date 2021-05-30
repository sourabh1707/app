<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Schedule_layout_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Schedulelog_model','Model');
        $this->load->library('excel');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'schedule/layout_list';
        //$page_data['page_name'] = 'playlist/export';
        $page_data['page_title'] = 'layout Schedule Log';
        $page_data['layoutInfo'] = $this->Model->layout_dataList();
       // print_r($page_data['layoutInfo']);
        $this->load->view('index',$page_data);
    }

    public function fetch_layout_data(){
        $start_date = $this->input->post('fromDate');
        $end_date = $this->input->post('endDate');

         if(isset($_POST['submit'])){
           // $start_date=date("m/d/Y",strtotime($from_date));
           // $end_date=date("m/d/Y",strtotime($to_date));
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'schedule/layout_list';
            $page_data['search_date'] = $this->Model->fetch_layout($start_date,$end_date);
           // print_r($page_data['page_name']); exit();
            $page_data['page_title'] = 'layout Schedule Log';
            $this->load->view('index',$page_data);        
         }
    }

   /* public function generateXls() {
    // create file name
     //   $fileName = 'data-'.time().'.xlsx';  
         $fileName = 'data-'.time().'.xlsx';  
    // load excel library
        $this->load->library('excel');
        //$this->load->model('Download_mod');
        $empInfo = $this->Model->dataList();
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Playlist Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Playlist Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Duration(Second)');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Terminal');

        // set Row   
        $rowCount = 2;
        foreach ($empInfo as $element) {

             $rowCount = 2;
        foreach ($empInfo as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['status']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['duration']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['terminal_id']);
            $rowCount++;
        };
            //print_r($element['name']);exit();
            $rowCount++;
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
       // $objWriter->save($fileName);
        $objWriter->save($fileName);
       // $objWriter->save(ROOT_UPLOAD_IMPORT_PATH.$fileName);
      // download file
        header("Content-Type: application/vnd.ms-excel");
       // $export=ROOT_UPLOAD_IMPORT_PATH;
      //redirect($export.$fileName);    
       redirect($fileName);    
      // redirect(site_url('uopload').$fileName); 
           
    }
    */

   public function get_layout_details(){
                        valid_session($this->module_name,'read');
                        $page_data = array();
                        $page_data['module_name'] = $this->module_name;
                        //$page_data['page_name'] = 'playlist/terminal';
                        $page_data['page_title'] = 'Layout details';
                        $id = $this->input->post('id');
                       // print_r($id); exit();
                        $id = decode_string($id);
                        $layout = $this->CRUD->get_data_row(TBL_LAYOUT,array('id'=>$id));
                        if($layout){
                           // print_r($playlist); exit();
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = $this->load->view('log/schedule/layout_details',array('layout'=>$layout),true);
                            print_r($json['details']); 
                        }
                    } 
         

         

    
    
}
