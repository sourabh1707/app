<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Download_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }

    /* public function dataList() {
     	 $user= $this->session->userdata('user_id');
        //$this->db->where('created_by', $user);
        $this->db->select(array('*'));
        $this->db->from('tbl_playlist as e');
        //echo $this->db->last_query();exit;
        $query = $this->db->get();
        return $query->result_array();
    }*/
    

    public function dataList() {
        $user_id = $this->session->userdata('user_id');

        $this->db->select('tbl_playlist_log.*, tbl_playlist.*');
        $this->db->from('tbl_playlist_log');
        $this->db->join('tbl_playlist', 'tbl_playlist.id = tbl_playlist_log.playlist_id');
        $this->db->where('tbl_playlist_log.created_by',$user_id);
        //$this->db->where('tbl_playlist_log.playlist_id' = 'tbl_playlist.id');
        $this->db->order_by('tbl_playlist_log.id');
       // echo $this->db->last_query();exit;
        $query = $this->db->get();
        return $query->result_array();
            
}
}
