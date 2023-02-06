<?php
include('header_include.php');
require('razorpay/webinar_config.php');
require('razorpay/razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

// Configure upload directory and allowed file types
$upload_dir = 'images/company_logo/';
$allowed_types = array('jpg', 'png', 'jpeg');
// Define maxsize for files i.e 2MB
$maxsize = 2 * 1024 * 1024;

if($_POST && $_POST["action"]=="check-data"){
	
$memberType = filter($_POST['check_member']);
$bp_number = filter($_POST['bp_number']);
$mobile_number = filter($_POST['mobile_no']);
$name = filter($_POST['name']);
$email_id = filter($_POST['email_id']);
$company_name = filter($_POST['company_name']);
$pan_no = filter($_POST['pan_no']);
$gst_no = filter($_POST['gst_no']);
$address1 = filter($_POST['address1']);
$address2 = filter($_POST['address2']);
$address3 = filter($_POST['address3']);
$pincode = filter($_POST['pincode']);
$state = filter($_POST['state']);
$webinar_id = $_POST['webinar_id'];
$date_time = date("Y-m-d H:i:s");

if($memberType!= ""){
	if($memberType=="member"){
		if($pan_no !="" && !empty($pan_no)){
			$sql_chk_bp = "SELECT * FROM registration_master WHERE company_pan_no='$pan_no' ";
			$result_chk_bp = $conn->query($sql_chk_bp);
			$count_chk_bp =$result_chk_bp->num_rows;
				if($count_chk_bp==0){
				echo json_encode(array("status"=>"error-single","label"=>"pan_no","message"=>"Pan Number is not exist"));exit;
				}else{
					$row_chk_bp= $result_chk_bp->fetch_assoc();
						$registration_id = $row_chk_bp['id'];
					/*
					** CHECK MEMBER
					*/
					 $sql_chk_member = "SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND issue_membership_certificate_expire_status='Y'";
					$result_chk_member = $conn->query($sql_chk_member);
					$count_chk_member = $result_chk_member->num_rows;
					if($count_chk_member>0){
					// continue
						$u_name =  $row_chk_bp['name'];
						$u_email_id =  $row_chk_bp['email_id'];
						$u_mobile_number =$row_chk_bp['mobile_no'];
						$u_company_name = getCompanyName($registration_id,$conn);
						$company_bp_no = $row_chk_bp['company_bp_no'];
						$company_pan_no = $row_chk_bp['pan_no'];
					}else{
						echo json_encode(array("status"=>"error-single","label"=>"pan_no","message"=>"Sorry You are not a Member"));exit;
					}
				}
		}else{
			echo json_encode(array("status"=>"error-single","label"=>"pan_no","message"=>"Pan Number is Required"));exit;
		}
	}else{
		
		if($mobile_number !="" && !empty($mobile_number)){
			$chk_webinar_reg = "SELECT * FROM webinar_registration_details WHERE mobile_no='$mobile_number'";
			$result_chk_webinar_reg = $conn->query($chk_webinar_reg);
			$count_chk_webinar_reg = $result_chk_webinar_reg->num_rows;
			// if($count_chk_webinar_reg>0){
			// 	$row_chk_webinar_reg = $result_chk_webinar_reg->fetch_assoc();
			// 	$u_name = $row_chk_webinar_reg['name'];
			// 	$u_email_id = $row_chk_webinar_reg['email_id'];
			// 	$u_mobile_number = $row_chk_webinar_reg['mobile_no'];
			// 	$u_company_name = $row_chk_webinar_reg['company_name'];
			// 	$non_member_id = $row_chk_webinar_reg['id'];
			

			// }else{
				if(empty($name))
				{
					$name_error[] = array("status"=>"empty","msg"=>" Name is Required","label"=>"name");
				}else{
					$name_error[] =array();
				}
				//print_r($username_error);exit;
				if(empty($mobile_number))
				{
				    $mobile_number_error[] = array("status"=>"empty","msg"=>"Mobile No. is Required","label"=>"mobile_number");
				}else{
					/*
					** CHECKING VALID 10 DIGIT MOBILE NUMBER
					*/
					if(!preg_match('/^\d{10}$/',$mobile_number))
					{
						$mobile_number_error[] = array("status"=>"empty","msg"=>"Enter Valid Mobile No.","label"=>"mobile_number");
					}
					else
					{
						$mobile_number_error[] =array();
					}

				}
				if(empty($email_id))
				{
					$email_id_error[] = array("status"=>"empty","msg"=>"Email - Id is Required","label"=>"email_id");
				}else{
					/*
					** CHECKING VALID EMAIL-ID
					*/
					if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
						$email_id_error[] = array("status"=>"empty","msg"=>"Email -Id is Not Valid","label"=>"email_id");
					}else{
						$email_id_error[] =array();
					}
				}

				if(empty($company_name))
				{
					$company_name_error[] = array("status"=>"empty","msg"=>"Company name is Required","label"=>"company_name");
				}else{
					$company_name_error[] =array();
				}
			

				if(empty($pan_no))
				{
					$pan_no_error[] = array("status"=>"empty","msg"=>"Pan number is required","label"=>"pan_no");
				}else{

					if (strlen($pan_no) !== 10) {
						$pan_no_error[] = array("status"=>"empty","msg"=>"Pan number is Not Valid","label"=>"pan_no");
					}else{
						$pan_no_error[] =array();
					}
					
				}
				if(empty($gst_no))
				{
					//$gst_no_error[] = array("status"=>"empty","msg"=>"GST number is required","label"=>"gst_no");
					$gst_no_error[] = array();
				}else{

					if (strlen($gst_no) !== 12) {
						$gst_no_error[] = array("status"=>"empty","msg"=>"GST number is Not Valid","label"=>"gst_no");
					}else{
						$gst_no_error[] =array();
					}
					
				}

				if(empty($address1))
				{
					$address1_error[] = array("status"=>"empty","msg"=>"Address is Required","label"=>"address1");
				}else{
					$address1_error[] =array();
				}

				if(empty($address2))
				{
					$address2_error[] = array("status"=>"empty","msg"=>"Address is Required","label"=>"address2");
				}else{
					$address2_error[] =array();
				}

				if(empty($address3))
				{
					$address3_error[] = array("status"=>"empty","msg"=>"Address is Required","label"=>"address3");
				}else{
					$address3_error[] =array();
				}

				if(empty($pincode))
				{
					$pincode_error[] = array("status"=>"empty","msg"=>"Pincode number is required","label"=>"pincode");
				}else{

					if (strlen($pincode) !== 6) {
						$pincode_error[] = array("status"=>"empty","msg"=>"Pincode number is Not Valid","label"=>"pincode");
					}else{
						$pincode_error[] =array();
					}
					
				}
				if(empty($state))
				{
					$state_error[] = array("status"=>"empty","msg"=>"State is Required","label"=>"state");
				}else{
					$state_error[] =array();
				}

				$form_error = array_merge(array_filter($name_error),array_filter($mobile_number_error),array_filter($email_id_error),array_filter($company_name_error),array_filter($pan_no_error),array_filter($gst_no_error),array_filter($address1_error),array_filter($address2_error),array_filter($address3_error),array_filter($pincode_error),array_filter($state_error));
				if(!empty(array_filter($form_error)))
				{
					echo json_encode($form_error);exit;
				}else{

					if($count_chk_webinar_reg>0){

						$row_chk_webinar_reg = $result_chk_webinar_reg->fetch_assoc();
						$non_member_id = $row_chk_webinar_reg['id'];
						$sql_new_user_update = "UPDATE webinar_registration_details SET name='$name',type='$memberType',email_id='$email_id',mobile_no='$mobile_number',company_name='$company_name',pan_no='$pan_no',gst_no='$gst_no',address1='$address1',address2='$address2',address3='$address3',pincode='$pincode',state='$state',updated_date ='$date_time' WHERE  id='$non_member_id'";
						$result = $conn->query($sql_new_user_update);

					}else{
						$sql_new_user_insert = "INSERT INTO webinar_registration_details SET name='$name',type='$memberType',email_id='$email_id',mobile_no='$mobile_number',company_name='$company_name',pan_no='$pan_no',gst_no='$gst_no',address1='$address1',address2='$address2',address3='$address3',pincode='$pincode',state='$state',created_date ='$date_time'";
						$result = $conn->query($sql_new_user_insert);
						$non_member_id = $conn->insert_id;
					}	
				
				}		
			// }
		}else{
			echo json_encode(array("status"=>"error-single","label"=>"mobile_no","message"=>"Mobile Number is Required"));exit;
		}
	}

	if($memberType =="member"){
		$member_ref_id = $registration_id;
	}else{
		$member_ref_id = $non_member_id;
	}

$webinar_id = base64_decode($webinar_id);
$sql_webinar = "SELECT * FROM webinar_master WHERE id = '$webinar_id' ";
$result_webinar = $conn->query($sql_webinar);
$count_webinar = $result_webinar->num_rows;
if($count_webinar==1){
	$chks = "SELECT * FROM webinar_payment_history ORDER BY id DESC LIMIT 1";
	$chkResult = $conn->query($chks);
	$row = $chkResult->fetch_assoc();
	$num=$chkResult->num_rows;

$row_webinar = $result_webinar->fetch_assoc();
	$webinar_name = $row_webinar['title'];
	$webinar_category = $row_webinar['type'];

	/*
	** GENERATE ORDER ID
	*/
	$strNo = rand(1,10000000);
	if($webinar_category  == "webinar"){
		if($num<=0)
		{ $order_id = 'WEBINARID1'; }
		else
		{
		  $order_id='WEBINAR'.$strNo;
		}
	}else if($webinar_category  == "workshop"){
        if($num<=0)
		{ $order_id = 'WORKSHOP1'; }
		else
		{
		  $order_id='WORKSHOP'.$strNo;
		}
	}else if($webinar_category  == "event"){
       if($num<=0)
		{ $order_id = 'EVENT1'; }
		else
		{
		  $order_id='EVENT'.$strNo;
		}
	}
	
	

	$_SESSION['order_id'] = $order_id; 


	
	
	if($memberType=="member"){
		$total_payable =  trim($row_webinar['m_fees']);
	}else{
		$total_payable =  trim($row_webinar['nm_fees']);
	}
	// if($mobile_number =="9834797281"){
	// 	$total_payable =  1;
	// }


	if($total_payable == 0){
		if($memberType=="member"){
	    	$sql_payment = "INSERT INTO webinar_payment_history SET `member_type`='$memberType',`order_id`='$order_id',`registration_id`='$registration_id',`webinar_id`='$webinar_id',occasion_name='webinar',vid_language='0',`created_at`='$date_time',`razorpay_order_id`='',`Transaction_Amount`='$total_payable'";
	 	}else{
		    $sql_payment = "INSERT INTO webinar_payment_history SET `member_type`='$memberType',`order_id`='$order_id',`non_member_id`='$non_member_id',`webinar_id`='$webinar_id',occasion_name='webinar',vid_language='0',`created_at`='$date_time',`razorpay_order_id`='',`Transaction_Amount`='$total_payable'";
		}
		$result_payment = $conn->query($sql_payment);
		$date = date("jS F Y ");
	$message ='<table width="80%" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
    <tbody>    
    <tr>
      <td align="left"><img src="http://www.gjepc.org/images/gjepc_logo.png"></td>
    </tr>        
    <tr>
      <td colspan="3" height="30"><hr></td>
    </tr>        
    <tr>        
        <td colspan="3" id="content">            
            <table width="100%">
                <tr>                   
                    <td align="right"> <strong> '.$date.'</strong> </td>
                </tr>
            </table>

           <p style="line-height:22px;">Dear '.$company_name.',</p>

            <p style="line-height:22px;">Your registration for '.$webinar_name.' is Successfull</p>
            <p style="line-height:22px;"><strong>Order Id : </strong>'.$order_id.'</p>
            
            <p style="line-height:22px;">Should you have any queries, contact on 
             <a href="mailto:ajay.kumar@gjepcindia.com">ajay.kumar@gjepcindia.com</a>/ </p>
            
            <p style="line-height:22px;">Thanking you.</p>

            <p style="line-height:22px;">Yours faithfully,</p>

            <p style="line-height:22px;"><strong>Team GJEPC.</strong></p>
                  
        </td>                  
    </tr>
    
    <td colspan="3">

    </td>
              
            
           
    </tbody>
    
</table>';
	
		$to = $email_id;
		//$to = "santosh@kwebmaker.com";
		$cc = "";
		$subject = $event_name; 
		send_mail($to,$subject,$message,$cc);
	

		$url = "https://gjepc.org/webinar_payment_success.php?webinar=".$webinar_id."&isFree=yes&payment_id=".$order_id;
		echo json_encode(array("status"=>"success","isFree"=>"yes","url"=>$url)); exit;

	}

    

    $api = new Api($keyId, $keySecret);
	$orderData = [
		'receipt' => $order_id,
		'amount' => $total_payable * 100,
		'currency' => "INR",
		'payment_capture' => 1
	];

	$razorpayOrder = $api->order->create($orderData);
	$razorpayOrderId = $razorpayOrder['id'];
	if( $razorpayOrderId ){

					
		$data = [
			"key" => $keyId,
			"amount" => $total_payable,
			"name" => $webinar_name,
			"description" => 'Event payment',
			"order_id" => $razorpayOrderId,
			"notes" => [
				"amount" => $total_payable,
				"registration_id" => $member_ref_id,
				"company_name" => $company_name,
				"name" => $name,
				"email" => $email_id,
				"mobile" => $mobile_no,
				"member_type" => $memberType,
				'event_id' => $webinar_id,
				"event_name" => $webinar_name,
				"merchant_order_id"=> $order_id,
			],
			"success" => true,
			"action"=>"payment_capture"
		];

	if($memberType=="member"){
	    $sql_payment = "INSERT INTO webinar_payment_history SET `member_type`='$memberType',`order_id`='$order_id',`registration_id`='$registration_id',`webinar_id`='$webinar_id',occasion_name='webinar',vid_language='0',`created_at`='$date_time',`razorpay_order_id`='$razorpayOrderId',`Transaction_Amount`='$total_payable'";
 	}else{
	    $sql_payment = "INSERT INTO webinar_payment_history SET `member_type`='$memberType',`order_id`='$order_id',`non_member_id`='$non_member_id',`webinar_id`='$webinar_id',occasion_name='webinar',vid_language='0',`created_at`='$date_time',`razorpay_order_id`='$razorpayOrderId',`Transaction_Amount`='$total_payable'";
	}
	$result_payment = $conn->query($sql_payment);

	// PAYMENT LOG
	if($memberType=='member'){
	 	$payment_log = "INSERT INTO webinar_payment_log SET member_type='$memberType',registration_id='$registration_id',amount='$total_payable',order_id='$order_id',razorpay_order_id='$razorpayOrderId',`status`='created'";
	}else{
		$payment_log = "INSERT INTO webinar_payment_log SET member_type='$memberType',registration_id='$non_member_id',amount='$total_payable',order_id='$order_id',razorpay_order_id='$razorpayOrderId',`status`='created'";
	}
	$conn->query($payment_log);
	echo json_encode(array("status"=>"success","isFree"=>"no", "response"=>$data)); exit;

	}else{
		echo json_encode(array("status"=>"alert", "title"=>"Oops! Error occured", "icon"=>"error", "message"=>$razorpayOrder['error'])); exit;
	}
	
	
}else{
    echo json_encode(array("status"=>"error-single","label"=>"common_error","message"=>"Webinar Details Not found please contact with admin"));exit;
}
	
}else{
echo json_encode(array("status"=>"error-single","label"=>"check_member","message"=>"Select Member Type"));exit;
}
	
}


