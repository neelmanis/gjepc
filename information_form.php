<?php
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
$registration_id = intval(filter($_SESSION['USERID']));
?>
<?php
$action=$_REQUEST['action'];
if($action=="save")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']){

$company_name	=	strtoupper(filter($_REQUEST['company_name']));
$member_type_id =   filter($_REQUEST['member_type_id']);
$type_of_firm	=	filter($_REQUEST['type_of_firm']);
$cin_no	= str_replace(' ','',$_REQUEST['cin_no']);
$pan_no	= str_replace(' ','',strtoupper(filter($_REQUEST['pan_no'])));
$tan_no	= str_replace(' ','',$_REQUEST['tan_no']);
$iec_no	= str_replace(' ','',$_REQUEST['iec_no']);

$iec_issue_date=date('d-m-Y',strtotime($_REQUEST['iec_issue_date']));

$im_registration_no	 =	filter($_REQUEST['im_registration_no']);
$im_pin_code		 =	filter($_REQUEST['im_pin_code']);
$ssi_registration_no =  filter($_REQUEST['ssi_registration_no']);
$ssi_issue_date	     =	filter($_REQUEST['ssi_issue_date']);
$ssi_pin_code		 =	filter($_REQUEST['ssi_pin_code']);

$issuing_industrial_liecence=$_REQUEST['issuing_industrial_liecence'];
$authority=$_REQUEST['authority'];
$eh_th_certification_no=$_REQUEST['eh_th_certification_no'];
$eh_th_issue_date=$_REQUEST['eh_th_issue_date'];
$eh_th_valid_date=$_REQUEST['eh_th_valid_date'];
$region_id=filter($_REQUEST['region_id']);
$year_of_starting_bussiness=filter($_REQUEST['year_of_starting_bussiness']);
$name	=	filter($_REQUEST['name']);
$designation	=	$_REQUEST['designation'];
$email_id		=	filter($_REQUEST['email_id']);
$address1		=	filter($_REQUEST['address1']);
$address2		=	filter($_REQUEST['address2']);
$address3		=	filter($_REQUEST['address3']);
$pin_code		=	filter($_REQUEST['pin_code']);
$city			=	filter($_REQUEST['city']);
$country		=	filter($_REQUEST['country']);
$land_line_no	=	filter($_REQUEST['land_line_no']);
$mobile_no		=	filter($_REQUEST['mobile_no']);
$joining_date	=	filter($_REQUEST['joining_date']);
$retirement_date=	filter($_REQUEST['retirement_date']);
$post_date=date('Y-m-d');
$ip_address=$_SERVER['REMOTE_ADDR'];
$status_holder=$_REQUEST['status_holder'];
$status_holder_eh=$_REQUEST['status_holder_eh'];
$msme_ssi_status=$_REQUEST['msme_ssi_status'];
$msme_ssi_regis_no=$_REQUEST['msme_ssi_regis_no'];
$uin=filter($_REQUEST['uin']);
$uin_issue_date=$_REQUEST['uin_issue_date'];
$vat_tin=$_REQUEST['vat_tin'];
$co_profile	=	filter($_REQUEST['co_profile']);
$sight_holder=$_REQUEST['sight_holder'];
$sez_member=$_REQUEST['sez_member'];
$epc_fieo_status=$_REQUEST['epc_fieo_status'];
$org_name	=	filter($_REQUEST['org_name']);

/* Validation Start */
	if(empty($company_name)){
	$signup_error = "Please Enter Company Name";
	} else if(empty($member_type_id)){
	$signup_error = "Please Select Member Type";
	} else if(empty($type_of_firm)){
	$signup_error = "Please Select Firm Type";
	} else if(empty($iec_no)){
	$signup_error = "Please Enter IEC No";
	} else if(strlen($iec_no)>10 || strlen($iec_no)<10){
	$signup_error="IEC Number should be 10 digits.";
	} else if(empty($region_id)){
	$signup_error = "Please Select Region";
	} else if($member_type_id==6 && $msme_ssi_status=="Yes" && (empty($ssi_registration_no) && empty($ssi_pin_code) && empty($im_registration_no))){
			$signup_error = "SSI Registration No or SSI Pin Code or IM Registration No is compulsory";
	} else {
		
$query=$conn->query("select * from information_master where registration_id='$registration_id'");
$num = $query->num_rows;

// current challan yr calculation
    $cur_year = (int)date('y');
	$curyear  = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $curyear-1;
	 $cur_fin_yr1= $cur_year-1;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }  else {
     $cur_fin_yr = $curyear;
 	 $cur_fin_yr1= $cur_year;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }
		
