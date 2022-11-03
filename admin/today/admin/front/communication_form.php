<?php include 'include/header.php'; ?>
<?php if(!isset($_SESSION['USERID'])){header('location:login.php');exit;}?>
<?php
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$registration_id=$_SESSION['USERID'];
//echo "select member_type_id,type_of_firm,status from information_master where registration_id='$registration_id' and status=1";
$info_status=mysql_query("select member_type_id,type_of_firm,status,pan_no,gst_no,pin_code,land_line_no from information_master where registration_id='$registration_id' and status=1");
$info_num=mysql_num_rows($info_status);
$info_row=mysql_fetch_array($info_status);
$member_type_id=$info_row['member_type_id'];
$type_of_firm=$info_row['type_of_firm'];
$pan_no=$info_row['pan_no'];
$gst_no=$info_row['gst_no'];
$pin_code=$info_row['pin_code'];
$landline_no=$info_row['land_line_no'];


if($info_num==0){
$_SESSION['form_chk_msg']="Please first fill Information form";
header('location:information_form.php');
exit;
}
?>
<?php 
/*............................Check if Approved.................................*/
$qcom_aprv=mysql_query("SELECT final_submission,membership_expiry_status,membership_expiry_dt,apply_membership_renewal FROM approval_master WHERE 1 and registration_id=$registration_id");
$rcom_aprv=mysql_fetch_array($qcom_aprv);
$chk_com_aprv=$rcom_aprv['final_submission'];
$membership_expiry_status=$rcom_aprv['membership_expiry_status'];
$membership_expiry_dt=$rcom_aprv['membership_expiry_dt'];
$apply_membership_renewal=$rcom_aprv['apply_membership_renewal'];

?>
<?php
$action=$_REQUEST['action'];
if($action=="update")
{
$registration_id=$_REQUEST['registration_id'];
$panel_name=$_REQUEST['panel_name'];
$refer_membership_id=$_REQUEST['refer_membership_id'];
$refer_firm_name=$_REQUEST['refer_firm_name'];
$list_of_document=$_REQUEST['list_of_document'];

foreach($list_of_document as $val)
{
  $list_of_document_new.=$val.",";
}
$authority_firm_name=$_REQUEST['authority_firm_name'];
$authority_firm_registration_no=$_REQUEST['authority_firm_registration_no'];
$authority_registration_date=$_REQUEST['authority_registration_date'];
$authority_registration_valid_upto=$_REQUEST['authority_registration_valid_upto'];
$export_product_name=$_REQUEST['export_product_name'];

foreach($export_product_name as $val)
{
$export_product_name_new.=$val.",";
}
$post_date=date('Y-m-d');
$ip_address=$_SERVER['REMOTE_ADDR'];

$qchkDin=mysql_query("select * from communication_address_master where registration_id='$registration_id' and (din_no='' || pan_no='') and type_of_address='7'");
$nchkdin=mysql_num_rows($qchkDin);

$qchkPan=mysql_query("select * from communication_address_master where registration_id='$registration_id' and pan_no='' and type_of_address='5'");
$nchkPan=mysql_num_rows($qchkPan);

if($nchkdin==0 || $nchkPan==0)
{	
	$query=mysql_query("select * from communication_details_master where registration_id='$registration_id'");
	$num=mysql_num_rows($query);
	if($num>0){
	$sql1="update communication_details_master set panel_name='$panel_name',refer_membership_id='$refer_membership_id',refer_firm_name='$refer_firm_name',list_of_document='$list_of_document_new',authority_firm_name='$authority_firm_name',authority_firm_registration_no='$authority_firm_registration_no',authority_registration_date='$authority_registration_date',authority_registration_valid_upto='$authority_registration_valid_upto',export_product_name='$export_product_name_new',status='1',ip_address='$ip_address',new_update_status='Yes' where registration_id='$registration_id'";
	}
	else{
	$sql1="insert into communication_details_master set registration_id='$registration_id', panel_name='$panel_name',refer_membership_id='$refer_membership_id',refer_firm_name='$refer_firm_name',list_of_document='$list_of_document_new',authority_firm_name='$authority_firm_name',authority_firm_registration_no='$authority_firm_registration_no',authority_registration_date='$authority_registration_date',authority_registration_valid_upto='$authority_registration_valid_upto',export_product_name='$export_product_name_new',status='1',new_update_status='Yes',ip_address='$ip_address'";
	}
	
	if (!mysql_query($sql1))
	{
		die('Error: ' . mysql_error());
	}
	if(($membership_expiry_dt<=date("Y-m-d")) && ($membership_expiry_status=='Y') && ($apply_membership_renewal=='N')){
		header('location:challan_form_renew.php');exit;
		}
	else
		{
			$_SESSION['succ_msg']="Communication Form updated successfully";
			header('location:challan_form.php');exit;
		}
	}
	else
	{
		$_SESSION['form_chk_msg1']="Kindly update DIN/PAN number of Directors / Partners by clicking on edit option as it is mandatory.";
		header('location:communication_form.php');exit;
	}
}


