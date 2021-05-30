<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/V1_Controller.php');
class V1 extends V1_Controller {
    function __construct() {
        parent::__construct();
        $this->api_url = API_URL.'v2/';
        $this->load->model('V1_model','Model');
	//file_put_contents('logs.txt','Working'.PHP_EOL,FILE_APPEND);
    }
    public function index() {
        echo 'This is cron V1';
    }
    public function schedular() {
        $from_date = date(DB_DATETIME_FORMAT, strtotime('-1 minutes'));
        $to_date = date(DB_DATETIME_FORMAT);
        $playlists = $this->Model->get_playlist_data($from_date,$to_date,$start=true);
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
                                        /*$api_url = $this->api_url.'upload_file/image';
                                        $response = $this->terminal_response($api_url,$params);
                                        if(isset($response['status']) && $response['status']==200){
                                            $datails = json_decode($response['details']);
                                            $path = $datails->details;
                                        }*/
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
                                        /*$api_url = $this->api_url.'upload_file/video';
                                        $response = $this->terminal_response($api_url,$params);
                                        if(isset($response['status']) && $response['status']==200){
                                            $datails = json_decode($response['details']);
                                            $path = $datails->details;
                                        }*/
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
                        //echo '<pre>';print_r($contents);exit;
                        if(!empty($contents)){
                            $html = $this->load->view('template-playlist',array('contents'=>$contents),true);
                            if($html!=''){
                                $api_url = $this->api_url.'set_html';
                                $params['terminal_id'] = $tvalue;
                                $params['html'] = $html;
                                $response = $this->terminal_response($api_url,$params);
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
	    foreach($playlists as $pkey =>$playlist){
	        //$playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
		$tasks = isset($playlist->playlist) && !empty(unserialize($playlist->playlist)) ? unserialize($playlist->playlist) : array() ;
		$terminals = isset($playlist->terminals) && !empty(unserialize($playlist->terminals)) ? unserialize($playlist->terminals) : array() ;
		        if(!empty($tasks) && !empty($terminals)){
		            foreach ($terminals as $tkey => $tvalue) {
		                $api_url = $this->api_url.'clear_terminal';
		                        $params['terminal_id'] = $tvalue;
		                        $params['html'] = '';
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