if($num>0)
{
	$sql="update information_master set company_name='$company_name',member_type_id='$member_type_id',type_of_firm='$type_of_firm',cin_no='$cin_no',pan_no='$pan_no',tan_no='$tan_no',iec_no='$iec_no',iec_issue_date='$iec_issue_date',im_registration_no='$im_registration_no',im_pin_code='$im_pin_code',ssi_registration_no='$ssi_registration_no',ssi_issue_date='$ssi_issue_date',ssi_pin_code='$ssi_pin_code',issuing_industrial_liecence='$issuing_industrial_liecence',authority='$authority',eh_th_certification_no='$eh_th_certification_no',eh_th_issue_date='$eh_th_issue_date',eh_th_valid_date='$eh_th_valid_date',region_id='$region_id',year_of_starting_bussiness='$year_of_starting_bussiness',name='$name',designation='$designation',email_id='$email_id',address1='$address1',address2='$address2',address3='$address3',pin_code='$pin_code',city='$city',country='$country',land_line_no='$land_line_no',mobile_no='$mobile_no',joining_date='$joining_date',retirement_date='$retirement_date',status=1,ip_address='$ip_address',status_holder='$status_holder',status_holder_eh='$status_holder_eh',msme_ssi_status='$msme_ssi_status',vat_tin_reg_no='$vat_tin',uin='$uin',uin_issue_date='$uin_issue_date',co_profile='$co_profile',sight_holder='$sight_holder',sez_member='$sez_member',epc_fieo_status='$epc_fieo_status',org_name='$org_name',new_update_status='Yes' where registration_id='$registration_id'";
	$infoResult = $conn ->query($sql);
	if($infoResult){
	$_SESSION['succ_msg']="Information Form updated successfully";
	header('location:communication_form.php'); exit;
	} else { die ($conn->error); }
} else {

$qchk_iec = $conn->query("select count(id) as count from information_master where iec_no='$iec_no'");
$rchk_iec = $qchk_iec->fetch_assoc();
$iec_count=$rchk_iec['count'];
if($iec_count>=1){
$_SESSION['chk_iec_msg']="IEC Number Already Exists.";
header('location:information_form.php'); exit;
}

$sql1="insert into information_master set registration_id='$registration_id',company_name='$company_name',member_type_id='$member_type_id',type_of_firm='$type_of_firm',cin_no='$cin_no',pan_no='$pan_no',tan_no='$tan_no',iec_no='$iec_no',iec_issue_date='$iec_issue_date',im_registration_no='$im_registration_no',im_pin_code='$im_pin_code',ssi_registration_no='$ssi_registration_no',ssi_issue_date='$ssi_issue_date',ssi_pin_code='$ssi_pin_code',issuing_industrial_liecence='$issuing_industrial_liecence',authority='$authority',eh_th_certification_no='$eh_th_certification_no',eh_th_issue_date='$eh_th_issue_date',eh_th_valid_date='$eh_th_valid_date',region_id='$region_id',year_of_starting_bussiness='$year_of_starting_bussiness',name='$name',designation='$designation',email_id='$email_id',address1='$address1',address2='$address2',address3='$address3',pin_code='$pin_code',city='$city',country='$country',land_line_no='$land_line_no',mobile_no='$mobile_no',joining_date='$joining_date',retirement_date='$retirement_date',status=1,post_date='$post_date',ip_address='$ip_address',status_holder='$status_holder',status_holder_eh='$status_holder_eh',msme_ssi_status='$msme_ssi_status',vat_tin_reg_no='$vat_tin',uin='$uin',uin_issue_date='$uin_issue_date',co_profile='$co_profile',sight_holder='$sight_holder',sez_member='$sez_member',epc_fieo_status='$epc_fieo_status',org_name='$org_name',new_update_status='Yes'";
$saveResult = $conn ->query($sql1);
if(!$saveResult) die ($conn->error);
$_SESSION['succ_msg']="Information saved successfully";

$swx = $conn ->query("insert into communication_details_master set registration_id='$registration_id',post_date='$post_date'");

/*...........................Fetch challan no. .......................................*/
$chln = $conn ->query("SELECT challan_region_no FROM challan_master WHERE  challan_region_name = '$region_id' AND challan_financial_year = '$cur_fin_yr' ORDER BY id desc limit 1");
$last_challan_no = $chln->fetch_assoc();
$region_code = $region_id;
$last_challan_no = $last_challan_no['challan_region_no'];
    
$sequence = substr($last_challan_no, 10);
$next_sequence = sprintf('%04d', $sequence + 1);
$challan_no = substr($region_code, 3,3) . '/' . $cur_finyr . '/' . $next_sequence;

$chln = $conn ->query("insert into challan_master set registration_id='$registration_id',challan_financial_year='$cur_fin_yr',challan_region_name='$region_code',challan_region_no='$challan_no',status='1',post_date='$post_date'");

$aprv = "insert into approval_master set registration_id='$registration_id',post_date='$post_date'";
$ss = $conn ->query($aprv);
if(!$ss){ die ($conn->error); }
header('location:communication_form.php');exit;
}
	} /* Validation End */
	} else {
	 $_SESSION['error_msg']="Invalid Token Error";
	}
}

$sqlm = "SELECT * FROM `information_master` WHERE 1 and registration_id=$registration_id";
$ssx = $conn ->query($sqlm);
$rows = $ssx->fetch_assoc();

