<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Playlist_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $this->db->select('p.*');
	$this->db->where('is_delete','1');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('p.name',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
          //  $this->db->order_by('p.name','asc');
 	    $this->db->order_by('p.created_on','desc');
        }
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        $query = $this->db->get(TBL_PLAYLIST.' as p');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_all_count($where = array()){
        $this->db->select('p.id');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get(TBL_PLAYLIST.' as p');
        return $query->num_rows();
    }
    
    function get_filtered_count($where = array()){
        $this->db->select('p.id');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('p.name',$where['search']);
        }
        $query = $this->db->get(TBL_PLAYLIST.' as p');
        return $query->num_rows();
    }
}
