<?php 
session_start(); ob_start();
include('db.inc.php');

//validate Token
if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	if(isset($_POST['company_name']))
	{ 
		$company_name	=	filter($_POST['company_name']);
		$name		=	filter($_POST['name']);
		$email		=	filter($_POST['email']);
		$mobile		=	filter($_POST['mobile']);
		$address	=	filter($_POST['address']);
		$pdf_id		=	filter($_POST['pdf_id']);
		$post_date	=	date('Y/m/d');		
		//echo $pdf_id;
		
		$query="SELECT * FROM `tender_master` WHERE id='$pdf_id' and status=1 order by id";
		$result=$conn ->query($query);
		while($rows=$result->fetch_assoc())
		{
			$data=$rows;	
		}
		//print_r($data);
		//exit;
		$t_id	=	$data['id'];
		$tender_name	=	filter($data['name']);
		$upload_tender  =   $data['upload_tender'];
		$file_path = "https://www.gjepc.org/admin/Tender/".$upload_tender;

	$sql="insert into tender_download_info (company_name,name,email,mobile,address,download_status,`type`,tender_id,post_date) values ('$company_name','$name','$email','$mobile','$address','1','annual_report','$pdf_id','$post_date')";
	$result=$conn ->query($sql);
	if(!$result)
		echo "<script>alert('You doesn't have permission to access this pdf');</script>";		
	else
	{
		/*	$message = "<font style='font-size: 13px; color: black; font-family: arial'>";			  
			$message = $message .="<strong>Thank you for registering, we appreciate your interest in our GJEPC Projects. </strong><br>";
			$message = $message .="<strong>This email confirms our receipt of your request for downloading our tender. </strong><br>";
			$message = $message .="<strong><br>Yours Sincerely,<br>GJEPC TEAM</strong><br>";
			$message = $message .= "</font>";
			  
			$to=$email;			  
			$subject = "GJEPC Tenders PDF";
		    $headers  = 'MIME-Version: 1.0'."\n"; 
			$headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
			$headers .= 'From:GJEPC INDIA <do-not-reply@gjepc.org>'."\n";

		    if($email!="")
            {
		   	$ans=mail($to, $subject, $message, $headers);
			} */
						/*echo "<script>window.open('admin/tender/".$upload_tender."');
							</script>";
						echo "<script>window.location.href='tenders.php';
							</script>";*/
				if($result)
				{
						header("Content-type: application/pdf"); 
						header("Content-disposition: attachment; filename=$upload_tender");
						readfile("admin/Tender/".$upload_tender);
						echo "<script>window.location.href='tenders.php';</script>"; exit;
				} else {				  	
					echo "<script>alert('Email is not valid');</script>";
					echo "<script>window.location.href='tenders.php';</script>";
				}	  
	}			
	}
} else {
	echo "<script type='text/javascript'> alert('Invalid Token');window.location.href='annual_reports.php';</script>";	
}
?>