if($rows['company_name']=="")
{
	$sql="SELECT * FROM `registration_master` WHERE 1 and id='$registration_id'";
	$result = $conn ->query($sql);
	$rows1 = $result->fetch_assoc();
	
	$company_name	= strtoupper(filter($rows1['company_name']));
	$country	=	$rows1['country'];
	$land_line_no=$rows1['land_line_no'];
	$city= filter($rows1['city']);
	$mobile_no= filter($rows1['mobile_no']);
} else {
$company_name = strtoupper(filter($rows['company_name']));
$member_type_id = filter($rows['member_type_id']);
$type_of_firm = filter($rows['type_of_firm']);
$cin_no = filter($rows['cin_no']);
$pan_no = strtoupper(filter($rows['pan_no']));
$tan_no = filter($rows['tan_no']);
$iec_no = filter($rows['iec_no']);
$iec_issue_date=$rows['iec_issue_date'];
$im_registration_no=filter($rows['im_registration_no']);
$im_pin_code=filter($rows['im_pin_code']);
$ssi_registration_no=$rows['ssi_registration_no'];
$ssi_issue_date=$rows['ssi_issue_date'];
$ssi_pin_code=filter($rows['ssi_pin_code']);
$issuing_industrial_liecence=$rows['issuing_industrial_liecence'];
$authority=filter($rows['authority']);
$eh_th_certification_no=$rows['eh_th_certification_no'];
$eh_th_issue_date=$rows['eh_th_issue_date'];
$eh_th_valid_date=$rows['eh_th_valid_date'];
$region_id=strtoupper(filter($rows['region_id']));
$year_of_starting_bussiness=filter($rows['year_of_starting_bussiness']);
$name=strtoupper(filter($rows['name']));
$designation=$rows['designation'];
$email_id=filter($rows['email_id']);
$aadhar_no=$rows['aadhar_no'];
$passport_no=$rows['passport_no'];
$address1=strtoupper(filter($rows['address1']));
$address2=strtoupper(filter($rows['address2']));
$address3=strtoupper(filter($rows['address3']));
$pin_code=filter($rows['pin_code']);
$city=strtoupper(filter($rows['city']));
$country=$rows['country'];
$land_line_no=$rows['land_line_no'];
$mobile_no=$rows['mobile_no'];
$joining_date=$rows['joining_date'];
$retirement_date=$rows['retirement_date'];
$admin_aprove=$rows['admin_aprove'];
$status=$rows['status'];
$status_holder=$rows['status_holder'];
$status_holder_eh=$rows['status_holder_eh'];
$msme_ssi_status=$rows['msme_ssi_status'];
$vat_tin=$rows['vat_tin_reg_no'];
$uin=$rows['uin'];
$uin_issue_date=$rows['uin_issue_date'];
$co_profile=filter($rows['co_profile']);
$sight_holder=$rows['sight_holder'];
$sez_member=$rows['sez_member'];
$epc_fieo_status=$rows['epc_fieo_status'];
$org_name=strtoupper(filter($rows['org_name']));
}
?>
<?php 
/*............................Check if Approved.................................*/
$qinfo_aprv = $conn->query("SELECT final_submission FROM approval_master WHERE 1 and registration_id=$registration_id");
$rinfo_aprv = $qinfo_aprv->fetch_assoc();
$chk_info_aprv=$rinfo_aprv['final_submission'];
?>

