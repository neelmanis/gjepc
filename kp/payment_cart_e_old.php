<?php include('header_include.php');?>
<?php include('chk_login.php');?>
<?php 
	  $membertype=$_SESSION['MEMBERTYPE'];
	  if($membertype=="Agent"){
		$APPLICANT_ID=$_SESSION['AGENT_ID'];
		$APPLICANT_ADD1=getAgentAdd1($APPLICANT_ID);
		$APPLICANT_ADD2=getAgentAdd2($APPLICANT_ID);
		$APPLICANT_ADD3=getAgentAdd3($APPLICANT_ID);
		$PHONE=getAgentPhone($APPLICANT_ID);
		$EMAIL=getAgentEmail($APPLICANT_ID);
	  }
	  else if($membertype=="Member"){
		$APPLICANT_ID=$_SESSION['MEMBER_ID'];
		$APPLICANT_ADD1=getMemberAdd1($APPLICANT_ID);
		$APPLICANT_ADD2=getMemberAdd2($APPLICANT_ID);
		$APPLICANT_ADD3=getMemberAdd3($APPLICANT_ID);
		$PHONE=getMemberPhone($APPLICANT_ID);
		$EMAIL=getMemberEmail($APPLICANT_ID);
	  }
	  else if($membertype=="NonMember"){
		$APPLICANT_ID=$_SESSION['NON_MEMBER_ID']; 
		$APPLICANT_ADD1=getNonMemberAdd1($APPLICANT_ID);
		$APPLICANT_ADD2=getNonMemberAdd2($APPLICANT_ID);
		$APPLICANT_ADD3=getNonMemberAdd3($APPLICANT_ID);
		$PHONE=getNonMemberPhone($APPLICANT_ID);
		$EMAIL=getNonMemberEmail($APPLICANT_ID);	
	  }

