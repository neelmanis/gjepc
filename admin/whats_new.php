<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from whats_new where id='$_REQUEST[id]'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=whats_new.php?action=view\">";
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status=$_REQUEST['status'];	
	$id=$_REQUEST['id'];
	$sql="update whats_new set status='$status' where id='$id'";
	if(!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=whats_new.php?action=view\">";
}

if($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d'); 
	$title=mysql_real_escape_string($_REQUEST['title']);
	$sort_desc=mysql_real_escape_string($_REQUEST['sort_desc']);
	$link=mysql_real_escape_string($_REQUEST['link']);
	
	//---------------------------------------- upload  whats_new pdf  -----------------------------------------------
		$upload_pdf = '';
		$target_folder = 'whatsnew/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$file_name = $_FILES['upload_pdf']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='gold_rate.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{
			if(($_FILES["upload_pdf"]["type"] == "application/msword") || ($_FILES["upload_pdf"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_pdf']['tmp_name'], $target_path))
				{
				$upload_pdf = $temp_code.'_'.$file_name;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='whats_new.php?action=add';</script>";
				return;
				}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='whats_new.php?action=add';</script>";
			 }		
		}
	
		$sql="INSERT INTO whats_new (title,sort_desc,upload_pdf,link,status,post_date) VALUES ('$title','$sort_desc','$upload_pdf','$link','1','$post_date')";
			
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=whats_new.php?action=view\">";

}
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$title=mysql_real_escape_string($_REQUEST['title']);
	$sort_desc=mysql_real_escape_string($_REQUEST['sort_desc']);
	$upload_pdf=mysql_real_escape_string($_REQUEST['upload_pdf']);
	$link=mysql_real_escape_string($_REQUEST['link']);
	$id=mysql_real_escape_string($_REQUEST['id']);	

	//------------------------------------  Update Newsletter PDF ----------------------------------------------------------
		$upload_pdf = '';
		$target_folder = 'whatsnew/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$file_name = $_FILES['upload_pdf']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    	echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='gold_rate.php?action=add';</script>";
		exit;
		}
		else if($file_name != '')
		{
		  //Unlink the previuos image		  
		   $qpreviousimg=mysql_query("select upload_pdf from whats_new where id='$id'");
		   $rpreviousimg=mysql_fetch_array($qpreviousimg);
		   $filename="whatsnew/".$rpreviousimg['upload_pdf'];
		   unlink($filename);

			if(($_FILES["upload_pdf"]["type"] == "application/PDF") || ($_FILES["upload_pdf"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_pdf']['tmp_name'], $target_path))
				{
					$upload_pdf = $temp_code.'_'.$file_name;
					$sql="update whats_new set upload_pdf='$upload_pdf' where id='$id'";
					$result=mysql_query($sql);
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='whats_new.php?action=edit&id=$id';</script>";
					return;
				}
			} else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='whats_new.php?action=edit&id=$id';</script>";
			 }	
		}	
		
	$sql="update whats_new set title='$title',sort_desc='$sort_desc',link='$link' where id='$id'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=whats_new.php?action=view\">";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>What's New</title>
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
	if(document.getElementById('sort_desc').value == '')
	{
		alert("Please Enter Sort Description.");
		document.getElementById('sort_desc').focus();
		return false;
	}

	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	/*if(document.getElementById('upload_pdf').value == '')
	{
		alert("Please Upload pdf.");
		document.getElementById('upload_pdf').focus();
		return false;
	}*/
	<?php } ?>
	/*if(document.getElementById('order_no').value == '')
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Seminars</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="whats_new.php?action=add"><div class="content_head_button">Add Whats New</div></a> <a href="whats_new.php?action=view"><div class="content_head_button">View Whats New</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Title</td>
        <td>Sort Description</td>
        <td>PDF</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM whats_new where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['sort_desc']; ?></td>
        <td>
        <?php if($row['upload_pdf']!=""){?>
        <a href="whatsnew/<?php echo $row['upload_pdf']; ?>" target="_blank" style="color:#000000">View</a>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="whats_new.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="whats_new.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="whats_new.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="whats_new.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
  <?php  }  	?>

<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT *  FROM whats_new  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$title=stripslashes($row2['title']);
			$sort_desc=stripslashes($row2['sort_desc']);
			$upload_pdf=stripslashes($row2['upload_pdf']);
			echo $link=stripslashes($row2['link']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Seminars</td>
    </tr>  	
    <tr>
    <td class="content_txt">Title<span class="star">*</span></td>
    <td><input type="text" name="title" id="title" class="input_txt" value="<?php echo $title; ?>" /></td>
    </tr>    
    <tr>
    <td class="content_txt">Sort Description <span class="star">*</span></td>
    <td><textarea name="sort_desc" id="sort_desc" class="input_txt"><?php echo $sort_desc; ?></textarea></td>
    </tr>    
    <tr>
    <td class="content_txt">Upload Pdf<span class="star">*</span></td>
    <td><input name="upload_pdf" id="upload_pdf" type="file" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Link <span class="star">*</span></td>
    <td><input name="link" id="link" type="text"  value="<?php echo $link; ?>"/></td>
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