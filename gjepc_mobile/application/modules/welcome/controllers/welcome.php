<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_welcome');
	}
	
	function index()
	{
		echo "hello";	
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */