<?php 
if(!isset($_SESSION['AGENT_ID']) && !isset($_SESSION['MEMBER_ID']) && !isset($_SESSION['NON_MEMBER_ID'])){
	if(isset($_REQUEST['MEMBERTYPE'])){
			$MEMBER_ID=$_REQUEST['MEMBER_ID'];
			$membertype=$_REQUEST['MEMBERTYPE'];
			
	if($_REQUEST['MEMBERTYPE']=="Member"){
		$query=mysqli_query($conn,"select * from kp_member_user_details where MEMBER_ID='$MEMBER_ID'");
	}else if($_REQUEST['MEMBERTYPE']=="NonMember"){
		$query=mysqli_query($conn,"select * from kp_non_member_master where NON_MEMBER_ID='$MEMBER_ID'");
	}
	$result=mysqli_fetch_assoc($query);
	$num=mysqli_num_rows($query);
	if($num>0)
	{
		$_SESSION['MEMBERTYPE']=$membertype;
		if($membertype=="Member"){
			$_SESSION['USERNAME']=$result['COMPANY_NAME'];
			$_SESSION['LOGIN_NAME']=$result['LOGIN_NAME'];
			$_SESSION['MEMBER_ID']=$result['MEMBER_ID'];
			$_SESSION['GCODE']=$result['GCODE'];
		}
		else if($membertype=="NonMember"){
			$_SESSION['USERNAME']=$result['NON_MEMBER_NAME'];
			$_SESSION['NON_MEMBER_NO']=$result['NON_MEMBER_NO'];
			$_SESSION['NON_MEMBER_ID']=$result['NON_MEMBER_ID'];
		}
	}
	}else{
		header('location:login.php');
	}
}
?>