<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(($_REQUEST['action']=='del') && ($_REQUEST['mid']!=''))
{
	$qpreviousimg=mysql_query("select upload_msme_info from msme_circular where mid='$_REQUEST[mid]'");
	$rpreviousimg=mysql_fetch_array($qpreviousimg);
	$filename="msmecircular/".$rpreviousimg['upload_msme_info'];
	unlink($filename);
	$sql="delete from msme_circular where mid='$_REQUEST[mid]'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=msme.php?action=view\">";
}

if(($_REQUEST['action']=='active') && ($_REQUEST['mid']!=''))
{
		$status=$_REQUEST['status'];
		$sql="update msme_circular set status='$status' where mid='$_REQUEST[mid]'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=msme.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$name	   =	filter($_REQUEST['name']);
	$order_no  =	filter($_REQUEST['order_no']);
	if($order_no ==''){ $order_no=0; } 
	
	//---------------------------------------- upload  MSME pdf  -----------------------------------------------
		$upload_msme_info = '';
		$target_folder = 'msmecircular/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload = "";
		$file_name = $_FILES['upload_msme_info']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='msme.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{
			if (($_FILES["upload_msme_info"]["type"] == "application/PDF") || ($_FILES["upload_msme_info"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_msme_info']['tmp_name'], $target_path))
				{
				$upload_msme_info = $temp_code.'_'.$file_name;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='msme.php?action=add';</script>";
				return;
				}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='msme.php?action=add';</script>";
			 }		
		}
	
		$sql="INSERT INTO msme_circular (name,upload_msme_info,order_no,status,post_date) VALUES ('$name','$upload_msme_info','$order_no','1','$post_date')"; 
			
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=msme.php?action=view\">";

}

if(($_REQUEST['action']=='update')&&($_REQUEST['mid']!=''))
{
	$name=mysql_real_escape_string($_REQUEST['name']);
	$order_no=mysql_real_escape_string($_REQUEST['order_no']);
	$id=mysql_real_escape_string($_REQUEST['mid']);	
	if($order_no ==''){ $order_no=0; } 

	//------------------------------------  Update Newsletter PDF ----------------------------------------------------------
		$upload_msme_info = '';
		$target_folder = 'msmecircular/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$file_name = $_FILES['upload_msme_info']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='msme.php?action=add';</script>";
			exit;
		}
		else if($file_name != '')
		{
		  //Unlink the previuos image
		 // echo "select upload_msme_info from msme_circular where mid='$_REQUEST[mid]'"; exit;
		   $qpreviousimg=mysql_query("select upload_msme_info from msme_circular where mid='$_REQUEST[mid]'");
		   $rpreviousimg=mysql_fetch_array($qpreviousimg);
		   $filename="msmecircular/".$rpreviousimg['upload_msme_info'];
		   unlink($filename);

			if(($_FILES["upload_msme_info"]["type"] == "application/PDF") || ($_FILES["upload_msme_info"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['upload_msme_info']['name'];
				if(@move_uploaded_file($_FILES['upload_msme_info']['tmp_name'], $target_path))
				{
					$upload_msme_info = $temp_code.'_'.$_FILES['upload_msme_info']['name'];
					$sql="update msme_circular set upload_msme_info='$upload_msme_info' where mid='$_REQUEST[mid]'";
					$result=mysql_query($sql);
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='msme.php?action=edit&mid=$mid';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='msme.php?action=edit&mid=$mid';</script>";
			 }	
		}	
		
	$sql="update msme_circular set name='$name',order_no='$order_no' where mid='$_REQUEST[mid]'";	
	if(!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=msme.php?action=view\">";
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
<script language="javascript">
function checkdata()
{
	if(document.getElementById('name').value == '')
	{
		alert("Please Enter MSME Name.");
		document.getElementById('name').focus();
		return false;
	}

	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.getElementById('upload_msme_info').value == '')
	{
		alert("Please Upload MSME File.");
		document.getElementById('upload_msme_info').focus();
		return false;
	}
	<?php } ?>
/*	if(document.getElementById('order_no').value == '')
	{
		alert("Please enter Order No.");
		document.getElementById('order_no').focus();
		return false;
	}
	if(!IsNumeric(document.getElementById('order_no').value))
	{
		alert("Please enter Numeric Value.")
		document.getElementById('order_no').focus();
		return false;
	}*/
		
		
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage MSME Circulars</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="msme.php?action=add">
    	<div class="content_head_button">Add MSME Info</div>
    	</a> <a href="msme.php?action=view">
    	<div class="content_head_button">View MSME Info</div>
    	</a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>MSME Info Name</td>
        <td>PDF</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'order_no';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM msme_circular where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo $row['name']; ?></td>
        <td>
        <?php if($row['upload_msme_info']!=""){?>
        <a href="msmecircular/<?php echo $row['upload_msme_info']; ?>" target="_blank" style="color:#000000">View</a>
        <?php }?>
        </td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="msme.php?mid=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="msme.php?id=<?php echo $row['mid']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="msme.php?action=edit&mid=<?php echo $row['mid']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="msme.php?action=del&mid=<?php echo $row['mid']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
  if(($_REQUEST['mid']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT *  FROM msme_circular  where mid='$_REQUEST[mid]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$name=stripslashes($row2['name']);
			$upload_msme_info=stripslashes($row2['upload_msme_info']);
			$order_no=stripslashes($row2['order_no']);
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New MSME Info</td>
    </tr>  	
    <tr>
    <td class="content_txt">MSME Info Name <span class="star">*</span></td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>    
    <tr>
    <td class="content_txt">Upload MSME Info <span class="star">*</span></td>
    <td><input name="upload_msme_info" id="upload_msme_info" type="file" /></td>
    </tr>
	<!--<tr>
    <td class="content_txt">Order No <span class="star">*</span></td>
    <td><input type="text" name="order_no" id="order_no" class="input_txt" value="<?php //echo $order_no; ?>" /></td>
    </tr>-->
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['mid'];?>" />    </td>
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