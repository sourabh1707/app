<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Download_model');
        $this->load->library('excel');
  }

    public function index()
    {
        $page_data = array();
        $page_data['header_setting'] = $this->header_setting;
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'playlist/export';
        $page_data['page_title'] = 'Download';
        $page_data['employeeInfo'] = $this->Download_model->dataList();
        //print_r($page_data); exit();
        $this->load->view('index',$page_data);
}

/*
public function generateXls() {
        // create file name
        $fileName = 'mobile-'.time().'.xlsx';  
       // require_once APPPATH . "/third_party/PHPExcel.php";

        // load excel library
        $this->load->library('excel');
       // $mobiledata = $this->export->mobileList();
        $mobiledata = $this->Download_mod->dataList();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Plalist Name.');       
        // set Row
        $rowCount = 2;
        foreach ($mobiledata as $val) 
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $val['name']);
            $rowCount++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save($fileName);
        // download file
        header("Content-Type: application/vnd.ms-excel");
         redirect(site_url().$fileName);              
    }
*/


  // create xlsx
    public function generateXls() {
    // create file name
     //   $fileName = 'data-'.time().'.xlsx';  
         $fileName = 'data-'.time().'.xlsx';  
    // load excel library
        $this->load->library('excel');
        //$this->load->model('Download_mod');
        $empInfo = $this->Download_model->dataList();
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Playlist Name');
        // set Row
        $rowCount = 2;
        foreach ($empInfo as $element) {

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['name']);
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
    
}