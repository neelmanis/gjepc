<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MX_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('mdl_dashboard');
	}

	function home(){ 
		$template = 'admin';
		$data = array();
		$data['viewFile'] = 'home';
		$data['page'] = 'dashboard';
		$data['menu'] = '';
		echo Modules::run('template/'.$template, $data); 
	}

	function profile(){
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'userhome';
			$data['leftPanel'] = 'sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Dashboard';
			$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			

			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;

	}
	
	function view_profile($userId)
	{
		if(Modules::run('site_security/isLoggedIn')):
		$id=explode("_",base64_decode($userId));
			
			if(!empty($id))
			{
				$userId=trim($id[0]);
			}
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'userEdit';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Profile';
			$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['scripts'] = 'register';
			$data['scripts_1'] = 'userEdit';

			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;

	}
	function edit_profile($userId)
	{
		if(Modules::run('site_security/isLoggedIn')):
		$id=explode("_",base64_decode($userId));
			
			if(!empty($id))
			{
				$userId=trim($id[0]);
			}
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'userEditEmailPhone';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Profile';
			$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['scripts'] = 'register';
			$data['scripts_1'] = 'userEdit';

			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;

	}
	function edit_photos($userId)
	{
		if(Modules::run('site_security/isLoggedIn')):
		$id=explode("_",base64_decode($userId));
			
			if(!empty($id))
			{
				$userId=trim($id[0]);
				
			}
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'userPhotoEdit';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Profile';
			$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['scripts_1'] = 'userEdit';

			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;

	}
	function edit_trust_verification($userId)
	{
		if(Modules::run('site_security/isLoggedIn')):
		$id=explode("_",base64_decode($userId));
			
			if(!empty($id))
			{
				$userId=trim($id[0]);
				
			}
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'userverificationEdit';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Profile';
			$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['scripts_1'] = 'userEdit';

			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;

	}
	
	function review_by_you($userId)
	{
		if(Modules::run('site_security/isLoggedIn')):
		$id=explode("_",base64_decode($userId));
			
			if(!empty($id))
			{
				$userId=trim($id[0]);
				
			}
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'userReviewByYou';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Profile';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$result=Modules::run('review/review_by_user',$regId);
			$resultLimit=Modules::run('review/review_by_user_limit',$regId);
			$result1=Modules::run('review/review_about_user',$regId);
			$data['review']=$resultLimit;
			//$data['review1']=$result1;
			
			$data['countBy']=sizeof($result);
			$data['countAbout']=sizeof($result1);
			
			$data['scripts_1'] = 'userEdit';

			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;

	}
	function review_about_you($userId)
	{
		if(Modules::run('site_security/isLoggedIn')):
		$id=explode("_",base64_decode($userId));
			
			if(!empty($id))
			{
				$userId=trim($id[0]);
				
			}
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'userReviewAboutYou';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Profile';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$result=Modules::run('review/review_about_user',$regId);
			$resultLimit=Modules::run('review/review_about_user_limit',$regId);
			$result1=Modules::run('review/review_by_user',$regId);
			$data['review']=$resultLimit;
			//$data['review1']=$result1;
			$data['countBy']=sizeof($result1);
			$data['countAbout']=sizeof($result);
			$data['scripts_1'] = 'userEdit';

			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;

	}
	/*------------------------Your listing--------------------------------------*/
	//-----------renter products uploaded--------------------
	function listing(){
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'your_listing';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Listing';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['prod_list']=$this->mdl_dashboard->listing($regId);
			$data['scripts_1'] = 'userEdit';
			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;

	}
	function productImages($id)
	{
		if(!empty($id))
		{
			$imagerecord = $this->mdl_product->get_product_image($id);
			if(is_array($imagerecord))
			{
				return $imagerecord;
			}
		}
	}
	function delete_product()
	{
		
		
		$regId=Modules::run('site_security/_getUserIdfromSession');
		if(isset($_POST['isAjax'])){		
			
			$delUser = $this->mdl_dashboard->delete_product($_POST['proId'],$regId);
			if($delUser=='1') echo "success";
			else echo "error";
			
		}
		else{
			show_404();
		}
	}
	//-----------renter products on rent--------------------
	function on_rent(){
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'on_rent';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Listing';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['prod_list']=$this->mdl_dashboard->rent_seller($regId);
			$data['scripts_1'] = 'productProcess';
			//echo "<pre>"; print_r($data['prod_list']);
			//echo "--->".$this->db->last_query();die();
			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;

	}
	//----------------borrower approval pending------------
	function borrow_approval_pending()
	{
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'borrow_approval_pending';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Borrow';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['prod_list']=$this->mdl_dashboard->borrow_approval_pending($regId);
			$data['scripts_1'] = 'userEdit';
			//echo $this->db->last_query();exit;
			
			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;
		
	}
	function delete_product_borrow_approval_pending()
	{
		if(isset($_POST['isAjax'])){		
			
			$delUser = $this->mdl_dashboard->delete_product_borrow_approval_pending($_POST['proId']);
			if($delUser=='1') echo "success";
			else echo "error";
			
		}
		else{
			show_404();
		}
	}
	//--------------------------borrowers disapproved products-----------------
	function borrow_disapproved()
	{
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'borrow_disapproved';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Borrow';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['prod_list']=$this->mdl_dashboard->borrow_disapproved($regId);
			$data['scripts_1'] = 'userEdit';			
			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;
	}
	//--------------------------borrower order history
	function borrow_order_history()
	{
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'borrow_order_history';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Borrow';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['prod_list']=$this->mdl_dashboard->borrow_order_history($regId);			
			$data['scripts_1'] = 'productProcess';			
			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;
	}
	//--------------------borrowers wishlist
	function wishlist()
	{
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'borrow_wishlist';
			//$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Wishlist';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['prod_list']=$this->mdl_dashboard->wishlist($regId);	
			$data['scripts_1'] = 'userEdit';			
			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;		
		
	}
	//-------------------dashboard renter awaiting approval
	function renter_awaiting_approval($isDashboard='')
	{
		
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();								
			$data['viewFile'] = 'dashboard_renter_awaiting_approval';
			$data['leftPanel'] = 'renter_dashboard_left_menu';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Dashboard Renter';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$prod_list=$data['prod_list']=$this->mdl_dashboard->renter_awaiting_approval($regId);
			//echo $this->db->last_query(); die();
			$data['scripts_1'] = 'productProcess';			
			if($isDashboard!='')
			{			
				return $prod_list;
			}	
			else echo Modules::run('template/_'.$template, $data);	
		else:
			redirect('users/login');
		endif;
	}
	//-------------------dashboard renter five fast movers
	function renter_five_fast_movers($isDashboard='')
	{
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();								
			$data['viewFile'] = 'dashboard_renter_fast_five_mover';
			$data['leftPanel'] = 'renter_dashboard_left_menu';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Dashboard Renter';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$prod_list=$data['prod_list']=$this->mdl_dashboard->renter_five_fast_movers($regId);
			$data['scripts_1'] = 'userEdit';			
			if($isDashboard!='')
			{			
				return $prod_list;
			}
						
			else echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;
	}
	//--------------dashboard renter total sales
	function renter_total_sale()
	{
		if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();								
			$data['viewFile'] = 'dashboard_renter_total_sale';
			$data['leftPanel'] = 'renter_dashboard_left_menu';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Dashboard Renter';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['prod_list']=$this->mdl_dashboard->renter_total_sale($regId);
			$data['scripts_1'] = 'userEdit';			
			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;
		
		
	}
	function dashboard_renter_total_sale()
	{
		if(Modules::run('site_security/isLoggedIn')):
			
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');			
			$data=$this->mdl_dashboard->renter_total_sale($regId);			
			return $data;
		else:
			redirect('users/login');
		endif;
	}
	
	
	function borrower_approved($isDashboard='')
	{
			if(Modules::run('site_security/isLoggedIn')):
			
				
			$template = 'membersArea';
			$data = array();								
			$data['viewFile'] = 'dashboard_borrower_approved';
			$data['leftPanel'] = 'borrower_dashboard_left_menu';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Dashboard Borrower';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$prod_list=$data['prod_list']=$this->mdl_dashboard->borrower_approved_products($regId);
			$data['scripts_1'] = 'userEdit';
			if($isDashboard!='')
			{			
				return $prod_list;
			}	
			else echo Modules::run('template/_'.$template, $data);	
			
		else:
			redirect('users/login');
		endif;
		
	}
	
	
	function borrower_approval_pending($isDashboard='')
	{
			if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();								
			$data['viewFile'] = 'dashboard_borrower_approval_pending';
			$data['leftPanel'] = 'borrower_dashboard_left_menu';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Dashboard Borrower';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$prod_list=$data['prod_list']=$this->mdl_dashboard->borrow_approval_pending($regId);
			$data['scripts_1'] = 'userEdit';			
			if($isDashboard!='')
			{			
				return $prod_list;
			}	
			else echo Modules::run('template/_'.$template, $data);	
		else:
			redirect('users/login');
		endif;
		
	}
	
	function borrower_total_spend($isDashboard='')
	{
			if(Modules::run('site_security/isLoggedIn')):
			$template = 'membersArea';
			$data = array();								
			$data['viewFile'] = 'dashboard_borrower_total_spend';
			$data['leftPanel'] = 'borrower_dashboard_left_menu';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - DASHBOARD';
			$data['page'] = 'Dashboard Borrower';
			$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$total_spend=$data['prod_list']=$this->mdl_dashboard->borrower_total_spend($regId);	
			$data['scripts_1'] = 'userEdit';			
			if($isDashboard!='')
			{			
				return $total_spend;
			}	
			else echo Modules::run('template/_'.$template, $data);	
		else:
			redirect('users/login');
		endif;
		
	}
	//---------------------add addresses--------------------------
	
	function address($userId='')
	{
		if(Modules::run('site_security/isLoggedIn')):
		$id=explode("_",base64_decode($userId));
			
			if(!empty($id))
			{
				$userId=trim($id[0]);
			}
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'userAddAddress';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - Add Address';
			$data['page'] = 'Profile';
			$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['scripts'] = 'register';
			$data['scripts_1'] = 'userEdit';

			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;
	}
	//---------------------add addresses--------------------------
	
	function list_address($userId='')
	{
		if(Modules::run('site_security/isLoggedIn')):
		$id=explode("_",base64_decode($userId));
			
			if(!empty($id))
			{
				$userId=trim($id[0]);
			}
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'address_list';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - List Address';
			$data['page'] = 'Profile';
			$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['scripts'] = 'register';
			$data['scripts_1'] = 'userEdit';
			$data['address']= $this->mdl_dashboard->list_address($data['regId']);
			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;
	}
