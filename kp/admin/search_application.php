<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $action="";
  $_SESSION['agent_id']="";
  $_SESSION['member_type']="";
  $_SESSION['status']="";
  $_SESSION['KP_CERT_NO']="";
  $_SESSION['BP_NUMBER']="";
  $_SESSION['COMPANY_NAME']="";
  $_SESSION['app_type']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
 
  header("Location: search_application.php?action=view");
}else if($_REQUEST['action']=="search")
{ 
  $action=$_REQUEST['action'];
  $_SESSION['agent_id']=$_REQUEST['agent_id'];
  $_SESSION['member_type']=$_REQUEST['member_type'];
  $_SESSION['status']=$_REQUEST['status'];
  $_SESSION['KP_CERT_NO']=$_REQUEST['KP_CERT_NO'];
  $_SESSION['BP_NUMBER']=$_REQUEST['BP_NUMBER'];
  $_SESSION['COMPANY_NAME']=$_REQUEST['COMPANY_NAME'];
  $_SESSION['app_type']=$_REQUEST['app_type'];
  $_SESSION['from_date']=$_REQUEST['from_date'];
  $_SESSION['to_date']=$_REQUEST['to_date'];
 
  if($action=='search')
  {
  	if($_SESSION['agent_id']=="" || $_SESSION['member_type']=="")
	{
		$_SESSION['error_msg']="Please select agent Name Or member type";
	}
	
	if($_SESSION['BP_NUMBER']!="" || $_SESSION['COMPANY_NAME']!="")
	{
		if($_SESSION['member_type']=="")
	  		$_SESSION['error_msg1']="Please select member type";
	}
  }
}
?>  


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Search Application || KP ||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<!--<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}-->
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
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="search_application.php">Home</a> > Search Application</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Search Application</div></div>
    	
      
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
if($_SESSION['error_msg1']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg1']."</span>";
$_SESSION['error_msg1']="";
}

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
      
<tr>
    <td><strong>Agent Name</strong></td>
    <td>
     <select name="agent_id" id="agent_id" class="input_txt">
      <option value="">Please Select Agent Name</option>
       <?php 
       $sql="select * from kp_agent_master";
       $result=mysqli_query($conn,$sql);
       while($rows=mysqli_fetch_array($result))
       {
           if($rows['AGENT_ID']==$_SESSION['agent_id'])
           {
            echo "<option selected='selected' value='$rows[AGENT_ID]'>$rows[AGENT_NAME]</option>";
           }else
           {
            echo "<option value='$rows[AGENT_ID]'>$rows[AGENT_NAME]</option>";
           }
       }
       ?>	
     </select>
     </td>
     <td><strong>Member  Type</strong></td>
     <td>
     <select name="member_type" id="member_type" class="input_txt">
      <option value="">Please Select Type</option>
      <?php 
       $sql="select * from  kp_lookup_details where LOOKUP_ID='7'";
       $result=mysqli_query($conn,$sql);
       while($rows=mysqli_fetch_array($result))
       {
		   if($rows['LOOKUP_VALUE_ID']==$_SESSION['member_type'])
		   {
				echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
		   }else
		   {
				echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
		   }
       }
       ?>	
    </select>  
    </td>
</tr>	
<tr>
  <td><strong>Status</strong></td>
  <td>
  <select name="status" id="status" class="input_txt">
    <option value="">Please Select Status</option>
     <?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='8'";
	   $result=mysqli_query($conn,$sql);
	   while($rows=mysqli_fetch_array($result))
	   {
		   if($rows['LOOKUP_VALUE_ID']==$_SESSION['status'])
		   {
			echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
		   }else
		   {
			echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
		   }
	   }
	   ?>	
    </select>
    </td>
    <td><strong>Application Type</strong></td>
  	<td><select name="app_type" id="app_type" class="input_txt">
    <option value="">Please App Type</option>
    <?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='9'";
	   $result=mysqli_query($conn,$sql);
	   while($rows=mysqli_fetch_array($result))
	   {
		   if($rows['LOOKUP_VALUE_CODE']==$_SESSION['status'])
		   {
			echo "<option selected='selected' value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
		   }else
		   {
			echo "<option value='$rows[LOOKUP_VALUE_CODE]'>$rows[LOOKUP_VALUE_NAME]</option>";
		   }
	   }
	   ?>	
	</select>
    </td>
  </tr>
  
<tr>
  <td><strong>KP CERT No.</strong></td>
  <td><input type="text" name="KP_CERT_NO" id="KP_CERT_NO" value="<?php echo $_SESSION['KP_CERT_NO'];?>"  class="input_txt1"/></td>
  <td><strong>BP Number</strong></td>
    <td><input type="text" name="BP_NUMBER" id="BP_NUMBER" value="<?php echo $_SESSION['BP_NUMBER'];?>"  class="input_txt1"/></td>
