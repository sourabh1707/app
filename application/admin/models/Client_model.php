<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class client_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $this->db->select('c.*');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('c.code',$where['search']);
            $this->db->or_like('c.name',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
            $this->db->order_by('c.name','asc');
        }
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        
        $query = $this->db->get(TBL_CLIENT.' as c');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_all_count($where = array()){
        $this->db->select('c.id');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get(TBL_CLIENT.' as c');
        return $query->num_rows();
    }
    
    function get_filtered_count($where = array()){
        $this->db->select('c.id');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('c.code',$where['search']);
            $this->db->or_like('c.name',$where['search']);
        }
        $query = $this->db->get(TBL_CLIENT.' as c');
        return $query->num_rows();
    }
}
