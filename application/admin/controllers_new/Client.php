<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Client extends MY_Controller {
    public $module_name = 'client';
    function __construct() {
        parent::__construct();
        $this->load->model('Client_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'list';
        $page_data['page_title'] = 'Client';
        $this->load->view('index',$page_data);
    }
    public function add(){
        valid_session($this->module_name,'write');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'add';
        $page_data['page_title'] = 'Client';
        $this->load->view('index',$page_data);
    }
    public function edit($id=''){
        valid_session($this->module_name,'write');
        $id = $id!='' ? decode_string($id) : '';
        $client = $this->CRUD->get_data_row(TBL_CLIENT,array('id'=>$id));
        if($client){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'add';
            $page_data['page_title'] = 'Client';
            $page_data['client'] = $client;
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
                        $edit = '<a href="'.site_url("client/edit/".encode_string($d->id)).'" style=" margin-bottom: 0px; " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="'. translate('edit').'"><i class="fa fa-edit"></i></a>';
                    }
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    $client = base_url('uploads/client').'/default.png';
                    if(isset($d->logo) && $d->logo!=''){
                        $client_image = base_url('uploads/client').'/'.$d->logo;
                        if(file_exists(str_replace(base_url(),FCPATH,$client_image))){
                            $client = $client_image;
                        }
                    }
                    $row = array();
                    $row[] = $start;
                    $row[] = '<ul class="list-inline"><li><img src="'.$client.'" class="avatar" alt="'.$d->name.'"></li></ul>';
                    $row[] = $d->name;
                    $row[] = $d->address;
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
                    $admin_id = $this->session->userdata('admin_id');

                    //print_r($id); exit();

                    if($status=='true'){
                        $up_data['is_active'] = '1';
                    }
                    else{
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    
                    $upd_id = $this->CRUD->update_data(TBL_CLIENT,$up_data,array('id'=>$id));
                    if($upd_id){
                        if($status=='true'){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('activated_successfully'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'activated_successfully';
                                client_log($log_data,$admin_id,$id,0);
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('deactivated_successfully'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'deactivated_successfully';
                                client_log($log_data,$admin_id,$id,0);
                        }
                    }
                }
            }
        }
        if($type=='add'){
            $action = $this->input->post('action');
            if($action=='add_client'){
                $this->form_validation->set_rules('client_name', translate('name'), 'trim|required|callback_unique_client_name');
                $this->form_validation->set_rules('address', translate('address'), 'trim|required');
                if ($this->form_validation->run()){
                    $admin_id=$this->session->userdata('admin_id');
                    $client_logo = 'default.png';
                    $file = $_FILES["logo"];
                    if(isset($file['name']) && $file['name']!=''){
                        $ext = end((explode(".", $file['name'])));
                        $file_name = 'Client_'.date('YmdHis').'.'.$ext;
                        $target_logo = base_url().'uploads/client/'.$file_name;
                        if (move_uploaded_file($file["tmp_name"], str_replace(base_url(),FCPATH, $target_logo))) {
                            $client_logo = $file_name;
                        }
                    }
                    
                    $in_data = array();
                    $in_data['logo'] = $client_logo;
                    $in_data['name'] = $this->input->post('client_name');
                    $in_data['address'] = $this->input->post('address');
                    $in_data['created_by'] = $this->session->userdata('admin_id');
                    $in_data['created_on'] = date(DB_DATETIME_FORMAT);
                    $in_data['updated_by'] = $this->session->userdata('admin_id');
                    $in_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $ins_id = $this->CRUD->insert_data(TBL_CLIENT,$in_data);
                    $insert_id = $this->db->insert_id();
                    if($ins_id){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('New Client added successfully.'));

                        $log_data = array();
                        $log_data['status'] = true;
                        $log_data['message'] = 'New Client added successfully';
                        client_log($log_data,$admin_id,$insert_id,0);
                    }
                    else{
                        $json['status'] = 205;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('Unabal to add new client.'));

                        $log_data = array();
                        $log_data['status'] = true;
                        $log_data['message'] = 'Unabal to add new client';
                        client_log($log_data,$admin_id,$insert_id,0);
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
                    $client = $this->CRUD->get_data_row(TBL_CLIENT,array('id'=>$id));
                    if($client){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('client'=>$client),true);
                    }
                }
            }
        }
        if($type=='edit' && $id!=''){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='edit_client'){
                    $client = $this->CRUD->get_data_row(TBL_CLIENT,array('id'=>$id));
                    $unique_name = 'trim|required';
                    if($client->name!=$this->input->post('client_name')){
                        $unique_name = 'trim|required|callback_unique_client_name';
                    }
                    $this->form_validation->set_rules('client_name', translate('name'), $unique_name);
                    $this->form_validation->set_rules('address', translate('address'), 'trim|required');
                    if ($this->form_validation->run()){
                        $admin_id=$this->session->userdata('admin_id');
                        $client_logo = '';
                        $file = $_FILES["logo"];
                        if(isset($file['name']) && $file['name']!=''){
                            $ext = end((explode(".", $file['name'])));
                            $file_name = 'Client_'.date('YmdHis').'.'.$ext;
                            $target_logo = base_url().'uploads/client/'.$file_name;
                            if (move_uploaded_file($file["tmp_name"], str_replace(base_url(),FCPATH, $target_logo))) {
                                $client_logo = $file_name;
                            }
                        }
                        
                        $in_data = array();
                        if($file['name']!=''){
                            $in_data['logo'] = $client_logo;
                        }
                        $in_data['name'] = $this->input->post('client_name');
                        $in_data['address'] = $this->input->post('address');
                        $in_data['updated_by'] = $this->session->userdata('admin_id');
                        $in_data['updated_on'] = date(DB_DATETIME_FORMAT);
                        $ins_id = $this->CRUD->update_data(TBL_CLIENT,$in_data,array('id'=>$id));
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('updated_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'updated_successfully';
                            client_log($log_data,$admin_id,$id,0);
                        }
                        else{
                            $json['status'] = 205;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unabal_to_update'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'unabal_to_update';
                            client_log($log_data,$admin_id,$id,0);
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
    function unique_client_name(){
        $client_name = $this->input->post('client_name');
        if($this->CRUD->get_data_row(TBL_CLIENT,array('name'=>$client_name))){
            $this->form_validation->set_message('unique_client_name',translate('this_name_is_already_exist'));
            return false;
        }
        return true;
    }
}
