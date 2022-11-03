<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from renewal_deadline_master where id='$_REQUEST[id]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=renewal_deadline.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{
	$deadline_date = date("Y-m-d",strtotime($_REQUEST['deadline_date']));
	$description=mysql_real_escape_string($_REQUEST['description']);
	
	
		$sql="INSERT INTO renewal_deadline_master (deadline_date,description) VALUES ('$deadline_date','$description')";
			
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=renewal_deadline.php?action=view\">";

}
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$deadline_date = date("Y-m-d",strtotime($_REQUEST['deadline_date']));
	$description=mysql_real_escape_string($_REQUEST['description']);
	$id=mysql_real_escape_string($_REQUEST['id']);
	
	$sql="update renewal_deadline_master set deadline_date='$deadline_date', description='$description' where id='$id'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=renewal_deadline.php?action=view\">";
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
<link href="../css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#deadline_date').datepick();

});
</script>


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
	if(document.getElementById('deadline_date').value == '')
	{
		alert("Please Enter Deadline Date");
		document.getElementById('deadline_date').focus();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Renewal Deadline</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><!--<a href="renewal_deadline.php?action=add"><div class="content_head_button">Add Renewal Deadline</div></a>--> <a href="renewal_deadline.php?action=view"><div class="content_head_button">View Renewal Deadline</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>DeadLine Date</td>
        <td>Description</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM renewal_deadline_master where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo date("d-m-Y",strtotime($row['deadline_date'])); ?></td>
     	<td><?php echo $row['description']; ?></td>
           
        <td ><a href="renewal_deadline.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <!--<td ><a href="renewal_deadline.php?action=del&id=<?php //echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>-->
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
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT *  FROM renewal_deadline_master  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$deadline_date=stripslashes($row2['deadline_date']);
			$description=stripslashes($row2['description']);
			
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Notifications</td>
    </tr>

	<!--<tr>
    <td class="content_txt">Order No <span class="star">*</span></td>
    <td><input type="text" name="order_no" id="order_no" class="input_txt" value="<?php //echo $order_no; ?>" /></td>
    </tr>-->
    <tr>
      <td>Deadline  Date <span class="star">*</span></td>
      <td><input type="text" name="deadline_date" id="deadline_date" class="input_txt" value="<?php echo date("d-m-Y",strtotime($deadline_date)); ?>" /></td>
    </tr>
    <tr>
      <td class="content_txt">Description <span class="star">*</span></td>
      <td><input type="text" name="description" id="description" class="input_txt" value="<?php echo $description; ?>" /></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
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
