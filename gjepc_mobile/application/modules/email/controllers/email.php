<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Email extends MX_Controller{
  function __construct() {
    parent::__construct();
    
    $this->load->library('email');
      $mail_config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.live.com',
        'smtp_port' => 587,
        'smtp_user' =>  'donotreply@gjepcindia.com',
        'smtp_pass' => 'Gjepc@786',
        'smtp_crypto'=>'tls'
       );
    $this->email->initialize($mail_config);
  }

  public function mailer($data){
    $this->email->clear(TRUE);
    $message =  $this->load->view($data['viewFile'], $data, TRUE);
    $this->email->set_newline("\r\n");
    $this->email->set_mailtype("html");
    $this->email->from('donotreply@gjepcindia.com', 'GJEPC INDIA');
    $this->email->to($data['to']);
    if($data['cc'] !=""){
        $this->email->cc($data['cc']);
    }
    if($data['bcc'] !=""){
        $this->email->bcc($data['bcc']);
    }
    $this->email->subject($data['subject']);

    if($data['isAttachment']){
      $attatchments = $data['attatchmentsList'];
        foreach ($attatchments as $attatchment) {
         $this->email->attach($attatchment);
        }   
    }
    $ans = $this->email->message($message);
    if (!$this->email->send()) {
      show_error($this->email->print_debugger());exit; 
      return FALSE;
    }else {
      return TRUE;
    }
  }




}