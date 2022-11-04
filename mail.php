<?php 
	//$to_admin = array("neelmani@kwebmaker.com","mithun@gjepcindia.com","sheetal.kesarkar@gjepcindia.com");
	$to_admins = "neelmani@kwebmaker.com";
	$email_array = explode(",",$to_admins);
	//echo '<pre>'. print_r($email_array); 
	//echo '<pre>'. print_r($to_admin); exit;
	send_mail($email_array,"Hello Test Emails","This is test mail","santosh@kwebmaker.com");
	
	function send_mail($to, $subject, $message,$cc){
	/*Start Config*/
	$account="donotreply@gjepcindia.com";
	//$password="Gjepc@786";
	$password="kngtnsnqthmysqmp";
	//$to="neelmani@kwebmaker.com";
	$from="donotreply@gjepcindia.com";
	$from_name="GJEPC INDIA";
    /*End Config*/
	
	include("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->Host = "smtp.office365.com";
	$mail->SMTPAuth= true;
	$mail->Port = 587;
	$mail->Username= $account;
	$mail->Password= $password;
	$mail->SMTPSecure = 'tls';
	$mail->From = $from;
	$mail->FromName= $from_name;
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;
	foreach($to as $email_to)
    {
	$mail->addAddress($email_to);
	}
	
	$mail->AddCC($cc);
	if(!$mail->send()){
	 // return false;
	  echo 0;
	} else {
	 // return true;
	  echo 1;
	}
}
?>