//-------------------------renter accept product
function renter_accept_product()
{
	if(isset($_POST['isAjax'])){		
			
			$pro = $this->mdl_dashboard->renter_accept_product($_POST['orderItemId']);
			if($pro=='1') echo "success";
			else echo "error";
			
		}
		else{
			show_404();
		}
}	
//-----------------------renter reject product	
function renter_reject_product()
{

	if(isset($_POST['isAjax'])){		
			
			$pro = $this->mdl_dashboard->renter_reject_product($_POST['orderItemId']);
			if($pro=='1') echo "success";
			else echo "error";
			
		}
		else{
			show_404();
		}
}	
//---------------------add addresses dashboard by supriya-----------------
function add_address_dashboard()
{

	if(isset($_POST['isAjax'])){		
		
			$result = $this->mdl_dashboard->add_address();
				
				if( $result == 'validationErrors')
					echo validation_errors('<p>','</p>');
				elseif( $result == 'failed')
					echo '"Oops. Something went wrong. Please try again later."';
				elseif( $result == 'success')
					echo 'success';
				else
					echo $result;
			
		}
		else{
			show_404();
		}
	
}
//---------------------delete addresses dashboard by supriya-----------------
function delete_address()
	{

		if(isset($_POST['isAjax'])){		
			
			$delUser = $this->mdl_dashboard->Delete_address($_POST['addId']);
			
		
			if($delUser=='1') 
				
			echo "success";
			else echo "error";
			
		}
		else{
			show_404();
		}
	}	
	//---------------------edit addresses dashboard by supriya-----------------
	function editaddress($addId)
	{
		if(Modules::run('site_security/isLoggedIn')):
		$id=explode("_",base64_decode($addId));
			
			if(!empty($id))
			{
				$addId=trim($id[0]);
			}
			$template = 'membersArea';
			$data = array();
			$data['viewFile'] = 'usereditAddress';
			$data['leftPanel'] = 'profile_edit_sidebar';
			$data['breadcrumb'] = "Dashboard";
			$data['title'] = 'EASYRENTIL - List Address';
			$data['page'] = 'Profile';
			$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
			$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
			$data['scripts'] = 'register';
			$data['scripts_1'] = 'userEdit';
			$data['address']= $this->mdl_dashboard->edit_add($addId);
			
			echo Modules::run('template/_'.$template, $data);
		else:
			redirect('users/login');
		endif;  
		
	}	
		

