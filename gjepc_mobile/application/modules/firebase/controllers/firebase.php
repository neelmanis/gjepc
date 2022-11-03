<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$timezone = "Asia/Calcutta";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
class Firebase extends MX_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('mdl_firebase');
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
		
/********************************************** Start Firebase Msg Details **************************************/
	function msgList()
	{ 
		$template = 'admin';
		$data['viewFile'] = "msglist";
		$data['page'] = 'details';
		$data['menu'] = 'labA';
		$data['details'] = $this->mdl_firebase->msgList();
		echo Modules::run('template/'.$template, $data);
	}
	
	function addFirebaseMsg()
	{
		$template = 'admin';
		$data['viewFile'] = "addmsg";
		$data['page'] = 'addmsg';
		$data['menu'] = 'abc';
		echo Modules::run('template/'.$template, $data);
	}
	
	function addMsgDetails()
	{
		$userdata = $this->input->post();
			$data = array(
			        'title'=>$userdata['title'],
					'description'=>$userdata['content'],
					'status'=>$userdata['status']
			    );
				
			$updateData = $this->mdl_firebase->addFirebaseDetail($data);
			redirect('firebase/msglist');		
	}
	
	function editMsg($id)
	{
		if(!empty($id))
		{
		$template = 'admin';
		$data['viewFile'] = "editmsg";
		$data['page'] = 'editmsg';
		$data['editmsg']=$this->mdl_firebase->getFirebaseMsg($id);
		$data['menu'] = 'abc';
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
		redirect("admin/login");
		}
	}
	
	function updateMsg()
	{
		$userdata = $this->input->post();	
		$id =$userdata['id'];
				
			 $data = array(
			        'title'=>$userdata['title'],
					'description'=>$userdata['content'],
					'status'=>$userdata['status'],
					'modifiedDate'=> date('Y-m-d H:i:s')
			    );
				
			$updateData = $this->mdl_firebase->firebaseMsgUpdate($data,$id);
			redirect('firebase/msglist');	
	}
	
	function viewFirebaseMsg($id)
	{
		if(!empty($id))
		{			
	    $template = 'admin';
		$data = array();
		$data['viewFile'] = 'viewMsgDetails';
		$data['page'] = 'viewMsgDetails';
		$data['menu'] = 'abc';
	    $data['view_details'] = $this->mdl_firebase->getFirebaseMsg($id);
		echo Modules::run('template/'.$template, $data);
		}
		else
		{
			redirect("admin/login");
		}
	}
		
	function delete_msgDetails($id)
	{
		if(!empty($id))
		{
			$deleteData = $this->mdl_firebase->del_firebaseDetail($id);
			redirect('firebase/msglist','refresh');	
		}
	}
	
/********************************** End Firebase Details ****************************************/	

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
}
?>