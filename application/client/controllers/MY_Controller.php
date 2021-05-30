<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    var $permissions;
    function __construct() {
        parent::__construct();
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->config->cache_query();
        $permissions = array();
        $permissions = $this->session->userdata('permissions');
        $permissions = unserialize($permissions);
        //echo '<pre>';print_r($permissions);echo '</pre>';
        $this->permissions = $permissions;
    }
}
