<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_category extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_table() {
		$table = "feed_category";
		return $table;
	}

	function _insert($data) {
		$table = $this->get_table();
		return $this->db->insert($table, $data);
	}

	function _update($catId, $data) {
		$table = $this->get_table();
		$this->db->where('catId', $catId);
		return $this->db->update($table, $data);
	}

	function _delete($catId) {
		if($catId > 1):
			$table = $this->get_table();
			$this->db->where('catId', $catId);
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

	function newcategory(){

		$this->form_validation->set_rules('catName','Category Name','trim|required|max_length[100]|xss_clean');
		$this->form_validation->set_rules('parentId','Parent Category','trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('isActive','Status','trim|required|is_natural|xss_clean');

		$this->form_validation->set_message('is_natural', 'PLease select from %s dropdown');

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

	function editcategory(){

		$this->form_validation->set_rules('catId','Category','trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('catName','Category Name','trim|required|max_length[100]|xss_clean');

		
		$this->form_validation->set_rules('parentId','Parent Category','trim|required|is_natural|xss_clean');
		$this->form_validation->set_rules('isActive','Status','trim|required|is_natural|xss_clean');

		$this->form_validation->set_message('numeric', '%s Invalid');

		if(!$this->form_validation->run())
			return 'validationErrors';
		else{
			/*after form validation check for image validation if validated insert data else throw error*/
			

			$_POST['modifiedDate'] = date('Y-m-d h:i:s');

			$catId = $this->input->post('catId');

			if($this->_update($catId, $this->input->post())):
				return 'success';
			else:
				return 'failed';
			endif;
		}
	}
	
	/***************************** SHEETAL CODE ****************************/
		function get_subcat_by_cat_id($parentid)
	{
		$this->db->select('*');
		$this->db->where('parentId', $parentid);
		$this->db->where('parentId >', '0');
		$this->db->where('isActive','1');
		$this->db->order_by('name ASC');
		$query=$this->db->get('category_master');
		$categories_list = $query->result();
		if(is_array($categories_list))
				{
					foreach($categories_list as $val)
					{
						if(empty($val->icon))
						{
							$val->icon = "noicon.png";
						}
					}
				}	
		return 	$categories_list;	
	}
	
	/***************************** SHEETAL CODE ****************************/
	
	function get_catproduct($data,$order)
	{
		$currentDate = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('product');	
		$this->db->where($data);
		$this->db->where('qty >',0);
		$this->db->where('rentFrom <=',$currentDate);
		$this->db->where('rentTo >=',$currentDate);
		//$this->db->where('rentTo =<',0);
		$this->db->order_by("price",$order);
		$catPro = $this->db->get();
		
		
		if($catPro->num_rows > 0)
		{
			$data['result'] = $catPro->result();
			$data['totalcount'] = $catPro->num_rows();
			return $data;
		}
		else
		{
			$data['result'] = "No Product Found";
			$data['totalcount'] = 0;
			return $data;
		}	
	}
	
	 function showprice($id)
	  {
		$currentDate = date('Y-m-d');  
	   $this->db->select_max('price','maxprice');
	   $this->db->select_min('price','minprice');
	   $this->db->where('catId',$id);
	   $this->db->where('qty >',0);
	   $this->db->where('rentFrom <=',$currentDate);
	   $this->db->where('rentTo >=',$currentDate);
       $query = $this->db->get('product')->row();  
	   return $query;
	  }
	  
	  
	  	  function getcount($id,$a,$b)
	  { 
		$currentDate = date('Y-m-d'); 
		$this->db->select('count(*) AS count');
		$this->db->from('product');
		$this->db->where('catId',$id);
		$this->db->where('status','A');
		$this->db->where('price >=', $a);
		$this->db->where('price <=', $b);
		$this->db->where('rentFrom <=',$currentDate);
		$this->db->where('rentTo >=',$currentDate);
	    $query = $this->db->get();
	    $result= $query->result();
	    if(is_array($result))
		{
		  return $result[0]->count;
		}
	  }
}