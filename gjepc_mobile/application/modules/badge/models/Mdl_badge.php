<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_badge extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function update($table, $param, $data){
		foreach($param as $key => $value){
	        $this->db->where($key, $value);
	    }
        return $this->db->update($table, $data);
	}

	function retrieve($table, $param){
		foreach($param as $key => $value){
			$this->db->where($key, $value);
		}

		$query=$this->db->get($table);
		
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return "NA";
		} 
	}
	function searchFunction($table, $paramSearch,$param,$check){
		foreach($paramSearch as $key => $value){
			$this->db->like($key, $value,$check);
		}
		foreach($param as $keys => $values){
			$this->db->where($keys, $values);
		}

		$query=$this->db->get($table);
		
		if($query->num_rows() > 0){
			return $query->result(); 
		}else{
			return "NA";
		} 

	}

  /* 
  **  GET COLUMN NAME VALUE
  */
  function getName($table, $id, $name){
    $result = $this->retrieve($table,array('id' => $id));
    //$this->db->last_query();
    if($result !== "NA"){
      return  $result[0]->$name;
    }else{
      return "NA";
    }
  }

    /*
	**	FIND RECORD
	*/
	function isExist($table, $param){
		foreach($param as $key => $value){
			$this->db->where($key, $value);
		}

		$query=$this->db->get($table);

		if($query->num_rows() > 0){
			return TRUE; 
		}else{
			return FALSE;
		} 
	}

	function customQuery($mysql_query){
		$query = $this->db->query($mysql_query);
		if($query->num_rows() > 0){
      return $query->result(); 
    }else{
      return "NA";
    } 
	}
    

 	
	
}