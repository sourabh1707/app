<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Playlist extends MY_Controller {
    public $module_name = 'playlist';
    public $api_url = '';
    function __construct() {
        parent::__construct();
        $this->api_url = API_URL.'v2/';
        $this->load->model('Playlist_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'list';
        $page_data['page_title'] = 'Playlist';
        $user_id = $this->session->userdata('user_id');
        $page_data['terminal_s'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','is_delete'=>'0','user_id'=>$user_id));
        $page_data['terminals'] = $this->CRUD->get_data(TBL_GROUP_TERMINAL,array('is_active'=>'1','is_delete'=>'1','user_id'=>$user_id));

        $this->load->view('index',$page_data);
    }
    public function add(){
        valid_session($this->module_name,'write');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'add';
        $page_data['clients'] = $this->CRUD->get_data(TBL_CLIENT);
        $page_data['page_title'] = 'Playlist';
        $this->load->view('index',$page_data);
    }
    public function edit($id=''){
        valid_session($this->module_name,'write');
        $id = $id!='' ? decode_string($id) : '';
        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
        if($playlist){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'add';
            $page_data['page_title'] = 'Playlist';
            $page_data['playlist'] = $playlist;
            $this->load->view('index',$page_data);
        }
        else{
            $page_data = array();
            $page_data['page_title'] = '404';
            $this->load->view('error_404',$page_data);
        }
    }

public function preview($id=''){
        valid_session($this->module_name,'write');
        $id = $id!='' ? decode_string($id) : '';
        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
        if($playlist){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'preview';
            $page_data['page_title'] = 'Preview';
            $page_data['playlist'] = $playlist;
            $this->load->view('index',$page_data);
        }
        else{
            $page_data = array();
            $page_data['page_title'] = '404';
            $this->load->view('error_404',$page_data);
        }
    }


    public function crud($type='',$id=''){
        $id = $id!='' ? decode_string($id) : '';
        $json = array();
        $json['status'] = 201;
        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        $json['details'] = array('Invalid Details');
        if($type=='list'){
            $json = array();
            $data = array();
            $data_array = array();

            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $order_array = $this->input->post('order');
            $search_array = $this->input->post('search');
            $draw = $this->input->post('draw');


            $where = array();
            $where['start'] = $start;
            $where['length'] = $length;
            if(isset($order_array[0]['column']) && $order_array[0]['column']!=0){
                $col_id = $order_array[0]['column'];
                if($col_id==2){
                    $where['order'] = 'name';
                }
            }
            if(isset($search_array['value']) && $search_array['value']!=''){
                $where['search'] = $search_array['value'];
            }

            $all_count = $this->Model->get_all_count();
            $filtered_count = $this->Model->get_filtered_count($where);

            $data_array = $this->Model->get_datatable($where);
            if(isset($data_array) && !empty($data_array)){
                foreach ($data_array as $d) {
                    $start++;
                    $schedule = '';
                    $checked = $d->is_active==1 ? "checked" : "";
                    $status = '<input type="checkbox" class="js-switch change-status" data-id="'.encode_string($d->id).'" '.$checked.'/>';
                    $edit = '<a href="'.site_url("playlist/edit/".encode_string($d->id)).'" style=" margin-bottom: 0px; " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="'. translate('edit').'"><i class="fa fa-edit"></i></a>';
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    $send = '<a href="javascript:void(0);" data-title="'. translate('send').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-warning btn-xs show-send" data-toggle="tooltip" data-placement="top" title="'. translate('send on group terminal').'"><i class="fa fa-share"></i></a>';
                    
                    $schedule = '<a href="javascript:void(0);" data-title="'. translate('schedule').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-danger btn-xs show-schedule" data-toggle="tooltip" data-placement="top" title="'. translate('schedule for group').'"><i class="fa fa-clock-o"></i></a>';
	
		            $delete = '<a href="javascript:void(0);" data-title="'. translate('delete').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-danger btn-xs delete-details" data-toggle="tooltip" data-placement="top" title="'. translate('delete').'"><i class="fa fa-trash"></i></a>';

                    $schedulet = '<a href="javascript:void(0);" data-title="'. translate('schedule').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-warning btn-xs show-schedulet" data-toggle="tooltip" data-placement="top" title="'. translate('schedule for single').'"><i class="fa fa-clock-o"></i></a>';

                    $sendt = '<a href="javascript:void(0);" data-title="'. translate('send').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-info btn-xs show-sendt" data-toggle="tooltip" data-placement="top" title="'. translate('send on single terminal').'"><i class="fa fa-share"></i></a>';

                    // $sendt = '<a href="javascript:void(0);" data-title="'. translate('send').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-info btn-xs show-sendt" data-toggle="tooltip" data-placement="top" title="'. translate('send on single terminal').'"><i class="fa fa-share"></i></a>';

                    
                    $row = array();
                    $row[] = $start;
                    $row[] = $d->name;
                    $row[] = '<a href="'.site_url("playlist/preview/".encode_string($d->id)).'"  class="btn btn-success btn-sm">View</a> ';
                    // $row[] = $status.' '.$details.' '.$edit.' '.$schedule.' '.$delete;
                    // $row[] = $status.' '.$details.' '.$edit.' '.$schedule.' '.$delete.' '.$send;
                    $row[] = $status.' '.$details.' '.$edit.' '.$schedule.' '.$schedulet.' '.$delete.' '.$send.' '.$sendt.''.$preview;
                    $data[] = $row;
                }
            }
            $json['draw'] = intval($draw);
            $json['recordsTotal'] = intval($all_count);
            $json['recordsFiltered'] = intval($filtered_count);
            $json['data'] = $data;
        }

        if($type=='change_status'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='change_status'){
                    $up_data = array();
                    $status = $this->input->post('status');
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $user_id = $this->session->userdata('user_id');

                    if($status=='true'){
                        $up_data['is_active'] = '1';
                    }
                    else{
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    
                    $upd_id = $this->CRUD->update_data(TBL_PLAYLIST,$up_data,array('id'=>$id));
                    if($upd_id){
                        if($status=='true'){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('activated_successfully'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'activated_successfully';
                                add_log1($log_data,$user_id,0,$id,0,0,0,0);
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('deactivated_successfully'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'deactivated_successfully';
                                add_log1($log_data,$user_id,0,$id,0,0,0,0);
                        }
                    }
                }
            }
        }


/*
        if($type=='send'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='send_command'){
                    $up_data = array();
                    $status = false;
                    $id = $this->input->post('id');
                    $id = decode_string($id);//playlist id
                    $user_id= $this->session->userdata('user_id');
                    // $terminals = $this->input->post('terminal');//terminal
                    // $gt_id = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$terminals_id));
                    $terminals_id = $this->input->post('terminal[]');//terminal
                    $gt_id = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$terminals_id));
                    $terminal['gt_id'] = $gt_id;
                    $terminals = unserialize($terminal['gt_id']->group_terminal);

                    $ter_grp= array();
                    $ter_grp=implode(',',$terminals_id);
                    
                    if($id!='' && !empty($terminals)){
                        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                        if($playlist){
                            $tasks = isset($playlist->playlist) && !empty(unserialize($playlist->playlist)) ? unserialize($playlist->playlist) : array() ;
                            if($tasks){
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
                                                    *****
                                                
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

					                if(!empty($contents)){
		                            $html = $this->load->view($this->module_name.'/template-playlist',array('contents'=>$contents),true);
                                    
                                    // echo '<pre>';
                                    // print_r($html);
                                    // echo '</pre>';
                                    // exit();

                                    if($html!=''){
		                                $api_url = $this->api_url.'set_html';
		                                $params['terminal_id'] = $tvalue;
		                                $params['html'] = $html;
		                                $response = $this->terminal_response($api_url,$params);
		                                if($response['status']==200){
		                                    $status = true;
		                                }
		                            }
		                            //echo $html;exit;
		                          }
                                }
                            }
                        }
                        
                        if($status){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('send_successfully'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'send_successfully';
                                add_log1($log_data,$user_id,$ter_grp,$id,0,0,0);

                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unable_to_send'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'unable_to_send';
                                add_log1($log_data,$user_id,$ter_grp,$id,0,0,0);
                        }
                    }
                }
            }
        }
*/
     

 if($type=='send'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='send_command'){
                    
                    $up_data = array();
                    $status = false;
                    $id = $this->input->post('id');
                    $id = decode_string($id);//playlist id
                    $user_id= $this->session->userdata('user_id');
                    $terminals_id = $this->input->post('terminal[]');//terminal
                    // old query
                    //$gt_id = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$terminals_id));

                    //changed query
                   $gt_id = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('is_active'=>'1','is_delete'=>'1','user_id'=>$user_id));

                  //  $page_data['terminals'] = $this->CRUD->get_data(TBL_GROUP_TERMINAL,array('is_active'=>'1','is_delete'=>'1','user_id'=>$user_id));

                    $terminal['gt_id'] = $gt_id;
                  
                    $terminals = unserialize($terminal['gt_id']->group_terminal); 

                    $ter_grp= array();
                    $ter_grp=implode(',',$terminals_id);   
                    $start_time= date(DB_DATETIME_FORMAT);        

                 /* echo '<pre>';
                         print_r($ter_grp);    
                         echo '</pre>';exit();
                  */
                    if($id!='' && !empty($terminals)){
                        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                        if($playlist){
                            $tasks = isset($playlist->playlist) && !empty(unserialize($playlist->playlist)) ? unserialize($playlist->playlist) : array() ;
                            if($tasks){
                                foreach ($terminals as $tkey => $tvalue) {
                                    $twidth = $this->db->get_where(TBL_TTERMINAL,array('name'=>$tvalue))->row()->width;
                                    $theight = $this->db->get_where(TBL_TTERMINAL,array('name'=>$tvalue))->row()->height;
                                    $contents = array();
                                    foreach($tasks as $tkey => $task) {
                                        switch ($task['type']) {
                                            case 'image':
                                                    $params = array();
                                                    $params['terminal_id'] = $tvalue;
                                                    $params['path'] = $task['image'];
                                                    $path = $task['image'];
                                                    $contents[$tkey]['data'] = '<img width="'.$twidth.'" height="'.$theight.'" src="' . $path . '">';
                                                break;
                                            case 'video':
                                                   
                                                    $vid_url = $task['video'];
                                                    $params = array();
                                                    $params['terminal_id'] = $tvalue;
                                                    $params['path'] = $vid_url;
                                                    $path = $vid_url;
                                                  
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
                                   
                                   if(!empty($contents)){
                                    $html = $this->load->view($this->module_name.'/template-playlist',array('contents'=>$contents),true);

                                    if($html!=''){
                                        $api_url = $this->api_url.'set_html';
                                        $params['terminal_id'] = $tvalue;
                                        $params['html'] = $html;
                                        $response = $this->terminal_response($api_url,$params);
                                        if($response['status']==200){
                                            $status = true;
                                        }
                                    }
                                    //echo $html;exit;
                                  }
                                }
                            }
                        }
                       
                        if($status){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('send_successfully'));
                            

                                $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'send_successfully';
                                add_log1($log_data,$user_id,$ter_grp,$id,$start_time,0,0,0);

                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unable_to_send'));

                             $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'unable_to_send';
                                add_log1($log_data,$user_id,$ter_grp,$id,$start_time,0,0,0);
                        }
                    }
                }
            }
        }

        if($type=='send_single'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='send_single_command'){
                    $userid= $this->session->userdata('user_id');
                    $up_data = array();
                    $status = false;
                    $id = $this->input->post('id');
                    $id = decode_string($id);//playlist id
                    $terminals = $this->input->post('terminal[]');//terminal

                    $ter_grp= array();
                    $ter_grp=implode(',',$terminals);   

                   // print_r($terminals); exit();
                    $start_time= date(DB_DATETIME_FORMAT);
                    if($id!='' && !empty($terminals)){
                        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                        if($playlist){
                            $tasks = isset($playlist->playlist) && !empty(unserialize($playlist->playlist)) ? unserialize($playlist->playlist) : array() ;
                            if($tasks){
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

                                    if(!empty($contents)){
                                        $html = $this->load->view($this->module_name.'/template-playlist',array('contents'=>$contents),true);
                                        if($html!=''){
                                            $api_url = $this->api_url.'set_html';
                                            $params['terminal_id'] = $tvalue;
                                            $params['html'] = $html;
                                            $response = $this->terminal_response($api_url,$params);
                                            if($response['status']==200){
                                                $status = true;
                                            }
                                        }
                                        print_r($contents);exit();
                                      //  print_r($html);exit();
                                        //echo $html;exit;
                                    }
                                }
                            }
                        }
                        
                        if($status){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('send_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'send_successfully';
                            add_log1($log_data,$userid,0,$id,$start_time,0,0,$ter_grp);
                        }
                      //  print_r($status) ; exit();
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unable_to_send'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'unable_to_send';
                            add_log1($log_data,$userid,0,$id,$start_time,0,0,$ter_grp);

                        }
                    }
                }
            }
        }
        
        // ===========================================================================================================

        // echo '<pre>';
        // print_r($_POST);
        // print_r($terminals);
        // print_r($type);
        // echo '</pre>';exit();

    /*    if($type=='schedule'){ 
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='schedule_command'){
                    $up_data = array();
                    $status = false;
                    $id = $this->input->post('id');
                    $id = decode_string($id);//playlist id
                    $terminals_id = $this->input->post('terminal[]');//terminal
                    
                    $uid = $this->session->userdata('user_id'); 
                    $ter_id= array();
                    $ter_id =implode(',',$terminals_id);

                    $gt_id = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$terminals_id));
                    $terminal['gt_id'] = $gt_id;
                    $terminals = unserialize($terminal['gt_id']->group_terminal);


                    
                    $datetime = $this->input->post('datetime');//terminal
        		    //$datetime = explode($datetime,' - ');
        		    $d = explode(' - ',$datetime);
        		    $dt1 = new DateTime($d[0]);
        		    $dt2 = new DateTime($d[1]);
        		    $start_datetime = $dt1->format('Y-m-d H:i:s');
        		    $end_datetime = $dt2->format('Y-m-d H:i:s');
                    $hourdiff = round((strtotime($end_datetime) - strtotime($start_datetime))/3600, 1);
                    if($id!='' && !empty($terminals) && $datetime!=''){
                        $ins_id = false;
                        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                        if($playlist){
                            $schedule = array();
                            $schedule['playlist_id'] = $playlist->id;
                            $schedule['name'] = $playlist->name;
                            $schedule['playlist'] = $playlist->playlist;
                            $schedule['schedule_on'] = $start_datetime;
            			    $schedule['schedule_to'] = $end_datetime;
            			    //$schedule['schedule_on'] = trim($datetime[0]);
            			    //$schedule['schedule_to'] = trim($datetime[1]);
                            $schedule['terminals'] = serialize($terminals);
                            $schedule['created_by'] = $this->session->userdata('user_id');
                            $schedule['created_on'] = date('Y-m-d H:i:s');
                            $schedule['updated_by'] = $this->session->userdata('user_id');
                            $schedule['updated_on'] = date('Y-m-d H:i:s');
			                $ins_id = $this->CRUD->insert_data(TBL_SCHEDULE,$schedule);
                        }
			           //echo $this->db->last_query();
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('schedule_successfully'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'schedule_successfully';
                            add_log1($log_data,$uid,$ter_id,$id,$start_datetime,$end_datetime,$hourdiff);
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unable_to_schedule'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'unable_to_schedule';
                            add_log1($log_data,$uid,$ter_id,$start_datetime,$end_datetime,$id,$hourdiff);
                        }
                    }
                }
            }
        }

   */ 