?>
<?php
$action=$_REQUEST['action'];
if($action=="save")
{ 
$APPLICANT_ID=$_REQUEST['APPLICANT_ID'];
$MEMBERTYPE=$_REQUEST['MEMBERTYPE'];
$PAYMENT_TYPE=$_REQUEST['Payment_Mode'];
$PAYEE_BANK=mysql_real_escape_string($_REQUEST['Bank']);
$PAYMENT_AMOUNT=$_REQUEST['Total_Amount'];
$APPLICANT_NAME=$_SESSION['USERNAME'];

$ENTERED_ON=date('Y-m-d H:i:s');
$ENTERED_BY=$_SESSION['USERNAME'];
$MODIFIED_ON=date('Y-m-d H:i:s');
$MODIFIED_BY=$_SESSION['USERNAME'];
$CURRENCY_CODE="INR";
$CURRENCY_VAL="356";

$BILLING_TO=$_REQUEST['BILLING_TO'];
$PAYEE_BRANCH=$_REQUEST['Branch'];
$CHEQUE_NO=$_REQUEST['Cheque_No'];
$CHEQUE_DATE=date('Y-m-d',strtotime($_REQUEST['Cheque_Date']));
$STATUS="88";
$FORM_TYPE="E";

	$sql="insert into kp_payment_master set MEMBERTYPE='$MEMBERTYPE',APPLICANT_ID='$APPLICANT_ID',PAYMENT_TYPE='$PAYMENT_TYPE',PAYEE_BANK='$PAYEE_BANK',PAYMENT_AMOUNT='$PAYMENT_AMOUNT',APPLICANT_NAME='$APPLICANT_NAME',APPLICANT_ADD1='$APPLICANT_ADD1',APPLICANT_ADD2='$APPLICANT_ADD2',PHONE='$PHONE',EMAIL='$EMAIL',ENTERED_ON='$ENTERED_ON',ENTERED_BY='$ENTERED_BY',MODIFIED_ON='$MODIFIED_ON',MODIFIED_BY='$MODIFIED_BY',CURRENCY_CODE='$CURRENCY_CODE',CURRENCY_VAL='$CURRENCY_VAL',PAYEE_BRANCH='$PAYEE_BRANCH',BILLING_TO='$BILLING_TO',CHEQUE_NO='$CHEQUE_NO',CHEQUE_DATE='$CHEQUE_DATE',STATUS='$STATUS',FORM_TYPE='$FORM_TYPE'";
	mysql_query($sql);
	$PAYMENT_MST_ID=mysql_insert_id();

	$export_app_id1=$_REQUEST['export_app_id1'];
	$_SESSION['export_size']=sizeof($export_app_id1);
	$i=0;
	foreach($export_app_id1 as $val)
    {
		 $_SESSION['export_app_id'.$i]=$val;
		 $query=mysql_query("select max(RECIEPT_NO) as RECIEPT_NO ,max(TRAN_ID) as TRAN_ID from kp_payment_details");
		 $result=mysql_fetch_array($query);
		 $RECIEPT_NO=$result['RECIEPT_NO']+1;
		 $TRAN_ID=$result['TRAN_ID']+1;
		 $query1=mysql_query("select MEMBER_TYPE_ID ,MEMBER_ID from kp_export_application_master where EXPORT_APP_ID='$val'");
		 $result1=mysql_fetch_array($query1);
		 $MEMBER_TYPE_ID=$result1['MEMBER_TYPE_ID'];
		 if($MEMBER_TYPE_ID=="18"){
		 $MEMBER_ID=$result1['MEMBER_ID'];
		 }
		 else
		 {
		 	$MEMBER_ID=$result1['NON_MEMBER_ID'];
		 }
		
		 mysql_query("insert into kp_payment_details set EXPORT_APP_ID='$val',PAYMENT_MST_ID='$PAYMENT_MST_ID',RECIEPT_NO='$RECIEPT_NO',APPLICANT_ID 	='$APPLICANT_ID',MEMBER_TYPE_ID='$MEMBER_TYPE_ID',MEMBER_ID='$MEMBER_ID',FORM_TYPE='E',TRAN_ID='$TRAN_ID'");
		 
		 mysql_query("update kp_export_application_master set payment_made_status='Y',KP_PAYMENT_ID='$PAYMENT_MST_ID' where EXPORT_APP_ID='$val'"); 
		 $i++;
	}
	$_SESSION['succ_msg']="Payment Made Successfully";
	header('location:payment_cart_e.php');
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>About GJEPC | Kimberly Process | Search Applications | Payment Cart </title>

<!-- Main css -->
<?php include ('maincss.php') ?>

<!-- Member lightbox Thum -->
<script type="text/javascript">
		$(document).ready(function() {
			$("#example1-1").imgbox();

			$("#example1-2").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-4").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-5").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-6").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-7").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-8").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-9").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			$("#example1-10").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			})
			;$("#example1-11").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			;$("#example1-12").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			;$("#example1-13").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});
			;$("#example1-14").imgbox({
			    'zoomOpacity'	: true,
				'alignment'		: 'center'
			});

			//$("#example1-3").imgbox({
//				'speedIn'		: 0,
//				'speedOut'		: 0
//			});
//
//			$("#example2-1, #example2-2").imgbox({
//				'speedIn'		: 0,
//				'speedOut'		: 0,
//				'alignment'		: 'center',
//				'overlayShow'	: true,
//				'allowMultiple'	: false
//			});
		});
	</script>
<script type="text/javascript" src="imgbox/jquery.min.js"></script>
<script type="text/javascript" src="imgbox/jquery.imgbox.pack.js"></script>
<link rel="stylesheet" href="imgbox/imgbox.css" /> 
<!-- Member lightbox Thum -->
<!-- Main css -->
<script src="jsvalidation/jquery.js" type="text/javascript"></script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/cmxform.css" /> 
<script type="text/javascript">
$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	// validate signup form on keyup and submit
	$("#form1").validate({
		rules: {  
			newpassword: {
				required: true,
				minlength: 6
			},  
			cnfrmpassword:{
			 required: true,
			 equalTo: "#newpassword"
			}
		},
		messages: {
			newpassword: {
				required: "Please enter your new password",
				minlength: "password should not less than 6 characters"
			},
			cnfrmpassword: {
				required: "Please enter your confirm password",
				equalTo: "Please enter the same password as above"
			} 
	 }
	});
});
</script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>
<script>
$("input:checked").live('change', function(){ 
   var allVals = [];
   $("input[name='export_app_id1[]']:checked").each( function () {
       allVals.push($(this).val());
   });
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getAmount&myCheckboxes="+allVals,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     //alert(data);
								if (data.indexOf("error") >= 0)
								 {
								 	alert("Location should be same for Payment");
									$(location).attr('href','payment_cart_e.php');
								 }
								 else
								 {
								 	 $('#Total_Amount').val(data); 
								 }
							    
							}
		});
});

