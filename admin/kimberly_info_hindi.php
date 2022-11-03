<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['kid']!=''))
{
	$sql="delete from kimberly_info_hindi where kid='$_REQUEST[kid]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=kimberly_info_hindi.php?action=view\">";
}

if (($_REQUEST['action']=='active') && ($_REQUEST['kid']!=''))
{

		$status=$_REQUEST['status'];	
		//$id=$_REQUEST['kid'];
		$sql="update kimberly_info_hindi set status='$status' where kid='$_REQUEST[kid]'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=kimberly_info_hindi.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$name=mysql_real_escape_string($_REQUEST['name']);
	$upload_kimberly_info=mysql_real_escape_string($_REQUEST['upload_kimberly_info']);
	$order_no=mysql_real_escape_string($_REQUEST['order_no']);
	
	
		$sql="INSERT INTO kimberly_info_hindi (name,upload_kimberly_info,order_no,status,post_date) VALUES ('$name','$upload_kimberly_info','$order_no','1','$post_date')";
			
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=kimberly_info_hindi.php?action=view\">";

}
if (($_REQUEST['action']=='update')&&($_REQUEST['kid']!=''))
{
	$name=mysql_real_escape_string($_REQUEST['name']);
	$upload_kimberly_info=mysql_real_escape_string($_REQUEST['upload_kimberly_info']);
	$order_no=mysql_real_escape_string($_REQUEST['order_no']);
	$id=mysql_real_escape_string($_REQUEST['kid']);	

		
	$sql="update kimberly_info_hindi set name='$name',upload_kimberly_info='$upload_kimberly_info',order_no='$order_no' where kid='$_REQUEST[kid]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=kimberly_info_hindi.php?action=view\">";
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
<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>


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
	if(document.getElementById('name').value == '')
	{
		alert("Please Enter KimberlyInfo Name.");
		document.getElementById('name').focus();
		return false;
	}
	
	
	if(document.getElementById('upload_kimberly_info').value == '')
	{
		alert("Please Enter Kimberly info.");
		document.getElementById('upload_kimberly_info').focus();
		return false;
	}

	/*<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	if(document.getElementById('upload_kimberly_info').value == '')
	{
		alert("Please Upload KimberlyInfo.");
		document.getElementById('upload_kimberly_info').focus();
		return false;
	}
	<?php } ?>*/
/*	if(document.getElementById('order_no').value == '')
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


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Kimberly Info</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="kimberly_info_hindi.php?action=add">
    	<div class="content_head_button">Add Kimberly Info</div>
    	</a> <a href="kimberly_info_hindi.php?action=view">
    	<div class="content_head_button">View Kimberly Info</div>
    	</a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Kimberly Info Name</td>
        <td>Post Date</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'order_no';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM kimberly_info_hindi where 1".$attach." ");
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
		<td><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>
        <!--<td>
        <?php if($row['upload_kimberly_info']!=""){?>
        <a href="KimberlyInfohindi/<?php echo $row['upload_kimberly_info']; ?>" target="_blank" style="color:#000000">View</a>
        <?php }?>
        </td>-->
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="kimberly_info_hindi.php?kid=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="kimberly_info_hindi.php?id=<?php echo $row['kid']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="kimberly_info_hindi.php?action=edit&kid=<?php echo $row['kid']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="kimberly_info_hindi.php?action=del&kid=<?php echo $row['kid']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
  if(($_REQUEST['kid']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT *  FROM kimberly_info_hindi  where kid='$_REQUEST[kid]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$name=stripslashes($row2['name']);
			$upload_kimberly_info=stripslashes($row2['upload_kimberly_info']);
			$order_no=stripslashes($row2['order_no']);
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Kimberly Info</td>
    </tr>
  	
    <tr>
      <td class="content_txt">Kimberly Info Name <span class="star">*</span></td>
      <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>
    <tr>
      <td class="content_txt">Kimberly Info <span class="star">*</span></td>
      <td><textarea name="upload_kimberly_info" class="input_txt" id="upload_kimberly_info"><?php echo $upload_kimberly_info; ?></textarea>
      <script type="text/javascript">
CKEDITOR.replace( 'upload_kimberly_info',
                {
                    filebrowserBrowseUrl :'js/ckeditor/filemanager/browser/default/browser.html?Connector=/admin/js/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserImageBrowseUrl : 'js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=/admin/js/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserFlashBrowseUrl :'js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=/admin/js/ckeditor/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'/admin/js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '/admin/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserFlashUploadUrl : '/admin/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash',
					width:800
				});
</script>   
      </td>
    </tr>
	
  <!--  <tr>
    <td class="content_txt">Upload Kimberly Info <span class="star">*</span></td>
    <td><input name="upload_kimberly_info" id="upload_kimberly_info" type="file" /></td>
    </tr>-->

	<!--<tr>
    <td class="content_txt">Order No <span class="star">*</span></td>
    <td><input type="text" name="order_no" id="order_no" class="input_txt" value="<?php //echo $order_no; ?>" /></td>
    </tr>-->
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['kid'];?>" />    </td>
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
