<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Gterminal extends MY_Controller {
    public $module_name = 'group-terminal';
    public $api_url = '';
    function __construct() {
        parent::__construct();
        $this->load->model('TerminalG_model','GT');
    }
    public function index(){
        // valid_session($this->module_name,'read');
        $user_id = $this->session->userdata('user_id');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'list';
        $page_data['page_title'] = 'Terminal Group';
        // $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        // $page_data['users'] = $this->CRUD->get_data(TBL_USER,array('is_active'=>'1','client_id'=>'1'));
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','is_delete'=>'1','user_id'=>$user_id));
        $page_data['boards'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','is_delete'=>'1','user_id'=>$user_id));
        $this->load->view('index',$page_data);
    }

    public function add(){
        // valid_session($this->module_name,'write');
        $user_id = $this->session->userdata('user_id');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'add';
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','is_delete'=>'0','user_id'=>$user_id));
        // $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));
        // $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','type'=>'1','is_delete'=>'1'));
        // $page_data['users'] = $this->CRUD->get_data(TBL_USER,array('is_active'=>'1','client_id'=>'1'));
        $page_data['page_title'] = 'Add Group Terminal';
        $this->load->view('index',$page_data);
    }


    public function delete_t($id=''){
        // valid_session($this->module_name,'write');
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
        $gtarray = unserialize($gtarray['gt_id'][0]->group_terminal);
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
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    // $send = '<a href="javascript:void(0);" data-title="'. translate('send').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-warning btn-xs show-send" data-toggle="tooltip" data-placement="top" title="'. translate('send').'"><i class="fa fa-share"></i></a>';
                    $delete = '<a href="javascript:void(0);" data-title="'. translate('delete').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-danger btn-xs delete-details" data-toggle="tooltip" data-placement="top" title="'. translate('delete').'"><i class="fa fa-trash"></i></a>';
                    $row = array();
                    $row[] = $start;
                    $row[] = $d->name;
                    $row[] = $details.' '.$delete;
                    $data[] = $row;
                }
            }
            $json['draw'] = intval($draw);
            $json['recordsTotal'] = intval($all_count);
            $json['recordsFiltered'] = intval($filtered_count);
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';exit();
            $json['data'] = $data;
        }

        if($type=='add'){
            $action = $this->input->post('action');
            if($action=='add_terminal'){
                $this->form_validation->set_rules('gtname', translate('name'), 'trim|required|callback_unique_name');
                if ($this->form_validation->run()){
                        $in_data = array();
                        $in_data['name'] = $this->input->post('gtname');
                        $tarray = $this->input->post('terminal_id',false);
                        // ======================================================================================
                            if(!empty($tarray)) 
                            { $i=0;
                                foreach($tarray as $gt) 
                                {
                                   $data['term'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','name'=>$gt));
                                   foreach ($data as $value) {
                                       $tid = $value[0]->id;
                                       $up_data = array('is_delete' =>'0');
                                       $up_data['user_id'] = $this->session->userdata('user_id');
                                        // $up_data['user_id'] = array('user_id' =>$user_id);
                                        // echo '<pre>';
                                        // print_r($tid);
                                        // print_r($up_data);
                                        // echo '</pre>';exit();
                                       $upd_id = $this->CRUD->update_data(TBL_TERMINAL,$up_data,array('id'=>$tid));
                                       $i++;
                                   }
                                }   
                            }
                          
                        // ======================================================================================
                        $in_data['group_terminal'] = serialize($tarray);
                        $in_data['user_id'] = $this->session->userdata('user_id');
                        $in_data['created_by'] = $this->session->userdata('user_id');
                        $in_data['created_on'] = date('Y-m-d H:i:s');
                        $in_data['updated_by'] = $this->session->userdata('user_id');
                        $in_data['updated_on'] = date('Y-m-d H:i:s');
                        // print_r($in_data);exit();
                        $ins_id = $this->CRUD->insert_data(TBL_GROUP_TERMINAL,$in_data);
                        if($ins_id){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('added_successfully'));
                        }
                        else{
                            $json['status'] = 205;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unabal_to_add'));
                        }
                }
                else{
                    $json['status'] = 205;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = $this->form_validation->error_array();
                }
            }
        }

        if($type=='send'){
        $action = $this->input->post('action'); 
            if($action!=''){
                if($action=='send_command'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $up_data['updated_by'] = $this->session->userdata('user_id');
                    $up_data['user_id'] = $this->input->post('user');
                    $gt = $this->CRUD->update_data(TBL_GROUP_TERMINAL,$up_data,array('id'=>$id));
                    if($gt){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = array(translate('send_successfully'));
                    }else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unable_to_send'));
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
                //=======================================================================================
                    // $gtdetails = $this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('id'=>$id));
                    // $gtarray['gt_id'] = $gtdetails;
                    // $gtarray = unserialize($gtarray['gt_id']->group_terminal);
                    // if(!empty($gtarray)) 
                    // { $i=0;
                    //     foreach($gtarray as $gt) 
                    //     {
                    //         $data['term'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1','name'=>$gt));
                    //         foreach ($data as $value) {
                    //            $tid = $value[0]->id;
                    //            $in_data = array('is_delete' =>'1');
                    //            // $upd_id = $this->CRUD->update_data(TBL_TERMINAL,$in_data,array('id'=>$tid));
                    //            $upd_id = $this->CRUD->update_data(TBL_TERMINAL,$in_data,array('id'=>$tid));
                    //            $i++;
                    //         }
                    //     }     
                    // }
                //=======================================================================================
                    $up_data['is_delete'] = '0';
                    $up_data['updated_by'] = $this->session->userdata('user_id');
                    $gtdetails = $this->CRUD->update_data(TBL_GROUP_TERMINAL,$up_data,array('id'=>$id));
                    if($gtdetails){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('gtdetails'=>$gtdetails),true);
                    }
                }
            }
        }

        echo encode_json($json);exit;
    }
    function unique_name(){
        $gtname = $this->input->post('name');
        if($this->CRUD->get_data_row(TBL_GROUP_TERMINAL,array('name'=>$gtname))){
            $this->form_validation->set_message('unique_name',translate('this_group_name_is_already_exist'));
            return false;
        }
        return true;
    }
}
//echo '<pre>';
// print_r($_POST);
// echo '</pre>';exit();








