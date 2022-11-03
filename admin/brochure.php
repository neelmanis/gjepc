<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php'); 
?>
<?php
$adminID = filter($_SESSION['curruser_login_id']);

if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	//Unlink the previuos image		  
	$smx = "select upload_brochure from brochure where id=?";
	$stmt = $conn -> prepare($smx);
	$stmt->bind_param("i", $_REQUEST['id']);
	$stmt -> execute();
	$result = $stmt->get_result();		   
	$rpreviousimg = $result->fetch_assoc();
	$filename="brochure/".$rpreviousimg['upload_brochure'];
	unlink($filename);
	$sql="delete from brochure where id=?";	
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", $_REQUEST['id']);
	if($stmtd->execute()){
	echo"<meta http-equiv=refresh content=\"0;url=brochure.php?action=view\">";
	}
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id		= filter($_REQUEST['id']);
	$sql="update brochure set status='$status',adminId='$adminID' where id='$id'";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){
	echo"<meta http-equiv=refresh content=\"0;url=brochure.php?action=view\">";
	}
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$post_date = date('Y-m-d');
	$name=filter($_REQUEST['name']);
	$year=filter($_REQUEST['year']);
	$order_no=filter($_REQUEST['order_no']);
	
	//---------------------------------------- upload brochure pdf  -----------------------------------------------
		$upload_brochure = '';
		$target_folder = 'brochure/';
		$file_name = $_FILES['upload_brochure']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i", $file_name)) {
    		 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='brochure.php?action=add';</script>";
			exit;
		}
		else if($file_name !='')
		{
			if(($_FILES["upload_brochure"]["type"] == "application/pdf") || ($_FILES["upload_brochure"]["type"] == "application/PDF"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_brochure']['tmp_name'], $target_path))
				{
				$upload_brochure = $temp_code.'_'.$file_name;
			//	$sql="INSERT INTO brochure (name,upload_brochure,status,post_date,year,adminId) VALUES ('$name','$upload_brochure','1','$post_date','$year','$adminID')";
				$status=1;
				$sql="INSERT INTO brochure (name,upload_brochure,status,post_date,year,adminId) VALUES (?,?,?,?,?,?)";
				$stmt = $conn -> prepare($sql);
				$stmt->bind_param("sssssi", $name,$upload_brochure,$status,$post_date,$year,$adminID);
				if($stmt->execute()) { echo "<meta http-equiv=refresh content=\"0;url=brochure.php?action=view\">"; }
				else { die ("Mysql Update Error: " . $conn->error); }
				
				} else {
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='brochure.php?action=add';</script>";
				return;
				}
			 } else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='brochure.php?action=add';</script>";
			 }		
		}
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='brochure.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$name=filter($_REQUEST['name']);
	$year=filter($_REQUEST['year']);
	$order_no=filter($_REQUEST['order_no']);
	$id=filter($_REQUEST['id']);	

	//------------------------------------  Update Newsletter PDF ----------------------------------------------------------
		$upload_brochure = '';
		$target_folder = 'brochure/';
		$file_name = $_FILES['upload_brochure']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if(preg_match("/.php/i", $file_name)) {
    		 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='brochure.php?action=add';</script>";
			exit;
		}
		else if($file_name != '')
		{
		  //Unlink the previuos image		  
		   $qpreviousimg = "select upload_brochure from brochure where id=?";
		   $stmt = $conn -> prepare($qpreviousimg);
		   $stmt->bind_param("i", $id);
		   $stmt -> execute();
		   $result = $stmt->get_result();		   
		   $rpreviousimg = $result->fetch_assoc();
		   $filename="brochure/".$rpreviousimg['upload_brochure'];
		   unlink($filename);

			if(($_FILES["upload_brochure"]["type"] == "application/PDF") || ($_FILES["upload_brochure"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_brochure']['tmp_name'], $target_path))
				{
					$upload_brochure = $temp_code.'_'.$file_name;
					$sql="update brochure set upload_brochure='$upload_brochure' where id='$id'";
					$stmt = $conn -> prepare($sql);
					$stmt->execute();	
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='brochure.php?action=edit&id=$id';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='brochure.php?action=edit&id=$id';</script>";
			 }	
		}	
		
	$sql="update brochure set name='$name',year='$year',adminId='$adminID' where id='$id'";	
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=brochure.php?action=view\">"; } else { die('Error: ' . mysql_error()); }
	
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='tender.php?action=add';</script>";
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

<script language="javascript">
function checkdata()
{
	if(document.getElementById('name').value == '')
	{
		alert("Please Enter brochure Name.");
		document.getElementById('name').focus();
		return false;
	}
	if(document.getElementById('year').value == '')
	{
		alert("Please Enter brochure Year.");
		document.getElementById('year').focus();
		return false;
	}

	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.getElementById('upload_brochure').value == '')
	{
		alert("Please Upload brochure.");
		document.getElementById('upload_brochure').focus();
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
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage brochure</div></div>

<div id="main">
	<div class="content">
    <div class="content_head"><a href="brochure.php?action=add"><div class="content_head_button">Add brochure</div></a> <a href="brochure.php?action=view"><div class="content_head_button">View brochure</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>brochure Name</td>
        <td>PDF</td>
        <td>Year</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php   
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$asc_desc." ";
    
    $i=1;
	$sqlx1 = "SELECT * FROM brochure where 1";
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
        <td>
        <?php if($row['upload_brochure']!=""){?>
        <a href="brochure/<?php echo $row['upload_brochure']; ?>" target="_blank" style="color:#000000">View</a>
        <?php }?>
        </td>
            <td><?php echo $row['year']; ?></td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="brochure.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/active.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="brochure.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/inactive.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="brochure.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="brochure.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM brochure  where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", $_REQUEST['id']);
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$name=filter($row2['name']);
			$year=stripslashes($row2['year']);
			$upload_brochure=stripslashes($row2['upload_brochure']);
			$order_no=stripslashes($row2['order_no']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="POST" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New brochure</td>
    </tr>
  	
    <tr>
      <td class="content_txt">brochure Name <span class="star">*</span></td>
      <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>
    <tr>
      <td class="content_txt"> Year <span class="star">*</span></td>
      <td><input type="text" name="year" id="year" class="input_txt" value="<?php echo $year; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Upload brochure <span class="star">*</span></td>
    <td><input name="upload_brochure" id="upload_brochure" type="file" /></td>
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