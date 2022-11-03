<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Site_security extends MX_Controller{

	function __construct() {
		parent::__construct();
	}

	function is_admin(){
		if(!$this->session->userdata('adminData')){
			return FALSE;
		}
		else{
			$adminData = $this->session->userdata('adminData');
			$userId = $adminData['userId'];
			$userType = $adminData['userType'];
			$dept = $adminData['dept'];
			
			if(!is_numeric($userId) && $userType=='' && $dept==''){
				redirect(base_url());
			}
			else{
				if($userType == 'D' || $userType == 'A')
					return TRUE;
				else
					return FALSE;
			}
		}
	}

	function _makeHash($password){
	
		return sha1($password);
	}
	
	function isLoggedIn(){
		if(!$this->session->userdata('customerData')){
			return FALSE;
		}
		else{
			$userData = $this->session->userdata('customerData');
			$userId = $userData['regId'];

			if(!is_numeric($userId))
				return FALSE;
			else
				return TRUE;
		}
	}

	function _getUserIdfromSession(){
		if(!$this->session->userdata('customerData')){
			return FALSE;
		}
		else{
			$userData = $this->session->userdata('customerData');
			$userId = $userData['regId'];

			if(!is_numeric($userId))
				return FALSE;
			else
				return $userId;
		}
	}

	function _setRegIdForPublicProfile($userId=''){
		if($userId=='')
			return $data['regId'] = Modules::run('site_security/_getUserIdFromSession');
		else
			return $data['regId'] = $userId;
	}

	function _checkForPublicProfile($regId=''){
		if($this->isLoggedIn())
			$data['loginId'] = Modules::run('site_security/_getUserIdFromSession');
		else
			$data['loginId'] = '' ;

		if($regId != '' && $data['loginId'] == $regId)
			$data['edit'] = TRUE;
		else
			$data['edit'] = FALSE;

		return $data['edit'];
	}
	

	/*----------------------------REDIRECT URL CODE BY SHEETAL--------------------------------*/
	function redirectTo()
	{
		if($this->agent->is_referral())
		{	
   			 $redirect_to = $this->agent->referrer();
   			 $domainname=base_url();
			 $redirect_to = str_replace($domainname,"",$redirect_to);
   			 $redirect_url= array(
					      'name'   => 'redirect_to',
					      'value'  => "$redirect_to",
					       'expire' => time()+60*60*60*24*30,
					        'secure' => false
					  );
			$this->input->set_cookie($redirect_url); 
   			echo $this->input->cookie('redirect_to', false);
		}	
	}
	
	function redirectToLogin()
	{
   			 $domainname=base_url();
			$redirect_to = 'dashboard/profile';
   			$redirect_url= array(
					      'name'   => 'redirect_to',
					      'value'  => "$redirect_to",
					       'expire' => time()+60*60*60*24*30,
					        'secure' => false
					  );
			$this->input->set_cookie($redirect_url); 
   			echo $this->input->cookie('redirect_to', false);
	}
	
/*----------------------------REDIRECT URL CODE BY SHEETAL ENDS--------------------------------*/	
	
}