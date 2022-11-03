<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enquiry extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_enquiry');
		$this->load->library('form_validation');
		$this->load->helper('url');
	}
	
	function index()
	{		
		$data['viewFile']='show';
		$template='dashboard';
        $dept     = ($this->session->userdata['adminData']['dept']);
		$data['userlist']=$this->get('regId')->result();		
		echo Modules::run('template/'.$template,$data);		
	}

/*********************************************** Start Show Updates Details ***************************************************/	

	function enquiryList()
	{
		$template = 'admin';
		$data['viewFile'] = "enquiry";
		$data['page'] = 'details';
		$data['menu'] = 'masterEnquiry';
		$dept     = ($this->session->userdata['adminData']['dept']);
		$data['details'] = $this->mdl_enquiry->getEnquiryList($dept);
		echo Modules::run('template/'.$template, $data);
	}	
	
		function viewDetails($id)
		{
		if(!empty($id))
		{			
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'viewenquiry';
		$data['page'] = 'viewenquiry';
		$data['menu'] = 'abc';
		$dept     = ($this->session->userdata['adminData']['dept']);
		$data['view_details'] = $this->mdl_enquiry->getEnquiry($id);
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
		}
		
		
	function editinfo($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "replyenquiry";
		  $data['page'] = 'replyenquiry';
		  $data['editinfo']=$this->mdl_enquiry->getEnquiry($id);
		  $data['menu'] = 'abc';
		  echo Modules::run('template/'.$template, $data);
		}
		else
		{
			  redirect("admin/login");
		}
	}
	
	function updateDetails()
	{
		$userdata = $this->input->post();	
		$id =$userdata['id'];						  
		//echo '<pre>'; print_r($userdata); exit;
				$data = array(															
					'email'=>$userdata['email'],				
					'description'=>$userdata['description'],				
					'replied'=>'1',
					'adminId'=>$userdata['adminid'],
					'modified_date'=> date('Y-m-d H:i:s')
			        );
					
		if(!empty($data))
		{
    				$updateData = $this->mdl_enquiry->submitenquiry($data,$id);						
					$getemail = $userdata['email'];					 
					$description = $userdata['description'];					 
					
					/********************** Mail *****************/
$to  =  $getemail;
$subject = 'GJEPC Feedback reply';
$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
	<td width="85%" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="105" height="91" /></td>         
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"> Thanks for Feedback at Gems and Jewellery Export Promotion Council (GJEPC).
</td>
  </tr>
   <tr>
    <td>&nbsp; </td>
    </tr>
    
  <tr>
    <td align="left"  style="text-align:justify;">'. $description .'</td>
  </tr>

   <tr>
  <td>&nbsp; </td>
    </tr>
    
  <tr>
    <td height="22" align="left"  style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong></td>
  </tr>
  
</table>';
				
				
				$headers = 'From:GJEPC Feedback <do-not-reply@gjepc.org>' . "\n";
				$headers .= "MIME-Version: 1.0" . "\n";
   				$headers .= "Content-type:text/html;charset=UTF-8" . "\n"; 
			    mail($to, $subject, $message, $headers);
				redirect('enquiry/enquiryList');
			}			  
			
	  }
	  
		/*function viewDetails($id)
		{
		if(!empty($id))
		{
			
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'viewupdatedetails';
		$data['page'] = 'viewupdatedetails';
		$data['menu'] = 'abc';
		//$data['title'] = 'Signin';
	    $data['view_details'] = $this->mdl_enquiry->getUser($id);
        $data['image'] = $this->mdl_enquiry->getUser($id);
		$data['events']= $this->mdl_enquiry->getEvents();
		$data['years']= $this->mdl_enquiry->getYear();
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
		}*/
		
		function delete_details($id)
		{
			if(!empty($id))
			{
				$deleteData = $this->mdl_enquiry->del_Detail($id);
				redirect('show/showList');	
			}
		}
		
