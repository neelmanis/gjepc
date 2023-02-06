<?php
session_start();
include('../db.inc.php');
include('../functions.php');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if(!isset($_SESSION['curruser_login_id'])){	header("location:index.php"); exit; }
$adminID	=	intval($_SESSION['curruser_login_id']);
if($adminID!=1){ header("location:index.php"); exit; }

if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from news_master where id=?";	
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", $_REQUEST['id']);
	if($stmtd->execute()){	echo"<meta http-equiv=refresh content=\"0;url=news.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter($_REQUEST['id']);
	$modified_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	$sql = "update news_master set status=?,adminId=?,modified_date=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("iisi", $status,$adminID,$modified_date,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=news.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$post_date 	= 	date("Y-m-d",strtotime($_REQUEST['post_date']));
	$n_name		=	$conn->real_escape_string($_REQUEST['name']);
	$short_desc	=	$conn->real_escape_string($_REQUEST['short_desc']);
	$long_desc	=	$conn->real_escape_string($_REQUEST['long_desc']);
	$order_no	=	$_REQUEST['order_no'];
	$top_news	=	$_POST['top_news'];
    $slug = createSlug("news_master","slug",$n_name,$conn);
	if(isset($top_news)){
	 $top_news=$_POST['top_news'];
	} else {
	 $top_news="0";
	}
	
	$banner_image = '';
	$target_folder = 'images/news_images/';
	$path_parts = "";
	$ext="";
	$target_path = "";
	$filetoupload="";
	$temp_code = rand();
	$name = $_FILES['p_image']['name'];
	$name = str_replace(" ","_",$name);
	$temp_name = $_FILES['p_image']['tmp_name'];
	
	if(preg_match("/.php/i", $name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='news.php?action=add';</script>";
			exit;
	}
	else if($name !='')
	{
			if(($_FILES["p_image"]["type"] == "image/jpeg") || ($_FILES["p_image"]["type"] == "image/jpg") || ($_FILES["p_image"]["type"] == "image/png"))
			{
				$target_path = $target_folder.$temp_code.'_'.$name;
				$ans = $_FILES['p_image']['tmp_name'];
				if(move_uploaded_file($temp_name,$target_path))
				{
					$banner_image = $temp_code.'_'.$name;
				} else	{
					$_FILES['p_image']['error'];
					return;
				}
			} else
			{
			   echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='news.php?action=add';</script>";
			}		
	}
		
	$update_sql="update news_master set section='0' where section=?";	
	$stmt = $conn -> prepare($update_sql);
	$stmt -> bind_param("s", $top_news);
	$stmt->execute();
	
	$status=1;
	$sql="INSERT INTO news_master (name,short_desc,long_desc,news_pic,status,section,post_date,adminId,slug) VALUES (?,?,?,?,?,?,?,?,?)"; 
	$stmt = $conn -> prepare($sql);
	$stmt -> bind_param("ssssiisis", $n_name,$short_desc,$long_desc,$banner_image,$status,$top_news,$post_date,$adminID,$slug);
	if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=news.php?action=view\">";  } else {  die ($conn->error); }
	
	} else {
		echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
	}

}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$n_name= $conn->real_escape_string($_REQUEST['name']);
	$short_desc= $conn->real_escape_string($_REQUEST['short_desc']);
	$long_desc=$conn->real_escape_string($_REQUEST['long_desc']);
	$order_no=$_REQUEST['order_no'];
	$post_date = date("Y-m-d",strtotime($_REQUEST['post_date']));
	
	$id=$_REQUEST['id'];	
	$top_news=$_POST['top_news'];
    $slug = createSlug("news_master","slug",$n_name,$conn);
	$banner_image = '';
	$target_folder = 'images/news_images/';
	$path_parts = "";
	$ext="";
	$target_path = "";
	$filetoupload="";
	$temp_code = rand();
	$name = $_FILES['p_image']['name'];
	$name = str_replace(" ","_",$name);
	
	if(preg_match("/.php/i", $name)) {
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='news.php?action=add';</script>";
			exit;
	}
	else if($name !='')
	{
			if(($_FILES["p_image"]["type"] == "image/jpeg") || ($_FILES["p_image"]["type"] == "image/jpg") ||($_FILES["p_image"]["type"] == "image/png"))
			{
				$target_path = $target_folder.$temp_code.'_'.$name;
				if(move_uploaded_file($_FILES['p_image']['tmp_name'],$target_path))
				{
					  $banner_image = $temp_code.'_'.$name;					
				} else {
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this file.\");location.href='news.php?action=edit&id=$id';</script>";
				return;
				}
			} else	{
			echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='manage_achivers.php?action=edit&id=$id';</script>";
			}		
	}
	
	if(isset($top_news)){
	 $top_news=$_POST['top_news'];
	} else {
	 $top_news="0";
	}
	
	$update_sql="update news_master set section='0' where section=?";
	$stmt = $conn -> prepare($update_sql);
	$stmt -> bind_param("s", $top_news);
	$stmt->execute();
	
	/*$sql="update news_master set name=?,short_desc=?,long_desc=?,news_pic=?,order_no=?,section=?,post_date=?,adminId=?,slug=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt -> bind_param("ssssiisisi", $n_name,$short_desc,$long_desc,$banner_image,$order_no,$top_news,$post_date,$adminID,$slug,$id); */

	$sql.="update news_master set name='$n_name',short_desc='$short_desc',long_desc='$long_desc',post_date='$post_date',section='$top_news',adminId='$adminID',slug='$slug'";
	if(isset($banner_image) && $banner_image!='')
	$sql.=",`news_pic`='$banner_image'";
	$sql.=" where id='$id'";
