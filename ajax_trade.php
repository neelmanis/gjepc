<?php 
session_start(); ob_start();
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include('db.inc.php'); 	
$registration_id = intval(filter($_SESSION['USERID']));

if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='exh_option')
{
	$exh_id = filter($_REQUEST['exh_id']);
	$sql = $conn ->query("select * from trade_exhibition_master where Exhibition_Id='$exh_id'");
	$ans = $sql->fetch_assoc();
	$From_Date = $ans['From_Date'];
	$To_Date = $ans['To_Date'];
	$Organizer_Address = $ans['Organizer_Address'];
	$Venue_Address = $ans['Venue_Address'];
    echo $From_Date."#".$To_Date."#".$Organizer_Address."#".$Venue_Address;
}
	
if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='optionValue')
{
	$reg_no = $_REQUEST['reg_id'];
	$option = $_REQUEST['option'];
	$sql = $conn ->query("select * from communication_address_master where registration_id='$reg_no' and type_of_address='$option'");
	$ans =  $sql->fetch_assoc();
	$address_id = filter($ans['id']);
	$address1   = filter($ans['address1']);
	$address2   = filter($ans['address2']);
	$city = filter($ans['city']);
	$pincode = $ans['pincode'];
	$email_id = $ans['email_id'];
	$name = $ans['name'];
 echo $name."#".$address1."#".$address2."#".$city."#".$pincode."#".$email_id."#".$address_id;
}

if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='countryValue1')
{	
	$country = $_REQUEST['country'];
	if($country=='IND' || $country=='IN')
	{
		$sql_city = "select * from trade_city_master where country_code='$country'";
	} else
	{
		$sql_city = "select * from trade_city_master where country_code!='IND'";
	}
	$str ="";	
	$query_city = $conn ->query($sql_city);
	while($ans_city =  $query_city->fetch_assoc())
	{
		$str.= "<option value='".$ans_city['id']."'>".$ans_city['City']."</option>";
	}			
	echo $str;
}
	
if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='countryValue2')
{	
	$country = filter($_REQUEST['country']);
	if($country=='IN')
	{
	 $sql_city = "select * from trade_city_master where country_code='$country'";
	}
	else
	{
		 $sql_city = "select * from trade_city_master where country_code!='IND'";
	}
	$str ="";	
	$query_city = $conn ->query($sql_city);
	while($ans_city =  $query_city->fetch_assoc())
	{
		 $str.= "<option value='".$ans_city['id']."'>".$ans_city['City']."</option>";
	}				
	echo $str;
}

if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='countryValue3')
{
	$country = filter($_REQUEST['country']);
	if($country=='IN')
	{
		$sql_city = "select * from trade_city_master where country_code='$country'";
	}
	else
	{
		 $sql_city = "select * from trade_city_master where country_code!='IND'";
	}
	$str ="";
	$query_city = $conn ->query($sql_city);
	while($ans_city =  $query_city->fetch_assoc())
	{
		$str.= "<option value='".$ans_city['id']."'>".$ans_city['City']."</option>";
	}				
	echo $str;
}

if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='countryValue4')
{
	$country = filter($_REQUEST['country']);
	if($country=='IN')
	{
		$sql_city = "select * from trade_city_master where country_code='$country'";
	}
	else
	{
		$sql_city = "select * from trade_city_master where country_code!='IND'";
	}
	$str ="";	
	$query_city = $conn ->query($sql_city);
	while($ans_city =  $query_city->fetch_assoc())
	{
		$str.= "<option value='".$ans_city['id']."'>".$ans_city['City']."</option>";
	}				
	echo $str;
}

if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='countryValue5')
{	
	$country = filter($_REQUEST['country']);
	if($country=='IN')
	{
		$sql_city = "select * from trade_city_master where country_code='$country'";
	}
	else
	{
		 $sql_city = "select * from trade_city_master where country_code!='IND'";
	}
	$str ="";
	$query_city = $conn ->query($sql_city);
	while($ans_city =  $query_city->fetch_assoc())
	{
		$str.= "<option value='".$ans_city['id']."'>".$ans_city['City']."</option>";
	}				
	echo $str;
}
	
if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='countryValue6')
{
	$country = filter($_REQUEST['country']);
	if($country=='IN')
	{
		$sql_city = "select * from trade_city_master where country_code='$country'";
	}
	else
	{
		$sql_city = "select * from trade_city_master where country_code!='IND'";
	}
	$str ="";	
	$query_city = $conn ->query($sql_city);
	while($ans_city =  $query_city->fetch_assoc())
	{
	 $str.= "<option value='".$ans_city['id']."'>".$ans_city['City']."</option>";
	}				
	echo $str;
}
		
if(isset($_REQUEST['actiontype']) && $_REQUEST['actiontype']=='exh_value')
{
	$exh_cnt=count($_POST['exhibition_1']);
	$app_id=$_POST['app_id'];
	$date=date('Y-m-d');
	$result = $conn ->query("delete from trade_exhibition_info where app_id='$app_id'");
	if($exh_cnt==1)
	{
		 $under_council=$_POST['checkbox_1'][0];
		 $exhibition_id=$_POST['exhibition_1'][0];
		 $dateFrom_1=$_POST['dateFrom_1'][0];
		 $dateTo_1=$_POST['dateTo_1'][0];
		 $organizer_address=$_POST['organizer_address'][0];
		 $venue_address=$_POST['venue_address'][0];
		
		$sql="insert into trade_exhibition_info (app_id,registration_id,under_council,exhibition_id,exhibition_date_from,exhibition_date_to,organizer_address,venue_address,created_date,exh_status,post_date) values ('$app_id','$registration_id','$under_council','$exhibition_id','$dateFrom_1','$dateTo_1','$organizer_address','$venue_address','$date','P',now())";
		$results = $conn ->query($sql);  
		echo "insert";
	}else
	{
		for($i=0;$i<$exh_cnt;$i++)
		{
			$date_from=$_POST['dateFrom_1'][$i+1];
			$date_to=$_POST['dateTo_1'][$i];
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
		 //$exhibitionName_1=$_POST['exhibitionName_1'][$i];
		 $dateFrom_1=$_POST['dateFrom_1'][$i];
		 $dateTo_1=$_POST['dateTo_1'][$i];
		 $organizer_address=$_POST['organizer_address'][$i];
		 $venue_address=$_POST['venue_address'][$i];
		 
		$sql="insert into trade_exhibition_info (app_id,registration_id,exhibition_id,exhibition_date_from,exhibition_date_to,organizer_address,venue_address,created_date,exh_status,post_date) values ('$app_id','$registration_id','$exhibition_id','$dateFrom_1','$dateTo_1','$organizer_address','$venue_address','$date','P',now())";
		$result = $conn ->query($sql);  
		 if($result)
		 	$flag=$flag+1;
		}
		if($flag==$exh_cnt)
			echo "insert";
	}
}
?>