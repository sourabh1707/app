<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Gterminal extends MY_Controller {
    public $module_name = 'group-terminal';
    // public $api_url = '';
    function __construct() {
        parent::__construct();
        // $this->api_url = API_URL.'v2/';
        $this->load->model('TerminalG_model','GT');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'list';
        $page_data['page_title'] = 'Terminal Group';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','is_delete'=>'1'));
        $page_data['users'] = $this->CRUD->get_data(TBL_USER,array('is_active'=>'1','client_id'=>'1'));
        $this->load->view('index',$page_data);
    }

    public function add(){
        valid_session($this->module_name,'write');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'add';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        // $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','is_delete'=>'1'));
        // $page_data['users'] = $this->CRUD->get_data(TBL_USER,array('is_active'=>'1','client_id'=>'1'));
        $page_data['page_title'] = 'Add Group Terminal';
        $this->load->view('index',$page_data);
    }
 
     public function edit($id=''){
        valid_session($this->module_name,'write');
        $id = $id!='' ? decode_string($id) : '';
        $terminalss = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$id));
        // $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));

        if($terminalss){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'add';
            $page_data['page_title'] = 'Edit Group Terminal';
            // $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
            // $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
            $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
            // $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','is_delete'=>'1'));
            $page_data['users'] = $this->CRUD->get_data(TBL_USER,array('is_active'=>'1','client_id'=>'1'));
            $page_data['terminalss'] = $terminalss;
            $this->load->view('index',$page_data);
        }
        else{
            $page_data = array();
            $page_data['page_title'] = '404';
            $this->load->view('error_404',$page_data);
        }
    }

    public function delete_t($id=''){
        valid_session($this->module_name,'write');
        $id = $id!='' ? decode_string($id) : '';
        $gtid = $this->input->post('gt_id');
        $t_id = $this->CRUD->get_data_row(TBL_TERMINAL,array('id'=>$id));
        $gt_id = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$gtid));
        // $gt = $this->input->post('terminal_id',false);
        // $in_data['group_terminal'] = serialize($gt);
        $in_data['created_by'] = $this->session->userdata('admin_id');
        $in_data['created_on'] = date('Y-m-d H:i:s');
        $in_data['updated_by'] = $this->session->userdata('admin_id');
        $in_data['updated_on'] = date('Y-m-d H:i:s');
        $gtarray['gt_id'] = $gt_id;
        $gtarray = unserialize($gtarray['gt_id']->group_terminal);
        if(!empty($gtarray)) 
        { $i=0;
            foreach($gtarray as $gt) 
            {
                if($t_id->name === $gt){
                    if (($gt = array_search($gt, $gtarray)) !== false) {
                        unset($gtarray[$gt]);
                        $in_data['group_terminal'] = serialize($gtarray);
                        $upd_id = $this->CRUD->update_data(TBL_GROUP_TERMINAL,$in_data,array('id'=>$gtid));
                    }
                  }
                $i++;
            }     
        }
        if($upd_id) 
        {
            redirect(site_url('gterminal'),'refresh');
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

            $all_count = $this->GT->get_all_count();
            $filtered_count = $this->GT->get_filtered_count($where);

            $data_array = $this->GT->get_datatable($where);
            if(isset($data_array) && !empty($data_array)){
                foreach ($data_array as $d) {
                    $start++;
                    $schedule = '';
                    $checked = $d->is_active==1 ? "checked" : "";
                    $status = '<input type="checkbox" class="js-switch change-status" data-id="'.encode_string($d->id).'" '.$checked.'/>';
                    $edit = '<a href="'.site_url("gterminal/edit/".encode_string($d->id)).'" style=" margin-bottom: 0px; " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="'. translate('edit').'"><i class="fa fa-edit"></i></a>';
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    $delete = '<a href="javascript:void(0);" data-title="'. translate('delete').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-danger btn-xs delete-details" data-toggle="tooltip" data-placement="top" title="'. translate('delete').'"><i class="fa fa-trash"></i></a>';
                    $send = '<a href="javascript:void(0);" data-title="'. translate('send').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-warning btn-xs show-sendu" data-toggle="tooltip" data-placement="top" title="'. translate('send').'"><i class="fa fa-share"></i></a>';
                    $row = array();
                    $row[] = $start;
                    $row[] = $d->name;
                    $row[] = unserialize($d->group_terminal);
                    $row[] = $d->username;
                    // $row[] = $d->name;
                    $row[] = $status.' '.$details.' '.$edit.' '.$delete.' '.$send;
                    $data[] = $row;
                }
            }
            $json['draw'] = intval($draw);
            $json['recordsTotal'] = intval($all_count);
            $json['recordsFiltered'] = intval($filtered_count);
            // echo '<pre>';
            // print_r($row);
            // echo '</pre>';exit();
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
                    $admin_id= $this->session->userdata('admin_id');
                   // print_r($id); exit();

                    if($status=='true'){
                        $up_data['is_active'] = '1';
                    }
                    else{
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    
                    $upd_id = $this->CRUD->update_data(TBL_GROUP_TERMINAL,$up_data,array('id'=>$id));
                    if($upd_id){
                        if($status=='true'){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('activated_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Group Terminal Activated Successfully';
                            add_log1($log_data,$admin_id,0,$id); 
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('deactivated_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Group Terminal Deactivated Successfully';
                            add_log1($log_data,$admin_id,0,$id); 
                        }
                    }
                }
            }
        }
        if($type=='add'){
            $action = $this->input->post('action');
            if($action=='add_terminal'){
                 $admin_id= $this->session->userdata('admin_id');
                $this->form_validation->set_rules('gtname', translate('name'), 'trim|required|callback_unique_name');
                if ($this->form_validation->run()){
                        $in_data = array();
                        $in_data['name'] = $this->input->post('gtname');
                        $tarray = $this->input->post('terminal_id',false);
                      //  print_r($tarray); exit();
                        // ======================================================================================
                            if(!empty($tarray)) 
                            { $i=0;
                                foreach($tarray as $gt) 
                                {
                                   $data['term'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','name'=>$gt));
                                   foreach ($data as $value) {
                                       $tid = $value[0]->id;
                                       $up_data = array('is_delete' =>'0');
                                       $upd_id = $this->CRUD->update_data(TBL_TERMINAL,$up_data,array('id'=>$tid));
                                       $i++;
                                   }
                                }   
                            }
                            // print_r($in_data);exit();
                            // exit();
                        // ======================================================================================
                        $in_data['group_terminal'] = serialize($tarray);
                        $in_data['created_by'] = $this->session->userdata('admin_id');
                        $in_data['created_on'] = date('Y-m-d H:i:s');
                        $in_data['updated_by'] = $this->session->userdata('admin_id');
                        $in_data['updated_on'] = date('Y-m-d H:i:s');
                        // print_r($in_data);exit();
                        $ins_id = $this->CRUD->insert_data(TBL_GROUP_TERMINAL,$in_data);
                        $insert_id = $this->db->insert_id();
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('added_successfully'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Group Terminal Added Successfully';
                            add_log1($log_data,$admin_id,0,$insert_id); 
                        }
                        else{
                            $json['status'] = 205;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unabal_to_add'));

                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'unabal_to_add';
                            add_log1($log_data,$admin_id,0,$insert_id); 
                        }
                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
        }
        // if($type=='send'){
        // $action = $this->input->post('action'); 
        //     if($action!=''){
        //         if($action=='send_command'){
        //             $id = $this->input->post('id');
        //             $id = decode_string($id);
        //             $up_data['updated_by'] = $this->session->userdata('admin_id');
        //             $up_data['user_id'] = $this->input->post('user');
        //             $gt = $this->CRUD->update_data(TBL_GROUP_TERMINAL,$up_data,array('id'=>$id));
        //             if($gt){
        //                 $json['status'] = 200;
        //                 $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        //                 $json['details'] = array(translate('send_successfully'));
        //             }else{
        //                     $json['status'] = 201;
        //                     $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        //                     $json['details'] = array(translate('unable_to_send'));
        //                 }
        //         }
        //     }
        // }
        if($type=='send'){
        $action = $this->input->post('action'); 
            if($action!=''){
                if($action=='send_command'){
                    $id = $this->input->post('id');
                    $admin_id=$this->session->userdata('admin_id');
                    $id = decode_string($id);
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $up_data['user_id'] = $this->input->post('user');
                    $up_dat['user_id'] = $this->input->post('user');
                    $user_id =$up_data['user_id'];
                  //  print_r($user_id); exit();
                    // echo '<pre>';
                    // print_r($_POST);
                    // echo '</pre>';exit();
                    $gt_id= $this->CRUD->get_data(TBL_GROUP_TERMINAL,array('is_active'=>'1','id'=>$id));
                    $gtarray['gt_id'] = $gt_id;
                    $gtarray = unserialize($gtarray['gt_id'][0]->group_terminal);
                    if (!empty($gtarray)) {
                        $i=0;
                        foreach ($gtarray as $value) {
                        $name = $value;
                        // $up_dat['user_id'] = array('user_id' =>$user_id);
                        $gt = $this->CRUD->update_data(TBL_TERMINAL,$up_dat,array('name'=>$name));
                        $i++;
                       }
                    }
                    $gt = $this->CRUD->update_data(TBL_GROUP_TERMINAL,$up_data,array('id'=>$id));
                    if($gt){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('send_successfully'));

                          $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'send_successfully';
                            add_log1($log_data,$admin_id,0,$id,$user_id);
                    }else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unable_to_send'));

                             $log_data = array();
                                $log_data['status'] = true;
                                $log_data['message'] = 'unable_to_send';
                                add_log1($log_data,$admin_id,0,$id,$user_id);
                        }
                }
            }
        }
        if($type=='details'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='get_details'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $gtdetails = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$id));
                    if($gtdetails){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('gtdetails'=>$gtdetails),true);
                        // echo '<pre>';
                        // print_r($gtdetails);
                        // echo '</pre>';exit();
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
                    $admin_id = $this->session->userdata('admin_id');
                //=======================================================================================
                    $gtdetails = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$id));
                    $gtarray['gt_id'] = $gtdetails;
                    $gtarray = unserialize($gtarray['gt_id']->group_terminal);
                    if(!empty($gtarray)) 
                    { $i=0;
                        foreach($gtarray as $gt) 
                        {
                            $data['term'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','name'=>$gt));
                            foreach ($data as $value) {
                               $tid = $value[0]->id;
                               $in_data = array('is_delete' =>'1');
                               $upd_id = $this->CRUD->update_data(TBL_TERMINAL,$in_data,array('id'=>$tid));
                               $i++;
                            }
                        }     
                    }
                //=======================================================================================
                    $up_data['is_delete'] = '0';
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    $gtdetails = $this->CRUD->update_data(TBL_GROUP_TERMINAL,$up_data,array('id'=>$id));
                    if($gtdetails){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('gtdetails'=>$gtdetails),true);

                        $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Group Terminal Deleted Successfully';
                            add_log1($log_data,$admin_id,0,$id); 
                    }
                }
            }
        }
        // if($type=='edit' && $id!=''){
        //     $action = $this->input->post('action');
        //     if($action!=''){
        //         if($action=='edit_terminal'){
        //             $gterminal = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$id));
        //             $this->form_validation->set_rules('gtname', translate('name'), 'trim|required');
        //             if($this->form_validation->run()){
        //                 $in_data = array();
        //                 $in_data['name'] = $this->input->post('gtname');
        //                 $gt = $this->input->post('terminal_id',false);
        //                 $gtarray['gterminal'] = $gterminal;
        //                 $gts = unserialize($gtarray['gterminal']->group_terminal);
        //                 if (!empty($gt)) {$i=0;
        //                     foreach ($gt as $value) {
        //                         array_push($gts,$value);
        //                     $i++;
        //                     }
        //                 }
        //                 $in_data['group_terminal'] = serialize($gts);
        //                 $in_data['created_by'] = $this->session->userdata('admin_id');
        //                 $in_data['created_on'] = date('Y-m-d H:i:s');
        //                 $in_data['updated_by'] = $this->session->userdata('admin_id');
        //                 $in_data['updated_on'] = date('Y-m-d H:i:s');
        //                 $ins_id = $this->CRUD->update_data(TBL_GROUP_TERMINAL,$in_data,array('id'=>$id));
        //                 if($ins_id){
        //                     $json['status'] = 200;
        //                     $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        //                     $json['details'] = array(translate('updated_successfully'));
        //                 }
        //                 else{
        //                     $json['status'] = 205;
        //                     $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        //                     $json['details'] = array(translate('unabal_to_update'));
        //                 }
        //             }
        //             else{
        //                 $json['status'] = 205;
        //                 $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        //                 $json['details'] = $this->form_validation->error_array();
        //             }
        //         }
        //     }
        // }

        if($type=='edit' && $id!=''){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='edit_terminal'){
                    $admin_id = $this->session->userdata('admin_id');
                    $gterminal = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$id));
                    $this->form_validation->set_rules('gtname', translate('name'), 'trim|required');
                    if($this->form_validation->run()){
                        $in_data = array();
                        $in_data['name'] = $this->input->post('gtname');
                        $gt = $this->input->post('terminal_id',false);

                        $gtarray['gterminal'] = $gterminal;
                        $gts = unserialize($gtarray['gterminal']->group_terminal);
                        if (!empty($gt)) {$i=0;
                            foreach ($gt as $value) {
                               array_push($gts,$value);
                            $i++;
                            }
                        }
                        $in_data['group_terminal'] = serialize($gts);
                        $last_element = end($gts); 
                        // print_r($last_element); exit();
                        // =====================================================
                        if(!empty($last_element)) 
                        { 
                            $last = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','name'=>$last_element));
                            $tid = $last[0]->id;
                            $up_data['is_delete'] = '0'; 
                            $up_data['user_id'] = $gterminal->user_id;
                            // array('is_delete' =>'0','user_id' =>$gterminal->user_id);
                            // echo '<pre>';
                            // print_r($last[0]->id);
                            // print_r($up_data);
                            // print_r($gterminal->user_id);
                            // echo '</pre>';exit();
                            $upd_id = $this->CRUD->update_data(TBL_TERMINAL,$up_data,array('id'=>$tid));

                        }                     
                    // ============================================
                        
                        $in_data['created_by'] = $this->session->userdata('admin_id');
                        $in_data['created_on'] = date('Y-m-d H:i:s');
                        $in_data['updated_by'] = $this->session->userdata('admin_id');
                        $in_data['updated_on'] = date('Y-m-d H:i:s');
                        $ins_id = $this->CRUD->update_data(TBL_GROUP_TERMINAL,$in_data,array('id'=>$id));
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('updated_successfully'));


                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'Group Terminal Updated Successfully';
                            add_log1($log_data,$admin_id,0,$id); 
                        }
                        else{
                            $json['status'] = 205;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unabal_to_update'));


                            $log_data = array();
                            $log_data['status'] = true;
                            $log_data['message'] = 'unabal_to_update';
                            add_log1($log_data,$admin_id,0,$id); 
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
    function unique_name(){
        $layout_name = $this->input->post('gtname');
        if($this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('name'=>$layout_name))){
            $this->form_validation->set_message('unique_name',translate('this_group-terminal_name_is_already_exist'));
            return false;
        }
        return true;
    }

}



//echo '<pre>';
// print_r($_POST);
// echo '</pre>';exit();