<section class="py-5">
	<div class="container inner_container">
    	
        <h1 class="bold_font text-center mb-5"><img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> My Account - Application form for Associate Membership</h1>
    
		<div class="row">        	
           
            
            <div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
			</div>
    
    		<div class="col-lg col-md-12 ">
				<p class="gold_clr mb-4 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong> Account Information </strong> </p>				
				<?php 
                if($_SESSION['succ_msg']!=""){
                echo "<div class='alert alert-danger' role='alert'>".$_SESSION['succ_msg']."</div>";
                $_SESSION['succ_msg']="";
                }
                if($_SESSION['chk_iec_msg']!=""){
                echo "<div class='alert alert-warning' role='alert'>".$_SESSION['chk_iec_msg']."</div>";
                $_SESSION['chk_iec_msg']="";
                }
                ?>

				<?php 
                if($_SESSION['form_chk_msg']!="" || $_SESSION['form_chk_msg1']!="" || $_SESSION['form_chk_msg2']!=""){
                echo "<div class='alert alert-warning' role='alert'>";
                if($_SESSION['form_chk_msg']!=""){
                echo $_SESSION['form_chk_msg']."<br>";
                }
                if($_SESSION['form_chk_msg1']!=""){
                echo $_SESSION['form_chk_msg1']."<br>";
                }
                if($_SESSION['form_chk_msg2']!=""){
                echo $_SESSION['form_chk_msg2'];
                }
                echo "</div>";
                $_SESSION['form_chk_msg']="";
                $_SESSION['form_chk_msg1']="";
                $_SESSION['form_chk_msg2']="";
                }
                if($_SESSION['error_msg']!=""){
                echo "<div class='alert alert-warning' role='alert'>";
                echo $_SESSION['error_msg']."<br>";
                echo "</div>";
                }
                ?>
				<?php if(isset($signup_error)){ echo "<div class='alert alert-danger' role='alert'>". $signup_error."</div>"; }?>

				<form class="cmxform row" method="POST" name="infoForm" id="infoForm">
					
					<?php token(); ?>
					
                    <div class="form-group col-sm-6">
					<label class="form-label" for="company_name">Company Name :</label>
					<input type="text" class="form-control" value="<?php echo $company_name;?>" name="company_name" id="company_name" placeholder="Company Name" autocomplete="off" maxlength="40"/>
					</div>
                    
					<div class="form-group col-sm-6">
						<label class="form-label" for="member_type_id">Member Type :</label>
                        <select class="form-control" name="member_type_id" id="member_type_id">
                                <option value="">--- Select Member Type ---</option>
                                  <?php
                                  $sql1="SELECT * FROM `member_type_master` WHERE 1 and `status`=1";
                                  $result1 = $conn->query($sql1);
                                  while($rows1 = $result1->fetch_assoc())
                                  {
                                  if($rows1['sap_value']==$member_type_id)
                                  {
                                  echo "<option selected='selected' value='$rows1[sap_value]'>$rows1[member_type_name]</option>";
                                  } else {
                                  echo "<option value='$rows1[sap_value]'>$rows1[member_type_name]</option>";
                                  }
                                  }
                                  ?>
                        </select>
					</div>
					
                    <div class="form-group col-sm-6">
						<label class="form-label" for="type_of_firm">Type of Firm :</label>
                        <select class="form-control" name="type_of_firm" id="type_of_firm">
                                <option value="">--- Select Type of Firm ---</option>
                                      <?php
                                      $sql2="SELECT * FROM `type_of_firm_master` WHERE 1 and `status`=1";
                                      $result2 = $conn->query($sql2);
									  while($rows2 = $result2->fetch_assoc())
                                      {
                                      if($rows2['sap_value']==$type_of_firm)
                                      {
                                      echo "<option selected='selected' value='$rows2[sap_value]'>$rows2[type_of_firm_name]</option>";
                                      } else  {
                                      echo "<option value='$rows2[sap_value]'>$rows2[type_of_firm_name]</option>";
                                      }
                                      }
                                      ?>
                        </select>
					</div>
                    
					<div class="form-group col-sm-6" id="cinNoDisplay" <?php if($type_of_firm!=13 && $type_of_firm!=12){?> style="display:none;" <?php }?>>
						<label class="form-label" for="cin_no">CIN No. :</label>
						<input type="text" class="form-control" value="<?php echo $cin_no;?>" name="cin_no" id="cin_no" placeholder="CIN No.">
					</div>
			
					<div class="form-group col-sm-6">
						<label class="form-label" for="tan_no">TAN No. :</label>
						<input type="text" class="form-control" value="<?php echo $tan_no;?>" name="tan_no" id="tan_no" placeholder="TAN No." maxlength="10" autocomplete="off">
					</div>
                    
					<div class="form-group col-sm-6">
						<label class="form-label" for="iec_no">IEC No. (10 digit) :</label>
						<input type="text" class="form-control" value="<?php echo $iec_no;?>" name="iec_no" id="iec_no" placeholder="IEC No." maxlength="10" autocomplete="off">
					</div>
					
                    <div class="form-group col-sm-6">
						<label class="form-label" for="iec_issue_date">IEC Issue Date</label>
						<input type="text" class="form-control" value="<?php echo $iec_issue_date;?>" name="iec_issue_date" id="iec_issue_date" placeholder="IEC Issue Date" autocomplete="off" readonly>
					</div>
					
                    <div class="form-group col-sm-6">
						<label class="form-label" for="Status_Holder">Status Holder</label>
						<div class="d-flex mt-2">
                        
                        	<div class="mr-3">
								<label for="Yes">
								<input type="radio" id="chkYes" value="Yes" name="status_holder" <?php if($status_holder=='Yes'){ echo 'checked="checked"'; } ?>/> Yes</label>						
                        	</div>
                        	
                            <div class="mr-3">
                        		<label for="No">
								<input type="radio" id="chkNo" value="No" name="status_holder" <?php if($status_holder=='No'){ echo 'checked="checked"'; } ?> /> No</label>					
                            </div>
                            
						</div>
					</div>
				
					<div class="col-md-6 col-sm-3 col-xs-12">
					<div class="row" id="holder_star" <?php if ($status_holder!='Yes'){?> style="display: none" <?php }?>>
					<div class="col-sm-6" >                    
                    	<label>Select Category </label>
                        <select class="form_text_text" name="status_holder_eh" id="status_holder_eh">
                            <option value="0">--- Select ---</option>
                            <option value="one_star" <?php if($status_holder_eh=="one_star") echo 'selected="selected"'; ?>>One Star</option>
                            <option value="two_star" <?php if($status_holder_eh=="two_star") echo 'selected="selected"'; ?>>Two Star</option>
                            <option value="three_star" <?php if($status_holder_eh=="three_star") echo 'selected="selected"'; ?>>Three Star</option>
                            <option value="four_star" <?php if($status_holder_eh=="four_star") echo 'selected="selected"'; ?>>Four Star</option>
                            <option value="five_star" <?php if($status_holder_eh=="five_star") echo 'selected="selected"'; ?>>Five Star</option>
                        </select>   
					</div>
					<div class="form-group col-sm-6">
							<label for="eh_th_certification_no" class="form-label"/>EH/TH/STH Certificate</label>
							<select class="form_text_text" name="eh_th_certification_no" id="eh_th_certification_no" >
							<option value="0">--- Select ---</option>
							<option value="EH" <?php if($eh_th_certification_no=="EH") echo 'selected="selected"'; ?>>EH</option>
							<option value="TH" <?php if($eh_th_certification_no=="TH") echo 'selected="selected"'; ?>>TH</option>
							<option value="STH" <?php if($eh_th_certification_no=="STH") echo 'selected="selected"'; ?>>STH</option>
							<option value="SSTH" <?php if($eh_th_certification_no=="SSTH") echo 'selected="selected"'; ?>>SSTH</option>
							</select>
					</div>
					</div>											
					</div>

					<div class="col-12" style="display:none;" id="memberttypedisplay">						
                        <div class="row">                        
                        <div class="form-group col-sm-12">
							<label class="form-label" for="company_name">MSME/SSI</label>
							<div class="d-flex">
                            	<div class="mr-3"><label for="Yes"><input type="radio" id="msmeYes" value="Yes" name="msme_ssi_status" <?php echo ($msme_ssi_status=='Yes')? 'checked':'' ?>/> Yes</label></div>
                                <div class="mr-3"><label for="No"><input type="radio" id="msmeNo" value="No" name="msme_ssi_status" <?php echo ($msme_ssi_status=='No')? 'checked':'' ?>/>  No</label></div>
							</div>
						</div>
                        
						<div class="form-group col-md-12" id="msme_main" <?php if($msme_ssi_status!='Yes'){?> style="display: none" <?php }?>>
						<div class="row">
						<div class="form-group col-md-4">
						<label for="ssi_registration_no" class="form-label">UAM/MSME/UDHYAM REGISTRATION No</label>
						<input type="text" class="form-control" name="ssi_registration_no" id="ssi_registration_no" value="<?php echo $ssi_registration_no;?>" placeholder="SSI Registration No" />
						</div>
                        	
						<!--<div class="form-group col-sm-6">
							<label for="eh_th_certification_no" class="form-label"/>EH/TH/STH/SSTH Certificate No. :</label>
							<input type="text" class="form-control" name="eh_th_certification_no" id="eh_th_certification_no" value="<?php echo $eh_th_certification_no;?>" placeholder="EH/TH/STH/SSTH Certificate No." />
						</div>-->
						                        
						<div class="form-group col-md-4">
                            <label for="ssi_issue_date" class="form-label" >DATE OF ISSUE OF UAM/MSME/UDYAM :</label>
                            <input type="text" class="form-control" name="ssi_issue_date" value="<?php echo $ssi_issue_date;?>" id="ssi_issue_date" placeholder="Date of SSI Registration" autocomplete="off" readonly/>
                        </div>
						
						<div class="form-group col-md-4">
                            <label for="ssi_pin_code" class="form-label d-block mb-2">UAM/MSME/UDHYAM Pin Code : </label><br/>
                            <input type="text" class="form-control" name="ssi_pin_code" value="<?php echo $ssi_pin_code;?>" id="ssi_pin_code" placeholder="SSI Pin Code" />
                        </div>
                        </div>
                        </div>
						
						<div class="form-group col-sm-6">
							<label for="eh_th_valid_date" class="form-label">Valid Upto :</label>
                            <input type="text" class="form-control" value="<?php echo $eh_th_valid_date;?>" name="eh_th_valid_date" id="eh_th_valid_date" placeholder="Valid Upto" autocomplete="off" readonly/>					
						</div>
					                    
                        <div class="form-group col-sm-6">
                            <label for="im_registration_no" class="form-label">IM Registration No. :</label>
                            <input type="text" class="form-control" name="im_registration_no" value="<?php echo $im_registration_no;?>" id="im_registration_no" placeholder="IM Registration No." />
                        
                        </div>
                    
                        <div class="form-group col-sm-6">
                            <label for="im_pin_code" class="form-label">IM Pin Code :</label>
                            <input type="text" class="form-control" name="im_pin_code" value="<?php echo $im_pin_code;?>" id="im_pin_code" placeholder="IM Pin Code" />
                        </div>
                    
                        <!--<div class="form-group col-sm-6">
                            <label for="uin" class="form-label">UAN Registration No :</label>
                            <input type="text" class="form-control" name="uin" id="uin" value="<?php echo $uin;?>" placeholder="UAN Registration No"/>
                        </div>
                    
                        <div class="form-group col-sm-6">
                            <label for="uin_issue_date" class="form-label">Date Of Issue :</label>
                            <input type="text" class="form-control" name="uin_issue_date" id="uin_issue_date" value="<?php echo $uin_issue_date;?>" placeholder="UIN Issue Date" />
                        </div>-->
                    
                        <div class="form-group col-sm-6">
                            <label for="issuing_industrial_liecence" class="form-label">ISSUING INDUSTRIAL LINCENCES/IEM :</label>
                            <input type="text" class="form-control" value="<?php echo $issuing_industrial_liecence; ?>" name="issuing_industrial_liecence" id="issuing_industrial_liecence" placeholder="Issuing Industrial Licences/IEM" />
                        </div>
				
                        <div class="form-group col-sm-6">
                            <label for="authority" class="form-label" >Authority :</label>
                            <input type="text" class="form-control" name="authority" id="authority" value="<?php echo $authority;?>" placeholder="Authority" />
                        </div>
						<div class="form-group col-sm-6">
							<label for="eh_th_issue_date" class="form-label">Date of Issue :</label>
							<input type="text" class="form-control" value="<?php echo $eh_th_issue_date;?>" name="eh_th_issue_date" id="eh_th_issue_date" placeholder="Date of Issue" autocomplete="off" readonly/>					
						</div>
                        
                        </div>
                    
                    </div>
					
					<!--<div class="form-group col-sm-6">
						<label class="form-label" for="vat_tin">VAT/TIN/CST Registration No. :</label>
						<input type="text" class="form-control" value="<?php echo $vat_tin;?>" name="vat_tin" id="vat_tin" placeholder="VAT/TIN/CST Registration No.">
					</div>-->

					<div class="form-group col-sm-6">
						<label class="form-label" for="region_id">Select Region :</label>
						<select class="form_text_text" name="region_id" id="region_id" >
							<option value="">--- Select Region ---</option>	
							 <?php
							  $sql3 = "SELECT * FROM `region_master` WHERE 1 and `status`=1";
							  $result = $conn->query($sql3);
							  while($rows3 = $result->fetch_assoc())
							  {
							  if($rows3['region_name']==$region_id)
							  {
							  echo "<option selected='selected' value='$rows3[region_name]'>$rows3[region_full_name]</option>";
							  }else  {
							  echo "<option value='$rows3[region_name]'>$rows3[region_full_name]</option>";
							  }  }
							  ?>
					</select>
					</div>

					<div class="form-group col-sm-12">
						<label class="form-label" for="company_profile">Company Profile</label>
						<textarea class="form-control" rows="5" name="co_profile" id="co_profile"><?php echo $co_profile;?></textarea> 
                    </div>
					
                    <div class="form-group col-sm-6">
						<label class="form-label" for="Status_Holder">DTC Sight Holder</label>
						<div class="form-group">
                        	<div class="d-flex">
                            	<div class="mr-3">
                                	<label for="Yes"><input type="radio" name="sight_holder" value="Yes" <?php if($sight_holder=='Yes'){ echo 'checked="checked"'; } ?>/> Yes</label>
                                </div>
                                <div class="mr-3"> <label for="No"><input type="radio" name="sight_holder" value="No" <?php if($sight_holder=='No'){ echo 'checked="checked"';} ?>/>  No</label> </div>
							</div>
						</div>
					</div>
                    
					<div class="form-group col-sm-6">
						<label class="form-label" for="Status_Holder">SEZ Member</label>
						<div class="d-flex">
							<div class="mr-3"><label for="Yes"><input type="radio" name="sez_member" value="Yes"<?php if($sez_member=='Yes'){ echo 'checked="checked"';}?> /> Yes</label></div>
							<div class="mr-3"><label for="No"><input type="radio" name="sez_member" value="No" <?php if($sez_member=='No'){ echo 'checked="checked"';}?> /> No</label></div>
						</div>
					</div>

					<div class="form-group col-sm-6">
						<label class="form-label" for="Status_Holder">Whether registered with any other EPC/FIEO :</label>
						<div class="d-flex">
                        	<div class="mr-3">
								<label for="Yes"><input type="radio" id="epcYes" value="Yes" name="epc_fieo_status" <?php if($epc_fieo_status=='Yes') { echo 'checked="checked"';} ?>/> Yes</label>
                            </div>
                            <div class="mr-3">
                            	<label for="No"><input type="radio" id="epcNo" value="No" name="epc_fieo_status" <?php if($epc_fieo_status=='No') { echo 'checked="checked"';} ?>/> No</label>
                            </div>						
						</div>			
					</div>

					<div class="form-group col-sm-6" id="epc_main" <?php if($epc_fieo_status!='Yes'){?> style="display: none" <?php }?>>
						<label class="form-label" for="Status_Holder">Name of the Organization :</label>
						<input type="text" class="form-control" name="org_name" id="org_name" value="<?php echo $org_name;?>" placeholder="Name of Organization" />
					</div>

					<div class="form-group col-sm-6">
						<label class="form-label" for="Status_Holder">Year of establishment</label>
						<input type="text" class="form-control position-relative" value="<?php echo $year_of_starting_bussiness;?>" name="year_of_starting_bussiness" id="year_of_starting_bussiness" placeholder="Year of starting Business" autocomplete="off" readonly/>
					</div>

					<div class="form-group col-12">
                        <button type="button" name="add" id="add" data-toggle="modal" data-target="#add_data_Modal" class="cta fade_anim">Add Other Contact Information</button> 
					</div>			
                    
					<div class="form-group col-12 mt-4" id="employee_table">						
                        <table class="responsive_table portal_table">                        
							<thead>
								<tr>
									<th class="text-lg-center">Department</th>
									<th class="text-lg-center">Name</th>
									<th class="text-lg-center">Email</th>
									<th class="text-lg-center">Phone</th>
									<th class="text-lg-center">EDIT</th>
								</tr>
							</thead>
                            
							<tbody id="CommunicationDetails">
								<?php
                                $get_dir="SELECT * FROM `other_contact_detail` where `registration_id`='$registration_id'";
								$dir_result = $conn->query($get_dir);
                                while($getValue = $dir_result->fetch_assoc()){
                                ?>                                
                                <tr>
                                    <td data-column="Department" class="text-lg-center"><?php echo filter(strtoupper($getValue['dept']));?></td>
                                    <td data-column="Name" class="text-lg-center"><?php echo filter(strtoupper($getValue['other_name']));?></td>
                                    <td data-column="Email" class="text-lg-center" ><?php echo $getValue['other_email'];?></td>
                                    <td data-column="Phone" class="text-lg-center"><?php echo $getValue['other_phone'];?></td>
                                    <td data-column="EDIT" class="text-lg-center"><input type="button" name="edit" value="Edit" id="<?php echo $getValue['id'];?>" class="edit_data table_btn"/></td>  					
                                </tr>
								<?php } ?>
							</tbody>						
                        </table>					
                    </div>	
 
					<div class="form-group col-sm-6">
						<input type="hidden" name="action" value="save" class="cta fade_anim"/>
						<?php if($chk_info_aprv!='Y'){?><input class="input_bg cta fade_anim" type="submit" value="Save"/><?php } ?>
					</div>
                    
			</form>
		
			<div id="add_data_Modal" class="modal fade">  
      			<div class="modal-dialog">  
          			<div class="modal-content">  
               			<div class="modal-header">  
                     		<h2 class="title mb-0">Other Contact Information</h2>  
                		</div>  
                <div class="modal-body">  
                    <form method="post" id="insert_form">  
                          <label>Choose Department</label>  
                            <select name="dept" id="dept" class="form-control">				
								<option value="Finance">Accounts & Finance</option>
								<option value="IT">IT</option>
								<option value="Legal">Legal</option>
								<option value="Marketing">Events & Marketing </option>                        
							</select> 
                          <br />  
                          <label>Name</label>  
                         <input type="text" class="form-control" name="other_name" id="other_name" placeholder="Name" autocomplete="off">  
                          <br />  
                          <label>Email</label>  
                          <input type="text" class="form-control" name="other_email" id="other_email" placeholder="Email" autocomplete="off"> 
                          <br />  
                          <label>Phone</label>  
                          <input type="text" class="form-control" name="other_phone" id="other_phone" placeholder="Phone" autocomplete="off">
                          <br />                            
                          <input type="hidden" name="id" id="id"/>  
                          <input type="button" name="insert" id="insert" value="Save" class="cta" />  
                    </form>  
                </div>  
                <div class="modal-footer">  
                     <button type="button" data-dismiss="modal" style="border-bottom:1px solid #a89c5d; color:#a89c5d;"> <strong>Close </strong></button>  
                </div>  
           </div>  
      </div>  
 </div>
			
            </div>            
        </div> 	
    </div>    
