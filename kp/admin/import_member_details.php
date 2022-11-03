<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Welcome to GJEPC</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!--navigation-->
  <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
  <script type="text/javascript" src="js/ddsmoothmenu.js"></script>
  <script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
  <!--navigation end-->
  <style type="text/css">
<!--
.style1 {
	color: #FF0000
}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
  </head>
<body>
  <div id="header_wrapper">
  <?php include("include/header.php");?>
</div>
  <div id="nav_wrapper">
  <div class="nav">
      <?php include("include/menu.php");?>
</div>
  </div>
  <div class="clear"></div>
  <div class="breadcome_wrap">
  <div class="breadcome"><a href="admin.php">Home</a> > Import Member Data</div>
</div>
  <div id="main">
  <div class="content">
    <?php 
	$con_gjepc = mysqli_connect("localhost","gjepcliveuserdb","KGj&6(pcvmLk5","gjepclivedatabase");

// Check connection
  if(mysqli_connect_errno($con_gjepc))
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

 function filter_input_string($data)
 {
	$data = trim($data);
	$data = filter_var($data,FILTER_SANITIZE_STRING);
	return $data;
 }


if($_REQUEST['action']=='view') {   
	// current challan yr calculation
	$cur_year=(int)date('y');
	$curyear=(int)date('Y');
	$cur_month =(int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $curyear-1;
	 /*$cur_fin_nyr = $cur_fin_yr+1;
	 $cur_fin_yr=$cur_fin_yr.'-04-01';
	 $cur_fin_nyr=$cur_fin_nyr.'-03-31';
	 $cur_fin_yr1= $cur_year-1;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;*/
    } else {
     $cur_fin_yr =$curyear;
	 /*$cur_fin_nyr =$cur_fin_yr+1;
	 $cur_fin_yr=$cur_fin_yr.'-04-01';
	 $cur_fin_nyr=$cur_fin_nyr.'-03-31';
 	 $cur_fin_yr1= $curyear;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;*/
    }

		$total_count=0;
		$insert_count=0;
		$update_count=0;
		
     /* ..........................This section will open after June 2020............................
	 $sql_gjepc="select a.email_id,a.password,a.company_pan_no,a.company_name,a.address_line1,a.address_line2,a.address_line3,a.city,a.country,a.state,a.land_line_no,a.mobile_no,a.status,a.website,a.post_date,b.*,c.c_bp_number,d.region_id from registration_master a, approval_master b ,communication_address_master c, information_master d where (b.`membership_issued_certificate_dt` between '$cur_fin_yr' and '$cur_fin_nyr' || (b.`membership_renewal_dt` between '$cur_fin_yr' and '$cur_fin_nyr')) and b.registration_id=a.id and a.`id`=c.`registration_id` and a.`id`=d.`registration_id` and c.type_of_address='2' and c.address_identity='CTC'";
	 */
	 
	$sql_gjepc="select a.email_id,a.company_secret,a.old_pass,a.company_pan_no,a.company_name,a.address_line1,a.address_line2,a.address_line3,a.city,a.country,a.state,a.land_line_no,a.mobile_no,a.status,a.website,a.post_date,b.*,c.c_bp_number,d.region_id from registration_master a, approval_master b ,communication_address_master c, information_master d where b.admin_issue_membership_certificate='Y' and b.registration_id=a.id and a.`id`=c.`registration_id` and a.`id`=d.`registration_id` and c.type_of_address='2' and c.address_identity='CTC' limit 7140,1000";
	
	//$sql_gjepc="select a.email_id,a.company_secret,a.old_pass,a.company_pan_no,a.company_name,a.address_line1,a.address_line2,a.address_line3,a.city,a.country,a.state,a.land_line_no,a.mobile_no,a.status,a.website,a.post_date,b.*,c.c_bp_number,d.region_id from registration_master a, approval_master b ,communication_address_master c, information_master d where b.registration_id=a.id and a.`id`=c.`registration_id` and a.`id`=d.`registration_id` and c.type_of_address='2' and c.address_identity='CTC' and a.id='600904190'";
	$result_gjepc=mysqli_query($con_gjepc,$sql_gjepc);
	$rowcount=mysqli_num_rows($result_gjepc);
	if(!$result_gjepc)
		echo mysqli_error();
	
	while($row_gjepc = mysqli_fetch_assoc($result_gjepc))
	  {
			 $member_id=filter_input_string($row_gjepc['registration_id']);
			 $gcode=filter_input_string($row_gjepc['gcode']);
			 $email_id=filter_input_string($row_gjepc['email_id']); 
			 $password=filter_input_string($row_gjepc['old_pass']);
			 $company_pan_no=$row_gjepc['company_pan_no'];
			 $c_bp_number=$row_gjepc['c_bp_number'];
			 $region_id=$row_gjepc['region_id'];
			 $company_name=filter_input_string($row_gjepc['company_name']);
			 $address_line1= filter_input_string($row_gjepc['address_line1']);
			 $address_line2=filter_input_string($row_gjepc['address_line2']);
			 $address_line3=filter_input_string($row_gjepc['address_line3']); 
			 $city= filter_input_string($row_gjepc['city']);
			 $country=filter_input_string($row_gjepc['country']);
			 $country=strtoupper($country);
			 $state=filter_input_string($row_gjepc['state']); 
			 $land_line_no=filter_input_string($row_gjepc['land_line_no']); 
			 $mobile_no=filter_input_string($row_gjepc['mobile_no']); 
			 $status= $row_gjepc['status']; 
			 $website=filter_input_string($row_gjepc['website']); 
			 $membership_issued_certificate_dt=$row_gjepc['membership_issued_certificate_dt']; 
			
			
			$sql_iec_no="select iec_no,name from information_master where registration_id='$member_id'";			
			$iec_result=mysqli_query($con_gjepc,$sql_iec_no);
			$row_iec=mysqli_fetch_assoc($iec_result);
			$iec_no=$row_iec['iec_no'];	
			$first_name=$row_iec['name'];
			
			$sql_kp="select * from kp_member_user_details where MEMBER_ID=$member_id";		
			$result_kp=mysqli_query($conn,$sql_kp);
			$cnt=mysqli_num_rows($result_kp);		
			
			if($cnt>0)
			{
				$sql_member_details="update kp_member_user_details set LOGIN_NAME='$email_id',LOGIN_PASSWORD='$password',BP_NUMBER='$c_bp_number',COMPANY_PAN_NO='$company_pan_no',COMPANY_NAME='$company_name',FIRST_NAME='$first_name',LAST_NAME='$last_name',EMAIL='$email_id',ENTERED_BY='admin',MODIFIED_ON=NOW() where MEMBER_ID='$member_id'";				
			}
			else
			{
				$sql_member_details="insert into kp_member_user_details (MEMBER_ID,GCODE,BP_NUMBER,COMPANY_PAN_NO,LOGIN_NAME,LOGIN_PASSWORD,COMPANY_NAME,FIRST_NAME,LAST_NAME,EMAIL,ENTERED_BY,ENTERED_ON,MODIFIED_ON) values ('$member_id','$gcode','$c_bp_number','$company_pan_no','$email_id','$password','$company_name','$first_name','$last_name','$email_id','admin',now(),now())";				
			}
			
		$result_query=mysqli_query($conn,$sql_member_details);
		if(!$result_query)
			echo mysqli_error();
	
					$date1=date("Y",strtotime($membership_issued_certificate_dt));
						
						$sql_kp_member_master="select * from kp_member_master where MEMBER_ID='$member_id'";
			 			$result_kp_member_master=mysqli_query($conn,$sql_kp_member_master);			 
						$cntt=mysqli_num_rows($result_kp_member_master);
						if($cntt==0)
			 			{
					
					$sql_member_master="insert into kp_member_master (MEMBER_ID,GJEPC_MEMBER,IEC_NO,MEMBER_REG_YEAR,MEMBER_REGION_ID,MEMBER_CO_NAME,MFCODE,MEMBER_ADDRESS1,MEMBER_ADDRESS2,MEMBER_ADDRESS3,PINCODE,STATE,CITY,COUNTRY,MEMBER_CO_TEL1,MEMBER_CO_EMAIL,MEMBER_CO_WEBSITE,CONTACT_PER_NAME,ENTERED_BY,ENTERED_ON,MODIFIED_ON,SEZ_STATUS,KP_COUNTRY,MEMBER_CO_FAX1) values ('$member_id','Y','$iec_no','$cur_fin_yr','$region_id','$company_name','$gcode','$address_line1','$address_line2','$address_line3','$pincode','$state','$city','$country','$land_line_no','$email_id','$website','$person_name','admin',now(),now(),'N','0','$land_line_no')";
					
					$result_query1=mysqli_query($conn,$sql_member_master);
							if(!$result_query1)
								echo mysqli_error();
								
					$insert_count++;
						}
						else{
					    $sql_member_master="update kp_member_master set IEC_NO='$iec_no',MEMBER_REG_YEAR='$cur_fin_yr',MODIFIED_ON=NOW() where MEMBER_ID='$member_id'";					 
						$result_query1=mysqli_query($conn,$sql_member_master);
							if(!$result_query1)
								echo mysqli_error();
					 
					$update_count++;					
						}		
								
								$sql_address="select * from communication_address_master where registration_id='$member_id'";
								$result_address=mysqli_query($con_gjepc,$sql_address);
								
								while($address_rows=mysqli_fetch_array($result_address))
								{
											$address_country=$address_rows['country'];
											$add_id=filter_input_string($address_rows['id']);
											$registration_id=filter_input_string($address_rows['registration_id']);
											$type_of_address=filter_input_string($address_rows['type_of_address']);
											$address_identity=filter_input_string($address_rows['address_identity']);
											$type_of_address_sap=filter_input_string($address_rows['type_of_address_sap']);
											$c_bp_number=$address_rows['c_bp_number'];
											$name=filter_input_string($address_rows['name']);
											$address1=filter_input_string($address_rows['address1']);
											$address2=filter_input_string($address_rows['address2']);
											$address3=filter_input_string($address_rows['address3']);
											$city=filter_input_string($address_rows['city']);
											$state=filter_input_string($address_rows['state']);
											$pincode=filter_input_string($address_rows['pincode']);
											$landline_no1=filter_input_string($address_rows['landline_no1']);
											$mobile_no=filter_input_string($address_rows['mobile_no']);
											$fax_no1=filter_input_string($address_rows['fax_no1']);
											$fax_no2=filter_input_string($address_rows['fax_no2']);									
									
							$sql_kp_member_address="select * from kp_member_address_details where MEMBER_ADD_ID='$add_id'";
							$result_kp_member_address=mysqli_query($conn,$sql_kp_member_address);
							
							if(!$result_kp_member_address)
								echo mysqli_error();
							
			 			 	$cntt1=mysqli_num_rows($result_kp_member_address);
							//exit;
			 				if($cntt1==0)
			 				{
								 $sql_address_details="insert into kp_member_address_details (MEMBER_ADD_ID,MEMBER_ID,MEMBER_ADD_SR_NO,MEMBER_BP_NO,ADDRESS_IDENTITY,TYPE_OF_ADDRESS_SAP,MEMBER_CO_NAME,MEMBER_ADDRESS1,MEMBER_ADDRESS2,MEMBER_ADDRESS3,PINCODE,CITY,STATE,COUNTRY,MEMBER_CO_TEL1,MEMBER_CO_TEL2,MEMBER_CO_FAX1,MEMBER_CO_FAX2,ENTERED_ON,MODIFIED_ON,STATUS) values ('$add_id','$registration_id','$type_of_address','$c_bp_number','$address_identity','$type_of_address_sap','$company_name','$address1','$address2','$address3','$pincode','$city','$state','$address_country','$landline_no1','$mobile_no','$fax_no1','$fax_no2',now(),now(),'1')";
							} else {
							$sql_address_details="update kp_member_address_details set MEMBER_ID='$registration_id',MEMBER_ADD_SR_NO='$type_of_address',MEMBER_BP_NO='$c_bp_number',ADDRESS_IDENTITY='$address_identity',TYPE_OF_ADDRESS_SAP='$type_of_address_sap',MEMBER_CO_NAME='$company_name',MEMBER_ADDRESS1='$address1',MEMBER_ADDRESS2='$address2',MEMBER_ADDRESS3='$address3',PINCODE='$pincode',CITY='$city',STATE='$state',COUNTRY='$address_country',MEMBER_CO_TEL1='$landline_no1',MEMBER_CO_TEL2='$mobile_no',MEMBER_CO_FAX1='$fax_no1',MEMBER_CO_FAX2='$fax_no2',STATUS='1' where MEMBER_ID='$registration_id' and MEMBER_ADD_ID='$add_id'";
							}
			$result_address_details=mysqli_query($conn,$sql_address_details);			
			if(!$result_address_details)
				echo mysqli_error();										
			}
								
				//$insert_count++;				
			// }	 
	  $total_count++;
	  }
 } ?>
    <div class="content_details1"> 
					<?php echo "Total Member Details Records Are :".$total_count."<br/><br/>"; 
						echo "Total New inserted Member Records Are :".$insert_count."<br/><br/>";
						echo "Total Updated Member Records Are :".$update_count."<br/><br/>";					
					?> 
	</div>
    </div>
</div>
  </div>
  </div>
  <div id="footer_wrap">
  <?php include("include/footer.php");?>
</div>
  </body>
</html>