//	echo $sql; exit;
	$stmt = $conn -> prepare($sql);
	$stmt->execute();
	echo"<meta http-equiv=refresh content=\"0;url=news.php?action=view\">";
    } else {
		echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
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
		alert("Please Enter Name.");
		document.getElementById('name').focus();
		return false;
	}
	
	if(document.getElementById('long_desc').value == '')
	{
		alert("Please Enter Long Desc.");
		document.getElementById('long_desc').focus();
		return false;
	}

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
	}
	*/	
		
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
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage News</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="news.php?action=add">
    	<div class="content_head_button">Add News</div>
    	</a> <a href="news.php?action=view">
    	<div class="content_head_button">View News</div>
    	</a> </div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Name</td>
        <td>Post Date</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." limit 50 ";
    
    $i=1;
	$result = $conn ->query("SELECT * FROM news_master where 1".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo filter($row['name']); ?></td>
        <td><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="news.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="news.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="news.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="news.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM news_master where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", $_REQUEST['id']);
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$name	=	filter($row2['name']);
			$short_desc	=	filter($row2['short_desc']);
			$long_desc	=	$row2['long_desc'];
			$news_pic	=	$row2['news_pic'];
			$order_no	=	filter($row2['order_no']);
			$post_date  = 	stripslashes(date("d-m-Y",strtotime($row2['post_date'])));
			$top_news	=	filter($row2['section']);
		}
  }
?>
 
<div class="content_details1">
<form method="POST" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New News</td>
    </tr>
    <tr>
      <td width="14%" class="content_txt">Name <span class="star">*</span></td>
      <td width="86%"><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>
    <tr>
      <td class="content_txt">Short Desc</td>
      <td><textarea name="short_desc" class="input_txt" id="short_desc"><?php echo $short_desc; ?></textarea></td>
    </tr>
    <tr>
    <td class="content_txt">Long Desc <span class="star">*</span></td>
    <td><textarea name="long_desc" class="input_txt" id="long_desc"><?php echo $long_desc; ?></textarea>
    <script type="text/javascript">
		CKEDITOR.replace( 'long_desc',
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
	<tr>
        <td valign="top" bgcolor="#FFFFFF"  class="text_content" width="60%"  style="padding:10px;">Upload Image</td>
        <td valign="top" colspan="2" bgcolor="#FFFFFF" style="padding:10px;"><div style="display:inline-block; vertical-align:top"><input type="file" id="p_image" name="p_image"/> <small> <br />
<i>(Image size must be less than 2 MB)<br/>(width:135px & Height:88px)</i></small></div>
            <div style="display:inline-block; vertical-align:top; float:right;">
            <?php  if($news_pic!="") {?><img src="images/news_images/<?php echo $news_pic;?>" width="100" height="120"/><?php }
			else { ?> <img src="../images/doctor-1.jpg" width="100" height="120"/><?php } ?>
			</div>
        </td>
    </tr>
    <tr>
      <td>Post Date <span class="star">*</span></td>
      <td><input type="text" name="post_date" id="post_date" class="input_txt" value="<?php echo $post_date; ?>" readonly/></td>
    </tr>
     <tr>
      <td>Top News <span class="star"></span></td>
      <td><input type="radio" name="top_news" id="top_news" value="1" <?php if($top_news=='1'){ echo "checked";}?>/>First
      <input type="radio" name="top_news" id="top_news" value="2" <?php if($top_news=='2'){ echo "checked";}?>/>Second
      <input type="radio" name="top_news" id="top_news" value="3" <?php if($top_news=='3'){ echo "checked";}?>/>Third
      <input type="radio" name="top_news" id="top_news" value="4" <?php if($top_news=='4'){ echo "checked";}?>/>Fourth
      </td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="a_image" id="a_image" value="<?php echo $p_image;?>" />
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