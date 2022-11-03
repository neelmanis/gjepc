<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');

$adminID=$_SESSION['curruser_login_id'];
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$qpreviousimg=mysql_query("select upload_pdf from manage_annual_report where id='$_REQUEST[id]'");
	$rpreviousimg=mysql_fetch_array($qpreviousimg);
	$filename="annual_report/".$rpreviousimg['upload_pdf'];
	unlink($filename);
	
	$sql="delete from manage_annual_report where id='$_REQUEST[id]'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_annual_report.php?action=view\">";
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
		$status = filter($_REQUEST['status']);	
		$id		= filter($_REQUEST['id']);
		$sql="update manage_annual_report set status='$status',adminId='$adminID',modified_date=NOW() where id='$id'";
		if(!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_annual_report.php?action=view\">";
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$post_date = mysql_real_escape_string(date("Y-m-d",strtotime($_REQUEST['post_date'])));
	$name = filter($_REQUEST['name']);
	$year = filter($_REQUEST['year']);

	//---------------------------------------- uplaod  pdf  -----------------------------------------------
		$upload_pdf = '';
		$target_folder = 'annual_report/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$file_name = $_FILES['upload_pdf']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name) || preg_match("/.PhP/i", $file_name)){
    	echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_annual_report.php?action=add';</script>";
		exit;
		}
		else if($file_name!='')
		{
			if(($_FILES["upload_pdf"]["type"] == "application/PDF") || ($_FILES["upload_pdf"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_pdf']['tmp_name'], $target_path))
				{
					$upload_pdf = $temp_code.'_'.$file_name;
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='manage_annual_report.php?action=add';</script>";
				return;
				}
			 } else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_annual_report.php?action=add';</script>";
			 }		
		}
			
	$sql="INSERT INTO `manage_annual_report`(`post_date`,`adminId`,`year`,`name`,`upload_pdf`) VALUES (NOW(),'$adminID','$year','$name','$upload_pdf')";
	if(!mysql_query($sql,$dbconn)){	die('Error: ' . mysql_error());	}
	echo "<meta http-equiv=refresh content=\"0;url=manage_annual_report.php?action=view\">";
	} else {
	echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");location.href='manage_annual_report.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$name = filter($_REQUEST['name']);
	$year = filter($_REQUEST['year']);
	$post_date = mysql_real_escape_string(date("Y-m-d",strtotime($_REQUEST['post_date'])));
	$id  = filter($_REQUEST['id']);	

	//------------------------------------  Update Circulars PDF ----------------------------------------------------
		$upload_pdf = '';
		$target_folder = 'annual_report/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$file_name = $_FILES['upload_pdf']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name) || preg_match("/.PhP/i", $file_name)){
    	echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_annual_report.php?action=add';</script>";
		exit;
		}
		else if($_FILES['upload_pdf']['name'] != '')
		{
		  //Unlink the previuos image		  
		   $qpreviousimg=mysql_query("select upload_pdf from manage_annual_report where id='$id'");
		   $rpreviousimg=mysql_fetch_array($qpreviousimg);
		   $filename="annual_report/".$rpreviousimg['upload_pdf'];
		   unlink($filename);

			if(($_FILES["upload_pdf"]["type"] == "application/PDF") || ($_FILES["upload_pdf"]["type"] == "application/pdf"))
			{
				//$target_path = $target_folder.$temp_code.'_'.$_FILES['upload_pdf']['name'];
				$target_path = $target_folder.$temp_code.'_' . str_replace(' ', '_', $_FILES['upload_pdf']['name']);
				if(@move_uploaded_file($_FILES['upload_pdf']['tmp_name'], $target_path))
				{
					//$upload_pdf = $temp_code.'_'.$_FILES['upload_pdf']['name'];
					$getPdf = $temp_code.'_'.$_FILES['upload_pdf']['name'];
				    $upload_pdf = str_replace(' ', '_', $getPdf);
					$sql="update manage_annual_report set upload_pdf='$upload_pdf',adminId='$adminID',modified_date=NOW() where id='$id'";
					$result=mysql_query($sql);
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='manage_annual_report.php?action=edit&id=$id';</script>";
					return;
				}
			} else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_annual_report.php?action=edit&id=$id';</script>";
			 }	
		}
		
	$sql="update manage_annual_report set name='$name',year='$year',modified_date=NOW() where id='$id'";	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
		echo"<meta http-equiv=refresh content=\"0;url=manage_annual_report.php?action=view\">";		
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
<script language="javascript">
function checkdata()
{	
	if(document.getElementById('year').value == '')
	{
		alert("Please Choose Section");
		document.getElementById('year').focus();
		return false;
	}
	if(document.getElementById('name').value == '')
	{
		alert("Please Enter Title.");
		document.getElementById('name').focus();
		return false;
	}

	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.getElementById('upload_pdf').value == '')
	{
		alert("Please Upload PDF.");
		document.getElementById('upload_pdf').focus();
		return false;
	}
	<?php } ?>			
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Annual Report</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_annual_report.php?action=add"><div class="content_head_button">Add </div></a> <a href="manage_annual_report.php?action=view"><div class="content_head_button">View </div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
		<td>Post Date</td>
       	<td>Name</td>
       	<td>Year</td>        
        <td>PDF</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM manage_annual_report where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>
		<td><?php echo filter($row['name']); ?></td>
		<td><?php echo filter($row['year']); ?></td>		     
        <td>
        <?php if($row['upload_pdf']!=""){?>
        <a href="annual_report/<?php echo $row['upload_pdf']; ?>" target="_blank" style="color:#000000">View</a>
        <?php }?>
        </td>
        <td>
		<?php 
		if($row['status'] == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        } else if($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_annual_report.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_annual_report.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="manage_annual_report.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="manage_annual_report.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = mysql_query("SELECT * FROM manage_annual_report where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$id=filter($row2['id']);
			$year=filter($row2['year']);
			$name=filter($row2['name']);
			$upload_pdf=filter($row2['upload_pdf']);
			$post_date = stripslashes(date("d-m-Y",strtotime($row2['post_date'])));
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New </td>
    </tr>
	<tr>
      <td class="content_txt">Year</td>
  	  <td>
		  <select name="year" id="year" class="input_txt">
			<option value="">Year</option>
			<option value="2016" <?php if($year=="2016"){echo "selected='selected'";} ?>>2016</option>
			<option value="2017" <?php if($year=="2017"){echo "selected='selected'";} ?>>2017</option>
			<option value="2018" <?php if($year=="2018"){echo "selected='selected'";} ?>>2018</option>
			<option value="2019" <?php if($year=="2019"){echo "selected='selected'";} ?>>2019</option>
		  </select>
	  </td>
	</tr>
    <tr>
      <td class="content_txt">Name <span class="star">*</span></td>
      <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>    
    <tr>
		<td class="content_txt">Upload PDF <span class="star">*</span></td>
		<td><input name="upload_pdf" id="upload_pdf" type="file" /></td>
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