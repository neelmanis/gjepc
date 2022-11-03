<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php 
$app_id = intval($_GET['uid']); 
$registration_id = filter(intval($_REQUEST['registration_id']));
$exhibition_type=getExhibitionType($_REQUEST['app_id'],$conn);
$commemail = getCommEmail($app_id,$conn);
?>
<?php 
$uid = $_REQUEST['uid'];
$ref_no = $_REQUEST['ref_no'];

$sql_max = "select * from trade_general_info where app_id=?";
$stmt = $conn -> prepare($sql_max);
$stmt->bind_param("i", $uid);
$stmt -> execute();
$result = $stmt->get_result();		   
$rowx = $result->fetch_assoc();

$registration_id=$rowx['registration_id'];
$member_name=$rowx['member_name'];
$membership_id=$rowx['membership_id'];
$commemail=$rowx['commemail'];
$actual_invoice_amt=$rowx['actual_invoice_amt'];
$created_date=$rowx['created_date'];
$modified_date=$rowx['modified_date'];
$application_date=$rowx['application_date'];
$sold_amt=$rowx['sold_amt'];
$unsold_amt=$rowx['unsold_amt'];
$address1=$rowx['address1'];
$address2=$rowx['address2'];
$good_description=$rowx['good_description'];
//$export_region=$rowx['export_region'];
$specify_country=$rowx['specify_country'];
$country=$rowx['visiting_country1'];
$from_date=$rowx['from_date'];
$to_date=$rowx['to_date'];
$latest_trend=$rowx['latest_trend'];
$future_prospect=$rowx['future_prospect'];
$prob_face=$rowx['prob_face'];
$comments=$rowx['comments'];
$app_report_status=$rowx['app_report_status'];
$permission_type=$rowx['permission_type'];
$app_report_reason=$rowx['app_report_reason'];
$terms_and_cond=$rowx['terms_and_cond'];
?>

