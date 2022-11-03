<?php
//session_start();
include 'include/header.php';
include 'db.inc.php';
//echo "<pre>"; print_r($_POST);

chmod("photo", 0755);

function getNoRegis($gcode)
{
	$query_sel = "SELECT count(gcode) as `count` FROM igjs_summit_registration where gcode='$gcode'";	
	$result_sel = mysql_query($query_sel);
	$row = mysql_fetch_array($result_sel);	
	return $row['count'];
}

function uploadIGJSDocument($file_name,$file_temp,$file_type,$file_size,$name)
{
	$upload_image = '';
	$target_folder = $name.'/';
	$target_path = "";
	$file_name = str_replace(" ","_",$file_name);
		
	if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && $file_size < 2097152)
		{
			$random_name = rand();
			$target_path = $target_folder.$random_name.'_'.$name.'_'.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $random_name.'_'.$name.'_'.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		} else	{
			echo "Invalid file";
		}	
	}	
	return $upload_image;
}

    $query_sql = "select * from igjs_summit_registration";	
	$result_sql = mysql_query($query_sql);
	$inrow = mysql_fetch_array($result_sql);
	$numrow=mysql_num_rows($result_sql);	

if(true)
{
	$verifyMember = mysql_real_escape_string($_REQUEST['verifyMember']);
	$gcode = mysql_real_escape_string($_REQUEST['gcode']);
	$feestype = mysql_real_escape_string($_REQUEST['feestype']);
	$noOfRegistration=getNoRegis($gcode);
	$_SESSION['verifyMember']=$verifyMember;
	
	$sqlx= "select * from approval_master where gcode='$gcode' and gcode!='' and  (`membership_issued_certificate_dt` between '2019-04-01' and '2020-03-31' || (`membership_renewal_dt` between '2019-04-01' and '2020-03-31'))";	
	$query=mysql_query($sqlx);
    $ismember=mysql_num_rows($query);	
	
	
	if($verifyMember=='M'){
		if($numrow > 350)
			{  
				$single=15000;
				$twinshare=10000;
				$fees=5000;
				$feePerPerson= 5000; 
			}
			else
			{
				$single=0;
				$twinshare=0;
				$fees=0;
				$feePerPerson= 0;
			}
		}
	else if($verifyMember=='NM'){
		if($numrow > 350)
			{  
				$single=15000;
				$twinshare=10000;
				$fees=5000;
				$feePerPerson= 5000; 
			}
			else
			{
				$single=0;
				$twinshare=0;
				$fees=0;
				$feePerPerson= 0;
			}
		}
	else if($verifyMember=='IN'){
	       if($numrow > 1)
		   {
			$fees=350;
			$feePerPerson=350;	
		   }else
		   {
		   $fees=0;
		   $feePerPerson=0;
		   }
		}
	else{
	 	$fees=4000;
		$feePerPerson=4000;}
	
	$gst_per=$feePerPerson*18/100; //GST
	$grand_total=$feePerPerson+$gst_per; //Total Payable
	$single_gst=$single*18/100;
	$single_grand_total=$single+$single_gst;
	$twin_gst=$twinshare*18/100;
	$twin_grand_total=$twinshare+$twin_gst;
	
	
	if(isset($verifyMember) && !empty($verifyMember) || isset($gcode) && !empty($gcode))
	{
	$random = rand(1000,9999);		
	$orderID = 	"GJEPC/".$verifyMember."/".$random;
	}
} else {
		echo "Something Wrong";
		header("location:checkMember.php");exit;
}
   
   if($verifyMember=='IN'){
		$feestext="Fees (USD)";
		$feesigst="GST (USD)";
		$totalpayment="Total Payable (USD)";
		$_SESSION['favcolor'] = 'thanks for register sfsdf';
		}
		else
		{
		$feestext="Fees (INR)";
		$feesigst="GST (INR)";
		$totalpayment="Total Payable (INR)";
		}
    
//echo '------'.$feePerPerson.'-->'.$noOfRegistration;
?>