//---------------------update addresses dashboard by supriya-----------------
function update_address_dashboard()
	{
	if(isset($_POST['isAjax'])){		
		
			$result = $this->mdl_dashboard->update_address($_POST['addId']);
			
				
			if( $result == 'validationErrors')
					echo validation_errors('<p>','</p>');
				elseif( $result == 'failed')
					echo '"Oops. Something went wrong. Please try again later."';
				elseif( $result == 'success')
					echo 'success';
				else
					echo $result;
		}
		else{
			show_404();
		}
	}
//----------------------get_borrower_id_product_id_from_order_id
function get_borrower_id_product_id_from_order_id($orderItemId)
{
	$res=$this->mdl_dashboard->get_borrower_id_product_id_from_order_id($orderItemId);
	return $res;
}
function get_renter_id_from_order_id($orderId)
{
	$res=$this->mdl_dashboard->get_renter_id_from_order_id($orderId);
	return $res;	
}

function get_product_name($prodId)
{
	$res=$this->mdl_dashboard->get_product_name($prodId);
	return $res;
}



function addProductPhoto($orderItemId='',$type='')
{
			if($orderItemId!='' && $type!='')
			{
				
				$template = 'membersArea';
				$data = array();
				 $data['orderItemId']=$orderItemId;
				//$data['renterId']=$renterId;
				$data['leftPanel'] = 'profile_edit_sidebar';
				$data['title'] = 'EASYRENTIL - DASHBOARD';
				if($type=='borrow')
				{
					$data['page'] = 'Borrow';
					$data['breadcrumb'] = "Borrower Order history";
					$data['viewFile'] = 'addProductPhoto';
					
				}
				else
				{
					$data['page'] = 'Listing';
					$data['breadcrumb'] = "On rent";
					$data['viewFile'] = 'addProductPhotoRenter';
					
				}
				
				$data['scripts_1'] = 'userEdit';
				$regId=$data['regId'] = Modules::run('site_security/_getUserIdfromSession');
				$data['info'] = Modules::run('users/_getWhere', array('regId'=>$data['regId']));
				//echo "<pre>"; print_r($data);exit;
				$productConditionImage=$this->mdl_dashboard->productConditionImage(base64_decode($orderItemId),$regId);
				
				//echo "<pre>"; print_r($productConditionImage);
				$before='';
				$after='';
				if($productConditionImage!='')
				{
					foreach($productConditionImage as $condition)
					{
						if($condition->isBefore==0)
							$after=1;
						if($condition->isBefore==1)
							$before=1;
					}
				}
				$data['before']=$before;
				$data['after']=$after;
			//echo "<pre>"; print_r($productConditionImage);exit;
				echo Modules::run('template/_'.$template, $data);
				
				
			}
			else show_404();
}
function productImageUpload()
{
	
	$err=''; 
	if(isset($_POST['isAjax']))
	{
		
		if($_POST['type']=='borrower-arrival' || $_POST['type']=='renter-departure')
		{
			if(empty($_FILES['upload1']['name']) && empty($_FILES['upload2']['name']) && empty($_FILES['upload3']['name']) && empty($_FILES['upload4']['name']) && empty($_FILES['upload5']['name']))
			{
				 $err=1; echo "1";
			}
		}
		else
		{
			if(empty($_FILES['upload6']['name']) && empty($_FILES['upload7']['name']) && empty($_FILES['upload8']['name']) && empty($_FILES['upload9']['name']) && empty($_FILES['upload10']['name']))
			{
				 $err=1; echo "1";
			}
			
		}
		if($err=='')
		{
			$regId= Modules::run('site_security/_getUserIdfromSession');
			$filePath="";
			
		
			if($_POST['type']=='borrower-arrival' || $_POST['type']=='renter-departure')
			{
				if(!file_exists("uploads/users/$regId/products/before"))
				mkdir("uploads/users/$regId/products/before", 0755, true);
				$filePath='users/'.$regId.'/products/before';
				
					if(!empty($_FILES['upload1']['name']))
				{
					$upload1 = upload(array('name'=>'upload1', 'upload_path'=>$filePath));				
				}	
					if(!empty($_FILES['upload2']['name']))
				{
					$upload2 = upload(array('name'=>'upload2', 'upload_path'=>$filePath));	
				}	
					if(!empty($_FILES['upload3']['name']))
				{
					$upload3 = upload(array('name'=>'upload3', 'upload_path'=>$filePath));	
				}	
					if(!empty($_FILES['upload4']['name']))
				{
					$upload4 = upload(array('name'=>'upload4', 'upload_path'=>$filePath));	
				}
				if(!empty($_FILES['upload5']['name']))
				{
					$upload5 = upload(array('name'=>'upload5', 'upload_path'=>$filePath));	
				}
				
				$data = array(
				   'orderItemId' =>base64_decode($_POST['orderItemId']),
				   'userId' => $regId,
				   'isBefore' => '1',
				   'isDeleted' => 'N',
				   'ipAddress' => $_SERVER['REMOTE_ADDR'],
				   'modifiedDate' => date('Y-m-d h:i:s'),
				   'createdDate' =>date('Y-m-d h:i:s'),
				   'image1' => $upload1['filename'],
				   'image2' => $upload2['filename'],
				   'image3' => $upload3['filename'],
				   'image4' => $upload4['filename'],
				   'image5' => $upload5['filename'],
				  
				);
				if($this->mdl_dashboard->_insert($data,'productconditionimages'))
				echo "success";
			}
			else
			{
				//--------------borrower-departure / renter-arrival
				
				if(!file_exists("uploads/users/$regId/products/after"))
				mkdir("uploads/users/$regId/products/after", 0755, true);
				$filePath='users/'.$regId.'/products/after';
				
				if(!empty($_FILES['upload6']['name']))
				{
					$upload6 = upload(array('name'=>'upload6', 'upload_path'=>$filePath));				
				}	
				if(!empty($_FILES['upload7']['name']))
				{
					$upload7 = upload(array('name'=>'upload7', 'upload_path'=>$filePath));	
				}	
				if(!empty($_FILES['upload8']['name']))
				{
					$upload8 = upload(array('name'=>'upload8', 'upload_path'=>$filePath));	
				}	
				if(!empty($_FILES['upload9']['name']))
				{
					$upload9 = upload(array('name'=>'upload9', 'upload_path'=>$filePath));	
				}
				if(!empty($_FILES['upload10']['name']))
				{
					$upload10 = upload(array('name'=>'upload10', 'upload_path'=>$filePath));	
				}
				
				$data = array(
				   'orderItemId' => base64_decode($_POST['orderItemId']),
				   'userId' => $regId,
				   'isBefore' => '0',
				   'isDeleted' => 'N',
				   'ipAddress' => $_SERVER['REMOTE_ADDR'],
				   'modifiedDate' => date('Y-m-d h:i:s'),
				   'createdDate' =>date('Y-m-d h:i:s'),
				   'image1' => $upload6['filename'],
				   'image2' => $upload7['filename'],
				   'image3' => $upload8['filename'],
				   'image4' => $upload9['filename'],
				   'image5' => $upload10['filename'],
				  
				);
				if($this->mdl_dashboard->_insert($data,'productconditionimages'))
				echo "success";	
			}
		}
		
	}
	else show_404();
}
//------------------------user raises dispute added by sheetal on 19th may 2016
function dispute()
{
	
	if(isset($_POST['isAjax'])){		
			
			$pro = $this->mdl_dashboard->dispute($_POST['orderItemId'],$_POST['userType']);
			if($pro=='1') echo "success";
			else echo "error";
			
		}
		else{
			show_404();
		}
}

