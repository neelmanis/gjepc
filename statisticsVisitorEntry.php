<?php 

session_start();
include('header_include.php');

if($_POST && $_POST['action']=="send_otp"){
   $email = filter($_POST['email']);
    $otp = rand(0000,9999);
  $datetime = date("Y-m-d H:i:s");

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

  echo json_encode(array("status"=>"invalid"));exit;

}else{

   $emailExist = $conn->query("SELECT * FROM statistics_visitors WHERE email='$email'");
  $countEmail = $emailExist->num_rows;
  if($countEmail>0){

  $details = $conn->query("SELECT * FROM statistics_email_otp_verification WHERE email='$email'");
  $count = $details->num_rows;
  if($count>0){
    $sql = "UPDATE statistics_email_otp_verification SET `otp`='$otp', `created_date`='$datetime', `status`='0' WHERE `email`= '$email' ";
  }else{
    $sql = "INSERT INTO statistics_email_otp_verification SET `email`= '$email', `otp`='$otp', `created_date`='$datetime',`status`='0' ";
  }
  $result = $conn->query($sql);
    if($result){
      $message ='<table cellpadding="10" width="100%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
                <tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
                  <tr><td align="left"><img src="https://gjepc.org/images/gjepc_logon.png"> </td></tr>
                 
                  <tr style="background-color:#eeee;padding:30px;">
                  <td>Use OTP '.$otp.' for stastics data user registration form</td></tr>
                  
                  
                   <tr><td>       
                      <p>Kind Regards,<br>
                      <b>GJEPC Web Team,</b>
                      </p>
                   
                    </td>
                  </tr>
                 
                </table>';
    $to = $email;
    $subject = "Email Verification"; 
    $cc = "";
    send_mail($to,$subject,$message,$cc);
      echo json_encode(array("status"=>"sent"));exit;
    }else{
      echo json_encode(array("status"=>"fail"));exit;
    }
  }else{
    echo json_encode(array("status"=>"notExist"));exit;
  }
}

}
if($_POST && $_POST['action']=="confirm_otp"){

  $email = filter($_POST['email']);
  $otp = filter($_POST['otp']);
  $details = $conn->query("SELECT * FROM statistics_email_otp_verification WHERE email='$email'");
  $count = $details->num_rows;
  if($count>0){
    $row = $details->fetch_assoc();
    $db_otp = $row['otp'];
    if($db_otp == $otp){
       $conn->query("UPDATE statistics_email_otp_verification SET `status`='1' WHERE email='$email'");
       echo json_encode(array("status"=>"verified"));exit;
    }else{
       echo json_encode(array("status"=>"fail"));exit;
    }
  }else{
     echo json_encode(array("status"=>"fail"));exit;
  }

}


// Action for statistics page aaccess
// if($_POST && $_POST['action']=="v_send_otp"){
 
//    $email = filter($_POST['email']);
//     $otp = rand(0000,9999);
//   $datetime = date("Y-m-d H:i:s");

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

//   echo json_encode(array("status"=>"invalid"));exit;

// }else{

//    $emailExist = $conn->query("SELECT * FROM statistics_visitors WHERE email='$email'");
//   $countEmail = $emailExist->num_rows;
//   if($countEmail>0){

//   $details = $conn->query("SELECT * FROM statistics_email_otp_verification WHERE email='$email'");
//   $count = $details->num_rows;
//   if($count>0){
//     $sql = "UPDATE statistics_email_otp_verification SET `otp`='$otp', `created_date`='$datetime', `status`='0' WHERE `email`= '$email' ";
//   }else{
//     $sql = "INSERT INTO statistics_email_otp_verification SET `email`= '$email', `otp`='$otp', `created_date`='$datetime',`status`='0' ";
//   }
//   $result = $conn->query($sql);
//     if($result){
//       $message ='<table cellpadding="10" width="100%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
//                 <tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
//                   <tr><td align="left"><img src="https://gjepc.org/images/gjepc_logon.png"> </td></tr>
                 
