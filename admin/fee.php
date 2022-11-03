<?php
session_start();
include('../db.inc.php');
include('../functions.php');
$adminID = intval($_SESSION['curruser_login_id']);
if($adminID!=1){ header('Location: index.php'); exit; }
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{	
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$id = intval($_REQUEST['id']);		
	$min_date = mysql_real_escape_string(trim($_REQUEST['min_date']));
	$max_date = mysql_real_escape_string(trim($_REQUEST['max_date']));
		
	$sql= "UPDATE `visitor_fee_structure` SET `min_date`='$min_date',`max_date`='$max_date' WHERE id='$id'";
	if(!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo "<meta http-equiv=refresh content=\"0;url=fee.php?action=view\">";
	} else {
	 echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='fee.php?action=add';</script>";
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
<script src="js/jqueryNew.js"></script>  <!-- Calendar    -->
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<!-- Calendar Starts -->
<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">	
<link href="https://www.malot.fr/bootstrap-datetimepicker/css/bootstrap.css" rel="stylesheet">
<!-- Calendar End -->
<script src="//cdn.ckeditor.com/4.4.4/full/ckeditor.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Fee</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="fee.php?action=view"><div class="content_head_button">View Events</div></a> </div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
		<td>Min Date</td>
        <td>Max Date</td> 
       	<td>1 SHOW</td>
       	<td>2 SHOW</td>
       	<td>5 SHOW</td>
       	<td>Type</td>               
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM visitor_fee_structure where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo $row['min_date']; ?></td>
        <td><?php echo $row['max_date']; ?></td>
        <td><?php echo filter($row['1show']); ?></td>        
        <td><?php echo filter($row['2show']); ?></td>        
        <td><?php echo filter($row['5show']); ?></td>        
		<td><?php echo filter($row['type']); ?></td>  
        <td><a href="fee.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
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
    <?php  } ?>
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
		$result2 = mysql_query("SELECT * FROM visitor_fee_structure where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$min_date = trim($row2['min_date']);
			$max_date = trim($row2['max_date']);
			$show1 = filter($row2['1show']);
			$show2 = filter($row2['2show']);
			$show5 = filter($row2['5show']);
		}
	}
?>
 
<div class="content_details1">
<form action="#" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"/>
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Update Fee</td>
    </tr>  	
    <tr>
    <td class="content_txt">1 SHOW<span class="star">*</span></td>
    <td><input type="text" name="show1" id="show1" class="input_txt" value="<?php echo $show1;?>" autocomplete="off"/></td>
    </tr>
	<tr>
    <td class="content_txt">2 SHOW<span class="star">*</span></td>
    <td><input type="text" name="show2" id="show2" class="input_txt" value="<?php echo $show2;?>" autocomplete="off"/></td>
    </tr>
	<tr>
    <td class="content_txt">5 SHOW<span class="star">*</span></td>
    <td><input type="text" name="show5" id="show5" class="input_txt" value="<?php echo $show5;?>" autocomplete="off"/></td>
    </tr>
	<tr>
    <td class="content_txt">Min Date<span class="star">*</span></td>
    <td><input size="16" type="text" value="<?php echo $min_date;?>" name="min_date" class="min_date" readonly>
    <span class="add-on"><i class="icon-th"></i></span></td>
	</tr>
	<tr>
    <td class="content_txt">Max Date<span class="star">*</span></td>
    <td><input size="16" type="text" value="<?php echo $max_date;?>" name="max_date" class="max_date" readonly>
    <span class="add-on"><i class="icon-th"></i></span></td>
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

<script src="https://www.malot.fr/bootstrap-datetimepicker/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js?t=20130302"></script>
<script type="text/javascript">    	
    $(".min_date").datetimepicker({
      format: 'yyyy-mm-dd hh:ii:ss',
	  autoclose: true,
      todayBtn: true,
    });  
    $(".max_date").datetimepicker({
      format: 'yyyy-mm-dd hh:ii:ss',
	  autoclose: true,
      todayBtn: true,
    });  	
  </script>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>