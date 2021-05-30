<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Schedule_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $this->db->select('s.*');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('s.name',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
            $this->db->order_by('s.schedule_on','desc');
        }
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        $this->db->where('is_deleted','0');
        $query = $this->db->get(TBL_SCHEDULE.' as s');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_all_count($where = array()){
        $this->db->select('s.id');
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->where('is_deleted','0');
        $query = $this->db->get(TBL_SCHEDULE.' as s');
        return $query->num_rows();
    }
    
    function get_filtered_count($where = array()){
        $this->db->select('s.id');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('s.name',$where['search']);
        }
        $this->db->where('is_deleted','0');
        $query = $this->db->get(TBL_SCHEDULE.' as s');
        return $query->num_rows();
    }
}
