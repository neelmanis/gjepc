<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_login extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	
	function get_table() {

		$table = "feed_Registration";

		return $table;

	}
	function getsignup($username,$password)
	{
		$strQuery="select * from  feed_Registration where ( username='$username' OR email = '$username') and password='$password' and usertype='A' and isActive='1'";
		$strResult=$this->_custom_query($strQuery);
			if($strResult->num_rows==1)
			{
				$strResult=$strResult->result();
					$this->session->set_userdata('UserId',$strResult[0]->regId);
				$this->session->set_userdata('UserName',$strResult[0]->username);
				return 1;

			}
			else
			{
				return 0;

			}


	}



	function get($order_by) {

		$table = $this->get_table();

		$this->db->order_by($order_by);

		$query=$this->db->get($table);

		return $query;

	}



	function get_with_limit($limit, $offset, $order_by) {

		$table = $this->get_table();

		$this->db->limit($limit, $offset);

		$this->db->order_by($order_by);

		$query=$this->db->get($table);

		return $query;

	}



	function get_where($regId) {

		$table = $this->get_table();

		$this->db->where('regId', $regId);

		$query=$this->db->get($table);

		return $query;

	}



	function get_where_custom($col, $value) {

		$table = $this->get_table();

		$this->db->where($col, $value);

		$query=$this->db->get($table);

		return $query;

	}



	function _insert($data) {

		$table = $this->get_table();

		return $this->db->insert($table, $data);

	}



	function _update($regId, $data) {

		$table = $this->get_table();

		$this->db->where('regId', $regId);

		return $this->db->update($table, $data);

	}



	function _delete($regId) {

		$table = $this->get_table();

		$this->db->where('regId', $regId);

		return $this->db->delete($table);

	}



	function count_where($column, $value) {

		$table = $this->get_table();

		$this->db->where($column, $value);

		$query=$this->db->get($table);

		$num_rows = $query->num_rows();

		return $num_rows;

	}



	function count_all() {

		$table = $this->get_table();

		$query=$this->db->get($table);

		$num_rows = $query->num_rows();

		return $num_rows;

	}



	function get_max() {

		$table = $this->get_table();

		$this->db->select_max('regId');

		$query = $this->db->get($table);

		$row=$query->row();

		$regId=$row->regId;

		return $regId;

	}



	function _custom_query($mysql_query) {

		$query = $this->db->query($mysql_query);

		return $query;

	}
	
	
}