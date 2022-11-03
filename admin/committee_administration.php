<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
$adminID=$_SESSION['curruser_login_id'];
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	//Unlink the previuos image		  
	$qpreviousimg=mysql_query("select profile_pic from committee_administration_master where id='$_REQUEST[id]'");
	$rpreviousimg=mysql_fetch_array($qpreviousimg);
	$filename="ProfilePic/".$rpreviousimg['profile_pic'];
	unlink($filename);
	
	$sql="delete from committee_administration_master where id='$_REQUEST[id]'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=committee_administration.php?action=view\">";
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status=$_REQUEST['status'];	
	$id=$_REQUEST['id'];
	$sql="update committee_administration_master set status='$status',adminId='$adminID',modified_date=NOW() where id='$id'";
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=committee_administration.php?action=view\">";
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$post_date = date('Y-m-d');
	$cat_id=filter($_REQUEST['cat_id']);
	$post_name=filter($_REQUEST['post_name']);
	$name=filter($_REQUEST['name']);
	$company_name=filter($_REQUEST['company_name']);
	$address=filter($_REQUEST['address']);
	$pin_code=filter($_REQUEST['pin_code']);
	$city=filter($_REQUEST['city']);
	$order_no=filter($_REQUEST['order_no']);
	
	//---------------------------------------- uplaod  profile pic  -----------------------------------------------
		$profile_pic = '';
		$target_folder = 'ProfilePic/';
		$file_name = $_FILES['profile_pic']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='committee_administration.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{
			if(($_FILES["profile_pic"]["type"] == "image/jpg") || ($_FILES["profile_pic"]["type"] == "image/jpeg") ||($_FILES["profile_pic"]["type"] == "image/png"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_path))
				{
				$profile_pic = $temp_code.'_'.$file_name;
				$sql="INSERT INTO committee_administration_master (cat_id,post_name,name,company_name,address,pin_code,city,profile_pic,order_no,status,post_date,adminId) VALUES ('$cat_id','$post_name','$name','$company_name','$address','$pin_code','$city','$profile_pic','$order_no','1','$post_date','$adminID')";			
				if(!mysql_query($sql,$dbconn))
				{
					die('Error: ' . mysql_error());
				}
				echo"<meta http-equiv=refresh content=\"0;url=committee_administration.php?action=view\">";
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  Image.\");location.href='committee_administration.php?action=add';</script>";
				return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='committee_administration.php?action=add';</script>";
			 }		
		}
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='committee_administration.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$cat_id=filter($_REQUEST['cat_id']);
	$post_name=filter($_REQUEST['post_name']);
	$name=filter($_REQUEST['name']);
	$company_name=filter($_REQUEST['company_name']);
	$address=filter($_REQUEST['address']);
	$pin_code=filter($_REQUEST['pin_code']);
	$city=filter($_REQUEST['city']);
	$order_no=filter($_REQUEST['order_no']);
	$id=filter($_REQUEST['id']);	

	//------------------------------------  Update Gallery Image ----------------------------------------------------------
		$profile_pic = '';
		$target_folder = 'ProfilePic/';
		$file_name = $_FILES['profile_pic']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='committee_administration.php?action=add';</script>";
			exit;
		}
		else if($_FILES['profile_pic']['name'] != '')
		{
		  //Unlink the previuos image		  
		   $qpreviousimg=mysql_query("select profile_pic from committee_administration_master where id='$id'");
		   $rpreviousimg=mysql_fetch_array($qpreviousimg);
		   $filename="ProfilePic/".$rpreviousimg['profile_pic'];
		   unlink($filename);

			if(($_FILES["profile_pic"]["type"] == "image/jpg") || ($_FILES["profile_pic"]["type"] == "image/jpeg") ||($_FILES["profile_pic"]["type"] == "image/png"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_path))
				{
					$profile_pic = $temp_code.'_'.$file_name;
					$sql="update committee_administration_master set profile_pic='$profile_pic' where id='$id'";
					$result=mysql_query($sql);
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this Image.\");location.href='committee_administration.php?action=edit&id=$id';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='committee_administration.php?action=edit&id=$id';</script>";
			 }	
		}	
		
	$sql="update committee_administration_master set cat_id='$cat_id',post_name='$post_name', name='$name',company_name='$company_name',address='$address',pin_code='$pin_code',city='$city',order_no='$order_no',modified_date=NOW(),adminId='$adminID' where id='$id'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=committee_administration.php?action=view\">";
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='committee_administration.php?action=add';</script>";
	}
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
	
	if(document.getElementById('post_name').value == '')
	{
		alert("Please Enter Post Name.");
		document.getElementById('post_name').focus();
		return false;
	}
	if(!IsCharacter(document.getElementById('post_name').value))
	{
		alert("Please Enter Valid Post.");
		document.getElementById('post_name').focus();
		return false;
	}
	
	if(document.getElementById('name').value == '')
	{
		alert("Please Enter Name.");
		document.getElementById('name').focus();
		return false;
	}
	if(!IsCharacter(document.getElementById('name').value))
	{
		alert("Please Enter Valid Name");
		document.getElementById('name').focus();
		return false;
	}
	
	if(document.getElementById('company_name').value == '')
	{
		alert("Please Enter Company Name.");
		document.getElementById('company_name').focus();
		return false;
	}
	if(!IsCharacter(document.getElementById('company_name').value))
	{
		alert("Please Enter Valid Company Name");
		document.getElementById('company_name').focus();
		return false;
	}
	if(document.getElementById('address').value == '')
	{
		alert("Please Enter Address.");
		document.getElementById('address').focus();
		return false;
	}
	if(!IsCharacter(document.getElementById('address').value))
	{
		alert("Please Enter Valid Address");
		document.getElementById('address').focus();
		return false;
	}
	if(document.getElementById('pin_code').value == '')
	{
		alert("Please Enter Pin Code.");
		document.getElementById('pin_code').focus();
		return false;
	}
	
	if(!IsNumeric(document.getElementById('pin_code').value))
	{
		alert("Please enter Numeric Value.")
		document.getElementById('pin_code').focus();
		return false;
	}
	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.getElementById('profile_pic').value == '')
	{
		alert("Please Upload Profile Pic.");
		document.getElementById('profile_pic').focus();
		return false;
	}
	<?php } ?>
	if(document.getElementById('order_no').value == '')
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
	}		
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
   var strValidChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz0123456789_.'";
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

