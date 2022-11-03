<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_welcome extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	function getBanner()
	{
		$this->db->select("galleryimages.*");
		$this->db->from("galleryimages");
		$this->db->join("galleryname","galleryname.galleryId=galleryimages.galId");
		$this->db->where("galleryname.isDefault",'1');
		$ans = $this->db->get();
		if(is_array($ans->result()))
				return $record = $ans->result();
		else
			return $record = "no";
	}
}