<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Login extends CI_Controller {
    public $module_name = 'login';
    public $client_id = 0;
    function __construct() {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->config->cache_query();
        $this->load->model('Login_model','Model');
    }
    public function index(){
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_title'] = 'Login';
        $keys = array('system_name','system_logo','system_loader','system_favicon', 'ui_fixed_footer','ui_fixed_sidebar','font','captcha_status','captcha_log_in_visibility','captcha_forgot_visibility','captcha_lang','captcha_secret_key','ui_rtl');
        $header_setting = $this->CRUD->get_setting_row($keys);
        $page_data['header_setting'] = $header_setting;
        
        if ($this->session->userdata('admin_id') != ''){
            $redirect_url = $this->session->userdata('redirect_url');
            if($redirect_url!=''){
                $this->session->unset_userdata('redirect_url');
                $action = $this->input->post('action');
                if($action!=''){
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = array('Login successfully.');
                    echo encode_json($json);
                }
                redirect($redirect_url, 'refresh');exit;
            }
            $action = $this->input->post('action');
            if($action!=''){
                $json['status'] = 200;
                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                $json['details'] = array('Success');
                echo encode_json($json);
            }
            redirect(site_url('dashboard'), 'refresh');exit;
        }
        $action = $this->input->post('action');
        if($action!=''){
            $json = array();
            $error = array();
            $required = array();
            $json['status'] = 201;
            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
            $json['details'] = array('Invalid Details');
            
            if($action=='login'){
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                if($username==''){
                    $required[] = translate('username_is_required');
                }
                if($password==''){
                    $required[] = translate('password_is_required');
                }
                if(isset($header_setting->captcha_status) && $header_setting->captcha_status=='on'){
                    if(isset($header_setting->captcha_log_in_visibility) && $header_setting->captcha_log_in_visibility=='on'){
                        $rcresponse = $this->input->post('g-recaptcha-response');
                        if($rcresponse==''){
                            $required[] = translate('captcha_is_required');
                        }
                        else{
                            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$header_setting->captcha_secret_key."&response=".$rcresponse ."&remoteip=".$_SERVER['REMOTE_ADDR']);
                            $response = json_decode($response);
                            if(!$response->success){
                                $error[] = translate('invalid_capcha');
                            }
                        }
                    }
                }
                if (!empty($required)){
                    $json['status'] = 204;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $required;
                }
                else{
                    $where = array();
                    if(strpos($username, '@')){
                        $where['user_email'] = $username;
                    }
                    elseif (is_numeric($username)) {
                        $where['mobile_no'] = $username;
                    }
                    else{
                        $where['username'] = $username;
                    }
                    $where['password'] = sha1($password);
                    $where['client_id'] = $this->client_id;
                    $admin = $this->CRUD->get_data_row(TBL_ADMIN,$where);
                    if($admin){
                        $is_active = $admin->is_active;
                        if($is_active=='0'){

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Unable to Login while Admin is not active';
                            add_log($log_data,1,1,$admin->id);
                            $error[] = translate('admin_account_is_not_active');
                        }
                        if (!empty($error)){
                            $json['status'] = 203;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = $error;
                        }
                        else{
                            $role = $this->CRUD->get_data_row(TBL_ROLE,array('id'=>$admin->role_id,'client_id'=>$this->client_id));
                            if($role->is_active==0){

                                $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'Unable to Login while Role is disabled';
                                add_log($log_data,1,1,$admin->id);

                                $json['status'] = 203;
                                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                                $json['details'] = array(translate('admin_role_is_disabled'));
                                echo encode_json($json);exit;

                            }
                            
                            $data = array();
                            $data['admin_id'] = $admin->id;
                            $data['client_id'] = $this->client_id;
                            $data['name'] = $admin->name;
                            $data['username'] = $admin->username;
                            $data['user_email'] = $admin->user_email;
                            $data['user_mobile'] = $admin->mobile_no;
                            $data['role_id'] = $admin->role_id;
                            $data['role_name'] = $role->name;
                            $data['date_format'] = $admin->date_format;
                            $data['time_format'] = $admin->time_format;
                            $data['timezone'] = $admin->timezone;
                            $profile = base_url('uploads/profile').'/default.png';
                            if(isset($admin->profile_image) && $admin->profile_image!=''){
                                $user_profile = base_url('uploads/profile').$admin->profile_image;
                                if(file_exists(str_replace(base_url(),FCPATH,$user_profile))){
                                    $profile = $user_profile;
                                }
                            }
                            $data['profile_image'] = $profile;
                            $data['permissions'] = $role->permissions;
                            $data['language'] = $this->db->get_where(TBL_SETTINGS,array('key'=>'default_language'))->row()->value;
                            
                            $up_data = array();
                            $up_data['last_login_on'] = date(DB_DATETIME_FORMAT);
                            $up_data['last_login_from'] = $_SERVER['REMOTE_ADDR'];
                            $up_data['password_token'] = '';
                            $this->CRUD->update_data(TBL_ADMIN,$up_data,array('id'=>$admin->id));
                            $this->session->set_userdata($data);
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('login successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Login Successfully';
                            add_log($log_data,1,1,$admin->id);
                        }
                    }
                    else{   
                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Unable to Login while wrong password';
                            add_log($log_data,1,1,$admin->id);
                 

                        $json['status'] = 202;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('admin_details_not_found'));
                    }
                }
            }
            
            if($action=='forgot'){
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                if($username==''){
                    $required[] = translate('username_is_required');
                }
                if(isset($header_setting->captcha_status) && $header_setting->captcha_status=='on'){
                    if(isset($header_setting->captcha_forgot_visibility) && $header_setting->captcha_forgot_visibility=='on'){
                        $rcresponse = $this->input->post('g-recaptcha-response');
                        if($rcresponse==''){
                            $required[] = translate('captcha_is_required');
                        }
                        else{
                            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$header_setting->captcha_secret_key."&response=".$rcresponse ."&remoteip=".$_SERVER['REMOTE_ADDR']);
                            $response = json_decode($response);
                            if(!$response->success){
                                $error[] = translate('invalid_capcha');
                            }
                        }
                    }
                }
                if (!empty($required)){
                    $json['status'] = 204;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $required;
                }
                else{
                    $where = array();
                    if(strpos($username, '@')){
                        $where['user_email'] = $username;
                    }
                    elseif (is_numeric($username)) {
                        $where['mobile_no'] = $username;
                    }
                    else{
                        $where['username'] = $username;
                    }
                    $where['client_id'] = $this->client_id;
                    $admin = $this->CRUD->get_data_row(TBL_ADMIN,$where);
                    if($admin){
                        $is_active = $admin->is_active;
                        if($is_active=='0'){
                            $error[] = translate('admin_account_is_not_active');
                        }
                        if (!empty($error)){
                            $json['status'] = 203;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = $error;
                        }
                        else{
                            $role = $this->CRUD->get_data_row(TBL_ROLE,array('id'=>$admin->role_id,'client_id'=>$this->client_id));
                            if($role->is_active==0){
                                $json['status'] = 203;
                                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                                $json['details'] = array(translate('admin_role_is_disabled'));
                                echo encode_json($json);exit;
                            }
                            $token = md5($admin->id.random_string('alnum', 16));
                            $up_data = array();
                            $up_data['password_token'] = $token;
                            $update = $this->CRUD->update_data(TBL_ADMIN,$up_data,array('id'=>$admin->id));
                            if($update){
                                $data = array();
                                $data['name'] = $admin->name;
                                $data['to_email'] = $admin->user_email;
                                $data['token'] = $token;
                                $this->load->model('Email_model','EMAIL');
                                $is_email_sent = $this->EMAIL->reset_password($data);
                                if($is_email_sent){
                                    $json['status'] = 200;
                                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                                    $json['details'] = array(translate('forgot_password_link_sent_successfully'));
                                }
                                else{
                                    $json['status'] = 203;
                                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                                    $json['details'] = array(translate('unabal_to_send_email'));
                                }
                            }
                        }
                    }
                    else{
                        $json['status'] = 202;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('admin_details_not_found'));
                    }
                }
            }
            echo encode_json($json);exit;
        }
        $this->load->view($this->module_name.'/login',$page_data);
    }
    public function action($type='',$token=''){
        $keys = array('system_name','system_logo','system_loader','system_favicon', 'ui_fixed_footer','ui_fixed_sidebar','font','captcha_status','captcha_reset_visibility','captcha_lang','captcha_secret_key','ui_rtl');
        $header_setting = $this->CRUD->get_setting_row($keys);
        
        if ($this->session->userdata('admin_id') != ''){
            $redirect_url = $this->session->userdata('redirect_url');
            if($redirect_url!=''){
                $this->session->unset_userdata('redirect_url');
                $action = $this->input->post('action');
                if($action!=''){
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = array(translate('login successfully'));
                    echo encode_json($json);
                }
                redirect($redirect_url, 'refresh');exit;
            }
            $action = $this->input->post('action');
            if($action!=''){
                $json['status'] = 200;
                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                $json['details'] = array('Success');
                echo encode_json($json);
            }
            redirect(site_url('dashboard'), 'refresh');exit;
        }
        $action = $this->input->post('action');
        if($action!=''){
            $json = array();
            $error = array();
            $required = array();
            $json['status'] = 201;
            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
            $json['details'] = array('Invalid Details');
            
            if($action=='reset'){
                $password1 = $this->input->post('new_password1');
                $password2 = $this->input->post('new_password2');
                $token = $this->input->post('token');
                if($password1==''){
                    $required[] = translate('new_password_is_required');
                }
                if($password2==''){
                    $required[] = translate('retype_new_password_is_required');
                }
                if($password1!=$password2){
                    $required[] = translate('new_password_&_retype_new_password_doesnot_match');
                }
                if($token==''){
                    $required[] = translate('invalid_request');
                }
                if(isset($header_setting->captcha_status) && $header_setting->captcha_status=='on'){
                    if(isset($header_setting->captcha_reset_visibility) && $header_setting->captcha_reset_visibility=='on'){
                        $rcresponse = $this->input->post('g-recaptcha-response');
                        if($rcresponse==''){
                            $required[] = translate('captcha_is_required');
                        }
                        else{
                            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$header_setting->captcha_secret_key."&response=".$rcresponse ."&remoteip=".$_SERVER['REMOTE_ADDR']);
                            $response = json_decode($response);
                            if(!$response->success){
                                $error[] = translate('invalid_capcha');
                            }
                        }
                    }
                }
                if (!empty($required)){
                    $json['status'] = 204;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $required;
                }
                else{
                    $where = array();
                    $where['password_token'] = $token;
                    $admin = $this->CRUD->get_data_row(TBL_ADMIN,$where);
                    if($admin){
                        if(sha1($password1)==$admin->password){
                            $error[] = translate('new_password_doesnot_same_with_last_password');
                        }
                        $is_active = $admin->is_active;
                        if($is_active=='0'){
                            $error[] = translate('admin_account_is_not_active');
                        }
                        if (!empty($error)){
                            $json['status'] = 203;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = $error;
                        }
                        else{
                            $role = $this->CRUD->get_data_row(TBL_ROLE,array('id'=>$admin->role_id));
                            if($role->is_active==0){
                                $json['status'] = 203;
                                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                                $json['details'] = array(translate('admin_role_is_disabled'));
                                echo encode_json($json);exit;
                            }
                            $up_data = array();
                            $up_data['password_token'] = '';
                            $up_data['password'] = sha1($password1);
                            $update = $this->CRUD->update_data(TBL_ADMIN,$up_data,array('id'=>$admin->id));
                            if($update){
                                $json['status'] = 200;
                                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                                $json['details'] = array(translate('password_reset_successfully'));
                            }
                        }
                    }
                    else{
                        $json['status'] = 202;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('admin_details_not_found'));
                    }
                }
            }
            echo encode_json($json);exit;
        }
        
        $page_data = array();
        $page_data['page_title'] = '404';
        $page = 'error_404';
        $page_data['module_name'] = $this->module_name;
        
        if($type=='rp'){
            $where = array();
            $where['password_token'] = $token;
            $admin = $this->CRUD->get_data_row(TBL_ADMIN,$where);
            if($admin){
                $page_data['header_setting'] = $header_setting;
                $page_data['page_title'] = 'reset_password';
                $page_data['token'] = $token;
                $page = 'reset';
            }
        }
        
        if($type=='cp'){
            $where = array();
            $where['password_token'] = $token;
            //$where['password'] = '';
            $admin = $this->CRUD->get_data_row(TBL_ADMIN,$where);
            if($admin){
                $page_data['header_setting'] = $header_setting;
                $page_data['page_title'] = 'create_password';
                $page_data['token'] = $token;
                $page = 'reset';
            }
        }
        $this->load->view($this->module_name.'/'.$page,$page_data);
    }
    function logout() {

        $admin = $this->session->userdata('admin_id');

        $log_data = array();
        $log_data['status'] = true;
        $log_data['message'] = 'Admin Successfully logged out';
        add_log($log_data,1,1,$admin);
      //  print_r($admin); exit();

        $this->session->sess_destroy();
        $this->session->set_flashdata('logout', translate('admin_successfully_logged_out'));
        redirect(site_url(), 'refresh');
    }
}
