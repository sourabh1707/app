<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once str_replace("libraries","third_party",dirname(__FILE__) . '/tcpdf/tcpdf.php');
class Pdf extends TCPDF{
    function __construct(){
        parent::__construct();
    }
}
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */