<?php
include('db.inc.php'); 
session_start(); ob_start();
include 'functions.php';
$action=$_REQUEST['action'];
if($action=="vendorReg")
{
 	$company_name= $_REQUEST['company_name'];
 	$address= $_REQUEST['address'];
 	$company_pan= $_REQUEST['company_pan'];
 	$gst= $_REQUEST['gst'];
    $contact_name= $_REQUEST['contact_name'];
 	$contact_number= $_REQUEST['contact_number'];
 	$contact_email= $_REQUEST['contact_email'];
 	$password= $_REQUEST['password'];
 	$c_password= $_REQUEST['c_password'];
    $otp_number = rand ( 1000 , 9999 );
 	/*print_r($_POST);exit;*/

  $getEmailSql = $conn ->query("SELECT * FROM vendor_registration WHERE contact_email='$contact_email'");
  $getPanSql = $conn ->query("SELECT * FROM vendor_registration WHERE company_pan='$company_pan'");

  $emailCount = $getEmailSql->num_rows;
  $panCount = $getPanSql->num_rows;
  $created_at = date("Y-m-d H:i:s");
 // $getEmail=mysql_fetch_array($getEmailSql);
  if($panCount<1){
  if($emailCount<1){
  if($password == $c_password ){
    $insert = "insert into vendor_registration set company_name='$company_name',address='$address',contact_name='$contact_name',company_pan='$company_pan',gst='$gst',contact_number='$contact_number',contact_email='$contact_email',password='$password',otp_number = '$otp_number',status='0',created_at='$created_at' ";
    $inserted=$conn ->query($insert);
    }else{
       echo json_encode(array("status"=>"notmatch","title"=>"error")); exit;
    }
  }else{
    echo json_encode(array("status"=>"emailExist","title"=>"error")); exit;
  }

}else{
   echo json_encode(array("status"=>"panExist","title"=>"error")); exit;
}
    if($inserted){

   $_SESSION['company_name']=$company_name;
   $_SESSION['contact_email']=$contact_email;

   $to = $contact_email;
   $message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Email Verification</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style=""><strong>Dear Sir / Madam,</strong></p>
        <p>Your OTP for Email verification is <strong>'.$otp_number.'</strong></p>
        <div style="border-top:1px solid #ccc;">
        <p>Regards,<br>
        <strong>GJEPC INDIA</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Account Activation OTP."; 
  
  
    $mail_result = send_mail($to, $subject, $message, "");
    echo json_encode(array("status"=>"success","title"=>"Success")); exit;
    }
}



if($action=="otp_form")
{   
$company_name = $_SESSION['company_name'];
$contact_email = $_SESSION['contact_email'];

$sqlquery = "select * from vendor_registration where company_name='$company_name' and  contact_email='$contact_email'"; 
$query=$conn ->query($sqlquery);

while($getRow = $query->fetch_assoc()) {
  $getOtp=$getRow['otp_number'];
}
/* print_r($getOtp);
 echo "<br>";
 print_r($_REQUEST['otp_number']);exit;*/

if($getOtp == $_REQUEST['otp_number']){
   $insert = "UPDATE  vendor_registration SET status='1' WHERE company_name ='$company_name' AND contact_email ='$contact_email'"; 
   $inserted=$conn ->query($insert);
    unset($_SESSION['company_name']);
    unset($_SESSION['contact_email']);
    echo json_encode(array("status"=>"success","title"=>"Success")); exit;
  } else {
  echo json_encode(array("status"=>"invalid","title"=>"invalid")); exit;
}
}

if(isset($_POST['email'])) {
$otp_number = rand (1000, 9999);
$to = $_REQUEST['email'];
$message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Email Verification</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style=""><strong>Dear Sir / Madam,</strong></p>
        <p>Your OTP for Email verification is <strong>'.$otp_number.'</strong></p>
        
        <div style="border-top:1px solid #ccc;">
        <p>Regards,<br>
        <strong>GJEPC INDIA</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Account Activation OTP."; 
   $headers  = 'MIME-Version: 1.0'."\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
   $headers .= 'From:GJEPC INDIA <do-not-reply@gjepc.org>'."\n";
   $cc = "Santosh.Yadav@gjepcindia.com";
  
  $mail_result = send_mail($to, $subject, $message, $cc);
   if($mail_result){
    echo json_encode(array("status"=>"emailSuccess","title"=>"Success")); exit;
  }else{
    echo json_encode(array("status"=>"emailFail","title"=>"Server Error")); exit;
  }  
}
 
