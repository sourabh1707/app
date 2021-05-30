<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Language_model extends MY_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_datatable($where = array()) {
        $this->db->select('l.*');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('l.name',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
            $this->db->order_by('l.name','asc');
        }
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        $query = $this->db->get(TBL_LANGUAGE.' as l');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_all_count($where = array()){
        $this->db->select('l.id');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get(TBL_LANGUAGE.' as l');
        return $query->num_rows();
    }
    
    function get_filtered_count($where = array()){
        $this->db->select('l.id');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->like('l.name',$where['search']);
        }
        $query = $this->db->get(TBL_LANGUAGE.' as l');
        return $query->num_rows();
    }
    
    
    
    
    
    public function get_translate_datatable($where = array(),$column) {
        $this->db->select('lt.id,lt.word,lt.'.$column);
        if(isset($where['search']) && $where['search']!=''){
            $this->db->or_like('lt.word',$where['search']);
        }
        if(isset($where['order']) && $where['order']!='' && isset($where['order_by']) && $where['order_by']!=''){
            $this->db->order_by($where['order'],$where['order_by']);
        }
        else{
            $this->db->order_by('lt.word','asc');
        }
        if($where['start']!=0){
            $this->db->limit($where['length'],$where['start']);
        }
        else{
            $this->db->limit($where['length']);
        }
        $query = $this->db->get(TBL_LANGUAGE_TRANSLATION.' as lt');
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    function get_translate_all_count($where = array(),$column){
        $this->db->select('lt.id');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get(TBL_LANGUAGE_TRANSLATION.' as lt');
        return $query->num_rows();
    }
    
    function get_translate_filtered_count($where = array(),$column){
        $this->db->select('lt.id');
        if(isset($where['search']) && $where['search']!=''){
            $this->db->or_like('lt.word',$where['search']);
        }
        $query = $this->db->get(TBL_LANGUAGE_TRANSLATION.' as lt');
        return $query->num_rows();
    }
    
    
    
    
    
    function add_column($column_name){
        $this->load->dbforge();
        $fields = array(
            $column_name => array('type' => 'LONGTEXT','collation' => 'utf8_general_ci','null' => TRUE,'default' => NULL)
        );
        if ($this->dbforge->add_column(TBL_LANGUAGE_TRANSLATION, $fields)) {
            return true;
        }
        return false;
    }
    function modify_column($old_column_name,$new_column_name){
        $this->load->dbforge();
        $fields = array(
            $old_column_name => array('name' => $new_column_name,'type' => 'LONGTEXT','collation' => 'utf8_general_ci','null' => TRUE,'default' => NULL)
        );
        if ($this->dbforge->modify_column(TBL_LANGUAGE_TRANSLATION, $fields)) {
            return true;
        }
        return false;
    }
    function drop_column($column_name){
        $this->load->dbforge();
        if ($this->dbforge->drop_column(TBL_LANGUAGE_TRANSLATION, $column_name)) {
            return true;
        }
        return false;
    }
}
