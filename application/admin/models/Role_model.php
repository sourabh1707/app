<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Role_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $role_id = $this->session->userdata('role_id');
        $this->db->select('r.*');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('r.name',$where['search']);
            $this->db->or_like('r.description',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
            $this->db->order_by('r.name','asc');
        }
        if($role_id!=1){
            $this->db->where('r.id>2');
        }
        else{
            $this->db->where('r.id>1');
        }
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        
        $query = $this->db->get(TBL_ROLE.' as r');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_all_count($where = array()){
        $role_id = $this->session->userdata('role_id');
        $this->db->select('r.id');
        if(!empty($where)){
            $this->db->where($where);
        }
        if($role_id!=1){
            $this->db->where('r.id>2');
        }
        else{
            $this->db->where('r.id>1');
        }
        $query = $this->db->get(TBL_ROLE.' as r');
        return $query->num_rows();
    }
    
    function get_filtered_count($where = array()){
        $role_id = $this->session->userdata('role_id');
        $this->db->select('r.id');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('r.name',$where['search']);
            $this->db->or_like('r.description',$where['search']);
        }
        if($role_id!=1){
            $this->db->where('r.id>2');
        }
        else{
            $this->db->where('r.id>1');
        }
        $query = $this->db->get(TBL_ROLE.' as r');
        return $query->num_rows();
    }
}