$sql="SELECT * FROM `communication_details_master` WHERE 1 and registration_id=$registration_id";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);

$panel_name=ucwords(strtolower($rows['panel_name']));
$refer_membership_id=$rows['refer_membership_id'];
$refer_firm_name=$rows['refer_firm_name'];
$list_of_document=$rows['list_of_document'];
$authority_firm_name=$rows['authority_firm_name'];
$authority_firm_registration_no=$rows['authority_firm_registration_no'];
$authority_registration_date=$rows['authority_registration_date'];
$authority_registration_valid_upto=$rows['authority_registration_valid_upto'];
$export_product_name=$rows['export_product_name'];
$status=$rows['status'];
?>

<!-- Datepicker Start -->
<script src="js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link href="css/datepicker.css" rel="stylesheet" type="text/css" />

<script>
$(document).ready(function () {
                $('#authority_registration_date').datepicker({
                minDate: 0,
                autoclose: true, 
                todayHighlight: true,
                format: "dd/mm/yyyy"
                });
				$('#authority_registration_valid_upto').datepicker({
                minDate: 0,
                autoclose: true, 
                todayHighlight: true,
                format: "dd/mm/yyyy"
                });
            });    
</script>
<!-- Datepicker End -->
<script>
$(document).ready(function(){
	/*
 $("#type_of_address").change(function () {
	var type_of_address=$(this).val();
	arr = type_of_address.split('-');
	//alert(arr[0]);
	alert(arr[1]);
	if((arr[0]==1) || (arr[0]==5) || (arr[0]==7))
	{
		$("#basedontype").show();
	}
	if((arr[0]==2) || (arr[0]==3) || (arr[0]==4) || (arr[0]==5) || (arr[0]==6) || (arr[0]==10))
	{	
		$("#basedontypes").show();
	}
	if((arr[0]=="") && (arr[0]!=2) && (arr[0]!=3) && (arr[0]!=4) && (arr[0]!=6) && (arr[0]!=10) (arr[0]==1) && (arr[0]==7))
	{	
		$("#basedontypes").hide();	
	}
	if((arr[0]=="") || (arr[0]!=1) && (arr[0]!=5) && (arr[0]!=7))
	{	
		$("#basedontype").hide();	
	}
}); */
	 $("#type_of_address").change(function () {
		var type_of_address=$(this).val();
		arr = type_of_address.split('-');
		//alert(arr[0]);
		//alert(arr[1]);
		if((arr[1]=="CTC"))
		{ 
			$("#basedontype").hide();
			$("#basedontypes").hide();
			$("#basedonpan").hide();
			$("#basedontype2").show();
			$("#aadhar_no").attr("disabled", "disabled"); 
			//$("#gst_no").attr("disabled", "disabled"); 
		} else {
			$("#basedontype").show();
			$("#basedontypes").show();
			$("#basedontype2").hide();
			$("#basedonpan").show();
			$("#aadhar_no").removeAttr("disabled"); 
			//$("#gst_no").removeAttr("disabled"); 
		}
		if((arr[0]==2)) 
		{
			$("#basedonpan").show(); 
		} 		
	});

 $('.editAdd').click(function(){

	clasvar = $(this).attr('class');
	x = clasvar.split(' ');
	id = x[1];
	registration_id = x[2];
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=editAdd&id="+id+"&registration_id="+registration_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){  
								$('#update_comm').html(data);
							 //$("#CommunicationDetails").html(data); 
		$("#add_more").on("click", function(){
			add_more();
		});								 
				}
		});
		
});

$("#country").change(function(){
	country=$("#country").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getCity&country="+country,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
							     $("#stateDiv").html(data);  
							}
		});
 });
 