/**************************************************** End Show Updates Details ************************************************/	


	
	function changepassword()
	{
		$data['viewFile']='changepassword';
		$template='dashboard';
		echo Modules::run('template/'.$template,$data);
	}
	function submitchangepassword()
	{
		$password=$this->input->post("password");
		$oldpassword=$this->input->post("oldpassword");
		$regId=Modules::run('sitesecurity/getSessionId');
		echo $this->mdl_showinfo->getsubmitchangepassword($password,$oldpassword,$regId);
		
	}

	function get($order_by) {
		$query = $this->mdl_showinfo->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$query = $this->mdl_showinfo->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($addId) {
		$query = $this->mdl_showinfo->get_where($addId);
		return $query;
	}

	function get_where_custom($col, $value) {
		$query = $this->mdl_showinfo->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) {
		return $this->mdl_showinfo->_insert($data);
	}

	function _update($addId, $data) {
		return $this->mdl_showinfo->_update($addId, $data);
	}

	function _delete($addId) {
		return $this->mdl_showinfo->_delete($addId);
	}

	function count_where($column, $value) {
		$count = $this->mdl_showinfo->count_where($column, $value);
		return $count;
	}

	function get_max() {
		$max_id = $this->mdl_showinfo->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$query = $this->mdl_showinfo->_custom_query($mysql_query);
		return $query;
	}
/***************************** shital *********************************/	
	  public function forgotpass()
	  {
			$json = file_get_contents('php://input');
			$obj = json_decode($json,True);
			if(!empty($obj))
                        {
                            $email=$obj["email"];
			              
			if(!empty($obj)&& (isset($email)))
			{
    			  $strResponse = $this->mdl_showinfo->checkEmail($email);
			
					if($strResponse['Message'] == "Success")
					{ 
					$regId=base64_encode($strResponse['Result'][0]->regId);
					$exp=explode("=",$regId);
					
			 /********************** Mail *****************/
					$to  = $email;  
					// subject
				$subject = 'Life Feed-Change Password';
				//message
				$message ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Life Feed</title>
<style type="text/css">
<!--
* { padding:0px;}

body, td, th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #353535;
	line-height:18px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

a:link{color:#353535; text-decoration:none; font-weight: bold;}
a:hover{color:#00519a; text-decoration:none; font-weight: bold;}


</style>
</head>
<body>
<table width="70%"  border="0" cellspacing="0" cellpadding="0" align="CENTER" bgcolor="#f2f2f2">
    <tr>
    <td colspan="4" bgcolor="#469D85">&nbsp;</td>
    </tr> 
    
    <tr>
    <td width="5%" height="81" align="center">&nbsp;</td>
    <td colspan="2" align="center" style="border-bottom:2px #2D2C80 solid"><img src="http://digitalagencymumbai.com/lifefeed/logo.png" width="150px" style="padding:10px 0px;" /></td>
    <td width="5%" align="center" >&nbsp;</td>
</tr>
    
    <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2">Dear Sir/Madam,</td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2" style="text-align:justify;">
       To reset your  password, simply click the link below. That will take you to a web page where you can create a new password.</td>
    	  <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    
     <tr>
    <td>&nbsp;</td>
    <td colspan="2">Please click<a href='.base_url("users/changeForgotpass/$exp[0]").'> 
    Click here</a></td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    
    
    <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
    
    
    <tr>
    <td height="22">&nbsp;</td>
    <td colspan="2" style="text-align:right">Regards,</td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td height="23">&nbsp;</td>
    <td width="129" style="text-align:right">&nbsp;</td>
    <td width="436" style="text-align:right">Team Life Feed</td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
    
    <tr>
    <td colspan="4" bgcolor="#469D85">&nbsp;</td>
    </tr></table>
</body>
</html>
';
				// To send HTML mail, the Content-type header must be set
				$headers = 'From:Life Feed- Change Password <info@digitalagencymumbai.com>' . "\r\n";
				$headers .= "MIME-Version: 1.0" . "\r\n";
   				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

				// Additional headers

				// Mail it
				
					 mail($to, $subject, $message, $headers);
					 $strResponse=array(
						"Result"=>'',
						"Message"=>"Please check your mail to reset the password",
						"status"=>"true"
						);	
					/********************** Mail *****************/
			}
			}
			else
			{
				$strResponse=array(
				"Result"=>'',
				"Message"=>"Invalid post.Post must contains email.",
				"status"=>"false"
				);
				
			}
              }
          else 
               {
                $strResponse=array(
				"Result"=>'',
				"Message"=>" Invalid post.Post must contains email.",
				"status"=>"false"
				);
               }
				//header('Content-type: application/json');
			    echo json_encode(array("Response"=>$strResponse));

	 }
	 
function changeForgotpass($id='')
	{
if(!empty($id))
		{
		$uid = $id."==";
	    $data['user_id'] = base64_decode($uid);
		//echo $user_id;
	    $this->load->view('users/forgot_password',$data); 
	    }
		else
		{
		 show_404();
		}
	}	 
	
	 
	 public function updatePassword()
	 {
	   $formdata = $this->input->post();
	  
	   $this->form_validation->set_rules('new_pass','New Password','trim|required|xss_clean');
	   $this->form_validation->set_rules('confirm_pass','Confirm Password','trim|required|xss_clean|matches[new_pass]'); 
	   
	     if($this->form_validation->run() == FALSE)
		  {
	        echo validation_errors();	  
   		  }
		 else
		 {
		    $uid = $formdata['id']; 
			$new = Modules::run('sitesecurity/makeHash', $formdata['new_pass']);
			$update = $this->mdl_showinfo->change_forgot_passowrd($uid,$new);
			echo "1";
		 } 
	 }
/*************************** shital ***********************/	
}
?>