<?php
$action=$_REQUEST['action'];
if(isset($_POST['submit']))
{
	//echo "<pre>";print_r($_POST);exit;
	$email_id=$_REQUEST['email_id'];
	if(empty($email_id))
	{ $signup_error="Please Enter a valid Email id"; }
	else if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) // Validate email address
    {
        $signup_error = "Invalid Email Id Please Enter a valid Email !!";
    }
	else {
	//$email_id=$_REQUEST['email_id'];
	$title=addslashes($_REQUEST['title']);
	$gcode=$_REQUEST['gcode'];
	$designation=addslashes($_REQUEST['designation']);	
	$name=mysql_real_escape_string(strip_tags(addslashes($_REQUEST['first_name'])));
	$company=mysql_real_escape_string(strip_tags(addslashes($_REQUEST['company_name'])));
	$address=mysql_real_escape_string(strip_tags(addslashes($_REQUEST['address_line'])));
	$land_line_no=mysql_real_escape_string(strip_tags($_REQUEST['land_line_no']));
    $mobile_no=mysql_real_escape_string(strip_tags($_REQUEST['mobile_no']));
	$fax=mysql_real_escape_string(strip_tags($_REQUEST['fax_no']));
	$gst_no=mysql_real_escape_string(strip_tags($_REQUEST['gst_no']));
	$website=mysql_real_escape_string(strip_tags($_REQUEST['website']));
	
	$travel=mysql_real_escape_string(strip_tags($_REQUEST['travel']));
	
	$region=mysql_real_escape_string(strip_tags($_REQUEST['region']));	
	$business=mysql_real_escape_string(strip_tags($_REQUEST['business']));

	$card_type=mysql_real_escape_string(strip_tags($_REQUEST['card_type']));
	$holder_name=mysql_real_escape_string(strip_tags($_REQUEST['holder_name']));
	$card_number=mysql_real_escape_string(strip_tags($_REQUEST['card_number']));	
	$expiry_month=mysql_real_escape_string(strip_tags($_REQUEST['expiry_month']));
	$expiry_year=mysql_real_escape_string(strip_tags($_REQUEST['expiry_year']));
	
	$state_name=mysql_real_escape_string(strip_tags($_REQUEST['state_name']));
	$city_name=mysql_real_escape_string(strip_tags($_REQUEST['city_name']));
	$cheque_details=mysql_real_escape_string(strip_tags($_REQUEST['cheque_details']));
	$deposite=mysql_real_escape_string(strip_tags($_REQUEST['deposite']));	
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$business_nature=implode(",",$_REQUEST['business_nature']);
	if(preg_match('/Any Other/',$business_nature))
		$business_nature_other=$_REQUEST['other_business'];
	else
		$business_nature_other="";
	
	$single_2night=implode(",",$_REQUEST['single_2night']);
	
	//---------------------------------------- Upload Photo  -----------------------------------------------
	if(isset($_FILES['photo_image']) && $_FILES['photo_image']['name']!="")
	{
		/* passport picture */
		$photo_copy_name=$_FILES['photo_image']['name'];
		$photo_copy_temp=$_FILES['photo_image']['tmp_name'];
		$photo_copy_type=$_FILES['photo_image']['type'];
		$photo_copy_size=$_FILES['photo_image']['size'];
		$attach="photo";
		if($photo_copy_name!="")
		{
			$photo_image=uploadIGJSDocument($photo_copy_name,$photo_copy_temp,$photo_copy_type,$photo_copy_size,$attach);
		}
	}
	
	if(isset($_FILES['pdf1']) && $_FILES['pdf1']['name']!="")
	{
		/* Flight picture */
		$filght_copy_name=$_FILES['pdf1']['name'];
		$filght_copy_temp=$_FILES['pdf1']['tmp_name'];
		$filght_copy_type=$_FILES['pdf1']['type'];
		$filght_copy_size=$_FILES['pdf1']['size'];
		$attach="flight_pdf";
		if($filght_copy_name!="")
		{
			$pdf1=uploadIGJSDocument($filght_copy_name,$filght_copy_temp,$filght_copy_type,$filght_copy_size,$attach);
		}
	}
	
	if(isset($_FILES['cheque_image']) && $_FILES['cheque_image']['name']!="")
	{
		/* Cheque picture */
		$cheque_copy_name=$_FILES['cheque_image']['name'];
		$cheque_copy_temp=$_FILES['cheque_image']['tmp_name'];
		$cheque_copy_type=$_FILES['cheque_image']['type'];
		$cheque_copy_size=$_FILES['cheque_image']['size'];
		$attach="cheque_details";
		if($cheque_copy_name!="")
		{
			$cheque_image=uploadIGJSDocument($cheque_copy_name,$cheque_copy_temp,$cheque_copy_type,$cheque_copy_size,$attach);
		}
	}
	
		if($photo_image!='')
		{
			if($photo_image!='valid file')
			{
				$sqlx="INSERT INTO `igjs_summit_registration`(`gcode`, `ismember`,`orderid`, `title`, `name`, `designation`, `company`, `address`, `land_line_no`, `mobile_no`, `fax`, `gst_no`, `email`, `website`,`pdf1`,`pdf2`, `region`, `state_name`, `city_name`, `travel`, `card_type`, `cheque`, `deposite`, `holder_name`,`card_number`, `expiry_month`, `expiry_year`,  `business_nature`, `business_nature_other`, `photo`, `fees`, `single`, `twinshare`, `single_2night`, `gst_per`, `total_payable`, `ip`) VALUES ('$gcode', '$verifyMember', '$orderID', '$title', '$name', '$designation', '$company', '$address', '$land_line_no', '$mobile_no', '$fax', '$gst_no', '$email_id', '$website', '$pdf1', '$pdf2', '$region', '$state_name', '$city_name', '$travel', '$card_type','$cheque_image', '$deposite', '$holder_name', '$card_number', '$expiry_month', '$expiry_year', '$business_nature', '$business_nature_other', '$photo_image', '$fees', '$single', '$twinshare', '$single_2night', '$gst_per', '$grand_total','$ip')";
				$resultx = mysql_query($sqlx);
				if(!$resultx){ echo "Error: ".mysql_error(); }

				/*.............................Send mail to users mail id...............................................*/
if($resultx){
	
$message ='<table width="100%" bgcolor="#fff" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">

<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fff" cellpadding="0" cellspacing="0">
    <tr>
	<td width="85%" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="110" height="95"/></td>         
    </tr>  
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>
	
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE India Gold Jewellery Summit 2019</u></strong></td></tr>
	<tr><td align="center">&nbsp;</td></tr>
    
	<tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
    	<p><strong>Dear '.$title.' '.$name.',</strong> </p>
    	<p>Thank you for showing interest in India Gold Jewellery Summit 2019. Please note your application is under approval process.</p>
    	<p><strong>Order No. : '.$orderID.'</strong></p>
    	</td>
    </tr>
    
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
<td colspan="2">
<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:left;">
    <tr>
    	<td colspan="2" style="color:#14b3da;"><strong>Application Summary</strong></td>
    </tr>
    <tr>
        <td width="50%"><strong>Name </strong></td>
        <td width="50%">'.$name.'</td>
    </tr>
    <tr>
        <td width="50%"><strong>Designation</strong></td>
        <td width="50%">'.$designation.'</td>
    </tr>
    <tr>
        <td width="50%"><strong>Company</strong></td>
        <td width="50%">'.$company.'</td>
    </tr>
	<tr>
        <td width="50%"><strong>Mobile No</strong></td>
        <td width="50%">'.$mobile_no.'</td>
    </tr>
	<tr>
        <td width="50%"><strong>Email</strong></td>
        <td width="50%">'.$email_id.'</td>
    </tr>
   
</table>
   
    <tr>
    <td colspan="2" style="line-height:20px;">
<p align="justify">Thank you for registering IGJS 2019, For any query kindly contact to Mrs. Annu Pal Mob:7738098225</p>
<p>Kind Regards,</p>
<p><strong>GJEPC INDIA,</strong></p>
 </td>
</tr>
</table>
</td>
</tr>
</table>';
  
		$to =$email_id.",annu@gjepcindia.com";
		$subject = "PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE India Gold Jewellery Summit 2019"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From:admin@gjepc.org';			
		mail($to, $subject, $message, $headers);
		header('location:thanks.php?orderid='.$orderID);	 
	}
			//	$_SESSION['succ_msg1']="You have been successfully Submitted Form. Your Order Number is $orderID. Click here for Register again <a href='checkMember.php'> Register</a>";
				
			 } else {
			 $signup_error="Sorry you have selected Invalid file."	;
			 }		
		}		
	
	
	
  }
 }