</section>
<?php include 'include-new/footer-card.php'; ?>

<script src="assets/js/jquery.validate.js" type="text/javascript"></script> 
<script>
$(document).ready(function(){
	var member_id=$("#member_type_id").val();
	if(member_id==5 || member_id=="")
	{
		$("#memberttypedisplay").hide();
		$("#im_registration_no").attr("disabled", "disabled"); 
		$("#im_pin_code").attr("disabled", "disabled"); 
		$("#ssi_registration_no").attr("disabled", "disabled"); 
		$("#ssi_issue_date").attr("disabled", "disabled"); 
		$("#ssi_pin_code").attr("disabled", "disabled"); 
		$("#issuing_industrial_liecence").attr("disabled", "disabled"); 
		$("#authority").attr("disabled", "disabled"); 
	}
	if(member_id==6)
	{
		$("#memberttypedisplay").show();
		$("#im_registration_no").removeAttr("disabled"); 
		$("#im_pin_code").removeAttr("disabled"); 
		$("#ssi_registration_no").removeAttr("disabled"); 
		$("#ssi_issue_date").removeAttr("disabled"); 
		$("#ssi_pin_code").removeAttr("disabled"); 
		$("#issuing_industrial_liecence").removeAttr("disabled"); 
		$("#authority").removeAttr("disabled"); 
	}

  $("#member_type_id").change(function () {
	var member_id=$(this).val();
	if(member_id==5 || member_id=="")
	{
		$("#memberttypedisplay").hide();
		$("#im_registration_no").attr("disabled", "disabled"); 
		$("#im_pin_code").attr("disabled", "disabled"); 
		$("#ssi_registration_no").attr("disabled", "disabled"); 
		$("#ssi_issue_date").attr("disabled", "disabled"); 
		$("#ssi_pin_code").attr("disabled", "disabled"); 
		$("#issuing_industrial_liecence").attr("disabled", "disabled"); 
		$("#authority").attr("disabled", "disabled"); 
	}
	if(member_id==6)
	{
		$("#memberttypedisplay").show();
		$("#im_registration_no").removeAttr("disabled"); 
		$("#im_pin_code").removeAttr("disabled"); 
		$("#ssi_registration_no").removeAttr("disabled"); 
		$("#ssi_issue_date").removeAttr("disabled"); 
		$("#ssi_pin_code").removeAttr("disabled"); 
		$("#issuing_industrial_liecence").removeAttr("disabled"); 
		$("#authority").removeAttr("disabled"); 
	}
 });
});
</script>
<script type="text/javascript">
$().ready(function() {
	$("#infoForm").validate({
			//var member_id=$("#member_type_id").val();
		rules: {  
			company_name: {
				required: true,
			},  
			member_type_id: {
				required: true,
			}, 
			type_of_firm:{
				required: true,
			},  
			iec_no: {
				required: true,
				minlength: 10,
				maxlength: 10
			},
			iec_issue_date: {
				required: true,
			}, 
			ssi_registration_no: {
				required: true,
			}, 
			ssi_issue_date: {
				required: true,
			}, 
			im_registration_no:{
			required: true,	
			},
			ssi_pin_code: {
				required: true,
			},
			issuing_industrial_liecence: {
				required: true,
			}, 
			authority: {
				required: true,
			},				
			region_id: {
				required: true,
			},  
			year_of_starting_bussiness:{
			 required:true,	
			}			
		},
		messages: {
			company_name: {
				required: "Please Enter Company Name",
			},  
			member_type_id: {
				required: "Please Select Member Type",
			},  
			type_of_firm: {
				required: "Please Select Firm Type",
			},
			pan_no: {
				required: "Please Enter your PAN NO.",
				minlength: "Your PAN no must consist of at least 10 characters",
				maxlength: "Your PAN no must be less than 10 characters"
			},   
			iec_no: {
				required: "Please Enter your IEC No",
				minlength: "Your iec no must consist of at least 10 characters",
				maxlength: "Your iec no must be less than 10 characters"
			},  
			iec_issue_date: {
				required: "Please Enter valid date of issue",
			},   
			ssi_registration_no:
			{
				required: "Please Enter SSI Registration No",
			},
			ssi_issue_date:
			{
				required: "Please Enter SSI issue date",
			},
			im_registration_no:
			{
				required: "Please Enter IM Registration No",
			},
			ssi_pin_code:
			{
				required: "Please Enter SSI Pin code",
			},
			issuing_industrial_liecence: {
				required: "Please Enter industrial liecence number",
			},
			authority: {
				required: "Please Enter authority number",
			},   
			region_id: {
				required: "Please select a region",
			},    
			year_of_starting_bussiness:{
				required: "Please Enter year of starting business",
			}			
		}
	});
});
</script>

