<?php session_start();
	ob_start();
 ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from health_master where id='$_REQUEST[id]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	//echo"<meta http-equiv=refresh content=\"0;url=manage_health.php?action=view\">";
	header("location:manage_health.php?action=view");
						exit;
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{

		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update health_master set status='$status' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		//echo"<meta http-equiv=refresh content=\"0;url=manage_health.php?action=view\">";
		header("location:manage_health.php?action=view");
						exit;
}

if ($_REQUEST['action']=='save')
{
	//$post_date = date('Y-m-d');
	 $post_date=$_REQUEST['p_date'];
	 $h_name=addslashes($_REQUEST['h_name']);
	 $h_desc=addslashes($_REQUEST['h_desc']);
		$export_attachment = '';
		$target_folder = '../health/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		
			if($_FILES['h_file']['name']!='')
			{	
				if (($_FILES["h_file"]["type"] == "application/pdf"))
				{
					$target_path = $target_folder.$_FILES['h_file']['name'];
					if(@move_uploaded_file($_FILES['h_file']['tmp_name'], $target_path))
					{
						 $h_file = $_FILES['h_file']['name'];
						
						$sql="INSERT INTO health_master (name,long_desc,h_file,status,post_date) VALUES ('$h_name','$h_desc','$h_file','1','$post_date')";		
						if (!mysql_query($sql,$dbconn))
						{
							die('Error: ' . mysql_error());
						}
						//echo"<meta http-equiv=refresh content=\"0;url=manage_health.php?action=view\">";
						header("location:manage_health.php?action=view");
						exit;
					}
					else
					{
						echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='manage_health.php?action=add';</script>";
					return;
					}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_health.php?action=add';</script>";
			 }	
			}
						
						
						
					
	
	
		
	
}


if ($_REQUEST['action']=='update')
{
	$id = $_REQUEST['id'];
	 $post_date=$_REQUEST['p_date'];
	 $h_name=addslashes($_REQUEST['h_name']);
	 $h_desc=addslashes($_REQUEST['h_desc']);
		
						$export_attachment = '';
		$target_folder = '../health/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		
			if($_FILES['h_file']['name']!='')
			{	
				if (($_FILES["h_file"]["type"] == "application/pdf"))
				{
					$target_path = $target_folder.$_FILES['h_file']['name'];
					if(@move_uploaded_file($_FILES['h_file']['tmp_name'], $target_path))
					{
						 $h_file = $_FILES['h_file']['name'];
						
						$sql="update health_master set name='$h_name',long_desc='$h_desc',status='1',h_file='$h_file',post_date='$post_date' where id='$id' ";		
						if (!mysql_query($sql,$dbconn))
						{
							die('Error: ' . mysql_error());
						}
						//echo"<meta http-equiv=refresh content=\"0;url=manage_health.php?action=view\">";
						header("location:manage_health.php?action=view");
						exit;
					}
					else
					{
						echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='manage_health.php?action=add';</script>";
					return;
					}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_health.php?action=add';</script>";
			 }	
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
<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#p_date').datepick();
	//$('#to_date').datepick();
	//$('#from_date').datepick();

});
</script>

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
<script language="javascript">
function checkdata()
{
	
	//alert(dte);
	
	if(document.getElementById('h_name').value == '')
	{
		alert("Please Enter Name");
		document.getElementById('h_name').focus();
		return false;
	}
	
	if(document.getElementById('h_desc').value == '')
	{
		alert("Please Enter Description.");
		document.getElementById('h_desc').focus();
		return false;
	}
	if(document.getElementById('p_date').value == '')
	{
		alert("Please Select Post Date")
		document.getElementById('p_date').focus();
		return false;
	}
	if(document.getElementById('h_file').value == '')
	{
		alert("Please Select File")
		document.getElementById('h_file').focus();
		return false;
	}
	
	 var ext = h_file.substring(h_file.lastIndexOf('.') + 1);
	if(ext!='pdf')
	{
		alert('Select Only PDF File');
		document.getElementById('h_file').focus();
		return false;
	}
	/* var ext = p_file.substring(p_file.lastIndexOf('.') + 1);
	if(ext!='pdf')
	{
		alert('Select Only PDF File');
		document.getElementById('p_file').focus();
		return false;
	}*/
	
	/*var x=document.getElementById('mobile_no').value;
	
	if (x.charAt(0)!="9" && x.charAt(0)!="8" && x.charAt(0)!="7")
   	{
		alert("It should start with 9 or 8 or 7");
		document.getElementById('mobile_no').focus();
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
<script language="javascript">
$(document).ready(function(){
 $("#role").change(function () {
	var role=$(this).val();
	if(role=="Super Admin")
	{
		$("#admin_access_div").hide();
	}else
	{
		$("#admin_access_div").show();
	}
	
 });
});
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Admin</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_health.php?action=add"><div class="content_head_button">Add Health Tip</div></a> <a href="manage_health.php?action=view"><div class="content_head_button">View Health Tip</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td > Title</td>
        <td >Sescription</td>
        <td>Post Date</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$result = mysql_query("SELECT * FROM health_master where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo stripslashes($row['name']); ?></td>
        <td><?php echo stripslashes($row['long_desc']); ?></td>
        <td><?php echo $row['post_date']; ?></td>
      
        
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_health.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_health.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td><a href="manage_health.php?action=edit&id=<?php echo $row['id']; ?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        
        <td><a href="manage_health.php?action=del&id=<?php echo $row['id']; ?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></a></td>
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
        
<!--<div class="pages">
    <ul>
        <a href="#"><li style="border-right:none;">Prev </li></a>
        <a href="#"><li>1 </li></a>
        <a href="#"><li>2 </li></a>
        <a href="#"> <li>3 </li> </a>
         <a href="#"><li>4 </li></a>
        <a href="#"><li style="border-right:none;">5 </li></a>
        <a href="#"><li style="border-right:none;">Next</li></a>	           
    </ul>
</div>-->
<?php } ?>        
 
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT *  FROM health_master  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			//print_r($row2);
			$name=stripslashes($row2['name']);
			$h_name=stripslashes($row2['long_desc']);
			$post_date=stripslashes($row2['post_date']);
			
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" enctype="multipart/form-data" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Admin</td>
    </tr>

    <tr>
    <td class="content_txt"> Title <span class="star">*</span></td>
    <td><input type="text" name="h_name" id="h_name" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $name;?>" />    </td>
    </tr>
  
   
    <tr>
    <td class="content_txt">Health Description <span class="star">*</span></td>
    <td><!--<input type="file" name="p_file" id="p_file" class="input_txt" />--><textarea name="h_desc" id="h_desc" class="show-tooltip input_txt"><?php echo $h_name;?></textarea>
           </td>
    </tr>
    <tr>
    <td class="content_txt">Browse <span class="star">*</span></td>
    <td><input type="file" name="h_file" id="h_file" class="input_txt" value="<?php echo $h_file;?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Post Date <span class="star">*</span></td>
    <td><input type="text" name="p_date" id="p_date" class="input_txt" value="<?php echo $post_date;?>" /></td>
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
