<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_master');
		$this->load->library('form_validation');
		$this->load->helper('url');
	}
	
	function index()
	{		
		$data['viewFile']='showevent';
		$template='dashboard';			
		$data['userlist']=$this->get('regId')->result();		
		echo Modules::run('template/'.$template,$data);		
	}

/********************************************************** Start Events Details ****************************************/
	function eventList()
	{ 
		$template = 'admin';
		$data['viewFile'] = "showevent";
		$data['page'] = 'details';
		$data['menu'] = 'masterE';
		$data['details'] = $this->mdl_master->listEvent();
		echo Modules::run('template/'.$template, $data);
	}
	
	function addEvents()
	{
		  $template = 'admin';
		  $data['viewFile'] = "addevent";
		  $data['page'] = 'addevent';
		  $data['menu'] = 'abc';
		  echo Modules::run('template/'.$template, $data);
	}
	
	function addEventDetails()
	{
		$userdata = $this->input->post();
				  
		$data = array(
				'event'=>$userdata['event'],
				'description'=>$userdata['content'],
				'isTemp'=>$userdata['temp'],
				'status'=>$userdata['status']
					 );
				
		$updateData = $this->mdl_master->addEventDetail($data);
		redirect('master/eventList');		
	}
	
	function editevent($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "editevent";
		  $data['page'] = 'editevent';
		  $data['editevent']=$this->mdl_master->getEventID($id);
		  $data['menu'] = 'abc';
		  echo Modules::run('template/'.$template, $data);
		}
		else
		{
		  redirect("admin/login");
		}
	}
	
	function updateEvent()
	{
		$userdata = $this->input->post();	
		$id =$userdata['id'];		
			 $data = array(
					'event'=>$userdata['event'],

					'isTemp'=>$userdata['temp'],
					'description'=>$userdata['content'],
					'status'=>$userdata['status'],
					'modified_date'=> date('Y-m-d H:i:s')
			      );
				
		$updateData = $this->mdl_master->eventUpdate($data,$id);
		redirect('master/eventList');	
	}
		
	function delete_eventDetails($id)
	{
			if(!empty($id))
			{
				$deleteData = $this->mdl_master->del_eventDetail($id);
				redirect('master/eventList');		
			}
	}
	
/********************************************************** End Events Details ****************************************/

/********************************************************** Start Year Details ****************************************/
	function yearList()
	{ 
		$template = 'admin';
		$data['viewFile'] = "showyear";
		$data['page'] = 'details';
		$data['menu'] = 'masterY';
		$data['details'] = $this->mdl_master->listYear();
		echo Modules::run('template/'.$template, $data);
	}
	
	function yearLists()
	{ 		
		$details = $this->mdl_master->listYear();
		return $details;
	}
	
	function addYear()
	{
		  $template = 'admin';
		  $data['viewFile'] = "addyear";
		  $data['page'] = 'addyear';
		  $data['menu'] = 'abc';
		  echo Modules::run('template/'.$template, $data);
	}
	
	function addYearDetails()
	{
		$userdata = $this->input->post();
				  
		$data = array(
				'year'=>$userdata['year'],
				'status'=>$userdata['status']
					 );
				
		$updateData = $this->mdl_master->addYearDetail($data);
		redirect('master/yearList');		
	}
	
	function edityear($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "edityear";
		  $data['page'] = 'edityear';
		  $data['edityear']=$this->mdl_master->getYearID($id);
		  $data['menu'] = 'abc';
		  echo Modules::run('template/'.$template, $data);
		}
		else
		{
		  redirect("admin/login");
		}
	}
	
	function updateYear()
	{
		$userdata = $this->input->post();	
		$id =$userdata['id'];		
			 $data = array(
					'year'=>$userdata['year'],
					'status'=>$userdata['status'],
					'modified_date'=> date('Y-m-d H:i:s')
			      );
				
		$updateData = $this->mdl_master->yearUpdate($data,$id);
		redirect('master/yearList');	
	}
		
	function delete_yearDetails($id)
	{
			if(!empty($id))
			{
				$deleteData = $this->mdl_master->del_yearDetail($id);
				redirect('master/yearList');		
			}
	}
	
/********************************************************** End Year Details ****************************************/		

}
?>