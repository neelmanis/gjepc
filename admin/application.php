<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
$curruser_region_id = trim($_SESSION['curruser_region_id']);
?>

<?php
$registration_id = intval($_REQUEST['registration_id']);
$sql = "select * from trade_general_info where registration_id='$registration_id'";
$stmt =  $conn ->query($sql);	
$regionapp = $stmt->fetch_assoc();
$region_name = $regionapp['region_code'];
$permission_type = $regionapp['permission_type'];

if($region_name=='HO-MUM (M)')
	$r_name="MUM";
else if($region_name=='RO-CHE')
	$r_name="CHE";
else if($region_name=='RO-DEL')
	$r_name="DEL";
else if($region_name=='RO-JAI')
	$r_name="JAI";
else if($region_name=='RO-KOL')
	$r_name="KOL";
else if($region_name=='RO-SRT')
	$r_name="SRT";
else
	$r_name="MUM";
	
if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$registration_id =  intval($_REQUEST['registration_id']);
	$status			 =	intval(filter($_REQUEST['status']));	
	$id			 	 =	intval(filter($_REQUEST['id']));
	if(isset($registration_id) && $registration_id!=""){
	$sql   = "update trade_general_info set app_report_status='$status' where app_id='$id'";
	$stmtd = $conn ->query($sql);
	if($stmtd->execute()){	header("location:application.php?registration_id=".$registration_id); }
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
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Trade permission</div>
</div>

<div id="main">
	<div class="content">
 
<div class="content_details1">
<form action="" method="post" name="adminForm" id="adminForm" > 
<input type="hidden" name="Id" value="" /> 
<input type="hidden" name="act" value="" /> 
  	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
        <td width="180px;">Company name</td>
       	<td width="150px;">Reference no</td>
       	<td>Application status</td>
        <td>View report</td>
        <td>report status</td>
        <td>Created date</td>
        <td>View detail</td>
        <td>Print Acknowladgement</td>       
    </tr>
    <?php 
	//$registration_id = $_REQUEST['registration_id'] ;
    $i=1;
	$sql = 'SELECT * from trade_general_info where registration_id ='.$registration_id;
	if(isset($_REQUEST['member_name']) && $_REQUEST['member_name']!="" )
	{
		$member_name = $_REQUEST['member_name'] ;
		$sql .= " and (`member_name` LIKE '%".$member_name."%')";
	}
	if(isset($_REQUEST['permission_no']) && $_REQUEST['permission_no']!="" )
	{
		$permission_no = $_REQUEST['permission_no'] ;
		$sql .= " and (`permission_no` LIKE '%".$permission_no."%')";
	}
	$sql.=" order by app_id desc";
	$result = $conn ->query($sql);
    $rCount=0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
		if($row['permission_type']=="promotional_tour")
			$type="PRM";
		else if($row['permission_type']=="exhibition")
			$type="EXH";
		else
			$type="OTH";
			
		$ref_no="GJC/".$type."/".$r_name."/PER/".$row['start']."-".$row['end'];
		$for_print_ref_no="GJC/".$type."/".$r_name."/PER";
    ?>  
 		<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
		<td><?php echo strtoupper(getCompanyName($registration_id,$conn)); ?></td>
		<td><?php echo $ref_no; ?></td>
	    <td><?php if($row['application_status']=="P"){ echo "Pending";}elseif($row['application_status']=="N"){echo "Disapprove";}elseif($row['application_status']=="C"){ echo "Cancelled"; }else {echo "Approve";} ?></td>
	
<!-- Start View -->	
	    <?php if($row['permission_type']=="exhibition"){ ?>
        <td>
       <a href="trade_view_exh.php?uid=<?php echo $row['app_id']; ?>&&ref_no=<?php echo $ref_no;?>">View</a> 
        </td>
        <?php } ?>
        <?php if($row['permission_type']=="promotional_tour"){ ?>
        <td>
		<a href="trade_view_prom.php?uid=<?php echo $row['app_id']; ?>&&ref_no=<?php echo $ref_no;?>">View</a> 
        </td>
        <?php } ?>
<!-- End View -->			
        <!--<td>
	<?php echo ($row["app_report_status"] == 1)?'<img src="images/active.png" alt="approve" title="disapprove" onclick="return chkPublish('.$row["app_id"].')">':'<img src="images/inactive.png" title="approve" alt="approve" onclick="return chkPublish('.$row["app_id"].')">' ?>
	 
 		</td>-->
<!-- Start Report Status -->
		        <td>
				<?php
				if($row['app_report_status'] == 'P') 
				{echo 'Pending';	
				}elseif($row['app_report_status'] == 'N')
				{ echo 'Disapprove';}				
				elseif($row['app_report_status'] == 'Y')
				{ echo 'Approve';}
				?>
<!-- Over Report Status -->
				<!--
				<?php if($row['app_report_status'] == 'P') 
				{
 				?> 
                <a style="text-decoration:none;" href="application.php?id=<?php echo $row['app_id']; ?>&status=Y&action=active&registration_id=<?php echo $registration_id ; ?>" onClick="return(window.confirm('Are you sure you want to aprove.'));"><img src="images/active.png" border="0" title="approve"/></a> 
                   
				<a style="text-decoration:none;" href="application.php?id=<?php echo $row['app_id']; ?>&status=N&action=active&&registration_id=<?php echo $registration_id ; ?>" onClick="return(window.confirm('Are you sure you want to disapprove.'));"><img src="images/inactive.png" border="0" title="Disapprove"/></a>&nbsp;&nbsp;&nbsp;(Pending)
			    <?php } ?>
				<?php if($row['app_report_status'] == 'Y') 
				{ ?> 
			<a style="text-decoration:none;" href="application.php?id=<?php echo $row['app_id']; ?>&status=N&action=active&registration_id=<?php echo $registration_id ; ?>" onClick="return(window.confirm('Are you sure you want to disaprove.'));"><img src="images/inactive.png" border="0" title="Disapproved"/></a> (Approved)
			<?php } ?>
			
			<?php if($row['app_report_status'] == 'N') 
			 { ?>
			<a style="text-decoration:none;" href="application.php?id=<?php echo $row['app_id']; ?>&status=Y&action=active&&registration_id=<?php echo $registration_id ; ?>" onClick="return(window.confirm('Are you sure you want to approve.'));"><img src="images/active.png" border="0" title="Approve"/></a> (Disapproved)
			<?php } ?>-->
			</td>

	    <td><?php echo $row['application_date']; ?></td>
		<td><a href="trade_approval.php?app_id=<?php echo $row['app_id']; ?>&&registration_id=<?php echo $row['registration_id']; ?>"  style="color:#000000">View</a></td>
        
		<?php if($row['permission_type']=="exhibition"){ ?>
        <td>
        <a href="https://www.gjepc.org/admin/trade_exh_print_ack.php?app_id=<?php echo $row["app_id"]; ?>&&registraton_id=<?php echo $row["registration_id"]; ?>&ref_no=<?php echo $for_print_ref_no;?>" target="_blank" style="color:#000000">Download</a>
        </td>
        <?php } ?>
        <?php if($row['permission_type']=="promotional_tour"){?>
        <td>
        <a href="https://www.gjepc.org/admin/trade_other_print_ack.php?app_id=<?php echo $row["app_id"]; ?>&&registraton_id=<?php echo $row["registration_id"]; ?>&ref_no=<?php echo $for_print_ref_no;?>" target="_blank" style="color:#000000">Download</a>
        </td>
        <?php } ?>
         
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
	</form>
		</div>
    </div>
</div>
<script language="JavaScript">
 // var registration_id = '<?php echo $registration_id ; ?>' ;
// function chkPublish(code){
	// document.adminForm.act.value = 'pub';
	// document.adminForm.Id.value = code;
	// document.adminForm.action = "application.php?registration_id="+registration_id;
	// document.adminForm.submit();
	// return true;
// }
</script>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>