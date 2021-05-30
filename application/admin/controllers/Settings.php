<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Settings extends MY_Controller {
    public $module_name = 'settings';
    function __construct() {
        parent::__construct();
        $this->load->model('Settings_model','Model');
    }
    public function system(){
        valid_session($this->module_name,'system');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'system';
        $page_data['page_title'] = 'System';
        
        $keys = array('system_name','system_email','system_mobile','system_address','system_timezone','system_date_format','system_time_format','system_status');
        $page_data['setting'] = $this->CRUD->get_setting_row($keys);
        $this->load->view('index',$page_data);
    }
    public function logos(){
        valid_session($this->module_name,'logos');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'logos';
        $page_data['page_title'] = 'Logos';
        
        $keys = array('system_logo','system_favicon','system_loader','system_footer');
        $page_data['setting'] = $this->CRUD->get_setting_row($keys);
        $this->load->view('index',$page_data);
    }
    public function ui(){
        valid_session($this->module_name,'ui');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'ui';
        $page_data['page_title'] = 'UI';
        
        $keys = array('ui_fixed_sidebar','ui_fixed_footer','records_per_page','font','ui_rtl','ui_fixed_topbar');
        $page_data['setting'] = $this->CRUD->get_setting_row($keys);
        $this->load->view('index',$page_data);
    }
    public function smtp(){
        valid_session($this->module_name,'smtp');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'smtp';
        $page_data['page_title'] = 'SMTP';
        
        $keys = array('smtp_host','smtp_port','smtp_user','smtp_password','smtp_from_user','smtp_from_name');
        $page_data['setting'] = $this->CRUD->get_setting_row($keys);
        $this->load->view('index',$page_data);
    }
    public function captcha(){
        valid_session($this->module_name,'captcha');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'captcha';
        $page_data['page_title'] = 'captcha';
        
        $keys = array('captcha_status','captcha_site_key','captcha_secret_key','captcha_theme','captcha_size','captcha_log_in_visibility','captcha_forgot_visibility','captcha_reset_visibility','captcha_type','captcha_lang');
        $page_data['setting'] = $this->CRUD->get_setting_row($keys);
        $this->load->view('index',$page_data);
    }
    public function crud(){
        $action = $this->input->post('action');
        if($action!=''){
            $json = array();
            $json['status'] = 201;
            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
            $json['details'] = array('Invalid Details');
            if($action=='edit_system'){
                $systems = array('system_name'=>translate('system_name'),'system_email'=>translate('system_email'),'system_mobile'=>translate('system_mobile'),'system_address'=>translate('system_address'),'system_timezone'=>translate('system_timezone'),'system_date_format'=>translate('system_date_format'),'system_time_format'=>translate('system_time_format'));
                foreach ($systems as $key => $value) {
                    $this->form_validation->set_rules($key, $value, 'trim|required');
                }
                if ($this->form_validation->run()){
                    $posts = $_POST;
                    if(isset($posts) && !empty($posts)){
                        foreach ($posts as $key => $value) {
                            $up_data = array();
                            $up_data['value'] = $value;
                            $up_data['updated_by'] = $this->session->userdata('admin_id');
                            $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                            $this->CRUD->update_data(TBL_SETTINGS,$up_data,array('key'=>$key));
                        }
                    }
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = array(translate('updated_successfully'));
                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
            
            if($action=='edit_logo'){
                $files = $_FILES;
                if(isset($files) && !empty($files)){
                    foreach ($files as $key => $value) {
                        if($value['name']!=''){
                            $ext = end((explode(".", $value['name'])));
                            $file_name = str_replace("system_","",$key).'_'.date('YmdHis').'.'.$ext;
                            $target_path = base_url().'uploads/system/'.$file_name;
                            if (move_uploaded_file($value["tmp_name"], str_replace(base_url(),FCPATH, $target_path))) {
                                $up_data = array();
                                $up_data['value'] = $file_name;
                                $up_data['updated_by'] = $this->session->userdata('admin_id');
                                $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                                $this->CRUD->update_data(TBL_SETTINGS,$up_data,array('key'=>$key));
                            }
                        }
                    }
                }
                $json['status'] = 200;
                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                $json['details'] = array(translate('updated_successfully'));
            }
            if($action=='edit_ui'){
                $posts = $_POST;
                $uis = array('ui_fixed_sidebar'=>translate('fixed_sidebar'),'ui_fixed_footer'=>translate('fixed_footer'),'ui_rtl'=> translate('RTL'),'ui_fixed_topbar'=> translate('fixed_topbar'));
                foreach ($uis as $key => $value) {
                    $up_data = array();
                    $up_data['value'] = isset($posts[$key]) && $posts[$key]=='on' ? 'on' : 'off';
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $this->CRUD->update_data(TBL_SETTINGS,$up_data,array('key'=>$key));
                }
                $uis = array('records_per_page'=>translate('records_per_page'),'font'=>translate('font'));
                foreach ($uis as $key => $value) {
                    $up_data = array();
                    $up_data['value'] = $posts[$key];
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $this->CRUD->update_data(TBL_SETTINGS,$up_data,array('key'=>$key));
                }
                $json['status'] = 200;
                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                $json['details'] = array(translate('updated_successfully'));
            }
            if($action=='edit_smtp'){
                $systems = array('smtp_host'=>translate('SMTP_host'),'smtp_port'=>translate('SMTP_port'),'smtp_user'=>translate('SMTP_user'),'smtp_password'=>translate('SMTP_password'));
                foreach ($systems as $key => $value) {
                    $this->form_validation->set_rules($key, $value, 'trim|required');
                }
                if ($this->form_validation->run()){
                    $posts = $_POST;
                    if(isset($posts) && !empty($posts)){
                        foreach ($posts as $key => $value) {
                            $up_data = array();
                            $up_data['value'] = $value;
                            $up_data['updated_by'] = $this->session->userdata('admin_id');
                            $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                            $this->CRUD->update_data(TBL_SETTINGS,$up_data,array('key'=>$key));
                        }
                    }
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = array(translate('updated_successfully'));
                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
            if($action=='edit_captcha'){
                $posts = $_POST;
                $uis = array('captcha_status'=> translate('captcha_status'),'captcha_log_in_visibility'=> translate('log_in_page'),'captcha_forgot_visibility'=> translate('forgot_password_page'),'captcha_reset_visibility'=> translate('reset_password_page'));
                foreach ($uis as $key => $value) {
                    $up_data = array();
                    $up_data['value'] = isset($posts[$key]) && $posts[$key]=='on' ? 'on' : 'off';
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $this->CRUD->update_data(TBL_SETTINGS,$up_data,array('key'=>$key));
                }
                
                $uis = array('captcha_site_key'=> translate('captcha_site_key'),'captcha_secret_key'=> translate('captcha_secret_key'),'captcha_theme'=> translate('captcha_theme'),'captcha_size'=> translate('captcha_size'),'captcha_type'=> translate('captcha_type'),'captcha_lang'=> translate('captcha_language'));
                foreach ($uis as $key => $value) {
                    $up_data = array();
                    $up_data['value'] = $posts[$key];
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $up_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $this->CRUD->update_data(TBL_SETTINGS,$up_data,array('key'=>$key));
                }
                $json['status'] = 200;
                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                $json['details'] = array(translate('updated_successfully'));
            }
            echo encode_json($json);exit;
        }
    }
}
