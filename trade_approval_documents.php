<?php
include 'include-new/header.php';
include 'db.inc.php';
include 'functions.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
?>

<?php 
$registration_id = intval(filter($_SESSION['USERID']));
$info_status = $conn ->query("select status,region_id,member_type_id from information_master where registration_id='$registration_id' and status=1");
$info_result = $info_status->fetch_assoc();
$info_num	 = $info_status->num_rows;

$region_id	=	filter($info_result['region_id']);
$member_type_id = filter($info_result['member_type_id']);
$app_id		=	filter($_SESSION['APP_ID']);

if($_SESSION['APP_ID']==''){ header('location:trade_approval.php');exit;}
 $exhibition_type = getExhibitionType($_SESSION['APP_ID'],$conn);
/*else if(isset($_SESSION['APP_ID']) && $_SESSION['APP_ID']!='')
{
	
	$exh_sql1="select * from trade_documents where app_id=$app_id and registration_id='$registration_id'";
	$exh_result1=mysql_query($exh_sql1);
	$exh_cnt=mysql_num_rows($exh_result1);
	if($exh_cnt>0)$row = $result->fetch_assoc();
	{
		header('location:app.php');
		exit;
	}
}*/
//echo "select * from trade_documents where  app_id='$app_id'";
$docu = $conn ->query("select * from trade_documents where app_id='$app_id'");
$row = $docu->fetch_assoc();
$num = $docu->num_rows;
?>
<script>
$(document).ready(function(){
	 /*$('#Indian_pavilion').click(function() {
        if (!$(this).is(':checked')) {
		    $('#picupload').show();$('#upload1').show();$('#upload2').show();$('#upload3').show();$('#upload4').show();
			$('#upload5').show();$('#upload6').show();$('#upload7').show();$('#upload8').show();
			$(".check_box").each(function(){
				this.checked=false;
			});
        }
		else
		{
			$('#picupload').hide();$('#upload1').hide();$('#upload2').hide();$('#upload3').hide();$('#upload4').hide();
			$('#upload5').hide();$('#upload6').hide();$('#upload7').hide();$('#upload8').hide();
			$(".check_box").each(function(){
				this.checked=true;
			});
		}
    });*/	
});
function validate()
{
 if(document.getElementById('Indian_pavilion').checked)
	 {
		
		 if(!document.getElementById('iec_no_copy').checked)
		 {
				alert('Please select Copy of Valid IEC No.');
				$("#iec_no_copy").focus();
				return false;
		 }
		 if(!document.getElementById('member_cer').checked)
		 {
				alert('Please Select Copy of Valid Mem Certificate.');
				$("#member_cer").focus();
				return false;
		 }
		 
		 if(!document.getElementById('past_org').checked)
		 {
				alert('Please select 3 Years Past Exports Ex.');
				$("#past_org").focus();
				return false;
		 }
		 
		if(!document.getElementById('passport').checked)
		{
				alert('Please select Passport');
				$("#passport").focus();
				return false;
		}
		 
		 if(!document.getElementById('terms_and_cond').checked)
		{
			alert('Please Select Terms And Condition');
			$("#terms_and_cond").focus();
			return false;
		} 
	 }
 else
	 {
	var num = "<?php echo $num ?>"; 
	if(num==0){
	 if(!document.getElementById('iec_no_copy').checked)
	 {
			alert('Please select Copy of Valid IEC No.');
			$("#iec_no_copy").focus();
			return false;
	 }
	 else
	 {
		var p_file=document.getElementById('upload1').value;
		var ext = p_file.substring(p_file.lastIndexOf('.') + 1);
		
		if(ext=='')
		{
			alert('Please Upload Image for Copy of Valid IEC No.');
			document.getElementById('upload1').focus();
			return false;
		}
		else if(ext=='png' || ext=='jpg' || ext=='jpeg' || ext=='pdf' || ext=='xls' || ext=='PDF')
		{
			
		}
		else
		{
			alert('Select Only png,gif,jpg,jpeg,pdf File for IEC no.');
			document.getElementById('upload1').focus();
			return false;
		}
	 }
		 
	if(!document.getElementById('member_cer').checked)
	 {
			alert('Please Select Copy of Valid Mem Ceritificate.');
			$("#member_cer").focus();
			return false;
	 }
	 else
	 {
		var p_file2=document.getElementById('upload2').value;
		var ext2 = p_file2.substring(p_file2.lastIndexOf('.') + 1);
		if(ext2=='')
		{
			alert('Please Upload Image for Valid Mem Ceritificate.');
			document.getElementById('upload2').focus();
			return false;
		}
		else if(ext2=='png' || ext2=='jpg' || ext2=='jpeg' || ext2=='pdf' || ext2=='xls' || ext2=='PDF')
		{
			
		}
		else
		{
			alert('Select Only png, gif, jpg, jpeg ,pdf,excel file for Valid Mem Ceritificate.');
			document.getElementById('upload2').focus();
			return false;
		}
	 }
		
	if(!document.getElementById('past_org').checked)
	 {
			alert('Please select 3 Years Past Exports Ex.');
			$("#past_org").focus();
			return false;
	 }
	 else
	 {
		var p_file4=document.getElementById('upload4').value;
		var ext4 = p_file4.substring(p_file4.lastIndexOf('.') + 1);
		if(ext4=='')
		{
			alert('Please Upload Image for 3 Years Past Exports Ex.');
			document.getElementById('upload4').focus();
			return false;
		}
		else if(ext4=='png' || ext4=='jpg' || ext4=='jpeg' || ext4=='gif' || ext4=='pdf' || ext4=='PDF')
		{
			
		}
		else
		{
			alert('Select Only png,gif,jpg,jpeg,pdf,excel file for 3 Years Past Exports Ex.');
			document.getElementById('upload4').focus();
			return false;
		}
	 }
	}
	if(!document.getElementById('terms_and_cond').checked)
	 {
			alert('Please Select Terms And Condition');
			$("#terms_and_cond").focus();
			return false;
	 }
  }
 }	
