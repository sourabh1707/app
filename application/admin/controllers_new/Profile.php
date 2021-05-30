<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Profile extends MY_Controller {
    public $module_name = 'profile';
    function __construct() {
        parent::__construct();
        $this->load->model('Profile_model','Model');
    }
    public function index(){
        valid_session($this->module_name);
        $page_data = array();
        $page_data['module_name'] = 'profile';
        $page_data['page_name'] = 'profile';
        $page_data['page_title'] = 'Profile';
        $user_id = $this->session->userdata('admin_id');
        $action = $this->input->post('action');
        if($action!=''){
            $json = array();
            $json['status'] = 201;
            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
            $json['details'] = array('Invalid Details');
            if($action=='edit_profile'){
                $user_name = $this->input->post('user_name');
                $username = $this->input->post('username');
                $user_email = $this->input->post('user_email');
                $mobile_no = $this->input->post('mobile_no');
                
                $unique_email = 'trim|required|callback_unique_user_email';
                $unique_mobile = 'trim|required|callback_unique_user_mobile';
                $unique_username = 'trim|required|callback_unique_username';
                if($user_id!=''){
                    $user = $this->CRUD->get_data_row(TBL_ADMIN,array('id'=>$user_id));
                    if($user->user_email==$user_email){
                        $unique_email = 'trim|required';
                    }
                    if($user->mobile_no==$mobile_no){
                        $unique_mobile = 'trim|required';
                    }
                    if($user->username==$username){
                        $unique_username = 'trim|required';
                    }
                }
                $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
                $this->form_validation->set_rules('username', 'Username', $unique_username);
                $this->form_validation->set_rules('user_email', 'Email', $unique_email);
                $this->form_validation->set_rules('mobile_no', 'Mobile No', $unique_mobile);
                if ($this->form_validation->run()){
                    $up_data = array();
                    $up_data['user_email'] = $user_email;
                    $up_data['mobile_no'] = $mobile_no;
                    $up_data['name'] = $user_name;
                    $up_data['username'] = $username;
		    
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $this->CRUD->update_data(TBL_ADMIN,$up_data,array('id'=>$user_id));
                    
                    $data = array();
                    $data['name'] = $user_name;
                    $data['username'] = $username;
                    $data['user_email'] = $user_email;
                    $data['user_mobile'] = $mobile_no;
                    $this->session->set_userdata($data);
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = array('User details updated successfully');

                    $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Admin details updated successfully';
                            add_log($log_data,1,1,$user_id);
                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
            
            if($action=='edit_datetime'){
                $timezone = $this->input->post('timezone');
                $time_format = $this->input->post('time_format');
                $date_format = $this->input->post('date_format');
                
                $this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');
                $this->form_validation->set_rules('time_format', 'Time Format', 'trim|required');
                $this->form_validation->set_rules('date_format', 'Date Format', 'trim|required');
                if ($this->form_validation->run()){
                    $up_data = array();
                    $up_data['timezone'] = $timezone;
                    $up_data['time_format'] = $time_format;
                    $up_data['date_format'] = $date_format;
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $this->CRUD->update_data(TBL_ADMIN,$up_data,array('id'=>$user_id));
                    
                    $data = array();
                    $data['timezone'] = $timezone;
                    $data['time_format'] = $time_format;
                    $data['date_format'] = $date_format;
                    $this->session->set_userdata($data);
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = array('Date & Time details updated successfully');

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Date & Time details updated successfully';
                            add_log($log_data,1,1,$user_id);

                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
            if($action=='edit_password'){
                $this->form_validation->set_rules('old_password', 'Old Password', 'trim|min_length[5]|required|callback_old_password');
                
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|min_length[5]|required');
                $this->form_validation->set_rules('conf_password', 'Confirm New Password', 'trim|required|min_length[5]|matches[new_password]');
                if ($this->form_validation->run()){
                    $up_data = array();
                    $up_data['password'] = sha1($this->input->post('new_password'));
                    $up_data['updated_by'] = $this->session->userdata('admin_id');	
		    $up_data['pass_status'] = 1;
                    $this->CRUD->update_data(TBL_ADMIN,$up_data,array('id'=>$user_id));
                    
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = array('User password updated successfully');


                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Admin password updated successfully';
                            add_log($log_data,1,1,$user_id);           
                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
            echo encode_json($json);exit;
        }
        
        $page_data['profile'] = $this->CRUD->get_data_row(TBL_ADMIN,array('id'=>$user_id));
        $this->load->view('index',$page_data);
    }
    public function crud($type=''){
        $json = array();
        $json['status'] = 201;
        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        $json['details'] = array('Invalid Details');
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
                    $user_id = $this->session->userdata('admin_id');
                    $up_data = array();
                    $up_data['profile_image'] = $params['avatar_name'].'.png';
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $this->CRUD->update_data(TBL_ADMIN,$up_data,array('id'=>$user_id));

                    $data = array();
                    $data['profile_image'] = $result;
                    $this->session->set_userdata($data);
                }
            }
            $json = array(
                'state'  => 200,
                'message' => $msg,
                'result' => $result
            );
        }
        echo encode_json($json);
    }
    
    function unique_user_email(){
        $user_email = $this->input->post('user_email');
        if($this->CRUD->get_data_row(TBL_ADMIN,array('user_email'=>$user_email))){
            $this->form_validation->set_message('unique_user_email',translate('this_email_is_already_exist'));
            return false;
        }
        return true;
    }
    function unique_user_mobile(){
        $mobile_no = $this->input->post('mobile_no');
        if($this->CRUD->get_data_row(TBL_ADMIN,array('mobile_no'=>$mobile_no))){
            $this->form_validation->set_message('unique_user_mobile',translate('this_mobile_number_is_already_exist'));
            return false;
        }
        return true;
    }
    function unique_username(){
        $username = $this->input->post('username');
        if($this->CRUD->get_data_row(TBL_ADMIN,array('username'=>$username))){
            $this->form_validation->set_message('unique_username',translate('this_username_is_already_exist'));
            return false;
        }
        return true;
    }
    function old_password(){
        $old_password = $this->input->post('old_password');
        $user_id = $this->session->userdata('admin_id');
        
        if($this->CRUD->get_data_row(TBL_ADMIN,array('id'=>$user_id,'password'=> sha1($old_password)))){
            return true;
        }
        $this->form_validation->set_message('old_password',translate('old_password_does_not_match'));
        return false;
    }
}
