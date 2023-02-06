<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; } 
$adminID = intval($_SESSION['curruser_login_id']);
function getVendorStatusFromGlobal($reg_id,$vis_id,$event,$type,$conn){
	$query_sel = "SELECT status FROM globalExhibition where `registration_id`='$reg_id' AND `visitor_id`='$vis_id' AND `participant_Type`='$type' AND event='$event' limit 1";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['status'];
}
if(($_REQUEST['action']=='vis_del') && ($_REQUEST['id']!='') && ($_REQUEST['agency_id']!=''))
{
	$sql="delete from visitor_agency_registration where id='".$_REQUEST[id]."' and agency_id='".$_REQUEST[agency_id]."'";

	$deleteFromGlobal="delete from globalExhibition where visitor_id='".$_REQUEST[id]."' AND registration_id='".$_REQUEST[agency_id]."' AND participant_Type='CONTR'";	
	$conn->query($deleteFromGlobal);

   $deleteFromLab="delete from visitor_lab_info where visitor_id='".$_REQUEST[id]."' AND registration_id='".$_REQUEST[agency_id]."' AND 	category_for='CONTR'";	
	$conn->query($deleteFromLab);

	if(!$conn->query($sql))
	{
		die('Error: ' . $conn->error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_agency.php?action=viewVisitors&agencyId=".$_REQUEST['agency_id']."\">";
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter(intval($_REQUEST['id']));
	$modified_at = date("Y-m-d H:i:s");
	$sql = "update visitor_agency_master set status='$status',adminId='$adminID',modified_at='$modified_at' where id='$id'";
	
	if($conn->query($sql)) {
	echo"<meta http-equiv=refresh content=\"0;url=manage_agency.php?action=view\">";
	} else {
	die ("Mysql Update Error: " . $conn->error);
	}
}


if(($_REQUEST['action']=='visitorApproval') && isset($_POST['apply'] ))
{
	$status = filter($_REQUEST['approval']);	
	$agency_id = filter($_POST['agency_id']);
    $modified_at = date("Y-m-d H:i:s");
    $created_at = date("Y-m-d H:i:s");
	$visitors="";	
	$visitors = $_POST['visitor_id'];
	$event = $_POST['event'];
	$categoryId=getAgencyCat($agency_id,$conn);
	if($_POST['event'] !=""){
	if($status !=""){
		if($visitors !=""){
			foreach ($visitors as $key => $visitor) {
				
				
			
						$getVisitor = $conn->query("SELECT * FROM visitor_agency_registration WHERE `id`='$visitor' AND `agency_id`='$agency_id'");
						$row = $getVisitor->fetch_assoc();
					    $fname =  str_replace(array('&amp;','&AMP;'), '&', $row['person_name']);
					    $lname = '';
					    $mobile = $row['mobile'];
					    $pan_no = $row['pan_no'];
					    $designation = "";
						if($categoryId=="5")

						$company = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $row['company_name']));
						else	
						$company = getAgencyName($agency_id,$conn);
					   $company = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $company));
						
					    $photo_url = "https://registration.gjepc.org/images/agency_directory/".$agency_id."/photo/".$row['photo'];
					    $participant_type = "CONTR";
					    $covid_report_status = "pending";
					    $days_allow = 'all';
					    $category = $row['category'];
					    $committee = $row['committee'];
                        
                   $digits = 9;	
                   $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
                   $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
                   $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
						while($countUniqueIdentifier > 0) {
						  $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
						} 
					
					   $checkRecord = $conn->query("SELECT * FROM globalExhibition WHERE  `registration_id`='$agency_id' AND `visitor_id`='$visitor'  AND `mobile`='$mobile' AND event='$event' ");
                  $checkRecordNum = $checkRecord->num_rows;
	                        if($checkRecordNum>0){
	                        	$checkRecordRow = $checkRecord->fetch_assoc();
	                        	$global_booster_dose_status = $checkRecordRow['booster_dose_status'] ; 
	                        	$global_dose2_status = $checkRecordRow['dose2_status'] ;
	                        	if($global_booster_dose_status =="Y" || $global_dose2_status =="Y"){
                              	$global_status = "Y";
	                        	}else{
                              	$global_status = "P";
	                        	}

                              $updateGlobal = "UPDATE  globalExhibition  SET `modified_date`='$modified_at',`status`='$status',`isDataPosted`='N',`onspot_adminId`= '$adminID' WHERE  `registration_id`='$agency_id' AND `visitor_id`='$visitor'  AND `participant_type`= '$participant_type' AND event='$event' ";
						        $updateGlobalResult = $conn->query($updateGlobal);
								if($updateGlobalResult){

									$sqlUpdate = "UPDATE visitor_agency_registration SET `person_status`='$status',`adminId`='$adminID' WHERE `agency_id`='$agency_id' AND `id`='$visitor'";
									$result = $conn->query($sqlUpdate);
									
								}else{
									echo "<script langauge=\"javascript\">alert(\" Updating Global table failed. Error:".$conn->error."\");location.href='manage_agency.php?action=viewVisitors&agencyId=".$agency_id."';</script>";
								}
	                        }else{
                                 $insertGlobal = "INSERT INTO globalExhibition  SET `post_date`='$created_at',`uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$agency_id',`visitor_id`='$visitor',`fname`='$fname',`lname`='$lname',`mobile`='$mobile',`pan_no`='$pan_no',`designation`='$designation',`company`='$company',`photo_url`='$photo_url',`participant_type`='$participant_type',`covid_report_status`='$covid_report_status',`days_allow`='$days_allow',`agency_category`='$category',`committee`='$committee',`status`='$status',`event`='$event',`isDataPosted`='N',`onspot_adminId`= '$adminID' ";
						        $insertGlobalResult = $conn->query($insertGlobal);
								if($insertGlobalResult){
									$sqlUpdate = "UPDATE visitor_agency_registration SET `person_status`='$status',`adminId`='$adminID' WHERE `agency_id`='$agency_id' AND `id`='$visitor'";
									$result = $conn->query($sqlUpdate);
								}else{
									echo "<script langauge=\"javascript\">alert(\" Inserting Global table failed. Error:".$conn->error."\");location.href='manage_agency.php?action=viewVisitors&agencyId=".$agency_id."';</script>";
									
								}
	                        }

				
			}
			echo "<script langauge=\"javascript\">alert(\" Submitted successfully\");location.href='manage_agency.php?action=viewVisitors&agencyId=".$agency_id."';</script>";

		}else{
			echo "<script langauge=\"javascript\">alert(\" Select Visitors\");location.href='manage_agency.php?action=viewVisitors&agencyId=".$agency_id."';</script>";
		}
	}else{
		echo "<script langauge=\"javascript\">alert(\" Select approval status\");location.href='manage_agency.php?action=viewVisitors&agencyId=".$agency_id."';</script>";
	}
	}else{
		echo "<script langauge=\"javascript\">alert(\" Select Event \");location.href='manage_agency.php?action=viewVisitors&agencyId=".$agency_id."';</script>";
	}
	

	// $sql = "update visitor_agency_master set status=?,adminId=?,modified_date='$modified_at' where id=?";
	// $stmt = $conn -> prepare($sql);
	// $stmt->bind_param("sii", $status,$adminID,$id);
	// if($stmt->execute()) {
	// echo"<meta http-equiv=refresh content=\"0;url=manage_agency.php?action=view\">";
	// } else {
	// die ("Mysql Update Error: " . $conn->error);
	// }
}



