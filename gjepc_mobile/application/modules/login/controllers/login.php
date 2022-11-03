<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_login');
	}
	
	function index()
	{
		$data['viewFile']='login';
		$template='login';
		
		echo Modules::run('template/'.$template,$data);
		
	}

	function signup()
	{
			$username=$this->input->post("username");
			$password=$this->input->post("password");
			$haspassword=Modules::run('sitesecurity/makeHash',$password);
			$strResult=$this->mdl_login->getsignup($username,$haspassword);
				echo 1;
	}

	function get($order_by) {
		$query = $this->mdl_login->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$query = $this->mdl_login->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($addId) {
		$query = $this->mdl_login->get_where($addId);
		return $query;
	}

	function get_where_custom($col, $value) {
		$query = $this->mdl_login->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) {
		return $this->mdl_login->_insert($data);
	}

	function _update($addId, $data) {
		return $this->mdl_login->_update($addId, $data);
	}

	function _delete($addId) {
		return $this->mdl_login->_delete($addId);
	}

	function count_where($column, $value) {
		$count = $this->mdl_login->count_where($column, $value);
		return $count;
	}

	function get_max() {
		$max_id = $this->mdl_login->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$query = $this->mdl_login->_custom_query($mysql_query);
		return $query;
	}
}
?>