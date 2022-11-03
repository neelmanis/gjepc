<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Showinfo extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_showinfo');
		$this->load->library('form_validation');
		$this->load->helper('url');
	}
	
	function index()
	{		
		$data['viewFile']='showdetails';
		$template='dashboard';
			
		$data['userlist']=$this->get('regId')->result();
		
		echo Modules::run('template/'.$template,$data);
		
	}

/***************************************************** Start Show Details *****************************************************/	

	function listShowDetails($status = 'active')
	{
		$template = 'admin';
		$data['viewFile'] = "showdetails";
		$data['page'] = 'details';
		$data['menu'] = 'detailsA';
		$data['details'] = $this->mdl_showinfo->listShowDetails();
		echo Modules::run('template/'.$template, $data);
	}	
	
	function deactivateExhibitor($id)
	{
	  $this->mdl_showinfo->exhibitorDeactive($id);
	  $this->listUsers();
	}
	
	function activateExhibitor($id)
	{
	  $this->mdl_showinfo->exhibitorActive($id);
	  $this->listShowDetails();
	}
	
	function addshowdetails()
	{
		  $template = 'admin';
		  $data['viewFile'] = "addshowdetails";
		  $data['page'] = 'addshowdetails';
		  $data['menu'] = 'abc';
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		   echo Modules::run('template/'.$template, $data);
	}
	
	/********************* Common Function For Upload  ******************/
	
	   public function uploadFile($imageName,$key,$folderName)
	   {
	   		  //  echo $imageName."--".$key."--".$folderName; exit;
	   			$config['file_name'] = $imageName;
				$config['upload_path'] = './uploads/'.$folderName;
				$config['allowed_types'] = "html";
				
                $this->load->library('upload',$config);
				$this->upload->initialize($config);
				   
				 if (!$this->upload->do_upload($key))
					 {
						echo $this->upload->display_errors();
					 } 
	    }
	
	/************* get Event Name ************/
	function eventName($id)
	{
	   $getEvents = $this->mdl_showinfo->getEventName($id);
	   echo  $getEvents;
    }
	
	/************* get Event Name ************/
	function yearName($id)
	{
	   $getYear = $this->mdl_showinfo->getYearName($id);
	   echo  $getYear;
    }
		
	function addDetails()
	{ 
		$userdata = $this->input->post();

				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","showdetails");	
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
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status']
			      );
				
					$updateData = $this->mdl_showinfo->addDetail($data);
					
					redirect('showinfo/listShowDetails');		
	}
	
	function editshowdetails($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "editshowdetails";
		  $data['page'] = 'editshowdetails';
		  $data['editshowdetails']=$this->mdl_showinfo->getUser($id);
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		  $data['menu'] = 'abc';
		  echo Modules::run('template/'.$template, $data);
		}
		else
		{
			  redirect("admin/login");
		}
	}
	
	function updateDetails()
	{
		$userdata = $this->input->post();
	
		$id =$userdata['id'];
			
				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","showdetails");	
				  }
				  else 
				  {
				    $imgname = $userdata['my_file'];
				  }
				 /* else
				  {
				    $imgname = "profile_Pic.png";
				  }*/
				  
			 $data = array(
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status'],
					'modifiedDate'=> date('Y-m-d H:i:s')
			      );
				
					$updateData = $this->mdl_showinfo->userUpdate($data,$id);
					redirect('showinfo/listShowDetails');	
	  }
	  
		function viewDetails($id)
		{
		if(!empty($id))
		{
			
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'viewshowdetails';
		$data['page'] = 'viewshowdetails';
		$data['menu'] = 'abc';
		//$data['title'] = 'Signin';
	       $data['view_details'] = $this->mdl_showinfo->getUser($id);
                $data['image'] = $this->mdl_showinfo->getUser($id);
		$data['events']= $this->mdl_showinfo->getEvents();
		$data['years']= $this->mdl_showinfo->getYear();
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
		}
		
		function delete_details($id)
		{
			if(!empty($id))
			{
				$deleteData = $this->mdl_showinfo->del_Detail($id);
				redirect('showinfo/listShowDetails');	
			}
		}
		
/********************************************************** End Show Details ***************************************************/	

/********************************************************** Start Registration Details ****************************************/
	function listRegistration()
	{ 
		$template = 'admin';
		$data['viewFile'] = "showregistration";
		$data['page'] = 'details';
		$data['menu'] = 'detailsB';
		$data['details'] = $this->mdl_showinfo->listRegistration();
		echo Modules::run('template/'.$template, $data);
	}
	
	function addRegistrationDetails()
	{
		  $template = 'admin';
		  $data['viewFile'] = "addregistration";
		  $data['page'] = 'addregistration';
		  $data['menu'] = 'abc';
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		  echo Modules::run('template/'.$template, $data);
	}
	
	function addregisdetails()
	{
		$userdata = $this->input->post();

				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","registration");	
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
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status']
			      );
				
					$updateData = $this->mdl_showinfo->addRegisDetail($data);
					redirect('showinfo/listRegistration');		
	}
	
	function editregistration($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "editregistration";
		  $data['page'] = 'editregistration';
		  $data['editregistration']=$this->mdl_showinfo->getRegistration($id);
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		  $data['menu'] = 'abc';
		  echo Modules::run('template/'.$template, $data);
		}
		else
		{
			  redirect("admin/login");
		}
	}
	
	function updateRegistration()
	{
		$userdata = $this->input->post();
	
		$id =$userdata['id'];
			
				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","registration");	
				  }
				  else 
				  {
				    $imgname = $userdata['my_file'];
				  }
				 /* else
				  {
				    $imgname = "profile_Pic.png";
				  }*/
				  
			 $data = array(
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status'],
					'modifiedDate'=> date('Y-m-d H:i:s')
			      );
				
					$updateData = $this->mdl_showinfo->registrationUpdate($data,$id);
					redirect('showinfo/listRegistration');	
	  }
	
		function viewRegistrationDetails($id)
		{
		if(!empty($id))
		{
			
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'viewregistrationdetails';
		$data['page'] = 'viewregistrationdetails';
		$data['menu'] = 'abc';
		//$data['title'] = 'Signin';
	    $data['view_details'] = $this->mdl_showinfo->getRegistration($id);
        $data['image'] = $this->mdl_showinfo->getRegistration($id);
		$data['events']= $this->mdl_showinfo->getEvents();
		$data['years']= $this->mdl_showinfo->getYear();
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
		}
	
		function delete_regDetail($id)
		{
			if(!empty($id))
			{
				$deleteData = $this->mdl_showinfo->del_regDetail($id);
				redirect('showinfo/listRegistration');	
			}
		}
/********************************************************** End Registration Details ****************************************/

/********************************************************** Start FAQ Details ****************************************/
	function listFaq()
	{ 
		$template = 'admin';
		$data['viewFile'] = "showfaq";
		$data['page'] = 'details';
		$data['menu'] = 'detailsC';
		$data['details'] = $this->mdl_showinfo->listFaqs();
		echo Modules::run('template/'.$template, $data);
	}
	
	function addFaq()
	{
		  $template = 'admin';
		  $data['viewFile'] = "addfaq";
		  $data['page'] = 'addfaq';
		  $data['menu'] = 'abc';
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		  echo Modules::run('template/'.$template, $data);
	}
	
	function addfaqDetails()
	{
		$userdata = $this->input->post();

				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","faq");	
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
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status']
			      );
				
					$updateData = $this->mdl_showinfo->addFaqDetail($data);
					redirect('showinfo/listFaq');		
	}
	
	function editfaq($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "editfaq";
		  $data['page'] = 'editfaq';
		  $data['menu'] = 'abc';
		  $data['editfaq']=$this->mdl_showinfo->getFaq($id);
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();		  
		  echo Modules::run('template/'.$template, $data);
		}
		else
		{
			  redirect("admin/login");
		}
	}
	
	function updateFaq()
	{
		$userdata = $this->input->post();
	
		$id =$userdata['id'];
			
				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","faq");	
				  }
				  else 
				  {
				    $imgname = $userdata['my_file'];
				  }
				 /* else
				  {
				    $imgname = "profile_Pic.png";
				  }*/
				  
			 $data = array(
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status'],
					'modifiedDate'=> date('Y-m-d H:i:s')
			      );
				
					$updateData = $this->mdl_showinfo->faqUpdate($data,$id);
					redirect('showinfo/listFaq');	
	  }
	
		function viewFaqDetails($id)
		{
		if(!empty($id))
		{
			
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'viewfaqdetails';
		$data['page'] = 'viewfaqdetails';
		$data['menu'] = 'abc';
		//$data['title'] = 'Signin';
	    $data['view_details'] = $this->mdl_showinfo->getFaq($id);
        $data['image'] = $this->mdl_showinfo->getFaq($id);
		$data['events']= $this->mdl_showinfo->getEvents();
		$data['years'] = $this->mdl_showinfo->getYear();
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
		}
		
		function delete_faqDetails($id)
		{
			if(!empty($id))
			{
				$deleteData = $this->mdl_showinfo->del_faqDetail($id);
				redirect('showinfo/listFaq');	
			}
		}
	
/********************************************************** End FAQ Details ****************************************/		
	

/********************************************************** Start HOW TO REACH Details ****************************************/
	function listReach()
	{ 
		$template = 'admin';
		$data['viewFile'] = "showreach";
		$data['page'] = 'details';
		$data['menu'] = 'detailsD';
		$data['details'] = $this->mdl_showinfo->listReach();
		echo Modules::run('template/'.$template, $data);
	}
	
	function addReach()
	{
		  $template = 'admin';
		  $data['viewFile'] = "addreach";
		  $data['page'] = 'addreach';
		  $data['menu'] = 'abc';
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		  echo Modules::run('template/'.$template, $data);
	}
	
	function addreachDetails()
	{
		$userdata = $this->input->post();

				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","reach");	
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
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status']
			      );
				
					$updateData = $this->mdl_showinfo->addReachDetail($data);
					redirect('showinfo/listReach');		
	}
	
	function editreach($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "editreach";
		  $data['page'] = 'editreach';
		  $data['menu'] = 'abc';
		  $data['editreach']=$this->mdl_showinfo->getReach($id);
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		  echo Modules::run('template/'.$template, $data);
		}
		else
		{
			  redirect("admin/login");
		}
	}
	
	function updateReach()
	{
		$userdata = $this->input->post();
	
		$id =$userdata['id'];
			
				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","reach");	
				  }
				  else 
				  {
				    $imgname = $userdata['my_file'];
				  }
				 /* else
				  {
				    $imgname = "profile_Pic.png";
				  }*/
				  
			 $data = array(
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status'],
					'modifiedDate'=> date('Y-m-d H:i:s')
			      );
				
					$updateData = $this->mdl_showinfo->reachUpdate($data,$id);
					redirect('showinfo/listReach');	
	  }
	
		function viewReachDetails($id)
		{
		if(!empty($id))
		{
			
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'viewreachdetails';
		$data['page'] = 'viewreachdetails';
		$data['menu'] = 'abc';
		//$data['title'] = 'Signin';
	    $data['view_details'] = $this->mdl_showinfo->getReach($id);
        $data['image'] = $this->mdl_showinfo->getReach($id);
		$data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
		}
	
		function delete_reachDetails($id)
		{
			if(!empty($id))
			{
				$deleteData = $this->mdl_showinfo->del_reachDetail($id);
				redirect('showinfo/listReach');	
			}
		}
/********************************************************** End HOW TO REACH Details ****************************************/

/********************************************************** Start About GJEPC Details ****************************************/
	function listabout()
	{ 
		$template = 'admin';
		$data['viewFile'] = "showabout";
		$data['page'] = 'details';
		$data['menu'] = 'detailsE';
		$data['details'] = $this->mdl_showinfo->listAbout();
		echo Modules::run('template/'.$template, $data);
	}
	
	function addAbout()
	{
		  $template = 'admin';
		  $data['viewFile'] = "addabout";
		  $data['page'] = 'addabout';
		  $data['menu'] = 'abc';
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();	
		  echo Modules::run('template/'.$template, $data);
	}
	
	function addaboutDetails()
	{
		$userdata = $this->input->post();

				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","about");	
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
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status']
			      );
				
					$updateData = $this->mdl_showinfo->addAboutDetail($data);
					redirect('showinfo/listabout');		
	}
	
	function editabout($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "editabout";
		  $data['page'] = 'editabout';
		  $data['menu'] = 'abc';
		  $data['editabout']=$this->mdl_showinfo->getAbout($id);
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();	
		  echo Modules::run('template/'.$template, $data);
		}
		else
		{
			  redirect("admin/login");
		}
	}
	
	function updateAbout()
	{
		$userdata = $this->input->post();
	
		$id =$userdata['id'];
			
				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","about");	
				  }
				  else 
				  {
				    $imgname = $userdata['my_file'];
				  }
				  
			 $data = array(
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status'],
					'modifiedDate'=> date('Y-m-d H:i:s')
			      );
				
					$updateData = $this->mdl_showinfo->aboutUpdate($data,$id);
					redirect('showinfo/listabout');	
	  }
	
		function viewAbout($id)
		{
		if(!empty($id))
		{
			
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'viewabout';
		$data['page'] = 'viewabout';
		$data['menu'] = 'abc';
		//$data['title'] = 'Signin';
	    $data['view_details'] = $this->mdl_showinfo->getAbout($id);
        $data['image'] = $this->mdl_showinfo->getAbout($id);
		$data['events']= $this->mdl_showinfo->getEvents();
		$data['years']= $this->mdl_showinfo->getYear();	
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
		}
		
		function delete_aboutDetails($id)
		{
			if(!empty($id))
			{
				$deleteData = $this->mdl_showinfo->del_aboutDetail($id);
				redirect('showinfo/listabout');	
			}
		}
	
/********************************************************** End About GJEPC Details ****************************************/

/********************************************************** Start Contact Details ****************************************/
	function listContact()
	{ 
		$template = 'admin';
		$data['viewFile'] = "showcontact";
		$data['page'] = 'details';
		$data['menu'] = 'detailsF';
		$data['details'] = $this->mdl_showinfo->listContact();
		echo Modules::run('template/'.$template, $data);
	}
	
	function addContact()
	{
		  $template = 'admin';
		  $data['viewFile'] = "addcontact";
		  $data['page'] = 'addcontact';
		  $data['menu'] = 'abc';
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		  echo Modules::run('template/'.$template, $data);
	}
	
	function addContactDetails()
	{
		$userdata = $this->input->post();

				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","contact");	
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
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status']
			      );
				
					$updateData = $this->mdl_showinfo->addContactDetail($data);
					redirect('showinfo/listContact');		
	}
	
	function editcontact($id)
	{
		if(!empty($id))
		{
		  $template = 'admin';
		  $data['viewFile'] = "editcontact";
		  $data['page'] = 'editcontact';
		  $data['menu'] = 'abc';
		  $data['editcontact']=$this->mdl_showinfo->getContact($id);
		  $data['events']= $this->mdl_showinfo->getEvents();
		  $data['years']= $this->mdl_showinfo->getYear();
		  echo Modules::run('template/'.$template, $data);
		}
		else
		{
			  redirect("admin/login");
		}
	}
	
	function updateContact()
	{
		$userdata = $this->input->post();
	
		$id =$userdata['id'];
			
				if(!empty($_FILES['my_file']['name']))
				  { 
				    $profileimg = $_FILES['my_file']['name'];
				    $imgname=str_replace(" ","_",time().$profileimg);
				    $img = $this->uploadFile($imgname,"my_file","contact");	
				  }
				  else 
				  {
				    $imgname = $userdata['my_file'];
				  }
				  
			 $data = array(
			        'title'=>$userdata['title'],
					'year'=>$userdata['year'],
					'event_name'=>$userdata['event'],
					'html_files'=>$imgname,
					'status'=>$userdata['status'],
					'modifiedDate'=> date('Y-m-d H:i:s')
			      );
				
					$updateData = $this->mdl_showinfo->contactUpdate($data,$id);
					redirect('showinfo/listContact');	
	  }
	
		function viewContact($id)
		{
		if(!empty($id))
		{
			
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'viewcontact';
		$data['page'] = 'viewcontact';
		$data['menu'] = 'abc';
		//$data['title'] = 'Signin';
	    $data['view_details'] = $this->mdl_showinfo->getContact($id);
        $data['image'] = $this->mdl_showinfo->getContact($id);
		$data['events']= $this->mdl_showinfo->getEvents();
		$data['years']= $this->mdl_showinfo->getYear();
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			 redirect("admin/login");
		}
		}
		
		function delcontact($id)
		{
			if(!empty($id))
			{
				$deleteData = $this->mdl_showinfo->delete_contact($id);
				redirect('showinfo/listContact');	
			}
		}
	
