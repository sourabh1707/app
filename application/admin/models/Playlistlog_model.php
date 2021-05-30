<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Playlistlog_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $this->db->select('l.*');
        if(isset($where['search']) && $where['search']!=''){
            //$this->db->like('l.name',$where['search']);
            //$this->db->or_like('l.alise',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
            $this->db->order_by('l.created_on','desc');
        }
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        
        $query = $this->db->get(TBL_PLAYLIST_LOG.' as l');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_all_count($where = array()){
        $this->db->select('l.id');
        if(!empty($where)){
            //$this->db->where($where);
        }
        $query = $this->db->get(TBL_PLAYLIST_LOG.' as l');
        return $query->num_rows();
    }
    
    function get_filtered_count($where = array()){
        $this->db->select('l.id');
        if(isset($where['search']) && $where['search']!=''){
            //$this->db->like('l.name',$where['search']);
            //$this->db->or_like('l.alise',$where['search']);
        }
        $query = $this->db->get(TBL_PLAYLIST_LOG.' as l');
        return $query->num_rows();
    }

    public function dataList_playlist() {
       // $user_id = $this->session->userdata('user_id');
        $this->db->select('tbl_playlist_log.*, tbl_playlist.*');
        $this->db->from('tbl_playlist_log','tbl_playlist');
        $this->db->join('tbl_playlist', 'tbl_playlist.id = tbl_playlist_log.playlist_id');
        //$this->db->where('tbl_playlist_log.created_by',$user_id);
        $this->db->order_by('tbl_playlist_log.log_created_on','desc');
        $query = $this->db->get();
        return $query->result_array();
            
}

    public function fetch_playlist($start_date,$end_date) {
       // $user_id = $this->session->userdata('user_id');
        $this->db->select('tbl_playlist_log.*, tbl_playlist.*');
        $this->db->from('tbl_playlist_log','tbl_playlist');
        $this->db->join('tbl_playlist', 'tbl_playlist.id = tbl_playlist_log.playlist_id');
        //$this->db->where('tbl_playlist_log.created_by',$user_id);
        $this->db->where('tbl_playlist_log.log_created_on BETWEEN "'.$start_date.'" and "'.$end_date.'"');
        //echo $this->db->last_query();exit;
        $this->db->order_by('tbl_playlist_log.id','desc');
        $query = $this->db->get();
        return $query->result_array();
            
}
}
