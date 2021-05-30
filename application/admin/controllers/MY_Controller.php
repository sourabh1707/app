<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    var $permissions;
    var $client_id = 0;
    function __construct() {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->config->cache_query();
        
        $role_id = $this->session->userdata('role_id');
        $permissions = array();
        if($role_id!=1){
            $permissions = $this->session->userdata('permissions');
            $permissions = unserialize($permissions);
        }
        // echo '<pre>';
        // print_r($permissions);
        // echo '</pre>';exit();
        $this->permissions = $permissions;
    }
}