/********************************************************** End Contact Details ****************************************/

	
	function changepassword()
	{
		$data['viewFile']='changepassword';
		$template='dashboard';
		echo Modules::run('template/'.$template,$data);
	}
	function submitchangepassword()
	{
		$password=$this->input->post("password");
		$oldpassword=$this->input->post("oldpassword");
		$regId=Modules::run('sitesecurity/getSessionId');
		echo $this->mdl_showinfo->getsubmitchangepassword($password,$oldpassword,$regId);
		
	}

	function get($order_by) {
		$query = $this->mdl_showinfo->get($order_by);
		return $query;
	}

	function get_with_limit($limit, $offset, $order_by) {
		$query = $this->mdl_showinfo->get_with_limit($limit, $offset, $order_by);
		return $query;
	}

	function get_where($addId) {
		$query = $this->mdl_showinfo->get_where($addId);
		return $query;
	}

	function get_where_custom($col, $value) {
		$query = $this->mdl_showinfo->get_where_custom($col, $value);
		return $query;
	}

	function _insert($data) {
		return $this->mdl_showinfo->_insert($data);
	}

	function _update($addId, $data) {
		return $this->mdl_showinfo->_update($addId, $data);
	}

	function _delete($addId) {
		return $this->mdl_showinfo->_delete($addId);
	}

	function count_where($column, $value) {
		$count = $this->mdl_showinfo->count_where($column, $value);
		return $count;
	}

	function get_max() {
		$max_id = $this->mdl_showinfo->get_max();
		return $max_id;
	}

	function _custom_query($mysql_query) {
		$query = $this->mdl_showinfo->_custom_query($mysql_query);
		return $query;
	}
