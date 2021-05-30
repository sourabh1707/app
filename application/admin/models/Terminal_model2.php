<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Terminal_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $this->db->select('t.*,c.name as client_name');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('t.name',$where['search']);
            $this->db->or_like('t.admin_alise',$where['search']);
            $this->db->or_like('c.name',$where['search']);
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
        $this->db->join(TBL_CLIENT.' as c','t.client_id=c.id','LEFT');
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
            $this->db->or_like('t.admin_alise',$where['search']);
            $this->db->or_like('c.name',$where['search']);
        }
        $this->db->join(TBL_CLIENT.' as c','t.client_id=c.id','LEFT');
        $query = $this->db->get(TBL_TERMINAL.' as t');
        return $query->num_rows();
    }
}
