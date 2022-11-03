<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
include('../functions.php');
?>
<?php 
if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from statistics_export_master where id=?";
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", $_REQUEST['id']);
	if($stmtd->execute()){	echo"<meta http-equiv=refresh content=\"0;url=statistics_export.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter(intval($_REQUEST['id']));
	$sql="update statistics_export_master set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=statistics_export.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$cat_id	   = filter($_REQUEST['cat_id']);
	$name	   = filter($_REQUEST['name']);
	$year=filter($_REQUEST['year']);
	$set_archive=filter($_REQUEST['set_archive']);
	if($set_archive==''){ $set_archive =0;}
	
	//---------------------------------------- Start upload  Statistics Export pdf  -----------------------------------------------
		$upload_statistics_export = '';
		$target_folder = 'StatisticsExport/';
		$file_name = $_FILES['upload_statistics_export']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i",$file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='statistics_export.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{
			if(($_FILES["upload_statistics_export"]["type"] == "application/PDF") || ($_FILES["upload_statistics_export"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_statistics_export']['tmp_name'], $target_path))
				{
				$upload_statistics_export = $temp_code.'_'.$file_name;
				
				} else {
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='statistics_export.php?action=add';</script>";
				return;
				}
			 } else	 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='statistics_export.php?action=add';</script>";
			 }		
		}
		
		$background_img = '';
		$btarget_folder = 'StatisticsExport/background/';
		$bfile_name = $_FILES['background_img']['name'];
		$bfile_name = str_replace(" ","_",$bfile_name);
		$path_parts = "";
		$ext="";
		$btarget_path = "";
		$filetoupload="";
		$btemp_code = rand();
		if(preg_match("/.php/i",$bfile_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='statistics_export.php?action=add';</script>";
			exit;
		}
		else if($bfile_name!='')
		{
			if(($_FILES["background_img"]["type"] == "image/jpg") || ($_FILES["background_img"]["type"] == "image/jpeg") || ($_FILES["background_img"]["type"] == "image/png"))
			{
				$btarget_path = $btarget_folder.$btemp_code.'_'.$bfile_name;
				if(@move_uploaded_file($_FILES['background_img']['tmp_name'], $btarget_path))
				{
				$background_img = $btemp_code.'_'.$bfile_name;
				
				} else {
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='statistics_export.php?action=add';</script>";
				return;
				}
			 } else	 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='statistics_export.php?action=add';</script>";
			 }		
		}
		//---------------------------------------- Start upload  Statistics Export pdf  -----------------------------------------------
		$sql = "INSERT INTO statistics_export_master (cat_id,name,upload_statistics_export,year,set_archive,status,post_date,admin,background_img) VALUES ('$cat_id','$name','$upload_statistics_export','$year','$set_archive','1','$post_date','$adminID','$background_img')";			
		$result = $conn ->query($sql);   
        if(!$result) { die ($conn->error);
		} else { echo"<meta http-equiv=refresh content=\"0;url=statistics_export.php?action=view\">"; }
				
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='statistics_export.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$cat_id=filter($_REQUEST['cat_id']);
	$name=filter($_REQUEST['name']);
	$year=filter($_REQUEST['year']);
	$set_archive=filter($_REQUEST['set_archive']);
	if($set_archive==''){ $set_archive =0;}
	$id=filter($_REQUEST['id']);	

	//------------------------------------  Update Statistics Export PDF ----------------------------------------------------
		$upload_statistics_export = '';
		$target_folder = 'StatisticsExport/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i",$_FILES['upload_statistics_export']['name'])) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='statistics_export.php?action=add';</script>";
			exit;
		}
		else if($_FILES['upload_statistics_export']['name'] != '')
		{
		  //Unlink the previuos image		  
		   $qpreviousimg=$conn ->query("select upload_statistics_export from statistics_export_master where id='$id'");
		   $rpreviousimg= $qpreviousimg->fetch_assoc();
		   $filename="StatisticsExport/".$rpreviousimg['upload_statistics_export'];
		   unlink($filename);

			if(($_FILES["upload_statistics_export"]["type"] == "application/PDF") || ($_FILES["upload_statistics_export"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['upload_statistics_export']['name'];
				if(@move_uploaded_file($_FILES['upload_statistics_export']['tmp_name'], $target_path))
				{
					$upload_statistics_export = $temp_code.'_'.$_FILES['upload_statistics_export']['name'];
					$result = $conn ->query("update statistics_export_master set upload_statistics_export='$upload_statistics_export' where id='$id'");
					if (!$result) die ($conn->error);
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='statistics_export.php?action=edit&id=$id';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='statistics_export.php?action=edit&id=$id';</script>";
			 }	
		}
		
		$background_img = '';
		$btarget_folder = 'StatisticsExport/background/';
		$bfile_name = $_FILES['background_img']['name'];
		$bfile_name = str_replace(" ","_",$bfile_name);
		$path_parts = "";
		$ext="";
		$btarget_path = "";
		$filetoupload="";
		$btemp_code = rand();
		if(preg_match("/.php/i",$bfile_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='statistics_export.php?action=add';</script>";
			exit;
		}
		else if($bfile_name!='')
		{
			if(($_FILES["background_img"]["type"] == "image/jpg") || ($_FILES["background_img"]["type"] == "image/jpeg") || ($_FILES["background_img"]["type"] == "image/png"))
			{
				$btarget_path = $btarget_folder.$btemp_code.'_'.$bfile_name;
				if(@move_uploaded_file($_FILES['background_img']['tmp_name'], $btarget_path))
				{
				$background_img = $btemp_code.'_'.$bfile_name;
				$result = $conn ->query("update statistics_export_master set background_img='$background_img' where id='$id'");
				if(!$result) die ($conn->error);
				} else {
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='statistics_export.php?action=add';</script>";
				return;
				}
			 } else	 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='statistics_export.php?action=add';</script>";
			 }		
		}
	//------------------------------------  Update Statistics Export PDF ----------------------------------------------------
	
	$result = $conn ->query("update statistics_export_master set cat_id='$cat_id', year='$year',name='$name',set_archive='$set_archive',post_date='$post_date' where id='$id'");	
	if(!$result) die ($conn->error);
	echo"<meta http-equiv=refresh content=\"0;url=statistics_export.php?action=view\">";
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='statistics_export.php?action=add';</script>";
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
	$('#to_date').datepick();

});
</script>

<script language="javascript">
function checkdata()
{
	/*if(document.getElementById('cat_id').value == '')
	{
		alert("Please Select Category Name");
		document.getElementById('cat_id').focus();
		return false;
	}*/

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
	if(document.getElementById('upload_statistics_export').value == '')
	{
		alert("Please Upload Statistics Export.");
		document.getElementById('upload_statistics_export').focus();
		return false;
	}
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
	
	if(document.getElementById('post_date').value == '')
	{
		alert("Please Enter Post Date.");
		document.getElementById('post_date').focus();
		return false;
	}
	
	/*if(document.getElementById('to_date').value == '')
	{
		alert("Please Enter To Date.");
		document.getElementById('to_date').focus();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Statistics Export</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="statistics_export.php?action=add"><div class="content_head_button">Add Statistics Export</div></a> <a href="statistics_export.php?action=view"><div class="content_head_button">View Statistics Export</div></a> </div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Name</td>
        <td>From Date</td>
        <td>PDF</td>
        <td>Image</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = $conn ->query("SELECT * FROM statistics_export_master where 1".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;	
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo $row['name']; ?></td>
        <td><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>
        <td>
        <?php if($row['upload_statistics_export']!=""){?>
        <a href="StatisticsExport/<?php echo $row['upload_statistics_export']; ?>" target="_blank" style="color:#000000">View</a>
        <?php }?>
        </td>
		<td>
        <?php if($row['background_img']!=""){ ?>
        <img src="StatisticsExport/background/<?php echo $row['background_img']; ?>" align="center" height="50" width="80">
        <?php } ?>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="statistics_export.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="statistics_export.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="statistics_export.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="statistics_export.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM statistics_export_master where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", $_REQUEST['id']);
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$cat_id=stripslashes($row2['cat_id']);
			$name=stripslashes($row2['name']);
			$year=stripslashes($row2['year']);
			$upload_statistics_export=stripslashes($row2['upload_statistics_export']);
			$background_img = $row2['background_img'];
			$post_date = stripslashes(date("d-m-Y",strtotime($row2['post_date'])));
			$set_archive= stripslashes($row2['set_archive']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="3"> &nbsp;Add New Statistics Export</td>
    </tr>
  	<tr>
      <td class="content_txt">Select Category</td>
  	  <td>
      <select name="cat_id" id="cat_id" class="input_txt">
		<option value="">Select Category Name</option>
		<?php
        $sql="select * from statistics_export_category where status=1";
        $result =  $conn ->query($sql);
        while($rows=$result->fetch_assoc())
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
    <td class="content_txt">Upload Statistics Export <span class="star">*</span></td>
    <td><input name="upload_statistics_export" id="upload_statistics_export" type="file" /></td>
    </tr>
	
	<tr>
    <td class="content_txt">Upload Export Background Image <span class="star">*</span></td>
    <td><input name="background_img" id="background_img" type="file"/></td>
    <td>
	<?php if (isset($background_img) && !empty($background_img)) {?>
	<img src="StatisticsExport/background/<?php echo $background_img; ?>" align="center" height="100" width="300"><?php } ?>
	</td>
	</tr>
	
	<tr>
      <td class="content_txt">Select Year</td>
  	  <td>
      <select name="year" id="year" class="input_txt">
		<option value="">Select Year</option>
		<?php
        $sql2 = "select cat_name from circulars_category where status=1";
        $stmt = $conn -> prepare($sql2);
		$stmt -> execute();			
		$result2 = $stmt -> get_result();
		while($rows = $result2->fetch_assoc())
        {
			if($rows['cat_name']==$year)
			{
			echo "<option selected='selected' value='$rows[cat_name]'>$rows[cat_name]</option>";
			}
			else
			{
			echo "<option value='$rows[cat_name]'>$rows[cat_name]</option>";
			}
        }        
        ?>
      </select></td>
	  </tr>
	  
	<!--<tr>
    <td class="content_txt">Order No <span class="star">*</span></td>
    <td><input type="text" name="order_no" id="order_no" class="input_txt" value="<?php //echo $order_no; ?>" /></td>
    </tr>-->
    
    <tr>
      <td>Post Date <span class="star">*</span></td>
      <td><input type="text" name="post_date" id="post_date" class="input_txt" value="<?php echo $post_date; ?>" /></td>
    </tr>
  <!--  <tr>
      <td>To Date <span class="star">*</span></td>
      <td><input type="text" name="to_date" id="to_date" class="input_txt" value="<?php //echo $to_date; ?>" /></td>
    </tr>-->
    
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