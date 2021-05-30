<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class User_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $client_id = $this->session->userdata('client_id');
        $this->db->select('u.id,u.name,u.username,u.user_email,u.mobile_no,u.is_active');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('r.name',$where['search']);
            $this->db->or_like('u.name',$where['search']);
            $this->db->or_like('u.username',$where['search']);
            $this->db->or_like('u.user_email',$where['search']);
            $this->db->or_like('u.mobile_no',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
            $this->db->order_by('u.name','asc');
        }
        
        $this->db->where('u.client_id',$client_id);
        
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        $query = $this->db->get(TBL_USER.' as u');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_all_count($where = array()){
        $client_id = $this->session->userdata('client_id');
        $this->db->select('u.id');
        if(!empty($where)){
            $this->db->where($where);
        }
        
        $this->db->where('u.client_id',$client_id);
        
        $query = $this->db->get(TBL_USER.' as u');
        return $query->num_rows();
    }
    
    function get_filtered_count($where = array()){
        $client_id = $this->session->userdata('client_id');
        $this->db->select('u.id');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('r.name',$where['search']);
            $this->db->or_like('u.name',$where['search']);
            $this->db->or_like('u.username',$where['search']);
            $this->db->or_like('u.user_email',$where['search']);
            $this->db->or_like('u.mobile_no',$where['search']);
        }
        
        $this->db->where('u.client_id',$client_id);
        
        $query = $this->db->get(TBL_USER.' as u');
        return $query->num_rows();
    }
}
