<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
include ("html2pdf.php");
class Pdf extends MX_Controller{
  function __construct() {
    parent::__construct();
  
    
  }

  public function makePDF($data){
    // echo "<pre>";print_r($data);exit;
    
    $this->load->library('html2pdf');
    $this->html2pdf->folder($data['path']);
    $this->html2pdf->filename($data['filename']);
    $this->html2pdf->paper('a4', 'portrait');
    $this->html2pdf->html($this->load->view($data['view'], $data, true));
    if($this->html2pdf->create('save')) {
      redirect(base_url("badges/".$data['filename']));
    }else{
      return FALSE;
    }
  }
 
} 