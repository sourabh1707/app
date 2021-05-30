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
        $page_data['page_title'] = 'User';
        $this->load->view('index',$page_data);
    }
    public function add(){
        valid_session($this->module_name,'write');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'add';
        $page_data['page_title'] = 'User';
        $page_data['clients'] = $this->CRUD->get_data(TBL_CLIENT,array('is_active','1'));
        $this->load->view('index',$page_data);
    }
    public function edit($id=''){
        valid_session($this->module_name,'write');
        $id = $id!='' ? decode_string($id) : '';
        $user = $this->CRUD->get_data_row(TBL_USER,array('id'=>$id));
        if($user){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'add';
            $page_data['page_title'] = 'User';
            $page_data['user'] = $user;
            $page_data['permissions_array'] = unserialize($user->permissions);
            $page_data['clients'] = $this->CRUD->get_data(TBL_CLIENT);
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
                    $status = '';
                    $edit = '';
                    if(empty($this->permissions) || isset($this->permissions[$this->module_name]['write'])){
                        $checked = $d->is_active==1 ? "checked" : "";
                        $status = '<input type="checkbox" class="js-switch change-status" data-id="'.encode_string($d->id).'" '.$checked.'/>';
                        $edit = '<a href="'.site_url("user/edit/".encode_string($d->id)).'" style=" margin-bottom: 0px; " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="'.translate('edit').'"><i class="fa fa-edit"></i></a>';
                    }
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    $row = array();
                    $row[] = $start;
                    $row[] = $d->client_name;
                    $row[] = $d->name;
                    $row[] = $d->username;
                    $row[] = $d->user_email;
                    $row[] = $d->mobile_no;
                    $row[] = $status.' '.$details.' '.$edit;
                    $data[] = $row;
                }
            }
            $json['draw'] = $draw;
            $json['recordsTotal'] = $all_count;
            $json['recordsFiltered'] = $filtered_count;
            $json['data'] = $data;
        }
        if($type=='add'){
            $action = $this->input->post('action');
            if($action=='add_user'){
                $user_name = $this->input->post('user_name');
                $username = $this->input->post('username');
                $user_email = $this->input->post('user_email');
                $mobile_no = $this->input->post('mobile_no');
                $password = 'landt';

                $unique_email = 'trim|required|callback_unique_user_email';
                $unique_mobile = 'trim|required|callback_unique_user_mobile';
                $unique_username = 'trim|required|callback_unique_username';
                
                $this->form_validation->set_rules('user_name', translate('name'), 'trim|required');
                $this->form_validation->set_rules('username', translate('username'), $unique_username);
                $this->form_validation->set_rules('user_email', translate('email'), $unique_email);
                $this->form_validation->set_rules('mobile_no', translate('mobile_no'), $unique_mobile);
                if ($this->form_validation->run()){
                    $keys = array('system_timezone','system_date_format','system_time_format');
                    $header_setting = $this->CRUD->get_setting_row($keys);
                    $permission = $this->input->post('permission');
                    
                    $profile = $this->session->userdata('user_profile');
                    $up_data = array();
                    $up_data['user_email'] = $user_email;
                    $up_data['mobile_no'] = $mobile_no;
                    $up_data['name'] = $user_name;
                    $up_data['username'] = $username;
		            $up_data['password'] = sha1($password);
                    $token = md5($user_email.random_string('alnum', 16));
                    $up_data['password_token'] = $token;
                    if($profile!=''){
                        $up_data['profile_image'] = $profile;
                    }
                   // $admin_id=$this->session->userdata('admin_id');
                    $up_data['permissions'] = serialize($permission);
                    $up_data['timezone'] = $header_setting->system_timezone;
                    $up_data['date_format'] = $header_setting->system_date_format;
                    $up_data['time_format'] = $header_setting->system_time_format;
                    $up_data['client_id'] = $this->input->post('client_id');
                    $up_data['created_by'] = $this->session->userdata('admin_id');
                    $up_data['created_on'] = date(DB_DATETIME_FORMAT);
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $ins_id = $this->CRUD->insert_data(TBL_USER,$up_data);
                   //  $insert_id = $this->db->insert_id();
                    $this->session->unset_userdata('user_profile');
                    if($ins_id){
                        $data = array();
                        $data['name'] = $user_name;
                        $data['to_email'] = $user_email;
                        $data['token'] = $token;
                        $this->load->model('Email_model','EMAIL');
                        $is_email_sent = $this->EMAIL->create_password($data);
                        
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('added_successfully'));

                       /* $log_data = array();
                        $log_data['status'] = true;
                        $log_data['message'] = 'added_successfully';
                        client_log($log_data,$admin_id,0,$insert_id);
                        */
                    }
                    else{
                        $json['status'] = 205;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->form_validation->error_array();
                    }
                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
        }
        if($type=='change_status'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='change_status'){
                    $up_data = array();
                    $status = $this->input->post('status');
                    $admin_id=$this->session->userdata('admin_id');
                    $id = $this->input->post('id');
                    $id = decode_string($id);

                    if($status=='true'){
                        $up_data['is_active'] = '1';
                    }
                    else{
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    
                    $upd_id = $this->CRUD->update_data(TBL_USER,$up_data,array('id'=>$id));
                    if($upd_id){
                        if($status=='true'){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('activated_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'activated_successfully';
                            client_log($log_data,$admin_id,0,$id);
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('deactivated_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'deactivated_successfully';
                            client_log($log_data,$admin_id,0,$id);
                        }
                    }
                }
            }
        }
        if($type=='edit' && $id!=''){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='edit_user'){
                    $user_name = $this->input->post('user_name');
                    $username = $this->input->post('username');
                    $user_email = $this->input->post('user_email');
                    $mobile_no = $this->input->post('mobile_no');

                    $unique_email = 'trim|required|callback_unique_user_email';
                    $unique_mobile = 'trim|required|callback_unique_user_mobile';
                    $unique_username = 'trim|required|callback_unique_username';
                    
                    $user = $this->CRUD->get_data_row(TBL_USER,array('id'=>$id));
                    if($user->user_email==$user_email){
                        $unique_email = 'trim|required';
                    }
                    if($user->mobile_no==$mobile_no){
                        $unique_mobile = 'trim|required';
                    }
                    if($user->username==$username){
                        $unique_username = 'trim|required';
                    }
                    $this->form_validation->set_rules('user_name', translate('name'), 'trim|required');
                    $this->form_validation->set_rules('username', translate('username'), $unique_username);
                    $this->form_validation->set_rules('user_email', translate('email'), $unique_email);
                    $this->form_validation->set_rules('mobile_no', translate('mobile_no'), $unique_mobile);
                    if ($this->form_validation->run()){
                        $profile = $this->session->userdata('user_profile');
                        $permission = $this->input->post('permission');
                        
                        $up_data = array();
                        $up_data['user_email'] = $user_email;
                        $up_data['mobile_no'] = $mobile_no;
                        $up_data['name'] = $user_name;
                        $up_data['username'] = $username;
                        $admin_id=$this->session->userdata('admin_id');
                        if($profile!=''){
                            $up_data['profile_image'] = $profile;
                        }
                        $up_data['client_id'] = $this->input->post('client_id');
                        $up_data['permissions'] = serialize($permission);
                        $up_data['updated_by'] = $this->session->userdata('admin_id');
                        $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                        $this->CRUD->update_data(TBL_USER,$up_data,array('id'=>$id));
                        $this->session->unset_userdata('user_profile');
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('updated_successfully'));

                        $log_data = array();
                        $log_data['status'] = true;
                        $log_data['message'] = 'updated_successfully';
                        client_log($log_data,$admin_id,0,$id);
                    }
                    else{
                        $json['status'] = 205;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->form_validation->error_array();
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
                    $user = $this->CRUD->get_data_row(TBL_USER,array('id'=>$id));
                    if($user){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('user'=>$user),true);
                    }
                }
            }
        }
        if($type=='upload'){
            $params = array();
            $params['src'] = isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null;
            $params['avatar_data'] = isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null;
            $params['avatar_file'] = isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null;
            $params['avatar_path'] = FCPATH.'uploads/profile/';
            $params['avatar_name'] = 'Profile_'.date('YmdHis');

            $this->load->library('croper',$params);
            $msg = $this->croper->getMsg();
            $result = $this->croper->getResult();
            if($msg=='' || $msg==null){
                if(file_exists($result)){
                    $result = str_replace(FCPATH,base_url(),$result);
                    $data = array();
                    $data['user_profile'] = $params['avatar_name'].'.png';
                    $this->session->set_userdata($data);
                }
            }
            $json = array(
                'state'  => 200,
                'message' => $msg,
                'result' => $result
            );
        }
        echo encode_json($json);exit;
    }
    
    function unique_user_email(){
        $user_email = $this->input->post('user_email');
        if($this->CRUD->get_data_row(TBL_USER,array('user_email'=>$user_email))){
            $this->form_validation->set_message('unique_user_email',translate('this_email_is_already_exist'));
            return false;
        }
        return true;
    }
    function unique_user_mobile(){
        $mobile_no = $this->input->post('mobile_no');
        if($this->CRUD->get_data_row(TBL_USER,array('mobile_no'=>$mobile_no))){
            $this->form_validation->set_message('unique_user_mobile',translate('this_mobile_number_is_already_exist'));
            return false;
        }
        return true;
    }
    function unique_username(){
        $username = $this->input->post('username');
        if($this->CRUD->get_data_row(TBL_USER,array('username'=>$username))){
            $this->form_validation->set_message('unique_username',translate('this_username_is_already_exist'));
            return false;
        }
        return true;
    }
}
