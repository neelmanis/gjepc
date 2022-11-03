<?php
session_start();

//error_reporting(0);// With this no error reporting will be there
include('db.inc.php');

$opt		=	$_POST['opt']; // User choice
$survey_id	=	$_POST['survey_id']; // User choice
$order_no	=	$_POST['order_no']; // User choice
$qst_id	=	$_POST['qst_id']; // User choice

function getQstId($survey_id,$order_no)
{
	$query_sel = "SELECT qst_id FROM survey_qst where order_no='$order_no' AND survey_id='$survey_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['qst_id'];
	}
}

$getQst_id = getQstId($survey_id,$order_no);
$user_id = $_SESSION['USERID'];
if(!is_numeric($qst_id)){
echo "Data Error";
exit; }

		$ip_address = $_SESSION['REMOTE_ADDR'] ;
        
		if(isset($_SESSION['USERID']) && $_SESSION['USERID']!='')
			$user_query="select * from survey_answer where user_id='$user_id' and survey_id='$survey_id'";
		else	
			$user_query="select * from survey_answer where IP_address='$ip_address' and survey_id='$survey_id'";
        
		$result_user=mysql_query($user_query);
			
		$sql= "INSERT INTO survey_answer(user_id,IP_address,qst_id,survey_id,opt) values('$user_id','$ip_address','$getQst_id','$survey_id','$opt')";
		$result = mysql_query($sql);		 
		
$qst_id=$qst_id+1;
$order_no=$order_no+1;
//$sqlQuestionNumber = "SELECT count(qst_id) AS total FROM survey_qst";
$sqlQuestionNumber = "SELECT count(qst_id) AS total FROM survey_qst WHERE survey_id='$survey_id' AND order_no !=0 AND status='1'";
$resultQuestionNumber = mysql_query($sqlQuestionNumber); 
$rowNumber = mysql_fetch_array($resultQuestionNumber);

$no_questions = $rowNumber['total'];
//echo $qst_id ."==". $no_questions; exit; (3>4)
if($order_no > $no_questions){
$next='F'; // Flag is set to display thank you message
} else {
$next='T'; // Flag is set to display next question

$sqlNewData="SELECT * FROM survey_qst WHERE order_no=$order_no AND survey_id='$survey_id' AND order_no !=0 AND status='1'";
$resultNewData = mysql_query($sqlNewData);
$row = mysql_fetch_assoc($resultNewData);
}

$main= array("data"=>array("q1"=>"$row[qst]","opt1"=>"$row[opt1]","opt2"=>"$row[opt2]","opt3"=>"$row[opt3]","opt4"=>"$row[opt4]","qst_id"=>"$getQst_id","survey_id"=>"$survey_id","order_no"=>"$order_no"),"next"=>"$next");
echo json_encode($main);
?>