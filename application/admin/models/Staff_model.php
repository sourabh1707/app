<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Staff_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $role_id = $this->session->userdata('role_id');
        $this->db->select('a.id,a.name,a.username,a.user_email,a.mobile_no,r.name as role_name,a.is_active');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('r.name',$where['search']);
            $this->db->or_like('a.name',$where['search']);
            $this->db->or_like('a.username',$where['search']);
            $this->db->or_like('a.user_email',$where['search']);
            $this->db->or_like('a.mobile_no',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
            $this->db->order_by('a.name','asc');
        }
        $this->db->join(TBL_ROLE.' as r','r.id=a.role_id','left');
        if($role_id!=1){
            $this->db->where('a.id>'.$role_id);
        }
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        $this->db->where('a.client_id','0');
        $query = $this->db->get(TBL_ADMIN.' as a');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_all_count($where = array()){
        $role_id = $this->session->userdata('role_id');
        $this->db->select('a.id');
        if(!empty($where)){
            $this->db->where($where);
        }
        if($role_id!=1){
            $this->db->where('a.id>'.$role_id);
        }
        $this->db->where('a.client_id','0');
        $query = $this->db->get(TBL_ADMIN.' as a');
        return $query->num_rows();
    }
    
    function get_filtered_count($where = array()){
        $role_id = $this->session->userdata('role_id');
        $this->db->select('a.id');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('r.name',$where['search']);
            $this->db->or_like('a.name',$where['search']);
            $this->db->or_like('a.username',$where['search']);
            $this->db->or_like('a.user_email',$where['search']);
            $this->db->or_like('a.mobile_no',$where['search']);
        }
        if($role_id!=1){
            $this->db->where('a.id>'.$role_id);
        }
        $this->db->where('a.client_id','0');
        $this->db->join(TBL_ROLE.' as r','r.id=a.role_id','left');
        $query = $this->db->get(TBL_ADMIN.' as a');
        return $query->num_rows();
    }
}
