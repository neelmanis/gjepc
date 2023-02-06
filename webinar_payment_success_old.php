<?php
include 'include-new/header.php';
include 'db.inc.php';
include 'functions.php';
?>

<section>
<div class="container inner_container">
    <?php 
	//echo "<pre>"; print_r($_POST);
	//echo "<pre>"; print_r($_SESSION); exit;
	$optional_fields = $_POST['optional_fields'];
    //$optional_fields = "1|10104|Member|KP|Other2|0";
	$pipeResponse = explode('|',$optional_fields);
	$getRedirectURL = $pipeResponse[3];
	$registration_id = $pipeResponse[4];
	if($getRedirectURL == "KP")
	{
		$Response_Code = $_POST['Response_Code'];
		$Unique_Ref_Number = $_POST['Unique_Ref_Number'];
		$ReferenceNo = $_POST['ReferenceNo'];
		$Transaction_Date = date("Y-m-d H:i:s",strtotime($_POST['Transaction_Date']));
		$Transaction_Amount = $_POST['Transaction_Amount'];
		$Payment_Mode = $_POST['Payment_Mode'];
		$_SESSION["resp"]=$_POST;
		//print_r($_SESSION["resp"]); echo "<br/>";
		$optional_fields=$_POST['optional_fields'];
		$optional_fields_arr=explode("|",$optional_fields);
		$MEMBERTYPE=$optional_fields_arr[2];
		$MEMBER_ID=$optional_fields_arr[4];
		header('location:https://gjepc.org/kp/payment_success.php?MEMBERTYPE='.$MEMBERTYPE.'&&MEMBER_ID='.$MEMBER_ID);		
		
	} else if($getRedirectURL == "ADVALOREM")
	{
		$Response_Code = $_POST['Response_Code'];
		$Unique_Ref_Number = $_POST['Unique_Ref_Number'];
		$ReferenceNo = $_POST['ReferenceNo'];
		$Transaction_Date = date("Y-m-d H:i:s",strtotime($_POST['Transaction_Date']));
		$Transaction_Amount = $_POST['Transaction_Amount'];
		$Payment_Mode = $_POST['Payment_Mode'];
		$_SESSION["response"]=$_POST;
		//print_r($_SESSION["resp"]); 
		$optional_fields=$_POST['optional_fields'];
		$optional_fields_arr=explode("|",$optional_fields);
		$MEMBERTYPE=$optional_fields_arr[2];
		$MEMBER_ID=$optional_fields_arr[4];
		header('location:https://gjepc.org/kp/advalorem_payment_success.php?MEMBERTYPE='.$MEMBERTYPE.'&&MEMBER_ID='.$MEMBER_ID);
	} else {
		$post_date=date('Y-m-d');
		$Response_Code=$_POST['Response_Code'];
		$Unique_Ref_Number=$_POST['Unique_Ref_Number'];
		$ReferenceNo= trim($_POST['ReferenceNo']);
		$Transaction_Date=date("Y-m-d H:i:s",strtotime($_POST['Transaction_Date']));
		$Transaction_Amount=$_POST['Transaction_Amount'];
		$Payment_Mode=$_POST['Payment_Mode'];
	
	//echo $Response_Code."-";
    // if($Response_Code=="E00335"){
    // $result = $conn->query("UPDATE promo_video_payment_history SET Response_Code='$Response_Code' WHERE ReferenceNo='$ReferenceNo' ");
    // } else {

    // $result = $conn->query("UPDATE promo_video_payment_history SET Response_Code='$Response_Code',Unique_Ref_Number='$Unique_Ref_Number',Transaction_Date='$Transaction_Date',`Payment_Mode`='$Payment_Mode' WHERE ReferenceNo='$ReferenceNo' ");    
    // }
	if($Response_Code=="E00335"){
    $result = $conn->query("UPDATE webinar_payment_history SET Response_Code='$Response_Code' WHERE ReferenceNo='$ReferenceNo' ");
    } else {

    $result = $conn->query("UPDATE webinar_payment_history SET Response_Code='$Response_Code',Unique_Ref_Number='$Unique_Ref_Number',Transaction_Date='$Transaction_Date',`Payment_Mode`='$Payment_Mode' WHERE ReferenceNo='$ReferenceNo' ");    
    }
   
    if($result){
     if($Response_Code=="E000" ){
        $_SESSION['succ_msg']="Your payment successfully done.";
    }elseif($Response_Code=="E00329" ){
        $_SESSION['succ_msg']="NEFT Challan Generated Successfully.";
    }else{
        $_SESSION['err_msg']="Sorry you could not make payment successfully.";
    }
    }else{
        $_SESSION['err_msg']="Something went wrong on server please contact Admin.";
    }
    
    $getInfo = $conn->query("SELECT * FROM  webinar_payment_history  WHERE ReferenceNo='$ReferenceNo'");
    
    $resultInfo = $getInfo->fetch_assoc();
    $date = date("jS F Y ");
    $ref_no = $resultInfo['ReferenceNo'];
    $order_no = $resultInfo['order_id'];
        
    $redirectUrl = "https://gjepc.org/gjepc-promo.php";
    $title = "DEEPAWALI PROMO VIDEO";
    $name = $resultInfo['name'];
     $email_id = $resultInfo['email_id'];
     $mobile_no = $resultInfo['mobile_no'];
     $registration_id = $resultInfo['registration_id'];
     $company_name = getCompanyName($registration_id,$conn);
  
    $html ='<table width="80%" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
    <tbody>    
    <tr>
      <td align="left"><img src="http://www.gjepc.org/images/gjepc_logo.png"></td>
    </tr>        
    <tr>
      <td colspan="3" height="30"><hr></td>
    </tr>        
    <tr>        
        <td colspan="3" id="content">            
            <table width="100%">
                <tr>                   
                    <td align="right"> <strong> '.$date.'</strong> </td>
                </tr>
            </table>

           <p style="line-height:22px;">Dear '.$company_name.',</p>

            <p style="line-height:22px;">Your registration for '.$title.' is Successfull</p>
            <p style="line-height:22px;"><strong>Order Id : </strong>'.$order_no.'</p>
            <p style="line-height:22px;margin-bottom:20px;"><strong>Ref No  :</strong>'.$ref_no.'</p>
            
            <p style="line-height:22px;">Should you have any queries, contact on 
             <a href="mailto:annu@gjepcindia.com">raksha@gjepcindia.com</a>/ </p>
            
            <p style="line-height:22px;">Thanking you.</p>

            <p style="line-height:22px;">Yours faithfully,</p>

            <p style="line-height:22px;"><strong>Team GJEPC.</strong></p>
                  
        </td>                  
    </tr>
       
        <tr>
            <td colspan="3" height="30"><hr></td>
        </tr>        
        <tr>
            <td align="center" colspan="3">
            
                <img src="https://www.gjepc.org/images/gjepc_logo.png">
                
                <p style="line-height:22px;">
                    <b>The Gem &amp; Jewellery Export Promotion Council</b><br>Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400051 
 <br> Tel + 9122 43541800 Fax +9122 26524769  <br> Website: <a href="https://www.gjepc.org/" target="_blank">https://www.gjepc.org/ </a>
                </p>
                
                <table cellpadding="5">
                    <tr>
                        <td> <a href="https://www.facebook.com/GJEPC" target="_blank"> <img src="https://gjepc.org/download/icon/fb.png" /> </a> </td>
                        <td> <a href="https://twitter.com/GJEPCIndia" target="_blank"> <img src="https://gjepc.org/download/icon/tw.png" /> </a> </td>
                        <td> <a href="https://www.instagram.com/gjepcindia/" target="_blank"> <img src="https://gjepc.org/download/icon/insta.png" /> </a> </td>
                        <td> <a href="https://www.linkedin.com/in/sabyaray/" target="_blank"> <img src="https://gjepc.org/download/icon/li.png" /> </a> </td>
                    </tr>
                </table>
                
            </td>
        </tr>    
           
    </tbody>
    
</table>';
	if($Response_Code =="E000" || $Response_Code =="E00329"){
		$to = $email_id;
		$subject = "GJEPC Promo Video Application"; 
		$headers  = 'MIME-Version: 1.0' . "\n"; 
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
		$headers .= 'From: GJEPC <admin@gjepc.org>';
		//$headers .= 'Cc: raksha@gjepcindia.com\r\n';     
		mail($to, $subject, $html, $headers);
	}
  }
