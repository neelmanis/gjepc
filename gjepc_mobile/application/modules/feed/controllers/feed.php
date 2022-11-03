<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends MX_Controller
{
	function __construct() {
		parent::__construct();
	    $this->load->model('mdl_feed');
	}

/*************************************************************** Manage Feed *********************************************************/
	
 function viewFeeds($id)
	{
		  $data['feed'] =$this->mdl_feed->getFeeds($id);
		  $template = 'admin';
		  $data['viewFile'] = "feed_lists";
		  $data['page'] = 'feed';
		  $data['menu'] = 'lists';
		  echo Modules::run('template/'.$template, $data);
	}

	
	function listFeed($status = 'active'){
		$template = 'admin';
		$data['viewFile'] = "feed_list";
		$data['page'] = 'feed';
		$data['menu'] = 'lists';
		//$data['feed'] = $this->mdl_feed->getFeedlist();
		$isActive = ($status == 'active') ? '1' : '0';
		$data['feed'] = $this->mdl_feed->getFeedlist($isActive);
		echo Modules::run('template/'.$template, $data);
	
	}
	
	function feedInfo($id){
		if(!empty($id))
		{
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'feed_info';
		$data['page'] = 'view_feed';
		$data['menu'] = 'lists';
	    $data['feed'] = $this->mdl_feed->getFeedInfo($id);
		if(is_array($data['feed']))
		{
		$cat = $data['feed'][0]->catId;
		$data['feed_cat'] = $this->mdl_feed->getFeedCat($cat,$id);
		}
		$data['contact'] = $this->mdl_feed->getContacts($id);
        $data['image'] = $this->mdl_feed->getImages($id);
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
	}
	
function deletefeed($feedId,$regId){
      $this->mdl_feed->_delete($feedId);
	  $url=base_url(); 
      redirect($url.'feed/viewFeeds/'.$regId);
	 // echo "<script>alert('This feed deleted successfully.')</script>";
}
	

}