<script type="text/javascript">
    $(function () {
        $("input[name='status_holder']").click(function () {
            if ($("#chkYes").is(":checked")) {
                $("#holder_star").show();
            } else {
                $("#holder_star").hide();
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $("input[name='msme_ssi_status']").click(function () {
            if ($("#msmeYes").is(":checked")) {
                $("#msme_main").show();
            } else {
                $("#msme_main").hide();
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $("input[name='epc_fieo_status']").click(function () {
            if ($("#epcYes").is(":checked")) {
                $("#epc_main").show();
            } else {
                $("#epc_main").hide();
            }
        });
    });
</script>
<script>
$(document).ready(function(){
	var typeFirm=$("#type_of_firm").val();
	$("#type_of_firm").change(function () {
	var typeFirm=$(this).val();
	if(typeFirm==13 || typeFirm==12)
	{
		$("#cinNoDisplay").show();
		$("#cin_no").removeAttr("disabled");
	}else
	{
		$("#cinNoDisplay").hide();
		$("#cin_no").attr("disabled", "disabled"); 
	}
 }); 
});
</script>

<script>  
 $(document).ready(function(){  
      $('#add').click(function(){  
           $('#insert').val("Save");  
           $('#insert_form')[0].reset();  
      });  
      $(document).on('click', '.edit_data', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){
                     $('#dept').val(data.dept);  
                     $('#other_name').val(data.other_name);  
                     $('#other_email').val(data.other_email);  
                     $('#designation').val(data.designation);  
                     $('#other_phone').val(data.other_phone);  
                     $('#id').val(data.id);  
                     $('#insert').val("Update");  
                     $('#add_data_Modal').modal('show');  
                }  
           });  
      });  
      $('#insert').on("click", function(event){ 
           event.preventDefault();  
           if($('#dept').val() == "")  
           {  
                alert("Choose Department required");  
           }  
           else if($('#other_name').val() == '')  
           {  
                alert("Name is required");  
           }  
           else if($('#other_email').val() == '')  
           {  
                alert("Email is required");  
           }  
           else if($('#other_phone').val() == '')  
           {  
                alert("Phone is required");  
           }  
           else  
           {  
                $.ajax({  
                     url:"ajax_other_contact.php",  
                     method:"POST",  
                     data:$('#insert_form').serialize(),  
                     beforeSend:function(){  
                          $('#insert').val("Inserting");  
                     },  
                     success:function(data){
						 if(data == '0'){
							 alert('Already Selected!! Try Another Department');
							 $('#add_data_Modal').modal('hide');
						 }else{
                          $('#insert_form')[0].reset();  
                          $('#add_data_Modal').modal('hide');  
                          $('#employee_table').html(data);  
						 }
                     }  
                });  
           }  
      });  
       
 });  
 </script>

<!-- Datepicker Start -->
<script>
$(document).ready(function () { 
				$("#iec_issue_date").datepicker({             
                format: "dd-mm-yyyy"
                });
				$("#eh_th_issue_date").datepicker({             
                format: "dd/mm/yyyy"
                });
				$("#eh_th_valid_date").datepicker({               
                format: "dd-mm-yyyy"
                });
				$("#uin_issue_date").datepicker({            
                format: "dd/mm/yyyy"
                });
				$("#ssi_issue_date").datepicker({             
                format: "dd-mm-yyyy"
                });
                $("#year_of_starting_bussiness").datepicker({              
                format: "dd-mm-yyyy"
                });
				$("#retirement_date").datepicker({              
                format: "dd/mm/yyyy"
                });			
				$('#datetimepicker2').datepicker({
				format: 'DD-MM-YYYY'
				});				
            });    
</script>
<!-- Datepicker End -->