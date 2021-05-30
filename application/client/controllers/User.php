<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class User extends MY_Controller {
    public $module_name = 'user';
    function __construct() {
        parent::__construct();
        $this->load->model('User_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'list';
        $page_data['page_title'] = 'Staff';
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
                elseif($col_id==3){
                    $where['order'] = 'username';
                }
                elseif($col_id==4){
                    $where['order'] = 'user_email';
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
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    $row = array();
                    $row[] = $start;
                    $row[] = $d->name;
                    $row[] = $d->username;
                    $row[] = $d->user_email;
                    $row[] = $d->mobile_no;
                    $row[] = $d->is_active==1 ? translate('active') : translate('in_active');
                    $row[] = $details;
                    $data[] = $row;
                }
            }
            $json['draw'] = $draw;
            $json['recordsTotal'] = $all_count;
            $json['recordsFiltered'] = $filtered_count;
            $json['data'] = $data;
        }
        if($type=='details'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='get_details'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $staff = $this->CRUD->get_data_row(TBL_USER,array('id'=>$id));
                    if($staff){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('staff'=>$staff),true);
                    }
                }
            }
        }
        echo encode_json($json);exit;
    }
}