$("#add_more").click(function(){
    add_more();
	
});

});
</script>
<script>
function add_more(){
	if($("#type_of_address").val()=="none")
   {
   		alert("Please select type of communication address.");
		$("#type_of_address").focus();
		return false;
   }
   if($("#address1").val()=="")
   {
   		alert("Please enter address 1.");
		$("#address1").focus();
		return false;
   }
   if($("#city").val()=="")
   {
   		alert("Please enter city.");
		$("#city").focus();
		return false;
   }
   if($("#country").val()=="")
   {
   		alert("Please select country.");
		$("#country").focus();
		return false;
   }
   if($("#state").val()=="")
   {
   		alert("Please enter state.");
		$("#state").focus();
		return false;
   }
   if($("#other_state").val()=="")
   {
   		alert("Please enter state.");
		$("#other_state").focus();
		return false;
   }
   
   if($("#pincode").val()=="")
   {
   		alert("Please enter pincode.");
		$("#pincode").focus();
		return false;
   }   
   
   var landline_no1=$("#landline_no1").val();
   if(landline_no1=="" || isNaN(landline_no1))
   {
   		alert("Please enter a valid landline number.");
		$("#landline_no1").focus();
		return false;
   }
   
   var mobile_no=$("#mobile_no").val();
   if(mobile_no=="" || isNaN(mobile_no))
   {
   		alert("Please enter a valid mobile number.");
		$("#mobile_no").focus();
		return false;
   }
   
   var mobile_length=mobile_no.length
   if(mobile_length<10)
   {
   	    alert("Please enter at least 10 digit mobile number.");
		$("#mobile_no").focus();
		return false;
   }
   
		email=$("#email_id").val();
		var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if(!emailPattern.test(email))
		{
			alert("Enter Valid Email Id!");
			$("#email_id").focus();
			return false;
		}
		if($("#din_no").val()=="")
	    {
			alert("Please enter DIN No.");
			$("#din_no").focus();
			return false;
	    }
	   
	    if($("#pan_no").val()=="" && $("#pan_no").is(":visible"))
	    {
			alert("Please enter PAN No.");
			$("#pan_no").focus();
			return false;
	    }  
   
	   /* if($("#aadhar_no").val()=="" && $("#aadhar_no").is(":visible"))
	    {
			alert("Please Enter Aadhar No.");
			$("#aadhar_no").focus();
			return false;
	    } */
		
		var gst_no=$("#gst_no").val();
		if(gst_no=="" && $("#gst_no").is(":visible"))
		{
			alert("Please Enter a valid GSTIN.");
			$("#gst_no").focus();
			return false;
		}
   
		var gst_length=gst_no.length
		if(gst_length<15 && $("#gst_no").is(":visible"))
		{
			alert("Please Enter 15 digit GSTIN.");
			$("#gst_no").focus();
			return false;
		}
	   
		var gstinformat = /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/;
		if(!gstinformat.test(gst_no) && $("#gst_no").is(":visible")) {  
			alert('Please Enter Valid GSTIN Numbers');        
			$("#gst_no").focus();
			return false;
		}
	
   /*
	var reggst = /^([0][1-9]|[1-2][0-9]|[3][0-7])([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})+$/;
	if(!reggst.test(gst_no) && gst_no!=''){
        alert('GST Identification Number is not valid. It should be in this "11AAAAA1111Z1A1" format');
		$("#gst_no").focus();
		return false;
	} */
   
   /*
   function check_Alpha(letters){
    var regex = /^[a-zA-Z]+$/;
    if(regex.test(letters.yourname.value) == false){
   alert("Name must be in alphabets only");
   $("#gst_no").focus();
   return false;
    }
    if(letters.yourname.value == " "){
      alert("Name Field cannot be left empty");
      letters.yourname.focus();
      return false;
    }
    return true;
  } */
  
   
	comaddress=$("#comaddress").serialize();
	//alert(comaddress);return false;
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=comaddress&comaddress="+comaddress,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){ //alert(data);
							 //$("#comaddress")[ 0 ].reset();
							 //$("#CommunicationDetails").html(data);  
							 $(location).attr('href','communication_form.php');
							 
							}
		});

}
</script>

<script>
$('.deleteAdd').on('click',function(){
	clasvar = $(this).attr('class');
	x = clasvar.split(' ');
	id = x[1];
	registration_id = x[2];
	var confrm=window.confirm('Are you sure you want to Delete.')
	if(confrm==true){
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=deleteAdd&id="+id+"&registration_id="+registration_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							 $("#CommunicationDetails").html(data);  
							}
		});
		}
		else
		{
			return false;
		}
});
</script>

