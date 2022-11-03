<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
include('../db.inc.php');
include('../functions.php'); 
?>
<?php
/****************Export in excel*************/
if(isset($_POST['export']))
{
  //$_SESSION['delivery_date']=mysql_real_escape_string($_REQUEST['delivery_date']); 	
  function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }
	$order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
	$asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
	$attach = " order by ".$order_by." ".$asc_desc." ";

	$sql="select g_code as 'G-Code',gst_no as 'GST Number',location as 'Location',address as 'Address',post_date as 'Post Date' from gst_member where 1";

  $filename = "Member GST" ." ". date('d/m/y') . ".csv";
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");
  $out = fopen("php://output", 'w');
  $flag = false;
	$result=mysql_query($sql);
  	while(false !== ($row = mysql_fetch_assoc($result))) {
    if(!$flag) {
	      // display field/column names as first row
	   //echo getCompanyName($row['regId']);
	   //echo $row['address1'];
      fputcsv($out, array_keys($row), ',', '"');	  
      $flag = true;
    }
    array_walk($row, 'cleanData');
    fputcsv($out, array_values($row), ',', '"');
  }
  //fclose($out);
  exit;
}
/****************Export in excel*************/
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

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Member GST</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">
			<form name="search" action="" method="post" > 			
				<tr>
				    <td class="content_txt">Member GST</td>&nbsp;				
					<td><input type="submit" name="export" value="Export" /></td>					
				</tr>
			</form>
		</div>
<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >G-Code</td>
		<td >GST Number</td>      
        <td>Address</td>                       
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$sqlx1 = "SELECT * FROM gst_member where 1".$attach." ";
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
        <td><?php echo $row['g_code']; ?></td>
		<td><?php echo $row['gst_no']; ?></td>        
        <td><?php echo getState($row['address'],$conn); ?></td>               
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
     
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>