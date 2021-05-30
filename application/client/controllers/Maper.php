<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/MY_Controller.php');
class Maper extends MY_Controller {

    public $module_name = 'maper';
// ========================================================================================================       
    public function index(){
        $page_data = array();
        $page_data['module_name'] = $this->module_name;
        $page_data['page_name'] = 'maperlist';
        $page_data['page_title'] = 'Maper';
        // $terminals = $this->CRUD->get_data(TBL_TERMINAL);
        $page_data['terminals'] = $this->CRUD->get_data(TBL_TERMINAL,array('is_active'=>'1'));

        $config['center'] = '21.2514,81.6296';
        // $config['zoom'] = 'auto';
        $this->googlemaps->initialize($config);

        if(!empty($page_data['terminals'])){
            $icon_active = base_url('uploads/system/marker-g-48.png');
            $icon_inactive = base_url('uploads/system/marker-r-48.png');
            foreach ($page_data['terminals'] as $value){
                $icon = $icon_inactive;
                if ($this->get_status($value->name)) {
                    $icon = $icon_active;
                }
                // $data['name'] = $value->name;
                $marker = array();
                $marker['position'] = $value->terminal_latitude.",".$value->terminal_longitude;
                $marker['title']= $value->client_alise;
                $marker['icon'] = $icon;
                // $marker['infowindow_content'] = $value->name."-".$value->client_alise;
                $marker['infowindow_content'] = "<div class=info_content><h3>".$value->name."</h3><h4><b>".$value->client_alise."</b></h4></div>";
                $marker['draggable'] = TRUE;
                $marker['animation'] = 'DROP';
                $this->googlemaps->add_marker($marker); 
            }
        }
        // echo '<pre>';print_r($response);echo '</pre>';exit();        
        $page_data['map'] = $this->googlemaps->create_map();
        $this->load->view('index',$page_data);
    }
// =====================================================================================================   
   public function get_status($terminal_id){
        $api_url = API_URL.'v1/';
        $set_api_url = $api_url.'get_query_status';
        $ssparams = array();
        $ssparams['terminal_id'] = $terminal_id;
        // $ssparams['terminal_id'] = $this->input->post('terminal_id');
        // echo '<pre>';print_r($ssparams);echo '</pre>';exit();        
        if($ssparams['terminal_id']!=''){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $set_api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ssparams));
            $response = curl_exec($ch);
            $response = decode_json($response);
        }
        if(isset($response->status) && $response->status == 200){
            return true;
        }
        return false;
        // echo '<pre>';print_r($response);echo '</pre>';exit();        
        // echo encode_json($response);
    }


    public function get_statuss(){
        $api_url = API_URL.'v1/';
        $set_api_url = $api_url.'get_query_status';
        $ssparams = array();
        // $ssparams['terminal_id'] = $terminal_id;
        $ssparams['terminal_id'] = $this->input->post('terminal_id');
        // echo '<pre>';print_r($ssparams);echo '</pre>';exit();        
        if($ssparams['terminal_id']!=''){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $set_api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ssparams));
            $response = curl_exec($ch);
            $response = decode_json($response);
        }
        // if(isset($response->status) && $response->status == 200){
        //     return true;
        // }
        // return false;
        // echo '<pre>';print_r($response);echo '</pre>';exit();        
        echo encode_json($response);
    }

}

// ========================================================================================================
    // public function indexs(){
    //     // valid_session($this->module_name,'read');
    //     $page_data = array();
    //     $page_data['module_name'] = $this->module_name;
    //     $page_data['page_name'] = 'maperlist';
    //     $page_data['page_title'] = 'Maper';
    //     $terminals = $this->CRUD->get_data(TBL_TERMINAL);

    //     $config['center'] = '21.2514,81.6296';
    //     $config['zoom'] = 'auto';
    //     $this->googlemaps->initialize($config);


    //     $marker = array();
    //     $marker['position'] = '21.234469,81.638925';
    //     $marker['title']= 'Kalibadi';
    //     $marker['infowindow_content'] = 'Kalibadi, Raipur ';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.245541,81.642361';
    //     $marker['title']= 'Shastri Chowk, Raipur';
    //     $marker['infowindow_content'] = 'Shastri Chowk, Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.245541,81.642361';
    //     $marker['title']= 'Telibandha Thana Ring Road / Deen Dayal, Raipur';
    //     $marker['infowindow_content'] = 'Telibandha Thana Ring Road / Deen Dayal, Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.239228,81.679789 ';
    //     $marker['title']= 'VIP Chowk (Opp - Balilone Tower),Raipur';
    //     $marker['infowindow_content'] = 'VIP Chowk (Opp - Balilone Tower), Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.249212,81.641784';
    //     $marker['title']= 'Mekahara Chowk, Raipur';
    //     $marker['infowindow_content'] = 'Mekahara Chowk , Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);


    //     $marker = array();
    //     $marker['position'] = '21.257257,81.631143';
    //     $marker['title']= 'Railway Station Chowk , Raipur';
    //     $marker['infowindow_content'] = 'Railway Station Chowk , Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.251984,81.628744';
    //     $marker['title']= 'Telghani Naaka Chowk , Raipur';
    //     $marker['infowindow_content'] = 'Telghani Naaka Chowk , Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);


    //     $marker = array();
    //     $marker['position'] = '21.270618,81.679621 ';
    //     $marker['title']= 'VIP Tiraha Vidhan Sabha Road, Raipur';
    //     $marker['infowindow_content'] = 'VIP Tiraha Vidhan Sabha Road, Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.237058,81.621015 ';
    //     $marker['title']= 'Lakhe Nagar, Raipur';
    //     $marker['infowindow_content'] = 'Lakhe Nagar , Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.259490,81.569139 ';
    //     $marker['title']= ' Tati Bandh Square , Raipur';
    //     $marker['infowindow_content'] = 'Tati Bandh Square , Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.243602,81.636213';
    //     $marker['title']= 'Bombay Market Tiraha (MLP) Jaistambh , Raipur';
    //     $marker['infowindow_content'] = 'Bombay Market Tiraha (MLP) Jaistambh, Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.242090,81.641484 ';
    //     $marker['title']= 'Banjari Motibagh Chowk, Raipur';
    //     $marker['infowindow_content'] = 'Banjari Motibagh Chowk , Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);


    //     $marker = array();
    //     $marker['position'] = '21.190312,81.732273';
    //     $marker['title']= 'Airport T Junction,Raipur';
    //     $marker['infowindow_content'] = 'Airport T Junction, Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.200917,81.722788';
    //     $marker['title']= 'PTS Mana , Raipur';
    //     $marker['infowindow_content'] = ' , Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $marker = array();
    //     $marker['position'] = '21.218164,81.692461';
    //     $marker['title']= 'Fundhar Chowk, Raipur';
    //     $marker['infowindow_content'] = 'Fundhar Chowk , Raipur';
    //     $marker['draggable'] = TRUE;
    //     $marker['animation'] = 'DROP';
    //     $this->googlemaps->add_marker($marker);

    //     $this->googlemaps->initialize($config);
    //     $page_data['map'] = $this->googlemaps->create_map();     
    //     $this->load->view('index',$page_data); 
     
    // }
// ===========================================================================================================================    
// }
