<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Schedule_l extends MY_Controller {
    public $module_name = 'schedule_l';
    public $api_url = '';
    function __construct() {
        parent::__construct();
        $this->api_url = API_URL.'v2/';
        $this->load->model('Schedule_l_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'list';
        $page_data['page_title'] = 'Schedule';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        $this->load->view('index',$page_data);
    }
    public function crud($type='',$id=''){
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
                    $delete = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-danger btn-xs delete-details" data-toggle="tooltip" data-placement="top" title="'. translate('delete').'"><i class="fa fa-trash"></i></a>';
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    $row = array();
                    $row[] = $start;
                    $row[] = $d->name;
                    $row[] = $d->schedule_on;
		    $row[] = $d->schedule_to;
                    $row[] = $d->is_schedule==1 ? translate('success') : translate('pending');
                    $row[] = $details.' '.$delete;
                    $data[] = $row;
                }
            }
            $json['draw'] = intval($draw);
            $json['recordsTotal'] = intval($all_count);
            $json['recordsFiltered'] = intval($filtered_count);
            $json['data'] = $data;
        }
        if($type=='change_status'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='change_status'){
                    $up_data = array();
                    $status = $this->input->post('status');
                    $id = $this->input->post('id');
                    $id = decode_string($id);

                    if($status=='true'){
                        $up_data['is_active'] = '1';
                    }
                    else{
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    
                    $upd_id = $this->CRUD->update_data(TBL_SCHEDULE_L,$up_data,array('id'=>$id));
                    if($upd_id){
                        if($status=='true'){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('activated_successfully'));
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('deactivated_successfully'));
                        }
                    }
                }
            }
        }
        if($type=='details'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='get_details'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $schedule = $this->CRUD->get_data_row(TBL_SCHEDULE_L,array('id'=>$id));
                    if($schedule){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('schedule'=>$schedule),true);
                    }
                }
            }
        }
        if($type=='delete'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='delete_details'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $user_id= $this->session->userdata('user_id');
                    $schedule = array();
                    $schedule['is_deleted'] = '1';
                    $schedule['updated_by'] = $this->session->userdata('user_id');
                    $schedule['updated_on'] = date(DB_DATETIME_FORMAT);
                    $delete = $this->CRUD->update_data(TBL_SCHEDULE_L,$schedule,array('id'=>$id));
                    if($delete){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('schedule'=>$schedule),true);

                         $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'layout_schedule_remove_successfully';
                               add_log2($log_data,$user_id,0,$id);
                               // add_log1($log_data,$user_id,0,$id,0,0,0,0);
                    }
                }
            }
        }
        echo encode_json($json);exit;
    }
}
