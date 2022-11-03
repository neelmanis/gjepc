<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php'); 
?>
<?php 
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from whatsapp_templates_master where id='".$_REQUEST['id']."'";
	$stmt = $conn -> query($sql);

	if($stmt){
	echo"<meta http-equiv=refresh content=\"0;url=manage_templates.php?action=view\">";
	}
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = intval(filter($_REQUEST['id']));	
	$sql="update whatsapp_templates_master set status='$status' where id='$id'";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){
		echo"<meta http-equiv=refresh content=\"0;url=manage_templates.php?action=view\">";
	}
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$category=$_REQUEST['category'];
	$template_name=$_REQUEST['template_name'];
	$templateId=$_REQUEST['templateId'];
	$template_title=$_REQUEST['template_title'];
	$content=$_REQUEST['content'];
	$createdDate= date("Y-m-d H:i:s");
		
	  $sql="INSERT INTO  whatsapp_templates_master SET `category`='$category',`template_name`='$template_name',`templateId`='$templateId',`template_title`='$template_title',`content`='$content',`createdDate`='$createdDate'";
	$stmt = $conn ->query($sql);
	if($conn->error){
		echo "<script langauge=\"javascript\">alert(\"$conn->error\");location.href='manage_templates.php?action=add';</script>";
	}else{
		echo "<meta http-equiv=refresh content=\"0;url=manage_templates.php?action=view\">";	
	}
	
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='manage_templates.php?action=add';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$category=$_REQUEST['category'];
	$template_name=$_REQUEST['template_name'];
	$template_title=$_REQUEST['template_title'];
	$content=$_REQUEST['content'];
	$id=$_REQUEST['id'];	
	$templateId=$_REQUEST['templateId'];
	$sql="update whatsapp_templates_master set category='$category',template_name='$template_name',template_title='$template_title',`templateId`='$templateId',content='$content' where id='$id'";	
	$stmt = $conn ->query($sql);
	echo"<meta http-equiv=refresh content=\"0;url=manage_templates.php?action=view\">";
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

<script>
	function checkdata()
    {
     
	    
	    if(document.getElementById('category').value == ''){
	    alert("Please Select Category");
	    document.getElementById('category').focus();
	    return false;
	    }
	    if(document.getElementById('template_name').value == ''){
	    alert("Please enter template name");
	    document.getElementById('template_name').focus();
	    return false;
	    }
	    // if(document.getElementById('content').value == ''){
	    // alert("Please enter template content");
	    // document.getElementById('content').focus();
	    // return false;
	    // }
    
   
    
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Vendor Category</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_templates.php?action=add"><div class="content_head_button">Add Template </div></a>  <a href="manage_templates.php?action=view"><div class="content_head_button">Manage Template </div> </a></div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td>Sr. No.</td>
        <td>Category</td>
        <td>Template Name</td>
        <td>Content</td>
        <td>Status</td>
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $i=1;
	$result = $conn ->query("SELECT * FROM whatsapp_templates_master WHERE 1 ORDER BY updatedDate DESC ");
	
    $rCount=0;
    $rCount = $result->num_rows;;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['category'];?></td>
        <td><?php echo $row['template_name'];?></td>
        <td><?php echo $row['content'];?></td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_templates.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/active.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_templates.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/inactive.png" border="0" title="Active"/></a><?php } ?></td>

        <td ><a href="manage_templates.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" alt="Edit" width="15" height="15" border="0" /></a></td>
        <td ><a href="manage_templates.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = $conn->query("SELECT *  FROM whatsapp_templates_master  where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{
			$category=stripslashes($row2['category']);
			$template_name=stripslashes($row2['template_name']);
			$templateId=stripslashes($row2['templateId']);
			$template_title=stripslashes($row2['template_title']);
			$content=stripslashes($row2['content']);
			$status=stripslashes($row2['status']);
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add Whatsapp template</td>
    </tr>

    <tr>
    <td class="content_txt">Category  <span class="star">*</span></td>
    <td>   

    <select class="input_txt" name="category" id="category" style="width: 70%">
    	<option  value="">Select Category</option>
    	<option <?php if($category=="TEXT"){echo "selected";}?> value="TEXT">TEXT</option>
    	<option <?php if($category=="IMAGE"){echo "selected";}?> value="IMAGE">IMAGE</option>
    	<option <?php if($category=="DOCUMENT"){echo "selected";}?> value="DOCUMENT">DOCUMENT</option>
    	<option <?php if($category=="VIDEO"){echo "selected";}?> value="VIDEO">VIDEO</option>
    </select> 
    </td>
    </tr>
     <tr>
    <td class="content_txt">Template Name  <span class="star">*</span></td>
    <td><input type="text" name="template_name" id="template_name" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $template_name; ?>" style="width: 70%" />   
    </td>
    </tr>
     <tr>
    <td class="content_txt">Template Id  <span class="star">*</span></td>
    <td><input type="text" name="templateId" id="templateId" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $templateId; ?>" style="width: 70%" />   
    </td>
    </tr>
    
    <tr>
    <td class="content_txt">Template Content Title </td>
    <td><input type="text" name="template_title" id="template_title" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $template_title; ?>" style="width: 70%" />   
    </td>
    </tr>
    <tr>
    <td class="content_txt">Message Template  <span class="star">*</span></td>
    <td><textarea name="content" id="content" title="Please enter your name" class="show-tooltip input_txt"  rows="20" style="width: 70%" /><?php echo $content; ?>   </textarea> 
    </td>
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