if($type=='schedule'){ 
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='schedule_command'){
                    
                    $up_data = array();
                    $status = false;
                    $id = $this->input->post('id');
                    $id = decode_string($id);//playlist id
                    $terminals = $this->input->post('terminal'); //terminal
                    $datetime = $this->input->post('datetime');//terminal
                    $uid = $this->session->userdata('user_id');
                    
                    //print_r($terminals);exit();

            //$datetime = explode($datetime,' - ');
           $ter_id= array();
           $ter_id =implode(',',$terminals);  
            

            $d = explode(' - ',$datetime);
            $dt1 = new DateTime($d[0]);
            $dt2 = new DateTime($d[1]);
            $start_datetime = $dt1->format('Y-m-d H:i:s');
            $end_datetime = $dt2->format('Y-m-d H:i:s');
          //  $hourdiff = round(($end_datetime - $start_datetime)/3600, 1);
           // $hourdiff = round((strtotime($end_datetime) - strtotime($start_datetime))/3600, 1);
            $hourdiff = round((strtotime($end_datetime) - strtotime($start_datetime)));

                    if($id!='' && !empty($terminals) && $datetime!=''){
                        $ins_id = false;
                        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                        if($playlist){
                            $schedule = array();
                            $schedule['playlist_id'] = $playlist->id;
                            $schedule['name'] = $playlist->name;
                            $schedule['playlist'] = $playlist->playlist;
                            $schedule['schedule_on'] = $start_datetime;
                            $schedule['schedule_to'] = $end_datetime;
                            //$schedule['schedule_on'] = trim($datetime[0]);
                            //$schedule['schedule_to'] = trim($datetime[1]);
                            $schedule['terminals'] = serialize($terminals);
                            $schedule['created_by'] = $this->session->userdata('user_id');
                            $schedule['created_on'] = date(DB_DATETIME_FORMAT);
                            $schedule['updated_by'] = $this->session->userdata('user_id');
                            $schedule['updated_on'] = date(DB_DATETIME_FORMAT);

               /*echo '<pre>';
                print_r($hourdiff);
                 // print_r($end_datetime);
               //  //print_r($schedule['schedule_to']);
                  echo '</pre>';exit();
                */ 
             
                            $ins_id = $this->CRUD->insert_data(TBL_SCHEDULE,$schedule);
                        }
            //echo $this->db->last_query();
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('schedule_successfully'));


                                $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'schedule_successfully';
                            add_log1($log_data,$uid,$ter_id,$id,$start_datetime,$end_datetime,$hourdiff,0);
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unable_to_schedule'));

                                $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'unable_to_schedule';
                            add_log1($log_data,$uid,$ter_id,$start_datetime,$end_datetime,$id,$hourdiff,0);
                        }
                    }
                }
            }
        }



        if($type=='schedule_single'){ 
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='schedule_single_command'){
                    $up_data = array();
                    $status = false;
                    $id = $this->input->post('id');
                    $uid = $this->session->userdata('user_id');
                    $id = decode_string($id);//playlist id
                    $terminals = $this->input->post('terminal');//terminal
                    $datetime = $this->input->post('datetime');//terminal
                    //$datetime = explode($datetime,' - ');
                    $d = explode(' - ',$datetime);
                    $dt1 = new DateTime($d[0]);
                    $dt2 = new DateTime($d[1]);
                    $start_datetime = $dt1->format('Y-m-d H:i:s');
                    $end_datetime = $dt2->format('Y-m-d H:i:s');
                    //$hourdiff = round((strtotime($end_datetime) - strtotime($start_datetime))/3600, 1);

                    $hourdiff = round((strtotime($end_datetime) - strtotime($start_datetime)));
                    
                    if($id!='' && !empty($terminals) && $datetime!=''){
                        $ins_id = false;
                        $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                        if($playlist){
                            $schedule = array();
                            $schedule['playlist_id'] = $playlist->id;
                            $schedule['name'] = $playlist->name;
                            $schedule['playlist'] = $playlist->playlist;
                            $schedule['schedule_on'] = $start_datetime;
                            $schedule['schedule_to'] = $end_datetime;
                            //$schedule['schedule_on'] = trim($datetime[0]);
                            //$schedule['schedule_to'] = trim($datetime[1]);
                            $schedule['terminals'] = serialize($terminals);
                            $schedule['created_by'] = $this->session->userdata('user_id');
                            $schedule['created_on'] = date('Y-m-d H:i:s');
                            $schedule['updated_by'] = $this->session->userdata('user_id');
                            $schedule['updated_on'] = date('Y-m-d H:i:s');
                            $ins_id = $this->CRUD->insert_data(TBL_SCHEDULE,$schedule);
                        }
                        //echo $this->db->last_query();
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('schedule_successfully'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'single_schedule_successfully';
                            add_log1($log_data,$uid,0,$id,$start_datetime,$end_datetime,$hourdiff,$terminals);
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unable_to_schedule'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'unable_to_schedule';
                            add_log1($log_data,$uid,0,$id,$start_datetime,$end_datetime,$hourdiff,$terminals);
                        }
                    }
                }
            }
        }

        if($type=='add'){
            $action = $this->input->post('action');
            if($action=='add_playlist'){
                $this->form_validation->set_rules('playlist_name', translate('playlist_name'), 'trim|required|callback_unique_name');
                if ($this->form_validation->run()){
                    $in_data = array();
                    $uid = $this->session->userdata('user_id');
                    $in_data['name'] = $this->input->post('playlist_name');
                    $playlist = $this->input->post('playlist',false);
                    $in_data['playlist'] = serialize($playlist);
                    
                    $in_data['created_by'] = $this->session->userdata('user_id');
                    $in_data['created_on'] = date('Y-m-d H:i:s');
                    $in_data['updated_by'] = $this->session->userdata('user_id');
                    $in_data['updated_on'] = date('Y-m-d H:i:s');
	                $ins_id = $this->CRUD->insert_data(TBL_PLAYLIST,$in_data);
                    $insert_id = $this->db->insert_id();
                    if($ins_id){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('added_successfully'));

                        $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'added_successfully';
                               // add_log1($log_data,$uid,0,$insert_id,0,0);
                            add_log1($log_data,$uid,0,$insert_id,0,0,0,0);
                    }
                    else{
                        $json['status'] = 205;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('unabal_to_add'));

                        $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'unabal_to_add';
                               // add_log1($log_data,$uid,0,$insert_id,0,0);
                                 add_log1($log_data,$uid,0,$insert_id,0,0,0,0);
                    }
                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
        }

        if($type=='details'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='get_details'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                    if($playlist){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('playlist'=>$playlist),true);
                    }
                }
            }
        }
	   
        if($type=='delete'){
		    $action = $this->input->post('action');
		    if($action!=''){
		        if($action=='delete_details'){
		            $id = $this->input->post('id');
		            $id = decode_string($id);
                    $user_id= $this->session->userdata('user_id');
		            $up_data['is_delete'] = '0';
		            $up_data['updated_by'] = $this->session->userdata('user_id');
		            $layout = $this->CRUD->update_data(TBL_PLAYLIST,$up_data,array('id'=>$id));
		            if($layout){
		                $json['status'] = 200;
		                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
		                $json['details'] = $this->load->view($this->module_name.'/template-details',array('layout'=>$layout),true);

                        $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'remove_data_successfully';
                                add_log1($log_data,$user_id,0,$id,0,0,0,0);
		            }
		        }
		    }
		}

        if($type=='get_video_length'){
            $action = $this->input->post('action');
            $url = $this->input->post('url');
            if($action!='' && $url!=''){
                if($action=='get_length'){
                    $url = str_replace(base_url(),FCPATH,$url);
                    require_once(FCPATH.'application/client/libraries/getid3/getid3.php');
                    $getID3 = new getID3;
                    $FileInfo = $getID3->analyze($url);
                    $playTime = isset($FileInfo['playtime_seconds']) ? $FileInfo['playtime_seconds'] : 0;
                    
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = round($playTime);
                }
            }
        }

        if($type=='edit' && $id!=''){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='edit_playlist'){
                    $u_id = $this->session->userdata('user_id');
                    $playlist = $this->CRUD->get_data_row(TBL_PLAYLIST,array('id'=>$id));
                    $unique_name = 'trim|required';
                    $unique_abbr = 'trim|required';
                    if($playlist->name!=$this->input->post('playlist_name')){
                        $unique_name = 'trim|required|callback_unique_name';
                    }
                    $this->form_validation->set_rules('playlist_name', translate('playlist_iD'), $unique_name);
                    if ($this->form_validation->run()){
                        $in_data = array();
                       
                        $in_data['name'] = $this->input->post('playlist_name');
                        $playlist = $this->input->post('playlist',false);
                        $in_data['playlist'] = serialize($playlist);
                        $in_data['updated_by'] = $this->session->userdata('user_id');
                        //$in_data['updated_on'] = date(DB_DATETIME_FORMAT);
			            $in_data['updated_on'] = date('Y-m-d H:i:s');
			
                        $ins_id = $this->CRUD->update_data(TBL_PLAYLIST,$in_data,array('id'=>$id));
                       // print_r($in_data['playlist']); exit();
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('updated_successfully'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'updated_successfully';
                                add_log1($log_data,$u_id,0,$id,0,0,0,0);
                        }
                        else{
                            $json['status'] = 205;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unabal_to_update'));

                            $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'unabal_to_update';
                                add_log1($log_data,$u_id,0,$id,0,0,0,0);
                        }
                    }
                    else{
                        $json['status'] = 205;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->form_validation->error_array();
                    }
                }
            }
        }
        
        echo encode_json($json);exit;
    }
    function terminal_response($api_url,$params){
        if($api_url!='' && !empty($params)){
            //echo '<pre>Operations URL : '.$api_url.'</pre><br/>';
            //echo '<pre>Params : '. print_r($params).'</pre<br/>';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            $response = curl_exec($ch);
            //echo '<pre>Response : ';var_export($response).'</pre<br/>';
            
            $return['status'] = 200;
            $return['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$return['status']))->row()->msg;
            $return['details'] = $response;
            return  $return;
        }
        return false;
    }
    function unique_name(){
        $playlist_name = $this->input->post('playlist_name');
        if($this->CRUD->get_data_row(TBL_PLAYLIST,array('name'=>$playlist_name))){
            $this->form_validation->set_message('unique_name',translate('this_playlist_name_is_already_exist'));
            return false;
        }
        return true;
    }
    function size(){
        $url = 'http://192.168.2.100/ador/uploads/filemanager/source/movie.mp4';
        $url = str_replace(base_url(),FCPATH,$url);
        require_once(FCPATH.'application/client/libraries/getid3/getid3.php');
        $getID3 = new getID3;
        $FileInfo = $getID3->analyze($url);
        echo 'Play Time is: '.round($FileInfo['playtime_seconds']);
        echo '<pre>';print_r($FileInfo);exit;
    }
    function set_background($terminal_id = '', $color = ''){
        $params = array();
        $params['color'] = $terminal_id;
        $params['terminal_id'] = $color;
        
        if($params['color']!='' && $params['terminal_id']!=''){
            $api_url = $this->api_url.'set_activity_background';            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            $response = curl_exec($ch);
            
            return  true;
        }
        return false;
    }
}
