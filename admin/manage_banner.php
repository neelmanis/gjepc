<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php'); 
?>
<?php
function getCountHits($banner_id,$conn)
{
	$sql="SELECT count(*) as total from banner_hits where banner_id='$banner_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();	 		
	return $row['total'];
}

if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from home_banner_master where id='$_REQUEST[id]'";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", $_REQUEST['id']);
	if($stmt->execute()){
	echo "<meta http-equiv=refresh content=\"0;url=manage_banner.php?action=view\">";
	}
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status=$_REQUEST['status'];	
	$id=$_REQUEST['id'];
	$sql="update home_banner_master set status='$status' where id='$id'";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){
		echo "<meta http-equiv=refresh content=\"0;url=manage_banner.php?action=view\">";
	}
}

if ($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$post_date = date('Y-m-d');
	$banner_website = filter($_REQUEST['banner_website']);
	$banner_name = filter($_REQUEST['banner_name']);
	$url = filter($_REQUEST['url']);
	$target = filter($_REQUEST['target']);
	$order_no = filter($_REQUEST['order_no']);
	
	//---------------------------------------- UPLOAD BANNER  -----------------------------------------------
		$banner_image = '';
		$target_folder = 'Banner/';
		$file_name = $_FILES['banner_image']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_banner.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{
			if(($_FILES["banner_image"]["type"] == "image/png") || ($_FILES["banner_image"]["type"] == "image/jpeg") || ($_FILES["banner_image"]["type"] == "image/jpg") || ($_FILES["banner_image"]["type"] == "image/PNG") || ($_FILES["banner_image"]["type"] == "image/JPEG") || ($_FILES["banner_image"]["type"] == "image/JPG"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['banner_image']['name'];
				if(@move_uploaded_file($_FILES['banner_image']['tmp_name'], $target_path))
				{
				$banner_image = $temp_code.'_'.$_FILES['banner_image']['name'];
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='manage_banner.php?action=add';</script>";
				return;
				}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_banner.php?action=add';</script>";
			 }		
		}
	
		$sqlx="INSERT INTO banner_master (banner_website,banner_name,banner_image,url,target,'order_no',post_date,status) VALUES ('$banner_website','$banner_name','$banner_image','$url','$target','order_no','$post_date','1')";
		$result = $conn ->query($sqlx);
		if($result){ echo "<meta http-equiv=refresh content=\"0;url=manage_banner.php?action=view\">"; } else { die ($conn->error); }
		
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='manage_banner.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$banner_website=filter($_REQUEST['banner_website']);
	$banner_name=filter($_REQUEST['banner_name']);
	$url=filter($_REQUEST['url']);
	$target=filter($_REQUEST['target']);
	$order_no=filter($_REQUEST['order_no']);
	$id=filter($_REQUEST['id']);	

	//------------------------------------  Update Newsletter PDF ----------------------------------------------------------
		$banner_image = '';
		$target_folder = 'Banner/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['banner_image']['name'] != '')
		{
		  //Unlink the previuos image
		  
		   $qpreviousimg=mysql_query("select banner_image from banner_master where id='$id'");
		   $rpreviousimg=mysql_fetch_array($qpreviousimg);
		   $filename="Banner/".$rpreviousimg['banner_image'];
		   unlink($filename);

			if (($_FILES["banner_image"]["type"] == "image/gif") || ($_FILES["banner_image"]["type"] == "image/jpeg") || ($_FILES["banner_image"]["type"] == "image/pjpeg") ||($_FILES["banner_image"]["type"] == "image/png"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['banner_image']['name'];
				if(@move_uploaded_file($_FILES['banner_image']['tmp_name'], $target_path))
				{
					$banner_image = $temp_code.'_'.$_FILES['banner_image']['name'];
					$sql="update banner_master set banner_image='$banner_image' where id='$id'";
					$result=mysql_query($sql);
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='manage_banner.php?action=edit&id=$id';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_banner.php?action=edit&id=$id';</script>";
			 }	
		}	
		
	$sql="update banner_master set banner_position='$banner_position',banner_name='$banner_name',url='$url',target='$target',order_no='$order_no' where id='$id'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_banner.php?action=view\">";
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
		if(document.form1.banner_position.value=='')
	{
		alert("Please select banner position")
		document.form1.banner_position.focus();
		return false
	}
	if(document.form1.banner_name.value=='')
	{
		alert("Please enter banner name")
		document.form1.banner_name.focus();
		return false
	}
	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.form1.banner_image.value=='')
	{
		alert("Please upload banner image")
		document.form1.banner_image.focus();
		return false
	}
	<?php }?>
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
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Banner</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">
		<!--<a href="manage_banner.php?action=add"><div class="content_head_button">Add Banner</div></a> 
		<a href="manage_banner.php?action=view"><div class="content_head_button">View Banner</div></a>--> 
		<a href="export_website_banner_report.php"><div class="content_head_button">Export Website Banner Report</div></a> 
		<a href="export_app_banner_report.php"><div class="content_head_button">Export App Banner Report</div></a>
		</div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Banner ID</a></td>
        <td>Banner Type</td>
        <td>Banner Website</td>
        <td>Banner Name</td>
        <td>Banner Image</td>
        <td>Status</td>
        <td>View Hits</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'banner_website';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$sqlx1 = "SELECT * FROM home_banner_master where 1 ".$attach." ";
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
        <td><?php echo $row['id'];?></td>
        <td><?php echo strtoupper($row['type']); ?></td>
        <td><?php echo $row['banner_website']; ?></td>
        <td><?php echo $row['banner']; ?></td>
        <td>
		<?php if($row['banner']!=""){ ?>
		<?php if($row['banner_website']=="GJEPC"){ ?>
		<img src="../assets/images/banner/<?php echo $row['banner'];?>" width="100px" height="50px" />
		<?php } else if($row['banner_website']=="SIGNATURE"){ ?>
		<img src="../iijs-signature/assets/images/banner_slider/<?php echo $row['banner'];?>" width="100px" height="50px" />
		<?php } else if($row['banner_website']=="IGJME"){ ?>
		<img src="/igjme/assets-new/images/banner/<?php echo $row['banner'];?>" width="100px" height="50px" />
		<?php } ?>
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
		<td><?php echo getCountHits($row['id'],$conn)?></td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_banner.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_banner.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } ?></td>
        
        <!--<td ><a href="manage_banner.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>-->
        <td ><a href="manage_banner.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = $conn ->query("SELECT *  FROM banner_master  where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{
			$banner_position=stripslashes($row2['banner_position']);
			$banner_name=stripslashes($row2['banner_name']);
			$banner_image=stripslashes($row2['banner_image']);
			$urls=stripslashes($row2['url']);
			$target=stripslashes($row2['target']);
			$order_no=stripslashes($row2['order_no']);
		}
  }
?>
 
<div class="content_details1">

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Banner</td>
    </tr>
  	
    <tr>
      <td class="content_txt">Website Banner <span class="star">*</span></td>
      <td>
      	  <select id="banner_website" name="banner_website">
          <option value="">--Select Website--</option>
          <option value="GJEPC" <?php if($banner_website=="GJEPC"){?> selected="selected" <?php }?>>GJEPC</option>
          <option value="IIJS_PREMIERE" <?php if($banner_website=="IIJS_PREMIERE"){?> selected="selected" <?php }?>>IIJS PREMIERE</option>
          </select>
      </td>
   	</tr> 
    
    <tr>
      <td class="content_txt">Banner Name <span class="star">*</span></td>
      <td><input type="text" name="banner_name" id="banner_name" class="input_txt" value="<?php echo $banner_name; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Upload Banner <span class="star">*</span></td>
    <td><input name="banner_image" id="banner_image" type="file" class="input_txt" /></td>
    </tr>
	
    <tr>
    <td class="content_txt">Url</td>
    <td><input type="text" id="url" name="url" value="<?php echo $urls;?>" class="input_txt"/></td>
   </tr>
        
        <tr>
          <td class="content_txt">Target</td>
          <td>
           <?php
		  if($target=="_blank")
		  {		  
          echo "<input type='radio' name='target' id='target' value='_blank' checked='checked' />Blank";
          echo "<input type='radio' name='target' id='target' value='_self' />Self";
		  }else
		  {		  
          echo "<input type='radio' name='target' id='target' value='_blank' />Blank";
          echo "<input type='radio' name='target' id='target' value='_self' checked='checked' />Self";
		  }		  
		  ?>
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