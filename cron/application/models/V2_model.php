<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class V2_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_layout_data($from_date,$to_date,$start=true) {
        $this->db->select('sl.*');
	if($start){
            $this->db->where('sl.is_schedule','0');
        	$this->db->where('sl.schedule_on BETWEEN "'.$from_date.'" and "'.$to_date.'"');
    }else{
		$this->db->where('sl.schedule_to BETWEEN "'.$from_date.'" and "'.$to_date.'" ');	
	}
        $this->db->where('sl.is_deleted','0');
        $this->db->order_by('sl.schedule_on','desc');
        $query = $this->db->get(TBL_SCHEDULE_L.' as sl');
        //echo $this->db->last_query();exit;
        // file_put_contents('logs5.txt',$this->db->last_query(),FILE_APPEND);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
}