/***************************** shital *********************************/	
	  public function forgotpass()
	  {
			$json = file_get_contents('php://input');
			$obj = json_decode($json,True);
			if(!empty($obj))
                        {
                            $email=$obj["email"];
			              
			if(!empty($obj)&& (isset($email)))
			{
    			  $strResponse = $this->mdl_showinfo->checkEmail($email);
			
					if($strResponse['Message'] == "Success")
					{ 
					$regId=base64_encode($strResponse['Result'][0]->regId);
					$exp=explode("=",$regId);
					
			 /********************** Mail *****************/
					$to  = $email;  
					// subject
				$subject = 'Life Feed-Change Password';
				//message
				$message ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Life Feed</title>
<style type="text/css">
<!--
* { padding:0px;}

body, td, th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #353535;
	line-height:18px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

a:link{color:#353535; text-decoration:none; font-weight: bold;}
a:hover{color:#00519a; text-decoration:none; font-weight: bold;}


</style>
</head>
<body>
<table width="70%"  border="0" cellspacing="0" cellpadding="0" align="CENTER" bgcolor="#f2f2f2">
    <tr>
    <td colspan="4" bgcolor="#469D85">&nbsp;</td>
    </tr> 
    
    <tr>
    <td width="5%" height="81" align="center">&nbsp;</td>
    <td colspan="2" align="center" style="border-bottom:2px #2D2C80 solid"><img src="http://digitalagencymumbai.com/lifefeed/logo.png" width="150px" style="padding:10px 0px;" /></td>
    <td width="5%" align="center" >&nbsp;</td>
</tr>
    
    <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2">Dear Sir/Madam,</td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2" style="text-align:justify;">
       To reset your  password, simply click the link below. That will take you to a web page where you can create a new password.</td>
    	  <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    
     <tr>
    <td>&nbsp;</td>
    <td colspan="2">Please click<a href='.base_url("users/changeForgotpass/$exp[0]").'> 
    Click here</a></td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    
    
    <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
    
    
    <tr>
    <td height="22">&nbsp;</td>
    <td colspan="2" style="text-align:right">Regards,</td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td height="23">&nbsp;</td>
    <td width="129" style="text-align:right">&nbsp;</td>
    <td width="436" style="text-align:right">Team Life Feed</td>
    <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
    
    <tr>
    <td colspan="4" bgcolor="#469D85">&nbsp;</td>
    </tr></table>
</body>
</html>
';
				// To send HTML mail, the Content-type header must be set
				$headers = 'From:Life Feed- Change Password <info@digitalagencymumbai.com>' . "\r\n";
				$headers .= "MIME-Version: 1.0" . "\r\n";
   				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

				// Additional headers

				// Mail it
				
					 mail($to, $subject, $message, $headers);
					 $strResponse=array(
						"Result"=>'',
						"Message"=>"Please check your mail to reset the password",
						"status"=>"true"
						);	
					/********************** Mail *****************/
			}
			}
			else
			{
				$strResponse=array(
				"Result"=>'',
				"Message"=>"Invalid post.Post must contains email.",
				"status"=>"false"
				);
				
			}
              }
          else 
               {
                $strResponse=array(
				"Result"=>'',
				"Message"=>" Invalid post.Post must contains email.",
				"status"=>"false"
				);
               }
				//header('Content-type: application/json');
			    echo json_encode(array("Response"=>$strResponse));

	 }
	 
function changeForgotpass($id='')
	{
if(!empty($id))
		{
		$uid = $id."==";
	    $data['user_id'] = base64_decode($uid);
		//echo $user_id;
	    $this->load->view('users/forgot_password',$data); 
	    }
		else
		{
		 show_404();
		}
	}	 
	
	 
	 public function updatePassword()
	 {
	   $formdata = $this->input->post();
	  
	   $this->form_validation->set_rules('new_pass','New Password','trim|required|xss_clean');
	   $this->form_validation->set_rules('confirm_pass','Confirm Password','trim|required|xss_clean|matches[new_pass]'); 
	   
	     if($this->form_validation->run() == FALSE)
		  {
	        echo validation_errors();	  
   		  }
		 else
		 {
		    $uid = $formdata['id']; 
			$new = Modules::run('sitesecurity/makeHash', $formdata['new_pass']);
			$update = $this->mdl_showinfo->change_forgot_passowrd($uid,$new);
			echo "1";
		 } 
	 }
/*************************** shital ***********************/	
}
?>