<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php 
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from election_for_coa_master where id=?";	
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", intval($_REQUEST['id']));
	if($stmtd->execute()){	echo"<meta http-equiv=refresh content=\"0;url=election_for_coa.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter($_REQUEST['id']);
	$sql = "update election_for_coa_master set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=election_for_coa.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$post_date = date('Y-m-d');
	$name = filter($_REQUEST['name']);
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	
	//---------------------------------------- uplaod  newsletter pdf  -----------------------------------------------
		$upload_pdf = '';
		$target_folder = 'COA/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$file_name = $_FILES['upload_pdf']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='election_for_coa.php?action=add';</script>";
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
				$status=1;
				$sql="INSERT INTO election_for_coa_master (name,upload_pdf,status,post_date) VALUES (?,?,?,?)";			
				$stmt = $conn -> prepare($sql);
				$stmt->bind_param("ssis", $name,$upload_pdf,$status,$post_date);
				$stmt->execute();
				echo"<meta http-equiv=refresh content=\"0;url=election_for_coa.php?action=view\">";
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='election_for_coa.php?action=add';</script>";
				return;
				}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='election_for_coa.php?action=add';</script>";
			 }		
		}
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='election_for_coa.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$name = filter($_REQUEST['name']);
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$id = filter($_REQUEST['id']);	

	//------------------------------------  Update Newsletter PDF ----------------------------------------------------------
		$upload_pdf = '';
		$target_folder = 'COA/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$file_name = $_FILES['upload_pdf']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='election_for_coa.php?action=add';</script>";
			exit;
		}
		else if($file_name != '')
		{
		  //Unlink the previuos image		  
		   $qpreviousimg = "select upload_pdf from election_for_coa_master where id=?";
		   $stmt = $conn -> prepare($qpreviousimg);
		   $stmt->bind_param("i", intval($id));
		   $stmt -> execute();
		   $result = $stmt->get_result();		   
		   $rpreviousimg = $result->fetch_assoc();
		   $filename="COA/".$rpreviousimg['upload_pdf'];
		   unlink($filename);

			if(($_FILES["upload_pdf"]["type"] == "application/PDF") || ($_FILES["upload_pdf"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_pdf']['tmp_name'], $target_path))
				{
					$upload_pdf = $temp_code.'_'.$file_name;
					$sql="update election_for_coa_master set upload_pdf=? where id=?";
					$stmt = $conn -> prepare($sql);
					$stmt->bind_param("si", $upload_pdf,$id);
					$stmt->execute();
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='election_for_coa.php?action=edit&id=$id';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='election_for_coa.php?action=edit&id=$id';</script>";
			 }	
		}	
		
	$sql="update election_for_coa_master set name='$name',post_date='$post_date' where id='$id'";	
	$stmt = $conn -> prepare($sql);
	$stmt->execute();
	echo"<meta http-equiv=refresh content=\"0;url=election_for_coa.php?action=view\">";
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='election_for_coa.php?action=add';</script>";
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
	if(document.getElementById('name').value == '')
	{
		alert("Please Enter Coa Name.");
		document.getElementById('name').focus();
		return false;
	}

	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.getElementById('upload_pdf').value == '')
	{
		alert("Please Upload pdf.");
		document.getElementById('upload_pdf').focus();
		return false;
	}
	<?php } ?>
	if(document.getElementById('post_date').value == '')
	{
		alert("Please enter Post Date.");
		document.getElementById('post_date').focus();
		return false;
	}
	/*if(!IsNumeric(document.getElementById('post_date').value))
	{
		alert("Please enter Numeric Value.")
		document.getElementById('post_date').focus();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage COA</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="election_for_coa.php?action=add"><div class="content_head_button">Add COA</div></a> <a href="election_for_coa.php?action=view"><div class="content_head_button">View COA</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>COA Name</td>
        <td>PDF</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$sqlx1 = "SELECT * FROM election_for_coa_master where 1".$attach." ";
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
        <?php if($row['upload_pdf']!=""){?>
        <a href="COA/<?php echo $row['upload_pdf']; ?>" target="_blank" style="color:#000000">View</a>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="election_for_coa.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="election_for_coa.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="election_for_coa.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="election_for_coa.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM election_for_coa_master  where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$name=filter($row2['name']);
			$upload_pdf=stripslashes($row2['upload_pdf']);
			$post_date = stripslashes(date("d-m-Y",strtotime($row2['post_date'])));
		}
  }
?>
 
<div class="content_details1 ">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New COA</td>
    </tr>
  	
    <tr>
      <td class="content_txt">COA Name <span class="star">*</span></td>
      <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" autocomplete="off"/></td>
    </tr>
    
    <tr>
    <td class="content_txt">Upload PDF <span class="star">*</span></td>
    <td><input name="upload_pdf" id="upload_pdf" type="file" /></td>
    </tr>

	<tr>
    <td class="content_txt">Date<span class="star">*</span></td>
    <td><input type="text" name="post_date" id="post_date" class="input_txt" value="<?php echo $post_date; ?>" autocomplete="off"/></td>
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