</script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#cheque_date').datepick();
});
</script>

	<section class="py-5">    
	<div class="container inner_container">    
    <h1 class="bold_font text-center mb-5"><img src="assets/images/gold_star.png" class="title_star d-block mx-auto">My Account - Trade Documents</h1>
    <div class="row"> 
	<div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
		<?php include 'include/regMenu.php'; ?>
	</div>
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}

if($_SESSION['form_chk_msg']!="" || $_SESSION['form_chk_msg1']!="" || $_SESSION['form_chk_msg2']!=""){
echo "<span class='notification n-attention'>";
echo "</span>";
$_SESSION['form_chk_msg']="";
$_SESSION['form_chk_msg1']="";
$_SESSION['form_chk_msg2']="";
}
?>
	<div class="col-lg col-md-12 ">
    
		<p class="blue">Trade Approval</p>
		
		<div class="d-flex mb-3 tabHeaders">
			<div class="tabHead"><a href="trade_approval.php">General</a></div>
			<?php if($exhibition_type=="exhibition" || $exhibition_type==""){?>
			<div class="tabHead"><a href="trade_exhibition.php">Exhibition</a></div>
			 <?php } ?>
			<div class="tabHead tabactive"><a href="trade_approval_documents.php">Documents</a></div>
		</div>	

<form action="trade_approval_documents_action.php" method="post" id="form1" name="form1" enctype='multipart/form-data' onsubmit='return validate();'>		
<?php
$form_sql = $conn ->query("select * from trade_general_info where registration_id='$registration_id' and app_id='$app_id'"); 
$form_ans = $form_sql->fetch_assoc();
$application_status=$form_ans['application_status'];

