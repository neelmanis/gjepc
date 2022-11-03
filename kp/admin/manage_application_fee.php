<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
$LOOKUP_ID='11';

if (($_REQUEST['action']=='del') && ($_REQUEST['LOOKUP_VALUE_ID']!=''))
{
	$sql="delete from kp_lookup_details where LOOKUP_VALUE_ID='$_REQUEST[LOOKUP_VALUE_ID]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_application_fee.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{
	$LOOKUP_VALUE_CODE=addslashes($_REQUEST['LOOKUP_VALUE_CODE']);
	$LOOKUP_VALUE_NAME=addslashes($_REQUEST['LOOKUP_VALUE_NAME']);
	$LOOKUP_VALUE_ORDER=addslashes($_REQUEST['LOOKUP_VALUE_ORDER']);
	$LOOKUP_ID=addslashes($_REQUEST['LOOKUP_ID']);
		
	$sql="INSERT INTO kp_lookup_details (LOOKUP_VALUE_CODE, LOOKUP_VALUE_NAME,LOOKUP_VALUE_ORDER,LOOKUP_ID) VALUES ('$LOOKUP_VALUE_CODE', '$LOOKUP_VALUE_NAME','$LOOKUP_VALUE_ORDER','$LOOKUP_ID')";
		
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_application_fee.php?action=view\">";
	
}
if (($_REQUEST['action']=='update')&&($_REQUEST['LOOKUP_VALUE_ID']!=''))
{
	$LOOKUP_VALUE_CODE=addslashes($_REQUEST['LOOKUP_VALUE_CODE']);
	$LOOKUP_VALUE_NAME=addslashes($_REQUEST['LOOKUP_VALUE_NAME']);
	$LOOKUP_VALUE_ORDER=addslashes($_REQUEST['LOOKUP_VALUE_ORDER']);
	$LOOKUP_VALUE_ID=addslashes($_REQUEST['LOOKUP_VALUE_ID']);
	$sql="update kp_lookup_details set LOOKUP_VALUE_CODE='$LOOKUP_VALUE_CODE',LOOKUP_VALUE_NAME='$LOOKUP_VALUE_NAME', LOOKUP_VALUE_ORDER='$LOOKUP_VALUE_ORDER' where LOOKUP_VALUE_ID='$LOOKUP_VALUE_ID'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_application_fee.php?action=view\">";
}
?>
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
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
<script language="javascript">
function checkdata()
{
	if(document.getElementById('LOOKUP_VALUE_CODE').value == '')
	{
		alert("Please Enter Value Code");
		document.getElementById('LOOKUP_VALUE_CODE').focus();
		return false;
	}
	
	if(document.getElementById('LOOKUP_VALUE_NAME').value == '')
	{
		alert("Please Enter Name.");
		document.getElementById('LOOKUP_VALUE_NAME').focus();
		return false;
	}
	
	if(document.getElementById('LOOKUP_VALUE_ORDER').value == '')
	{
		alert("Please Enter order no.");
		document.getElementById('LOOKUP_VALUE_ORDER').focus();
		return false;
	}
	
	
	if(!IsNumeric(document.getElementById('LOOKUP_VALUE_ORDER').value))
	{
		alert("Please enter Numeric Value.")
		document.getElementById('LOOKUP_VALUE_ORDER').focus();
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



</script>

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> >Manage Application Fee</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_application_fee.php?action=add"><div class="content_head_button">Add Application Fee</div></a> <a href="manage_application_fee.php?action=view"><div class="content_head_button">View Application Fee</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Code</td>
        <td >Name</td>
        <td >Order No</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'LOOKUP_VALUE_ORDER';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$result = mysql_query("SELECT * FROM kp_lookup_details where 1 and LOOKUP_ID='$LOOKUP_ID' ".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['LOOKUP_VALUE_CODE']; ?></td>
        <td><?php echo $row['LOOKUP_VALUE_NAME']; ?></td>
        <td><?php echo $row['LOOKUP_VALUE_ORDER']; ?></td>
       
               
        <td ><a href="manage_application_fee.php?action=edit&LOOKUP_VALUE_ID=<?php echo $row['LOOKUP_VALUE_ID']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="manage_application_fee.php?action=del&LOOKUP_VALUE_ID=<?php echo $row['LOOKUP_VALUE_ID']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></a></td>
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
        
<!--<div class="pages">
    <ul>
        <a href="#"><li style="border-right:none;">Prev </li></a>
        <a href="#"><li>1 </li></a>
        <a href="#"><li>2 </li></a>
        <a href="#"> <li>3 </li> </a>
         <a href="#"><li>4 </li></a>
        <a href="#"><li style="border-right:none;">5 </li></a>
        <a href="#"><li style="border-right:none;">Next</li></a>	           
    </ul>
</div>-->
<?php } ?>        
 
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['LOOKUP_VALUE_ID']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT *  FROM kp_lookup_details  where LOOKUP_VALUE_ID='$_REQUEST[LOOKUP_VALUE_ID]'");
		if($row2 = mysql_fetch_array($result2))
		{
			
			$LOOKUP_VALUE_CODE=stripslashes($row2['LOOKUP_VALUE_CODE']);
			$LOOKUP_VALUE_NAME=stripslashes($row2['LOOKUP_VALUE_NAME']);
			$LOOKUP_VALUE_ORDER=stripslashes($row2['LOOKUP_VALUE_ORDER']);
			
			
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Application Fee</td>
    </tr>

    <tr>
    <td class="content_txt">Value Code <span class="star">*</span></td>
    <td><input type="text" name="LOOKUP_VALUE_CODE" id="LOOKUP_VALUE_CODE" title="Please enter Value" class="show-tooltip input_txt" value="<?php echo $LOOKUP_VALUE_CODE; ?>" />    </td>
    </tr>
  
   <tr>
    <td class="content_txt">Name <span class="star">*</span></td>
    <td><input type="text" name="LOOKUP_VALUE_NAME" id="LOOKUP_VALUE_NAME" title="Please enter Name" class="show-tooltip input_txt" value="<?php echo $LOOKUP_VALUE_NAME; ?>" />    </td>
   </tr>
   
   <tr>
    <td class="content_txt">Order No <span class="star">*</span></td>
    <td><input type="text" name="LOOKUP_VALUE_ORDER" id="LOOKUP_VALUE_ORDER" title="Please enter order no" class="show-tooltip input_txt" value="<?php echo $LOOKUP_VALUE_ORDER; ?>" />    </td>
   </tr>
    

    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="LOOKUP_VALUE_ID" id="LOOKUP_VALUE_ID"  value="<?php echo $_REQUEST['LOOKUP_VALUE_ID'];?>" />
    <input type="hidden" name="LOOKUP_ID" id="LOOKUP_ID" value="<?php echo $LOOKUP_ID;?>" />    </td>
    </tr>
</table>
</form>
        </div>
        
 <?php } ?>    
    
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