</script>
<script>
$("#Bank_Branch").live('change', function(){
var bank_id=$("#Bank_Branch").val();
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=getbranch&bank_id="+bank_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
								var data=data.split("#");
								$('#Bank').val(data[0]); 
								$('#Branch').val(data[1]); 
							}
		});
 });
</script>

<script>
$("#delete_importer").live('click', function(){
var chks = document.getElementsByName('export_app_id1[]');
	var hasChecked = false;
	for (var i = 0; i < chks.length; i++)
	{
		if (chks[i].checked)
	{
	hasChecked = true;
	break;
	}
	}
	
	if (hasChecked == false)
	{
	alert("Please select at least one.");
	return false;
	}


 var allVals = [];
   $("input[name='export_app_id1[]']:checked").each( function () {
       allVals.push($(this).val());
   });
	$.ajax({ type: 'POST',
					url: 'ajax.php',
					data: "actiontype=deleteImporter&EXPORT_APP_ID="+allVals,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
						//alert(data);
						$(location).attr('href','payment_cart_i.php');
						}
		});
 });
</script>

<script language="javascript">
function checkdata()
{
	var chks = document.getElementsByName('export_app_id1[]');
	var hasChecked = false;
	for (var i = 0; i < chks.length; i++)
	{
		if (chks[i].checked)
	{
	hasChecked = true;
	break;
	}
	}
	
	if (hasChecked == false)
	{
	alert("Please select at least one.");
	return false;
	}
	if ( ( document.form2.Payment_Mode[0].checked == false ) && (document.form2.Payment_Mode[1].checked == false ) && (document.form2.Payment_Mode[2].checked == false ) )
	{
		alert ( "Please choose a payment mode");
		return false;
	}
	if(document.form2.Cheque_No.value=='')
	{
		alert("Please enter Cheque/DD details")
		document.form2.Cheque_No.focus();
		return false
	}
	if(document.form2.Cheque_Date.value=='')
	{
		alert("Please enter Cheque Date")
		document.form2.Cheque_Date.focus();
		return false
	}
	
	if(document.form2.Bank_Branch.value=='')
	{
		alert("Please select Bank Branch")
		document.form2.Bank_Branch.focus();
		return false
	}
}	
</script>

<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('export_app_id[]');
  for(var i in checkboxes)
    checkboxes[i].checked = source.checked;
}
</script>

</head>

<body>
<!-- main -->
<div class="main">

<!-- Top -->
<?php include ('top.php') ?>
<!-- Top -->


<div class="inner_mainwidth">


<div class="online_business_banner">

<!-- Midle Bg -->
<div class="midletable_img"><img src="images/inner_top_bg_new.png" /></div>
<div class="inner_midle_bg">
<div class="text_heading">Payment Cart</div>
<div class="text_bread1"><a href="kimberley_process_search_applications.php">Home</a> > Kimberley Process > Payment Cart</div>
<div class="clear"></div>
<!-- Midle -->
<div class="midletext">
<!-- Left Table -->
<form action="" method="post" onsubmit="return checkdata()" name="form2" id="form2" >
<div class="righttable_css">
<div class="clear"></div>
<!-- div -->
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."<br>";
echo "your Application ID is:";
for($i=0;$i<=$_SESSION['export_size'];$i++)
{
	echo $_SESSION['export_app_id'.$i]."<br>";
	
	$_SESSION['export_app_id'.$i]="";
}
echo "</span>";
$_SESSION['export_size']="";
$_SESSION['succ_msg']="";
}
?>
<div class="search_app_div">
<strong>Note :</strong> Payment for multiple transactions can be done only for same locations.
</div>

