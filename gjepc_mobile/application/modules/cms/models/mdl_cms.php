<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_cms extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_table() {
		$table = "cms";
		return $table;
	}

	function _insert($data) {
		$table = $this->get_table();
		return $this->db->insert($table, $data);
	}

	function _update($cmsId, $data) {
		$table = $this->get_table();
		$this->db->where('cmsId', $cmsId);
		return $this->db->update($table, $data);
	}

	function _delete($cmsId) {
		if($cmsId > 1):
			$table = $this->get_table();
			$this->db->where('cmsId', $cmsId);
			return $this->db->delete($table);
		else:
			return false;
		endif;
	}

	function get_where($filters = array()) {
		$table = $this->get_table();

		if(sizeof($filters)){
			foreach($filters as $key=>$value)
				$this->db->where($key, $value);

			$query = $this->db->get($table);
			return $query->result();
		}
		else
			return FALSE;
	}

	function _conditions($and = array(), $or = array()){
		$table = $this->get_table();
		$andconditon = FALSE; $orcondition = FALSE;

		if(sizeof($and)){
			$andconditon = TRUE;
			foreach($and as $key=>$value)
				$this->db->where($key, $value);
		}

		if(sizeof($or)){
			$orcondition = TRUE;
			foreach($or as $key=>$value)
				$this->db->or_where($key, $value);
		}

		if($orcondition || $andconditon){
			$query = $this->db->get($table);
			return $query->result();
		}

		return FALSE;
	}

	function newcms(){

		$this->form_validation->set_rules('name','Content Name','trim|required|max_length[100]|xss_clean');
		$this->form_validation->set_rules('slug','Url Key','trim|required|is_unique[cms.slug]|max_length[150]|xss_clean');
		$this->form_validation->set_rules('content','Description','required|xss_clean');
		$this->form_validation->set_rules('isActive','Status','trim|required|xss_clean');
		
		if(!$this->form_validation->run())
			return 'validationErrors';
		else{
			/*after form validation check for image validation if validated insert data else throw error*/
			$_POST['createdDate'] = date('Y-m-d h:i:s');
			$_POST['modifiedDate'] = date('Y-m-d h:i:s');

			if($this->_insert($this->input->post())):
				return 'success';
			else:
				return 'failed';
			endif;
		}
	}

	function editcms(){
		$this->form_validation->set_rules('name','Content Name','trim|required|max_length[100]|xss_clean');
		$this->form_validation->set_rules('content','Description','required|xss_clean');
		$this->form_validation->set_rules('isActive','Status','trim|required|xss_clean');

		$cmsId = intval($_POST['cmsId']);
		$slug = $this->input->post('slugnames');

		if($slug != trim($this->input->post('slug')))
			$this->form_validation->set_rules('slug','Url Key','trim|required|is_unique[cms.slug]|max_length[150]|xss_clean');
		else
			$this->form_validation->set_rules('slug','Url Key','trim|required|max_length[150]|xss_clean');
		
		
		if(!$this->form_validation->run())
			return 'validationErrors';
		else
		{
			/*after form validation check for image validation if validated insert data else throw error*/

			$_POST['modifiedDate'] = date('Y-m-d h:i:s');
			$cmsId = $this->input->post('cmsId');
			
			unset($_POST['slugnames']);
			if($this->_update($cmsId, $this->input->post())):
				return 'success';
			else:
				return 'failed';
			endif;
		}
	}
}