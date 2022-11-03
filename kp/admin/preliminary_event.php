<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from kp_tajmahal where id='$_REQUEST[id]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=preliminary_event.php?action=view\">";
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{

		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update kp_tajmahal set status='$status' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=preliminary_event.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$banner_position=mysql_real_escape_string($_REQUEST['banner_position']);
	$banner_name=mysql_real_escape_string($_REQUEST['banner_name']);
	$url=mysql_real_escape_string($_REQUEST['url']);
	$target=mysql_real_escape_string($_REQUEST['target']);
	$order_no=mysql_real_escape_string($_REQUEST['order_no']);
	
	//---------------------------------------- uplaod  newsletter pdf  -----------------------------------------------
		$banner_image = '';
		$target_folder = 'Banner/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['banner_image']['name']!='')
		{
			if (($_FILES["banner_image"]["type"] == "image/gif") || ($_FILES["banner_image"]["type"] == "image/jpeg") || ($_FILES["banner_image"]["type"] == "image/pjpeg") ||($_FILES["banner_image"]["type"] == "image/png"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['banner_image']['name'];
				if(@move_uploaded_file($_FILES['banner_image']['tmp_name'], $target_path))
				{
				$banner_image = $temp_code.'_'.$_FILES['banner_image']['name'];
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='preliminary_event.php?action=add';</script>";
				return;
				}
			 }else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='preliminary_event.php?action=add';</script>";
			 }		
		}
	
		$sql="INSERT INTO kp_tajmahal (banner_position,banner_name,banner_image,url,target,post_date,status) VALUES ('$banner_position','$banner_name','$banner_image','$url','$target','$post_date','1')";
			
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=preliminary_event.php?action=view\">";

}
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$banner_position=mysql_real_escape_string($_REQUEST['banner_position']);
	$banner_name=mysql_real_escape_string($_REQUEST['banner_name']);
	$url=mysql_real_escape_string($_REQUEST['url']);
	$target=mysql_real_escape_string($_REQUEST['target']);
	$order_no=mysql_real_escape_string($_REQUEST['order_no']);
	$id=mysql_real_escape_string($_REQUEST['id']);	

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
		  
		   $qpreviousimg=mysql_query("select banner_image from kp_tajmahal where id='$id'");
		   $rpreviousimg=mysql_fetch_array($qpreviousimg);
		   $filename="Banner/".$rpreviousimg['banner_image'];
		   unlink($filename);

			if (($_FILES["banner_image"]["type"] == "image/gif") || ($_FILES["banner_image"]["type"] == "image/jpeg") || ($_FILES["banner_image"]["type"] == "image/pjpeg") ||($_FILES["banner_image"]["type"] == "image/png"))
			{
				$target_path = $target_folder.$temp_code.'_'.$_FILES['banner_image']['name'];
				if(@move_uploaded_file($_FILES['banner_image']['tmp_name'], $target_path))
				{
					$banner_image = $temp_code.'_'.$_FILES['banner_image']['name'];
					$sql="update kp_tajmahal set banner_image='$banner_image' where id='$id'";
					$result=mysql_query($sql);
				}
				else
				{
					echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='preliminary_event.php?action=edit&id=$id';</script>";
					return;
				}
			}else
			 {
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='preliminary_event.php?action=edit&id=$id';</script>";
			 }	
		}	
		
	$sql="update kp_tajmahal set banner_position='$banner_position',banner_name='$banner_name',url='$url',target='$target',order_no='$order_no' where id='$id'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=preliminary_event.php?action=view\">";
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
	<div class="breadcome"><a href="admin.php">Home</a> > Preliminary Event</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">
        <!--<a href="preliminary_event.php?action=add"><div class="content_head_button">Add Banner</div></a> -->
        <a href="preliminary_event.php?action=view"><div class="content_head_button">View Data</div></a> 
    </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
        <td>Name</td>
        <td>Passport No</td>
        <td>Passport Issuing Country</td>
        <td>Date of Issue</td>
        <td>Date of Expiry</td>
        <td>Download Attched Passport Copy</td>
        <td>Post Date</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM kp_tajmahal where 1 ".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['passport_no']; ?></td>
        <td><?php echo $row['passport_issuing_country'];?></td>
        <td><?php echo $row['date_of_issue'];?></td>
        <td><?php echo $row['date_of_expiry'];?></td>
        <td><a href="https://gjepc.org/kp-tajmahal/passport_copy/<?php echo $row['attched_passport_copy']?>" target="_blank">Download Passport Copy</a></td>
        <td><?php echo $row['post_date']; ?></td>
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
		$result2 = mysql_query("SELECT *  FROM kp_tajmahal  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
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
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Banner</td>
    </tr>
  	
    <tr>
      <td class="content_txt">Banner Position <span class="star">*</span></td>
      <td>
      	  <select id="banner_position" name="banner_position">
          <option value="">--Select Position--</option>
          <option value="Bottom First" <?php if($banner_position=="Bottom First"){?> selected="selected" <?php }?>>Bottom First</option>
          <option value="Bottom Second" <?php if($banner_position=="Bottom Second"){?> selected="selected" <?php }?>>Bottom Second</option>
          <option value="Bottom Third" <?php if($banner_position=="Bottom Third"){?> selected="selected" <?php }?>>Bottom Third</option>
         
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