<div class="search_app_div">
<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-color:#ccc; " >
  <tr align="center" bgcolor="#EEEEEE">
    <td width="12%" height="35" align="center"><div class="chexbox11"><!--<input name="check_all" id="check_all" type="checkbox" value="" onClick="toggle(this)"  />--></div></td>
    <td width="15%" align="center"><strong>Application Date</strong></td>
    <td width="24%" align="center"><strong>Member Name</strong></td>
    <td width="13%" align="center"><strong>Application Fees</strong></td>
    <td width="12%" align="center"><strong>Courier Amount</strong></td>
    <td width="12%" align="center"><strong>Total Amount</strong></td>
    <td width="12%" align="center"><strong>Location</strong></td>
    <td width="12%" align="center"><strong>Action</strong></td>
  </tr>
  
	<?php 
    if(isset($_SESSION['AGENT_ID'])){
	$member_id=$_SESSION['AGENT_ID'];
    $sql_import_pending="select  * from kp_export_application_master where AGENT_ID='".$_SESSION['AGENT_ID']."' and FORM_TYPE='E' and payment_made_status='N' order by ENTERED_ON desc";
    }
    else if(isset($_SESSION['MEMBER_ID'])){
	$member_id=$_SESSION['MEMBER_ID'];
    $sql_import_pending="select * from kp_export_application_master where MEMBER_ID='".$_SESSION['MEMBER_ID']."' and FORM_TYPE='E' and payment_made_status='N' order by ENTERED_ON desc";
    }
    else if($_SESSION['NON_MEMBER_ID']){
	$member_id=$_SESSION['NON_MEMBER_ID'];
    $sql_import_pending="select * from kp_export_application_master where NON_MEMBER_ID='".$_SESSION['NON_MEMBER_ID']."' and FORM_TYPE='E' and payment_made_status='N' order by ENTERED_ON desc";
    }
    $query_import_pending=mysql_query($sql_import_pending);
	
    while($result_import_pending=mysql_fetch_array($query_import_pending)){
    ?>
  <tr align="center">
    <td height="30" align="center"><div class="chexbox11"><input name="export_app_id1[]" id="export_app_id" type="radio" value="<?php echo $result_import_pending['EXPORT_APP_ID'];?>" />
    </div>
    </td>
    <td align="center"><?php echo date("d-m-Y",strtotime($result_import_pending['ENTERED_ON']));?></td>
    <td align="center">
	<?php 
	if($result_import_pending['MEMBER_TYPE_ID']=='18'){
	echo getMemberName('Member',$result_import_pending['MEMBER_ID']);
	}
	else
	{
	echo getNonMemberName('NonMember',$result_import_pending['NON_MEMBER_ID']);
	}
	?>
    </td>
    <td><?php echo $result_import_pending['FEES_AMOUNT'];?></td>
    <td><?php echo $result_import_pending['COURIER_AMOUNT'];?></td>
    <td><?php echo $result_import_pending['TOTAL_AMOUNT'];?></td>
    <td><?php echo getRegionName($result_import_pending['LOC_PICKUP_ID']);?></td>
    <td><a href="export_application.php?EXPORT_APP_ID=<?php echo $result_import_pending['EXPORT_APP_ID'];?>&action=update">Edit</a></td>
  </tr>
 
  <?php } ?>
  
  <tr>
    <td height="30" align="center"><img src="images/delete.png" id="delete_importer" style="cursor:pointer;" onClick="return(window.confirm('Are you sure you want to delete?'));"; /></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>

</div>
<div class="search_app_div">

</div>
<div class="search_app_div">
<div class="search_app_text1">Payment Mode</div>

