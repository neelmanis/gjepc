<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $action="";
  $_SESSION['name']="";
  $_SESSION['bp_number']="";
  header("Location: manage_foreign_party.php?action=view");
}else if($_REQUEST['Search']=="Search")
{ 
  $action=$_REQUEST['Search'];
  $_SESSION['name']=$_REQUEST['name'];
  $_SESSION['bp_number']=$_REQUEST['bp_number'];
  if($action=='Search')
  {
  	if($_SESSION['name']=="" && $_SESSION['bp_number']=="")
	{
		$_SESSION['error_msg']="Please Name or BP Number";
	}
  }
}
?>  
<?php 
if($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$LONGNAME=addslashes($_REQUEST['LONGNAME']);
	$BP_NUMBER=addslashes($_REQUEST['BP_NUMBER']);
	$EMAIL=addslashes($_REQUEST['EMAIL']);
	$PHONE1=addslashes($_REQUEST['PHONE1']);
	$ADDRESS1=addslashes($_REQUEST['ADDRESS1']);
	$ADDRESS2=addslashes($_REQUEST['ADDRESS2']);
	$ADDRESS3=addslashes($_REQUEST['ADDRESS3']);
	$PINCODE=addslashes($_REQUEST['PINCODE']);
	$CITY_NAME=addslashes($_REQUEST['CITY_NAME']);
	$COUNTRYID=addslashes($_REQUEST['COUNTRYID']);
	$post_date=date("Y/m/d:h:i:s");	
	$Entered_By=$_SESSION['curruser_contact_name'];
	
	$result = @mysqli_query($conn,"select * from kp_foreign_imp_master where BP_NUMBER='$BP_NUMBER'");
	$cnt = mysqli_num_rows($result);
	if($cnt > 0)
	{
		echo "<script langauge=\"javascript\">alert(\"BP NUMBER already in use\");location.href='manage_foreign_party.php?action=view';</script>";
	}
	else
	{
		$sql="INSERT INTO kp_foreign_imp_master set BP_NUMBER='$BP_NUMBER',LONGNAME='$LONGNAME',COUNTRYID='$COUNTRYID',ADDRESS1='$ADDRESS1',ADDRESS2='$ADDRESS2',ADDRESS3='$ADDRESS3',PINCODE='$PINCODE',EMAIL='$EMAIL',CITY_NAME='$CITY_NAME',Entered_By='$Entered_By',Entered_On='$post_date',Modified_On='$post_date'";	
		if (!mysqli_query($conn,$sql))
		{
			die('Error: ' . mysqli_error($conn));
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_foreign_party.php?action=view\">";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Foreign Party|| KP ||</title>
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
<script language="javascript">
function checkdata()
{
	if(document.getElementById('LONGNAME').value == '')
	{
		alert("Please Enter Foreign Party Name");
		document.getElementById('LONGNAME').focus();
		return false;
	}
	
	if(document.getElementById('EMAIL').value == '')
	{
		alert("Please enter Email ID.");
		document.getElementById('EMAIL').focus();
		return false;
	}
	if(document.getElementById('PHONE1').value=="")
	{
		alert("Please enter valid Mobile No.")
		document.getElementById('PHONE1').focus();
		return false;
	}
	if(document.getElementById('BP_NUMBER').value == '')
	{
		alert("Please Enter BP NUMBER");
		document.getElementById('BP_NUMBER').focus();
		return false;
	}
	if(document.getElementById('ADDRESS1').value == '')
	{
		alert("Please Enter ADDRESS Line 1");
		document.getElementById('ADDRESS1').focus();
		return false;
	}
	if(document.getElementById('ADDRESS2').value == '')
	{
		alert("Please Enter ADDRESS Line 2");
		document.getElementById('ADDRESS2').focus();
		return false;
	}
	if(document.getElementById('ADDRESS3').value == '')
	{
		alert("Please Enter ADDRESS Line 3");
		document.getElementById('ADDRESS3').focus();
		return false;
	}
	if(document.getElementById('PINCODE').value == '')
	{
		alert("Please Enter PINCODE");
		document.getElementById('PINCODE').focus();
		return false;
	}
	if(document.getElementById('COUNTRYID').value == '')
	{
		alert("Please select country");
		document.getElementById('COUNTRYID').focus();
		return false;
	}
}
</script>
</head>
<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a>> Manage Foreign Party</div>
</div>

<div id="main">
	<div class="content">
	<div class="content_head">
		<a href="manage_foreign_party.php?action=add"><div class="content_head_button">Add Foreign Party</div></a>
		<a href="manage_foreign_party.php?action=view"><div class="content_head_button">View Foreign Party</div></a> 
	</div>
    	
<?php if($_REQUEST['action']=='view' || isset( $_REQUEST['Search'] ) ) { ?>
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
		<tr class="orange1">
			<td colspan="11" >Search Options</td>
		</tr>   
		<tr>
			<td ><strong>Foreign Party Name</strong></td>
			<td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $_SESSION['name'];?>" /></td>
		</tr>	 
		<tr>
		  <td><strong>BP Number</strong></td>
		  <td><input type="text" name="bp_number" id="bp_number" class="input_txt" value="<?php echo $_SESSION['bp_number'];?>" /></td>
		</tr>     
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="Search" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
		</tr>	
	</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action" value="UPDATE_STATUS" /> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="10%">Foreign Party Name</td>
    <td width="10%">BP Number</td>
	<td width="50%">ADDRESS</td>
	<td width="5%">Country Code</td>
    <td width="15%">Application Date</td>
  </tr>
  <?php
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
  
	 $sql="SELECT * from kp_foreign_imp_master where 1";

	if($_SESSION['name']!="")
	{
	$sql.=" and `LONGNAME` like '%".$_SESSION['name']."%' ";
	}
	
	if($_SESSION['bp_number']!="")
	{
	$sql.=" and `BP_NUMBER`='".$_SESSION['bp_number']."'";
	}
	
	//echo $sql;
	
 	$result=mysqli_query($conn,$sql);
	$rCount=mysqli_num_rows($result);	

	$sql1=$sql." limit $start, $limit"; 
	$result1=mysqli_query($conn,$sql1);
		
  if($rCount>0)
  {	
  while($rows=mysqli_fetch_array($result1))
   {
  ?>
	  <tr>
		<td><?php echo $rows['LONGNAME'];?></td>
		<td><?php echo $rows['BP_NUMBER'];?></td>
		<td><?php echo $rows['ADDRESS1']." ".$rows['ADDRESS2']." ".$rows['ADDRESS3'];?></td>
		<td><?php echo $rows['COUNTRYID'];?></td>
		<td><?php echo $rows['Entered_On']?></td>
	  </tr>
  <?php
	   $i++;
	}
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
   <?php  } ?>  
</table>
</form>
</div> 
<?php }?>
<?php 
/*..................................Add or View.................................*/
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
	$action='save';
	if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
	{
		$action='update';
		$result2 = mysqli_query($conn,"SELECT * FROM kp_foreign_imp_master where id='$_REQUEST[PARTY_ID]'");
		if($row2 = mysqli_fetch_array($result2))
		{
			$LONGNAME=stripslashes($row2['LONGNAME']);
			$BP_NUMBER=stripslashes($row2['BP_NUMBER']);
			$mobile_no=stripslashes($row2['mobile_no']);
			$email_id=stripslashes($row2['email_id']);
			$password=stripslashes($row2['password']);
			$role=stripslashes($row2['role']);
			$admin_access=$row2['admin_access'];
			$region_id=stripslashes($row2['region_id']);
		}
	}
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Foreign Party</td>
    </tr>

    <tr>
		<td class="content_txt">Name <span class="star">*</span></td>
		<td><input type="text" name="LONGNAME" id="LONGNAME" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $LONGNAME; ?>" /></td>
    </tr>
	<tr>
		<td class="content_txt">Email <span class="star">*</span></td>
		<td><input type="text" name="EMAIL" id="EMAIL" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $EMAIL; ?>" /></td>
    </tr>
	<tr>
		<td class="content_txt">Mobile No <span class="star">*</span></td>
		<td><input type="text" name="PHONE1" id="PHONE1" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $PHONE1; ?>" /></td>
    </tr>
	
	<tr>
		<td class="content_txt">BP Number <span class="star">*</span></td>
		<td><input type="text" name="BP_NUMBER" id="BP_NUMBER" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $BP_NUMBER; ?>" /></td>
    </tr>
    <tr>
      <td valign="top" class="content_txt">ADDRESS1</td>
      <td><input type="text" name="ADDRESS1" id="ADDRESS1" class="input_txt" value=<?php echo $ADDRESS1; ?>></td>
    </tr>
	<tr>
      <td valign="top" class="content_txt">ADDRESS2</td>
      <td><input type="text" name="ADDRESS2" id="ADDRESS2" class="input_txt" value=<?php echo $ADDRESS2; ?>></td>
    </tr>
	<tr>
      <td valign="top" class="content_txt">ADDRESS3</td>
      <td><input type="text" name="ADDRESS3" id="ADDRESS3" class="input_txt" value=<?php echo $ADDRESS3; ?>></td>
    </tr>
    <tr>
	<tr>
      <td valign="top" class="content_txt">PINCODE</td>
      <td><input type="text" name="PINCODE" id="PINCODE" class="input_txt" value=<?php echo $PINCODE; ?>></td>
    </tr>
    <tr>
	<tr>
      <td valign="top" class="content_txt">CITY NAME</td>
      <td><input type="text" name="CITY_NAME" id="CITY_NAME" class="input_txt" value=<?php echo $CITY_NAME; ?>></td>
    </tr>
    <tr>
	
    <tr>
    <td class="content_txt">Country <span class="star">*</span></td>
    <td>
	<select name="COUNTRYID" id="COUNTRYID" class="input_txt" >
	<option value="">Select Country</option>
	<?php
		$sql="select * from  kp_country_master order by country_name asc";
		$result=mysqli_query($conn,$sql);
		while($rows=mysqli_fetch_array($result))
		{
			if($rows[country_code]==$COUNTRY_ID ||$rows[country_code]==$M_COUNTRY)
			{
				echo "<option  value='$rows[country_code]' selected='selected'>$rows[country_name]</option>";
			}
			else
			{
				echo "<option  value='$rows[country_code]'>$rows[country_name]</option>";
			}
		}
	?>
	</select>
	</td>
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
<div class="pages_1">Total number of Foreign Parties: <?php echo $rCount;?><?php echo pagination($limit,$page,'manage_foreign_party.php?action=view&page=',$rCount); //call function to show pagination?></div>        
     
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
