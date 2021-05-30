<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Change_password extends MY_Controller {
    public $module_name = 'profile';
    function __construct() {
        parent::__construct();
        $this->load->model('Profile_model','Model');
    }
    public function index(){
        valid_session($this->module_name);
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'edit_password';
        $page_data['page_title'] = 'Change Password';
        $this->load->view('index',$page_data);
    }
}