//                   <tr style="background-color:#eeee;padding:30px;">
//                   <td>Use OTP '.$otp.' for stastics data user registration form</td></tr>
                  
                  
//                    <tr><td>       
//                       <p>Kind Regards,<br>
//                       <b>GJEPC Web Team,</b>
//                       </p>
                   
//                     </td>
//                   </tr>
                 
//                 </table>';
//     $to = $email;
//     $subject = "Email Verification"; 
//     $cc = "";
//     send_mail($to,$subject,$message,$cc);
//       echo json_encode(array("status"=>"sent"));exit;
//     }else{
//       echo json_encode(array("status"=>"fail"));exit;
//     }
//   }else{
//     echo json_encode(array("status"=>"notExist"));exit;
//   }
// }

// }
// if($_POST && $_POST['action']=="v_confirm_otp"){

//   $email = filter($_POST['email']);
//   $otp = filter($_POST['otp']);
//   $details = $conn->query("SELECT * FROM statistics_email_otp_verification WHERE email='$email'");
//   $count = $details->num_rows;
//   if($count>0){
//     $row = $details->fetch_assoc();
//     $db_otp = $row['otp'];
//     if($db_otp == $otp){
//        $conn->query("UPDATE statistics_email_otp_verification SET `status`='1' WHERE email='$email'");
//        echo json_encode(array("status"=>"verified"));exit;
//     }else{
//        echo json_encode(array("status"=>"fail"));exit;
//     }
//   }else{
//      echo json_encode(array("status"=>"fail"));exit;
//   }

// }
if($_POST && $_POST['action']=="recordVisits"){

  $email = filter($_POST['email']);

  $details = $conn->query("SELECT * FROM statistics_visitors WHERE email='$email'");
  $count = $details->num_rows;
  if($count>0){
    $row = $details->fetch_assoc();
    $vistis = $row['visitCount']+1;
    $conn->query("UPDATE statistics_visitors SET `visitCount`='$vistis' WHERE email='$email'");
  }else{
     echo json_encode(array("status"=>"notExist"));exit;
  }

}

// if($_POST && $_POST['actiontype']=="statistics-visitor-entry"){

//  $name = filter($_POST['name']);
//  $org_name = filter($_POST['org_name']);
//  $degn = filter($_POST['degn']);
//  $email = filter($_POST['email']);
//  $mobile = filter($_POST['mobile']);
//  $country = filter($_POST['country']);
//  $isNotification = filter($_POST['isNotification']);
//  $isMember = filter($_POST['isMember']);
//  $wantMember = filter($_POST['wantMember']);
//  $purpose = filter($_POST['purpose']);
//  if($name ==""){
//  echo json_encode(array("status"=>"error","label"=>"name","message"=>"Name is Required"));exit;
//  }else if($org_name ==""){
//  echo json_encode(array("status"=>"error","label"=>"org_name","message"=>"Organisation Name is Required"));exit;
//  }else if($degn ==""){
//  echo json_encode(array("status"=>"error","label"=>"degn","message"=>"Designation is Required"));exit;
//  }else if($email ==""){
//  echo json_encode(array("status"=>"error","label"=>"email","message"=>"Email is Required"));exit;
//  }else if($mobile ==""){
//  echo json_encode(array("status"=>"error","label"=>"mobile","message"=>"Mobile is Required"));exit;
//  }else if($country ==""){
//  echo json_encode(array("status"=>"error","label"=>"country","message"=>"Country is Required"));exit;
//  }else if($isNotification ==""){
//  echo json_encode(array("status"=>"error","label"=>"isNotification","message"=>"Notification is Required"));exit;
//  }else if($isMember ==""){
//  echo json_encode(array("status"=>"error","label"=>"isMember","message"=>"Select"));exit;
//  }else if($purpose ==""){
//  echo json_encode(array("status"=>"error","label"=>"purpose","message"=>"Purpose of information is Required"));exit;
//  }else{
//   $emailExist = $conn->query("SELECT * FROM statistics_visitors WHERE email='$email' ");
//   $countEmail  = $emailExist->num_rows;

