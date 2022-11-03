<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
$adminID=$_SESSION['curruser_login_id'];
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from ideal_cut_newsletter_master where id='$_REQUEST[id]'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=ideal_cut_newsletter.php?action=view\">";
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status=$_REQUEST['status'];	
	$id=$_REQUEST['id'];
	$sql="update ideal_cut_newsletter_master set status='$status',adminId='$adminID',modified_date=NOW() where id='$id'";
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=ideal_cut_newsletter.php?action=view\">";
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$post_date = date('Y-m-d');
	$cat_id	   = filter($_REQUEST['cat_id']);
	$name	   = filter($_REQUEST['name']);
	$newsletter_url = mysql_real_escape_string($_REQUEST['newsletter_url']);
	$order_no = mysql_real_escape_string($_REQUEST['order_no']);
	
	//---------------------------------------- uplaod  newsletter pdf  -----------------------------------------------
		$upload_newsletter = '';
		$target_folder = 'IdealCutNewsletter/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['upload_newsletter']['name']!='')
		{
			if(($_FILES["upload_newsletter"]["type"] == "application/PDF") || ($_FILES["upload_newsletter"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['upload_newsletter']['name'];
				if(@move_uploaded_file($_FILES['upload_newsletter']['tmp_name'], $target_path))
				{
				$upload_newsletter = $temp_code.'_'.$_FILES['upload_newsletter']['name'];
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='ideal_cut_newsletter.php?action=add';</script>";
				return;
				}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='ideal_cut_newsletter.php?action=add';</script>";
			 }		
		}
	
		$sql="INSERT INTO ideal_cut_newsletter_master (cat_id,name,upload_newsletter,newsletter_url,order_no,status,post_date,adminId) VALUES ('$cat_id','$name','$upload_newsletter','$newsletter_url','$order_no','1','$post_date','$adminID')";
			
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=ideal_cut_newsletter.php?action=view\">";
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='ideal_cut_newsletter.php?action=add';</script>";
	}
}
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$cat_id=mysql_real_escape_string($_REQUEST['cat_id']);
	$name=mysql_real_escape_string($_REQUEST['name']);
	$newsletter_url=mysql_real_escape_string($_REQUEST['newsletter_url']);
	$order_no=mysql_real_escape_string($_REQUEST['order_no']);
	$id=mysql_real_escape_string($_REQUEST['id']);	

	//------------------------------------  Update Newsletter PDF ----------------------------------------------------------
		$upload_newsletter = '';
		$target_folder = 'IdealCutNewsletter/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['upload_newsletter']['name'] != '')
		{
		  //Unlink the previuos image		  
		   $qpreviousimg=mysql_query("select upload_newsletter from ideal_cut_newsletter_master where id='$id'");
		   $rpreviousimg=mysql_fetch_array($qpreviousimg);
		   $filename="IdealCutNewsletter/".$rpreviousimg['upload_newsletter'];
		   unlink($filename);

			if (($_FILES["upload_newsletter"]["type"] == "application/msword") || ($_FILES["upload_newsletter"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['upload_newsletter']['name'];
				if(@move_uploaded_file($_FILES['upload_newsletter']['tmp_name'], $target_path))
				{
					$upload_newsletter = $temp_code.'_'.$_FILES['upload_newsletter']['name'];
					$sql="update ideal_cut_newsletter_master set upload_newsletter='$upload_newsletter' where id='$id'";
					$result=mysql_query($sql);
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='ideal_cut_newsletter.php?action=edit&id=$id';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='ideal_cut_newsletter.php?action=edit&id=$id';</script>";
			 }	
		}	
		
	$sql="update ideal_cut_newsletter_master set cat_id='$cat_id', name='$name',newsletter_url='$newsletter_url',order_no='$order_no',modified_date=NOW(),adminId='$adminID' where id='$id'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=ideal_cut_newsletter.php?action=view\">";
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
	if(document.getElementById('cat_id').value == '')
	{
		alert("Please Select Category Name");
		document.getElementById('cat_id').focus();
		return false;
	}

	if(document.getElementById('name').value == '')
	{
		alert("Please Enter Name.");
		document.getElementById('name').focus();
		return false;
	}

	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	/*if(document.getElementById('upload_newsletter').value == '')
	{
		alert("Please Upload Newsletter.");
		document.getElementById('upload_newsletter').focus();
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
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>
<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Ideal Cut Newsletter</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="ideal_cut_newsletter.php?action=add"><div class="content_head_button">Add Ideal Cut Newsletter</div></a> <a href="ideal_cut_newsletter.php?action=view"><div class="content_head_button">View Ideal Cut Newsletter</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Name</td>
        <td>URL</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'order_no';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM ideal_cut_newsletter_master where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo filter($row['name']);?></td>
        <td>
        <?php if($row['upload_newsletter']!=""){?>
        <a href="IdealCutNewsletter/<?php echo $row['upload_newsletter']; ?>" target="_blank" style="color:#000000">View</a>
        <?php }?>
        </td>
        <td>
		<?php 
		if($row['status'] == '1') { 
        echo "<span style='color:green'>Active</span>";
        } elseif($row['status'] == '0'){
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="ideal_cut_newsletter.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="ideal_cut_newsletter.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="ideal_cut_newsletter.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="ideal_cut_newsletter.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT * FROM ideal_cut_newsletter_master  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$cat_id=stripslashes($row2['cat_id']);
			$post_name=filter($row2['post_name']);
			$name=filter($row2['name']);
			$company_name=filter($row2['company_name']);
			$address=filter($row2['address']);
			$pin_code=filter($row2['pin_code']);
			$newsletter_url=stripslashes($row2['newsletter_url']);
			$upload_newsletter=filter($row2['upload_newsletter']);
			$order_no=stripslashes($row2['order_no']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST"  name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Ideal Cut Newsletter</td>
    </tr>
  	<tr>
      <td class="content_txt">Select Category</td>
  	  <td>
      <select name="cat_id" id="cat_id" class="input_txt">
		<option value="">Select Category Name</option>
		<?php
        $sql="select * from ideal_cut_newsletter_category where status=1";
        $result=mysql_query($sql);
        while($rows=mysql_fetch_array($result))
        {
        if($rows['id']==$cat_id)
        {
        echo "<option selected='selected' value='$rows[id]'>$rows[cat_name]</option>";
        }
        else
        {
        echo "<option value='$rows[id]'>$rows[cat_name]</option>";
        }
        }
        
        ?>
      </select></td>
	  </tr>
    <tr>
      <td class="content_txt">Name <span class="star">*</span></td>
      <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>    
    <tr>
      <td class="content_txt">Newsletter URL</td>
      <td><input type="text" name="newsletter_url" id="newsletter_url" class="input_txt" value="<?php echo $newsletter_url; ?>" /></td>
    </tr>
    <!--<tr>
    <td class="content_txt">Upload Newsletter <span class="star">*</span></td>
    <td><input name="upload_newsletter" id="upload_newsletter" type="file" /></td>
    </tr>-->

	<tr>
    <td class="content_txt">Order No <span class="star">*</span></td>
    <td><input type="text" name="order_no" id="order_no" class="input_txt" value="<?php //echo $order_no; ?>" /></td>
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
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>