if($_POST && isset($_POST['razorpay_payment_id']) && $_POST['razorpay_payment_id'] !==""){
	$api = new Api($keyId, $keySecret);
	$payment = $api->payment->fetch($_POST['razorpay_payment_id']);
	$razorpay_payment_id =  $_POST['razorpay_payment_id'];
    $razorpay_signature = $_POST['razorpay_signature'];
    $razorpay_order_id = $_POST['razorpay_order_id'];
    $order_id = $_SESSION['order_id'];
    $error_description =  $payment->error_description;
	$card_id =  $payment->card_id;
	$bank =  $payment->bank;
	$payment_status =  $payment->status;
	$method =  $payment->method;
	$currency =  $payment->currency;
	$payment_date = date('Y-m-d',$payment->created_at);
	$notes_response = $payment->notes;
	$merchant_order_id = $notes_response->merchant_order_id;
	$post_date=date('Y-m-d');

	$update_payment = "UPDATE webinar_payment_history SET error_description='$error_description',card_id='$card_id',bank='$bank',payment_status='$payment_status',method='method',currency='$currency',payment_date='$payment_date',razorpay_signature='$razorpay_signature',razorpay_payment_id='$razorpay_payment_id' WHERE  order_id='$order_id' AND razorpay_order_id='$razorpay_order_id'";
	$result = $conn->query($update_payment);

    /*=== UPDATE PAYMENT LOG  STATRT ===*/

	$update_payment_log = $conn->query("UPDATE webinar_payment_log SET razorpay_signature='$razorpay_signature',razorpay_payment_id='$razorpay_payment_id' , `status`='$payment_status' WHERE  razorpay_order_id='$razorpay_order_id' AND order_id='$order_id'");

    /*=== UPDATE PAYMENT LOG  END ===*/

	if($result){

     
    $memberType = $notes_response->member_type;
    $event_name = $notes_response->event_name;
    $event_name = $notes_response->event_name;
    $email_id =  $notes_response->email_id;
    if($memberType =="member"){
      $registration_id = $notes_response->registration_id;
      $company_name = getCompanyName($registration_id,$conn);
    }else{
		$company_name = "";
    }

	$date = date("jS F Y ");
	$message ='<table width="80%" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
    <tbody>    
    <tr>
      <td align="left"><img src="http://www.gjepc.org/images/gjepc_logo.png"></td>
    </tr>        
    <tr>
      <td colspan="3" height="30"><hr></td>
    </tr>        
    <tr>        
        <td colspan="3" id="content">            
            <table width="100%">
                <tr>                   
                    <td align="right"> <strong> '.$date.'</strong> </td>
                </tr>
            </table>

           <p style="line-height:22px;">Dear '.$company_name.',</p>

            <p style="line-height:22px;">Your registration for '.$event_name.' is Successfull</p>
            <p style="line-height:22px;"><strong>Order Id : </strong>'.$order_id.'</p>
            <p style="line-height:22px;margin-bottom:20px;"><strong>Ref No  :</strong>'.$razorpay_order_id.'</p>
            
            <p style="line-height:22px;">Should you have any queries, contact on 
             <a href="mailto:ajay.kumar@gjepcindia.com">ajay.kumar@gjepcindia.com</a>/ </p>
            
            <p style="line-height:22px;">Thanking you.</p>

            <p style="line-height:22px;">Yours faithfully,</p>

            <p style="line-height:22px;"><strong>Team GJEPC.</strong></p>
                  
        </td>                  
    </tr>
    
    <td colspan="3">

    </td>
              
            
           
    </tbody>
    
</table>';
	if($payment_status =="captured" || $payment_status =="authorized"){
		//$to = $email_id;
		$to = "santosh@kwebmaker.com";
		$cc = "";
		$subject = $event_name; 
		send_mail($to,$subject,$message,$cc);
	}
	   $url = "https://gjepc.org/webinar_payment_success.php?isFree=no&payment_id=".$razorpay_payment_id;
	   echo json_encode(array("status"=>"success","url"=>$url));exit;
	  
	}else{
		$url  = "";
		 echo json_encode(array("status"=>"error","message"=>" Something went wrong"));exit;
	}

}

