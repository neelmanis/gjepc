<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
	if(isset($_REQUEST['Download']) || $_REQUEST['Download']=="Download")
 		{
			$_SESSION['location']=$_REQUEST['location_id'];
			$_SESSION['type']=$_REQUEST['doc_type'];
			$_SESSION['filter']=$_REQUEST['filter'];
			$_SESSION['from_date']=date("Y-m-d",strtotime($_REQUEST['from_date']));
			$_SESSION['to_date']=date("Y-m-d",strtotime($_REQUEST['to_date']));
 			header("location:export_application.php");
 		}
 elseif(isset($_REQUEST['hs_Download'])|| $_REQUEST['hs_Download']=="Download_HS" )
 		{
 			$_SESSION['location']=$_REQUEST['location_id'];
			$_SESSION['type']=$_REQUEST['doc_type'];
			$_SESSION['filter']=$_REQUEST['filter'];
			$_SESSION['from_date']=date("Y-m-d",strtotime($_REQUEST['from_date']));
			$_SESSION['to_date']=date("Y-m-d",strtotime($_REQUEST['to_date']));
			header("location:export_HS.php");
	    }
?>