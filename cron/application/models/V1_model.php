<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class V1_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_playlist_data($from_date,$to_date,$start=true) {
        $this->db->select('s.*');
	if($start){
		$this->db->where('s.is_schedule','0');
        	$this->db->where('s.schedule_on BETWEEN "'.$from_date.'" and "'.$to_date.'"');
	}else{
		$this->db->where('s.schedule_to BETWEEN "'.$from_date.'" and "'.$to_date.'"');	
	}
        $this->db->where('s.is_deleted','0');
        $this->db->order_by('s.schedule_on','desc');
        $query = $this->db->get(TBL_SCHEDULE.' as s');
      //  echo $this->db->last_query();exit; and "is_schedule='0'" 
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
}
