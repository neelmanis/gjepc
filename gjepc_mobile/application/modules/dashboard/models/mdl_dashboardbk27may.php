<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Mdl_dashboard extends CI_Model {

	function __construct() {
		parent::__construct();
		
	}

	function get_table() {
		$table = "product";
		return $table;
	}

	function get_where($filters = array()) {
		$table = $this->get_table();

		if(sizeof($filters)){
			$this->db->where($filters);

			$query = $this->db->get($table);
			return $query->result();
		}
		else
			return FALSE;
	}

//----------------------------get users product uploaded-----------------------------
function listing($regId)
{
	
	$table = $this->get_table();
	$this->db->select('*');
	$this->db->where('regId',$regId);
	$this->db->where('isDeleted','N');
	$this->db->from($table);
	$this->db->order_by("proId","DESC");
	$query = $this->db->get();
	return $query->result();
}


//----------get product image from id 
function get_product_image($id){
		
		$image = $this->db->get_where("productimage",array('proId'=>$id));
		if($image->num_rows > 0){
			return $image->result();
		}	
	}
	
//----------------delete product----------
function delete_product($id,$regId)
{
	$data = array(
               'isDeleted' => 'Y'                        
            );
	$table = 'product';
	$this->db->where('proId', $id);
	$res=$this->db->update($table, $data);					
	return $res; 
	
		
}
//----------------------------get users product uploaded-----------------------------
function rent_seller($regId)
{
	
	$sql="Select orderitem.*,product.* from orderitem,orders,product where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orders.regId=$regId AND orderitem.status='Y' AND orderitem.transactionStatus='Y' AND orderitem.productTo >= NOW() ";
	$query=$this->db->query($sql);
	return $query->result();
}
//---------------------------borrow approval pending-----dashboard borrower approval pending-----------------------------
function borrow_approval_pending($regId)
{
	$sql="Select orderitem.*,product.*,orders.regId as renterId from orderitem,orders,product where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orderitem.rentID=$regId AND orderitem.status='P' AND orderitem.transactionStatus='P' ";
	$query=$this->db->query($sql);
	return $query->result();
}

//-------------delete borrowers approval pending product---------------------------
function delete_product_borrow_approval_pending($id)
{
	$this->db->where('orderItemId', $id);
$this->db->delete('orderitem'); 
	
}

//-----------------------borrowers disapproved products-------------
function borrow_disapproved($regId)
{
	
	$sql="Select orderitem.*,product.*,orders.regId as renterId from orderitem,orders,product where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orderitem.rentID=$regId AND orderitem.status='N' AND orderitem.transactionStatus='N' ";
	$query=$this->db->query($sql);
	return $query->result();
}

//---------------------borrowers order history
function borrow_order_history($regId)
{
	
	$sql="Select orderitem.*,product.*,orders.regId as renterId from orderitem,orders,product where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orderitem.rentID=$regId AND orderitem.status='Y' AND orderitem.transactionStatus='Y' order by orderitem.orderItemId DESC";
	$query=$this->db->query($sql);
	return $query->result();	
}
//----------------wishlist-------------------
function wishlist($regId)
{
	
	$sql="Select wishlist.*,product.* from wishlist,product where wishlist.pro_id=product.proId AND wishlist.reg_id=$regId AND wishlist.status='Y'  order by wishlist.wish_id DESC";
	$query=$this->db->query($sql);
	return $query->result();
}
//-----------dashboard renter awaiting approval
function renter_awaiting_approval($regId)
{
	$sql="Select orderitem.*,product.*,orders.regId as renterId from orderitem,orders,product where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orders.regId=$regId AND orderitem.status='P' AND orderitem.transactionStatus='P' ";
	$query=$this->db->query($sql);
	return $query->result();
	
}
//-------dashboard renter five fast movers
function renter_five_fast_movers($regId)
{
	//$sql="Select orderitem.*,product.*,orders.regId as renterId from orderitem,orders,product where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orders.regId=$regId AND orderitem.status='Y' AND orderitem.transactionStatus='Y' group by orderitem.productId  ";
	$sql="Select orderitem.*, count(orderitem.productId) as prod_count,product.*,orders.regId as renterId from orderitem,orders,product where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orders.regId=$regId AND orderitem.status='Y' AND orderitem.transactionStatus='Y' group by orderitem.productId order by prod_count DESC limit 5";
	$query=$this->db->query($sql);
	return $query->result();
	
}
//-----dashboard renter sales report
function renter_total_sale($regId)
{
	$sql="Select orderitem.*,product.*,orders.regId as renterId, sum(orderitem.productPrice) as total_price from orderitem,orders,product where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orders.regId=$regId AND orderitem.status='Y' AND orderitem.transactionStatus='Y' group by orderitem.productId order by orderitem.orderItemId DESC ";
	$query=$this->db->query($sql);
	return $query->result();
	
}

//-----------dashboard borrower approved products
function borrower_approved_products($regId)
{
	$sql="Select orderitem.*,product.*,orders.regId as renterId, registration.lastLogin from orderitem,orders,product,registration where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orderitem.rentID=registration.regId AND orderitem.rentID=$regId AND orderitem.status='Y' AND orderitem.transactionStatus='Y' AND registration.lastLogin <= orderitem.modifiedDate order by orderitem.orderItemId DESC ";
	$query=$this->db->query($sql);
	return $query->result();
	
}

//-------------------dashboard borrower total spend
function borrower_total_spend($regId)
{
	
	$sql="Select orderitem.*,product.*,orders.regId as renterId, sum(orderitem.productPrice) as total_price from orderitem,orders,product where orders.orderId=orderitem.orderId AND orderitem.productId=product.proId AND orderitem.rentID=$regId AND orderitem.status='Y' AND orderitem.transactionStatus='Y' group by orderitem.productId order by orderitem.orderItemId DESC ";
	$query=$this->db->query($sql);
	return $query->result();
	
}

//----------------renter accepts product from borrower
function renter_accept_product($orderItemId)
{
	$data = array(
               'status' => 'Y' ,
			   'transactionStatus' => 'Y',
			   'reject_reason' => '',
			   'modifiedDate' => date('Y-m-d')
            );
	$table = 'orderitem';
	$this->db->where('orderItemId', $orderItemId);
	$res=$this->db->update($table, $data);
//---------------------------------payment gateway freeze deposit procedure here



//-----------------------payment gateway freeze deposit procedure ends
//--------added by sheetal to send mail to renter on 19th may 2016
$regId = Modules::run('site_security/_getUserIdfromSession');
$emailRenter=$this->get_email($regId);
$nameRenter=$this->get_name($regId);
//----------------------send mail to borrower
	$ids=$this->get_borrower_id_product_id_from_order_id($orderItemId); 
	foreach($ids as $id)
	{
		
		$rentId=$id->rentID;
		$productId=$id->productId;
		
	}
	
	$email=$this->get_email($rentId);
	$name=$this->get_name($rentId);
	$productName=$this->get_product_name($productId);	
	
	$info['viewFile'] = 'productProcess';		
	$info['receiverEmail'] =$email;
	$info['status']='Y';
	$info['name']=$name;
	$info['productName']=$productName;
	$info['subject'] = 'EasyRentil - Product approved by renter';
	$info['nameRenter'] =$nameRenter;
	
	$sendMail = Modules::run('email/_mailer', $info);
		
//----------------mail sending ends
//-----------------send mail to renter starts added on 19th may 2016 by sheetal
	$infoR['viewFile'] = 'productProcessRenter';		
	$infoR['receiverEmail'] =$emailRenter;
	$infoR['status']='Y';
	$infoR['name']=$nameRenter;
	$infoR['nameBorrower'] =$name;
	$infoR['productName']=$productName;
	$infoR['subject'] = 'EasyRentil - Product approval request accepted';
	
	$infoR['nameRenter'] =$nameRenter;
	
	$sendMail = Modules::run('email/_mailer', $infoR);


//-----------------send mail to renter ends added on 19th may 2016 by sheetal

//-------------------------send sms code starts
	$mobileNo=$this->get_mobile($rentId);		

//-------------------------send sms code ends

		

	return $res; 
	
	
	
}

//----------------renter rejects product from borrower
function renter_reject_product($orderItemId)
{
	$data = array(
               'status' => 'N' ,
			   'transactionStatus' => 'N',
			   'modifiedDate' => date('Y-m-d'),
			   'reject_reason' =>$_POST['reject_reason']
            );
	$table = 'orderitem';
	$this->db->where('orderItemId', $orderItemId);
	$res=$this->db->update($table, $data);
//---------------------------------payment gateway freeze deposit procedure here



//-----------------------payment gateway freeze deposit procedure ends
//--------added by sheetal to send mail to renter on 19th may 2016
$regId = Modules::run('site_security/_getUserIdfromSession');
$emailRenter=$this->get_email($regId);
$nameRenter=$this->get_name($regId);
//----------------------send mail to borrower
	$ids=$this->get_borrower_id_product_id_from_order_id($orderItemId); 
	foreach($ids as $id)
	{
		
		$rentId=$id->rentID;
		$productId=$id->productId;
		
	}
	
	$email=$this->get_email($rentId);
	$name=$this->get_name($rentId);
	$productName=$this->get_product_name($productId);	
	
	$info['viewFile'] = 'productProcess';		
	$info['receiverEmail'] =$email;
	$info['status']='N';
	$info['reject_reason']=$_POST['reject_reason'];
	$info['name']=$name;
	$info['productName']=$productName;
	$info['subject'] = 'EasyRentil - Product disapproved by renter';
	$info['nameRenter'] =$nameRenter;
	
	$sendMail = Modules::run('email/_mailer', $info);
		
//----------------mail sending ends
//-----------------send mail to renter starts added on 19th may 2016 by sheetal
	$infoR['viewFile'] = 'productProcessRenter';		
	$infoR['receiverEmail'] =$emailRenter;
	$infoR['status']='N';
	$infoR['name']=$nameRenter;
	$infoR['nameBorrower'] =$name;
	$infoR['productName']=$productName;
	$infoR['subject'] = 'EasyRentil - Product disapproval request accepted';
	
	$infoR['nameRenter'] =$nameRenter;
	
	$sendMail = Modules::run('email/_mailer', $infoR);


//-----------------send mail to renter ends added on 19th may 2016 by sheetal

//-------------------------send sms code starts
	$mobileNo=$this->get_mobile($rentId);		

//-------------------------send sms code ends

		

	return $res; 
	
	
	
}

function get_borrower_id_product_id_from_order_id($orderItemId)
{
	
	$table = 'orderitem';
	$this->db->select('rentID,productId,orderId');
	$this->db->where('orderItemId',$orderItemId);
	$this->db->from($table);
	$query = $this->db->get();
	$result= $query->result();		
	return $result;
}
function get_renter_id_from_order_id($orderId)
{
	$table = 'orders';
	$this->db->select('regId');
	$this->db->where('orderId',$orderId);
	$this->db->from($table);
	$query = $this->db->get();
	$result= $query->result();		
	return $result;	
}
function get_name($regId)
{
	$table = 'registration';
	$this->db->select('firstName,lastName');
	$this->db->where('regId',$regId);
	$this->db->from($table);
	$query = $this->db->get();
	$result= $query->result();
	foreach($result as $res)
		{
			$name=$res->firstName." ".$res->lastName;
			return ucfirst($name);
			
		}
	
}
function get_email($regId)
{
	$table = 'registration';
	$this->db->select('email');
	$this->db->where('regId',$regId);
	$this->db->from($table);
	$query = $this->db->get();
	$result= $query->result();
	foreach($result as $res)
		{
			$email=$res->email;
			return $email;
			
		}
	
}
function get_mobile($regId)
{
	$table = 'registration';
	$this->db->select('mobileNo');
	$this->db->where('regId',$regId);
	$this->db->from($table);
	$query = $this->db->get();
	$result= $query->result();
	foreach($result as $res)
		{
			$mobileNo=$res->mobileNo;
			return $mobileNo;
			
		}
	
}
function get_product_name($id)
{
	$table = 'product';
	$this->db->select('title');
	$this->db->where('proId',$id);
	$this->db->from($table);
	$query = $this->db->get();
	$result= $query->result();
	foreach($result as $res)
		{
			$title=$res->title;
			return $title;
			
		}
}
//----------------------add address by supriya-------------------------

function add_address()
{
		$this->form_validation->set_rules('firstName','first Name','trim|required|max_length[100]|xss_clean');
		$this->form_validation->set_rules('lastName','last Name','trim|required|max_length[100]|xss_clean');
		$this->form_validation->set_rules('building','building','required|xss_clean');
		$this->form_validation->set_rules('street','street','required|xss_clean');
		$this->form_validation->set_rules('countryId','country','required|xss_clean');
		$this->form_validation->set_rules('stateId','state','required|xss_clean');
		$this->form_validation->set_rules('cityId','city','required|xss_clean');
		$this->form_validation->set_rules('pincode','pincode','required|xss_clean');
		$this->form_validation->set_rules('mobileNo','mobileNo','required|xss_clean');
		
		if(!$this->form_validation->run())
			return 'validationErrors';
		else{
			$data = array(
               'firstName' => $_POST['firstName'],
			   'MiddleName' => $_POST['MiddleName'],
			   'lastName' => $_POST['lastName'],
			   'building' => $_POST['building'],
			   'street' => $_POST['street'],
			   'countryId' => $_POST['countryId'],
			   'stateId' => $_POST['stateId'],
			   'cityId' => $_POST['cityId'],
			   'pincode' => $_POST['pincode'],
			   'mobileNo' => $_POST['mobileNo'],
			   'isDeleted' => 'N',
			   'ipAddress' => $_SERVER['REMOTE_ADDR'],
			   'createdDate' => date('Y-m-d h:i:s'),
			   'modifiedDate' => date('Y-m-d h:i:s'),
			   'regId' => $_POST['regId'],
            );
			if($this->_insert($data,'address')):
		
				return 'success';
		else:
				return 'failed';
			endif;
		}
}
function _insert($data,$table) {
		
		return $this->db->insert($table, $data);
	}
	
//----------get address from id by supriya
function list_address($regId)
{
		
		$add = $this->db->get_where("address",array('regId'=>$regId,'isDeleted'=>'N'));
		
		if($add->num_rows > 0){
			return $add->result();
		}	
}
	
//----------delete address from id by supriya
function Delete_address($addId)
{
		
	$data = array(
			   'isDeleted' => 'Y',
			   'modifiedDate' => date('Y-m-d')
            );
	$table = 'address';
	$this->db->where('addId', $addId);
	$res=$this->db->update($table, $data);
	return $res;
	}	
//----------update address from id by supriya
	function update_address($addId)
	{
		$this->form_validation->set_rules('firstName','first Name','trim|required|max_length[100]|xss_clean');
		$this->form_validation->set_rules('lastName','last Name','trim|required|max_length[100]|xss_clean');
		$this->form_validation->set_rules('building','building','required|xss_clean');
		$this->form_validation->set_rules('street','street','required|xss_clean');
		//$this->form_validation->set_rules('countryId','country','required|xss_clean');
		//$this->form_validation->set_rules('stateId','state','required|xss_clean');
		//$this->form_validation->set_rules('cityId','city','required|xss_clean');
		$this->form_validation->set_rules('pincode','pincode','required|xss_clean');
		$this->form_validation->set_rules('mobileNo','mobileNo','required|xss_clean');
		
		if(!$this->form_validation->run())
			return 'validationErrors';
		else{
			$data = array(
               'firstName' => $_POST['firstName'],
			   'MiddleName' => $_POST['MiddleName'],
			   'lastName' => $_POST['lastName'],
			   'building' => $_POST['building'],
			   'street' => $_POST['street'],
			  // 'countryId' => $_POST['countryId'],
			  // 'stateId' => $_POST['stateId'],
			  // 'cityId' => $_POST['cityId'],
			   'pincode' => $_POST['pincode'],
			   'mobileNo' => $_POST['mobileNo'],
			   'isDeleted' => 'N',
			   'ipAddress' => $_SERVER['REMOTE_ADDR'],
						   'modifiedDate' => date('Y-m-d h:i:s'),
			   
            );
			$table = 'address';
			$this->db->where('addId', $addId);
			$res=$this->db->update($table, $data);	
			if($res):
		
				return 'success';
		else:
				return 'failed';
			endif;
		}
	}
	
	
	//--------update address from id by supriya
	function edit_add($addId)
	{
		
		$addr = $this->db->get_where("address",array('addId'=>$addId));
		if($addr->num_rows > 0){
			return $addr->result();
		}	
	}
	
	//------------------check if user has uploaded product images 
	function productConditionImage($orderItemId,$regId)
	{
		$addr = $this->db->get_where("productconditionimages",array('orderItemId'=>$orderItemId,'userId'=>$regId));
		if($addr->num_rows > 0){
			return $addr->result();
		}
	}
//------------------user raises dispute added by sheetal on 19th may 2016
function dispute($orderItemId,$userType)
{
	$userId = Modules::run('site_security/_getUserIdfromSession');
	$data = array(
               'status' => 'P' ,
			   'orderItemId' => $orderItemId,
			   'userId' => $userId,
			   'ipAddress' => $_SERVER['REMOTE_ADDR'],
			   'createdDate' => date('Y-m-d h:i:s'),
			   'modifiedDate' => date('Y-m-d h:i:s')
            );
	
	$res=$this->_insert($data,'dispute');
	$ticketNumber=$this->db->insert_id();

//------- send mail to user who raised dispute

/*$UserEmail=$this->get_email($userId);
$UserName=$this->get_name($userId);*/
$ids=$this->get_borrower_id_product_id_from_order_id($orderItemId); 
	foreach($ids as $id)
	{
		
		$rentId=$id->rentID;
		$productId=$id->productId;
		$orderId=$id->orderId;
		
	}
$productName=$this->get_product_name($productId);
$ids=$this->get_renter_id_from_order_id($orderId); 
	foreach($ids as $id)
	{
		$regId=$id->regId;		
	}	
	
	 $emailRenter=$this->get_email($regId);
	 $nameRenter=$this->get_name($regId);
	 $emailBorrower=$this->get_email($rentId);
	 $nameBorrower=$this->get_name($rentId);

//----------------------send mail to user who is disputed 
if($userType=='borrower')
{
	//-----------------mail to renter as borrower has raised dispute
	$info['viewFile'] = 'disputeByBorrower';		
	$info['receiverEmail'] =$emailRenter;	
	$info['name']=$nameRenter;
	$info['nameBorrower'] =$nameBorrower;
	$info['productName']=$productName;
	$info['ticketNumber']=$ticketNumber;
	$info['subject'] = 'EasyRentil - Dispute raised';	
	$sendMail = Modules::run('email/_mailer', $info);
	
	
}
else
{
	
	
	//-----------------mail to borrower as renter has raised dispute
	$infoR['viewFile'] = 'disputeByRenter';		
	$infoR['receiverEmail'] =$emailBorrower;	
	$infoR['name']=$nameBorrower;
	$infoR['nameRenter'] =$nameRenter;
	$infoR['productName']=$productName;
	$infoR['ticketNumber']=$ticketNumber;
	$infoR['subject'] = 'EasyRentil - Dispute raised';	
	$sendMail = Modules::run('email/_mailer', $infoR);
}
//----------------mail sending borrower ends

//-------------------------send sms code starts
	$mobileNo=$this->get_mobile($rentId);		

//-------------------------send sms code ends

		

	return 'success'; 
	
	
	
}

//----------------------get order id from orderItemId
function get_order_id_from_orderItemId($orderItemId)
{
	$table = 'orders';
	$this->db->select('regId');
	$this->db->where('orderId',$orderId);
	$this->db->from($table);
	$query = $this->db->get();
	$result= $query->result();		
	return $result;
	
	
}
//--------------------------check if dispute is raised by user
function isDispute($orderItemId,$regId)
{
	
	$table = 'dispute';
	$this->db->select('*');
	$this->db->where('orderItemId',$orderItemId);
	$this->db->where('userId', $regId);
	$this->db->from($table);
	$query = $this->db->get();
	$result= $query->result();		
	return $result;
	
	
	
}





}