<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gjepcevents extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_gjepcevents');
		$this->load->library('form_validation');
	}
	
	function index()
	{		
		$data['viewFile']='showdetails';
		$template='dashboard';			
		$data['userlist']=$this->get('regId')->result();		
		echo Modules::run('template/'.$template,$data);		
	}
	
	/********************* Common Function For Upload  ******************/	
	   public function uploadFile($imageName,$key,$folderName)
	   {
	   			$config['file_name'] = $imageName;
				$config['upload_path'] = './uploads/'.$folderName;
				$config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG';
				
                $this->load->library('upload',$config);
				$this->upload->initialize($config);
				   
				 if (!$this->upload->do_upload($key))
					 {
						echo $this->upload->display_errors();
					 } 
	    }
		
/****************************** Start Laboratory Details **************************/
	function gjepcEventsList()
	{ 
		$template = 'admin';
		$data['viewFile'] = "eventslist";
		$data['page'] = 'details';
		$data['menu'] = 'show_gjepevents';
		$data['details'] = $this->mdl_gjepcevents->eventList();		
		echo Modules::run('template/'.$template, $data);
	}
	
	function addEvent()
	{
		  $template = 'admin';
		  $data['viewFile'] = "addEvent";
		  $data['page'] = 'addEvent';
		  $data['menu'] = 'abc';
		  $data['years'] =  Modules::run('master/yearLists',$data);
		  echo Modules::run('template/'.$template, $data);
	}
	
	function addEventsDetails()
	{
		$userdata = $this->input->post();
				  if(!empty($_FILES['image']['name']))
				  {
				    $profileimg = $_FILES['image']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"image","gjepcevents");	
				  }
				  else if(isset($userdata['imagename']) && !empty($userdata['imagename']))
				  {
				    $imgname = $userdata['imagename'];
				  }
				  else
				  {
				    $imgname = "profile_Pic.png";
				  }
				  
			$data = array(
			        'event'=>$userdata['title'],
			        'year'=>$userdata['year'],
			        'fromDate'=>$userdata['fromDate'],
			        'toDate'=>$userdata['toDate'],
			        'eventVenue'=>$userdata['eventVenue'],
			        'eventUrl'=>$userdata['eventUrl'],
					'image'=>$imgname,
					'eventDescription'=>$userdata['content'],
					'status'=>$userdata['status']
			      );
				
			$updateData = $this->mdl_gjepcevents->addEventDetail($data);
			redirect("gjepcevents/gjepcEventsList");			
	}
	
	function editEvents($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "editEvent";
		  $data['page'] = 'editlab';
		  $data['menu'] = 'abc';
		  $data['editlab']=$this->mdl_gjepcevents->getEvent($id);
		  $data['years'] =  Modules::run('master/yearLists',$data);	  
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
				  if(!empty($_FILES['image']['name']))
				  { 
				    $profileimg = $_FILES['image']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"image","gjepcevents");	
				  }
				  else 
				  {
				    $imgname = $userdata['image'];
				  }
				  
			 $data = array(
					'event'=>$userdata['title'],
			        'year'=>$userdata['year'],
			        'fromDate'=>$userdata['fromDate'],
			        'toDate'=>$userdata['toDate'],
			        'eventVenue'=>$userdata['eventVenue'],
			        'eventUrl'=>$userdata['eventUrl'],
					'image'=>$imgname,
					'eventDescription'=>$userdata['content'],
					'status'=>$userdata['status']
			      );
				
				$updateData = $this->mdl_gjepcevents->eventUpdate($data,$id);
				redirect('gjepcevents/gjepcEventsList');	
	    }
	
		function viewEventDetails($id)
		{
		if(!empty($id))
		{	
			$data = array();
			$template = 'admin';			
			$data['viewFile'] = 'viewEventDetails';
			$data['page'] = 'viewEventDetails';
			$data['menu'] = 'abc';
			$data['view_details'] = $this->mdl_gjepcevents->getEvent($id);
			$data['years'] =  Modules::run('master/yearLists',$data);
			echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
		}
		
		function delete_eventDetails($id)
		{
			if(!empty($id))
			{
				$deleteData = $this->mdl_gjepcevents->del_eventDetail($id);
				redirect('gjepcevents/gjepcEventsList','refresh');	
			}
		}
	
/********************************** End Events Details ****************************************/
}
?>