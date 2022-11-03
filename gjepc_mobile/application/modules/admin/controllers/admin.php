<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends MX_Controller
{

	function __construct() {
		parent::__construct();
		$this->load->model('mdl_admin');
	}

	function login(){	
		
		$getLoggedStatus = Modules::run('site_security/is_admin');
		if(!$getLoggedStatus){
				$this->load->view('login');
		} else {
			redirect('dashboard/home','refresh');
		}
	}

	function _authenticate($username){
		$query = $this->get_where_custom('username', $username);
		
		foreach ($query->result() as $row) {
			$userId = $row->userId;
			$userType = $row->userType;
			$userName = $row->username;
			$dept = $row->dept;
		}
		
		$sessionData = array(
							'userId'=>$userId,
							'userType'=>$userType,
							'userName'=>$userName,
							'dept'=>$dept
					);
		
		$this->session->set_userdata('adminData', $sessionData);
		
		redirect('dashboard/home');
	}

	function submit(){

		if($this->input->post()):
			$this->load->library('form_validation');

			$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[30]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			
			if ($this->form_validation->run($this) == FALSE){
				$this->login();
			}
			else{
				$username = $this->input->post('username');
				$pass = $this->password_check($this->input->post('password'));
			
				if($pass == 2){ 
				$this->_authenticate($username);
				}
				else
				{ 
				echo 'Username and password dont match';
			}	
			}
		else:
			show_404();
		endif;

	}

	function password_check($password){

		$username = $this->input->post('username');
	    $password = Modules::run('site_security/_makeHash', $password);
		$isAdmin = $this->mdl_admin->checkLogin($username, $password);
			
		if(!$isAdmin){
			return 'Username and password don\'t match';
		}
		else{
			return 2;
		}
	}

	function logout(){

		$sessionData = array(
							'userId'=>'',
							'userType'=>''
					);
		
		$this->session->unset_userdata('adminData', $sessionData);
		$this->session->sess_destroy();

     	redirect('admin/login','refresh');
	}

	function manage(){
		$template = 'admin';

		$data = array();
		$data['viewFile'] = 'manage';
		$data['page'] = 'manage_dashboard';

		echo Modules::run('template/'.$template, $data);
	}

	function get($order_by) {
		
		$query = $this->mdl_admin->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		
		$query = $this->mdl_admin->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($id) {
		
		$query = $this->mdl_admin->get_where($id);
		return $query;
	}

	function get_where_custom($col, $value) {
		
		$query = $this->mdl_admin->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) {
		
		return $this->mdl_admin->_insert($data);
	}

	function _update($id, $data) {
		
		return $this->mdl_admin->_update($id, $data);
	}

	function _delete($id) {
		
		return $this->mdl_admin->_delete($id);
	}

	function count_where($column, $value) {
		
		$count = $this->mdl_admin->count_where($column, $value);
		return $count;
	}

	function get_max() {
		
		$max_id = $this->mdl_admin->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		
		$query = $this->mdl_admin->_custom_query($mysql_query);
		return $query;
	}
}
