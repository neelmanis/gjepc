<?php 
//include 'include/header.php';
include 'db.inc.php'; 
?>
<?php if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }?>
<?php
    $sql_elec="SELECT status FROM `Election_Live` WHERE 1";
    $result_elec=mysql_query($sql_elec);
    $rows_elec=mysql_fetch_array($result_elec);
	if($rows_elec['status']==1){
		mysql_query("UPDATE  `gjepclivedatabase`.`Election_Live` SET  `status` =  '0'");
		echo "Updated as Zero";
	}
	elseif($rows_elec['status']==0){
		mysql_query("UPDATE  `gjepclivedatabase`.`Election_Live` SET  `status` =  '1'");
		echo "Updated as One";
	} 
?>