if ($_REQUEST['action']=='save')
{
	
	$agency_name=filter($_REQUEST['agency_name']);
	$contact_name=filter($_REQUEST['contact_name']);
	$category=filter($_REQUEST['category']);
	$isDocument=filter($_REQUEST['isDocument']);

	$contact_number=filter($_REQUEST['contact_number']);
	$email=filter($_REQUEST['email']);
	$address=filter($_REQUEST['address']);
	$gst=filter($_REQUEST['gst']);
	$pan=filter($_REQUEST['pan']);
	$password = md5(trim($_REQUEST['password']));
	$password_text = strip_tags($_REQUEST['password']);
	$created_at = date("Y-m-d H:i:s");
	$modified_at = date("Y-m-d H:i:s");
	
	$sqlx = "select * from visitor_agency_master where email='$email'";
	$query = $conn -> query($sqlx);
	
	
    $cnt = $query->num_rows;
	if($cnt > 0)
	{
		echo "<script langauge=\"javascript\">alert(\"Email ID already in use\");location.href='manage_agency.php?action=view';</script>";
	}
	else
	{
		$sql="INSERT INTO visitor_agency_master (`agency_name`,`category`,`isDocument`,`contact_name`,`contact_number`,`email`,`pan`,`gst`,`address`,`password`,`password_text`,`adminId`,`created_at`,`modified_at` ) VALUES 
		  ('$agency_name',$category,'$isDocument','$contact_name','$contact_number', '$email','$pan','$gst','$address','$password','$password_text','$adminID','$created_at','$modified_at')";
		$resultx = $conn -> query($sql);	  
	    if($resultx) {
		echo "<meta http-equiv=refresh content=\"0;url=manage_agency.php?action=view\">";
		} else {
		die ("Mysql Insert Error: " . $conn->error);
		}
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$agency_name=filter($_REQUEST['agency_name']);
	$category=filter($_REQUEST['category']);
	$isDocument=filter($_REQUEST['isDocument']);
	$contact_name=filter($_REQUEST['contact_name']);
	$contact_number=filter($_REQUEST['contact_number']);
	$email=filter($_REQUEST['email']);
	$address=filter($_REQUEST['address']);
	$gst=filter($_REQUEST['gst']);
	$pan=filter($_REQUEST['pan']);

	$password = md5(trim($_REQUEST['password']));
	$password_text = strip_tags($_REQUEST['password']);
	
	$modified_at = date("Y-m-d H:i:s");
	$id		   = intval($_REQUEST['id']);
    

	$sql="update visitor_agency_master set agency_name='$agency_name',category='$category',isDocument='$isDocument',contact_name='$contact_name',contact_number='$contact_number', email='$email',address='$address',gst='$gst',pan='$pan',password='$password',password_text='$password_text',adminId='$adminID',modified_at='$modified_at' where `id`='$id'";	
	$resultx = $conn -> query($sql);
	if($resultx) {
	echo "<meta http-equiv=refresh content=\"0;url=manage_agency.php?action=view\">";
	} else {
	die ("Mysql Update Error: " . $conn->error);
	}
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['person_name']="";
  $_SESSION['person_status']="";
  $_SESSION['global_status']="";

 
  
  header("Location: manage_agency.php?action=viewVisitors&agencyId=".$_REQUEST['agencyId']);
} else
{
    $search_type=$_REQUEST['search_type'];
    if($search_type=="SEARCH")
    { 
    $_SESSION['person_name']=  filter($_REQUEST['person_name']);
    $_SESSION['person_status']      =  filter($_REQUEST['person_status']);
    $_SESSION['global_status']      =  filter($_REQUEST['global_status']);
    
    
    }
}
//print_r($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>   
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<script type="text/javascript" src="fancybox/jquery-3.3.1.js"></script> 
<script type="text/javascript" src="fancybox/fancybox_js.js"></script>
<script type="text/javascript">		
$("div.fancyDemo a").fancybox();
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

<script language="javascript">
function checkdata()
{
	if(document.getElementById('agency_name').value == '')
	{
		alert("Please Enter Agency Name");
		document.getElementById('agency_name').focus();
		return false;
	}
	if(document.getElementById('category').value == '')
	{
		alert("Select category");
		document.getElementById('category').focus();
		return false;
	}
	if(document.getElementById('contact_name').value == '')
	{
		alert("Please Enter Name");
		document.getElementById('contact_name').focus();
		return false;
	}
	if(!IsCharacter(document.getElementById('contact_name').value))
	{
		alert("Please Enter Valid Name");
		document.getElementById('contact_name').focus();
		return false;
	}
	if(document.getElementById('email').value == '')
	{
		alert("Please enter Email ID.");
		document.getElementById('email').focus();
		return false;
	}
	if(echeck(document.getElementById('email').value)==false)
	{
		document.getElementById('email').focus();
		return false;
	}
	
	if(document.getElementById('contact_number').value == '')
	{
		alert("Please Enter Mobile No.");
		document.getElementById('contact_number').focus();
		return false;
	}
	if(!IsNumeric(document.getElementById('contact_number').value))
	{
		alert("Please enter valid Mobile No.")
		document.getElementById('contact_number').focus();
		return false;
	}
	
	if(document.getElementById('contact_number').value.length < 10)
	{
		alert("Please enter 10 digit Mobile No.");
		document.getElementById('contact_number').focus();
		return false;
	}

	
	if(document.getElementById('pan').value == '')
	{
		alert("Please enter PAN number.");
		document.getElementById('pan').focus();
		return false;
	}
	if(document.getElementById('gst').value == '')
	{
		alert("Please enter GST number.");
		document.getElementById('gst').focus();
		return false;
	}

	
	
		
}
function echeck(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Invalid E-mail ID")
		return false
	}
	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(dot,(lat+2))==-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(" ")!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 return true					
}