<?php
$action=$_POST['action'];
if($action=='updatedetails')
{
//	print_r($_POST);
$app_reports=$_POST['app_reports'];
$app_report_reason=$_POST['app_report_reason']; 
 
$sqlx="update trade_general_info set app_report_status='$app_reports', app_report_reason='$app_report_reason' where app_id='$uid'"; 
$result = $conn ->query($sqlx);
if($result){

if($app_reports=='Y')
{
 $message='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">		
		<tr>
		<td align="left"><img src="https://www.gjepc.org/images/logo_gjepc.png" width="238" height="78" /></td>
		</tr>
		<tr><td></td><td align="right"></td></tr>
		<tr><td align="right" colspan="2" height="30px"><hr /></td></tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p><strong>Your Report for  Export Promotional Tour to '.$country.' (From Date:'.$from_date.' To Date:'.$to_date.') has been Approved</strong></p>
		</td>
		</tr>
		<tr>
		<td height="22" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;"><br/>Kind Regards,</td>
		</tr>
	  <tr>
		<td align="left"><strong>GJEPC Web Team,</strong></td>
	  </tr>		
</table>';
	 $to =$commemail;
	$subject = "Trade Application Report Approval"; 
	$headers  = 'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$headers .= 'From: Trade Application <admin@gjepc.org>';		
	mail($to, $subject, $message, $headers);

}elseif($app_reports=='N')
{
   $message='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">		
		<tr>
		<td align="left"><img src="https://www.gjepc.org/images/logo_gjepc.png" width="238" height="78" /></td>
		</tr>
		<tr><td></td><td align="right"></td></tr>
		<tr><td align="right" colspan="2" height="30px"><hr /></td></tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p><strong>Your Report for  Export Promotional Tour to '.$country.' (From Date:'.$from_date.' To Date:'.$to_date.') is Diapproved</strong></p>
		</td>
		</tr>
		<tr>
		<td colspan="2" style="font-size:13px; line-height:22px;">
		<p><strong>Reason For Disapprove:</strong></p>
		<p>'.$app_report_reason.'</p>
		</td>
		</tr>
		<tr>
		<td height="22" align="left"  style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;"><br/>Kind Regards,</td>
		</tr>
	  <tr>
		<td align="left"><strong>GJEPC Web Team,</strong></td>
	  </tr>
		
</table>';

	 $to =$commemail;;
	$subject = "Trade Application Report Disapproval"; 
	$headers  = 'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$headers .= 'From: Trade Application <admin@gjepc.org>';			
	mail($to, $subject, $message, $headers);
}

/***  Emailer End **/
echo "<script langauge=\"javascript\">alert(\"Information Updated Sucessfully.\");location.href='manage_trade_permission.php?action=view';</script>";
			exit;
} else { die ($conn->error); }
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
<style type="text/css">
	.minibuffer{margin: 10px auto;}
	.well{background-color: #f0f0f0;box-shadow: 2px 2px 8px #808080;padding: 10px;}
</style>
<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<link rel="stylesheet" type="text/css" href="css/trade_approval.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > View Report</div>
</div>

<div id="main">

<div class="container well">
	<div class="row"><div class="col-md-12 lead">View Promotional Report </div></div>
	<div class="row">
		<div class="col-md-12 minibuffer text-right"> <strong>Date : <?php echo $modified_date; ?></strong> </div>
		<div class="col-md-12">
			<label class="col-md-4" for="compname">Company Name</label>
			<input class="col-md-4" disabled="" type="text" value="<?php echo $member_name;?>"></input>
		</div>
		<div class="col-md-12 minibuffer">
			<label class="col-md-4" for="compname">Address</label>
			<textarea class="col-md-4" disabled="" type="text"><?php echo $address1.$address2; ?></textarea>
		</div>
		<div class="col-md-12 minibuffer">
			<label class="col-md-4">Council Approval Ref. No. & Date:</label>
			<input class="col-md-4" disabled="" value="Ref. No. : <?php echo $ref_no;?> & Date: <?php echo $application_date;?>"></input>
		</div>
		<div class="col-md-12 minibuffer">
			<label class="col-md-6">Report On:</label>
			<input type="radio" class=" " name="permission_no" id="permission_no"<?php if($permission_type=="exhibition") echo 'checked="checked"';?> >Exhibition</input>
			<input type="radio" class=" " name="permission_no" id="permission_no"<?php if($permission_type=="promotional_tour") echo 'checked="checked"';?>>Promotion Tour</input>	
			<input type="radio" class=" " name="permission_no" id="permission_no">Branded Jewellery</input>
		</div>	
		<div class="col-md-12 minibuffer">
			<table class="table table-bordered">
				<thead>
					<th>Country</th>
					<th>City</th>
					<th>From Date</th>
					<th>To Date</th>
				</thead>
				<?php
				$sqlx="select * from  trade_general_info where `app_id` = ?";
				$stmtx = $conn -> prepare($sqlx);
				$stmtx->bind_param("i", $uid);
				$stmtx -> execute();
				$resultx = $stmtx->get_result();		   
				while($rowx = $resultx->fetch_assoc())
				{					//print_r($rowx);
				$visiting_country1=$rowx['visiting_country1'];	
				$city1=$rowx['city1'];	
				$from_date=$rowx['from_date'];	
				$to_date=$rowx['to_date'];					
				?>
        		<tbody>
        			<tr>
        				<td><center>
        				<?php echo getCountryName($visiting_country1,$conn);?>
       				    </center></td>
        				<td><center><?php echo $city1;?></center></td>
        				<td><center><?php echo $from_date;?></center></td>
        				<td><center><?php echo $to_date;?></center></td>
        			</tr>
				<?php }?>
					</tbody>
					</table>
	  </div>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6">Fob value of goods</label>
			<input class="col-md-6" type="text" disabled="" value="<?php echo $actual_invoice_amt; ?>"></input>
		</div>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6">Value of goods sold</label>
			<input class="col-md-6" type="text" disabled="" value="<?php echo $sold_amt; ?>"></input>
		</div>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6">Value of goods unsold</label>
			<input class="col-md-6" type="text" disabled="" value="<?php echo $unsold_amt; ?>"></input>
		</div>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6">Describe your goods</label>
			<textarea type="text" class="col-md-6" disabled=""><?php echo $good_description; ?></textarea>
		</div>
	
		<!--<div class="col-md-6 minibuffer">
			<label class="col-md-6" for="fobvalue">Exporting Region</label>
			<input type="text" class="col-md-6" value="<?php echo $export_region; ?>" disabled></input>
		</div>-->
		<div class="col-md-6 minibuffer">
			<label class="col-md-6" for="fobvalue">Specify Countries</label>
			<input type="text" class="col-md-6" value="<?php echo $specify_country;?>" disabled></input>
		</div>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6" for="fobvalue">LATEST TREND (WHAT IS THE MARKET DEMAND?)</label>
			<input type="text" class="col-md-6" value="<?php echo $latest_trend;?>" disabled></input>
		</div>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6" for="fobvalue">FUTURE PROSPECTS (WHAT IS EXPECTED DEMAND?)</label>
			<input type="text" class="col-md-6" value="<?php echo $future_prospect;?>" disabled></input>
		</div>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6" for="fobvalue">ANY PROBLEMS FACED</label>
			<input type="text" class="col-md-6" value="<?php echo $prob_face;?>" disabled></input>
		</div>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6" for="fobvalue">COMMENTS & SUGGESTIONS FOR IMPROVING INDIAN MARKET SHARE</label>
			<input type="text" class="col-md-6" value="<?php echo $comments;?>" disabled></input>
		</div>
		<form method="POST">
		<input type="hidden" name="action" value="updatedetails" enctype='multipart/form-data' /> 
		
		<input type="hidden"  name="app_id" value="<?php echo $uid ; ?>">
		<input type="hidden"  name="registration_id" value="<?php echo $registration_id ; ?>">
		 <?php
		 $document = fetch('select app_report_name from trade_general_info where app_id='.$uid);
		 'select app_report_name from trade_general_info where app_id='.$uid;
		// $sql='select app_id,registration_id,permission_type, application_status , app_report_status , app_report_reason  from trade_general_info where app_id='.$uid;
		 $app_status = fetch('select app_id,registration_id,permission_type, application_status , app_report_status , app_report_reason  from trade_general_info where app_id='.$uid);
		?>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6" for="report">Status</label>
			<div class="col-md-6">
				<input type="radio" name="app_reports" value="Y" <?php if ($app_report_status == "Y") echo 'checked="checked"'; ?>>Approve
				<input type="radio" name="app_reports" value="N" <?php if ($app_report_status == "N") echo 'checked="checked"'; ?>>Disapprove
			</div>
		</div>
		<div class="col-md-6 minibuffer">
			<label class="col-md-6" for="fobvalue">Reason</label>
			<textarea type="text" name="app_report_reason" class="col-md-6"><?php echo $app_report_reason;?></textarea>
		</div>
		
		<div class="col-md-6 minibuffer">
			<label class="col-md-6" for="fobvalue">View Report</label>
			 <?php  if($document[0]['app_report_name']!='') { ?>
			 <a target="_blank" style="text-decoration:none;color:#70134a; font-weight:bold; font-size:16px; font-family:Lucida Sans;" href="../images/Tradephoto/report/<?php echo $document[0]['app_report_name']; ?>">view file</a>
				 <?php } ?>
		</div>
		
		<div class="col-md-12 minibuffer">
			<input type="checkbox" name="terms_and_cond" value="Y" <?php if ($terms_and_cond == "Y") echo 'checked="checked"'; ?> disabled>I here by confirm the above information filled is true & best of my knowledge.
		</div>
		<div class="col-md-12 text-right">
			<input type="submit" name="submit" value="Submit" class="btn btn-primary">
		</div>
		</form>
	</div>
</div>

</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>