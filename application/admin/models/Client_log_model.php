<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Client_log_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    
    public function dataList_client() {
        $user_id = $this->session->userdata('admin_id');
        $this->db->select('tbl_client_log.*, tbl_client.*');
        $this->db->from('tbl_client_log','tbl_client');
        $this->db->join('tbl_client', 'tbl_client.id = tbl_client_log.client_id');
        $this->db->where('tbl_client_log.created_by',$user_id);
        //echo $this->db->last_query();exit;
        //$this->db->where('tbl_terminal_log.playlist_id' = 'tbl_terminal.id');
        $this->db->order_by('tbl_client_log.log_created_on','desc');  
        $query = $this->db->get();
        return $query->result_array();
            
    }

    public function fetch_client($start_date,$end_date) {
        $user_id = $this->session->userdata('admin_id');
        $this->db->select('tbl_client_log.*, tbl_client.*');
        $this->db->from('tbl_client_log','tbl_client');
        $this->db->join('tbl_client', 'tbl_client.id = tbl_client_log.client_id');
        //$this->db->where('tbl_terminal_log.created_by',$user_id);
        $this->db->where('tbl_client_log.log_created_on BETWEEN "'.$start_date.'" and "'.$end_date.'"');
        $this->db->where('tbl_client_log.created_by',$user_id);
        //echo $this->db->last_query();exit;
        $this->db->order_by('tbl_client_log.id','desc');
        $query = $this->db->get();
        return $query->result_array();
            
    }

     public function dataList_user() {
        $user_id = $this->session->userdata('admin_id');
        $this->db->select('tbl_client_log.*, tbl_user.*');
        $this->db->from('tbl_client_log','tbl_user');
        $this->db->join('tbl_user', 'tbl_user.id = tbl_client_log.user_id');
        $this->db->where('tbl_client_log.created_by',$user_id);
        //echo $this->db->last_query();exit;
        //$this->db->where('tbl_terminal_log.playlist_id' = 'tbl_terminal.id');
        $this->db->order_by('tbl_client_log.log_created_on','desc');  
        $query = $this->db->get();
        return $query->result_array();
            
    }

    public function fetch_user($start_date,$end_date) {
        $user_id = $this->session->userdata('admin_id');
        $this->db->select('tbl_client_log.*, tbl_user.*');
        $this->db->from('tbl_client_log','tbl_user');
        $this->db->join('tbl_user', 'tbl_user.id = tbl_client_log.user_id');
        //$this->db->where('tbl_terminal_log.created_by',$user_id);
        $this->db->where('tbl_client_log.log_created_on BETWEEN "'.$start_date.'" and "'.$end_date.'"');
        $this->db->where('tbl_client_log.created_by',$user_id);
        //echo $this->db->last_query();exit;
        $this->db->order_by('tbl_client_log.id','desc');
        $query = $this->db->get();
        return $query->result_array();
            
    }

}