?>
	<div class="row justify-content-center mb-0 mt-3">
	<div class="col-12 text-center">
		<h1 class="bold_font"><div class="d-block"><img src="assets/images/gold_star.png"></div>
		GJEPC  Payment Summary</h1>
	</div>
	</div>
	 <?php 
    if($_SESSION['succ_msg']!=""){
    echo "<div class='alert alert-success' role='alert' style='color: red;'>".$_SESSION['succ_msg']."</div>";
    	$_SESSION['succ_msg']="";
    }
	if($_SESSION['err_msg']!=""){
	echo "<div class='alert alert-danger' role='alert' style='color: red;'>".$_SESSION['err_msg']."</div>";
	$_SESSION['err_msg']="";
	}
    ?>
    <?php  if($ReferenceNo!=""){ ?>
	<table class="responsive_table mb-3">
        
        <tr><td><b>Transaction ID :&nbsp;&nbsp;</b> <?php echo $Unique_Ref_Number;?></td></tr>
        <tr><td><b>Reference No:&nbsp;&nbsp;</b><?php echo $ReferenceNo;?></td></tr>
        <tr><td><b>Transaction Amount:&nbsp;&nbsp;</b><?php echo $Transaction_Amount;?></td></tr>
        <tr><td><b>Transaction Date:&nbsp;&nbsp;</b><?php echo $Transaction_Date;?></td></tr>
	</table>
<?php } ?>
<?php //header("Refresh: 10; url='".$redirectUrl."'"); ?>
</div>
</section>

<?php include 'include/footer.php'; ?>