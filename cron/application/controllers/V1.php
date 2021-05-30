<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/V1_Controller.php');
class V1 extends V1_Controller {
    public $module_name = 'dashboard';
    function __construct() {
        parent::__construct();
        $this->api_url = API_URL.'v2/';
        $this->load->model('V1_model','Model');
	//file_put_contents('logs.txt','Working'.PHP_EOL,FILE_APPEND);
    }
    public function index() {
        echo 'This is cron V1';
    
    }

   /* public function test() {    
        //valid_session($this->module_name);
        
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'dashboard';
        $page_data['page_title'] = 'Dashboard';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
       // $page_data['boards'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','type'=>'2'));
        echo "<pre>"; print_r($page_data['terminals']); exit();
        $this->load->view('dashboard/dashboard',$page_data);
        header('Refresh:60; url= '. base_url().'v1/test');
    }
    */

    public function get_status(){
        $terminals = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        //echo $this->db->last_query();exit;
        foreach($terminals as $tkey => $tvalue){
             $aa= $tvalue->name;           
        
        $api_url = API_URL.'v2/';
          // $set_api_url = $api_url.'get_hardware_info';  //get_query_status
        $set_api_url = $api_url.'get_query_status';  //get_hardware_info
        $ssparams = array();
        $id=$aa;
        //$ssparams['terminal_id'] = $this->input->post('terminal_id');
        $ssparams['terminal_id'] = $id;
        //print_r($ssparams['terminal_id']); exit();
        if($ssparams['terminal_id']!=''){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $set_api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ssparams));
            $response = curl_exec($ch);
            $response = decode_json($response);

          $door = "open";
          $status = $response->status;
         if($status==200){
            $status1 = "online";
         } if($status==500){
            $status1 = "offline";
         }

          $user_id=17;

         $log_data = array();
         $log_data['door_status'] = $door;
         $log_data['terminal_id'] = $id;
        // $log_data['opentime'] = date(DB_DATETIME_FORMAT); 
        // $log_data['closetime'] = date(DB_DATETIME_FORMAT);
         
         if($status==200){
         $log_data['closetime'] = 0;
         }
         else{
         $log_data['closetime'] = date(DB_DATETIME_FORMAT);
         }
         

         $log_data['status'] = $status1;
         $log_data['created_by'] = $user_id;
         $log_data['log_created_on'] = date(DB_DATETIME_FORMAT);
         //door_log($log_data,$user_id,$id,$door,$open_time,0);
         $ins_id = $this->CRUD->insert_data(TBL_ALARM_LOG,$log_data);  
         //echo $this->db->last_query();exit;

           //echo "<pre>"; print_r($terminals); exit();
         file_put_contents('Alarm.log', 'Last Run At : '.date(DB_DATETIME_FORMAT).PHP_EOL,FILE_APPEND);
        
        echo encode_json($response);
        }  

      }  //foreach


        /*$query_status = $api_url.'get_query_status';
        $reboot_terminal = $api_url.'reboot_terminal';
        if($query_status || $reboot_terminal){
        $playlist = $this->db->query("SELECT name FROM TBL_TERMINAL where id = $terminal_id ");
                   foreach ($playlist->result() as $row) {
                            $name= $row->name;
   
        $insertId = $this->db->insert_id();
        $playlist1 = $this->db->query("SELECT MAX(id) as id  FROM tbl_alarm_log"); 
             //$str = $this->db->last_query();
            foreach ($playlist1->result() as $row1) {
                    $tid= $row1->id;
                    }
           // print_r($tid); exit();
            $up_data = array();
            $up_data['closetime'] = date(DB_DATETIME_FORMAT);
            $up_data['door_status'] = "Closed";
            $up_data['status'] = "offline";
            $upd_id = $this->CRUD->update_data(TBL_ALARM_LOG,$up_data,array('id'=>$tid));
        }*/
    }

   /* public function get_door_status(){
        $fresponse['status'] = 200;
        $api_url = API_URL.'v2/';
        $set_api_url = $api_url.'get_hardware_info';
        $ssparams = array();
        $ssparams['terminal_id'] = $this->input->post('terminal_id');
        if($ssparams['terminal_id']!=''){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $set_api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ssparams));
            $response = curl_exec($ch);
            $response= decode_json($response);

            // echo '<pre>';print_r($response);echo '</pre>';
            // echo '<pre>';print_r($response->details[0]->doorOpened);echo '</pre>';

            $myresponse = isset($response->details[0]) && !empty($response->details[0]) ? $response->details[0] : array();
            // $myresponse = isset($response[0]) && !empty($response[0]) ? $response[0] : array();
            // echo '<pre>';print_r($myresponse->doorOpened);echo '</pre>';

            if(isset($myresponse->doorOpened) && $myresponse->doorOpened=='Open'){
                $fresponse['status'] = 201;
            }
            else if(isset($myresponse->doorOpened) && $myresponse->doorOpened=='Close'){
                $fresponse['status'] = 202;
            }
            else{
                $fresponse['status'] = 200;
            }
            // echo '<pre>';print_r($response);echo '</pre>';
            // print_r($response);
        }
        echo encode_json($fresponse);
    } */
    
    public function schedular() {
        file_put_contents('schedular.log', 'Last Run At : '.date(DB_DATETIME_FORMAT).PHP_EOL,FILE_APPEND);
        $from_date = date(DB_DATETIME_FORMAT, strtotime('-10 minutes'));
        $to_date = date(DB_DATETIME_FORMAT);
        $playlists = $this->Model->get_playlist_data($from_date,$to_date,$start=true);
       // print_r($playlists);
if(isset($playlists)&&!empty($playlists)){        
            foreach($playlists as $pkey =>$playlist){
                //$playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                $tasks = isset($playlist->playlist) && !empty(unserialize($playlist->playlist)) ? unserialize($playlist->playlist) : array() ;
                $terminals = isset($playlist->terminals) && !empty(unserialize($playlist->terminals)) ? unserialize($playlist->terminals) : array() ;
                if(!empty($tasks) && !empty($terminals)){
                    foreach ($terminals as $tkey => $tvalue) {
                        $twidth = $this->db->get_where(TBL_TERMINAL,array('name'=>$tvalue))->row()->width;
                        $theight = $this->db->get_where(TBL_TERMINAL,array('name'=>$tvalue))->row()->height;
                        $contents = array();
                        foreach($tasks as $tkey => $task) {
                                        switch ($task['type']) {
                                            case 'image':
                                                    $params = array();
                                                    $params['terminal_id'] = $tvalue;
                                                    $params['path'] = $task['image'];
                                                    $path = $task['image'];

                                                    $api_url = $this->api_url.'upload_file/image';
                                                    $response = $this->terminal_response($api_url,$params);
                                                    if(isset($response['status']) && $response['status']==200){
                                                        $datails = json_decode($response['details']);
                                                        $path = $datails->details;
                                                    }
                                                    $contents[$tkey]['data'] = '<img width="'.$twidth.'" height="'.$theight.'" src="' . $path . '">';
                                                break;
                                            case 'video':
                                                    /*
                                                    $params = array();
                                                    $params['terminal_id'] = $tvalue;
                                                    $params['path'] = $task['video'];;
                                                    $api_url = $this->api_url.'get_file_size/video';
                                                    $response = $this->terminal_response($api_url,$params);
                                                    echo '<pre>';print_r($response);exit;
                                                    */
                                                
                                                    $vid_url = $task['video'];
                                                    $params = array();
                                                    $params['terminal_id'] = $tvalue;
                                                    $params['path'] = $vid_url;
                                                    $path = $vid_url;

                                                    $api_url = $this->api_url.'upload_file/video';
                                                    $response = $this->terminal_response($api_url,$params);
                                                    if(isset($response['status']) && $response['status']==200){
                                                        $datails = json_decode($response['details']);
                                                        $path = $datails->details;
                                                    }
                                                    $muted = 'muted';
                                                    $loop = 'loop';

                                                    $contents[$tkey]['data'] = '<video width="'.$twidth.'" height="'.$theight.'" autoplay '.$loop.' '.$muted.'><source src="'.$path.'" type="video/mp4"><source src="'.$path.'" type="video/ogg"><source src="'.$path.'" type="video/webm">Your browser does not support the video tag.</video>';
                                                    $contents[$tkey]['time'] = $task['tis'];
                                                break;
                                            case 'html':
                                                    $contents[$tkey]['data'] = $task['content_text'];
                                                break;
                                            case 'marquee':
                                                    $align = 'middle';
                                                    $direction = 'left';
                                                    $loop = 'INFINITE';
                                                    $scrolldelay = 0;
                                                    $behavior = 'scroll';
                                                    $contents[$tkey]['data'] = '<marquee align="'.$align.'" loop="'.$loop.'" scrolldelay="'.$scrolldelay.'" behavior="'.$behavior.'" scrolldelay="'.$scrolldelay.'" direction="'.$direction.'">'.$task['content_text'].'</marquee>';
                                                break;
                                            default:
                                                    $is_data = false;
                                                break;
                                        }
                                        $contents[$tkey]['time'] = $task['tis'];
                                        $contents[$tkey]['bc'] = $task['bc'];
                                    }
                       // echo '<pre>';print_r($contents);exit;
                        if(!empty($contents)){
                            $html = $this->load->view('template-playlist',array('contents'=>$contents),true);
                            if($html!=''){
                                $api_url = $this->api_url.'set_html';
                                $params['terminal_id'] = $tvalue;
                                $params['html'] = $html;
                                //print_r($api_url);
                                $response = $this->terminal_response($api_url,$params);
                                 print_r($response);
                                if($response['status']==200){
                                    $status = true;
                                    $upd_table = array();
                                    $upd_table['is_schedule'] = '1';
                                    $upd_table['updated_on'] = date(DB_DATETIME_FORMAT);
                                    $upd_id = $this->CRUD->update_data(TBL_SCHEDULE,$upd_table,array('id'=>$playlist->id));
                                }
                            }
                        }
                    }
                }
            }
        }

	
    $playlists = $this->Model->get_playlist_data($from_date,$to_date,$start=false);
	if(isset($playlists)&&!empty($playlists)){  
    print_r($playlists);      
	    foreach($playlists as $pkey =>$playlist){
	        //$playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
		$tasks = isset($playlist->playlist) && !empty(unserialize($playlist->playlist)) ? unserialize($playlist->playlist) : array() ;
		$terminals = isset($playlist->terminals) && !empty(unserialize($playlist->terminals)) ? unserialize($playlist->terminals) : array() ;
		        if(!empty($tasks) && !empty($terminals)){
		            foreach ($terminals as $tkey => $tvalue) {
		                $api_url = $this->api_url.'clear_terminal';
		                        $params['terminal_id'] = $tvalue;
		                        $params['html'] = NULL;
		                        $response = $this->terminal_response($api_url,$params);
			
	    	}
	      }
	   }
	}



    }
    function terminal_response($api_url,$params){
        if($api_url!='' && !empty($params)){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            $response = curl_exec($ch);
            
            $return['status'] = 200;
            $return['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$return['status']))->row()->msg;
            $return['details'] = $response;
            return  $return;
        }
        return false;
    }
}