if($action=="vendor_login")
{   
$token = $_SESSION['token'];
if($token == $_POST['csrfToken']){
 $email= filter($_REQUEST['email_id']);
 $password= filter($_REQUEST['password']);
  
 $query = "select * from vendor_registration where contact_email='$email' and  password='$password' and status='1'";  
 $userMatch= $conn ->query($query);
 $num = $userMatch->num_rows;
 $result= $userMatch->fetch_assoc();
 if($num == 1)
  {
    $_SESSION['vendorId']=$result['id'];
    $_SESSION['company_name']=$result['company_name'];
    $_SESSION['contact_email']=$result['contact_email'];
    
    echo json_encode(array("status"=>"success","title"=>"Success")); exit;
  }else{
    echo json_encode(array("status"=>"invalid","title"=>"invalid")); exit; 
  }

  }else{
     echo json_encode(array("status"=>"invalidToken","title"=>"invalidToken")); exit; 
  }
}

if($action =="recover_password"){
 $email = $_REQUEST['v_email_id'];
 $getData = $conn ->query("SELECT * FROM vendor_registration WHERE contact_email='$email'");
 $vendorData = $getData->fetch_assoc();

 $name = $vendorData['contact_name'];
 $login_id = $vendorData['contact_email'];
 $password  = $vendorData['password'];
 $countEmail = $getData->num_rows;
 if($countEmail>0){
$to = $login_id;
   $message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Recover Password</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style=""><strong>Dear Sir / Madam,</strong>'.$name.'</p>
        <p>Login Id :<strong>'.$login_id.'</strong></p>
        <p>Password :<strong>'.$password.'</strong></p>     
        <div style="border-top:1px solid #ccc;">
        <p>Regards,<br>
        <strong>GJEPC INDIA</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "Recover Password Notification"; 
   $headers  = 'MIME-Version: 1.0'."\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
   $headers .= 'From:GJEPC INDIA <do-not-reply@gjepc.org>'."\n";
   $cc = "Santosh.Yadav@gjepcindia.com";
    $mail_result = send_mail($to, $subject, $message, $cc);
   if($mail_result){
    echo json_encode(array("status"=>"emailSuccess","title"=>"Success")); exit;
  }else{
    echo json_encode(array("status"=>"emailFail","title"=>"Server Error")); exit;
  }  
 }
 echo json_encode(array("status"=>"notExist","title"=>"Email Id Not Exist")); exit;
}

if($action=="profile_update")
{
  $vendorId = $_REQUEST['vendorId'];
  $company_name= $_REQUEST['company_name'];
  $address= $_REQUEST['address'];
  $company_pan= $_REQUEST['company_pan'];
  $gst= $_REQUEST['gst'];
  $contact_number= $_REQUEST['contact_number'];
  $contact_email= $_REQUEST['contact_email'];
  $isMsme= $_REQUEST['isMsme'];
  $msme_no= $_REQUEST['msme_no'];

	$update = "UPDATE  vendor_registration SET company_name ='$company_name',address ='$address',company_pan ='$company_pan',gst='$gst',contact_number ='$contact_number',contact_email='$contact_email',isMsme='$isMsme',msme_no='$msme_no' WHERE id ='$vendorId' "; 
    $updated=$conn ->query($update);
    if($updated){
    echo json_encode(array("status"=>"success","title"=>"Success")); exit;
    }
}

function getExtension($str) 
{
   $i = strrpos($str,".");
   if (!$i) { return ""; } 

   $l = strlen($str) - $i;
   $ext = substr($str,$i+1,$l);
   return $ext;
}

if($action=="document_upload")
{  
$valid_formats = array("jpg", "png","jpeg","PNG","JPG","JPEG","pdf","PDF","doc","docx");
$vendorId = $_REQUEST['vendorId'];
$docName = $_REQUEST['docName'];
$docType = $_REQUEST['docType'];
$documentKey = $_REQUEST['document_key'];
$filename = $_FILES['document']['name'];
$ext = getExtension($filename); 
$actual_image_name = $documentKey.'_'.$vendorId.substr(str_replace(" ", "_", $ext), 5).".".$ext;
$filelocation = $_FILES['document']['tmp_name'];
$path ='vendor_documents/'.$actual_image_name;
$created_at= date("Y-m-d H:i:s");
$getDocument = $conn ->query("SELECT * FROM vendor_document_uploads WHERE  vendor_id='$vendorId' AND document_key='$documentKey' ") ;
$documentExist= $getDocument->num_rows;

if(isset($_FILES['document']) ) {

   if(in_array($ext,$valid_formats)){
    $fileUploaded= move_uploaded_file($filelocation, $path);
   if($fileUploaded){
   if($documentExist<1){
    $sqlInsert = "INSERT INTO vendor_document_uploads SET vendor_id='$vendorId',document_key='$documentKey',document_name='$docName',document='$path',status='pending',created_at='$created_at',type='c'"; 
    $inserted =  $conn ->query($sqlInsert);
     echo json_encode(array("status"=>"successInsert","title"=>"Success")); exit;
}else if($documentExist>0){
	$sqlUpdate = "UPDATE vendor_document_uploads SET document='$path',status='pending',created_at='$created_at' WHERE vendor_id ='$vendorId' AND document_key='$documentKey' ";
    $updated =  $conn ->query($sqlUpdate);
    echo json_encode(array("status"=>"successUpdate","title"=>"success")); exit;
}

  }else{
       echo json_encode(array("status"=>"error","title"=>"Error")); exit; 
  }
  }else{
       echo json_encode(array("status"=>"invalidDocs","title"=>"Error")); exit; 
  }
   } else{
           echo json_encode(array("status"=>"emptyDocs","title"=>"Error")); exit; 
  }
}

