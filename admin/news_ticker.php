<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from app_news_ticker where id='$_REQUEST[id]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=news_ticker.php?action=view\">";
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update app_news_ticker set status='$status' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=news_ticker.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$name=filter($_REQUEST['name']);
	$link=filter($_REQUEST['link']);
	
	//---------------------------------------- upload  newsletter pdf  -----------------------------------------------
	
	
	
		$sql="INSERT INTO `app_news_ticker`( `post_date`, `name`, `link`, `status`)
		VALUES ('$post_date','$name','$link','1')";
			
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=news_ticker.php?action=view\">";

}
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$name=filter($_REQUEST['name']);
	$link=filter($_REQUEST['link']);
	$id=filter($_REQUEST['id']);	

	//------------------------------------  Update Newsletter PDF ----------------------------------------------------------

	$sql="update app_news_ticker set name='$name',link='$link' where id='$id'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=news_ticker.php?action=view\">";
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
	if(document.getElementById('name').value == '')
	{
		alert("Please Enter News Name.");
		document.getElementById('name').focus();
		return false;
	}
	
	if(document.getElementById('link').value == '')
	{
		alert("Please insert Link.");
		document.getElementById('link').focus();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage News Ticker</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="news_ticker.php?action=add"><div class="content_head_button">Add News Ticker</div></a> <a href="news_ticker.php?action=view"><div class="content_head_button">View News Ticker</div></a> </div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Name</td>
        <td>Status</td>
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 

    
    $i=1;
	$result = mysql_query("SELECT * FROM app_news_ticker where 1");
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
	    <td><?php echo $row['link']; ?></td>
        
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="news_ticker.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="news_ticker.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="news_ticker.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="news_ticker.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = mysql_query("SELECT * FROM app_news_ticker where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$name=stripslashes($row2['name']);
			$link=stripslashes($row2['link']);
			
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New News Ticker</td>
    </tr>
  	
    <tr>
    <td class="content_txt">News Name <span class="star">*</span></td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>
	

    
    <tr>
    <td class="content_txt">Link <span class="star">*</span></td>
    <td><textarea name="link" id="link" rows="10"><?php echo $link; ?></textarea></td>
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