//   if($countEmail > 0){
//    echo json_encode(array("status"=>"error","label"=>"email","message"=>"E-mail ID is already taken"));exit;
//   }else{
//     $details = $conn->query("SELECT * FROM statistics_email_otp_verification WHERE email='$email' AND `status`='1'");
//     $count = $details->num_rows;
//     // if($count>0){
//       $sql = "INSERT INTO `statistics_visitors` SET `name`='$name',`org_name`='$org_name',`degn`='$degn',`email`='$email',`mobile`='$mobile',`isMember`='$isMember',`wantMember`='$wantMember',`country`='$country',`isNotification`='$isNotification',`purpose`='$purpose'";

//       $result  = $conn->query($sql);
//       if($result){
//        echo json_encode(array("status"=>"success","email"=>$email));exit;
//       }else{
//         echo json_encode(array("status"=>"fail","message"=>"Error: Server Error"));exit;
//       }
//     // }else{
//     //     echo json_encode(array("status"=>"error","label"=>"email","message"=>"Email verification is pending"));exit;
//     // }
//   }

//  }
// } 
if($_POST && $_POST['actiontype']=="statistics-visitor-entry"){

 $name = filter($_POST['name']);
 $org_name = filter($_POST['org_name']);
 $degn = filter($_POST['degn']);
 $email = filter($_POST['email']);
 $mobile = filter($_POST['mobile']);
 $country = filter($_POST['country']);
 $isNotification = filter($_POST['isNotification']);
 $isMember = filter($_POST['isMember']);
 $wantMember = filter($_POST['wantMember']);
 $purpose = filter($_POST['purpose']);
 if($name ==""){
 echo json_encode(array("status"=>"error","label"=>"name","message"=>"Name is Required"));exit;
 }else if($org_name ==""){
 echo json_encode(array("status"=>"error","label"=>"org_name","message"=>"Organisation Name is Required"));exit;
 }else if($degn ==""){
 echo json_encode(array("status"=>"error","label"=>"degn","message"=>"Designation is Required"));exit;
 }else if($email ==""){
 echo json_encode(array("status"=>"error","label"=>"email","message"=>"Email is Required"));exit;
 }else if($mobile ==""){
 echo json_encode(array("status"=>"error","label"=>"mobile","message"=>"Mobile is Required"));exit;
 }else if($country ==""){
 echo json_encode(array("status"=>"error","label"=>"country","message"=>"Country is Required"));exit;
 }else if($isNotification ==""){
 echo json_encode(array("status"=>"error","label"=>"isNotification","message"=>"Notification is Required"));exit;
 }else if($isMember ==""){
 echo json_encode(array("status"=>"error","label"=>"isMember","message"=>"Select"));exit;
 }else if($purpose ==""){
 echo json_encode(array("status"=>"error","label"=>"purpose","message"=>"Purpose of information is Required"));exit;
 }else{
  $emailExist = $conn->query("SELECT * FROM statistics_visitors WHERE email='$email' ");
  $countEmail  = $emailExist->num_rows;

  if($countEmail > 0){
   echo json_encode(array("status"=>"error","label"=>"email","message"=>"E-mail ID is already taken"));exit;
  }else{
    // $details = $conn->query("SELECT * FROM statistics_email_otp_verification WHERE email='$email' AND `status`='1'");
    // $count = $details->num_rows;
    //  if($count>0){
      $sql = "INSERT INTO `statistics_visitors` SET `name`='$name',`org_name`='$org_name',`degn`='$degn',`email`='$email',`mobile`='$mobile',`isMember`='$isMember',`wantMember`='$wantMember',`country`='$country',`isNotification`='$isNotification',`purpose`='$purpose'";

      $result  = $conn->query($sql);
      if($result){
       echo json_encode(array("status"=>"success","email"=>$email));exit;
      }else{
        echo json_encode(array("status"=>"fail","message"=>"Error: Server Error"));exit;
      }
    // }else{
    //     echo json_encode(array("status"=>"error","label"=>"email","message"=>"Email verification is pending"));exit;
    // }
  }

 }
} 

?>