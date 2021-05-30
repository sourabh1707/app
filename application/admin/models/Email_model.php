<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'models/MY_Model.php');
class Email_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function reset_password($data) {
        $keys = array('system_name');
        $system = $this->CRUD->get_setting_row($keys);
        
        $body = '';
        $name = $data['name'];
        $url = site_url('login/action/rp/'.$data['token']);
        $body .= '<p>Dear '. $name .',</p>';

        $body .= '<p>You recently requested to reset your account password.</p>';

        $body .= '<p>Please <a href="'.$url.'">click here</a> to reset your password.</p>';

        $body .= '<p>If you have any issues to click on above link then copy below link to browser.</p>';

        $body .= '<p>'.$url.'</p>'; 

        $body .= '<p>Best regards,</p>';
        $body .= '<p>'.$system->system_name.'</p>';
        
        $data['body'] = $body;
        $data['subject'] = 'Password Reset Request';
        return $this->send_email($data);
    }
    
    public function create_password($data) {
        $keys = array('system_name');
        $system = $this->CRUD->get_setting_row($keys);
        
        $body = '';
        $name = $data['name'];
        $url = site_url('login/action/cp/'.$data['token']);
        $body .= '<p>Dear '. $name .',</p>';

        $body .= '<p>Welcome to '.$system->system_name.'</p>';

        $body .= '<p>Please <a href="'.$url.'">click here</a> to create your password.</p>';

        $body .= '<p>If you have any issues to click on above link then copy below link to browser.</p>';

        $body .= '<p>'.$url.'</p>'; 

        $body .= '<p>Best regards,</p>';
        $body .= '<p>'.$system->system_name.'</p>';
        
        $data['body'] = $body;
        $data['subject'] = 'Create new Password';
        return $this->send_email($data);
    }
    
    public function send_email($data) {
        $keys = array('system_name','smtp_from_user','smtp_from_name');
        $smtp = $this->CRUD->get_setting_row($keys);
        
        $this->email->from($smtp->smtp_from_user, $smtp->smtp_from_name);
        $this->email->to($data['to_email']);
        $this->email->subject($data['subject'].' - '.$smtp->system_name);
        $this->email->message($data['body']);
        $is_email_send = $this->email->send();
        //echo $this->email->print_debugger();exit;
        if($is_email_send){
            return true;
        }
        return false;
    }
}