<div style=" margin-top:4px;">
<?php 
	$sql="select LOOKUP_VALUE_ID,LOOKUP_VALUE_CODE,LOOKUP_VALUE_NAME from  kp_lookup_details where LOOKUP_ID='15'";
	$result=mysql_query($sql);
	while($rows=mysql_fetch_array($result)){
?>	
<div class="chexbox11"><input name="Payment_Mode" id="Payment_Mode" type="radio" value="<?php echo $rows['LOOKUP_VALUE_ID'];?>" /></div>
<div style="float:left;"><?php echo $rows['LOOKUP_VALUE_NAME'];?></div>
<?php }?>
</div>
<div class="clear"></div>
</div>

<div class="search_app_div"></div>

<div class="search_app_div">Cheque / DD Details</div>

<div class="search_app_div">
<div class="search_app_text1">BILLING TO </div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="BILLING_TO" id="BILLING_TO">
<option selected="selected" value="">--Select--</option>
<option value="agent">Agent</option>
<option value="party">Party</option>
</select>
</div>
<div class="search_app_text1">Bank/Branch</div>
<div class="search_app_bg">
<select  class="search_app_bg_text" name="Bank_Branch" id="Bank_Branch">
<option selected="selected" value="">--Select--</option>
<?php 
	   $sql="select * from  kp_bank_branch_master order by BANK_NAME asc";
	   $result=mysql_query($sql);
	   while($rows=mysql_fetch_array($result))
	   {
	   		echo "<option  value='$rows[BANK_ID]'>$rows[BANK_NAME]/$rows[BRANCH_NAME]</option>";
	   }
?>	
</select>
</div>

<div class="clear"> </div>
</div>
<div class="search_app_div">
<div class="search_app_text1">Bank</div>
<div class="search_app_bg"><input name="Bank" id="Bank" class="search_app_bg_text" type="text" readonly="readonly" /></div>
<div class="search_app_text1">Branch</div>
<div class="search_app_bg"><input name="Branch" id="Branch" class="search_app_bg_text" type="text" readonly="readonly" /></div>
<div class="clear"> </div>
</div>

<div class="search_app_div">
<div class="search_app_text1">Cheque No</div>
<div class="search_app_bg"><input name="Cheque_No" id="Cheque_No" class="search_app_bg_text" type="text" /></div>
<div class="search_app_text1">Cheque Date</div>
<div class="search_app_bg">
<input type="text" name="Cheque_Date" id="popupDatepicker" value=""  class="search_app_bg_text"/>
</div>
<div class="clear"> </div>
</div>

<div class="search_app_div"></div>
<div class="clear"></div>

<div class="search_app_div">
<div class="search_app_text1">Total Amount</div>
<div class="search_app_bg"><input name="Total_Amount" id="Total_Amount" class="search_app_bg_text" type="text" value="" readonly="readonly" /></div>
<div class="clear"></div>
</div>

<div class="search_app_div"></div>

<div class="clear"></div>

<div class="search_app_div">
<div class="search_app_text1"></div>
<div style="float:left; margin-bottom:4px;"><input class="input_bg" type="submit" value="Submit" /></div>
<div style="float:left;  margin-bottom:4px;"><input class="input_bg" type="submit" value="Cancel" /></div>
<input type="hidden" name="MEMBERTYPE" id="MEMBERTYPE" value="<?php echo $_SESSION['MEMBERTYPE'];?>"/>
<input type="hidden" name="APPLICANT_ID" id="APPLICANT_ID" value="<?php echo $APPLICANT_ID;?>"/>
<input type="hidden" name="action" id="action" value="save"/>
</div>
<div class="clear"></div>
<!-- div -->
<div class="clear"></div>
</div>
</form>
<!-- Left Table -->


<!-- Right Table -->
<div class="left_table_gjepc">
<img src="images/advertise_here_1.png" />

</div>
<!-- Right Table -->



<div class="clear"></div>
</div>
<!-- Midle -->

<div class="clear"></div>

</div>
<div class="midletable_img"><img src="images/inner_bottom_bg_new.png" /></div>
<!-- Midle Bg -->
<div class="innerbg_bottom"></div>
<div class="clear"></div>
</div>
<div class="clear"></div>




<!-- Fotter -->
<?php include ('fotter.php') ?>
<!-- Fotter -->
<div class="clear"></div>

</div>
</div>
<!-- main -->

</body>
</html>