//----------------------send OTP to user

function verify_mobile()
	{
		if(Modules::run('site_security/isLoggedIn')):
//-------------added by sheetal on 24th may 2016
		$regId = Modules::run('site_security/_getUserIdfromSession');
		$dataA['mobileStatus'] = Modules::run('users/getMobileVerificationStatus',$regId);
		$dataA['viewFile']="verifyMobile";
		$dataA['message']="Thank-you for submitting review.";
		$dataA['title'] = "EASYRENTIL - Review and Rating";
		$dataA['scripts_1'] = 'userEdit';
		echo Modules::Run('template/oneCol',$dataA);
		else:
		redirect('users/login');
		endif;
		
	}
//---------------check otp
function checkOtp()
{
	

if(isset($_POST['isAjax'])){		
	$regId = Modules::run('site_security/_getUserIdfromSession');
	$session_id= Modules::run('users/getSessionId', $regId);
	
	$result=verify_data($_POST['otp'],$session_id);
		$Status=$result->Status;
		$Details=$result->Details;
		
	
	if($Status=='Success')
	{ 
		Modules::run('users/updateMobileVerified',$regId);
		echo "success";
	}
	else 
{echo "OTP code did not match"; }
		

	}
	else{
	show_404();
	}
	
}
//----------------resend OTP
function resend_otp()
{
	if(isset($_POST['isAjax'])){		
		$regId = Modules::run('site_security/_getUserIdfromSession');
		Modules::run('users/initiatePhoneVerification', $regId);
echo "OTP sent";			
		}
		else{
			show_404();
		}	
}

}//main closing
