<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
include('../db.inc.php');
include('../functions.php'); 
?>
<?php
$adminID = filter($_SESSION['curruser_login_id']);

if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from gst_upload where id=?";	
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", intval($_REQUEST['id']));
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=manage_gst_upload.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = intval(filter($_REQUEST['id']));
	$sql="update gst_upload set status='$status',adminId='$adminID',modified_date=NOW() where id='$id'";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=manage_gst_upload.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$name 	   = filter($_REQUEST['name']);
	$section_id	= filter($_REQUEST['section_id']);

	//---------------------------------------- uplaod  pdf  -----------------------------------------------
		$upload_pdf = '';
		$target_folder = 'gstpdf/';
		$file_name = $_FILES['upload_pdf']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='gold_rate.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{
			if(($_FILES["upload_pdf"]["type"] == "application/PDF") || ($_FILES["upload_pdf"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['upload_pdf']['name'];
				if(@move_uploaded_file($_FILES['upload_pdf']['tmp_name'], $target_path))
				{
				$upload_pdf = $temp_code.'_'.$_FILES['upload_pdf']['name'];
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='manage_gst_upload.php?action=add';</script>";
				return;
				}
			 } else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_gst_upload.php?action=add';</script>";
			 }		
		}
			
		$sql="INSERT INTO `gst_upload`(`post_date`, `adminId`,`section_id`, `name`, `upload_pdf`,`status`) VALUES (NOW(),'$adminID','$section_id','$name','$upload_pdf','1')";
		$stmt = $conn -> prepare($sql);
		$stmt->execute();
		echo"<meta http-equiv=refresh content=\"0;url=manage_gst_upload.php?action=view\">";
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$name = filter($_REQUEST['name']);
	$section_id=filter($_REQUEST['section_id']);
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$id=filter($_REQUEST['id']);	

	//------------------------------------  Update Circulars PDF ----------------------------------------------------
		$upload_pdf = '';
		$target_folder = 'gstpdf/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		if($_FILES['upload_pdf']['name'] != '')
		{
		  //Unlink the previuos image		  
		   $qpreviousimg=$conn ->query("select upload_pdf from gst_upload where id='$id'");
		   $rpreviousimg=$qpreviousimg->fetch_assoc();
		   $filename="gstpdf/".$rpreviousimg['upload_pdf'];
		   unlink($filename);

			if(($_FILES["upload_pdf"]["type"] == "application/PDF") || ($_FILES["upload_pdf"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['upload_pdf']['name'];
				if(@move_uploaded_file($_FILES['upload_pdf']['tmp_name'], $target_path))
				{
					$upload_pdf = $temp_code.'_'.$_FILES['upload_pdf']['name'];
					$sql="update gst_upload set upload_pdf='$upload_pdf',adminId='$adminID',modified_date=NOW() where id='$id'";
					$result=$conn ->query($sql);
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='manage_gst_upload.php?action=edit&id=$id';</script>";
					return;
				}
			} else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_gst_upload.php?action=edit&id=$id';</script>";
			 }	
		}
		
	$sql="update gst_upload set name='$name',section_id='$section_id',modified_date=NOW() where id='$id'";
	$result = $conn ->query($sql);   
    if(!$result) die ($conn->error);
	echo"<meta http-equiv=refresh content=\"0;url=manage_gst_upload.php?action=view\">";	
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
	if(document.getElementById('section_id').value == '')
	{
		alert("Please Choose Section");
		document.getElementById('section_id').focus();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage GST PDF</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_gst_upload.php?action=add"><div class="content_head_button">Add </div></a> <a href="manage_gst_upload.php?action=view"><div class="content_head_button">View </div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
		<td>Post Date</td>
       	<td>Name</td>
       	<td>Section</td>        
        <td>PDF</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$sqlx1 = "SELECT * FROM gst_upload where 1".$attach." ";
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
	    <td><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>
		<td><?php echo filter($row['name']); ?></td>     
		<td>
		<?php 
		if($row['section_id'] == '1') 
        { echo "Council Circular";
        }else if($row['section_id'] == '2') 
        { echo "Govt Circular";
        }
        ?>
		</td>        
        <td>
        <?php if($row['upload_pdf']!=""){?>
        <a href="gstpdf/<?php echo $row['upload_pdf']; ?>" target="_blank" style="color:#000000">View</a>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_gst_upload.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_gst_upload.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="manage_gst_upload.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="manage_gst_upload.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM gst_upload where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$id=filter($row2['id']);
			$section_id=filter($row2['section_id']);
			$name=filter($row2['name']);
			$upload_pdf=filter($row2['upload_pdf']);
			$post_date = filter(date("d-m-Y",strtotime($row2['post_date'])));
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New </td>
    </tr>
	<tr>
      <td class="content_txt">Section</td>
  	  <td>
		  <select name="section_id" id="section_id" class="input_txt">
			<option value="">Section</option>
			<option value="1" <?php if($section_id=="1"){echo "selected='selected'";} ?>>Council Circular</option>
			<option value="2" <?php if($section_id=="2"){echo "selected='selected'";} ?>>Govt Circular</option>
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