function IsNumeric(strString)
{
   var strValidChars = "0123456789,\. /-";
   var strChar;
   var blnResult = true;

   //if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}
function IsCharacter(strString)
{
   var strValidChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz0123456789_";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}

$(document).ready(function(){
	$("#checkAll").click(function(){
		if($(this).prop("checked") == true){
			$(".checkBoxClass").prop('checked', true);
		}else{
			$(".checkBoxClass").prop('checked', false);
		}
	});
});

</script>

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage Admin</div></div>

<div id="main">
	<div class="content">
      <?php if($_REQUEST['action'] =="viewVisitors" && $_REQUEST['agencyId'] !=="" ){ ?>
			<div class="content_head">
				<?php 

				   $sql_agency = $conn->query("SELECT agency_name from visitor_agency_master where id='".$_REQUEST[agencyId]."' ");
				   $result_agency =  $sql_agency->fetch_assoc();

				?>
       		<p>Company Name : <?php echo $result_agency['agency_name']; ?></p>
       	</div>
      <?php }?>
       

    	<div class="content_head">

    		<a href="manage_agency.php?action=add"><div class="content_head_button">Add Agency</div></a> <a href="manage_agency.php?action=view"><div class="content_head_button">View Agency</div></a> <a href="visitor-vendor-category.php?action=view" target="_blank">
    		<div class="content_head_button">Add Category</div></a></div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
		<!-- <td >Modified Date</td> -->
        <td >Agency Name</td>
		  <!--<td >Vendor Service Area</td> -->
        <td >Category</td>
        <td >Total Badge Upload</td>
        <td >Badge Approved</td>
        <td >Badge Disapproved</td>
        <td >Badge Pending</td>
        <td >Badges Applied Signature</td>
        <td >Visitors</td>
        <td>Status</td>
        <td colspan="2" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'modified_at';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result =  $conn ->query("select t1.*, count(agency_id) as total_persons from visitor_agency_master t1   left join visitor_agency_registration t2 on t1.id=t2.agency_id where 1 group by t1.id order by total_persons desc ");

    $rCount=0;
    $rCount = $result->num_rows;;		
    if($rCount>0)
    {	
	while($row =  $result->fetch_assoc())
	{	
        $agency_id = $row['id'];
		/*Get Total Badge Count*/
		$totalBadgeRes = $conn->query("SELECT COUNT(*) as total FROM visitor_agency_registration WHERE agency_id='$agency_id'");
		$totalBadgeRow = $totalBadgeRes->fetch_assoc();
		/*Get  Approved Badge Count*/
        $approvedBadgeRes = $conn->query("SELECT COUNT(*) as total FROM visitor_agency_registration WHERE agency_id='$agency_id' AND `person_status`='Y'");
		$approvedBadgeRow = $approvedBadgeRes->fetch_assoc();
		/*Get  Disapproved Badge Count*/
        $disapprovedBadgeRes = $conn->query("SELECT COUNT(*) as total FROM visitor_agency_registration WHERE agency_id='$agency_id' AND `person_status`='D'");
		$disapprovedBadgeRow = $disapprovedBadgeRes->fetch_assoc();
		/*Get  Pending Badge Count*/
        $pendingBadgeRes = $conn->query("SELECT COUNT(*) as total FROM visitor_agency_registration WHERE agency_id='$agency_id' AND `person_status`='P'");
		$pendingBadgeRow = $pendingBadgeRes->fetch_assoc();
		$appliedBadges = getTotalBadgesAppliedBycompany($agency_id,"CONTR",$conn);
    ?>  

 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo filter($row['agency_name']); ?></td>
        <td><?php echo getVisitorAgencyCategory(filter($row['category']),$conn); ?></td>
        <td><?php echo $totalBadgeRow['total'] ; ?></td>
        <td><?php echo $approvedBadgeRow['total']; ?></td>
        <td><?php echo $disapprovedBadgeRow['total']; ?></td>
        <td><?php echo $pendingBadgeRow['total']; ?></td>
        <td><?php echo $appliedBadges; ?></td>
      
        <td><a href="manage_agency.php?action=viewVisitors&agencyId=<?php echo $row['id']?>">View</a></td>
        <td>
		<?php if($row['status'] == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        }else if($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_agency.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_agency.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="manage_agency.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <!-- <td ><a href="manage_agency.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td> -->
 	</tr>

	<?php
	$i++;
	   }
	 }
	 else
	 {
	 ?>
    <tr>
        <td colspan="10">Records Not Found</td>
    </tr>
    <?php  }  	?>
</table>
</div>
<?php } ?> 

<?php if($_REQUEST['action']=='viewVisitors') {?>   
	<div class="content_details1" id="search">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr  class="orange1">
    <td colspan="2">Filter Options</td>
</tr>

<tr id="pan_number_div">
  <td style="width: 20%" ><strong>Person Name</strong></td>
  <td><input type="text" name="person_name" id="person_name" maxlength="10" class="input_txt" value="<?php echo $_SESSION['person_name'];?>" autocomplete="off"/></td>
</tr>
<tr>
<td style="width: 20%"><strong>Approve/ Disapprove</strong></td>        
    <td>
        <select name="person_status" class="input_txt" >
        <option value="">Select Status</option>
        <option value="P" <?php if($_SESSION['person_status']=='P'){echo "selected='selected'";}?>>Pending</option>
        <option value="Y" <?php if($_SESSION['person_status']=='Y'){echo "selected='selected'";}?>>Approved</option>
        <option value="D" <?php if($_SESSION['person_status']=='D'){echo "selected='selected'";}?>>Disapproved</option>
        </select>
    </td>

</tr>
<tr>
<td style="width: 20%"><strong>Show Approve/ Disapprove status</strong></td>        
    <td>
        <select name="global_status" class="input_txt" >
        <option value="">Select Status</option>
        <option value="P" <?php if($_SESSION['global_status']=='P'){echo "selected='selected'";}?>>Pending</option>
        <option value="Y" <?php if($_SESSION['global_status']=='Y'){echo "selected='selected'";}?>>Approved</option>
        <option value="D" <?php if($_SESSION['global_status']=='D'){echo "selected='selected'";}?>>Disapproved</option>
        </select>
    </td>
</tr>
<tr>

<td colspan="2"><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>   
</table>
</form>  
</div> 
<?php $agency_id = filter($_REQUEST['agencyId']);  ?>
<div class="content_details1">
        <form  method="POST" name="form1" id="form1">
        	<div style="margin-bottom: 20px;"  >
        		<select name="event"class="input_txt-select" id="event"  style="width: 200px" >
        		<option value="">Select</option>
        		<?php
        		$sql_event = "SELECT shortcode,event_name FROM `visitor_event_master` WHERE `status` ='1' and shortcode='signature23' order by `serial_no` ASC";  
				$result_event = $conn->query($sql_event);
				$count_event = $result_event->num_rows;
				if($count_event > 0){
				while($row_event = $result_event->fetch_assoc()){ ?>
                <option value="<?php echo $row_event['shortcode'];?>" selected><?php echo $row_event['event_name'];?></option>
				<?php } } 
				?>
        	</select>
        	<select name="approval"class="input_txt-select" id="approval"  style="width: 200px" >
        		<option value="">Select</option>
        		<option value="P">Pending</option>
        		<option value="Y">Approve</option>
        		<option value="D">Disapprove</option>
        	</select>
        	<input type="hidden" name="action" value="visitorApproval">
        	<input type="hidden" name="agency_id" value="<?php echo $agency_id ;?>">
        	<input type="submit" name="apply" value="Update" class="">
        	</div>
        	

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><input type="checkbox" name="checkAll" id="checkAll" value="all"></td>
        <td ><a href="#">Sr. No.</a></td>
		<!-- <td >Update Date</td> -->
        <td >Person Name</td>
        <td >Mobile No.</td>
        <td >Id Proof </td>       
        <td>Photo</td>
         <td>Photo ID</td>
        <td  align="center">Action</td>
        <td  align="center">Person Status</td>
        <td  align="center">Category</td>
        <td  align="center">Show Status</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'ar.modifiedDate';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ar.modifiedDate DESC ";
    
    $i=1;
    // $sql = "SELECT * FROM visitor_agency_registration where agency_id='$agency_id'  ";
    $sql = "SELECT ar.id, ar.modifiedDate,ar.person_name, ar.mobile,ar.pan_no,ar.agency_id,ar.photo,ar.id_proof_file,ar.person_status,`gb`.`status` as global_status,gb.agency_category FROM visitor_agency_registration ar left join globalExhibition gb on ar.id=gb.visitor_id and ar.agency_id=gb.registration_id where ar.agency_id='$agency_id'  ";
	if($_SESSION['person_name']!="")
    {
    $sql.=" and ar.person_name like '%".$_SESSION['person_name']."%'";
    }
    if($_SESSION['person_status']!="")
    {
    $sql.=" and ar.person_status like '%".$_SESSION['person_status']."%'";
    }
    if($_SESSION['global_status']!="")
    {
    $sql.=" and gb.status like '%".$_SESSION['global_status']."%'";
    }
    
    $sql = $sql.$attatch;
    $result =  $conn ->query($sql);

    
    $rCount=0;
    $rCount = $result->num_rows;;		
    if($rCount>0)
    {	
	while($row =  $result->fetch_assoc())
	{	
		//$global_status = getVendorStatusFromGlobal($row['agency_id'],$row['id'],'signature23',"CONTR",$conn);
		$global_status = $row['global_status'];
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><input type="checkbox" class="checkBoxClass" name="visitor_id[]" value="<?php echo $row['id'] ?>"></td>
        <td><?php echo $i;?></td>
		<!-- <td><?php //echo filter($row['modifiedDate']); ?></td> -->
        <td><?php echo filter($row['person_name']); ?></td>
        <td><?php echo filter($row['mobile']); ?></td>
        <td><?php echo $row['pan_no']; ?></td>
        
        <td><a data-fancybox="gallery" href="https://registration.gjepc.org/images/agency_directory/<?php echo $row['agency_id'].'/photo/'.$row['photo'];?>" >View photo</a></td>
        <td><a data-fancybox="gallery" href="https://registration.gjepc.org/images/agency_directory/<?php echo $row['agency_id'].'/id_proof/'.$row['id_proof_file'];?>" >View photo ID</a></td>
       
        <td><a href="manage_agency.php?action=viewDetails&agencyId=<?php echo $agency_id;?>&visitorId=<?php echo $row['id']; ?>"> View Details</a></td>
        <td>
         	<?php
				if($row['person_status']=="P") 
	        		echo "<img src='images/notification-exclamation.gif' border='0' />";	
				elseif($row['person_status']=="Y")
					echo "<img src='images/yes.gif' border='0' />";	
				elseif($row['person_status']=="D")
					echo "<img src='images/no.gif' border='0' />";				
			?>
        </td>
        <td><?php echo $row['agency_category'];?></td>
       <td >
       	<?php if($row['person_status'] !=="Y"){?>
            <a href="manage_agency.php?action=vis_del&id=<?php echo $row['id']?>&agency_id=<?php echo $row['agency_id'];?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" />
       <?php } ?>
  
       	<?php  if($global_status ==""){ echo "Not Registered";}elseif($global_status =="P"){ echo "Approval Pending"; }elseif($global_status =="D"){ echo "Disapproved"; }elseif($global_status =="Y"){ echo "IIJS SIGNATURE 23"; }  ?>
       	</td>     

 	</tr>

	<?php
	$i++;
	   }
	 }
	 else
	 {
	 ?>
    <tr>
        <td colspan="10">Records Not Found</td>
    </tr>
    <?php  }  	?>
</table>
</form>
</div>
<?php } ?> 
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$sql3 = "SELECT * FROM visitor_agency_master where id='".$_REQUEST['id']."'";
		$query = $conn ->query($sql3);
		
		while($row2 = $query->fetch_assoc())	
		{			
			$agency_name=stripslashes($row2['agency_name']);
			$category=stripslashes($row2['category']);
			$isDocument=stripslashes($row2['isDocument']);
			$contact_name=stripslashes($row2['contact_name']);
			$email=stripslashes($row2['email']);
			$contact_number=stripslashes($row2['contact_number']);
			$pan=stripslashes($row2['pan']);
			$gst=stripslashes($row2['gst']);
			$address=stripslashes($row2['address']);
			$password=stripslashes($row2['password']);
			$password_text=stripslashes($row2['password_text']);
			$created_at = date("Y-m-d H:i:s");
			$modified_at = date("Y-m-d H:i:s");
			
		}
  }
?>
 
<div class="content_details1">
<form method="POST" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr class="orange1">
    <td colspan="2">&nbsp; Add New Agency</td>
    </tr>
    <tr>
    <td class="content_txt">Agency Name: <span class="star">*</span></td>
    <td><input type="text" name="agency_name" id="agency_name" title="Please enter agency name" class="show-tooltip input_txt" value="<?php echo $agency_name; ?>"/></td>
    </tr>  
    <tr>
    <td class="content_txt">Select Category: <span class="star">*</span></td>
    <td>
        <select name="category" id="category" title="Please enter agency name" class="show-tooltip input_txt" >
        	<option value="">Select category</option>
        	<?php $categoryGet =$conn->query("SELECT * FROM visitor_vendor_category WHERE status='1'");
            while($rowCat = $categoryGet->fetch_assoc()){?>

           <option value="<?php echo $rowCat['id'];?>" <?php if($rowCat['id'] ==$category){echo "selected" ;}?> ><?php echo $rowCat['cat_name'];?></option>
           <?php   }   	?>
        </select>
    	
    </tr>
     <tr>
    <td class="content_txt">Document Required or not: <span class="star">*</span></td>
    <td>
         <label><input type="radio" name="isDocument" id="isDocumentYes" value="yes" <?php if($isDocument=="yes"){echo "checked";}elseif ($isDocument=="") {
         	echo "checked";
         }?>/>&nbsp;&nbsp;Yes</label>
         <label><input type="radio" name="isDocument" id="NoDocument" value="no" <?php if($isDocument=="no"){echo "checked";}?>/>&nbsp;&nbsp;No</label>
    	
    	</td>
    </tr>   
     <tr>
    <td class="content_txt">Contact Person Name: <span class="star">*</span></td>
    <td><input type="text" name="contact_name" id="contact_name" title="Please enter contact person name" class="show-tooltip input_txt" value="<?php echo $contact_name; ?>"/></td>
    </tr> 
    
     <tr>
    <td class="content_txt">Contact Person Email: <span class="star">*</span></td>
    <td><input type="text" name="email" id="email" title="Please enter contact person E-mail Id" class="show-tooltip input_txt" value="<?php echo $email; ?>"/></td>
    </tr>  
     <tr>
    <td class="content_txt">Mobile No. <span class="star">*</span></td>
    <td><input type="text" name="contact_number" id="contact_number" class="input_txt" value="<?php echo $contact_number; ?>" />
    <label id="lblMsg" style="display:none;">Please enter your contact No.</label>    </td>
    </tr> 
     <tr>
    <td class="content_txt">Agency PAN : <span class="star">*</span></td>
    <td><input type="text" name="pan" id="pan" title="Please enter agency PAN number" class="show-tooltip input_txt" value="<?php echo $pan; ?>"/></td>
    </tr> 
    <tr>
    <td class="content_txt">Agency GST : <span class="star">*</span></td>
    <td><input type="text" name="gst" id="gst" title="Please enter agency GST number" class="show-tooltip input_txt" value="<?php echo $gst; ?>"/></td>
    </tr> 
    <tr>
    <td valign="top" class="content_txt">Address</td>
    <td><label><textarea name="address" id="address" rows="5" class="input_txt" ><?php echo $address; ?></textarea></label></td>
    </tr>
    <tr>
    <td valign="top" class="content_txt">Password</td>
    <td><label><input type="text" name="password" id="password" rows="5" class="input_txt" value="<?php echo $password_text; ?>"></label></td>
    </tr>

    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" /> 
	</td>
    </tr>
</table>
</form>
</div>       
<?php } ?>   
<?php 
if($_REQUEST['action']=='viewDetails'){
		$agencyId=$_REQUEST['agencyId'];
		$visitorId=$_REQUEST['visitorId'];
		$result3 = $conn ->query("SELECT * FROM visitor_agency_registration where agency_id='$agencyId' and id='$visitorId'");
		if($row2 = $result3->fetch_assoc())
		{
			$person_name=stripslashes($row2['person_name']);
			$mobile=stripslashes($row2['mobile']);
			$pan_no=stripslashes($row2['pan_no']);
			$category=stripslashes($row2['category']);		
			$committee=stripslashes($row2['committee']);
			$id_proof_name=stripslashes($row2['id_proof_name']);
			$id_proof_file=stripslashes($row2['id_proof_file']);
			$photo=stripslashes($row2['photo']);
			$status=stripslashes($row2['person_status']);
			$remarks=stripslashes($row2['remarks']);
			$modifiedDate=stripslashes($row2['modifiedDate']);
		}
?>
 <div class="content_details1">
	<form action="" id="update_person" name='update_person' onsubmit="return checkdata()">
		<table width="100%" border="0" cellspacing="5" cellpadding="5"  >
			<tr class="orange1">
				<td colspan="2">&nbsp;View Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="manage_agency.php?action=viewVisitors&agencyId=<?php echo $agencyId?>" align="right">Back</a></td>
			</tr>  
			<tr>
			<td class="content_txt">Person Name</td>
				<td class="text6"><?php echo $person_name; ?></td>
			</tr>     
			<tr>
				<td class="content_txt">Mobile</td>
				<td class="text6"><?php echo $mobile; ?></td>
			</tr> 
			<tr>
				<td class="content_txt">Pan No</td>
				<td class="text6"><?php echo $pan_no; ?></td>
			</tr> 
			<tr>
				<td class="content_txt">Category</td>
				<td class="text6"><?php echo $category; ?></td>
			</tr> 
			<tr>
				<td class="content_txt">ID Proof</td>
				<td class="text6"><?php echo $id_proof_name; ?></td>
			</tr> 
			<?php if($category=="Committee Member"){?>
			<tr>
				<td class="content_txt">Committee</td>
				<td class="text6"><?php echo $committee; ?></td>
			</tr> 
			<?php }?>
			<tr>
				<td class="content_txt">ID Proof </td>
				<td class="text6"><a data-fancybox="gallery" href="https://registration.gjepc.org/images/agency_directory/<?php echo $agencyId.'/id_proof/'.$id_proof_file;?>" target="_blank">View Id Proof</a></td>
			</tr> 
			<tr>
				<td class="content_txt">Photo</td>
				<td class="text6"><a data-fancybox="gallery" href="https://registration.gjepc.org/images/agency_directory/<?php echo $agencyId.'/photo/'.$photo;?>" target="_blank">View photo</a></td>
			</tr> 
			<tr>
				<td class="content_txt">Update Date</td>
				<td class="text6"><?php echo $modifiedDate ?></td>
			</tr> 
		
			<td class="content_txt">Status</td>
				<td class="text6">
					<select id='per_status' name="per_status">
						<option value="P" <?php echo $status == "P" ? 'selected' : ''; ?>>Pending</option>
						<option value="Y" <?php echo $status == "Y" ? 'selected' : ''; ?>>Approve</option>
						<option value="D" <?php echo $status == "D" ? 'selected' : ''; ?>>Disapprove</option>
					</select>
				</td>
			</tr> 
			<tr class='remarks' style="display : <?php echo $status == 'D' ? '' : 'none';  ?>">
				<td class="content_txt">Remark</td>
				<td class="text6">
					<textarea  name='remark' id='remark' cols='40'><?php echo isset($remarks) && $remarks != '' ? $remarks : ''; ?></textarea>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="submit" name="Update" value="Update"  class="input_submit" />
					<input type="hidden" name="admin" value="<?php echo intval(filter($_SESSION['curruser_login_id'])) ?>" />
					<input type="hidden" name="action" id="action" value="update_status" />
					<input type="hidden" name="agencyId" id="agencyId" value="<?php echo $_REQUEST['agencyId'] ?>" />
					<input type="hidden" name="visitorId" id="visitorId" value="<?php echo $_REQUEST['visitorId'] ?>" />
				</td>
			</tr>
		</table>
		
	</form>
 </div>
 <?php } ?>  
 <?php if($_REQUEST['action'] == 'update_status' ) {
	$person_status = $_REQUEST['per_status'];
	$remark = $_REQUEST['remark'];
	if($person_status == 'Y'){
		$remark = '';
	}
	$adminId = $_REQUEST['admin'];
	$agencyId = $_REQUEST['agencyId'];
	$visitorId = $_REQUEST['visitorId'];
	if(isset($agencyId) && isset($visitorId)){

		$sqlStatusUpdate = "UPDATE visitor_agency_registration SET `person_status`='$person_status',`remarks`='$remark',`adminId`='$adminID' WHERE `agency_id`='$agencyId' AND `id`='$visitorId'";
		$result = $conn->query($sqlStatusUpdate);
		if($result){
			echo "<script langauge=\"javascript\">alert(\" Data Updated Successfully\");location.href='manage_agency.php?action=viewVisitors&agencyId=".$agencyId."';</script>";
		} else {
			echo "<script langauge=\"javascript\">alert(\" Updating Global table failed. Error:".$conn->error."\");location.href='manage_agency.php?action=viewVisitors&agencyId=".$agencyId."';</script>";
		}
		
	}
	
  } ?>	   
    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>

<script>
	$( document ).ready(function() {
		$("#per_status").change(function(e){
			let person_status = $("#per_status").val();
			if(person_status == 'D'){
				$('.remarks').show();
			} else {
				$('.remarks').hide();
			}
		})
	});	
	function checkdata()
    {

        if(document.getElementById('per_status').value == '')
        {
            alert("Please Select Status.");
            document.getElementById('per_status').focus();
            return false;
        }
        if(document.getElementById('remark').value == '')
        {
			let status = $("#per_status").val();
			if(status == "D"){
				alert("Please Select Remark.");
				document.getElementById('remark').focus();
				return false;
			} else {
				return true;
			}
            
        }
        
        
            
    }
</script>