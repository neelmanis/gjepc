<?php 
ob_start();
session_start(); 
include('../db.inc.php'); 
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
function str_replace_variable($from, $to, $content)
	{
	    $from = '/'.preg_quote($from, '/').'/';

	    return preg_replace($from, $to, $content,1);
	}

if (isset($_POST["action"]) && $_POST["action"]=="send_messsage") {

	$msg_type = filter($_POST['msg_type']);
	$msg_title = filter($_POST['msg_title']);
    $msg_description = filter($_POST['msg_description']);
    $msg_variable = filter($_POST['msg_variable']);
    $msg_contact_list = filter($_POST['msg_contact_list']);
    $custom_numbers = filter($_POST['custom_numbers']);

    if($msg_type ==""){
			echo json_encode(array("status"=>"error","message"=>"Select Message Media Type "));exit;
	}
	if($msg_contact_list ==""){
			echo json_encode(array("status"=>"error","message"=>"Select contact List "));exit;
	}else if($msg_contact_list =="custom"){
        if($custom_numbers ==""){
			echo json_encode(array("status"=>"error","message"=>"Insert Mobile Numbers "));exit;
     	}
	}

    $image = '';
	$target_folder = 'whatsappAttatchments/';
	$path_parts = "";
	$ext="";
	$target_path = "";
	$filetoupload="";
	$temp_code = rand();
	$name = $_FILES['msg_attatchment']['name'];
	$name = str_replace(" ","_",$name);
	$temp_name = $_FILES['msg_attatchment']['tmp_name'];
	
	if(preg_match("/.php/i", $name)) {
    		echo json_encode(array("status"=>"error","message"=>"Invalid File "));exit;
	}
	 if($name !='')
	{
			if(($_FILES["msg_attatchment"]["type"] == "image/jpeg") || ($_FILES["msg_attatchment"]["type"] == "image/jpg") || ($_FILES["msg_attatchment"]["type"] == "image/png") || ($_FILES["msg_attatchment"]["type"] == "application/pdf") || ($_FILES["msg_attatchment"]["type"] == "video/mp4") || ($_FILES["msg_attatchment"]["type"] == "video/mpeg") || ($_FILES["msg_attatchment"]["type"] == "application/zip") || ($_FILES["msg_attatchment"]["type"] == "application/msword")  || ($_FILES["msg_attatchment"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")){
				$target_path = $target_folder.$temp_code.'_'.$name;
				$ans = $_FILES['msg_attatchment']['tmp_name'];
				if(move_uploaded_file($temp_name,$target_path))
				{
					$file = $temp_code.'_'.$name;
				} else	{
					echo json_encode(array("status"=>"error","message"=>$_FILES['msg_attatchment']['error']));exit;
					
				}
			} else
			{
			   echo json_encode(array("status"=>"error","message"=>"Invalid File "));exit;
			}		
	}else{
		if($msg_type !="TEXT"){
			echo json_encode(array("status"=>"error","message"=>"Attatchment Required "));exit;
		}
	}

  
   if($msg_contact_list  =="loaded"){
    $contactsSql = base64_decode($_POST["data"]);
   }else if($msg_contact_list =="custom"){
     
      $custom_numbersArr = explode(",",$custom_numbers);
      if(count($custom_numbersArr) >0){
		foreach ($custom_numbersArr as $cust) {

		  $insertCust = "INSERT INTO whatsapp_temp_data SET `person`= '',`company`='',`mobile`='$cust',`variable_name`='',`type`='$msg_type',`title`='$msg_title',`description`='$msg_description',`attatchment`='$file'";
		$resCust = $conn->query($insertCust);    	
     	}
      }
      echo json_encode(array("status"=>"success","message"=>"Message Sent "));exit;

      

   }else{
   	echo json_encode(array("status"=>"error","message"=>"Select contact List "));exit;
   }

    

    $result = $conn ->query($contactsSql);
    $rCount =  $result->num_rows;
    if($rCount>0){
    while($rows = $result->fetch_assoc())
	{ 
		$name = $rows['name'];
		$company = $rows['company'];
		$mobile = $rows['mobile'];
		$msg_description = filter($_POST['msg_description']);
		if($msg_variable !=="none"){
			if($msg_variable =="person"){
				$name_tr =str_replace(" ","%20",$rows['name']);
              $msg_description = str_replace_variable("{{VAR}}",trim($name_tr),$msg_description);
			}else{
			$name_tr =str_replace(" ","%20",$rows['company']);
              $msg_description = str_replace_variable("{{VAR}}",trim($name_tr),$msg_description);
             
			}
		}else{
			$msg_description = $msg_description;
		}

		$insert = "INSERT INTO whatsapp_temp_data SET `person`= '$name',`company`='$company',`mobile`='$mobile',`variable_name`='$msg_variable',`type`='$msg_type',`title`='$msg_title',`description`='$msg_description',`attatchment`='$file'";
		$res = $conn->query($insert);
		$msg_description ="";

	}
	echo json_encode(array("status"=>"success","message"=>"Message Sent "));exit;

  }

	


}
?>