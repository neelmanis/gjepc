<?php 
ob_start();
session_start(); 
include('../db.inc.php'); 
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$registration_id = intval($_SESSION['USERID']);

if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='optionValue')
{
	$reg_no = intval($_REQUEST['reg_id']);
	$option = $_REQUEST['option'];
	$sqlAddress = "select * from communication_address_master where registration_id=? and id=?";
	$stmt = $conn -> prepare($sqlAddress);
	$stmt->bind_param("is", $reg_no,$option);
	$stmt -> execute();
	$result = $stmt->get_result();		   
	$ans = $result->fetch_assoc();
	$address1 = $ans['address1'];
	$address2 = $ans['address2'];
	$city = $ans['city'];
	$pincode = $ans['pincode'];
	$email_id = $ans['email_id'];
	$name = $ans['name'];
	echo $name."#".$address1."#".$address2."#".$city."#".$pincode."#".$email_id;
}
	
if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='exh_value')
{
	$exh_cnt=count($_POST['exhibition_1']);
	$app_id=$_POST['app_id'];
		 $date=date('Y-m-d');
	if($exh_cnt==1)
	{
		 $under_council=$_POST['checkbox_1'][0];
		 $exhibition_id=$_POST['exhibition_1'][0];
		 $exhibitionName_1=$_POST['exhibitionName_1'][0];
		 $dateFrom_1=$_POST['dateFrom_1'][0];
		 $dateTo_1=$_POST['dateTo_1'][0];
		 $organizer_address=$_POST['organizer_address'][0];
		 $venue_address=$_POST['venue_address'][0];
		
		$sql="insert into trade_exhibition_info (app_id,registration_id,under_council,exhibition_id,exhibition_name,exhibition_date_from,exhibition_date_to,organizer_address,venue_address,created_date,exh_status,post_date) values ('$app_id','$registration_id','$under_council','$exhibition_id','$exhibitionName_1','$dateFrom_1','$dateTo_1','$organizer_address','$venue_address','$date','P',now())";
		$result = $conn ->query($sql);
		 echo "insert";
	}else
	{
		for($i=0;$i<$exh_cnt;$i++)
		{
			$date_from=$_POST['dateFrom_1'][$i+1];
			$date_to=$_POST['dateTo_1'][$i];
			//if($dateto)
			$date_from=strtotime($date_from);
			$date_to=strtotime($date_to);
			if($i!=$exh_cnt)
			{
				$diff=(($date_from-$date_to)/(60*60*24));				
				if($diff>45)
				{
					echo "Select Exhibition's Date between 45 days";
					return;
				}
			}else
			{
				//echo "match";
			}
		}
		$flag=0;
		for($i=0;$i<$exh_cnt;$i++)
		{
		 $under_council=$_POST['checkbox_1'][$i];
		 $exhibition_id=$_POST['exhibition_1'][$i];
		 $exhibitionName_1=$_POST['exhibitionName_1'][$i];
		 $dateFrom_1=$_POST['dateFrom_1'][$i];
		 $dateTo_1=$_POST['dateTo_1'][$i];
		 $organizer_address=$_POST['organizer_address'][$i];
		 $venue_address=$_POST['venue_address'][$i];
		 
		$sql="insert into trade_exhibition_info (app_id,registration_id,under_council,exhibition_id,exhibition_name,exhibition_date_from,exhibition_date_to,organizer_address,venue_address,created_date,exh_status,post_date) values ('$app_id','$registration_id','$under_council','$exhibition_id','$exhibitionName_1','$dateFrom_1','$dateTo_1','$organizer_address','$venue_address','$date','P',now())";		 
		$result = $conn ->query($sql);
		if($result)
		 	$flag=$flag+1;			
		}
		if($flag==$exh_cnt)
			echo "insert";		
	}	
	}
?>