</tr> 

 <tr>
    <td><strong>Party Name</strong></td>
    <td><input type="text" name="COMPANY_NAME" id="COMPANY_NAME" value="<?php echo $_SESSION['COMPANY_NAME'];?>"  class="input_txt1"/></td>
    <td><strong>From Date</strong></td>
    <td><input type="text" name="from_date" id="from_date" value="<?php if($_SESSION['from_date']==""){echo "Form";}else{echo $_SESSION['from_date'];}?>"  class="input_date"/>
     <input type="text" name="to_date" id="to_date" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
 </tr>    
    
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>	
</table>
</form>      
</div>
<?php if($_SESSION['member_type'] !=""){?>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Type</td>
    <td>Agent Names</td>
    <td>Application No.</td>
    <td>Application Date</td>
    <td>Member Name</td>
	<td>IEC No</td>
    <td>KP CERT.</td>
	<td>Batch No</td>
    <td>DOCUMENT NO</td>
    <td>Amount</td>
    <td colspan="3">Action</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
  
 	if($_SESSION['BP_NUMBER']!=""&& $_SESSION['member_type']=="18")
		$sql="SELECT a.* FROM `kp_export_application_master` a WHERE 1 and a.MEMBER_ID IN (select MEMBER_ID from kp_member_user_details where   BP_NUMBER='".$_SESSION['BP_NUMBER']."')";	
	else if($_SESSION['COMPANY_NAME']!="" && $_SESSION['member_type']=="18")
		$sql="SELECT a.* FROM `kp_export_application_master` a WHERE 1 and a.MEMBER_ID IN (select MEMBER_ID from kp_member_user_details where COMPANY_NAME like '%".$_SESSION['COMPANY_NAME']."%')";
	else if($_SESSION['BP_NUMBER']!="" && $_SESSION['member_type']=="19")
		$sql="SELECT a.* FROM `kp_export_application_master` a WHERE 1 and a.NON_MEMBER_ID IN (select NON_MEMBER_ID from kp_non_member_master where NON_MEMBER_BP_NO='".$_SESSION['BP_NUMBER']."')";
	else if($_SESSION['COMPANY_NAME']!="" && $_SESSION['member_type']=="19")
		$sql="SELECT a.* FROM `kp_export_application_master` a WHERE 1 and a.NON_MEMBER_ID IN (select NON_MEMBER_ID from kp_non_member_master where NON_MEMBER_NAME like '%".$_SESSION['COMPANY_NAME']."%')";
	else
		$sql="SELECT a.* FROM `kp_export_application_master` a WHERE 1 ";
		
	if($_SESSION['agent_id']!="")
	{
	 $sql.=" and a.`AGENT_ID`='".$_SESSION['agent_id']."'";
	}
	
	if($_SESSION['member_type']!="")
	{
	 $sql.=" and a.MEMBER_TYPE_ID = '".$_SESSION['member_type']."' ";
	}
	if($_SESSION['app_type']!="")
	{
	 $sql.=" and a.FORM_TYPE = '".$_SESSION['app_type']."' ";
	}
	if($_SESSION['KP_CERT_NO']!="")
	{
		$sql.=" and a.KP_CERT_NO='".$_SESSION['KP_CERT_NO']."' ";
	}

	/*if($_SESSION['status']!="")
	{
	$sql.=" and STATUS='".$_SESSION['status']."' ";
	}*/
	if($_SESSION['curruser_region_id']!="")
	{
	 $sql.=" and a.PROCES_CNTR='".$_SESSION['curruser_region_id']."' ";
	}
	

	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
	{
	 $sql.=" and a.EXP_APP_DATE between '".date("Y-m-d",strtotime($_SESSION['from_date']))." 00:00:00' and '".date("Y-m-d",strtotime($_SESSION['to_date']))." 23:59:59'";
	}
	$sql.="order by a.EXP_APP_DATE desc";
	//echo $sql;
 	$result=mysqli_query($conn,$sql);
	$rCount=mysqli_num_rows($result);	

	$sql1=$sql." limit $start, $limit "; 
	 $result1=mysqli_query($conn,$sql1);
		
  if($rCount>0)
  {	
  while($rows=mysqli_fetch_array($result1))
  {
  ?>
  <tr>
    <td>
	<?php 
	if($rows['FORM_TYPE']=='I')
	{
	echo "Import";
	}else
	{
	echo "Export";
	}
	?></td>
    <td><?php echo getAgentName($conn,$rows['AGENT_ID']);?></td>
    <td><?php echo $rows['EXPORT_APP_ID'];?></td>
    <td><?php if($rows['EXP_APP_DATE']!=""){echo date("d-m-Y",strtotime($rows['EXP_APP_DATE']));}?></td>
    <td>
    <a href="search_application_detail.php?ID=<?php echo $rows['EXPORT_APP_ID'];?>">
   <?php 
	if($_SESSION['member_type']=="18")
	{
	echo getMemberName($conn,'Member',$rows['MEMBER_ID']);
	}else if($_SESSION['member_type']=="19")
	{
	echo getMemberName($conn,'NonMember',$rows['NON_MEMBER_ID']);
	}
	?>
   </a>
	</td>
	<td>
	<?php 
	if($_SESSION['member_type']=="18"){
		echo getMemberIec($conn,$rows['MEMBER_ID']);
	}else{
		echo "NA";
	}
	?>
	</td>
    <td><?php echo $rows['KP_CERT_NO'];?></td>
	<td><?php echo $rows['KP_BATCH_NO'];?></td>
    <td><?php echo $rows['INVENTORY_DOCUMENT_NO'];?></td>
    <td><?php echo $rows['FEES_AMOUNT'];?></td>
    
	<?php if($rows['KP_BATCH_STATUS']=="Y" || ($rows['COUNTRY_DEST_ID']=="BE" && $rows['FORM_TYPE']=='I')){?>
    	<td><a onclick="return(window.confirm('Batch Already Created..'));"><img src="images/active.png"/></a></td>	
    <?php }else {?>
    	<td class="cb" data-url="<?php echo $rows['EXPORT_APP_ID'];?>">Create Batch</td>
    <?php }?>
    
    <?php if($rows['INVENTORY_UPLAOD_STATUS']=="Y"){?>
    	<td><a onclick="return(window.confirm('Inventory Already Uploaded..'));"><img src="images/active.png"/></a></td>
  <?php }else if($rows['KP_BATCH_STATUS']=="Y" || $rows['COUNTRY_DEST_ID']=="BE"){?>
    	<td class="ui" data-url="<?php echo $rows['EXPORT_APP_ID'];?>">Upload Inventory</td>	
    <?php }else {?>
    	<td><a onclick="return(window.confirm('First Create Batch..'));">Upload Inventory</a></td>
    <?php }?>
     <td>
     <a href="<?php echo ($rows['FORM_TYPE']=='I')? 'update_import_applicaitons.php':'update_export_applicaitons.php';?>?action=edit&EXPORT_APP_ID=<?php echo $rows['EXPORT_APP_ID']?>">
     <img src="images/edit.png" title="Edit" border="0" />
     </a>
     </td>
  </tr>
  
  <?php
   $i++;
   }
   ?>
   <!--<tr>
    <td colspan="10"><input type="submit" name="Change Location" value="Change Location"  class="input_submit" /></td>
    </tr>-->
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
   <?php  }  	?>  
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
<div class="pages_1">Total number of Applications: <?php echo $rCount;?><?php echo pagination($limit,$page,'search_application.php?action=view&page=',$rCount); //call function to show pagination?></div>        

<?php } ?>      
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--..................Create Batch...........................-->
<script type="text/javascript">
$(".cb").click(function() {
	var values = $(this).data('url');
	var EXPORT_APP_ID=values;
	if (confirm("Are you sure you want to create batch for this application")) {
		$.ajax({
		url: "create_batch_api.php",
		method:"POST",
		data:{EXPORT_APP_ID:EXPORT_APP_ID},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			console.log(data);
			if($.trim(data)==1){
				alert("Batch created Successfully & Characteristics Uploaded Successfully.");; 
				window.location.href = "search_application.php?action=view";
			}else if($.trim(data)==2){
				alert("Batch created Successfully & Characteristics Upload is Unsuccessfully Kindly check.");; 
				window.location.href = "search_application.php?action=view";
			}else{
				alert("Both Batch & Characteristics Upload is Unsuccessfully Kindly check.");; 
				window.location.href = "search_application.php?action=view";
			
			}
		},
		});
	}	  
});
</script>
<!--....................Uplaod Inventory..............................-->
<script type="text/javascript">
$(".ui").click(function() {
	var values = $(this).data('url');
	var EXPORT_APP_ID=values;
	if (confirm("Are you sure you want to upload inventory for this application")) {
		$.ajax({
		url: "upload_inventory_api.php",
		method:"POST",
		data:{EXPORT_APP_ID:EXPORT_APP_ID},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			console.log(data);
			if($.trim(data)==1){
				alert("Inventory uploaded successfully..");; 
				window.location.href = "search_application.php?action=view";
			}else{
				alert("Sorry There is some problem with SAP response");; 
				window.location.href = "search_application.php?action=view";
			
			}
		},
		});
	}	  
});
</script>
<div id="overlay"></div>
<style>
#overlay {
    position: fixed;
    display: none; 
    width: 100%; 
    height: 100%; 
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.8);
z-index:999;}  	
</style>
</body>
</html>
