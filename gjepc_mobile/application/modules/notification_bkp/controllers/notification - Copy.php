<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_notification');
	}
	
	function index()
	{
		$data['viewFile']='devicelist';
		$template='admin';
		$data['devicelist']=Modules::run ('users/get_where_custom','usertype','M')->result();
		
		echo Modules::run('template/'.$template,$data);
		
	}

	

	function get($order_by) {
		$query = $this->mdl_users->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$query = $this->mdl_users->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($addId) {
		$query = $this->mdl_users->get_where($addId);
		return $query;
	}

	function get_where_custom($col, $value) {
		$query = $this->mdl_users->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) {
		return $this->mdl_users->_insert($data);
	}

	function _update($addId, $data) {
		return $this->mdl_users->_update($addId, $data);
	}

	function _delete($addId) {
		return $this->mdl_users->_delete($addId);
	}

	function count_where($column, $value) {
		$count = $this->mdl_users->count_where($column, $value);
		return $count;
	}

	function get_max() {
		$max_id = $this->mdl_users->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$query = $this->mdl_users->_custom_query($mysql_query);
		return $query;
	}
}
?>