<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php'); 
?>
<?php 
$adminID = intval($_SESSION['curruser_login_id']);
if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from circulars_to_member_master where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", $_REQUEST['id']);
	if($stmt->execute()){
	echo "<meta http-equiv=refresh content=\"0;url=circulars_to_member.php?action=view\">";
	}
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = intval(filter($_REQUEST['id']));
	$sql="update circulars_to_member_master set status='$status',adminId='$adminID',modified_date=NOW() where id='$id'";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){
	echo"<meta http-equiv=refresh content=\"0;url=circulars_to_member.php?action=view\">";
	}
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$cat_id	   = filter($_REQUEST['cat_id']);
	$name	   = filter($_REQUEST['name']);
	$order_no  = filter($_REQUEST['order_no']);
	$set_archive = filter($_REQUEST['set_archive']);
	if($set_archive==''){ $set_archive = 0;}
	
	//---------------------------------------- uplaod  Circulars pdf  -----------------------------------------------
		$upload_circulars = '';
		$target_folder = 'Circulars/';
		$file_name = $_FILES['upload_circulars']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i", $file_name)) {
    		 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='circulars_to_member.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{
			if(($_FILES["upload_circulars"]["type"] == "application/PDF") || ($_FILES["upload_circulars"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_circulars']['tmp_name'], $target_path))
				{
				$upload_circulars = $temp_code.'_'.$file_name;
				$status =1;
				$sql="INSERT INTO circulars_to_member_master (cat_id,name,upload_circulars,set_archive,status,post_date,adminId) VALUES (?,?,?,?,?,?,?)";
				$stmt = $conn -> prepare($sql);
				$stmt->bind_param("isssisi", $cat_id,$name,$upload_circulars,$set_archive,$status,$post_date,$adminID);
				if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=circulars_to_member.php?action=view\">"; }
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='circulars_to_member.php?action=add';</script>";
				return;
				}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='circulars_to_member.php?action=add';</script>";
			 }		
		}
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='circulars_to_member.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$cat_id=filter($_REQUEST['cat_id']);
	$name=filter($_REQUEST['name']);
	$order_no=0;
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$set_archive=filter($_REQUEST['set_archive']);
	if($set_archive==''){ $set_archive = 0;}
	$id=filter($_REQUEST['id']);	

	//------------------------------------  Update Circulars PDF ----------------------------------------------------
		$upload_circulars = '';
		$target_folder = 'Circulars/';
		$file_name = $_FILES['upload_circulars']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i", $file_name)) {
    		 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='circulars_to_member.php?action=add';</script>";
			exit;
		}
		else if($file_name != '')
		{
		  //Unlink the previuos image		  
		   $smx = "select upload_circulars from circulars_to_member_master where id=?";
		   $stmt = $conn -> prepare($smx);
		   $stmt->bind_param("i", intval($id));
		   $stmt -> execute();
		   $result = $stmt->get_result();		   
		   $rpreviousimg = $result->fetch_assoc();
		   $filename="Circulars/".$rpreviousimg['upload_circulars'];
		   unlink($filename);

			if(($_FILES["upload_circulars"]["type"] == "application/PDF") || ($_FILES["upload_circulars"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_circulars']['tmp_name'], $target_path))
				{
					$upload_circulars = $temp_code.'_'.$file_name;
					$sql="update circulars_to_member_master set upload_circulars='$upload_circulars' where id='$id'";
					$stmt = $conn -> prepare($sql);
					$stmt->execute();
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='circulars_to_member.php?action=edit&id=$id';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='circulars_to_member.php?action=edit&id=$id';</script>";
			 }	
		}	
		
	$sql="update circulars_to_member_master set cat_id=?, name=?,order_no=?,set_archive=?,modified_date=?,adminId=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("issssii", $cat_id,$name,$order_no,$set_archive,$post_date,$adminID,$id);
	if(!$stmt->execute()) { die ("Mysql Update Error: " . $conn->error); } 
	
	echo"<meta http-equiv=refresh content=\"0;url=circulars_to_member.php?action=view\">";
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='circulars_to_member.php?action=add';</script>";
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
<link href="../css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#post_date').datepick();

});
</script>

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
	if(document.getElementById('upload_circulars').value == '')
	{
		alert("Please Upload Circulars.");
		document.getElementById('upload_circulars').focus();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Govt Circulars</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="circulars_to_member.php?action=add"><div class="content_head_button">Add Govt Circulars</div></a> <a href="circulars_to_member.php?action=view"><div class="content_head_button">View Govt Circulars</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Name</td>
        <td>Post Date</td>
        <td>PDF</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$sqlx1 = "SELECT * FROM circulars_to_member_master where 1".$attach." ";
    $query = $conn -> prepare($sqlx1);
	$query->execute();			
	$result = $query->get_result();
    $rCount=0;
    $rCount=$result->num_rows;		
    if($rCount>0)
    {
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo filter($row['name']); ?></td>
        <td><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>
        <td>
        <?php if($row['upload_circulars']!=""){?>
        <a href="Circulars/<?php echo $row['upload_circulars']; ?>" target="_blank" style="color:#000000">View</a>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="circulars_to_member.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="circulars_to_member.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="circulars_to_member.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="circulars_to_member.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM circulars_to_member_master  where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", $_REQUEST['id']);
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$cat_id=filter($row2['cat_id']);
			$name=filter($row2['name']);
			$upload_circulars=stripslashes($row2['upload_circulars']);
			$order_no=filter($row2['order_no']);
			$post_date = stripslashes(date("d-m-Y",strtotime($row2['post_date'])));
			$set_archive= filter($row2['set_archive']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Circulars To Member</td>
    </tr>
  	<tr>
      <td class="content_txt">Select Category</td>
  	  <td>
      <select name="cat_id" id="cat_id" class="input_txt">
		<option value="">Select Category Name</option>
		<?php
        $sql2="select * from circulars_category where status=1";
        $stmt = $conn -> prepare($sql2);
		$stmt -> execute();			
		$result2 = $stmt -> get_result();
		while($rows = $result2->fetch_assoc())
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
    <td class="content_txt">Upload Circulars <span class="star">*</span></td>
    <td><input name="upload_circulars" id="upload_circulars" type="file" /></td>
    </tr>

    <tr>
      <td>Post Date <span class="star">*</span></td>
      <td><input type="text" name="post_date" id="post_date" class="input_txt" value="<?php echo $post_date; ?>" autocomplete="off"/></td>
    </tr>
    <tr>
      <td>Set Archive</td>
      <td><label>
        <input type="checkbox" name="set_archive" id="set_archive" <?php if($set_archive=='1'){echo "checked='checked'";} ?> value="1" />
      </label></td>
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