<script>

</script>

<script type="text/javascript">
function validate()
{
  	if (!$("input[name='panel_name']:checked").length > 0){
		$('#panel_msg').html('Please choose a panel');
		return false;
	}
	 if (!$("input[id='list_of_document']:checked").length > 0){
        $('#doc_msg').html('Please select one of the document');
		return false;
		}
	 if (!$("input[id='export_product_name']:checked").length > 0){
	    $('#exp_msg').html('Please select name of export products');
		return false;
	 }
}
</script>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title">
			<h4>My Account - Membership & RCMC - Communication Form</h4>
		</div>
	</div>

	<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
		<?php include 'include/regMenu.php'; ?>
	</div>
   
	<div class="col-md-8 col-sm-8 col-xs-12  speakerSelector">
		<div class="sub_head minibuffer">Communication Details</div>
<?php 
if($_SESSION['succ_msg']!=""){
echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
$_SESSION['succ_msg']="";
}

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

if($_SESSION['error_msg1']!="" || $_SESSION['error_msg2']!="" || $_SESSION['error_msg3']!="" || $_SESSION['error_msg4']!=""){
echo "<div class='alert alert-warning' role='alert'>";
if($_SESSION['error_msg1']!="")
{
echo $_SESSION['error_msg1']."<br>";
}

if($_SESSION['error_msg2']!="")
{
echo $_SESSION['error_msg2']."<br>";
}

if($_SESSION['error_msg3']!="")
{
echo $_SESSION['error_msg3']."<br>";
}

if($_SESSION['error_msg4']!="")
{
echo $_SESSION['error_msg4'];
}

echo "</div>";
$_SESSION['error_msg1']="";
$_SESSION['error_msg2']="";
$_SESSION['error_msg3']="";
$_SESSION['error_msg4']="";
}
?> 
		<table class="table">
			<thead>
				<tr>
					<th>TYPE</th>
					<th width="50%">ADDRESS</th>
					<th>NAME</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody id="CommunicationDetails">
		<?php 
	   	$query=mysql_query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."'");
		while($result=mysql_fetch_array($query)){
	    ?>
				<tr>
					<td><?php echo getaddresstype($result['type_of_address']);?></td>
					<td><?php echo $result['address1'];?>,<?php echo $result['address2'];?>,<?php echo $result['city'];?>,<?php echo getState($result['state']);?>,<?php echo $result['pincode'];?></td>
					<td><?php echo $result['name'];?></td>
					<?php  if($chk_com_aprv!='Y'){?>
					<td class="editAdd <?php echo $result['id'];?> <?php echo $_SESSION['USERID'];?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>EDIT</td>
					<?php }?>
				</tr>
		<?php } ?>		
			</tbody>
		</table>
<?php 
   $sql="SELECT * FROM `registration_master` WHERE 1 and id='$registration_id'";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	$name=$rows['first_name']." ".$rows['last_name'];
	$designation=$rows['designation'];
	$email_id=$rows['email_id'];
	$address1=$rows['address_line1'];
	$address2=$rows['address_line2'];
	$address3=$rows['address_line3'];
	$country=$rows['country'];
	$state=$rows['state'];
	$land_line_no=$rows['land_line_no'];
	$city=$rows['city'];
	$mobile_no=$rows['mobile_no'];