?>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>-->
<script type="text/javascript">
$().ready(function() {
$.validator.addMethod("gstno", function(value, element) {
	if(value=='NA')
		return true;
	else {
	return this.optional(element) || /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/.test(value);
	} }, "Please Enter Valid GSTIN No.");
	$("#regisForm").validate({
		
		rules: {
			title: {
			required: true,
			},
			first_name: {
				required: true,
			},
			photo_image:{
				required: true,
			},
			email_id: {
				required: true,
				email:true
			},
			designation: {
			required: true,
			},  		
			company_name: {
				required: true,
			}, 	 
			address_line: {
				required: true,
			},
			land_line_no: {
				required: true,
				number:true
			},
			mobile_no: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			gst_no: {
				required: true,
				gstno:true
			},
			
			travel: {
				required: true,
			},
			state_name: {
				required: true,
			},
			city_name: {
				required: true,
			},
			
			/*region: {
				required: true,
			},*/
			"business_nature[]":{
				required: true,
				minlength: 1
			},
			/*card_type:{
                required: true,
			},
			holder_name: {
				required: true,
			},
			card_number: {
				required: true,
				number:true
			},
			expiry_month: {
				required: true,
			},
			expiry_year: {
				required: true,
			},
			*/
			terms_and_cond:	{
				required: true,
			},
		
		},
		messages: {
			title: {
				required: "Select Title",
			},
			first_name: {
				required: "Enter your Name",
			},
			photo_image:{
                required:"Please upload file.",
			},
			email_id: {
				required: "Enter a valid Email id",
			},
			designation: {
				required: "Enter Designation",
			}, 			
			company_name: {
				required: "Enter Company Name",
			},  
			address_line: {
				required: "Enter Your Address",
			},
			land_line_no: {
				required: "Enter landline number",
				number:"Enter Numbers only"
			},
			mobile_no: {
				required:"Enter Mobile Number",
				number:"Enter Numbers only",
				minlength:"Enter at least {10} digit.",
				maxlength:"Enter no more than {0} digit."
			},
			gst_no: {
				required: "Enter GST Number",
				gstno:"Please enter Valid gst number"
			},			
			travel: {
				required: "Select Travel Mode",
			},
			state_name: {
				required: "Select State Name",
			},
			city_name: {
				required: "Enter City Name",
			},
			business_nature: {
				required: "Choose At least One",
			},
		/*	card_type:{
            required: "Select Card Type",
			},		
			holder_name: {
				required: "Please Enter Name of card Holder",
			},	
			card_number: {
				required: "Please Enter Card Number",
				number: "Please enter valid Card number",
			},		
			expiry_month: {
				required: "Please Enter Card Expiry Month",
			},
			expiry_year: {
				required: "Please Enter Card Expiry Year",
			},*/
			terms_and_cond: {
			required:"Required.",
			},
	 }
	});
});
</script>
<script>
$(document).ready(function(){
  $("#email_id").change(function(){
	email_id=$("#email_id").val();
	$.ajax({ type: 'POST',
					url: 'getGcodeajax.php',
					data: "actiontype=chkregisuser&email_id="+email_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
								 if(data==0){
								 	$('#submit').attr('disabled' , true);
									$("#chkregisuser").html("Already registered with this email id").css("color", "red"); 
								 }else{
								 	$("#chkregisuser").html("");
								 	$('#submit').removeAttr("disabled");
								 }
							}
		});
 });
});
</script>
<script>
var verifyMember = '<?php echo $verifyMember ?>';
var interntn = '<?php echo $numrow ?>';
var num_nm = '<?php echo $num_nm ?>';
	$(document).ready(function () {	
	//alert(interntn);
		/* show other-wa-jewellery on check */
		$("#other_business_id").click(function () {			
			if($(this).is(":checked"))
				$('#another_business_id').show("slow");
			else
				$('#another_business_id').hide("slow");
		});
		if($("#other_business_id").attr("checked"))

			$('#another_business_id').show("slow");
		/* end other-wa-jewellery */
		   		  
		    		
			 $('#feestype').change(function(){
			    	
				if($('#feestype').val() == 'single') {
					$('#single').show();
					$('#total').show();
					$('#gst').show();  
					$('#twinshare').hide(); 
					$('#fees').hide(); 
					$('#gst_per').val('<?php echo $single_gst;?>');
					$('#grand_total').val('<?php echo $single_grand_total;?>');
				} else if($('#feestype').val() == 'twin'){
					$('#single').hide(); 
					$('#twinshare').show(); 
					$('#total').show();
					$('#gst').show(); 
					$('#fees').hide(); 
					$('#gst_per').val('<?php echo $twin_gst;?>');
					$('#grand_total').val('<?php echo $twin_grand_total;?>');
				} 
				else if($('#feestype').val() == 'fees'){
					$('#single').hide(); 
					$('#twinshare').hide(); 
					$('#fees').show(); 
					$('#total').show();
					$('#gst').show(); 
					$('#gst_per').val('<?php echo $gst_per;?>');
					$('#grand_total').val('<?php echo $grand_total;?>');
					}
					else{
					$('#single').hide(); 
					$('#twinshare').hide();
					$('#fees').hide();
					$('#total').hide();
					$('#gst').hide(); 
					}
			});
			
			if(verifyMember == 'IN')
			{
				$('#single').hide();
				$('#total').show();
				$('#gst').show();  
				$('#twinshare').hide(); 
				$('#fees').show(); 
				$('#days').show(); 
				$('#types').hide();
				$('#gst_number').hide();
				$('#region_id').hide();
				$('#gst_no').attr('name', 'gst_in');
				$('#region').attr('name', 'region_in');
				
			} else 
			{
				$('#single').hide();
				$('#total').hide();
				$('#gst').hide();  
				$('#twinshare').hide(); 
				$('#fees').hide(); 
				$('#days').hide(); 
				$('#types').show();
			}
			
			if(verifyMember == 'NM')
			{
				$('#pdf2_details').hide();
				
				$('.details_text').html('Ticket Details');
			}
			else
			{
			    $('.details_text').html('Ticket Details from');
			}
			
			$("#travel").change(function(){
			var travel = $(this).val();
			  if(verifyMember == 'NM')
			  {
				if(travel == "byroad")
				{
					$('#pdf1_details').hide();
					$('#pdf2_details').hide();
					$('#pdf1').attr('name', 'pdfroad1');
				
					$('.details_text').html('');
				}
				else{
				    $('#pdf1_details').show();
					$('#pdf1').attr('name', 'pdf1');
					$('#pdf2').attr('name', 'pdfroad2');
					$('.details_text').html('Ticket Details');
				}
			   }else
			 {
			   if(travel == "byair")
				{
					$('#pdf1_details').hide();
					$('#pdf2_details').hide();
					$('#pdf1').attr('name', 'pdfroad1');
					
					$('.details_text').html('');
				}
				else{
				    $('#pdf1_details').show();
					$('#pdf2_details').show();
					$('#pdf1').attr('name', 'pdf1');
					$('#pdf2').attr('name', 'pdf2');
					$('.details_text').html('Ticket Details from');
				}  
			 }
			});
			
			$("#state_name").change(function(){
			var state = $(this).val();
				if(state == "Delhi")
				{
					$('#credit_details').hide();
					$('#cheques').show();
					$('#cheque_file').show();
					$('#deposite_details').show();
					$('#card_type').attr('name', 'card_type_new');
					$('#holder_name').attr('name', 'holder_name_new');
					$('#card_number').attr('name', 'card_number_new');
					$('#expiry_month').attr('name', 'expiry_month_new');
					$('#expiry_year').attr('name', 'expiry_year_new');
					
					$('#cheque').attr('name', 'cheque');
					$('#deposite').attr('name', 'deposite');
					$('#cheque_image').show();
					
				}
				else{
	                $('#credit_details').show();
					$('#cheques').hide();
					$('#cheque_file').hide();
					$('#deposite_details').hide();
				
					$('#cheque').attr('name', 'cheque_file_new');
					$('#card_type').attr('name', 'card_type');
					$('#holder_name').attr('name', 'holder_name');
					$('#card_number').attr('name', 'card_number');
					$('#expiry_month').attr('name', 'expiry_month');
					$('#expiry_year').attr('name', 'expiry_year');
					$('#deposite').attr('name', 'deposite_new');
					$('#cheque_image').hide();

				    }
			});
			
			if(verifyMember == 'IN' && interntn < 350)
			{
				$('#fees').hide(); 
				$('#days').hide(); 
				$('#gst').hide();
				$('#total').hide();
				$('#types').hide();
				$('#payment').hide();
			}
			
			if(verifyMember == 'M' && interntn < 350)
			{
				$('#types').hide();
				$('#payment').hide();
			}
			
			if(verifyMember == 'NM' && interntn < 350)
			{
				$('#types').hide();
				$('#payment').hide();
			}
						
	});