if($application_status=='Y' || $application_status=='C'){
?>	
<p class=".ab_description"> <strong>Note :</strong> If you are participating in exhibitions other than India Pavilion, following mandatory documents are to be uploaded </p>		
			<div class="row tabContainers">
							<div class="form-group radio inline-form col-sm-6">
							<label class="col-md-12" for="ppp">
                            <input type="hidden" name="application_status" id="application_status" value="Y"/>
							<input type="checkbox" class="check_box" id="Indian_pavilion" name="Indian_pavilion" onclick="checkBox();" <?php if($row['indian_pavilion']=="Y"){?> checked="checked"<?php }?> disabled="disabled" />Indian Pavilion
							 <strong>(Tick If you are participating through GJEPC)</strong></label>
							</div>

							<div class="form-group radio inline-form col-sm-6">
							<label for="ppp">
							<input type="checkbox" class="check_box" value="Y" id="iec_no_copy" name="iec_no_copy" <?php if($row['iec_no_copy']=="Y"){?> checked="checked"<?php }?> disabled="disabled"/> Copy of Valid IEC No.
							</label>
                            <input type="file" name="upload1" id="upload1" disabled="disabled"/>
							</div>
                            						
							<div class="form-group radio inline-form col-sm-6">
							<label for="ppp">
							<input type="checkbox" class="check_box" value="Y" id="member_cer" name="member_cer" <?php if($row['member_cer']=="Y"){?> checked="checked"<?php }?> disabled="disabled"/> Copy of Valid Mem Cer.
							</label>
                            <input type="file" name="upload2" id="upload2"  disabled="disabled"/>
							</div>
																				
							<div class="form-group radio inline-form col-sm-6">
							<label  for="ppp">
							<input type="checkbox" class="check_box" id="fair_org" value="Y" name="fair_org" <?php if($row['fair_org']=="Y"){?> checked="checked"<?php }?> disabled="disabled"/> Participation Proof
							</label>
                            <input type="file" name="upload3" id="upload3"  disabled="disabled"/>
							</div>										
							
							<div class="form-group radio inline-form col-sm-6">
							<label for="ppp">
							<input type="checkbox" class="check_box" id="past_org" value="Y" name="past_org" <?php if($row['past_org']=="Y"){?> checked="checked"<?php }?> disabled="disabled" /> 3 Years Past Exports Ex.
							</label>
                            <input type="file" name="upload4" id="upload4" disabled="disabled"/>
							</div>
							
							<div class="form-group radio inline-form col-sm-6">
							<label  for="ppp">
							<input type="checkbox" class="check_box" id="passport" value="Y" name="passport" <?php if($row['passport']=="Y"){?> checked="checked"<?php }?> disabled="disabled"/> Passport Photocopy of.
							</label>
                            <input type="file" name="upload5" id="upload5" disabled="disabled"/>
							</div>
							</div>
							<?php if($exhibition_type=="branded_jewellery" || $exhibition_type=="person_hand"){?>
							<div class="form-group radio inline-form">
							<label class="col-md-12" for="ppp">
							<input type="checkbox" class="check_box" id="brand_cer" value="Y" name="brand_cer" <?php if($row['brand_cer']=="Y"){?> checked="checked"<?php }?> disabled="disabled" /> Brand Regs Certificate.
							</label>													
							<input type="file" name="upload6" id="upload6"    disabled="disabled"/>
							</div>	
							<div class="form-group radio inline-form">
							<label class="col-md-12" for="ppp">
							<input type="checkbox" class="check_box" id="proof_authenticity" value="Y" name="proof_authenticity" <?php if($row['proof_authenticity']=="Y"){?> checked="checked"<?php }?>  disabled="disabled" /> Proof of Authenticity o.
							</label>
							<input type="file" name="upload7" id="upload7"  disabled="disabled"/>							
							</div>	
							<div class="form-group radio inline-form">
							<label class="col-md-12" for="ppp">
							<input type="checkbox" class="check_box" id="contract_with" value="Y" name="contract_with" <?php if($row['contract_with']=="Y"){?> checked="checked"<?php }?> disabled="disabled"/> Proof of Contract with.
							</label>
							<input type="file" name="upload8" id="upload8"    disabled="disabled"/>
							</div>	
							<?php } ?>
							
							<div class="col-md-12 col-sm-12 col-xs-12 minibuffer">
                            
		<p class="blue">Declaration</p>
		<div class="form-group col-md-12">
		
			<?php if($exhibition_type=="promotional_tour"){?>
			 <ol class="inner_under_listing">
				<li>We declare that we will abide with Para 4.46 & 4.47 of FTP 2015-20 read with Para 4.80 of H.Bo.P 2015-20</li>
				<li>We hereby declare that a complete report on our tour abroad will be submitted to the Council within 30 days from the return of goods. We also understand that any approval for future tours will not be given if this report is not submitted to the Council.</li>
				<li>We hereby declare that we are not on the Caution list of RBI & also on the DEL list of DGFT or debarred from receiving licenses etc. under the Foreign Trade (Development & Regulation) Act, 1992.</li>
				<li>We declare that we would bring back the jewellery / goods or repatriate the sale proceeds within 45 days from the date of departure through normal banking channel & value of goods sent will not exceed US $ 1 million.</li>
				<li>The Members will be responsible & liable for and shall indemnify the Council and keep the Council indemnified and safe and harmless at all times, against any and all claims, liabilities, damages, losses, costs (including reasonable legal fees), charges, expenses, proceedings and actions of any nature whatsoever made or instituted against or caused to or suffered by the Council directly or indirectly by reason of any non-compliance of the statutory laws or non-payment of the statutory levies by the Govt. authorities on the Member.</li>
				<li>I hereby certify that all the documents uploaded are true.</li>
				<li>I am authorized to verify & agree to all the terms & conditions in this declaration as per Para 9.06  FTP 2015-20</li>
			</ol>
			<?php } else if($exhibition_type=="exhibition"){?>
			 <ol class="inner_under_listing">
				<li>We declare that we will abide with Para 4.46 & 4.47 of FTP 2015-20 read with Para 4.80 of H.Bo.P 2015-20</li>
				<li>We hereby declare that a complete report on our tour abroad will be submitted to the Council within 30 days from the return of goods. We also understand that any approval for future tours will not be given if this report is not submitted to the Council.</li>
				<li>We hereby declare that we are not on the Caution list of RBI & also on the DEL list of DGFT or debarred from receiving licenses etc. under the Foreign Trade (Development & Regulation) Act, 1992.</li>
				<li>The Members will be responsible & liable for and shall indemnify the Council and keep the Council indemnified and safe and harmless at all times, against any and all claims, liabilities, damages, losses, costs (including reasonable legal fees), charges, expenses, proceedings and actions of any nature whatsoever made or instituted against or caused to or suffered by the Council directly or indirectly by reason of any non-compliance of the statutory laws or non-payment of the statutory levies by the Govt. authorities on the Member.</li>				
				<li>I hereby certify that all the documents uploaded are true.</li>
				<li>I am authorized to verify & agree to all the terms & conditions in this declaration as per Para 9.06  FTP 2015-20</li>
			</ol>
			<?php } else if($exhibition_type=="branded_jewellery"){?>
		 <ol class="inner_under_listing">
				<li>We declare that we will abide with Para 4.46 & 4.47 of FTP 2015-20 read with Para 4.80 of H.Bo.P 2015-20</li>
				<li>We fully understand that any information furnished in the Application if proved incorrect or false will render us liable for any penal action or other consequences as may be prescribed in law or otherwise warranted.</li>
				<li>We undertake to abide by the previous of the Foreign Trade (Development & Regulation) Act, 1992, the Rules & Orders framed there under, the Foreign Trade Policy & the Handbook of procedures.</li>
				<li>The Members will be responsible & liable for and shall indemnify the Council and keep the Council indemnified and safe and harmless at all times, against any and all claims, liabilities, damages, losses, costs (including reasonable legal fees), charges, expenses, proceedings and actions of any nature whatsoever made or instituted against or caused to or suffered by the Council directly or indirectly by reason of any non-compliance of the statutory laws or non-payment of the statutory levies by the Govt. authorities on the Member.</li>				
				<li>I hereby certify that all the documents uploaded are true.</li>
				<li>I am authorized to verify & agree to all the terms & conditions in this declaration as per Para 9.06  FTP 2015-20</li>
			</ol>
			<?php }?>
				
		</div>
		<div class="form-group radio col-md-12">
			<label for="terms_and_cond">
			<input type="checkbox" name="terms_and_cond" id="terms_and_cond" value="Y" class="form-checkbox" <?php if($row['terms_and_cond']=="Y"){?> checked="checked"<?php }?> disabled="disabled" />I am authorized to verify & agree to all the terms & conditions in this declaration. We would like to make shipment from (City) customs</label>
		</div>
		<div class="form-group radio col-md-12">
			<div class="col-md-8 nopadding" >
			<label for="terms_and_cond">We would like to make shipment from (City) customs :</label>
			</div>
			<div class="col-md-4">
			<input type="text" name="shipment_city" id="shipment_city" value="<?php echo $row['shipment_city'];?>" class="form-checkbox" readonly="readonly"/>
			</div>
		</div>
	</div>
									
			</div>
			</div>
	<?php } else { ?>
    
			<p class=".ab_description"> <strong> Note :</strong> If you are participating in exhibitions other than India Pavilion, following mandatory documents are to be uploaded </p>
            
			<div class="row tabContainers">	
							
							<div class="form-group radio inline-form col-md-4">
							<label  for="ppp">
                            <input type="hidden" name="application_status" id="application_status" value="N"/>
							<input type="checkbox" class="check_box" id="Indian_pavilion"  name="Indian_pavilion" onclick="checkBox();" <?php if($row['indian_pavilion']=="Y"){?> checked="checked"<?php }?> />	Indian Pavilion <strong>(Tick If you are participating through GJEPC) </strong>
							</label>								
							</div>

							<div class="form-group radio inline-form col-md-4">
									<label for="ppp">
										<input type="checkbox" class="check_box" value="Y" id="iec_no_copy" name="iec_no_copy" <?php if($row['iec_no_copy']=="Y"){?> checked="checked"<?php }?> /> Copy of Valid IEC No.
									</label>
								<input type="file" name="upload1" id="upload1" accept=".jpg,.jpeg,.png,.pdf" />
							</div>
							
							<div class="form-group radio inline-form col-md-4">
									<label  for="ppp">
										<input type="checkbox" class="check_box" value="Y" id="member_cer" name="member_cer" <?php if($row['member_cer']=="Y"){?> checked="checked"<?php }?> /> Copy of Valid Mem Cer.
									</label>
								
								 <input type="file" name="upload2" id="upload2" accept=".jpg,.jpeg,.png,.pdf" />
							</div>
							
							<div class="form-group radio inline-form col-md-4">
									<label for="ppp">
										<input type="checkbox" class="check_box" id="fair_org" value="Y" name="fair_org" <?php if($row['fair_org']=="Y"){?> checked="checked"<?php }?> /> Participation Proof
									</label>
								
								<input type="file" name="upload3" id="upload3"  accept=".jpg,.jpeg,.png,.pdf" />
							</div>
							
							<div class="form-group radio inline-form col-md-4">
									<label for="ppp">
										<input type="checkbox" class="check_box" id="past_org" value="Y" name="past_org" <?php if($row['past_org']=="Y"){?> checked="checked"<?php }?> /> 3 Years Past Exports Ex.
									</label>
								
								<input type="file" name="upload4" id="upload4" accept=".jpg,.jpeg,.png,.pdf"/>
							</div>	

							<div class="form-group radio inline-form col-md-4">
									<label for="ppp">
										<input type="checkbox" class="check_box" id="passport" value="Y" name="passport" <?php if($row['passport']=="Y"){?> checked="checked"<?php }?> /> Passport Photocopy of.
									</label>
							
								<input type="file" name="upload5" id="upload5" accept=".jpg,.jpeg,.png,.pdf"/>
							</div>	
							<?php if($exhibition_type=="branded_jewellery" || $exhibition_type=="person_hand"){?>
							<div class="form-group radio inline-form col-sm-6">
									<label for="ppp">
										<input type="checkbox" class="check_box" id="brand_cer" value="Y" name="brand_cer" <?php if($row['brand_cer']=="Y"){?> checked="checked"<?php }?> /> Brand Regs Certificate.
									</label>
							
								<input type="file" name="upload6" id="upload6"  accept=".jpg,.jpeg,.png,.pdf"/>
							</div>
							<div class="form-group radio inline-form col-sm-6">
							<label for="ppp">
							<input type="checkbox" class="check_box" id="proof_authenticity" value="Y" name="proof_authenticity" <?php if($row['proof_authenticity']=="Y"){?> checked="checked"<?php }?> /> Proof of Authenticity o.
							</label>								
							<input type="file" name="upload7" id="upload7" accept=".jpg,.jpeg,.png,.pdf"/>
							</div>
							<div class="form-group radio inline-form col-sm-6">
							<label for="ppp">
							<input type="checkbox" class="check_box" id="contract_with" value="Y" name="contract_with" <?php if($row['contract_with']=="Y"){?> checked="checked"<?php }?> /> Proof of Contract with.
							</label>								
							<input type="file" name="upload8" id="upload8" accept=".jpg,.jpeg,.png,.pdf"/>
							</div>
							 <?php }?>
							 
							
		<p class="blue">Declaration</p>
		<div class="form-group col-12">
			<div class="terms">
			<?php if($exhibition_type=="promotional_tour"){?>
			 <ul class="inner_under_listing">
				<li>We declare that we will abide with Para 4.46 & 4.47 of FTP 2015-20 read with Para 4.80 of H.Bo.P 2015-20</li>
				<li>We hereby declare that a complete report on our tour abroad will be submitted to the Council within 30 days from the return of goods. We also understand that any approval for future tours will not be given if this report is not submitted to the Council.</li>
				<li>We hereby declare that we are not on the Caution list of RBI & also on the DEL list of DGFT or debarred from receiving licenses etc. under the Foreign Trade (Development & Regulation) Act, 1992.</li>
				<li>We declare that we would bring back the jewellery / goods or repatriate the sale proceeds within 45 days from the date of departure through normal banking channel & value of goods sent will not exceed US $ 1 million.</li>
				<li>The Members will be responsible & liable for and shall indemnify the Council and keep the Council indemnified and safe and harmless at all times, against any and all claims, liabilities, damages, losses, costs (including reasonable legal fees), charges, expenses, proceedings and actions of any nature whatsoever made or instituted against or caused to or suffered by the Council directly or indirectly by reason of any non-compliance of the statutory laws or non-payment of the statutory levies by the Govt. authorities on the Member.</li>
				<li>I hereby certify that all the documents uploaded are true.</li>
				<li>I am authorized to verify & agree to all the terms & conditions in this declaration as per Para 9.06  FTP 2015-20</li>
			</ul>
			<?php } else if($exhibition_type=="exhibition"){?>
			<ul class="inner_under_listing">
				<li>We declare that we will abide with Para 4.46 & 4.47 of FTP 2015-20 read with Para 4.80 of H.Bo.P 2015-20</li>
				<li>We hereby declare that a complete report on our tour abroad will be submitted to the Council within 30 days from the return of goods. We also understand that any approval for future tours will not be given if this report is not submitted to the Council.</li>
				<li>We hereby declare that we are not on the Caution list of RBI & also on the DEL list of DGFT or debarred from receiving licenses etc. under the Foreign Trade (Development & Regulation) Act, 1992.</li>
				<li>The Members will be responsible & liable for and shall indemnify the Council and keep the Council indemnified and safe and harmless at all times, against any and all claims, liabilities, damages, losses, costs (including reasonable legal fees), charges, expenses, proceedings and actions of any nature whatsoever made or instituted against or caused to or suffered by the Council directly or indirectly by reason of any non-compliance of the statutory laws or non-payment of the statutory levies by the Govt. authorities on the Member.</li>				
				<li>I hereby certify that all the documents uploaded are true.</li>
				<li>I am authorized to verify & agree to all the terms & conditions in this declaration as per Para 9.06  FTP 2015-20</li>
			</ul>
			<?php } else if($exhibition_type=="branded_jewellery"){?>
			<ul class="inner_under_listing">
				<li>We declare that we will abide with Para 4.46 & 4.47 of FTP 2015-20 read with Para 4.80 of H.Bo.P 2015-20</li>
				<li>We fully understand that any information furnished in the Application if proved incorrect or false will render us liable for any penal action or other consequences as may be prescribed in law or otherwise warranted.</li>
				<li>We undertake to abide by the previous of the Foreign Trade (Development & Regulation) Act, 1992, the Rules & Orders framed there under, the Foreign Trade Policy & the Handbook of procedures.</li>
				<li>The Members will be responsible & liable for and shall indemnify the Council and keep the Council indemnified and safe and harmless at all times, against any and all claims, liabilities, damages, losses, costs (including reasonable legal fees), charges, expenses, proceedings and actions of any nature whatsoever made or instituted against or caused to or suffered by the Council directly or indirectly by reason of any non-compliance of the statutory laws or non-payment of the statutory levies by the Govt. authorities on the Member.</li>				
				<li>I hereby certify that all the documents uploaded are true.</li>
				<li>I am authorized to verify & agree to all the terms & conditions in this declaration as per Para 9.06  FTP 2015-20</li>
			</ul>
			<?php }?>
			</div>			
		</div>
        
		<div class="form-group radio col-12">
			<label for="terms_and_cond">
			<input type="checkbox" name="terms_and_cond" id="terms_and_cond" value="Y" class="form-checkbox" <?php if($row['terms_and_cond']=="Y"){?> checked="checked"<?php }?>  /> I am authorized to verify & agree to all the terms & conditions in this declaration. We would like to make shipment from (City) customs</label>
		</div>
        
		<div class="form-group radio col-12">
			<label for="terms_and_cond">We would like to make shipment from (City) customs :</label>
			<input type="text" name="shipment_city" id="shipment_city" value="<?php echo $row['shipment_city'];?>" class="form-control"/>			
		</div>
        <div class="col-12">
		<input type="submit" value="Submit" class="cta fade_anim"/>
        </div>
	</div>
</div>
	<?php } ?>
			<div class="row">
				<div class="col-md-12">
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
				<input type="hidden" name="region_id" id="region_id" value="<?php echo $region_id;?>" />				
				</div>
			</div>
		</form>
	</div>
	</div>
    </div>
    </section>

<?php include 'include-new/footer.php'; ?>