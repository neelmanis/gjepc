<?php 
ob_start();
session_start(); 
include('../db.inc.php'); 
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }

if(isset($_POST['mobile_data']))
{ 
	$output = '';	
	foreach($_POST['mobile_data'] as $row)
	{
		echo '<pre>'; print_r($row); exit;
	}
	 if($output == '')
	 {
	  echo 'ok';
	 } else {
	  echo $output;
	 }
}
?>
<?php
if(isset($_POST['mobile']) && $_POST['mobile']!=""){

	$mobiles  = $_POST['mobile'];
    foreach($mobiles as $mobile){

        if($mail->send()){
            $esMessage = true;
        } else {
    	    $esMessage = false;
        }
    }
    
    if($esMessage){
        echo'<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Email sent successfully
            </div>';
        exit;
    } else {
        echo'<div class="alert alert-danger alert-dismissible"> 
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Email not sent to Please try again or type correct email!
            </div>';
        exit;           
    }
}
?>