if($action=="document_upload_v")
{  
$valid_formats = array("jpg", "png","jpeg","PNG","JPG","JPEG","pdf","PDF","doc","docx");
$vendorId = $_REQUEST['vendorId'];
$areaId = $_REQUEST['area'];
$docName = $_REQUEST['docName'];
$docType = $_REQUEST['docType'];
$documentKey = $_REQUEST['document_key'];
$filename = $_FILES['document']['name'];
$ext = getExtension($filename); 
$actual_image_name = $documentKey.'_'.$vendorId.'_'.$areaId.substr(str_replace(" ", "_", $ext), 5).".".$ext;
$filelocation = $_FILES['document']['tmp_name'];
$path ='vendor_documents/'.$actual_image_name;
$created_at= date("Y-m-d H:i:s");
$ip_address = $_SERVER['REMOTE_ADDR']; 
/*print_r($_POST);exit;*/
$getDocument = $conn ->query("SELECT * FROM area_spec_doc_upload WHERE  vendor_id='$vendorId' AND area_id='$areaId' AND document_key='$documentKey'") ;
$documentExist= $getDocument->num_rows;
  if ($_REQUEST['area']!="" || !empty($_REQUEST['area']) ) {
       if(in_array($ext,$valid_formats)){
    $fileUploaded= move_uploaded_file($filelocation, $path);
   if($fileUploaded){
   if($documentExist<1){
    $sqlInsert = "INSERT INTO area_spec_doc_upload SET vendor_id='$vendorId',area_id= '$areaId', document_key='$documentKey',document_name='$docName',document='$path',status='pending',created_at='$created_at',ip_address='$ip_address'"; 
       $inserted =  $conn ->query($sqlInsert);
        $message = "Your Document Uploaded Successfully for".getVendorAreaName($areaId,$conn);
     echo json_encode(array("status"=>"successInsert","title"=>"Success","message"=>$message)); exit;
}else if($documentExist>0){
 $sqlUpdate = "UPDATE area_spec_doc_upload SET document='$path',status='pending',created_at='$created_at',ip_address='$ip_address' WHERE vendor_id ='$vendorId' AND area_id='$areaId' AND document_key='$documentKey'  ";
    $updated =  $conn ->query($sqlUpdate);

    $message = "Your Document Updated Successfully for".getVendorAreaName($areaId,$conn);
    echo json_encode(array("status"=>"successUpdate","title"=>"success","message"=>$message)); exit;
}

  }else{
       echo json_encode(array("status"=>"error","title"=>"Error")); exit; 
  }
  }else{
     $message = "Your Are Selected Invalid Document";
       echo json_encode(array("status"=>"invalidDocs","title"=>"Error","message"=>$message)); exit; 
  }
  }else{
           echo json_encode(array("status"=>"areaBlank","title"=>"Error")); exit; 

  }
}

function getDocumentKey($id,$conn)
{
            $query_sel = "SELECT document_key FROM  vendor_documents  where id='$id'";  
            $result_sel = $conn ->query($query_sel);                
            if($row = $result_sel->fetch_assoc())     
            {     
              return $row['document_key'];
            }
}

