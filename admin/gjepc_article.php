<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php 
$adminID = intval($_SESSION['curruser_login_id']);
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from update_article where id=?";	
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", intval($_REQUEST['id']));
	if($stmtd->execute()){	echo"<meta http-equiv=refresh content=\"0;url=gjepc_article.php?action=view\">"; }
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter($_REQUEST['id']);
	$modified_date = date('Y-m-d');
	$sql="update update_article set status=?,adminId=?,modified_date=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("sisi", $status,$adminID,$modified_date,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=gjepc_article.php?action=view\">"; }
}

if ($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$title=mysql_real_escape_string($_REQUEST['title']);
	$article_url=mysql_real_escape_string($_REQUEST['article_url']);
	
	$sql="INSERT INTO update_article (title,article_url,status,post_date,adminId) VALUES ('$title','$article_url','1','$post_date','$adminID')";			
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=gjepc_article.php?action=view\">";
}

if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$title=mysql_real_escape_string($_REQUEST['title']);
	$article_url=mysql_real_escape_string($_REQUEST['article_url']);
	$id=mysql_real_escape_string($_REQUEST['id']);	
		
	$sql="update update_article set title='$title',article_url='$article_url',modified_date=NOW(),adminId='$adminID' where id='$id'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=gjepc_article.php?action=view\">";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GJEPC Article</title>

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
	if(document.getElementById('title').value == '')
	{
		alert("Please Enter Title.");
		document.getElementById('title').focus();
		return false;
	}
	
    if(document.getElementById('article_url').value == '')
	{
		alert("Please Enter Article URL.");
		document.getElementById('article_url').focus();
		return false;
	}	
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Article Update</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="gjepc_article.php?action=add"><div class="content_head_button">Add Article</div></a> <a href="gjepc_article.php?action=view"><div class="content_head_button">View Article</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Date</td>
       	<td>Title</td>
        <td>Article URL</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$sqlx1 = "SELECT * FROM update_article where 1".$attach." ";
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
	    <td><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>
	    <td><?php echo strip_tags($row['title']); ?></td>
		<td><a href="<?php echo $row['article_url'];?>" target="_blank"><?php echo $row['article_url'];?></a></td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="gjepc_article.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="gjepc_article.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="gjepc_article.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="gjepc_article.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = $conn ->query("SELECT *  FROM update_article  where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{
			$title=stripslashes($row2['title']);
			$article_url=stripslashes($row2['article_url']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Article</td>
    </tr>
 
    <tr>
      <td class="content_txt">Title <span class="star">*</span></td>
      <td><input type="text" name="title" id="title" class="input_txt" value="<?php echo $title;?>" /></td>
    </tr>
    
    <tr>
      <td class="content_txt">Article URL</td>
      <td><input type="text" name="article_url" id="article_url" class="input_txt" value="<?php echo $article_url; ?>" /></td>
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