</script>
<script type="text/javascript">
$(document).ready(function(){	
	$("#travel").change(function(){
	var travel = $(this).val();
		if(travel == "byroad")
		{   

			$('#pdf1').attr('disabled',true);
			
			$('#pdf1').hide();
		
			
			/*$('#pdf1').attr('name', 'pdfroad1');
			$('#pdf2').attr('name', 'pdfroad2');*/
		}else{
			$('#pdf1').show();
	
			$('#pdf1').attr('disabled',false);
		
		}
	});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
	if($("#payment_mode").val()=="RTGS")
	{ 
		$("#rtgs_desc").css("display","block");
		$("#chequeordd").css("display","none");
	}
	else if($("#payment_mode").val()=="cheque")
	{ 
		$("#cheque_desc").css("display","block");
		$("#chequeordd").css("display","none");
	}
	else
	{
		$("#rtgs_desc").css("display","none");
		$("#cheque_desc").css("display","none");
		$("#chequeordd").css("display","block");
	}
	
	$("#payment_mode").change(function(){
		var value = $(this).val();
		//alert(value);
		
		if(value == "RTGS")
		{
			$("#rtgs_desc").css("display","block");
			$("#chequeordd").css("display","none");
			$("#cheque_desc").css("display","none");
		}
		else if(value == "cheque")
		{
			$("#cheque_desc").css("display","block");
			$("#chequeordd").css("display","none");
			$("#rtgs_desc").css("display","none");
		}
		else
		{
			$("#rtgs_desc").css("display","none");
			$("#cheque_desc").css("display","none");
			$("#chequeordd").css("display","block");
		}
	});
});
</script>
<script>
$(document).ready(function(){
	var payment_mode=$("#payment_mode").val();
	if(payment_mode=="cheque" || payment_mode=="")
	{
		$("#rtgs_desc").hide();
		$("#cheque_no").removeAttr("disabled"); 
		$("#cheque_date").removeAttr("disabled"); 
		$("#cheque_drawn_bank_name").removeAttr("disabled"); 
		$("#cheque_drawn_branch_name").removeAttr("disabled"); 
	}
	if(payment_mode=="RTGS")
	{
		$("#cheque_desc").hide();
		$("#cheque_no").attr("disabled", "disabled"); 		
	}

  $("#payment_mode").change(function () {
	var payment_mode=$(this).val();
	if(payment_mode=="cheque" || payment_mode=="")
	{
		$("#rtgs_desc").hide();
	}
	if(payment_mode=="RTGS")
	{
		$("#rtgs_desc").show();
		$("#cheque_no").attr("disabled", "disabled");  
		$("#cheque_date").attr("disabled", "disabled"); 
		$("#cheque_drawn_bank_name").attr("disabled", "disabled"); 
		$("#cheque_drawn_branch_name").attr("disabled", "disabled");
	}
 });
});
</script>
<style>
.form-group .input_title {display:-webkit-inline-box; width:15%;}
.form-group input[type=text]{width:100%; /*margin-left:2%;*/ display:inline; padding-left:1%!important;}
.form-group input[type=email]{width:100%; /*margin-left:2%;*/ display:inline; padding-left:10px; padding-left:1%!important;}
.form-group input[type=url]{width:100%; /*margin-left:2%;*/ display:inline; padding-left:10px; padding-left:1%!important;}
.form-group input[type=date]{width:25%; /*margin-left:2%;*/ display:inline; padding-left:10px; padding-left:1%!important;}
.terms {height:200px;font-size: 14px;}
.terms ol li {font-weight:normal; line-height:20px;}
.terms table {width:60%; margin-top:20px;} 
.terms table td {padding:10px; border:1px solid #ccc; }
.nature {width:82%; float:right;}
.nature label {width:auto;}
.content_wrp {width:85%; float:right;}
.error {padding-left:2%!important;}
/*.content_wrp select{margin-left:2%;}*/

#rtgs_desc {margin-left:4%;}
.card_terms{ border: solid thin #CCCCCC; padding: 10px; text-align: justify; font-size: 14px; margin-bottom: 10px;}
@media all and (max-width:768px)
{
.form-group label	{width:100%; display:block; margin-bottom:10px;}
.form-group input[type=text]{width:100%; margin-left:0; display:block;}
.content_wrp {width:100%; float:none;}
.content_wrp select {margin-left:0;} 
#photo_image {margin-left:0%;}

}
</style>
<div class="container loginform">
	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title">
		    <!--<h4>INDIA GOLD AND JEWELLERY SUMMIT <?php echo $verifyMember;?></h4>-->
            
            <h4>PARTICIPANT PRE-REGISTRATION APPLICATION FORM FOR India Gold Jewellery Summit 2019</h4>
		</div>
	</div>
<?php if(isset($signup_error)){ echo "<span style='color: red;'>".$signup_error.'</span>';} ?>
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span style='color: red;'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
if($_SESSION['succ_msg1']!=""){
echo "<span style='color: green;'>".$_SESSION['succ_msg1']."</span>";
$_SESSION['succ_msg1']="";
}
else{
?>
	<form class="cmxform" method="post" name="regisForm" id="regisForm" enctype="multipart/form-data">
	
	<input type="hidden" name="action" value="save" />
	<input type="hidden" name="verifyMember" value="<?php echo $verifyMember;?>" />
	<input type="hidden" name="gcode" value="<?php echo $gcode;?>" />	
	
	<div class="col-md-12 col-sm-12 col-xs-12 minibuffer">
	
		<!--<div class="sub_head">PARTICIPANT PRE-REGISTRATION APPLICATION FORM FOR India Gold Jewellery Summit 2019</div>-->
		<span id="chkregisuser"></span>
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<div class="content_wrp">
            <span style="display:inline-block; margin-right:20px;">Title </span>
			<label style="margin-right:10px; display:inline; padding-left:15px;">Mr.</label><input type="radio" name="title" value="Mr.">
            <label style="margin-right:10px; display:inline; padding-left:15px;">Mrs.</label><input type="radio" name="title" value="Mrs.">
            <label style="margin-right:10px; display:inline; padding-left:15px;">Ms.</label><input type="radio" name="title" value="Ms.">
			</div>
		</div>
		<label for="title" generated="true" class="error" style=""></label>
		
		<div class="form-group col-md-4 col-sm-12 col-xs-12">
			<div class="content_wrp">
			<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Visitors Full Name" autocomplete="off">
			</div>
		</div>        
        <div class="form-group col-md-4 col-sm-12 col-xs-12">
            <div class="form-control upload">
            <label for="photo_image"> <span>Upload Your Photo</span></label>
            <input name="photo_image" id="photo_image" type="file" class="textField" placeholder="Photo" />
			</div>        
		</div>
        
        <div class="form-group col-md-4 col-sm-12 col-xs-12">
		<div class="content_wrp">
		<input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" autocomplete="off">
		</div>
		</div>
        
		<div class="form-group col-md-4 col-sm-12 col-xs-12">
			<div class="content_wrp">
			<input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" autocomplete="off">
			</div>
		</div>
        
		<div class="form-group col-md-8 col-sm-12 col-xs-12">
			<div class="content_wrp">
			<input type="text" class="form-control" id="address_line" name="address_line" placeholder="Office Address">
			</div>
		</div>		
		<div class="form-group col-md-4 col-sm-12 col-xs-12">
			<div class="content_wrp">
			<input type="text" class="form-control" id="land_line_no" name="land_line_no" placeholder="Tel No">
			</div>
		</div>
		<div class="form-group col-md-4 col-sm-12 col-xs-12">
			<div class="content_wrp">
			<input type="text" class="form-control" id="mobile_no" name="mobile_no" maxlength="10" placeholder="Mobile No" autocomplete="off">
			</div>
		</div>      
        <div class="form-group col-md-4 col-sm-12 col-xs-12" id="gst_number">
			<!--<div class="input_title">GST Number</div>-->
			<div class="content_wrp">
			<input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="GST Number" autocomplete="off">
			</div>
		</div>
		<div class="form-group col-md-6 col-sm-12 col-xs-12">
			<!--<div class="input_title">Email address</div>-->
			<div class="content_wrp">
			<input type="text" class="form-control" id="email_id" name="email_id" placeholder="Email ID" autocomplete="off">
			</div>
		</div>
		<div class="form-group col-md-6 col-sm-12 col-xs-12">
			<!--<div class="input_title">Website</div>-->
			<div class="content_wrp">
			<input type="text" class="form-control" id="website" name="website" placeholder="Website">
			</div>
		</div>
        <div class="form-group col-md-4 col-sm-12 col-xs-12" id="travel_id">
			<div class="content_wrp">
			<select class="form-control" name="travel" id="travel" >
				<option value="">--- Select Travel Mode ---</option>	
                <option value="byroad">By Road</option>
                <option value="bytrain">By Train</option>
                <option value="byair">By Air</option>	 
			</select>
			</div>
		</div>
                
        <div class="form-group col-md-4 col-sm-12 col-xs-12" id="pdf1_details bytravel">
		<div class="form-control upload-btn-wrapper">            
            <div class="upload">
            	<label for="pdf1"><span>Upload Ticket</span></label>
			  <input name="pdf1" id="pdf1" type="file" class="textField" disabled="disabled" />
			  </div>
            </div>
		</div>
    
        
     <!--    <div class="form-group col-md-4 col-sm-12 col-xs-12" id="pdf2_details bytravel">
		<div class="upload-btn-wrapper">
            <div class="upload form-control">
            <label for="pdf2"><span>Ticket From</span></label>
			<input name="pdf2" id="pdf2" type="file" class="textField " disabled="disabled" />
            </div>
		</div>        
		</div> -->
        
        <div class="form-group col-md-4 col-sm-12 col-xs-12" id="state_id">
			<!--<div class="input_title">State</div>-->
			<div class="content_wrp">
			<select class="form-control" name="state_name" id="state_name" >
				<option value="">--- Select State ---</option>	
                <?php 
				$sql = "select state_name from state_master";
				$query = mysql_query($sql);
				while($row = mysql_fetch_array($query))
				{
				?>
                <option value="<?php echo $row['state_name']; ?>"><?php echo $row['state_name']; ?></option>
                <?php } ?>
			</select>
			</div>
		</div>
        
         <div class="form-group col-md-4 col-sm-12 col-xs-12" id="cheque_image">
            <div class="form-control upload">
            <label for="cheque_image"> <span>Upload Your Cheque</span></label>
            <input name="cheque_image" type="file" class="textField" placeholder="Cheque" />
			</div>        
		</div>
        
        <div class="form-group col-md-4 col-sm-12 col-xs-12">
			<div class="content_wrp">
			<input type="text" class="form-control" id="city_name" name="city_name" placeholder="City">
			</div>
		</div>        
      
        <div id="credit_details">
        
        <div class="form-group col-xs-12"> <strong> Credit Card Details </strong> </div>
        
        <div class="form-group  col-xs-12">The credit card details are mandatory in order to help us reserve the rooms, kindly follow the below mentioned details:</div>        
          
			<div class="form-group col-xs-12">
             <span style="display:inline-block; margin-right:20px;" >Credit card type (tick) :</span>
			<label style="margin-right:10px; display:inline;">Visa</label><input type="radio" checked="checked" id="card_type" name="card_type" value="V" style="margin-right:20px;">
            <label style="margin-right:10px; display:inline;">MasterCard</label><input type="radio" id="card_type" name="card_type" value="M" style="margin-right:20px">
            <label style="margin-right:10px; display:inline;">American Express</label><input type="radio" id="card_type" name="card_type" value="A">
			</div>
        
			<div class="form-group col-md-4 col-sm-12 col-xs-12">
            <!--	<div class="input_title">Name on credit card:</div>-->
			<input type="text" class="form-control" id="holder_name" name="holder_name" placeholder="Name mentioned on credit card">
			</div>
       
     		<div class="form-group col-md-4 col-sm-12 col-xs-12">
            <!--<div class="input_title">Credit card Number:</div>-->
			<input type="number" class="form-control" id="card_number" name="card_number" placeholder="Credit card Number">
			</div>
       
			<div class="form-group col-md-4 col-md-4 col-sm-12 col-xs-12">
            <!--<div class="input_title">Expiry Date (Month/Year):</div>-->
			<div class="col-xs-6" style="padding:0 5px 0 0;"><input type="text" class="form-control exp_date" id="expiry_month" name="expiry_month" placeholder="Expiry Date (Month)"></div>
            <div class="col-xs-6" style="padding:0 0 0 5px;"><input type="text" class="form-control exp_date" id="expiry_year" name="expiry_year" placeholder="Expiry Date (Year)"></div>			
           </div>
		</div>
        
 
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<div class="card_terms">
			 <ol type="1">
				<li>All reservations are to be guaranteed with a valid credit card/advance payment</li>
				<li>Kindly share with us your credit card number along with the expiration date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed.</li>
                <li>100% retention for the entire length of stay will be applicable in case of any No-Show</li>
				<li>The credit card shared will be considered as a guarantee for the reservation made and the same will be charged in the event of any No Show or Cancellation for the above booking.</li>
			</ol>

			</div>			
		</div>		
	
      
        <!--<div class="form-group col-md-12 col-sm-12 col-xs-12" id="region_id">
			<div class="input_title">Region</div>
			<div class="content_wrp">
			<select class="form-control" name="region" id="region" >
					<option value="">--- Select Region ---</option>	
                    <option value="HO-MUM (M)">HEAD OFFICE - MUMBAI</option>
                    <option value="RO-CHE">REGIONAL OFFICE - CHENNAI</option>
                    <option value="RO-DEL">REGIONAL OFFICE - DELHI</option>
                    <option value="RO-JAI">REGIONAL OFFICE - JAIPUR</option>
                    <option value="RO-KOL">REGIONAL OFFICE - KOLKATA</option>
                    <option value="RO-SRT">REGIONAL OFFICE - SURAT</option>		 
			</select>
			</div>
		</div>-->
	
			<div class="form-group col-xs-12"> <strong> Nature of Business </strong>  <label for="business_nature[]" generated="true" class="error " style="display:none;"></label></div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Gold Jewellery Manufacturer" <?php if(preg_match('/Gold Jewellery Manufacturer/',$business_nature)){ echo 'checked="checked"'; }?>>Gold Jewellery Manufacturer</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Gold Jewellery Retailer" <?php if(preg_match('/Gold Jewellery Retailer/',$business_nature)){ echo 'checked="checked"'; }?>>Gold Jewellery Retailer</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Machinery" <?php if(preg_match('/Machinery/',$business_nature)){ echo 'checked="checked"'; }?>>Machinery</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Software" <?php if(preg_match('/Software/',$business_nature)){ echo 'checked="checked"'; }?>>Software</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Publication" <?php if(preg_match('/Publication/',$business_nature)){ echo 'checked="checked"'; }?>>Publication</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Service Provider" <?php if(preg_match('/Service Provider/',$business_nature)){ echo 'checked="checked"'; }?>>Service Provider</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Educational Institution Association" <?php if(preg_match('/Educational Institution Association/',$business_nature)){ echo 'checked="checked"'; }?>>Educational Institution Association</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Banks" <?php if(preg_match('/Banks/',$business_nature)){ echo 'checked="checked"'; }?>>Banks</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="ecomm" <?php if(preg_match('/ecomm/',$business_nature)){ echo 'checked="checked"'; }?>>E- Comm</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Exporters" <?php if(preg_match('/Exporters/',$business_nature)){ echo 'checked="checked"'; }?>>Exporters</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" id="business_nature" value="Jewellery Wholesalers" <?php if(preg_match('/Jewellery Wholesalers/',$business_nature)){ echo 'checked="checked"'; }?>>Jewellery Wholesalers</label>
			</div>
			
			<div class="col-md-4 col-sm-6 col-xs-12">
			<label class="checkbox-inline">
			<input type="checkbox" name="business_nature[]" value="Any Other" id="other_business_id" <?php if(preg_match('/Any Other/',$business_nature)){ echo 'checked="checked"'; } ?>>Any Other</label>
									
		    <div class="form-group col-md-12 col-sm-12 col-xs-12" id="another_business_id" style="display:none;">			
			<!--<div class="input_title">Any Other:</div>-->
			<div class="content_wrp">
			<input type="text" name="other_business" class="textField" value="<?php echo $other_business;?>"/>
			</div>
			</div>
			</div>
			
	<!--	<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<div class="input_title">Upload Photo</div>
			<div class="content_wrp"><input name="photo_image" id="photo_image" type="file" class="textField" /></div>
		</div>-->
        
       <!-- <div class="form-group col-md-12 col-sm-12 col-xs-12" id="types">
			<div class="input_title">Fees Type</div>
			<div class="content_wrp">
			<select name="feestype" id="feestype" class="form-control">
                <option value="" selected>----Select Fees Type---</option>
				<option value="fees">Registration Fees</option>
				<option value="single">fees + single sharing (23rd Nov)</option>
				<option value="twin">fees + twin sharing (23rd Nov)</option>
			</select>
			</div>
		</div>-->
        
		<div class="form-group col-md-12 col-sm-12 col-xs-12" id="fees">
			<div class="input_title"><?php echo $feestext ?></div>
			<div class="content_wrp">
			<input type="text" class="form-control" name="feePerPerson" value="<?php echo $fees;?>" readonly/></div>
		</div>
        <div class="form-group col-md-12 col-sm-12 col-xs-12" id="days">
			<div class="input_title">Single Occupancy for 2 Night :</div>
			<div class="content_wrp">
			<span style="margin-right:10px; display:inline; padding-left:15px;">22nd and 23 Nov</span><input type="radio" name="single_2night" value="22nd and 23 Nov">
            <span style="margin-right:10px; display:inline; padding-left:15px;">23rd and 24 Nov</span><input type="radio" name="single_2night" value="23rd and 24 Nov">
      		<label for="title" generated="true" class="error" style="display:none;"> &nbsp;</label>
			</div>
		</div>
        
        <div class="form-group col-md-12 col-sm-12 col-xs-12" id="twinshare">
			<div class="input_title">fees + twin sharing (23rd Nov)</div>
			<div class="content_wrp">
			<input type="text" class="form-control" name="twinshare"  value="<?php echo $twinshare;?>" readonly/></div>
		</div>
        <div class="form-group col-md-12 col-sm-12 col-xs-12" id="single">
			<div class="input_title">fees + single (23rd Nov)</div>
			<div class="content_wrp">
			<input type="text" class="form-control" name="single" value="<?php echo $single;?>" readonly/></div>
		</div>
        <div class="form-group col-md-12 col-sm-12 col-xs-12" id="gst">
			<div class="input_title"><?php if($verifyMember=="M" || $verifyMember=="NM"){?><?php echo $feesigst;?> 18%<?php } else {?><?php echo $feesigst;?> <?php } ?></div>
			<div class="content_wrp">
			<input type="text" class="form-control" name="gst_per" id="gst_per" value="<?php echo $gst_per;?>" readonly/>
			</div>
		</div>
		<div class="form-group col-md-12 col-sm-12 col-xs-12" id="total">
			<div class="input_title"><?php echo $totalpayment;?></div>
			<div class="content_wrp">
			<input type="text" class="form-control" name="grand_total" id="grand_total" value="<?php echo $grand_total;?>" readonly/>
			</div>
		</div>
		
		<!--<div class="form-group col-md-12 col-sm-12 col-xs-12" id="payment">
			<div class="input_title">Payment</div>
			<div class="content_wrp">
			<select name="payment_mode" id="payment_mode" class="textField">
				<option value="" selected>Please Select</option>
				<option value="cheque">CHEQUE</option>
				<option value="RTGS">NEFT/RTGS </option>
			</select>
			</div>
		</div>-->
		
		<div id="rtgs_desc" class="field" style="margin-bottom:10px;font-size:12px;">
        <div class="content_wrp"> <p><strong>For NEFT/RTGS, The following is the bank details.</strong> </p>
		<strong>Company NAME:</strong>	THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL.<br/>
		<strong>ACCOUNT NO.:</strong>	31170500144<br/>
		<strong>BANK NAME:</strong>		State Bank of India<br/>
		<strong>BRANCH:</strong>	Bharat Diamond Bourse<br/>
		<strong>IFSC Code:</strong>	SBIN0016654<br/>
		<strong>A/c Status:</strong> Current A/c <br/>
        <span class="clear" style="height:1px; background:#ccc; display:block; margin-top:8px;"></span>
		</div>
		</div>
		
		<div id="cheque_desc" class="field" style="margin-bottom:10px;font-size:12px;">
		
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<div class="input_title"> Cheque No</div>
			<div class="content_wrp"><input type="text" class="form-control" name="cheque_no" id="cheque_no" value="<?php echo $cheque_no;?>"/></div>
		</div>
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<div class="input_title">Cheque Date</div>
			<div class="content_wrp"><input type="date" class="form-control" name="cheque_date" id="cheque_date" value="<?php echo $cheque_date;?>"/></div>
		</div>
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
			<div class="input_title">Cheque Drawn (Bank Name)</div>
			<div class="content_wrp">
			<select class="bgcolor" name="cheque_drawn_bank_name" id="cheque_drawn_bank_name">
                <?php
                    $fetch_bank = "select * from bank_master where status = '1'";
                    $e_fb = mysql_query($fetch_bank);
                    echo "<option value=''>--- Select Your Bank ---</option>";
                    while($bd = mysql_fetch_array($e_fb))
					{
                        $bank_option ="";
						$bank_option.= "<option value='".$bd['bank_name']."'";
						
						if($cheque_drawn_bank_name == $bd['bank_name'])
							$bank_option.="selected";
						$bank_option.=">".$bd['bank_name']."</option>";						
						echo $bank_option;
					}
                ?>
            </select>
			</div>
		</div>
		<div class="form-group col-md-12 col-sm-12 col-xs-12">
		<div class="input_title">Cheque Drawn (Branch Name)</div>
		<div class="content_wrp"><input type="text" class="form-control" name="cheque_drawn_branch_name" id="cheque_drawn_branch_name" value="<?php echo $cheque_drawn_branch_name;?>" /></div>
		</div>
		
		</div>
	</div>

	<div class="col-md-12 col-sm-12 col-xs-12 minibuffer">

		<div class="form-group"><strong> Terms of Agreement </strong></div>
		<div class="form-group col-md-12">
			<div class="terms card_terms">
			 <p>These are the general terms and conditions of&nbsp;Gems and Jewellery Export Promotion Council&nbsp;(GJEPC) for use of the GJEPC web site. Please read these terms and conditions carefully as your use of the Site is subject to them. GJEPC reserves the right at its sole discretion to change, modify or add to these terms and conditions without prior notice to you. By continuing to use the Site you agree to be bound by such amended terms.</p>

			<ol>
                <li>Delegates from Delhi region needs to either handover cheque of Rs. 5000/- as deposit towards attending IGJS or fill in the credit card details. In case if there is NO SHOW during the Summit the same would be charged. If the person has attended the Summit, cheque would be handed over back to the registered company.
				</li>
                <li>Registered participants approval will be done by Regional Chairman. Delegates that are approved by Regional Chairman only those can avail complimentary registration & accommodation. 
				</li>
				<li>What you are allowed to do You may:
				<ol style="padding-left:0;">
					<li>browse the Site and view the information on it for personal, professional or other commercial purposes;</li>
					<li>print off pages from the Site to the extent reasonably necessary for your use of the Site in accordance with the above. Provided that at all times you do not do any of the things set out in clause 2.</li>
				</ol>
				</li>
				<li>What you are not allowed to do Subject to these terms and conditions, you may not:
				<ol style="padding-left:0;">
					<li>systematically copy (whether by printing off onto paper, storing on disk or in any other way) substantial parts of the Site;</li>
					<li>remove, change or obscure in any way anything on the Site or otherwise use any material contained on the Site except as set out in these terms and conditions;</li>
					<li>include or create hyperlinks to the Site or any materials contained on the Site; or</li>
					<li>use the Site and anything available from the Site in order to produce any publication or otherwise provide any service that competes with the Site (whether on-line or by other media); or</li>
					<li>for unlawful purposes and you shall comply with all applicable laws, statutes and regulations at all times.</li>
				</ol>
				</li>
				<li>No Investment Advice You acknowledge that:
				<ol style="padding-left:0;">
					<li>GJEPC does not provide investment advice and that nothing on the Site constitutes investment advice (as defined in the Financial Services Act 1986) and that you will not treat any of the Site&#39;s content as such;</li>
					<li>GJEPC does not recommend any financial product;</li>
					<li>GJEPC does not recommend that any financial product should be bought, sold or held by you; and</li>
					<li>nothing on the Site should be construed as an offer, nor the solicitation of an offer, to buy or sell securities by GJEPC</li>
					<li>information which may be referred to on the Site from time to time may not be suitable for you and that you should not make any investment decision without consulting a fully qualified financial adviser.</li>
				</ol>
				</li>
				<li>Access The Site is directed exclusively at users located within the United Kingdom and as such any use of the site by users outside India is at their sole risk. By using the Site you confirm that you are located within India and that you are permitted by law to use the Site.</li>
				<li>Your personal information:<br />
				GJEPC&#39;s use of your personal information is governed by GJEPC&#39;s Privacy Policy, which forms part of these terms and conditions.</li>
				<li>Copyright and Trade Marks
				<ol style="padding-left:0;">
					<li>All copyright and other intellectual property rights in any material (including text, photographs and other images and sound) contained in the Site is either owned by GJEPC or has been licensed to GJEPC by the rights owner(s) for use by GJEPC on the Site. You are only allowed to use the Site and the material contained in the Site as set out in these terms and conditions.</li>
					<li>The Site contains trade marks, including the GJEPC name and logo. All trade marks included on the Site belong to GJEPC or have been licensed to GJEPC by the trade mark owner(s) for use on the Site. You are not allowed to copy or otherwise use any of these trade marks in any way except as set out in these terms and conditions.</li>
				</ol>
				</li>
				<li>Exclusions and limitations of liability
				<ol style="padding-left:0;">
					<li>GJEPC does not exclude or limit its liability for death or personal injury resulting from its negligence, fraud or any other liability which may not by applicable law be excluded or limited.</li>
					<li>Subject to clause 7.1, in no event shall GJEPC be liable (whether for breach of contract, negligence or for any other reason) for (i) any loss of profits, (ii) exemplary or special damages, (iii) loss of sales, (iv) loss of revenue, (v) loss of goodwill, (vi) loss of any software or data, (vii) loss of bargain, (viii) loss of opportunity, (ix) loss of use of computer equipment, software or data, (x) loss of or waste of management or other staff time, or (xi) for any indirect, consequential or special loss, however arising.</li>
				</ol>
				</li>
				<li>Disclaimer
				<ol style="padding-left:0;">
					<li>ALL INFORMATION CONTAINED ON THE SITE IS FOR GENERAL INFORMATIONAL USE ONLY AND SHOULD NOT BE RELIED UPON BY YOU IN MAKING ANY INVESTMENT DECISION. THE SITE DOES NOT PROVIDE INVESTMENT ADVICE AND NOTHING ON THE SITE SHOULD BE CONSTRUED AS BEING INVESTMENT ADVICE. BEFORE MAKING ANY INVESTMENT CHOICE YOU SHOULD ALWAYS CONSULT A FULLY QUALIFIED FINANCIAL ADVISER.</li>
					<li>ALTHOUGH GJEPC USES ITS REASONABLE EFFORTS TO ENSURE THAT INFORMATION ON THE SITE IS ACCURATE AND COMPLETE, WE CANNOT GUARANTEE THIS TO BE THE CASE. AS A RESULT, USE OF THE SITE IS AT YOUR SOLE RISK AND GJEPC CANNOT ACCEPT ANY LIABILITY FOR LOSS OR DAMAGE SUFFERED BY YOU ARISING FROM YOUR USE OF INFORMATION CONTAINED ON THE SITE. YOU SHOULD TAKE ADEQUATE STEPS TO VERIFY THE ACCURACY AND COMPLETENESS OF ANY INFORMATION CONTAINED ON THE SITE.</li>
					<li>Information contained on the site is not tailored for individual use and as a result such information may be unsuitable for you and your investment decisions. You should consult a financial adviser before making any investment decision.</li>
					<li>The Site includes advertisements and links to external sites and co-branded pages in order to provide you with access to information and services which you may find useful or interesting. GJEPC does not endorse such sites nor approve any content, information, goods or services provided by them and cannot accept any responsibility or liability for any loss or damage suffered by you as a result of your use of such sites.</li>
					<li>GJEPC is unable to exercise control over the security or content of information passing over the network or via the Service, and GJEPC hereby excludes all liability of any kind for the transmission or reception of infringing or unlawful information of whatever nature.</li>
					<li>GJEPC accepts no liability for loss or damage suffered by you as a result of accessing Site content which contains any virus or which has been maliciously corrupted.</li>
				</ol>
				</li>
				<li>Availability and updating of the Site
				<ol style="padding-left:0;">
					<li>GJEPC may suspend the operation of the Site for repair or maintenance work or in order to update or upgrade its content or functionality from time to time. GJEPC does not warrant that access to or use of the Site or of any sites or pages linked to it will be uninterrupted or error free.</li>
					<li>GJEPC may change the format and content of the Site at its sole discretion from time to time. You should refresh your browser each time you visit the Site to ensure that you access the most up to date version of the Site.</li>
				</ol>
				</li>
				<li>Enquiries or complaints<br />
				If you have any enquiries or complaints about the Site then please address them (within 30 days of such enquiry or complaint first arising) to : email: info@gjepc.org</li>
				<li>General and governing law
				<ol style="padding-left:0;">
					<li>These terms and conditions form the entire understanding of the parties and supersede all previous agreements, understandings and representations relating to the subject matter. If any provision of these terms and conditions is found to be unenforceable, this shall not affect the validity of any other provision. GJEPC may delay enforcing its rights under these terms and conditions without losing them. You agree that GJEPC may sub-contract the performance of any of its obligations or may assign these terms and conditions or any of its rights or obligations without giving you notice.</li>
					<li>GJEPC will not be liable to you for any breach of these terms and conditions which arises because of any circumstances which GJEPC cannot reasonably be expected to control.</li>
					<li>These terms and conditions shall be governed and interpreted in accordance with Indian law, and you consent to the non-exclusive jurisdiction of the Indian courts.</li>
				</ol>
				</li>
			</ol>
			</div>			
		</div>		
	</div>
	
	<div class="form-group col-md-12 col-sm-12 col-xs-12">
		<label for="terms_and_cond" style="width:100%;">
		<input type="checkbox" name="terms_and_cond" id="terms_and_cond" value="1"> I have read and agree to the 'Terms of Agreement' above. <label for="terms_and_cond" generated="true" class="error" style="display:none"></label></label>
	</div>	

	<div class="col-md-12 col-sm-12 col-xs-12 minibufer">
		<input type="submit" name="submit" id="submit" class="btn btn-default" value="submit">
		
		<input type="reset" class="btn btn-default" value="reset">
	</div>
	</form>
<?php } ?>
</div>
<?php include 'include/footer.php'; ?>

<style>
.form-group input[type=text], .form-control {color:#adadad; height:40px; font-size:13px; border:1px solid #ddd; box-shadow:none; padding:0 15px!important; line-height:40px;}
.form-group {padding-bottom:15px;}
.sub_head {font-weight:normal;}
.content_wrp {width:100%; float:none;}
.loginform {background:none;}
.card_terms ol {margin:0; padding:0;}

.card_terms {background:#fff; padding:20px;}
.card_terms ol li{margin-bottom:10px;}
.card_terms ol li:last-child{margin-bottom:0;}

.checkbox-inline {margin-left:25px;}
label {vertical-align:text-bottom;}

.terms {height:200px;}

label.error {padding: 0 5px!important;
    font-size: 10px;
    display: block;
    position: absolute;
    left: 20px;
    top: -5px;
    margin: 0;
    background: #fff;
    z-index: 1;}
	
.upload label span {color:#adadad; }
	.upload input[type=file] {color:#adadad; font-size:13px; position:absolute; top:10px; display:inline-flex!important; margin-left:10px;}

/*.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}

.upload-btn-wrapper {
  position: relative;

  display: block;
}


.upload-btn-wrapper button {text-align:left; color:#adadad;}*/
</style>