if($_POST && $_POST["action"]=="promo-video-registration"){


$file_tmpname = $_FILES['company_logo']['tmp_name'];
$file_name = $_FILES['company_logo']['name'];
$file_name = str_replace(" ","_",$file_name);
$file_name = time().'_'.$file_name;
$company_logo = $file_name;
$file_size = $_FILES['company_logo']['size'];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
// Set upload file path
$filepath = $upload_dir.$file_name;	


$pan_number = filter($_POST['pan_number']);
$company_name = filter($_POST['company_name']);
$gst_number = filter($_POST['gst_number']);
$address = filter($_POST['address']);
// $address = str_replace(',', ' ', $address);
// $address = preg_replace('/[ ,]+/', ' ', trim($address));


$city = filter($_POST['city']);
$state = filter($_POST['region']);
$person_name = filter($_POST['person_name']);
$person_email_id = filter($_POST['person_email_id']);
$person_mobile_number = filter($_POST['person_mobile_number']);

$agree_terms = $_POST['agree_terms'];
$vid_language = $_POST['vid_language'];

$date_time = date("Y-m-d H:i:s");

	
		
    if(empty($pan_number))
	{
		$pan_number_error[] = array("status"=>"empty","msg"=>"Pan Number is Required","label"=>"pan_number");
	}else{
		
		  if(preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", strtoupper($pan_number))){

	        $sql_pan_search = "SELECT * FROM registration_master WHERE company_pan_no='$pan_number' and status='1' limit 1";
			$result_pan_search = $conn->query($sql_pan_search);
			$count_pan_search =$result_pan_search->num_rows;
			if($count_pan_search>0){
				
				$row_pan_search = $result_pan_search->fetch_assoc();
				$registration_id = $row_pan_search['id'];
				$company_name = $row_pan_search['company_name'];

				$sql_check_member="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND issue_membership_certificate_expire_status='Y'";
				$result_check_member = $conn->query($sql_check_member);
				$count_check_member =$result_check_member->num_rows;
				if($count_check_member >0){
					##FETCH DETAILS OF MEMBER FORM COMMUNICATION ADDRESS MASTER TABLE
					  $memberType = "member";
					 $sql_m_details="SELECT * FROM communication_address_master WHERE type_of_address='2' AND registration_id='$registration_id'";
	                    $result_m_details = $conn->query($sql_m_details);
						$count_m_details =$result_m_details->num_rows;
						if($count_m_details>0){
	                      ## 
							$pan_number_error[] =array();
						}else{
							$pan_number_error[] =array("status"=>"empty","label"=>"pan_number","msg"=>"Your Head office Address not found in our system ");
						}


				}else{
					$sql_order_history="SELECT * FROM `registration_master` WHERE `id`='$registration_id' AND approval_status='Y'";
					$result_order_history = $conn->query($sql_order_history);
					$count_order_history = $result_order_history->num_rows;
					if($count_order_history>0){
					 	$memberType = "non-member";

	                    $sql_nm_details="SELECT * FROM n_m_billing_address WHERE type_of_address='2' AND registration_id='$registration_id'";
	                    $result_nm_details = $conn->query($sql_nm_details);
						$count_nm_details =$result_nm_details->num_rows;
						$pan_number_error[] =array();
						// if($count_nm_details>0){
	                      ## 
						// 	$pan_number_error[] =array();
						// }else{
						// 	$pan_number_error[] =array("status"=>"empty","label"=>"pan_number","msg"=>"Your Head office Address not found in our system ");
						// }

					}else{
						$pan_number_error[] =array("status"=>"empty","label"=>"pan_number","msg"=>"Company is not approved ");
					}


				}



			}else{
			$pan_number_error[] =array("status"=>"empty","label"=>"pan_number","msg"=>"Pan Number Not Found in our System ");
			}
		
	     
	    }else{
	        $pan_number_error[] =array("status"=>"empty","label"=>"pan_number","msg"=>"Please Enter Valid Pan number ");
	    }
	}
	if(empty($company_name))
		{
			$company_name_error[] = array("status"=>"empty","msg"=>"Company name is Required","label"=>"company_name");
		}else{
			$company_name_error[] =array();
		}
 //    if(empty($gst_number))
	// {
	// 	$gst_number_error[] = array("status"=>"empty","msg"=>"Gst Number is Required","label"=>"gst_number");
	// }else{
	// 	$gst_number_error[] =array();
	// }
	 if(empty($address))
	{
		$address_error[] = array("status"=>"empty","msg"=>"Address is Required","label"=>"address");
	}else{
		$address_error[] =array();
	}
	if(empty($city))
	{
		$city_error[] = array("status"=>"empty","msg"=>"City is Required","label"=>"city");
	}else{
		$city_error[] =array();
	}
	if(empty($state))
	{
		$state_error[] = array("status"=>"empty","msg"=>"State/ Region is Required","label"=>"region");
	}else{
		$state_error[] =array();
	}
	if(empty($person_name))
	{
		$person_name_error[] = array("status"=>"empty","msg"=>"Person Name is Required","label"=>"person_name");
	}else{
		$person_name_error[] =array();
	}
			//print_r($username_error);exit;
				if(empty($person_mobile_number))
				{
				    $person_mobile_number_error[] = array("status"=>"empty","msg"=>"Mobile No. is Required","label"=>"person_mobile_number");
				}else{
					/*
					** CHECKING VALID 10 DIGIT MOBILE NUMBER
					*/
					if(!preg_match('/^\d{10}$/',$person_mobile_number))
					{
						$person_mobile_number_error[] = array("status"=>"empty","msg"=>"Enter Valid Mobile No.","label"=>"person_mobile_number");
					}
					else
					{
						$person_mobile_number_error[] =array();
					}

				}
				if(empty($person_email_id))
				{
					$person_email_id_error[] = array("status"=>"empty","msg"=>"Email - Id is Required","label"=>"person_email_id");
				}else{
					/*
					** CHECKING VALID EMAIL-ID
					*/
					if (!filter_var($person_email_id, FILTER_VALIDATE_EMAIL)) {
						$person_email_id_error[] = array("status"=>"empty","msg"=>"Email -Id is Not Valid","label"=>"person_email_id");
					}else{
						$person_email_id_error[] =array();
					}
				}

			if(count($_POST['occasion'])==0)
			{
				$occasion_error[] = array("status"=>"empty","msg"=>"Select occasion for video","label"=>"occasion");
			}else{
				$occasion_error[] =array();
			}
			if(empty($vid_language))
			{
				$vid_language_error[] = array("status"=>"empty","msg"=>"Please Select language","label"=>"vid_language");
			}else{
				$vid_language_error[] =array();
			}
			if(empty($agree_terms))
			{
				$agree_terms_error[] = array("status"=>"empty","msg"=>"Please Accept terms and conditions","label"=>"agree_terms");
			}else{
				$agree_terms_error[] =array();
			}
			if(empty($_FILES['company_logo']['name'])) {
	            $company_logo_error[] = array("status"=>"empty","msg"=>"Please Upload Company Logo ","label"=>"company_logo");
			}else{
				
				if(!in_array(strtolower($file_ext), $allowed_types)) {
	            $company_logo_error[] = array("status"=>"empty","msg"=>"Please Upload valid logo file","label"=>"company_logo");
				}else{
					if ($file_size > $maxsize){
						$company_logo_error[] = array("status"=>"empty","msg"=>"Please Upload Logo below 2 MB","label"=>"company_logo");
					}else{
						 move_uploaded_file($file_tmpname, $filepath);
	                     $company_logo_error[] =array();
					}

				}
			}
			
          
			$form_error = array_merge(array_filter($pan_number_error),array_filter($company_name_error),array_filter($address_error),
				array_filter($city_error),array_filter($state_error),array_filter($company_logo_error),array_filter($person_name_error),array_filter($person_email_id_error),array_filter($person_mobile_number_error),array_filter($occasion_error),
				array_filter($vid_language_error),array_filter($agree_terms_error));

			if(!empty(array_filter($form_error)))
			{
				echo json_encode($form_error);exit;
			}else{
	            
				// continue
				// $conn->query("UPDATE registration_master SET company_logo='$company_logo' WHERE id ='$registration_id'");
				// $conn->query("INSERT INTO promo_video_logo_master SET type='$memberType',member_id='$registration_id',company_logo='$company_logo',language='$vid_language'");
				 $selected_occasions = count($_POST['occasion']);
				 // if($registration_id=="600716732"){
     //                $total_amount = 1;
				 // }else{
				 // 	$total_amount = 2000*$selected_occasions;
				 // }
				 $total_amount = 2000*$selected_occasions;
				 


				if($total_amount>0){
					$chks = "SELECT * FROM promo_video_payment_history ORDER BY id DESC LIMIT 1";
					$chkResult = $conn->query($chks);
					$row = $chkResult->fetch_assoc();
					$num=$chkResult->num_rows;
					$strNo = rand(1,10000000);
					if($num<=0)
					{ $order_id = 'ORDERID1'; }
					else
					{
					  
					  $order_id='ORDERID'.$strNo;
					}

					$_SESSION['order_id'] = $order_id; 
					
					 $occasions = implode(",",$_POST['occasion']);
					
					$total_payable = $total_amount;
					$key="2900042967901118";
					$payment_mode="9";
					$return_url = "https://gjepc.org/webinar_payment_success.php";
					$_SESSION['ReferenceNo']=$ReferenceNo=rand(100,9999999).time();
					$submerchantid ="45";
					$mandate_str=aes128Encrypt($ReferenceNo."|".$submerchantid."|".$total_payable."|".$person_email_id."|".$company_name."|".$person_mobile_number,$key);
					$optional_str=aes128Encrypt($total_payable."|10104|".$memberType."|".$order_id."|Others 2|0",$key);
					$return_url_str=aes128Encrypt($return_url,$key);
					$reference_str=aes128Encrypt($ReferenceNo,$key);
					$submerchant_str=aes128Encrypt($submerchantid,$key);
					$amount_str=aes128Encrypt($total_payable,$key);
					$payment_mode_str=aes128Encrypt($payment_mode,$key);
					if($total_payable !="0"){
					  	$redirectUrl="https://eazypay.icicibank.com/EazyPG?merchantid=296793&mandatory fields=".$mandate_str."&optional fields=".$optional_str."&returnurl=".$return_url_str."&Reference No=".$reference_str."&submerchantid=".$submerchant_str."&transaction amount=".$amount_str."&paymode=".$payment_mode_str;
				    }else{
				    	
				    	$redirectUrl ="https://gjepc.org/webinar_payment_success.php";
				    }
					
					
					
					 $sql_payment = "INSERT INTO promo_video_payment_history SET registration_id='$registration_id',`order_id`='$order_id',occasion='$occasions',`ReferenceNo`='$ReferenceNo',`created_at`='$date_time',`Transaction_Amount`='$total_payable',name='$person_name',email_id='$person_email_id',mobile_no='$person_mobile_number',address='$address',company_logo='$company_logo'";
					 	
					$result_payment = $conn->query($sql_payment);
					if($result_payment){
					echo json_encode(array("status"=>"success","redirectUrl"=>$redirectUrl));exit;
					}else{
					echo json_encode(array("status"=>"error-single","label"=>"common_error","message"=>"Something went wrong on server please contact admin"));exit;
					}
				}else{
				    echo json_encode(array("status"=>"error-single","label"=>"common_error","message"=>"Please Select One or more occasion for promo video"));exit;
				}

			
				
				
			}
	
}


