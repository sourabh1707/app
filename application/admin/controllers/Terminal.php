<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Terminal extends MY_Controller {
    public $module_name = 'terminal';
    function __construct() {
        parent::__construct();
        $this->load->model('Terminal_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'list';
        $page_data['page_title'] = 'Terminal';
        $this->load->view('index',$page_data);
    }
    public function add(){
        valid_session($this->module_name,'write');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'add';
        $page_data['clients'] = $this->CRUD->get_data(TBL_CLIENT);
        $page_data['page_title'] = 'Terminal';
        $this->load->view('index',$page_data);
    }
    public function edit($id=''){
        valid_session($this->module_name,'write');
        $id = $id!='' ? decode_string($id) : '';
        $terminal = $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$id));
        if($terminal){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'add';
            $page_data['page_title'] = 'Terminal';
            $page_data['clients'] = $this->CRUD->get_data(TBL_CLIENT);
            $page_data['terminal'] = $terminal;
            $this->load->view('index',$page_data);
        }
        else{
            $page_data = array();
            $page_data['page_title'] = '404';
            $this->load->view('error_404',$page_data);
        }
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
                    $status = '';
                    $edit = '';
                    if(empty($this->permissions) || isset($this->permissions[$this->module_name]['write'])){
                        $checked = $d->is_active==1 ? "checked" : "";
                        $status = '<input type="checkbox" class="js-switch change-status" data-id="'.encode_string($d->id).'" '.$checked.'/>';
                        $edit = '<a href="'.site_url("terminal/edit/".encode_string($d->id)).'" style=" margin-bottom: 0px; " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="'. translate('edit').'"><i class="fa fa-edit"></i></a>';
                    }
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    $row = array();
                    $row[] = $start;
                    $row[] = $d->name;
                    $row[] = $d->width.'*'.$d->height;
                    $row[] = $d->type=='1' ? 'Terminal' : 'Bill Board';
                    $row[] = $d->client_name;
                    $row[] = $d->admin_alise;
                    $dd = $d->terminal_latitude.' - '.$d->terminal_longitude;
                    $row[] = $dd;
                    $row[] = $status.' '.$details.' '.$edit;
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
                    $user_id= $this->session->userdata('admin_id');
                    $up_data = array();
                    $status = $this->input->post('status');
                    $id = $this->input->post('id');
                    $id = decode_string($id);

                   // print_r($user_id); exit();

                    if($status=='true'){
                        $up_data['is_active'] = '1';
                    }
                    else{
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    
                    $upd_id = $this->CRUD->update_data(TBL_TERMINAL,$up_data,array('id'=>$id));
                    if($upd_id){
                        if($status=='true'){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('activated_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Activated Successfully';
                            add_log1($log_data,$user_id,$id,0,0); 
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('deactivated_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Deactivated Successfully';
                            add_log1($log_data,$user_id,$id,0,0); 
                        }
                    }
                }
            }
        }
        if($type=='add'){
            $action = $this->input->post('action');
            if($action=='add_terminal'){
                $admin_id = $this->session->userdata('admin_id');
                $this->form_validation->set_rules('terminal_name', translate('terminal_iD'), 'trim|required|callback_unique_name');
                $this->form_validation->set_rules('client_id', translate('client'), 'trim|required');
                if ($this->form_validation->run()){
                    $in_data = array();
                    $in_data['name'] = $this->input->post('terminal_name');
                    $in_data['client_id'] = $this->input->post('client_id');
                    $in_data['type'] = $this->input->post('type');
                    $in_data['width'] = $this->input->post('width');
                    $in_data['height'] = $this->input->post('height');
                    $in_data['admin_alise'] = $this->input->post('terminal_admin_alise');
                    $in_data['client_alise'] = $this->input->post('terminal_client_alise');
                    $in_data['terminal_latitude'] = $this->input->post('terminal_latitude');
                    $in_data['terminal_longitude'] = $this->input->post('terminal_longitude');
                    $in_data['created_by'] = $this->session->userdata('admin_id');
                    $in_data['created_on'] = date(DB_DATETIME_FORMAT);
                    $in_data['updated_by'] = $this->session->userdata('admin_id');
                    $in_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $ins_id = $this->CRUD->insert_data(TBL_TERMINAL,$in_data);
                    $insert_id = $this->db->insert_id();
                    if($ins_id){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('added_successfully'));

                        $log_data = array();
                        $log_data['status'] = true;
                        $log_data['message'] = 'Added Successfully';
                        add_log1($log_data,$admin_id,$insert_id,0,0); 
                    }
                    else{
                        $json['status'] = 205;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('unabal_to_add'));

                        $log_data = array();
                        $log_data['status'] = true;
                        $log_data['message'] = 'unabal_to_add';
                        add_log1($log_data,$admin_id,$insert_id,0,0); 
                    }
                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
        }
        if($type=='details'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='get_details'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $terminal = $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$id));
                    if($terminal){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('terminal'=>$terminal),true);
                    }
                }
            }
        }
        if($type=='edit' && $id!=''){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='edit_terminal'){
                    $admin_id= $this->session->userdata('admin_id');
                    $terminal = $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$id));
                    $unique_name = 'trim|required';
                    $unique_abbr = 'trim|required';
                    if($terminal->name!=$this->input->post('terminal_name')){
                        $unique_name = 'trim|required|callback_unique_name';
                    }
                    $this->form_validation->set_rules('terminal_name', translate('terminal_iD'), $unique_name);
                    $this->form_validation->set_rules('client_id', translate('client'), 'trim|required');
                    if ($this->form_validation->run()){
                        $in_data = array();
                        $in_data['name'] = $this->input->post('terminal_name');
                        $in_data['type'] = $this->input->post('type');
                        $in_data['width'] = $this->input->post('width');
                        $in_data['height'] = $this->input->post('height');
                        $in_data['client_id'] = $this->input->post('client_id');
                        $in_data['admin_alise'] = $this->input->post('terminal_admin_alise');
                        $in_data['client_alise'] = $this->input->post('terminal_client_alise');
                        $in_data['terminal_latitude'] = $this->input->post('terminal_latitude');
                        $in_data['terminal_longitude'] = $this->input->post('terminal_longitude');
                        $in_data['updated_by'] = $this->session->userdata('admin_id');
                        $in_data['updated_on'] = date(DB_DATETIME_FORMAT);
                        $ins_id = $this->CRUD->update_data(TBL_TERMINAL,$in_data,array('id'=>$id));
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('updated_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Updated Successfully';
                            add_log1($log_data,$admin_id,$id,0,0); 
                        }
                        else{
                            $json['status'] = 205;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unabal_to_update'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'unabal_to_update';
                            add_log1($log_data,$admin_id,$id,0,0); 
                        }
                    }
                    else{
                        $json['status'] = 205;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->form_validation->error_array();
                    }
                }
            }
        }
        
        echo encode_json($json);exit;
    }
    function unique_name(){
        $terminal_name = $this->input->post('terminal_name');
        if($this->CRUD->get_data_row(TBL_TERMINAL,array('name'=>$terminal_name))){
            $this->form_validation->set_message('unique_name',translate('this_terminal_name_is_already_exist'));
            return false;
        }
        return true;
    }
}