?>
<div id="update_comm">
<?php
if($type_of_firm==14){$addflag=1;}  /* For SAP */
else if($type_of_firm==11){$addflag=2;}
else if($type_of_firm==13){$addflag=3;}
else if($type_of_firm==12){$addflag=4;}
else if($type_of_firm==15){$addflag=5;}
else if($type_of_firm==18){$addflag=6;}
else if($type_of_firm==17){$addflag=7;}
else if($type_of_firm==16){$addflag=8;}
else if($type_of_firm==19){$addflag=9;}
/*
if($type_of_firm=="Proprietory"){$addflag=1;}
else if($type_of_firm=="Partnership"){$addflag=2;}
else if($type_of_firm=="Private Ltd"){$addflag=3;}
else if($type_of_firm=="Public Ltd"){$addflag=4;}
else if($type_of_firm=="Proprietory HUF"){$addflag=5;}
else if($type_of_firm=="Individual"){$addflag=6;}
else if($type_of_firm=="Trustees"){$addflag=7;}
else if($type_of_firm=="Co-Op Society"){$addflag=8;}
else if($type_of_firm=="Others"){$addflag=9;}
*/
?>
<form id="comaddress" name="comaddress" class="form-block minibuffer">
<input type="hidden" name="hidden" id="hidden" value=""/>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="type_of_address">Type of Communication Address :</label></div>
				<div class="col-md-6">
					<select class="form-control" id="type_of_address" name="type_of_address">
					<option value="none">----Select----</option>
					<?php
					$stype_of_address=getCommunicationAddress($addflag);
					$result=mysql_query($stype_of_address);
					while($rows=mysql_fetch_array($result))
					{
						echo "<option value='$rows[id]-$rows[address_identity]'>$rows[type_of_comaddress_name]</option>";
					}
					?>
					</select>
				</div>
			</div>
			<div style="display:none;" id="basedontype">
			<div class="form-group row" class="propname">
				<div class="col-md-6"><label class="form-label" for="name">Name :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>" placeholder="Name" autocomplete="off"/> </div>
			</div>
			<!--<div class="form-group row" class="propname">
				<div class="col-md-6"><label class="form-label" for="father_name">Father's Name :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" id="father_name" name="father_name" placeholder="Father's Name" autocomplete="off"> </div>
			</div>-->
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="address1">Address Line 1 :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" id="address1" name="address1" value="<?php echo $address1;?>" placeholder="Address Line 1" autocomplete="off"> </div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="address2">Address Line 2 :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" id="address2" name="address2" value="<?php echo $address2;?>" placeholder="Address Line 2" autocomplete="off"> </div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="address3">Address Line 3 :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" id="address3" name="address3" value="<?php echo $address3;?>" placeholder="Address Line 3" autocomplete="off"> </div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="city">City :</label></div>
				<div class="col-md-6"> <input type="text" class="form-control" id="city" name="city" value="<?php echo $city;?>" placeholder="City" autocomplete="off"> </div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="country">Country :</label></div>
				<div class="col-md-6"> 
				<select class="form-control" name="country" id="country">
				<!--<option value="">---------- Select Country----------</option>-->
				<?php 
				$query=mysql_query("SELECT * FROM country_master where country_code='IN'");
				while($result=mysql_fetch_array($query)){
				?>
				<option value="<?php echo $result['country_code'];?>" <?php if($result['country_code']==$country){?> selected="selected" <?php } else if($result['country_code']=="IN"){?> selected="selected"<?php }?>><?php echo $result['country_name'];?></option>
				<?php }?>
				</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="state">State</label></div>
				<div class="col-md-6" id="stateDiv">
					<select name="state" id="state" class="form-control">
					<option value="">-- Select State --</option>
					<?php 
					$query=mysql_query("SELECT * from state_master WHERE country_code = 'IN'");
					while($result=mysql_fetch_array($query)){?>
					<option value="<?php echo $result['state_code'];?>"  <?php if($result['state_code']==$state){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
					<?php }?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="pincode">Pin Code :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="pincode" name="pincode" value="<?php echo $pin_code;?>" placeholder="Pin Code" autocomplete="off" onKeyPress="if(this.value.length==6) return false;"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="landline_no1">Landline No :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="landline_no1" name="landline_no1" value="<?php echo $landline_no;?>" placeholder="Landline No" maxlength="15" autocomplete="off"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="mobile_no">Mobile No. :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $mobile_no;?>" placeholder="Mobile No." onKeyPress="if(this.value.length==12) return false;" autocomplete="off"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="mobile_no">Email :</label></div>
				<div class="col-md-6"><input type="email" class="form-control" value="<?php echo $email_id;?>" id="email_id" name="email_id" placeholder="Email" autocomplete="off"></div>
			</div>
			<?php
			if($type_of_firm==13 || $type_of_firm==12){
			?>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="din_no">DIN No. :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="din_no" name="din_no" value="<?php echo $din_no;?>" placeholder="DIN No." autocomplete="off"></div>
			</div>
			<?php } ?>
			<div style="display:none;" id="basedonpan">
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="pan_no">Pan No. :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="pan_no" name="pan_no" value="<?php echo $pan_no;?>" placeholder="Pan No." maxlength="10" autocomplete="off"/></div>
			</div>
			</div>
			
			<div style="display:none;" id="basedontypes">
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="Aadhar">Aadhar No :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="aadhar_no" name="aadhar_no" value="<?php echo $aadhar_no;?>" maxlength="15" placeholder="Aadhar No" autocomplete="off"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="Passport">Passport No. :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="passport_no" name="passport_no" value="<?php echo $passport_no;?>" maxlength="10" placeholder="Passport No" autocomplete="off"></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="joining_date">Joining Date :</label></div>
				<div class="col-md-6"><input type="date" class="form-control" value="<?php echo $joining_date;?>" id="joining_date" name="joining_date" placeholder="Joining Date" autocomplete="off"/></div>
			</div>
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="retirement_date">Retirement Date :</label></div>
				<div class="col-md-6"><input type="date" class="form-control" value="<?php echo $retirement_date;?>" id="retirement_date" name="retirement_date" placeholder="Retirement Date" autocomplete="off"/></div>
			</div>
			</div>
			<div style="display:none;" id="basedontype2">
			<div class="form-group row">
				<div class="col-md-6"><label class="form-label" for="gst_no">GSTIN :</label></div>
				<div class="col-md-6"><input type="text" class="form-control" id="gst_no" name="gst_no" value="<?php echo $gst_no;?>" placeholder="GSTIN" maxlength="15" autocomplete="off"/></div>
			</div>
			</div>
			<div class="row"><div class="col-md-12"><label class="form-label"/>Note- : Fill up name of all present partners and directores as the case may be</label></div></div>
			<input type="hidden" id="registration_id" name="registration_id" value="<?php echo $_SESSION['USERID'];?>"/>
			<div class="row">
				<div class="col-md-12">
				<?php if($chk_com_aprv!='Y'){?><input type="button" value="Add More" name="add_more" id="add_more" class="btn"/><?php } ?>
				</div>
			</div>
		
		</form>
</div>

		<form id="communicationForm" name="communicationForm" method="post" onSubmit="return validate()">
			
			<div class="form-block">
				<div class="sub_head minibuffer">Panel</div> <span class="error" id="panel_msg"></span><br/>
				Note : Indicate ONE PANEL of export from the following under which you wish to enrol yourself as member (to represent at the time of election)
				<div class="form-group row">
					<div class="col-md-12"><label class="form-label">Panel Details</label></div>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group radio inline-form">
								<label class="col-md-12" for="cg"><input type="radio" name="panel_name" id="panel_name" value="Coloured Gemstones" <?php if($panel_name!=''){ if($panel_name=='Coloured Gemstones'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Coloured Gemstones</label>
								
								<label class="col-md-12" for="cfj"><input type="radio" name="panel_name" id="panel_name" value="Costume/Fashion Jewellery" <?php if($panel_name!=''){ if($panel_name=='Costume/fashion Jewellery'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Costume/Fashion Jewellery</label>
								
								<label class="col-md-12" for="dia"><input type="radio" name="panel_name" id="panel_name" value="Diamonds" <?php if($panel_name!=''){ if($panel_name=='Diamonds'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Diamonds</label>
								
								<label class="col-md-12" for="gj"><input type="radio" name="panel_name" id="panel_name" value="Gold Jewellery" <?php if($panel_name!=''){ if($panel_name=='Gold Jewellery'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Gold Jewellery</label>
								
								<label class="col-md-12" for="none"><input type="radio" name="panel_name" id="panel_name" value="Not Indicated" <?php if($panel_name!=''){ if($panel_name=='Not Indicated'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Not Indicated</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group radio inline-form">
								<label class="col-md-12" for="pearls"><input type="radio" name="panel_name" id="panel_name" value="Pearls" <?php if($panel_name!=''){ if($panel_name=='Pearls'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Pearls</label>
								
								<label class="col-md-12" for="stf"><input type="radio" name="panel_name" id="panel_name" value="Sales To Foreign Tourists" <?php if($panel_name!=''){ if($panel_name=='Sales To Foreign Tourists'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Sales To Foreign Tourists</label>
								<label class="col-md-12" for="ss"><input type="radio" name="panel_name" id="panel_name" value="Synthetic Stones" <?php if($panel_name!=''){ if($panel_name=='Synthetic Stones'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Synthetic Stones</label>
								
								<label class="col-md-12" for="sj"><input type="radio" name="panel_name" id="panel_name" value="Silver" <?php if($panel_name!=''){ if($panel_name=='Silver'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Silver Jewellery</label>
								
								<label class="col-md-12" for="opm"><input type="radio" name="panel_name" id="panel_name" value="Other Precious Metal Jewellery" <?php if($panel_name!=''){ if($panel_name=='Other Precious Metal Jewellery'){echo "checked='checked'";}else{?> disabled="disabled" <?php } } else { } ?>/>Other Precious Metal Jewellery</label>
							</div>
						</div>
					</div>
				</div>				
			</div>

			<div class="form-block">
				<div class="sub_head minibuffer">Referral Of GJEPC</div>

				<div class="form-group row">
					<div class="col-md-6"><label class="form-label" for="refer_membership_id">Membership ID (Eg. GXXXXX):</label></div>
					<div class="col-md-6"><input type="text" class="form-control" id="refer_membership_id" name="refer_membership_id" value="<?php echo $refer_membership_id; ?>" placeholder="Membership ID"></div>
				</div>

				<div class="form-group row">
					<div class="col-md-6"><label class="form-label" for="refer_firm_name">Name of the Firm:</label></div>
					<div class="col-md-6"><input type="text" class="form-control" name="refer_firm_name" id="refer_firm_name" value="<?php echo $refer_firm_name; ?>" placeholder="Name of the Firm"></div>
				</div>				
			</div>

			<div class="form-block">
				<div class="sub_head minibuffer">List of documents to be submitted</div>

				<div class="form-group row">
					<div class="col-md-12"><label class="form-label">List of documents</label></div>
					<?php 
					if($member_type_id==5 && $type_of_firm=14){$flag=1;}
					if($member_type_id==5 && $type_of_firm==11){$flag=2;}
					if($member_type_id==6 && $type_of_firm==14){$flag=3;}
					if($member_type_id==6 && $type_of_firm==13){$flag=4;}
					?>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group radio inline-form">
								<label class="col-md-12" for="maa"><input type="checkbox" name="list_of_document[]" id="list_of_document" value="Memorandum and Articles of Association" <?php if(preg_match('/Memorandum and Articles of Association/',$list_of_document)){ echo ' checked="checked"'; }?> <?php if($flag==1 || $flag==2 || $flag==3){?> disabled="disabled" <?php }?>>Memorandum and Articles of Association</label>
								<label class="col-md-12" for="ssic"><input type="checkbox" name="list_of_document[]" id="list_of_document" value="Small Scale Industries certificate (SSI)" <?php if(preg_match('/Small Scale Industries certificate (SSI)/',$list_of_document)){ echo ' checked="checked"'; } ?> <?php if($flag==1 || $flag==2){?> disabled="disabled" <?php }?>>Small Scale Industries certificate (SSI)</label>
								<label class="col-md-12" for="pd"><input type="checkbox" name="list_of_document[]" id="list_of_document" value="Partnership deed" <?php if(preg_match('/Partnership deed/',$list_of_document)){ echo ' checked="checked"'; } ?> <?php if($flag==1 || $flag==3){ ?> disabled="disabled" <?php }?>>Partnership deed</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group radio inline-form">
								<label class="col-md-12" for="ieccert"><input type="checkbox" name="list_of_document[]" id="list_of_document" value="IEC Certificate" <?php if(preg_match('/IEC Certificate/',$list_of_document)){ echo 'checked="checked"'; } ?> />IEC Certificate</label>
								<label class="col-md-12" for="iemcert"><input type="checkbox" name="list_of_document[]" id="list_of_document" value="IEM certificate" <?php if(preg_match('/IEM certificate/',$list_of_document)){ echo 'checked="checked"'; } ?> <?php if($flag==1 || $flag==2|| $flag==3){?> disabled="disabled" <?php }?> >IEM certificate</label>
							</div>
						</div>
					</div>
				</div>				
			</div>

			<div class="form-block">
				<div class="sub_head minibuffer">Other Authority Details</div>

				<div class="form-group row">
					<div class="col-md-6"><label class="form-label" for="authority_firm_name">Name of any other authority with whom the firm is registered:</label></div>
					<div class="col-md-6"><input type="text" class="form-control" name="authority_firm_name" id="authority_firm_name" value="<?php echo $authority_firm_name; ?>" placeholder="Name of any other authority" autocomplete="off"></div>
				</div>

				<div class="form-group row">
					<div class="col-md-6"><label class="form-label" for="authority_firm_registration_no">Registration No:</label></div>
					<div class="col-md-6"><input type="text" class="form-control" name="authority_firm_registration_no" id="authority_firm_registration_no" value="<?php echo $authority_firm_registration_no; ?>" placeholder="Registration No" autocomplete="off"></div>
				</div>

				<div class="form-group row">
					<div class="col-md-6"><label class="form-label" for="authority_registration_date">Registration Date:</label></div>
					<div class="col-md-6"><input type="text" class="form-control" name="authority_registration_date" id="authority_registration_date" value="<?php echo $authority_registration_date;?>" autocomplete="off"/></div>
				</div>

				<div class="form-group row">
					<div class="col-md-6"><label class="form-label" for="authority_registration_valid_upto">Valid upto:</label></div>
					<div class="col-md-6"><input type="text" class="form-control" name="authority_registration_valid_upto" id="authority_registration_valid_upto" value="<?php echo $authority_registration_valid_upto;?>" autocomplete="off"/></div>
				</div>				
			</div>

			<div class="form-block">
				<div class="sub_head minibuffer">Name of export products under which registration is required</div>

				<div class="form-group row">
					<div class="col-md-12"><label class="form-label">Export products</label><span id="exp_msg"></span></div>
					<div class="col-md-12">
						<div class="col-md-6">
							<div class="form-group radio inline-form">
								<label class="col-md-12" for="ppp"><input type="checkbox" name="export_product_name[]" id="export_product_name" value="Polished & Processed Pearls" <?php if(preg_match('/Polished & Processed Pearls/',$export_product_name) || $member_type_id==5){ echo ' checked="checked"'; } ?>/>Polished & Processed Pearls</label>
								<label class="col-md-12" for="cpd"><input type="checkbox" name="export_product_name[]" id="export_product_name" value="Cut & Polished Diamonds" <?php if(preg_match('/Cut & Polished Diamonds/',$export_product_name) || $member_type_id==5){ echo ' checked="checked"'; } ?>>Cut & Polished Diamonds</label>
								<label class="col-md-12" for="cpcg"><input type="checkbox" name="export_product_name[]" id="export_product_name" value="Cut & Polished Coloured Gemstones" <?php if(preg_match('/Cut & Polished Coloured Gemstones/',$export_product_name) || $member_type_id==5){ echo ' checked="checked"'; } ?>>Cut & Polished Coloured Gemstones</label>
								<label class="col-md-12" for="jcg"><input type="checkbox" name="export_product_name[]" id="export_product_name" value="Jewellery containing gold" <?php if(preg_match('/Jewellery containing gold/',$export_product_name) || $member_type_id==5){ echo ' checked="checked"'; } ?>>Jewellery containing gold</label>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group radio inline-form">
								<label class="col-md-12" for="cps"><input type="checkbox" name="export_product_name[]" id="export_product_name" value="Cut & Polished Synthetic stone" <?php if(preg_match('/Cut & Polished Synthetic stone/',$export_product_name) || $member_type_id==5){ echo ' checked="checked"'; } ?>>Cut & Polished Synthetic stone</label>
								<label class="col-md-12" for="cfj"><input type="checkbox" name="export_product_name[]" id="export_product_name" value="Costume Fashion Jewellery" <?php if(preg_match('/Costume Fashion Jewellery/',$export_product_name) || $member_type_id==5){ echo ' checked="checked"'; } ?>>Costume / Fashion Jewellery</label>
								<label class="col-md-12" for="sjsf"><input type="checkbox" name="export_product_name[]" id="export_product_name" value="Silver Jewellery & Silver Filligree" <?php if(preg_match('/Silver Jewellery & Silver Filligree/',$export_product_name) || $member_type_id==5){ echo ' checked="checked"'; } ?>>Silver Jewellery & Silver Filligree</label>
								<label class="col-md-12" for="rd"><input type="checkbox" name="export_product_name[]" id="export_product_name" value="Rough Diamonds" <?php if(preg_match('/Rough Diamonds/',$export_product_name) || $member_type_id==5){ echo ' checked="checked"'; } ?>>Rough Diamonds</label>
							</div>
						</div>
					</div>
				</div>				
			</div>

			<div class="row">
				<div class="col-md-12">
<input type="hidden" name="action" value="update" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $_SESSION['USERID'];?>" />
<?php if($chk_com_aprv!='Y'){?><input type="submit" class="btn"  value="Save" /><?php }?>
				
				</div>
			</div>
		</form>
	</div>
<?php include 'include/footer.php'; ?>