if($_POST && $_POST["action"]=="check_registered_webinar_user"){
	$mobile_number =filter($_POST["mobile_no"]);
	if($mobile_number !="" && !empty($mobile_number)){
		if(preg_match('/^\d{10}$/',$mobile_number)){
			$chk_webinar_reg = "SELECT * FROM webinar_registration_details WHERE mobile_no='$mobile_number'";
			$result_chk_webinar_reg = $conn->query($chk_webinar_reg);
			$count_chk_webinar_reg = $result_chk_webinar_reg->num_rows;
		    if($count_chk_webinar_reg==0){
	            echo json_encode(array("isNew"=>"yes","label"=>"mobile_no","message"=>"Please enter Below Details "));exit;
	        }else{
	        	$row_chk_webinar_reg = $result_chk_webinar_reg->fetch_assoc();
	        	$name = $row_chk_webinar_reg['name'];
	        	$email_id = $row_chk_webinar_reg['email_id'];
	        	$mobile_no = $row_chk_webinar_reg['mobile_no'];
	        	$company_name = $row_chk_webinar_reg['company_name'];
	        	$pan_no = $row_chk_webinar_reg['pan_no'];
	        	$gst_no = $row_chk_webinar_reg['gst_no'];
	        	$address1 = $row_chk_webinar_reg['address1'];
	        	$address2 = $row_chk_webinar_reg['address2'];
	        	$address3 = $row_chk_webinar_reg['address3'];
	        	$pincode = $row_chk_webinar_reg['pincode'];
	        	$state = $row_chk_webinar_reg['state'];
	            echo json_encode(array("isNew"=>"no","name"=>$name,"email_id"=>$email_id,"mobile_no"=>$mobile_no,"company_name"=>$company_name,"pan_no"=>$pan_no,"gst_no"=>$gst_no,"address1"=>$address1,"address2"=>$address2,"address3"=>$address3,"pincode"=>$pincode,"state"=>$state));exit;
	        }
	    }else{
	    	echo json_encode(array("status"=>"error-single","label"=>"mobile_no","message"=>"Enter  Valid Mobile Number"));exit;
	    }
	}else{
		echo json_encode(array("status"=>"error-single","label"=>"mobile_no","message"=>"Mobile  Number is Required"));exit;
	}

}
if($_POST && $_POST["action"]=="check_member_from_bp_number"){
	$pan_no = filter($_POST['pan_no']);
if($pan_no !="" && !empty($pan_no)){
$sql_chk_bp = "SELECT * FROM registration_master WHERE company_pan_no='$pan_no'  ";
$result_chk_bp = $conn->query($sql_chk_bp);
$count_chk_bp =$result_chk_bp->num_rows;
if($count_chk_bp==0){
echo json_encode(array("status"=>"error-single","label"=>"pan_number","message"=>"Pan Number is not exist"));exit;
}else{
$row_chk_bp= $result_chk_bp->fetch_assoc();
	$registration_id = $row_chk_bp['id'];
/*
** CHECK MEMBER
*/
 $sql_chk_member = "SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND issue_membership_certificate_expire_status='Y'";
$result_chk_member = $conn->query($sql_chk_member);
$count_chk_member = $result_chk_member->num_rows;
if($count_chk_member>0){
// continue
$name =  $row_chk_bp['name'];
$email_id =  $row_chk_bp['email_id'];
$mobile_number =$row_chk_bp['mobile_no'];

$address1 =$row_chk_bp['address_line1'];
$address2 =$row_chk_bp['address_line2'];
$address3 =$row_chk_bp['city'];
$pincode =$row_chk_bp['pin_code'];
$state = getState($row_chk_bp['state'],$conn);
$company_name = getCompanyName($registration_id,$conn);
$gst_no = $row_chk_bp['company_gstn'];
$pan_no = $row_chk_bp['company_pan_no'];

echo json_encode(array("status"=>"success","email_id"=>$email_id,"mobile_no"=>$mobile_number,"name"=>$name,"company_name"=>$company_name,"gst_no"=>$gst_no,"pan_no"=>$pan_no,"address1"=>$address1,"address2"=>$address2,"address3"=>$address3,"pincode"=>$pincode,"state"=>$state));exit;
}else{
	echo json_encode(array("status"=>"error-single","label"=>"pan_no","message"=>"Sorry You are not a Member"));exit;
}
}
}else{
	echo json_encode(array("status"=>"error-single","label"=>"pan_no","message"=>"Please refer 10 digit number starting from 7 in membership certificate"));exit;
}
	
}
if($_POST && $_POST["action"]=="fetch_videos"){
 
	$language = implode(",",$_POST['vid_language']);

	// if($language !=""){
	 $sql_promo_videos = "SELECT * FROM promo_video_demo_master WHERE language_id IN ($language) and status='1'";
	$result_promo_videos = $conn->query($sql_promo_videos);
	$count_promo_videos =$result_promo_videos->num_rows;
	$output = "";
	if($count_promo_videos > 0){
      $output = "";
      $output .= '<div class="row mt-2">';

      while($row_promo_video = $result_promo_videos ->fetch_assoc()){
      	$language_id =$row_promo_video ['language_id']; 
      	$result_language = $conn->query("SELECT * FROM promo_video_language_master WHERE id='$language_id'");
      	$row_language = $result_language->fetch_assoc();
      	$language_name = $row_language['language'];

        $output .= '  <div class=" col-4 col-md-3">';
        //$output .= '  	<iframe src="'.$row_promo_video['video_link'].'" class="w-100"></iframe>';
        $output .= '  	<iframe class="w-100"  src="'.$row_promo_video['video_link'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

        $output .= ' 	<label><input type="checkbox" name="occasion[]" id="occasion" class="mr-2 occasion" value="'.$row_promo_video['id'].'">'.$row_promo_video['occasion'].' - '.$language_name.'</label>';
        $output .= '</div>';
       }
       $output .= '<div class="col-12"><label class="error" for="occasion" generated="true"></label></div></div>';
       echo json_encode(array("status"=>"success","output"=>$output));exit;

	}else{
		$output = "";
	}

// }else{
//      echo json_encode(array("status"=>"error-single","label"=>"vid_language","message"=>"Please Select Language"));exit;
// }

    
}

  if($_POST && $_POST["action"]=="get_details_from_pan_number"){

    $pan_number = filter($_POST['pan_number']);
	if($pan_number !=""){
     if (preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", $pan_number)) {

         $sql_pan_search = "SELECT * FROM registration_master WHERE company_pan_no='$pan_number' and status='1' limit 1";
		$result_pan_search = $conn->query($sql_pan_search);
		$count_pan_search =$result_pan_search->num_rows;
		$row_pan_search = $result_pan_search->fetch_assoc();
       
		if($count_pan_search>0){
			
			
			$registration_id = $row_pan_search['id'];
			$company_name = $row_pan_search['company_name'];

			$sql_check_member="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND issue_membership_certificate_expire_status='Y'";
			$result_check_member = $conn->query($sql_check_member);
			$count_check_member =$result_check_member->num_rows;
			if($count_check_member >0){
				##FETCH DETAILS OF MEMBER FORM COMMUNICATION ADDRESS MASTER TABLE
				 $sql_m_details="SELECT * FROM communication_address_master WHERE type_of_address='2' AND registration_id='$registration_id'";
                    $result_m_details = $conn->query($sql_m_details);
					$count_m_details =$result_m_details->num_rows;
					if($count_m_details>0){
                      ## FETCH DETAILS OF NON MEMBER
						$row_m_details = $result_m_details->fetch_assoc();
						$gst_number = $row_m_details['gst_no'];
						$city = $row_m_details['city'];
						$state =getState($row_m_details['state'],$conn);
						$address = $row_m_details['address1'].','.$row_m_details['address2'].','.$row_m_details['address3'];
						$address_id = $row_m_details['id'];
                        echo json_encode(array("status"=>"success","data"=>array("company_name"=>$company_name,"gst_number"=>$gst_number,"city"=>$city,"state"=>$state,"address"=>$address,"address_id"=>$address_id)));exit;



					}else{
						echo json_encode(array("status"=>"error-single","label"=>"pan_number","message"=>"Your Head office Address not found in our system "));exit;
					}


			}else{
				$sql_order_history="SELECT * FROM `registration_master` WHERE `id`='$registration_id' AND approval_status='Y'";
				$result_order_history = $conn->query($sql_order_history);
				$count_order_history = $result_order_history->num_rows;
				if($count_order_history>0){
                   
                     
						$gst_number = $row_pan_search['company_gstn'];
						$city = $row_pan_search['city'];
						$state =getState($row_pan_search['state'],$conn);
						 $address = $row_pan_search['address_line1'].$row_pan_search['address_line2'].$row_pan_search['address_line3'];
                       
                        echo json_encode(array("status"=>"success","data"=>array("company_name"=>$company_name,"gst_number"=>$gst_number,"city"=>$city,"state"=>$state,"address"=>$address)));exit;

					

				}else{
					echo json_encode(array("status"=>"error-single","label"=>"pan_number","message"=>"Company is not approved"));exit;
				}


			}



		}else{
			echo json_encode(array("status"=>"error-single","label"=>"pan_number","message"=>"Pan Number Not Found in our System "));exit;
		}
	
     
    }else{
        echo json_encode(array("status"=>"error-single","label"=>"pan_number","message"=>"Please Enter Valid Pan number "));exit;
    }

	}else{
	     echo json_encode(array("status"=>"error-single","label"=>"pan_number","message"=>"Please Enter Company Pan number "));exit;
	}

  }

?>