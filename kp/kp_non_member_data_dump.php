<?php
session_start(); 
ob_start();
include('db.inc.php');
include('functions.php');
?>
<?php 
	/*....................................Non Member Data Dump.............................................*/
	/*
	$result = $conn ->query("SELECT * FROM gjepc_kp.kp_non_member_master_dump where 1");
	while ($row = mysqli_fetch_assoc($result)) { 
		$NON_MEMBER_BP_NO=$row['NON_MEMBER_BP_NO'];
		//echo "SELECT * FROM gjepc_kp.kp_non_member_master where NON_MEMBER_BP_NO='$NON_MEMBER_BP_NO'";echo "<br/>";
		$result1=$conn->query("SELECT * FROM gjepc_kp.kp_non_member_master where NON_MEMBER_BP_NO='$NON_MEMBER_BP_NO'");
		$row_cnt = $result1->num_rows;
		if($row_cnt==0){
			$columns = implode(", ",array_keys($row));
			$values  = implode("', '", array_values($row));
			echo $sql = "INSERT INTO gjepc_kp.kp_non_member_master($columns) VALUES ('$values')";echo "<br/>";
			//$conn ->query($sql);
		}
		
		$NON_MEMBER_ID=$row['NON_MEMBER_ID'];
		echo "update gjepc_kp.kp_non_member_master_dump set USER_NAME='NM$NON_MEMBER_ID' where NON_MEMBER_ID='$NON_MEMBER_ID'";echo "<br/>";
		$conn ->query("update gjepc_kp.kp_non_member_master_dump set USER_NAME='NM$NON_MEMBER_ID' where NON_MEMBER_ID='$NON_MEMBER_ID'");
		
	}*/
	/*....................................update member id.............................................*/
	$result = $conn ->query("SELECT * FROM gjepc_kp.kp_export_application_master where 1 order by EXPORT_APP_ID desc ");
	while ($row = mysqli_fetch_assoc($result)) { 
		$MEMBER_TYPE_ID=$row['MEMBER_TYPE_ID'];
		$EXPORT_APP_ID=$row['EXPORT_APP_ID'];
		if($MEMBER_TYPE_ID=="18"){
			$MEMBER_ID=$row['MEMBER_ID'];
			$M_COMPANY_NAME=getMemberName($conn,'Member',$MEMBER_ID);
			$query_sel = "SELECT * FROM  kp_member_address_details  where MEMBER_ID='$MEMBER_ID' and MEMBER_ADD_SR_NO='2'";	
			$result_sel = mysqli_query($conn,$query_sel);
			$row = mysqli_fetch_array($result_sel);
			$M_ADD_SR_NO=$row['MEMBER_ADD_ID'];
			$M_ADDRESS=$row['MEMBER_ADDRESS1']." ".$row['MEMBER_ADDRESS2']." ".$row['MEMBER_ADDRESS3'];$M_CITY=$row['CITY'];$M_STATE=$row['STATE'];$M_PIN=$row['PINCODE'];$M_COUNTRY=$row['COUNTRY'];
		}
		if($MEMBER_TYPE_ID=="19"){
			$NON_MEMBER_ID=$row['MEMBER_ID'];
			$M_COMPANY_NAME=getMemberName($conn,'NonMember',$NON_MEMBER_ID);
			$query_sel = "SELECT * FROM  kp_non_member_master  where NON_MEMBER_ID='$NON_MEMBER_ID'";	
			$result_sel = mysqli_query($conn,$query_sel);
			$row = mysqli_fetch_array($result_sel);
			$M_ADD_SR_NO=1;
			$M_ADDRESS=$row['ADDRESS1']." ".$row['ADDRESS2']." ".$row['ADDRESS3'];$M_CITY=$row['CITY'];$M_STATE=$row['STATE_ID'];$M_PIN=$row['PINCODE'];$M_COUNTRY=$row['COUNTRY_ID'];
		}
		echo "update kp_export_application_master set M_COMPANY_NAME='$M_COMPANY_NAME',M_ADDRESS='$M_ADDRESS',M_STATE='$M_STATE',M_STATE='$M_STATE',M_COUNTRY='$M_COUNTRY',M_ADD_SR_NO='$M_ADD_SR_NO' where EXPORT_APP_ID='$EXPORT_APP_ID'";echo "<br/>";
		//$conn ->query("update gjepc_kp.kp_export_application_master set MEMBER_ID='$MEMBER_ID',NON_MEMBER_ID='$NON_MEMBER_ID',MEMBER_TYPE_ID='$MEMBER_TYPE_ID' where EXPORT_APP_ID='$EXPORT_APP_ID'");
		//$conn ->query("update gjepc_kp.kp_export_application_master set M_COMPANY_NAME='$M_COMPANY_NAME' where EXPORT_APP_ID='$EXPORT_APP_ID'");
		$conn ->query("update kp_export_application_master set M_COMPANY_NAME='$M_COMPANY_NAME',M_ADDRESS='$M_ADDRESS',M_STATE='$M_STATE',M_STATE='$M_STATE',M_COUNTRY='$M_COUNTRY',M_ADD_SR_NO='$M_ADD_SR_NO' where EXPORT_APP_ID='$EXPORT_APP_ID'");
	}
	
	
	
?>