if($action=="area_registration"){
 $vendor_id= $_REQUEST['vendorId'];
 
 $area = $_REQUEST['area'];
 $areaId = $_REQUEST['areaId']; 
 $created_at = date("Y-m-d H:i:s"); 
 $ip_address = $_SERVER['REMOTE_ADDR']; 
 /*-----Get All Common Documents Key required in Array Format---------*/
$common_sql = $conn ->query("SELECT * FROM vendor_documents WHERE type ='c' AND status='1'");
while($common_sql_result= $common_sql->fetch_assoc()){
  $commonDocsArray[]= $common_sql_result['document_key'];
}

sort($commonDocsArray);
$arrlength1 = count($commonDocsArray);
for($x = 0; $x < $arrlength1; $x++) {
    $arrayCommonVal[]= $commonDocsArray[$x];
}

 /*-----Get All Variable Documents Key required in Array Format---------*/
 
$variable_sql = $conn ->query("SELECT * FROM vendor_area_specific_docs WHERE area ='$areaId' ");
$variable_sql_result= $variable_sql->fetch_assoc();
$variable_docs = explode(",",$variable_sql_result['document']);
foreach ($variable_docs as $v_docs) {

$variableDocsArray[] = getDocumentKey($v_docs,$conn);
}

sort($variableDocsArray);
$arrlength2 = count($variableDocsArray);
for($x = 0; $x < $arrlength2; $x++) {
    $arrayVariableVal[]= $variableDocsArray[$x];
    
}

/*print_r($arrayVariableVal);echo "<br>";*/

 /*-----Get All Common Uploaded Documents Key  in Array Format---------*/

$common__up_sql = $conn ->query("SELECT * FROM vendor_document_uploads WHERE vendor_id ='$vendor_id' AND type='c' ");

while($common__up_sql_res= $common__up_sql->fetch_assoc()) {
$commonUpDocsArray[]= $common__up_sql_res['document_key'];
}
sort($commonUpDocsArray);
$arrlength3 = count($commonUpDocsArray);
for($x = 0; $x < $arrlength3; $x++) {
    $arrayCommonUpVal[]= $commonUpDocsArray[$x];
}

 /*-----Get All Variable Uploaded Documents Key  in Array Format---------*/

$variable__up_sql = $conn ->query("SELECT * FROM area_spec_doc_upload WHERE vendor_id ='$vendor_id' AND area_id='$areaId' ");

while ($variable__up_sql_res= $variable__up_sql->fetch_assoc()) {
$variableUpDocsArray[]= ($variable__up_sql_res['document_key']);
}

/*get Common Documents between variable doc uploaded and variable required */
$variablesCommonArray = array_intersect($variableUpDocsArray, $variableDocsArray);
/*Sort array fo match purpose*/
sort($variablesCommonArray);
$arrlength4 = count($variablesCommonArray);
for($x = 0; $x < $arrlength4; $x++) {
    $arrayVariablesCommonVal[]= $variablesCommonArray[$x];
    
}

 $getRegisteredArea = $conn ->query("SELECT * FROM vendor_area_registration WHERE vendor_id='$vendor_id' AND area_id='$areaId'");
 $alreadyRegistered = $getRegisteredArea->num_rows;
/*print_r($arrayVariablesCommonVal);exit;*/
if($alreadyRegistered==0) {
if($arrayCommonUpVal == $arrayCommonVal) {

   // if($arrayVariablesCommonVal == $arrayVariableVal) {
   $sql = "INSERT INTO vendor_area_registration SET vendor_id='$vendor_id',area_id='$areaId',area='$area',status='pending',created_at='$created_at',ip_address='$ip_address'"; 
   $result =  $conn ->query($sql);
   if($result){
   $getVendorData  = $conn ->query("SELECT * FROM vendor_registration WHERE id='$vendor_id' ");
   $VendorDataResult = $getVendorData->fetch_assoc(); 

   $contact_name = $VendorDataResult['contact_name'];
   $company_name = $VendorDataResult['company_name'];
   $to = $VendorDataResult['contact_email'];
 $message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Email Verification</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style="">Dear Sir / Madam,<strong style="text-transform:uppercase;">'.$contact_name.'</strong></p>
        <p style="">Company Name, <strong style="text-transform:uppercase;">'.$company_name.'</strong></p>
        <p style="">Thank you for applying Vendor Empanelment Application for , <strong style="text-transform:uppercase;">'.$area.'</strong> Please note your application is under approval process.</p>
        <p style="">A system generated notification will be sent to you on successful approval/Disapproval of your Application
Kindly login at our website - iijs-signature.org to verify the same.
</p>    
        <div style="border-top:1px solid #ccc;">
        <p>Kind regards,<br>
        <strong>GJEPC Web Team</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Area Registration."; 
   
   $cc = "tender@gjepcindia.com";
  
  $mail_result = send_mail($to, $subject, $message, $cc); 
    echo json_encode(array("status"=>"success","title"=>"Success")); exit;
    }else{
      echo json_encode(array("status"=>"invalid","title"=>"Error")); exit;
    }

  //  }else{
  //   $msg=  " Kindly Upload required area specific  documents under upload  douments section";
  // echo json_encode(array("status"=>"v_doc_error","title"=>"Success","message"=>$msg)); exit;

  //  }

}else{
  $msg= " Kindly Upload required common documents under upload  douments section";
  echo json_encode(array("status"=>"c_doc_error","title"=>"Success","message"=>$msg)); exit;
}
}else{
  $msg= "Sorry You are already regestered for this area.";
  echo json_encode(array("status"=>"alreadyRegestered","title"=>"Success","message"=>$msg)); exit;
}

}
?>