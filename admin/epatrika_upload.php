<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
include('../functions.php');
?>

<?php
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from e_patrika where id=?";	
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", $_REQUEST['id']);
	if($stmtd->execute()){
	echo"<meta http-equiv=refresh content=\"0;url=epatrika_upload.php?action=view\">";
	}
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter($_REQUEST['id']);
	$sql = "update e_patrika set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){
	echo"<meta http-equiv=refresh content=\"0;url=epatrika_upload.php?action=view\">";
	}
}

if($_REQUEST['action']=='save')
{
	//validate Token
/*
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$post_date = date('Y-m-d');
	$name = filter($_REQUEST['name']);
	$year = filter($_REQUEST['year']);
	
	//---------------------------------------- upload epatrika pdf  -----------------------------------------------
		$upload_patrika = '';	
		$target_folder = '../epatrika/';
		$file_name = $_FILES['upload_patrika']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$file_name = str_replace(".phtml","",$file_name);
		$file_name = str_replace(".phtml.pdf","",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i", $file_name)) {
    		 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='epatrika_upload.php?action=add';</script>";
			exit;
		}
		else if($_FILES['upload_patrika']['name']!='')
		{
			if(($_FILES["upload_patrika"]["type"] == "application/PDF") || ($_FILES["upload_patrika"]["type"] == "application/pdf") || ($_FILES["upload_patrika"]["type"] == "text/html"))
			{ 
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				
				if(@move_uploaded_file($_FILES['upload_patrika']['tmp_name'], $target_path))
				{
				$upload_patrika = $temp_code.'_'.$file_name;
				$status=1;	
				$sql="INSERT INTO e_patrika (`post_date`, `name`, `year`, `html_files`, `status`) VALUES (?,?,?,?,?)";
				$stmt = $conn -> prepare($sql);
				$stmt->bind_param("ssssi", $post_date,$name,$year,$upload_patrika,$status);
				if($stmt->execute()) { echo "<meta http-equiv=refresh content=\"0;url=epatrika_upload.php?action=view\">"; }
				else { die ("Mysql Insert Error: " . $conn->error); }				
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='epatrika_upload.php?action=add';</script>";
				return;
				}
			} else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='epatrika_upload.php?action=add';</script>";
			 }
		}
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='epatrika_upload.php?action=add';</script>";
	}
	*/
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	//validate Token
/*
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$name=filter($_REQUEST['name']);
	$year=filter($_REQUEST['year']);
	$id=intval($_REQUEST['id']);	

	//------------------------------------  Update epatrika PDF ----------------------------------------------------------
		$upload_patrika = '';
		$target_folder = '../epatrika/';
		$file_name = $_FILES['upload_patrika']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$file_name = str_replace(".phtml","",$file_name);
		$file_name = str_replace(".phtml.pdf","",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i", $file_name)) {
    		 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='epatrika_upload.php?action=add';</script>";
			exit;
		}
		else if($file_name != '')
		{
		  //Unlink the previuos image
		   $qpreviousimg = "select html_files from e_patrika where id=?";
		   $stmt = $conn -> prepare($qpreviousimg);
		   $stmt->bind_param("i", $id);
		   $stmt -> execute();
		   $result = $stmt->get_result();		   
		   $rpreviousimg = $result->fetch_assoc();
		   $filename="../epatrika/".$rpreviousimg['html_files'];
		   unlink($filename);

			if(($_FILES["upload_patrika"]["type"] == "application/PDF") || ($_FILES["upload_patrika"]["type"] == "application/pdf") || ($_FILES["upload_patrika"]["type"] == "text/html"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_patrika']['tmp_name'], $target_path))
				{
					$upload_patrika = $temp_code.'_'.$file_name;
					$sql="update e_patrika set html_files=? where id=?";
					$stmt = $conn -> prepare($sql);
					$stmt->bind_param("si", $upload_patrika,$id);
					$stmt->execute();
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='epatrika_upload.php?action=edit&id=$id';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='epatrika_upload.php?action=edit&id=$id';</script>";
			 }
		}	
		
	$sql="update e_patrika set name='$name',year='$year' where id='$id'";	
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=epatrika_upload.php?action=view\">"; }
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='epatrika_upload.php?action=add';</script>";
	}
	*/
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E-Patrika</title>
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
		alert("Please Enter E-Patrika Title.");
		document.getElementById('name').focus();
		return false;
	}
	if(document.getElementById('year').value == '')
	{
		alert("Please Choose Year.");
		document.getElementById('year').focus();
		return false;
	}
	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.getElementById('upload_patrika').value == '')
	{
		alert("Please Upload E-Patrika.");
		document.getElementById('upload_patrika').focus();
		return false;
	}
	<?php } ?>
			
}
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage E-Patrika</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="epatrika_upload.php?action=add"><div class="content_head_button">Add E-Patrika</div></a> <a href="epatrika_upload.php?action=view"><div class="content_head_button">View E-Patrika</div></a></div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt">
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Name</td>
        <td>Status</td>
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$sqlx1 = "SELECT * FROM e_patrika where 1".$attach." ";
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
	    <td><?php echo $row['name']; ?></td>
        <td>
        <?php if($row['html_files']!=""){?>
        <a href="../epatrika/<?php echo $row['html_files']; ?>" target="_blank" style="color:#000000">View</a>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="epatrika_upload.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="epatrika_upload.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td>
		<a href="epatrika_upload.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0"/></a></td>
        <td ><a href="epatrika_upload.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM e_patrika where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", $_REQUEST['id']);
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$name=filter($row2['name']);
			$year=filter($row2['year']);
			$upload_tender=stripslashes($row2['html_files']);
		}
  }
?>
 
<div class="content_details1">
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New E-Patrika</td>
    </tr>
  	
    <tr>
    <td class="content_txt">E-Patrika Title<span class="star">*</span></td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>"/></td>
    </tr>
    
	<tr>
    <td class="content_txt">Year <span class="star">*</span></td>
    <td>
	<select name="year" id="year">
	  <option value="">Choose Year</option>
	  <option value="2016" <?php if($year=='2016') echo 'selected="selected"';?>>2016</option>
	  <option value="2017" <?php if($year=='2017') echo 'selected="selected"';?>>2017</option>
	  <option value="2018" <?php if($year=='2018') echo 'selected="selected"';?>>2018</option>
	  <option value="2019" <?php if($year=='2019') echo 'selected="selected"';?>>2019</option>
	  <option value="2020" <?php if($year=='2020') echo 'selected="selected"';?>>2020</option>
	</select>
	</td>
    </tr>
	
    <tr>
    <td class="content_txt">Upload E-Patrika<span class="star">*</span></td>
    <td><input name="upload_patrika" id="upload_patrika" type="file" /></td>
    </tr>
	
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id'];?>" />    </td>
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