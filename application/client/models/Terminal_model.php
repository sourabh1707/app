<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Terminal_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('t.*');
        $this->db->where('user_id',$user_id);
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('t.name',$where['search']);
            $this->db->or_like('t.alise',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
            $this->db->order_by('t.name','asc');
        }
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        
        $query = $this->db->get(TBL_TERMINAL.' as t');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_all_count($where = array()){
        $this->db->select('t.id');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get(TBL_TERMINAL.' as t');
        return $query->num_rows();
    }
    
    function get_filtered_count($where = array()){
        $this->db->select('t.id');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('t.name',$where['search']);
            $this->db->or_like('t.alise',$where['search']);
        }
        $query = $this->db->get(TBL_TERMINAL.' as t');
        return $query->num_rows();
    }
}
