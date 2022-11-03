<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php 
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from gold_rate_master where id='".$_REQUEST['id']."'";	
	$stmtd = $conn -> query($sql);
	if($stmtd){	echo"<meta http-equiv=refresh content=\"0;url=gold_rate.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter(intval($_REQUEST['id']));
	$sql = "update gold_rate_master set status='$status' where id='$id'";
	$stmt = $conn -> query($sql);
	if($stmt){		echo"<meta http-equiv=refresh content=\"0;url=gold_rate.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {

	$post_date = date('Y-m-d');
	$name	=	filter($_REQUEST['name']);	
	//---------------------------------------- upload  newsletter pdf  -----------------------------------------------
		$upload_gold_rate = '';
		$target_folder = 'GoldRate/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$file_name = $_FILES['upload_gold_rate']['name'];
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$file_name = str_replace("'","",$file_name);		
		$file_name = str_replace(".phtml","",$file_name);
		$file_name = str_replace(".PhaR","",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='gold_rate.php?action=add';</script>";
			exit;
		}
		else if($file_name!='')
		{
			if(($_FILES["upload_gold_rate"]["type"] == "application/PDF") || ($_FILES["upload_gold_rate"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_gold_rate']['tmp_name'], $target_path))
				{
				$upload_gold_rate = $temp_code.'_'.$file_name;
				$status=1;
				$sql  = "INSERT INTO gold_rate_master (name,upload_gold_rate,status,post_date) VALUES ('$name','$upload_gold_rate','$status','$post_date')";
				$result = $conn ->query($sql);  				
				if($result) {  echo "<meta http-equiv=refresh content=\"0;url=gold_rate.php?action=view\">"; }
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='gold_rate.php?action=add';</script>";
				return;
				}
			 } else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='gold_rate.php?action=add';</script>";
			 }		
		}
	} else {
	 echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");location.href='gold_rate.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$name = filter($_REQUEST['name']);
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$id=filter($_REQUEST['id']);	

	//------------------------------------  Update Gold Rate PDF ----------------------------------------------------------
		$upload_gold_rate = '';
		$target_folder = 'GoldRate/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		if(preg_match("/.php/i", $_FILES['upload_gold_rate']['name'])) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='gold_rate.php?action=add';</script>";
			exit;
		}
		else if($_FILES['upload_gold_rate']['name'] != '')
		{
		  //Unlink the previuos image		  
		   $qpreviousimg = "select upload_gold_rate from gold_rate_master where id=?";
		   $stmt = $conn -> prepare($qpreviousimg);
		   $stmt->bind_param("i", intval($id));
		   $stmt -> execute();
		   $result = $stmt->get_result();		   
		   $rpreviousimg = $result->fetch_assoc();
		   $filename="GoldRate/".$rpreviousimg['upload_gold_rate'];
		   unlink($filename);

			if(($_FILES["upload_gold_rate"]["type"] == "application/PDF") || ($_FILES["upload_gold_rate"]["type"] == "application/pdf"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['upload_gold_rate']['name'];
				if(@move_uploaded_file($_FILES['upload_gold_rate']['tmp_name'], $target_path))
				{
					$upload_gold_rate = $temp_code.'_'.$_FILES['upload_gold_rate']['name'];
					$sql="update gold_rate_master set upload_gold_rate='$upload_gold_rate' where id='$id'";
					$stmt = $conn -> query($sql);
					$stmt->execute();
				} else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='gold_rate.php?action=edit&id=$id';</script>";
					return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='gold_rate.php?action=edit&id=$id';</script>";
			}	
		}	
		
	$sql="update gold_rate_master set name='$name',post_date='$post_date' where id='$id'";	
	$stmt = $conn -> prepare($sql);
	$stmt->execute();
	echo"<meta http-equiv=refresh content=\"0;url=gold_rate.php?action=view\">";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gold Rate</title>
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
		alert("Please Enter Gold Rate Name.");
		document.getElementById('name').focus();
		return false;
	}

	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.getElementById('upload_gold_rate').value == '')
	{
		alert("Please Upload Gold Rate.");
		document.getElementById('upload_gold_rate').focus();
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
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>
<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Gold Rate</div>
</div>

<div id="main">
	<div class="content">
    <div class="content_head"><a href="gold_rate.php?action=add"><div class="content_head_button">Add Gold Rate</div></a> 
	<a href="gold_rate.php?action=view"><div class="content_head_button">View Gold Rate</div></a>
	</div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>GoldRate Name</td>
        <td>PDF</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = $conn ->query("SELECT * FROM gold_rate_master where 1".$attach." ");
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
        <td>
        <?php if($row['upload_gold_rate']!=""){ ?>
        <a href="GoldRate/<?php echo $row['upload_gold_rate']; ?>" target="_blank" style="color:#000000">View</a>
        <?php } ?>
        </td>
        <td>
		<?php 
		if($row['status'] == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        } elseif($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="gold_rate.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="gold_rate.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td><a href="gold_rate.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td><a href="gold_rate.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM gold_rate_master where id='".$_REQUEST['id']."'";
		$result2 = $conn -> query($sql3);
		if($row2 = $result2->fetch_assoc())
		{
			$name	=	filter($row2['name']);
			$upload_gold_rate=stripslashes($row2['upload_gold_rate']);
			$post_date = stripslashes(date("d-m-Y",strtotime($row2['post_date'])));
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Gold Rate</td>
    </tr>  	
    <tr>
    <td class="content_txt">Gold Rate Name <span class="star">*</span></td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>    
    <tr>
    <td class="content_txt">Upload Gold Rate <span class="star">*</span></td>
    <td><input name="upload_gold_rate" id="upload_gold_rate" type="file" /></td>
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
