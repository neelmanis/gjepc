<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$adminID=$_SESSION['curruser_login_id'];
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['category_type']="";
  $_SESSION['keyword']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['firm_type']="";
  $_SESSION['member_type']="";
  $_SESSION['status']="";
  
  header("Location: membership.php");
  
}else
{ 
  	$search_type=$_REQUEST['search_type'];
  	if($search_type=="SEARCH")
	{ 
	  $_SESSION['category_type']=$_REQUEST['category_type'];
	  $_SESSION['keyword']=$_REQUEST['keyword'];
	  $_SESSION['from_date']=$_REQUEST['from_date'];
	  $_SESSION['to_date']=$_REQUEST['to_date'];
	  $_SESSION['firm_type']=$_REQUEST['firm_type'];
	  $_SESSION['member_type']=$_REQUEST['member_type'];
	  $_SESSION['status']=$_REQUEST['status'];
	}
if($search_type=='SEARCH')
{
if($_SESSION['category_type']=="" && $_SESSION['keyword']=="" && $_SESSION['from_date']=="Form" && $_SESSION['to_date']=="To" && $_SESSION['firm_type']=="" && $_SESSION['member_type']=="" && $_SESSION['status']=="")
{
$_SESSION['error_msg']="Please select atleast one field to search";
}else if($_SESSION['category_type']=="" && $_SESSION['keyword']!="")
{
$_SESSION['error_msg']="Please select category for the keyword entered below";
}else if($_SESSION['category_type']!="" && $_SESSION['keyword']=="")
{
$_SESSION['error_msg']="Please enter keyword for above category";
}else if($_SESSION['from_date']=="Form" && $_SESSION['to_date'] !="To")
{
$_SESSION['error_msg']="Please enter form date";
}else if($_SESSION['from_date']!="Form" && $_SESSION['to_date']=="To")
{
$_SESSION['error_msg']="Please enter to date";
}

}
}
?>
<?php /*
if(($_REQUEST['id']!='') || ($_REQUEST['action']=='bpcreation'))
{
		$id = $_REQUEST['id'];
		$sql="update approval_master SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sap_status`='1' where registration_id='$id'";
		$resultx = mysql_query($sql);
		echo"<meta http-equiv=refresh content=\"0;url=membership.php?action=view\">";	
} */
?>  

