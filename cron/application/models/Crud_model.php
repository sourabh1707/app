<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Crud_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function insert_data($table,$data) {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        }
        return false;
    }
    function get_tbl_details($table,$details=''){
        $this->db->select('*');
        $this->db->where('table_name',$table);
        $this->db->where('table_schema = DATABASE()');
        $query = $this->db->get('information_schema.tables');
        if($query->num_rows()){
            if($details!='' && isset($query->row()->$details)){
                return $query->row()->$details;
            } else{
                return $query->row();
            }
        }
        return false;
    }
    public function get_data($table,$where = array(),$order = array(),$limit = '',$start = '') {
        $this->db->select('*');
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($order)){
            $key = key($order);
            $this->db->order_by($key,$order[$key]);
        }
        if($limit != '' && $start != ''){
            $this->db->limit($limit, $start);
        }else if($limit != '' && $start == ''){
            $this->db->limit($limit);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function get_search_data($table,$where = array(),$order = array(),$limit = '',$start = '',$q='') {
        $this->db->select('*');
        if(!empty($where)){
            $this->db->where($where);
        }
        if($q!=''){
            $this->db->like('name',$q);
            $this->db->or_like('keywords',$q);
        }
        if(!empty($order)){
            $key = key($order);
            $this->db->order_by($key,$order[$key]);
        }
        if($limit != '' && $start != ''){
            $this->db->limit($limit, $start);
        }else if($limit != '' && $start == ''){
            $this->db->limit($limit);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function get_data_row($table,$where = array()) {
        $this->db->select('*');
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    public function get_role_data($where = array()) {
        $role_id = $this->session->userdata('role_id');
        $this->db->select('*');
        if(!empty($where)){
            $this->db->where($where);
        }
        if($role_id!=1){
            $this->db->where('id>2');
        }
        else{
            $this->db->where('id>1');
        }
        $query = $this->db->get(TBL_ROLE);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function get_setting_row($keys) {
        $select = array();
        if(!empty($keys)){
            foreach($keys as $key){
                $select[] = 'MAX(CASE WHEN `key`="'.$key.'" THEN value END) '.$key;
            }
        }
        if(!empty($select)){
            $this->db->select(implode(', ', $select));
        }
        $query = $this->db->get(TBL_SETTINGS);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    public function update_data($table,$data,$where = array()) {
        if(!empty($where)){
            $this->db->where($where);
        }
        $this->db->update($table, $data);
        if ($this->db->affected_rows()) {
            return true;
        }
        return false;
    }
    public function delete_data($table,$where) {
        $this->db->delete($table, $where);
        if ($this->db->affected_rows()) {
            return true;
        }
        return false;
    }
}
