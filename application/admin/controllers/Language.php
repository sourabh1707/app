<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Language extends MY_Controller {
    public $module_name = 'language';
    function __construct() {
        parent::__construct();
        $this->load->model('Language_model','Model');
    }
    public function index(){
        valid_session($this->module_name,'read');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'list';
        $page_data['page_title'] = 'language';
        $this->load->view('index',$page_data);
    }
    public function add(){
        valid_session($this->module_name,'write');
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'add';
        $page_data['page_title'] = 'language';
        $this->load->view('index',$page_data);
    }
    public function translation($slug=''){
        valid_session($this->module_name,'write');
        $language = $this->CRUD->get_data_row(TBL_LANGUAGE,array('slug'=>$slug));
        if($language){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'translation';
            $page_data['language_id'] = encode_string($language->id);
            $page_data['language_slug'] = $slug;
            $page_data['page_title'] = translate('language_translation');
            $this->load->view('index',$page_data);
        }
        else{
            $page_data = array();
            $page_data['page_title'] = '404';
            $this->load->view('error_404',$page_data);
        }
    }
    public function edit($id=''){
        valid_session($this->module_name,'write');
        $id = $id!='' ? decode_string($id) : '';
        $language = $this->CRUD->get_data_row(TBL_LANGUAGE,array('id'=>$id));
        if($language){
            $page_data = array();
            $page_data['module_name'] = $this->module_name;
            $page_data['page_name'] = 'add';
            $page_data['page_title'] = translate('language');
            $page_data['language'] = $language;
            $this->load->view('index',$page_data);
        }
        else{
            $page_data = array();
            $page_data['page_title'] = '404';
            $this->load->view('error_404',$page_data);
        }
    }
    public function crud($type='',$id=''){
        $json = array();
        $json['status'] = 201;
        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
        $json['details'] = array('Invalid Details');
        if($type=='translation'){
            $slug = $id;
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

            $all_count = $this->Model->get_translate_all_count($slug,$slug);
            $filtered_count = $this->Model->get_translate_filtered_count($where,$slug);

            $data_array = $this->Model->get_translate_datatable($where,$slug);
            if(isset($data_array) && !empty($data_array)){
                foreach ($data_array as $d) {
                    $start++;
                    $row = array();
                    $row[] = $start;
                    $row[] = "<span class='translate-abv'>".ucwords(str_replace('_', ' ', $d->word))."</span>";
                    $row[] = "<form class='form-horizontal' id='form-".$slug."_".$d->id."' method='post' action='".site_url('language/crud/set_translation')."'><div class='input-group' style='width:100%;margin-bottom: 1px;'><input type='text' name='translation' class='form-control input-sm translate-ann' value='".$d->$slug."' style='border: 1px solid rgb(48, 68, 87); height:26px'><span class='input-group-btn'><button type='button' class='btn btn-dark btn-xs btn-labeled btn-submit' style='padding: 0px 5px;font-size: initial;margin-bottom: 5px;' data-fid='".$slug."_".$d->id."' data-bs='". translate("Saving")."' data-as='". translate("Save")."' style='padding: 0px 5px'> <i class='fa fa-save'></i> ". translate("Save")."</button></span></div><input type='hidden' name='name' value='".$slug."'><input type='hidden' name='id' value='".encode_string($d->id)."'><input type='hidden' name='action' value='update_translation'></form>";
                    $data[] = $row;
                }
            }
            $json['draw'] = $draw;
            $json['recordsTotal'] = $all_count;
            $json['recordsFiltered'] = $filtered_count;
            $json['data'] = $data;
        }
        if($type=='set_translation'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='update_translation'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $key = $this->input->post('name');
                    $val = $this->input->post('translation');                 
                    $upd_id = $this->CRUD->update_data(TBL_LANGUAGE_TRANSLATION,array($key=>$val),array('id'=>$id));
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = array(translate('translation_updated_successfully'));
                }
            }
        }
        if($type=='change'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='change_language'){
                    $language = $this->input->post('language');
                    $this->session->set_userdata('language', $language);
                    $json['status'] = 200;
                    $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                    $json['details'] = array(translate('changed_successfully'));
                }
            }
        }
        $id = $id!='' ? decode_string($id) : '';
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
                    $checked = $d->is_active==1 ? "checked" : "";
                    $status = '';$edit = '';$delete = '';
                    if($d->slug!='english'){
                        if(empty($this->permissions) || isset($this->permissions[$this->module_name]['write'])){
                            $status = '<input type="checkbox" class="js-switch change-status" data-id="'.encode_string($d->id).'" '.$checked.'/>';
                            $edit = '<a href="'.site_url("language/edit/".encode_string($d->id)).'" style=" margin-bottom: 0px; " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="'.translate('edit').'"><i class="fa fa-edit"></i></a>';
                            $delete = '<a href="javascript:void(0)" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-danger btn-xs btn-language-delete" data-toggle="tooltip" data-placement="top" title="'.translate('delete').'"><i class="fa fa-trash"></i></a>';
                        }
                    }
                    $details = '<a href="javascript:void(0);" data-title="'. translate('details').'" data-id="'.encode_string($d->id).'" style=" margin-bottom: 0px; " class="btn btn-primary btn-xs show-details" data-toggle="tooltip" data-placement="top" title="'. translate('view').'"><i class="fa fa-eye"></i></a>';
                    $flag = base_url().'uploads/flag/default.png';
                    if(isset($d->flag) && $d->flag != '' && file_exists(FCPATH.'uploads/flag/'.$d->flag)){
                        $flag = base_url().'uploads/flag/'.$d->flag;
                    }
                    $translation = '<a href="'.site_url("language/translation/".$d->slug).'" style=" margin-bottom: 0px; " class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="'.translate('translation').'"><i class="fa fa-language"></i></a>';
                    $row = array();
                    $row[] = $start;
                    $row[] = '<img src="'.$flag.'" class="avatar" alt="'.$d->name.'">';
                    $row[] = $d->name;
                    $row[] = $status.' '.$details.' '.$translation.' '.$edit.' '.$delete;
                    $data[] = $row;
                }
            }
            $json['draw'] = $draw;
            $json['recordsTotal'] = $all_count;
            $json['recordsFiltered'] = $filtered_count;
            $json['data'] = $data;
        }
        if($type=='details'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='get_details'){
                    $id = $this->input->post('id');
                    $id = decode_string($id);
                    $language = $this->CRUD->get_data_row(TBL_LANGUAGE,array('id'=>$id));
                    if($language){
                        $json['status'] = 200;
                        $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                        $json['details'] = $this->load->view($this->module_name.'/template-details',array('language'=>$language),true);
                    }
                }
            }
        }
        if($type=='change_status'){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='change_status'){
                    $up_data = array();
                    $status = $this->input->post('status');
                    $id = $this->input->post('id');
                    $id = decode_string($id);

                    if($status=='true'){
                        $up_data['is_active'] = '1';
                    }
                    else{
                        $up_data['is_active'] = '0';
                    }
                    $up_data['updated_by'] = $this->session->userdata('admin_id');
                    
                    $upd_id = $this->CRUD->update_data(TBL_LANGUAGE,$up_data,array('id'=>$id));
                    if($upd_id){
                        if($status=='true'){
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('activated_successfully'));
                        }
                        else{
                            $json['status'] = 201;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('deactivated_successfully'));
                        }
                    }
                }
            }
        }
        if($type=='add'){
            $action = $this->input->post('action');
            if($action=='add_language'){
                $this->form_validation->set_rules('language_name', translate('name'), 'trim|required|callback_unique_language');
                if ($this->form_validation->run()){
                    $permission = $this->input->post('permission');
                    $in_data = array();
                    $lname = $this->input->post('language_name');
                    $in_data['name'] = $lname;
                    $in_data['slug'] = strtolower(str_replace(' ', '_', $lname));
                    $in_data['created_by'] = $this->session->userdata('admin_id');
                    $in_data['created_on'] = date(DB_DATETIME_FORMAT);
                    $in_data['updated_by'] = $this->session->userdata('admin_id');
                    $in_data['updated_on'] = date(DB_DATETIME_FORMAT);
                    $flag = $_FILES['flag'];
                    if(isset($flag) && !empty($flag)){
                        if($flag['name']!=''){
                            $ext = end((explode(".", $flag['name'])));
                            $file_name = 'Flag_'.date('YmdHis').'.'.$ext;
                            $target_path = base_url().'uploads/flag/'.$file_name;
                            if (move_uploaded_file($flag["tmp_name"], str_replace(base_url(),FCPATH, $target_path))) {
                                $in_data['flag'] = $file_name;
                            }
                        }
                    }
                    $ins_id = $this->CRUD->insert_data(TBL_LANGUAGE,$in_data);
                    if($ins_id){
                        $this->Model->add_column($in_data['slug']);
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
        
        if($type=='edit' && $id!=''){
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='edit_language'){
                    $language = $this->CRUD->get_data_row(TBL_LANGUAGE,array('id'=>$id));
                    $unique_name = 'trim|required';
                    if($language->name!=$this->input->post('language_name')){
                        $unique_name = 'trim|required|callback_unique_language';
                    }
                    $this->form_validation->set_rules('language_name', 'Name', $unique_name);
                    if ($this->form_validation->run()){
                        $in_data = array();
                        $lname = $this->input->post('language_name');
                        $in_data['name'] = $lname;
                        $in_data['slug'] = strtolower(str_replace(' ', '_', $lname));
                        $in_data['updated_by'] = $this->session->userdata('admin_id');
                        $in_data['updated_on'] = date(DB_DATETIME_FORMAT);
                        $flag = $_FILES['flag'];
                        if(isset($flag) && !empty($flag)){
                            if($flag['name']!=''){
                                $ext = end((explode(".", $flag['name'])));
                                $file_name = 'Flag_'.date('YmdHis').'.'.$ext;
                                $target_path = base_url().'uploads/flag/'.$file_name;
                                if (move_uploaded_file($flag["tmp_name"], str_replace(base_url(),FCPATH, $target_path))) {
                                    $in_data['flag'] = $file_name;
                                }
                            }
                        }
                        $ins_id = $this->CRUD->update_data(TBL_LANGUAGE,$in_data,array('id'=>$id));
                        if($ins_id){
                            $this->Model->modify_column($language->slug,$in_data['slug']);
                            $json['status'] = 200;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('updated_successfully'));
                        }
                        else{
                            $json['status'] = 205;
                            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                            $json['details'] = array(translate('unabal_to_update'));
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
        if($type=='delete'){
            $json['status'] = 205;
            $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
            $json['details'] = array(translate('unabal_to_deleted'));
            $action = $this->input->post('action');
            if($action!=''){
                if($action=='delete'){
                    $id = $this->input->post('id');
                    $language = $this->CRUD->get_data_row(TBL_LANGUAGE,array('id'=>decode_string($id)));
                    if($language){
                        $column = $language->slug;
                        $is_delete = $this->CRUD->delete_data(TBL_LANGUAGE,array('id'=>$language->id));
                        if($is_delete){
                            $is_drop = $this->Model->drop_column($column);
                            if($is_drop){
                                $json['status'] = 200;
                                $json['message'] = $this->db->get_where(TBL_ERROR_CODE,array('code'=>$json['status']))->row()->msg;
                                $json['details'] = array(translate('deleted_successfully'));
                            }
                        }
                    }
                }
            }
        }
        echo encode_json($json);exit;
    }
    function unique_language(){
        $language_name = $this->input->post('language_name');
        if($this->CRUD->get_data_row(TBL_LANGUAGE,array('name'=>$language_name))){
            $this->form_validation->set_message('unique_language',translate('this_language_is_already_exist'));
            return false;
        }
        return true;
    }
}