</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage Committee Administration</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="committee_administration.php?action=add"><div class="content_head_button">Add Committee Administration</div></a> <a href="committee_administration.php?action=view"><div class="content_head_button">View Committee Administration</div></a> </div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Post Name</td> 
        <td>Name</td>
        <td>Company Name</td>
        <td>Address</td>
        <td>Pincode</td>
        <td>City</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'cat_id,order_no';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM committee_administration_master where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo filter($row['post_name']); ?></td>
        <td><?php echo filter($row['name']); ?></td>
        <td><?php echo filter($row['company_name']); ?></td>
        <td><?php echo filter($row['address']); ?></td>
        <td><?php echo $row['pin_code'];?></td>
        <td><?php echo filter($row['city']);?></td>       
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="committee_administration.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="committee_administration.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="committee_administration.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="committee_administration.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = mysql_query("SELECT *  FROM committee_administration_master  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$cat_id=stripslashes($row2['cat_id']);
			$post_name=stripslashes($row2['post_name']);
			$name=stripslashes($row2['name']);
			$company_name=stripslashes($row2['company_name']);
			$address=stripslashes($row2['address']);
			$pin_code=stripslashes($row2['pin_code']);
			$city=stripslashes($row2['city']);
			$profile_pic=stripslashes($row2['profile_pic']);
			$order_no=stripslashes($row2['order_no']);
		}
  }
?>
 
<div class="content_details1">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Committee Administration</td>
    </tr>
  	<tr>
      <td class="content_txt">Select Category <span class="star">*</span></td>
  	  <td>
      <select name="cat_id" id="cat_id" class="input_txt">
		<option value="">Select Category Name</option>
		<?php
        $sql="select * from committee_administration_category where status=1";
        $result=mysql_query($sql);
        while($rows=mysql_fetch_array($result))
        {
			if($rows['id']==$cat_id)
			{
			echo "<option selected='selected' value='$rows[id]'>$rows[cat_name]</option>";
			} else	{
			echo "<option value='$rows[id]'>$rows[cat_name]</option>";
			}
        }        
        ?>
      </select>
	  </td>
	  </tr>
    <tr>
    <td class="content_txt">Post Name</td>
    <td><input type="text" name="post_name" id="post_name" class="input_txt" value="<?php echo $post_name; ?>" /></td>
    </tr>
    <tr>
      <td class="content_txt">Name <span class="star">*</span></td>
      <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>
    <tr>
      <td class="content_txt">Company Name <span class="star">*</span></td>
      <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $company_name; ?>" /></td>
    </tr>
  
    <tr>
      <td valign="top" class="content_txt">Address <span class="star">*</span></td>
      <td><label>
        <textarea name="address" id="address" rows="5" class="input_txt" ><?php echo $address; ?></textarea>
      </label></td>
    </tr>
    
    <tr>
    <td class="content_txt">Pin Code <span class="star">*</span></td>
    <td><input type="text" name="pin_code" id="pin_code" class="input_txt" value="<?php echo $pin_code; ?>" maxlength="6" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">City <span class="star">*</span></td>
    <td><input type="text" name="city" id="city" class="input_txt" value="<?php echo $city; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Profile Pic <span class="star">*</span></td>
    <td><input name="profile_pic" id="profile_pic" type="file" />
    <?php if($profile_pic!=""){ echo "<img src='ProfilePic/$profile_pic' width='75px' height='75px' />";}?>
    </td>
    </tr>

	<tr>
    <td class="content_txt">Order No <span class="star">*</span></td>
    <td><input type="text" name="order_no" id="order_no" class="input_txt" value="<?php echo $order_no; ?>" /></td>
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
