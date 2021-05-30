<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Role extends MY_Controller {
    public $module_name = 'role';
    function __construct() {
        parent::__construct();
        $this->load->model('Role_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'list';
        $page_data['page_title'] = 'Role';
        $this->load->view('index',$page_data);
    }
    public function add(){
        valid_session($this->module_name,'write');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'add';
        $page_data['page_title'] = 'Role';
        $this->load->view('index',$page_data);
    }
    public function edit($id=''){
        valid_session($this->module_name,'write');
        $id = $id!='' ? decode_string($id) : '';
        $role = $this->CRUD->get_data_row(TBL_ROLE,array('id'=>$id));
        if($role){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'add';
            $page_data['page_title'] = 'Role';
            $page_data['role'] = $role;
            $page_data['permissions_array'] = unserialize($role->permissions);
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
                elseif($col_id==3){
                    $where['order'] = 'description';
                }
                elseif($col_id==4){
                    $where['order'] = 'modules';
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
                        $edit = '<a href="'.site_url("role/edit/".encode_string($d->id)).'" style=" margin-bottom: 0px; " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="'. translate('edit').'"><i class="fa fa-edit"></i></a>';
                    }
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    $row = array();
                    $row[] = $start;
                    $row[] = $d->name;
                    $row[] = $d->description;
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
                    
                    $upd_id = $this->CRUD->update_data(TBL_ROLE,$up_data,array('id'=>$id));
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
        if($type=='add'){
            $action = $this->input->post('action');
            if($action=='add_role'){
                $this->form_validation->set_rules('role_name', translate('name'), 'trim|required|callback_unique_role');
                $this->form_validation->set_rules('role_description', ('description'), 'trim|required');
                if ($this->form_validation->run()){
                    $permission = $this->input->post('permission');
                    $in_data = array();
                    $in_data['name'] = $this->input->post('role_name');
                    $in_data['description'] = $this->input->post('role_description');
                    $in_data['permissions'] = serialize($permission);
                    $in_data['created_by'] = $this->session->userdata('admin_id');
                    $in_data['created_on'] = date(DB_DATETIME_FORMAT);
                    $in_data['updated_by'] = $this->session->userdata('admin_id');
                    $in_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $ins_id = $this->CRUD->insert_data(TBL_ROLE,$in_data);
                    if($ins_id){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('added_successfully'));
                    }
                    else{
                        $json['status'] = 205;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('unabal_to_add'));
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
                    $role = $this->CRUD->get_data_row(TBL_ROLE,array('id'=>$id));
                    if($role){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('role'=>$role),true);
                    }
                }
            }
        }
        if($type=='edit' && $id!=''){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='edit_role'){
                    $role = $this->CRUD->get_data_row(TBL_ROLE,array('id'=>$id));
                    $unique_name = 'trim|required';
                    if($role->name!=$this->input->post('role_name')){
                        $unique_name = 'trim|required|callback_unique_role';
                    }
                    $this->form_validation->set_rules('role_name', translate('name'), $unique_name);
                    $this->form_validation->set_rules('role_description', translate('description'), 'trim|required');
                    if ($this->form_validation->run()){
                        $permission = $this->input->post('permission');
                        $in_data = array();
                        $in_data['name'] = $this->input->post('role_name');
                        $in_data['description'] = $this->input->post('role_description');
                        $in_data['permissions'] = serialize($permission);
                        $in_data['updated_by'] = $this->session->userdata('admin_id');
                        $in_data['updated_on'] = date(DB_DATETIME_FORMAT);
                        $ins_id = $this->CRUD->update_data(TBL_ROLE,$in_data,array('id'=>$id));
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('updated_successfully'));
                        }
                        else{
                            $json['status'] = 205;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unabal_to_update'));
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
    function unique_role(){
        $role_name = $this->input->post('role_name');
        if($this->CRUD->get_data_row(TBL_ROLE,array('name'=>$role_name))){
            $this->form_validation->set_message('unique_role',translate('this_name_is_already_exist'));
            return false;
        }
        return true;
    }
}
