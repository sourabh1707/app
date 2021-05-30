<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Billing_log extends MY_Controller {
    public $module_name = 'log';
    function __construct() {
        parent::__construct();
        $this->load->model('Billinglog_model','Model');
        $this->load->library('form_validation');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'billing/list';
        $page_data['page_title'] = 'Billing Log';


        $this->load->view('index',$page_data);
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


                      //  $id = $this->input->post('tt');
                        $res = $this->input->post('result');
                        $up_data = array();
                        $up_data['total'] = $res;
                        $upd_id = $this->CRUD->update_data(TBL_ALARM_LOG,$up_data,array('id'=>$id));


                        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                        if($playlist){
                           // print_r($playlist); exit();
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details1'] = $this->load->view('log/billing/playlist_details',array('playlist'=>$playlist),true);
                            print_r($json['details1']); 
                        }
                    } 

                    public function cal(){
                        valid_session($this->module_name,'read');
                        $page_data = array();
                        $page_data['module_name'] = $this->module_name;
                        $page_data['page_name'] = 'billing/calculate';
                        $page_data['page_title'] = 'Playlist details';
                        $this->load->view('log/billing/calculate',true);
                        $user_id = $this->session->userdata('user_id');
                        $updated_on= date(DB_DATETIME_FORMAT); 
                        $rate = $this->input->post('rate');
                        $time = $this->input->post('time');
                        $total = $this->input->post('answer');
                       // $aa=$this->input->post('$timediff');
                        $id = $this->uri->segment(3);
                        $playlistid = $this->uri->segment(4);
                        $duration = $this->uri->segment(5);
                        $terminalid = $this->uri->segment(6);

                       /* $this->form_validation->set_rules('time','time','required');
                        $this->form_validation->set_rules('rate','rate','required');
                       if($this->form_validation->run()== TRUE){
                        $user_id = $this->session->userdata('user_id');
                        $created_on= date(DB_DATETIME_FORMAT); 
                        $rate = $this->input->post('rate');
                        $time = $this->input->post('time');
                        $total = $this->input->post('total');

*/
                         // print_r($_POST['submit']);  exit();
                   
                    if(isset($_POST['submit'])){
                        $data = array();
                        $data['rate'] = $rate;
                        $data['time'] = $time;
                        $data['total'] = $total;
                       // $data['updated_by'] = $user_id;
                        //$data['updated_on'] = $updated_on;
                        $data['created_by'] = $user_id;
                        $data['created_on'] = $updated_on;
                        $data['alarm_id'] = $id;
                        $data['terminal_name'] = $terminalid;
                        $data['playlist_id'] = $playlistid;
                        $data['duration'] = $duration;
                 // $upd_id = $this->CRUD->update_data(TBL_ALARM_LOG,$data,array('id'=>$id));
                  $upd_id = $this->CRUD->insert_data(TBL_BILLING_LOG,$data);
                  //print_r($data); exit();
                //  $insert=$this->db->insert('tbl_status_log', $data);
                  // echo json_encode($upd_id);
                  if($upd_id){
                    $message = "Successfully Updated.";
                     //echo 'You have registered successfully.';
                    echo "<script type='text/javascript'>alert('$message');</script>";
                  // redirect('http://localhost:8080/app/billing_log.html', 'refresh'); 
                     redirect(base_url().'billing_log','refresh');
                     }
                     else{
                        $message = "Incorrect data...Please check Again.";
                     //echo 'You have registered successfully.';
                    echo "<script type='text/javascript'>alert('$message');</script>";
                     }
                    } 

                      
                    }

 

      public function create()
    {
        $id = $this->input->post('tid');
        $terminalid = $this->input->post('terminal_id');
        $playlistid = $this->input->post('playlist_id');
        $duration = $this->input->post('duration');
        $user_id = $this->session->userdata('user_id');
        $created_on= date(DB_DATETIME_FORMAT); 
        $rate = $this->input->post('rate');
        $time = $this->input->post('time');
        $total = $this->input->post('answer');

        $data = array();
        $data['rate'] = $rate;
        $data['time'] = $time;
        $data['total'] = $total;
        $data['created_by'] = $user_id;
        $data['created_on'] = $created_on;
        $data['alarm_id'] = $id;
        $data['terminal_name'] = $terminalid;
        $data['playlist_id'] = $playlistid;
        $data['duration'] = $duration;
        $this->load->model('Billinglog_model');
       // print_r($data); exit();
        $insert = $this->Billinglog_model->createData($data);
       // print_r($insert); exit();
        echo json_encode($insert);
        //header("Location: http://localhost:8080/app/billing_log.html");
          
         }
         
         
    public function pdf($id=0){
        $id = $this->uri->segment(3);
       // print_r($gid); 
        valid_session($this->module_name,'read');
        $log = $this->CRUD->get_data_row(TBL_BILLING_LOG,array('alarm_id' => $id));
        $html = $this->load->view('log/billing/template-pdf',array('log'=>$log),true);
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
