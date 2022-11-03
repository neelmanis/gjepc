<?php session_start();
	ob_start();
 ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

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

</style>

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
<?php if($_REQUEST['action']=='view') {?>    	
	<div class="content_head">	
		Survey For Equitable Oppurtunity
		<div style="float:right; padding-right:10px; font-size:12px;">
		<a href="export_equitable_survey_records.php">Download Data</a>
		</div>
	</div>
<div class="content_details1">
<?php 
/*..................................Total Vote Count...............................................*/
$query = "select * from  gjepclivedatabase.equitable_survey group by registration_id";
$result_sel = $conn->query($query);	
$tot_vote_count = $result_sel->num_rows;

/*.........................................Total Option 1 Vote Count.....................................*/
$query = "select * from  gjepclivedatabase.equitable_survey where option1=1 group by registration_id";
$result_sel = $conn->query($query);	
$tot_opt1_count = $result_sel->num_rows;

/*.........................................Total Option 2 Vote Count.....................................*/
$query = "select * from  gjepclivedatabase.equitable_survey where option2=1 group by registration_id";
$result_sel = $conn->query($query);	
$tot_opt2_count = $result_sel->num_rows;
?>
	
	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
	<tr>
		<td><strong>Option 1- </strong>THE COUNCIL SHOULD REVISE THE APPLICABILITY OF THE EQUITABLE OPPURTUNITY CLAUSE TO 30 DAYS BEFORE THE SHOW AND 15 DAYS POST COMPLETION OF SHOW.</td>
		<td><strong>Option 2- </strong>THE COUNCIL SHOULD INTRODUCE A SIMILAR CLAUSE IN OTHER EXHIBITIONS / EVENTS ORGANISED BY GJEPC. </td>
	</tr>
	<tr>
        <td>Total Yes Vote - <strong><?php echo round($tot_opt1_count/$tot_vote_count*100)."%";?></strong></td>
        <td>Total Yes Vote- <strong><?php echo round($tot_opt2_count/$tot_vote_count*100)."%";?></strong></td>
    </tr>
</table>
	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
		<td>Sr. No.</td>
		<td>Company Name</td>
		<td>BP Number</td>
		<td>Option1</td>
		<td>Option2</td>
		<td>Date</td>
    </tr>
    
    <?php 
	$page=1;//Default page
    $limit=10;//Records per page
    $start=0;//starts displaying records from 0
    if(isset($_GET['page']) && $_GET['page']!=''){
    $page=$_GET['page'];    
    }
    $start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$result = $conn ->query("SELECT * FROM equitable_survey where 1 group by registration_id ".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
		$company_name = getCompanyNameFromregistration($row['registration_id'], $conn);
    ?>  
 	<tr >
        <td><?php echo $i;?></td>
        <td><?php echo $company_name;?></td>
		<td><?php echo getBPNO($row['registration_id'],$conn);?></td>
        <td><?php if($row['option1']=="1"){echo "Yes";}else{echo "No";} ?></td>
        <td><?php if($row['option2']=="1"){echo "Yes";}else{echo "No";} ?></td>
        <td><?php echo $row['date']; ?></td>

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
</div>  
<?php } ?>        
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