<?php
$action_update=$_REQUEST['action_update'];
if($action_update=="UPDATE_STATUS")
{
$issue_mem_cer=$_REQUEST['issue_mem_cer'];
foreach($issue_mem_cer as $val)
{
//$rcmc_certificate_issue_date=date('Y-m-d');
//$rcmc_certificate_expire_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($rcmc_certificate_issue_date)) . " +5 year"));
$number=getUserMobile($val);
$message="Dear Sir, Your membership application with GJEPC has been approved pls. check your mail for more information.";
get_data($message,$number);
$update_membership="update approval_master set issue_membership_certificate_expire_status='Y',adminId='$adminID' where registration_id='$val'";
$update_result_membership=mysql_query($update_membership);

$update_membership1="update approval_master set admin_issue_membership_certificate='Y',admin_issue_certificate='$adminID' where registration_id='$val'";
$update_result_membership1=mysql_query($update_membership1);

$region=getRegion($val);
$cname=getCompanyName($val);
$email_id=getUserEmail($val);

/*if($region==1010){$to_admin='membership@gjepcindia.com,archana@gjepcindia.com,mithun@gjepcindia.com,kuldip@gjepcindia.com,sheetal.kesarkar@gjepcindia.com';$address=mumAdd();}
if($region==1040){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
if($region==1050){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
if($region==1020){$to_admin='sasi@gjepcindia.com';$address=jaiAdd();}
if($region==1060){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
if($region==1030){$to_admin='ccjacob@gjepcindia.com';$address=suratAdd();} */

if($region=='HO-MUM (M)'){$to_admin='membership@gjepcindia.com,archana@gjepcindia.com,mithun@gjepcindia.com,kuldip@gjepcindia.com,sheetal.kesarkar@gjepcindia.com';$address=mumAdd();}
if($region=='RO-CHE'){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
if($region=='RO-DEL'){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
if($region=='RO-JAI'){$to_admin='sasi@gjepcindia.com';$address=jaiAdd();}
if($region=='RO-KOL'){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
if($region=='RO-SRT'){$to_admin='ccjacob@gjepcindia.com';$address=suratAdd();}

$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left"><img src="http://www.gjepc.org/images/indo_gjepc_logo.png" width="238" height="78" /></td>
        </tr>
      </table></td>
  </tr>
  <br />
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">To,<br/>'.$cname.'</td>
  </tr>
  <tr>
    <td><br /> </td>
    </tr>

   <tr>
    <td><br /> </td>
    </tr>
  <tr>
    <td align="left" style="text-align:justify;"><p>The Gem &amp; Jewellery Export Promotion council is glade to inform you that your membership has been enrolled as an Associate Member of the Council for the year 2018-19..<br/>
    </p>
    <p>You may now take the printout of your membership certificate from MY GJEPC Dashboard by logging to <a href="http://www.gjepc.org/">www.gjepc.org</a>. (Print Acknowledgment – Print Membership Certificate)</p></td>
  </tr>
   <tr>
  		<td><br /> </td>
   </tr>
   <tr>
   	<td>With warm regards,</td>
   </tr>'.$address.'
</table>';	
		
 $to =$email_id.",".$to_admin;
 $subject = "Your application for GJEPC Membership with GJEPC has been approved by GJEPC admin"; 
 $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From:admin@gjepc.org';			
 mail($to, $subject, $message, $headers);
}


$issue_rcmc_cer=$_REQUEST['issue_rcmc_cer'];
foreach($issue_rcmc_cer as $val)
{
//$rcmc_certificate_issue_date=date('Y-m-d');
//$rcmc_certificate_expire_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($rcmc_certificate_issue_date)) . " +5 year"));
$number=getUserMobile($val);
$message="Dear Sir, Your application for RCMC with GJEPC has been approved & the RCMC will be couriered to you.";
$update_rcmc="update approval_master set rcmc_certificate_approve='Y',rcmc_certificate_issue_status='Y',rcmc_certificate_apply='N' where registration_id='$val'";
$update_result_rcmc=mysql_query($update_rcmc);
}

$renew_application=$_REQUEST['renew_application'];

foreach($renew_application as $val1)
{
$membership_renewal_dt=date('Y-m-d');

	// current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
 	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
$next_fin_year=$cur_year+1;    
$membership_expiry_dt="$next_fin_year-03-31";

$number=getUserMobile($val1);
$message="Dear Sir, Your membership application with GJEPC has been approved pls. check your mail for more information.";

$update_renew="update approval_master set membership_renewal_dt='$membership_renewal_dt',membership_expiry_dt='$membership_expiry_dt',membership_expiry_status='N',apply_membership_renewal='N',information_approve='Y',document_approve='Y',payment_approve='Y'  where registration_id='$val1'";
$update_result_renew=mysql_query($update_renew);

$region=getRegion($val1);
$cname=getCompanyName($val1);
$email_id=getUserEmail($val1);
/*
if($region==1010){$to_admin='membership@gjepcindia.com,archana@gjepcindia.com,mithun@gjepcindia.com,kuldip@gjepcindia.com,sheetal.kesarkar@gjepcindia.com';$address=mumAdd();}
if($region==1040){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
if($region==1050){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
if($region==1020){$to_admin='sasi@gjepcindia.com';$address=jaiAdd();}
if($region==1060){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
if($region==1030){$to_admin='ccjacob@gjepcindia.com';$address=suratAdd();} */

if($region=='HO-MUM (M)'){$to_admin='membership@gjepcindia.com,archana@gjepcindia.com,mithun@gjepcindia.com,kuldip@gjepcindia.com,sheetal.kesarkar@gjepcindia.com';$address=mumAdd();}
if($region=='RO-CHE'){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
if($region=='RO-DEL'){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
if($region=='RO-JAI'){$to_admin='sasi@gjepcindia.com';$address=jaiAdd();}
if($region=='RO-KOL'){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
if($region=='RO-SRT'){$to_admin='ccjacob@gjepcindia.com';$address=suratAdd();}


$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left"><img src="http://www.gjepc.org/images/indo_gjepc_logo.png" width="238" height="78"/></td>
        </tr>
      </table></td>
  </tr>
  <br />
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">To,<br/>'.$cname.'</td>
  </tr>
  <tr>
    <td><br /> </td>
    </tr>
  <tr>
    <td align="left" style="text-align:justify;">
	Your application for renewal of membership with GJEPC has been received by the GJEPC Membership Dept.</td>
  </tr>
   <tr>
    <td><br /> </td>
    </tr>
  <tr>
    <td align="left" style="text-align:justify;"><p><a href="https://www.gjepc.org/user/login">Click here</a> to login and check your application status.</p>
      <p>If your RCMC certificate is getting expired on 31-03-2018 then the same can be renewed through My GJEPC dashboard</p></td>
  </tr>
   <tr>
  		<td><br/> </td>
   </tr>
   <tr>
   	<td>With warm regards,</td>
   </tr>'.$address.'
</table>';	
		
 $to =$email_id.",".$to_admin;
 $subject = "Your application for renewal of Membership with GJEPC has been received by the GJEPC Membership Dept"; 
 $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From:admin@gjepc.org';			
 mail($to, $subject, $message, $headers);
 
}

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Membership Form ||GJEPC||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

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


<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
	</script>
<!-- lightbox Thum -->

</head>
<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>
<div class="clear"></div>
<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Membership</div>
</div>

<div id="main">
	<div class="content">
    
    	<!--<div class="content_head"><a href="webtoerp_export.php" target="_blank"><div class="content_head_button">Export New Member Web To ERP</div></a> <a href="renewalwebtoerp_export.php" target="_blank"><div class="content_head_button">Export Renewal Web To ERP</div></a> <a href="import_export.php" target="_blank"><div class="content_head_button">Import Export Membership data</div></a><a href="erptoweb_import.php" target="_blank"><div class="content_head_button">Import ERP To Web</div></a><a href="download_status.php" target="_blank"><div class="content_head_button">Activate Download Status</div></a>
        </div>-->
    	
<div class="clear"></div>
<div class="content_details1">

<form name="search" action="" method="post"/> 

<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
      
<tr>
    <td width="19%"><strong>Select Category</strong></td>
    <td width="81%">
        <select name="category_type" id="category_type" class="input_txt">
        <option value="">Please Select Category</option>	
        <option value="company_name" <?php if($_SESSION['category_type']=="company_name"){echo "selected='selected'";}?>>Company Name</option>
        <option value="iec_no" <?php if($_SESSION['category_type']=="iec_no"){echo "selected='selected'";}?>>IEC Number</option>
        <option value="membership_id" <?php if($_SESSION['category_type']=="membership_id"){echo "selected='selected'";}?>>Membership ID</option>	
        </select>  
    </td>
</tr>

<tr>
    <td ><strong>Enter Keywords</strong></td>
    <td><input type="text" name="keyword" id="keyword" class="input_txt" value="<?php echo $_SESSION['keyword'];?>" /></td>
</tr>	
     
<tr>
    <td><strong>Date</strong></td>
    <td><input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "Form";}else{echo $_SESSION['from_date'];}?>" class="input_date"/>
     <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
</tr>

<tr>
    <td><strong>Firm Type</strong></td>
    <td>
    <select name="firm_type" id="firm_type" class="input_txt">
    <option value="">Please Select Firm Type</option>	
    <?php 
	$sql="select * from type_of_firm_master where status='1'";
	$result=mysql_query($sql);
	while($rows=mysql_fetch_array($result))
	{
	if($_SESSION['sap_value']==$rows['type_of_firm_name'])
	{
	echo "<option value='$rows[sap_value]' selected='selected'>$rows[type_of_firm_name]</option>";
	}else
	{
	echo "<option value='$rows[sap_value]'>$rows[type_of_firm_name]</option>";
	}
	}
	?>    
    </select>
    </td>
</tr>

<tr >
  <td><strong>Member Type</strong></td>
  <td>
    <select name="member_type" class="input_txt">
    <option value="">Please Select Member Type</option>	
    <?php 
	$sql="select * from member_type_master where status=1";
	$result=mysql_query($sql);
	while($rows=mysql_fetch_array($result))
	{
	if($_SESSION['sap_value']==$rows['member_type_name'])
	{
	echo "<option value='$rows[sap_value]' selected='selected'>$rows[member_type_name]</option>";
	}else
	{
	echo "<option value='$rows[sap_value]'>$rows[member_type_name]</option>";
	}
	}
	?>
</select>
  </td>
 </tr>

<tr >
  <td><strong>Status</strong></td>
  <td>
  <select name="status" class="input_txt-select" >
  <option value="">Select Status</option>
  <option value="New_application_for_membership" <?php if($_SESSION['status']=='New_application_for_membership'){echo "selected='selected'";}?>>New application for membership</option>
  <option value="Application_for_renewal_of_membership" <?php if($_SESSION['status']=='Application_for_renewal_of_membership'){echo "selected='selected'";}?>>Application for renewal of membership</option>
  <option value="Information_Approved" <?php if($_SESSION['status']=='Information_Approved'){echo "selected='selected'";}?>>Information Approved</option>
  <option value="Information_Disapproved" <?php if($_SESSION['status']=='Information_Disapproved'){echo "selected='selected'";}?>>Information Disapproved</option>
  <option value="Information_Pending" <?php if($_SESSION['status']=='Information_Pending'){echo "selected='selected'";}?>>Information Pending</option>
  <option value="Document_Approved" <?php if($_SESSION['status']=='Document_Approved'){echo "selected='selected'";}?>>Document Approved</option>
  <option value="Document_Disapproved" <?php if($_SESSION['status']=='Document_Disapproved'){echo "selected='selected'";}?>>Document Disapproved</option>
  <option value="Document_Pending" <?php if($_SESSION['status']=='Document_Pending'){echo "selected='selected'";}?>>Document Pending</option>
  <option value="Payment_Approved" <?php if($_SESSION['status']=='Payment_Approved'){echo "selected='selected'";}?>>Payment Approved</option>
  <option value="Payment_Disapproved" <?php if($_SESSION['status']=='Payment_Disapproved'){echo "selected='selected'";}?>>Payment Disapproved</option>
  <option value="Payment_Pending" <?php if($_SESSION['status']=='Payment_Pending'){echo "selected='selected'";}?>>Payment Pending</option>
  <option value="Application_for_rcmc_certificate" <?php if($_SESSION['status']=='Application_for_rcmc_certificate'){echo "selected='selected'";}?>>Application for rcmc certificate</option>
   <option value="Issue_membership_certificate" <?php if($_SESSION['status']=='Issue_membership_certificate'){echo "selected='selected'";}?>> Issue membership certificate</option>
  <option value="Issue_rcmc_certificate" <?php if($_SESSION['status']=='Issue_rcmc_certificate'){echo "selected='selected'";}?>>Issue rcmc certificate</option>
  <option value="GJEPC_Membership_Expired" <?php if($_SESSION['status']=='GJEPC_Membership_Expired'){echo "selected='selected'";}?>>GJEPC Membership Expired</option>
  <option value="RCMC_certificate_expired" <?php if($_SESSION['status']=='RCMC_certificate_expired'){echo "selected='selected'";}?>>RCMC certificate expired</option></select>
  </td>
</tr>    
    
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	

</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="15%" height="30">Name</td>
    <td width="11%">G-code</td>
    <td width="11%">BP No.</td>
    <td width="18%">Certificate No.</td>
    <td width="20%">Membership No.</td>
    <td width="13%">Region</td>
    <td width="8%">Action</td>
    <td width="12%">&nbsp;</td>
    <td width="12%">Create BP</td>
    <td width="12%">Create Sales Order</td>
    <?php
	if($_SESSION['status']=='Application_for_renewal_of_membership')
	{
	echo "<td width='15%'>Renewal Applications</td>";
	}
	?>
    
	<?php
	if($_SESSION['status']=='Issue_rcmc_certificate')
	{
	echo "<td width='15%'>Issue RCMC Certificate</td>";
	}
	?>

	<?php
	if($_SESSION['status']=='Issue_membership_certificate')
	{
	echo "<td width='15%'>Issue Membership Certificate</td>";
	}
	?>
  </tr>
  <?php
  
 	$page=1;//Default page
	$limit=10;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
  
  $sql="select a.id,b.company_name,b.iec_no,b.region_id,b.member_type_id,c.challan_scanned_copy,c.signature_slip_copy,d.gcode,d.merchant_certificate_no,d.manufacturer_certificate_no,d.membership_id,d.sap_sale_order_create_status,d.sap_bp_create_status from registration_master a,information_master b,challan_master c,approval_master d where a.id=b.registration_id and a.id=c.registration_id and a.id=d.registration_id and c.challan_financial_year='2018' ";
  
  if($_SESSION['curruser_role']=="Admin")
  {
  $sql.=" and b.region_id='".$_SESSION['curruser_region_id']."' ";
  }
  
  if($_SESSION['category_type']!="" && $_SESSION['keyword']!="")
  {
  	if($_SESSION['category_type']=="membership_id")
	{
  		$sql.=" and d.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
	}
	else
	{
		$sql.=" and b.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
	}
  }
  
  if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
  {
    $sql.=" and a.post_date between '".$_SESSION['from_date']."' and '".$_REQUEST['to_date']."'";
  }
  
  if($_SESSION['firm_type']!="")
  {
  $sql.=" and b.type_of_firm='".$_REQUEST['firm_type']."'";
  }
  
  if($_SESSION['member_type']!="")
  {
  $sql.=" and b.member_type_id='".$_SESSION['member_type']."' ";
  }

  if($_SESSION['status']!="")
  { 
  	if($_SESSION['status']=='New_application_for_membership')
	{
  	$sql.=" and d.membership_type='N' ";
	}else if($_SESSION['status']=='Application_for_renewal_of_membership')
	{
	$sql.=" and d.apply_membership_renewal='Y' ";
	}else if($_SESSION['status']=='Information_Approved')
	{
	$sql.=" and d.information_approve='Y' ";
	}else if($_SESSION['status']=='Information_Disapproved')
	{
	$sql.=" and d.information_approve='N' ";
	}else if($_SESSION['status']=='Information_Pending')
	{
	$sql.=" and d.information_approve='P' ";
	}else if($_SESSION['status']=='Document_Approved')
	{
	$sql.=" and d.document_approve='Y' ";
	}else if($_SESSION['status']=='Document_Disapproved')
	{
	$sql.=" and d.document_approve='N' ";
	}else if($_SESSION['status']=='Document_Pending')
	{
	$sql.=" and d.document_approve='P' ";
	}else if($_SESSION['status']=='Payment_Approved')
	{
	$sql.=" and d.payment_approve='Y' ";
	}else if($_SESSION['status']=='Payment_Disapproved')
	{
	$sql.=" and d.payment_approve='N' ";
	}else if($_SESSION['status']=='Payment_Pending')
	{
	$sql.=" and d.payment_approve='P' ";
	}else if($_SESSION['status']=='Application_for_rcmc_certificate')
	{
	$sql.=" and d.rcmc_certificate_apply='Y' ";
	}else if($_SESSION['status']=='Issue_membership_certificate')
	{
	$sql.=" and (d.issue_membership_certificate_expire_status='N' || d.issue_membership_certificate_expire_status='Y')";
	}else if($_SESSION['status']=='Issue_rcmc_certificate')
	{
	$sql.=" and (d.rcmc_certificate_issue_status='N' || d.rcmc_certificate_issue_status='Y') ";
	}else if($_SESSION['status']=='GJEPC_Membership_Expired')
	{
	$sql.=" and d.membership_expiry_status='Y' ";
	}else if($_SESSION['status']=='RCMC_certificate_expired')
	{
	$sql.=" and d.rcmc_certificate_expire_status='Y' ";
	}
  }	
  
 	$sql.="group by a.id  order by a.id desc limit $start, $limit"; 
	//echo $sql;
	$result=mysql_query($sql);
	
	
	//total no of record 
	$sql1="SELECT COUNT( * ) FROM ( select a.id from registration_master a,information_master b,challan_master c,approval_master d where a.id=b.registration_id and a.id=c.registration_id and a.id=d.registration_id and c.challan_financial_year='2018'";
  
  	if($_SESSION['curruser_role']=="Admin")
	{
	$sql1.=" and b.region_id='".$_SESSION['curruser_region_id']."' ";
	}
	if($_SESSION['category_type']!="" && $_SESSION['keyword']!="")
	{
		if($_SESSION['category_type']=="membership_id")
		{
			$sql1.=" and d.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
		}
		else
		{
			$sql1.=" and b.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
		}
	}
	
	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
	{
	$sql1.=" and a.post_date between '".$_SESSION['from_date']."' and '".$_REQUEST['to_date']."'";
	}
	
	if($_SESSION['firm_type']!="")
	{
	$sql1.=" and b.type_of_firm='".$_REQUEST['firm_type']."'";
	}
	
	if($_SESSION['member_type']!="")
	{
	$sql1.=" and b.member_type_id='".$_SESSION['member_type']."' ";
	}
	
	if($_SESSION['status']!="")
	{
		if($_SESSION['status']=='New_application_for_membership')
		{
		$sql1.=" and d.membership_type='N' ";
		}else if($_SESSION['status']=='Application_for_renewal_of_membership')
		{
		$sql1.=" and d.apply_membership_renewal='Y' ";
		}else if($_SESSION['status']=='Information_Approved')
		{
		$sql1.=" and d.information_approve='Y' ";
		}else if($_SESSION['status']=='Information_Disapproved')
		{
		$sql1.=" and d.information_approve='N' ";
		}else if($_SESSION['status']=='Information_Pending')
		{
		$sql1.=" and d.information_approve='P' ";
		}else if($_SESSION['status']=='Document_Approved')
		{
		$sql1.=" and d.document_approve='Y' ";
		}else if($_SESSION['status']=='Document_Disapproved')
		{
		$sql1.=" and d.document_approve='N' ";
		}else if($_SESSION['status']=='Document_Pending')
		{
		$sql1.=" and d.document_approve='P' ";
		}else if($_SESSION['status']=='Payment_Approved')
		{
		$sql1.=" and d.payment_approve='Y' ";
		}else if($_SESSION['status']=='Payment_Disapproved')
		{
		$sql1.=" and d.payment_approve='N' ";
		}else if($_SESSION['status']=='Payment_Pending')
		{
		$sql1.=" and d.payment_approve='P' ";
		}else if($_SESSION['status']=='Application_for_rcmc_certificate')
		{
		$sql1.=" and d.rcmc_certificate_apply='Y' ";
		}
		else if($_SESSION['status']=='Issue_rcmc_certificate')
		{
		$sql1.=" and (d.rcmc_certificate_issue_status='N' || d.rcmc_certificate_issue_status='Y') ";
		}else if($_SESSION['status']=='Issue_membership_certificate')
		{
		$sql1.=" and (d.issue_membership_certificate_expire_status='N' || d.issue_membership_certificate_expire_status='Y') ";
		}
		else if($_SESSION['status']=='GJEPC_Membership_Expired')
		{
		$sql1.=" and d.membership_expiry_status='Y' ";
		}else if($_SESSION['status']=='RCMC_certificate_expired')
		{
		$sql1.=" and d.rcmc_certificate_expire_status='Y' ";
		}
	}	
	
	$sql1.=" group by a.id ) as temp"; 
	//echo "<br>".$sql1;
	$result1=mysql_query($sql1);
	$rows1=mysql_fetch_array($result1);
	$rCount=$rows1[0];
	
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result))
  {
  ?>
  <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
    <td><?php echo strtoupper($rows['company_name']);?></td>
    <td><?php echo $rows['gcode'];?></td>
    <td><?php echo getBPNO($rows['id']);?></td>
    <td><?php if($rows['member_type_id']==5){ echo "Merchant"; } else { echo "Manufacturer"; }
	if($rows['member_type_id']==5){echo $rows['merchant_certificate_no'];}else{echo $rows['manufacturer_certificate_no'];}?></td>
    <td><?php echo $rows['membership_id'];?></td>
    <!--<td>
	<?php 
	if($rows['region_id']=='1010'){ $region="HO-MUM (M)";}
	if($rows['region_id']=='1020'){ $region="RO-JAI";}
	if($rows['region_id']=='1030'){ $region="RO-SRT";}
	if($rows['region_id']=='1040'){ $region="RO-CHE";}
	if($rows['region_id']=='1050'){ $region="RO-DEL";}
	if($rows['region_id']=='1060'){ $region="RO-KOL";}
	echo $region;?>
	</td>-->
	<td ><?php echo $rows['region_id']?></td>
    <td valign="middle"><a href="information_form.php?registration_id=<?php echo $rows['id'];?>"><img src="images/edit1.png" border="0" /></a> </td>
    <td align="center" valign="bottom" class="linktext">
	<?php if($rows['challan_scanned_copy']!=""){?><div class="fancyDemo">	
	<a rel="group" href="../scan_copy/<?php echo $rows['challan_scanned_copy'];?>">Challan Copy</a></div><?php } ?>
	<?php if($rows['signature_slip_copy']!=""){?><div class="fancyDemo">	
	<a rel="group" href="../signature_slip/<?php echo $rows['signature_slip_copy'];?>">Signature Slip</a></div><?php } ?></td>
    
    <!--.....................BP Creat API------------>
    
	<?php 
	$bpno=getBPNO($rows['id']);
	if(getBPNO($rows['id'])=="") { ?>
	<td class="sap" data-url="<?php echo $rows['iec_no'];?> <?php echo $rows['id'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>
	<?php } else { ?>
	<td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png"/></a></td>
	<?php } ?>
    
    <!--.....................Sales Order Creat API------------>
    <?php if($rows['sap_sale_order_create_status'] == 0) { ?>
	<td class="so" data-url="<?php echo $bpno;?> <?php echo $rows['id'];?>">CREATE SO</td>
    <?php } else {?>
    <td><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
    <?php }?>

    <?php
	if($_SESSION['status']=='Application_for_renewal_of_membership')
	{
	echo "<td align='left'><input name='renew_application[]' type='checkbox' value='$rows[id]' /></td>";
	}
	?>
    
	<?php
	if($_SESSION['status']=='Issue_rcmc_certificate')
	{
	echo "<td align='left'><input name='issue_rcmc_cer[]' type='checkbox' value='$rows[id]' /> /<a href='../rcmc/print_certificate.php?registration_id=$rows[id]' target='_blank'> View Certificate</a></td>";
	}
	?>
	
	<?php
	if($_SESSION['status']=='Issue_membership_certificate')
	{
	echo "<td align='left'><input name='issue_mem_cer[]' type='checkbox' value='$rows[id]' /> /<a href='../rcmc/membership.php?registration_id=$rows[id]' target='_blank'> View Certificate</a></td>";
	}
	?>	
	</tr>
  
  <?php
   $i++;
   }
   ?>
   
		<?php
        if($_SESSION['status']=='Application_for_renewal_of_membership')
        {
        ?>
        <tr>
        <td colspan="6">&nbsp;</td>
        <td colspan="2"><input type="submit" name="Renew Application" value="Renew Application"  class="input_submit" /></td>
        </tr>
        <?php
        }
        ?>
        
        <?php
        if($_SESSION['status']=='Issue_rcmc_certificate')
        {
        ?>
        <tr>
        <td colspan="6">&nbsp;</td>
        <td colspan="2"><input type="submit" name="Issue RCMC Certificate" value="Issue RCMC Certificate"  class="input_submit" /></td>
        </tr>
        <?php
        }
        ?>
	
		<?php
        if($_SESSION['status']=='Issue_membership_certificate')
        {
        ?>
        <tr>
        <td colspan="6">&nbsp;</td>
        <td colspan="2"><input type="submit" name="Issue membership Certificate" value="Issue membership Certificate"  class="input_submit" /></td>
        </tr>
        <?php
        }
        ?>
   
   <?php 
	}
   else
   {
   ?>
   <tr>
     <td colspan="8">Records Not Found</td>
   </tr>
   <tr>
     <td colspan="5">&nbsp;</td>
     <td colspan="3"></td>
   </tr>
   <?php  }  ?>  
</table>

</form>
</div>  
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
}
?>

<div class="pages_1">Total number of Memberships: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'membership.php?action=view&page=',$rCount); //call function to show pagination?>
</div>        
      
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(".sap").click(function() {
	var values = $(this).data('url').split(" ");
	//alert (values);
	//alert(values[0]);   
	//alert(values[1]);
	var iec=values[0];
	var registration_id=values[1];
	//alert(registration_id);
	
	if (confirm("Are you sure you want to PUSH this record")) {
		$.ajax({
		url: "create_bp_api.php",
		method:"POST",
		data:{iec:iec,registration_id:registration_id},
		type: "POST",
		success:function(data)
		{
			//alert(data);
			if($.trim(data)==1){
				alert("BP successfully Created..");; 
				window.location.href = "membership.php?action=view";
			}else{
				alert("Sorry There is some problem with SAP response");; 
				window.location.href = "membership.php?action=view";
			
			}
			console.log(data);
		},
		});
	}	  
});

$(".so").click(function() {
	var values = $(this).data('url').split(" ");
	var bpno=values[0];
	var registration_id=values[1];
	//alert(registration_id);
	
	if (confirm("Are you sure you want to create sales order")) {
		$.ajax({
		url: "create_mem_so_api.php",
		method:"POST",
		data:{bpno:bpno,registration_id:registration_id},
		type: "POST",
		success:function(data)
		{
			if($.trim(data)==1){
				alert("Sales Order successfully Created..");; 
				window.location.href = "membership.php?action=view";
			}else{
				alert("Sorry There is some problem with SAP response");; 
				window.location.href = "membership.php?action=view";
			
			}
			console.log(data);
		},
		});
	}	  
});


</script>
</body>
</html>