<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template extends MX_Controller {

	function oneCol($data){
		$this->load->view('oneCol', $data );
	}

	function twoColLeft($data){
		$this->load->view('twoColLeft', $data);
	}

	function admin($data){
		if(Modules::run('site_security/is_admin')){
			$this->load->view('admin', $data);
		}
		else{
			redirect('admin/login','refresh');
		}
	}

}
