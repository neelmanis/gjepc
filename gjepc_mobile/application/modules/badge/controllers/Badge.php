<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Badge extends MX_Controller
{
  function __construct() {
    parent::__construct();
      $this->load->model('Mdl_badge');
      // header('Content-type: image/jpeg');
      // header('Content-type: application/pdf');
    
      // ini_set('error_reporting', 'ALL');
    
        // ini_set('file_put_contents', '1');
        // print (int) ini_get("file_put_contents");exit;
     
      $this->load->library('ci_qr_code');
      $this->config->load('qr_code');
  }

/********************************************************** DOMESTIC Visitor PAN VEFIRICATION **************************************************/
function view($uniqueId){
    $data = array();

    $badgeInfo = $this->Mdl_badge->retrieve("globalExhibition",array("uniqueIdentifier"=>$uniqueId));

     if(isset($badgeInfo) && $badgeInfo !=='NA'){
           if($badgeInfo[0]->status !=="Y"){
        $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"Your Badge is not active",
          "status"=>"false"
          );  
        echo json_encode(array("Response"=>$response));exit;
      }else if($badgeInfo[0]->dose2_status !=="Y"){
        $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"Vaccination is not complete",
          "status"=>"false"
          );  
        echo json_encode(array("Response"=>$response));exit;
      }
    }else{
      $response = array("status"=>"invalid","message"=>"Record not found");
      echo json_encode($response);exit;
    }

 
    switch ($badgeInfo[0]->participant_Type) {
      case 'VIS':
            $data["city"] = $this->getVisitorCity($badgeInfo[0]->registration_id);
            $color = "sky_blue"; 
            $data["participantType"] = "Visitor";
            $data["agency_category"] = "";
            $data["committee"] = "";
            $data["participantTitle"] = "TRADE VISITOR";
            $data["participantSecondTitle"] = "";
            $data["participantShortTitle"] = "V";
            $data["class"] = "text-dark";

      break;
      case 'IGJME':
            $data["city"] = $this->getVisitorCity($badgeInfo[0]->registration_id);
            $color = "orange"; 
            $data["participantType"] = "Visitor";
            $data["agency_category"] = "";
            $data["committee"] = "";
            $data["participantTitle"] = "MACHINERY SHOW VISITOR";
            $data["participantSecondTitle"] = "";
            $data["participantShortTitle"] = "MV";
            $data["class"] = "text-dark";
        
      break;
      case 'INTL':
            $data["city"]="";
            $color = "light_blue"; 
            $data["participantType"] = "International Visitor";
            $data["agency_category"] = "";
            $data["committee"]= "";
            $data["participantTitle"] = "OVERSEAS VISITOR";
            $data["participantSecondTitle"] = "";
            $data["participantShortTitle"] = "OV";
            $data["class"] = "text-white";

      break;
      case 'EXH':
            $data["city"]="";
            $color = "green"; 
            $data["participantType"] = "Exhibitor";
            $data["agency_category"] = "";
            $data["committee"] = "";
            $data["participantTitle"] = "EXHIBITOR";
            $data["participantSecondTitle"] = "";
            $data["participantShortTitle"] = "E";
            $class = "text-white";
      break;
      case 'EXHM':
            $data["city"]="";
            $color = "green"; 
            $data["participantType"] = "Machinery Exhibitor";
            $data["agency_category"] = "";
            $data["committee"] = "";
            $data["participantTitle"] = "MACHINERY EXHIBITOR";
            $data["participantSecondTitle"] = "";
            $data["participantShortTitle"] = "ME";
            $data["class"] = "text-white";
      break;
      case 'CONTR':
            $data["city"]="";
            $data["participantType"] = "Agency";
            $data["class"] = "text-dark";
            $data["agency_category"] = $badgeInfo[0]->agency_category;
            $data["committee"] = $badgeInfo[0]->committee;
            $data["participantSecondTitle"] = "";
            if($agency_category =="CM"){
              $color = "blue"; 
              if($committee =="C"){
                $data["participantTitle"] = "CHAIRMAN";
                $data["participantShortTitle"] = "C";
              }elseif($committee =="VC"){
                $data["participantTitle"] = "VICE CHAIRMAN";
                $data["participantShortTitle"] = "VC";
              }elseif($committee =="CO"){
                $data["participantTitle"] = "CONVENER";
                $data["participantShortTitle"] = "CO";
              }elseif($committee =="CC"){
                $data["participantTitle"] = "CO-CONVENER";
                $data["participantShortTitle"] = "CC";
              }elseif($committee =="CM"){
                $data["participantTitle"] = "COMMITTEE MEMBER";
                $data["participantShortTitle"] = "CM";
              }elseif($committee =="COA"){
                $data["participantTitle"] = "COMMITTEE OF ADMINISTRATION";
                $data["participantShortTitle"] = "COA";
              }
              $data["class"] = "text-white";
            }elseif($agency_category =="O"){
                $color = "blue"; 
                $data["participantTitle"] = "Organizer";
                $data["participantShortTitle"] = "O";

            }elseif($agency_category =="OA"){
              $color = "magenta"; 
              $data["participantTitle"] = "Official Agency";
              $data["participantShortTitle"] = "OA";
            }elseif($agency_category =="G"){
              $color = "grey"; 
              $data["participantTitle"] = "GUEST";
              $data["participantShortTitle"] = "G";
              $data["class"] = "text-dark";
            }elseif($agency_category =="VV"){
              $color = "sky_blue"; 
              $data["participantTitle"] = "TRADE VISITOR";
              $data["participantShortTitle"] = "VVIP";
              $data["class"] = "text-dark";
            }elseif($agency_category =="VIP"){
              $color = "sky_blue"; 
              $data["participantTitle"] = "TRADE VISITOR";
              $data["participantShortTitle"] = "VIP";
              $data["class"] = "text-dark";
            }elseif($agency_category =="P"){
              $color = "white"; 
              $data["participantTitle"] = "PRESS";
              $data["participantShortTitle"] = "P";
              $data["class"] = "text-dark";

            }elseif($agency_category =="S"){
              $color = "s_green"; 
              $data["participantTitle"] = "STUDENT";
              $data["participantShortTitle"] = "S";
              $data["class"] = "text-dark";
              
            }elseif($agency_category =="ED"){
              $color = "grey_blue"; 
              $data["participantTitle"] = "Executive Director";
              $data["participantShortTitle"] = "ED";
              $data["class"] = "text-dark";
              
            }

      break;
      default:
            $data["city"]="";
            $color  = "grey";
            $data["participantType"] = "";
            $data["agency_category"] = "";
            $data["committee"] = "";
            $data["participantTitle"] = "";
            $data["participantShortTitle"] = "";
            $data["participantSecondTitle"] = "";
      break;
    }

    if( $badgeInfo[0]->dose2_status=="Y" ){
      $data["color"] = $color;
      $data["badgeStatus"] = "Active";
    }else{
      $data["color"] = "grey";
      $data["badgeStatus"] = "Inactive";
      
    }
   
    /*=============GENERATE QR CODE================*/
    $qr_status = $this->generate_qr($uniqueId);
    $data["qr_link"] = base_url()."global/tmp/qr_codes/".$uniqueId.".png";
    /*=============GENERATE QR CODE================*/

    $data["assets_path"] = "https://gjepc.org/iijs-signature/";
    $data["name"] = $badgeInfo[0]->fname." ".$badgeInfo[0]->lname;
    $data["designation"] = $badgeInfo[0]->designation;
    $data["days"] = "18th to 21st Feb 2022";
    $data["note"]= "Valid for IIJS SIGNATURE 2022 on 06th to 09th January 20220only";
    $dose1_status = $badgeInfo[0]->dose1_status;
    $dose2_status = $badgeInfo[0]->dose2_status;
    if($dose2_status=="Y"){
      $dose1_status = "Y";
    }
    $data["dose2_status"] = $dose2_status;
    $data["path"] = "badges/";
    $data["filename"] = $uniqueId.'.pdf';
    $data['view'] = 'iijs-premiere';
 

   $status = Modules::run('pdf/makePDF',$data);
}

function checkVisitorPan(){
   // $response=array(
   //            "verified"=>"N",
   //            "Result"=>"",
   //            "Message"=>"Coming soon..",
   //            "status"=>"false"
   //          );
   //  echo json_encode(array("Response"=>$response)); exit;
  $json = file_get_contents('php://input');
  $obj = json_decode($json,True);
  $pan_no = trim($obj['pan_no']);
    $datetime = date("Y-m-d H:i:s");
  if($pan_no !=""){
    
        /*
        ** CHECK PAN NUMBER IS ALREADY EXIST IN TABLE OR NOT
        */
        $panExist = $this->Mdl_badge->isExist("globalExhibition",array("pan_no"=>$pan_no));
        if($panExist ===TRUE){
          $digits = 4;  
          $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);

          $getGlobal = $this->Mdl_badge->retrieve("globalExhibition",array("pan_no"=>$pan_no));
          $status =  $getGlobal[0]->status;
          if($status  =="Y"){

             if($getGlobal[0]->participant_Type =="IGJME"  ){
              $response=array(
                "verified"=>"N",
                "Result"=>"",
                "Message"=>"Digital badge is not allowed for Machinary visitors",
                "status"=>"false"
              ); 
            }else{
                $isSecondary = $getGlobal[0]->isSecondary;
          if($isSecondary =="Y"){
            $mobile_no = $getGlobal[0]->secondary_mobile;
          }else{
            $mobile_no = $getGlobal[0]->mobile;
          }
          $isVerified = $getGlobal[0]->isVerified;
          
            $id = $getGlobal[0]->id;
            $company_name = $getGlobal[0]->company;
            $visitor_name = $getGlobal[0]->fname." ".$getGlobal[0]->lname;
            $designation = $getGlobal[0]->designation;

             $message = "One Time Password for Visitor Verification is ".$otp." , Regards GJEPC";
          
            $data = array("otp"=>$otp,"modified_date"=>$datetime);
            $result=$this->Mdl_badge->update("globalExhibition",array("pan_no"=>$pan_no,"id"=>$id),$data);
            if($result){

            
              $isSent = $this->send_otp($message,$mobile_no);
              if($isSent){
                $response=array(
                "verified"=>"N",
                "Result"=>array("mobile_no"=>$mobile_no,"otp"=>$otp,"participant_Type"=>"Domestic","company_name"=>$company_name,"visitor_name"=>$visitor_name,"designation"=>$designation),
                "Message"=>"OTP has been Sent to Registered  mobile number",
                "status"=>"true"
                );
              }else{
              $response=array(
                "verified"=>"N",
                "Result"=>"",
                "Message"=>"Error: OTP Sending failed",
                "status"=>"false"
              );
            }

            }else{
              $response=array(
              "verified"=>"N",
              "Result"=>"",
              "Message"=>"Error: OTP Update Failed ",
              "status"=>"false"
            );
            }
         }
          } else{
             $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Your Badge is not active",
        "status"=>"false"
    );  
          }



        
       
              
        }else{
            $response=array(
              "verified"=>"N",
        "Result"=>"",
        "Message"=>"You are not registered for IIJS SIGNATURE 2022 show",
        "status"=>"false"
        );  
        }
  }else{
      $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Enter Pan Number",
        "status"=>"false"
    );  
  }

  header('Content-type: application/json');
  echo json_encode(array("Response"=>$response));

}

function verifyMobileOtpAction(){ 
  $json = file_get_contents('php://input');
  $obj = json_decode($json,True);
//  print_r($obj);exit;
  $otp_number = trim($obj['otp_number']);
  $pan_no = trim($obj['pan_no']);
    $datetime = date("Y-m-d H:i:s");
  if($pan_no !="" && $otp_number !=""){
    
        /*
        ** CHECK MOBILE NUMBER IS ALREADY EXIST IN TABLE OR NOT
        */

        $panExist = $this->Mdl_badge->isExist("globalExhibition",array("pan_no"=>$pan_no));
        if($panExist ===TRUE){

           $getOtpDetails =  $this->Mdl_badge->retrieve("globalExhibition",array("pan_no"=>$pan_no,"otp"=>$otp_number));
           
           if($getOtpDetails !="NA"){

            $db_otp = trim($getOtpDetails[0]->otp);
            $id = trim($getOtpDetails[0]->id);
            if($getOtpDetails[0]->covid_report_status !=='negative' ){
            $badgeStatus = "Inactive";
            }else{
              $badgeStatus = "Active";
            }

            
            if($db_otp == $otp_number){
            $data = array("isVerified"=>'1',"modified_date"=>$datetime);
            $result=$this->Mdl_badge->update("globalExhibition",array("pan_no"=>$pan_no,"id"=>$id,),$data);
              $uniqueId = trim($getOtpDetails[0]->uniqueIdentifier);
                $link = "https://gjepc.org/gjepc_mobile/badge/preview/".$uniqueId;  
                $response=array(
                   "verified"=>"N",
          "Result"=>$this->preview($uniqueId),
          "Message"=>"OTP has been verified successfully ",
          "status"=>"true"
          );  
          

            }else{
              $response=array(
                 "verified"=>"N",
          "Result"=>"",
          "Message"=>"OTP Not Matched",
          "status"=>"false"
          );  
            }


           }else{

                $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"OTP Not Matched",
          "status"=>"false"
          );  
           }

        }else{
          $response=array(
             "verified"=>"N",
        "Result"=>"",
        "Message"=>"Pan Number Not Found",
        "status"=>"false"
        );  
        }
  }else{
      $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Enter Pan Number AND OTP properly",
        "status"=>"false"
    );  
  }

  header('Content-type: application/json');
  echo json_encode(array("Response"=>$response));
} 

/******************************************************** International Visitor Email VEFIRICATION ***********************************************/

function checkIntlVisitorEmail(){
    //  $response=array(
    //           "verified"=>"N",
    //           "Result"=>"",
    //           "Message"=>"Coming soon..",
    //           "status"=>"false"
    //         );
    // echo json_encode(array("Response"=>$response)); exit;
  $json = file_get_contents('php://input');
  $obj = json_decode($json,True);
  $email = trim($obj['email']);
    $datetime = date("Y-m-d H:i:s");
  if($email !=""){
        /*
        ** CHECK EmailIS  EXIST IN TABLE OR NOT
        */
        $emailExist = $this->Mdl_badge->isExist("globalExhibition",array("email"=>$email,"participant_Type"=>"INTL"));
        if($emailExist ===TRUE){
          $digits = 4;  
          $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
           $getGlobal = $this->Mdl_badge->retrieve("globalExhibition",array("email"=>$email,"participant_Type"=>"INTL"));
           $status =  $getGlobal[0]->status;
          if($status  =="Y"){
           $isVerified = $getGlobal[0]->isVerified;
          // if($isVerified =="1"){
          //   $uniqueId = $getGlobal[0]->uniqueIdentifier;
          //   $response=array(
          //   "verified"=>"Y",
          //   "Result"=>$this->preview($uniqueId),
          //   "Message"=>"OTP has been verified successfully ",
          //   "status"=>"true"
          //   );  
          // }else{
         
          $name = $getGlobal[0]->fname." ".$getGlobal[0]->lname;
          $company_name = $getGlobal[0]->company;
          $visitor_name = $getGlobal[0]->fname." ".$getGlobal[0]->lname;
          $designation = $getGlobal[0]->designation;
            $data = array("otp"=>$otp,"modified_date"=>$datetime);
            $result=$this->Mdl_badge->update("globalExhibition",array("email"=>$email,"participant_Type"=>"INTL"),$data);
            if($result){
              
               $message ='
                <table width="100%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
                    <tr>
                    <td style="padding:30px;">  
                      <table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
                      <tr>
                        <td align="left"> <img src="https://registration.gjepc.org/images/logo.png"/> </td>
                        <td align="right"><img id="ri" src="https://registration.gjepc.org/images/signature-logo.png"></td>
                      </tr>
                      <tr>
                      <td align="right" colspan="3" height="30px"><hr /></td>
                      </tr>
                      <tr>
                      <td align="right" colspan="3" height="10px"></td>
                      </tr>
                      <tr>
                      <td colspan="3" style="font-size:13px; line-height:22px;">
                       <p> Dear '.$name.',</p>
                       <p>One Time Password for Visitor Verification is '.$otp.'.</p>
                      <p>Warm Regards,</p></br>
                      <p>IIJS SIGNATURE 2022 SHOW Web Team.</p>
                      </td>
                      </tr>
                      <tr>
                      <td colspan="4" align="right" ><hr /></td>
                      </tr>
                    </table>
                    </td>
                  </tr> 
                </table>';  
                $subject = "IIJS SIGNATURE 2022 - Email ID Verification"; 
			    $cc = "";
			    $emailSend = array($email,"Snehal.Rane@gjepcindia.com","naheed@gjepcindia.com");
              
                $isSent = $this->send_mailArray($emailSend,$subject,$message,$cc);
                $isSent =true;
                if($isSent){
                $response=array(
                  "verified"=>"N",
                  "Result"=>array("email"=>$email,"participant_Type"=>"International","company_name"=>$company_name,"visitor_name"=>$visitor_name,"designation"=>$designation),
                  "Message"=>"OTP has been Sent to Registered  E-mail ID",
                  "status"=>"true"
                );
              }else{
                $response=array(
                  "verified"=>"N",
                  "Result"=>"",
                  "Message"=>"Error: OTP Sending failed",
                  "status"=>"false"
                );
              }
            }else{
              $response=array(
                "verified"=>"N",
          "Result"=>"",
          "Message"=>"Error: OTP Update Failed ",
          "status"=>"false"
            );
            }
         // }
         } else{
             $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Your Badge is not active",
        "status"=>"false"
    );  
          }

              
        }else{
            $response=array(
              "verified"=>"N",
        "Result"=>"",
         "Message"=>"You are not registered for IIJS SIGNATURE 2022 show",
        "status"=>"false"
        );  
        }
  }else{
      $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Enter Registered E-mail ID ",
        "status"=>"false"
    );  
  }

  header('Content-type: application/json');
  echo json_encode(array("Response"=>$response));

}

function verifyEmailOtpAction(){ 
  $json = file_get_contents('php://input');
  $obj = json_decode($json,True);
  $otp_number = trim($obj['otp_number']);
  $email = trim($obj['email']);
  $datetime = date("Y-m-d H:i:s");
  if($email !="" && $otp_number !=""){
    
        /*
        ** CHECK MOBILE NUMBER IS ALREADY EXIST IN TABLE OR NOT
        */

        $emailExist = $this->Mdl_badge->isExist("globalExhibition",array("email"=>$email,"participant_Type"=>"INTL"));
        if($emailExist ===TRUE){

           $getOtpDetails =  $this->Mdl_badge->retrieve("globalExhibition",array("email"=>$email,"otp"=>$otp_number,"participant_Type"=>"INTL"));
           
           if($getOtpDetails !="NA"){

            $db_otp = trim($getOtpDetails[0]->otp);
            if($getOtpDetails[0]->covid_report_status !=='negative' ){
                $badgeStatus = "Inactive";
            }else{
              $badgeStatus = "Active";
            }

            
            if($db_otp == $otp_number){
              $uniqueId = trim($getOtpDetails[0]->uniqueIdentifier);
              $data = array("isVerified"=>'1',"modified_date"=>$datetime);
              $result=$this->Mdl_badge->update("globalExhibition",array("uniqueIdentifier"=>$uniqueId,"participant_Type"=>"INTL"),$data);

                $link = "https://gjepc.org/gjepc_mobile/badge/preview/".$uniqueId;  
                $response=array(
            "verified"=>"N",
           "Result"=>$this->preview($uniqueId),
          "Message"=>"OTP has been verified successfully ",
          "status"=>"true"
          );  
          

            }else{
              $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"OTP Not Matched",
          "status"=>"false"
          );  
            }


           }else{

                $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"OTP Not Matched",
          "status"=>"false"
          );  
           }

        }else{
          $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Pan Number Not Found",
        "status"=>"false"
        );  
        }
  }else{
      $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Enter E-mail ID Number AND OTP properly",
        "status"=>"false"
    );  
  }

  header('Content-type: application/json');
  echo json_encode(array("Response"=>$response));
} 
/********************************************************** EXHIBITORS MOBILE VEFIRICATION **************************************************/

function checkExhMobile(){
    //  $response=array(
    //           "verified"=>"N",
    //           "Result"=>"",
    //           "Message"=>"Coming soon..",
    //           "status"=>"false"
    //         );
    // echo json_encode(array("Response"=>$response)); exit;
  $json = file_get_contents('php://input');
  $obj = json_decode($json,True);
  $mobile = trim($obj['mobile']);
    $datetime = date("Y-m-d H:i:s");
  if($mobile !=""){
    
        /*
        ** CHECK PAN NUMBER IS ALREADY EXIST IN TABLE OR NOT
        */
        $sql = "SELECT * FROM globalExhibition WHERE mobile = '$mobile' AND (participant_Type ='EXH' OR participant_Type ='EXHM')";
        $getGlobal =  $this->Mdl_badge->customQuery($sql);
       
        if($getGlobal !=="NA"){
          $digits = 4;  
          $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);

          
           $status =  $getGlobal[0]->status;
          if($status  =="Y"){
          $mobile_no = $getGlobal[0]->mobile;
          $company_name = $getGlobal[0]->company;
          $visitor_name = $getGlobal[0]->fname." ".$getGlobal[0]->lname;
          $designation = $getGlobal[0]->designation;

          $isVerified = $getGlobal[0]->isVerified;
          // if($isVerified =="1"){
          //   $uniqueId = $getGlobal[0]->uniqueIdentifier;
          //   $response=array(
          //   "verified"=>"Y",
          //   "Result"=>$this->preview($uniqueId),
          //   "Message"=>"OTP has been verified successfully ",
          //   "status"=>"true"
          //   ); 
          // }else{
             $message = "One Time Password for Visitor Verification is ".$otp." , Regards GJEPC";
            $data = array("otp"=>$otp,"modified_date"=>$datetime);
            $result=$this->Mdl_badge->update("globalExhibition",array("mobile"=>$mobile),$data);
            if($result){
              $isSent = $this->send_otp($message,$mobile_no);
              if($isSent){
                $response=array(
                  "verified"=>"N",
                  "Result"=>array("mobile_no"=>$mobile_no,"otp"=>$otp,"participant_Type"=>"Exhibitor","company_name"=>$company_name,"visitor_name"=>$visitor_name,"designation"=>$designation),
                  "Message"=>"OTP has been Sent to Registered  mobile number",
                  "status"=>"true"
                   );
              }else{
                $response=array(
                  "verified"=>"N",
                  "Result"=>"",
                  "Message"=>"Error: OTP Sending failed",
                  "status"=>"false"
                );
              }

            }else{
              $response=array(
                "verified"=>"N",
                "Result"=>"",
                "Message"=>"Error: OTP Update Failed ",
                "status"=>"false"
              );
            }
          //}
             } else{
             $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Your Badge is not active",
        "status"=>"false"
    );  
          }

           
              
        }else{
            $response=array(
            "verified"=>"N",
            "Result"=>"",
             "Message"=>"You are not registered for IIJS SIGNATURE 2022 show",
            "status"=>"false"
          );  
        }
  }else{
      $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Enter Mobile Number",
        "status"=>"false"
    );  
  }

  header('Content-type: application/json');
  echo json_encode(array("Response"=>$response));

}

function verifyExhMobileOtpAction(){ 
  $json = file_get_contents('php://input');
  $obj = json_decode($json,True);
//  print_r($obj);exit;
  $otp_number = trim($obj['otp_number']);
  $mobile = trim($obj['mobile']);
  $datetime = date("Y-m-d H:i:s");
  if($mobile !="" && $otp_number !=""){
    
        /*
        ** CHECK MOBILE NUMBER IS ALREADY EXIST IN TABLE OR NOT
        */
        $sql = "SELECT * FROM globalExhibition WHERE mobile = '$mobile' AND (participant_Type ='EXH' OR participant_Type ='EXHM')";
        $getGlobal =  $this->Mdl_badge->customQuery($sql);

        if($getGlobal !=="NA"){
           
           $getOtpDetails =  $this->Mdl_badge->customQuery("SELECT * FROM globalExhibition WHERE mobile ='$mobile' AND otp='$otp_number' AND (participant_Type='EXH' OR participant_Type ='EXHM')");
     
           
           if($getOtpDetails !="NA"){

            $db_otp = trim($getOtpDetails[0]->otp);
           
            if($getOtpDetails[0]->covid_report_status !=='negative' ){
            $badgeStatus = "Inactive";
        }else{
          $badgeStatus = "Active";
        }

            
            if($db_otp == $otp_number){
               
              $uniqueId = trim($getOtpDetails[0]->uniqueIdentifier);
              $id = trim($getOtpDetails[0]->id);
              $data = array("isVerified"=>'1',"modified_date"=>$datetime);
              $result=$this->Mdl_badge->update("globalExhibition",array("id"=>$id),$data);
                $link = "https://gjepc.org/gjepc_mobile/badge/preview/".$uniqueId;  
                $response=array(
                  "verified"=>"N",
          "Result"=>$this->preview($uniqueId),
          "Message"=>"OTP has been verified successfully ",
          "status"=>"true"
          );  
          

            }else{
              $response=array(
                "verified"=>"N",
          "Result"=>"",
          "Message"=>"OTP Not Matched",
          "status"=>"false"
          );  
            }


           }else{

                $response=array(
                  "verified"=>"N",
          "Result"=>"",
          "Message"=>"OTP Not Matched",
          "status"=>"false"
          );  
           }

        }else{
          $response=array(
            "verified"=>"N",
        "Result"=>"",
        "Message"=>"Mobile Number Not Found",
        "status"=>"false"
        );  
        }
  }else{
      $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Enter Mobile Number AND OTP properly",
        "status"=>"false"
    );  
  }

  header('Content-type: application/json');
  echo json_encode(array("Response"=>$response));
} 




/********************************************************** VENDORS MOBILE VEFIRICATION **************************************************/

function checkVendorMobile(){
  //  $response=array(
  //           "verified"=>"N",
  //           "Result"=>"",
  //           "Message"=>"Coming soon..",
  //           "status"=>"false"
  //         );
  // echo json_encode(array("Response"=>$response)); exit;
  $json = file_get_contents('php://input');
  $obj = json_decode($json,True);
  $mobile = trim($obj['mobile']);
    $datetime = date("Y-m-d H:i:s");
  if($mobile !=""){
    
        /*
        ** CHECK PAN NUMBER IS ALREADY EXIST IN TABLE OR NOT
        */
        $mobileExist = $this->Mdl_badge->isExist("globalExhibition",array("mobile"=>$mobile,"participant_Type"=>"CONTR"));
        if($mobileExist ===TRUE){
          $digits = 4;  
          $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);

          $getGlobal = $this->Mdl_badge->retrieve("globalExhibition",array("mobile"=>$mobile,"participant_Type"=>"CONTR"));
           $status =  $getGlobal[0]->status;
           $agency_category =  $getGlobal[0]->agency_category;
          if($status  =="Y"){
            if($agency_category =="O" || $agency_category =="OA" || $agency_category =="SE"  ){
              $response=array(
                "verified"=>"N",
                "Result"=>"",
                "Message"=>"Digital badge is not allowed for you",
                "status"=>"false"
              ); 
            }else{
          $mobile_no = $getGlobal[0]->mobile;
          $company_name = str_replace(array('&amp;','&AMP;'), '&', $getGlobal[0]->company);
          $visitor_name = $getGlobal[0]->fname." ".$getGlobal[0]->lname;
          $designation = $getGlobal[0]->designation;

          $isVerified = $getGlobal[0]->isVerified;
          // if($isVerified =="1"){
          //   $uniqueId = $getGlobal[0]->uniqueIdentifier;
          //   $response=array(
          //   "verified"=>"Y",
          //   "Result"=>$this->preview($uniqueId),
          //   "Message"=>"OTP has been verified successfully ",
          //   "status"=>"true"
          //   );  
          // }else{
              $message = "One Time Password for Visitor Verification is ".$otp." , Regards GJEPC";
            
            $data = array("otp"=>$otp,"modified_date"=>$datetime);
            $result=$this->Mdl_badge->update("globalExhibition",array("mobile"=>$mobile,"participant_Type"=>"CONTR"),$data);
            if($result){

              $isSent = $this->send_otp($message,$mobile_no);
              if($isSent){
                $response=array(
                  "verified"=>"N",
                  "Result"=>array("mobile_no"=>$mobile_no,"otp"=>$otp,"participant_Type"=>"AGENCY/VENDOR","company_name"=>$company_name,"visitor_name"=>$visitor_name,"designation"=>$designation),
                  "Message"=>"OTP has been Sent to Registered  mobile number",
                  "status"=>"true"
                   );
              }else{
                $response=array(
                  "verified"=>"N",
                  "Result"=>"",
                  "Message"=>"Error: OTP Sending failed",
                  "status"=>"false"
                );
              }

            }else{
              $response=array(
                "verified"=>"N",
                "Result"=>"",
                "Message"=>"Error: OTP Update Failed ",
                "status"=>"false"
              );
            }
          //}

          }
            } else{
             $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Your Badge is not active",
        "status"=>"false"
    );  
          }
            
              
        }else{
            $response=array(
              "verified"=>"N",
            "Result"=>"",
             "Message"=>"You are not registered for IIJS SIGNATURE 2022 show",
            "status"=>"false"
          );  
        }
  }else{
      $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Enter Mobile Number",
        "status"=>"false"
    );  
  }

  header('Content-type: application/json');
  echo json_encode(array("Response"=>$response));

}

function verifyVendorMobileOtpAction(){ 
  $json = file_get_contents('php://input');
  $obj = json_decode($json,True);
//  print_r($obj);exit;
  $otp_number = trim($obj['otp_number']);
  $mobile = trim($obj['mobile']);
  $datetime = date("Y-m-d H:i:s");
  if($mobile !="" && $otp_number !=""){
    
        /*
        ** CHECK MOBILE NUMBER IS ALREADY EXIST IN TABLE OR NOT
        */

        $mobileExist = $this->Mdl_badge->isExist("globalExhibition",array("mobile"=>$mobile,"participant_Type"=>"CONTR"));
        if($mobileExist ===TRUE){

           $getOtpDetails =  $this->Mdl_badge->retrieve("globalExhibition",array("mobile"=>$mobile,"otp"=>$otp_number,"participant_Type"=>"CONTR"));
           
           if($getOtpDetails !="NA"){

            $db_otp = trim($getOtpDetails[0]->otp);
            if($getOtpDetails[0]->covid_report_status !=='negative' ){
            $badgeStatus = "Inactive";
        }else{
          $badgeStatus = "Active";
        }

            
            if($db_otp == $otp_number){
              $id = trim($getOtpDetails[0]->id);
              $data = array("isVerified"=>'1',"modified_date"=>$datetime);
              $result=$this->Mdl_badge->update("globalExhibition",array("id"=>$id,"participant_Type"=>"CONTR"),$data);
              
              $uniqueId = trim($getOtpDetails[0]->uniqueIdentifier);
                $link = "https://gjepc.org/gjepc_mobile/badge/preview/".$uniqueId;  
                $response=array(
          "verified"=>"N",
          "Result"=>$this->preview($uniqueId),
          "Message"=>"OTP has been verified successfully ",
          "status"=>"true"
          );  
          

            }else{
              $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"OTP Not Matched",
          "status"=>"false"
          );  
            }


           }else{

          $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"OTP Not Matched",
          "status"=>"false"
          );  
           }

        }else{
          $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Mobile Number Not Found",
        "status"=>"false"
        );  
        }
  }else{
      $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Enter Mobile Number AND OTP properly",
        "status"=>"false"
    );  
  }

  header('Content-type: application/json');
  echo json_encode(array("Response"=>$response));
} 

function preview($uniqueId){
    
    $data = array();

    $badgeInfo = $this->Mdl_badge->retrieve("globalExhibition",array("uniqueIdentifier"=>$uniqueId));

    if(isset($badgeInfo) && $badgeInfo !=='NA'){

      if($badgeInfo[0]->status =="Y"){

      }else{

        
        $response=array(
        "verified"=>"N",
        "Result"=>"",
        "Message"=>"Your Badge is not active",
        "status"=>"false"
        );  
        echo json_encode(array("Response"=>$response));exit;
      }

    }else{
      $response = array("status"=>"invalid","message"=>"Record not found");
      echo json_encode($response);exit;
    }
 
    switch ($badgeInfo[0]->participant_Type) {
      case 'VIS':
            $city = $this->getVisitorCity($badgeInfo[0]->registration_id);
            $color = "orange"; 
            $participantType = "Visitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "Visitor";
            $participantSecondTitle = "";
            $participantShortTitle = "V";

      break;
      case 'IGJME':
            $city = $this->getVisitorCity($badgeInfo[0]->registration_id);
            $color = "orange"; 
            $participantType = "Visitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "Machinery";
            $participantSecondTitle = "(Trade Visitor)";
            $participantShortTitle = "M";

        
      break;
      case 'INTL':
            $city="";
            $color = "magenta"; 
            $participantType = "International Visitor";
            $agency_category = "";
            $committee= "";
            $participantTitle = "Overseas Visitor";
            $participantSecondTitle = "";
            $participantShortTitle = "OV";
      break;
      case 'EXH':
            $city="";
            $color = "green"; 
            $participantType = "Exhibitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "Exhibitor";
            $participantSecondTitle = "";
            $participantShortTitle = "E";
      break;
      case 'CONTR':
            $city="";
            $participantType = "Agency";
            
            $agency_category = $badgeInfo[0]->agency_category;
            $committee = $badgeInfo[0]->committee;
            $participantSecondTitle = "";
            if($agency_category =="CM"){
              $color = "blue"; 
              if($committee =="C"){
                $participantTitle = "Chairman";
                $participantShortTitle = "C";
              }elseif($committee =="VC"){
                $participantTitle = "Vice-Chairman";
                $participantShortTitle = "VC";
              }elseif($committee =="CO"){
                $participantTitle = "Convener";
                $participantShortTitle = "CO";
              }elseif($committee =="CC"){
                $participantTitle = "Co-Convener";
                $participantShortTitle = "CC";
              }elseif($committee =="CM"){
                $participantTitle = "Committee Member";
                $participantShortTitle = "CM";
              }elseif($committee =="COA"){
                $participantTitle = "Committee Member";
                $participantShortTitle = "COA";
              }
            }elseif($agency_category =="O"){
               $color = "blue"; 
                $participantTitle = "Organizer";
                $participantShortTitle = "O";
            }elseif($agency_category =="OA"){
             $color = "magenta"; 
             $participantTitle = "Official Agency";
                $participantShortTitle = "OA";
            }elseif($agency_category =="G"){
              $color = "magenta"; 
              $participantTitle = "Guest";
              $participantShortTitle = "G";
            }elseif($agency_category =="VV"){
              $color = "magenta"; 
              $participantTitle = "VVIP";
              $participantShortTitle = "VV";
            }elseif($agency_category =="VIP"){
              $color = "magenta"; 
              $participantTitle = "VIP";
              $participantShortTitle = "VIP";
            }elseif($agency_category =="Press"){
              $color = "magenta"; 
               $participantTitle = "Press";
              $participantShortTitle = "P";

            }elseif($agency_category =="Student"){
              $color = "magenta"; 
              $participantTitle = "Student";
              $participantShortTitle = "S";
              
            }


      break;
      default:
            $city="";
            $color  = "grey";
            $participantType = "";
            $agency_category = "";
            $committee = "";
            $participantTitle = "";
            $participantShortTitle = "";
            $participantSecondTitle = "";
      break;
    }

    if($badgeInfo[0]->dose1_status=="Y" || $badgeInfo[0]->dose2_status=="Y" ){
      $color = $color;
      $badgeStatus = "Active";
    }else{
      $color = "grey";
      $badgeStatus = "Inactive";
      
    }
    $covid_status = $badgeInfo[0]->covid_report_status;
    /*=============GENERATE QR CODE================*/
    $qr_status = $this->generate_qr($uniqueId);
    $qr_link = base_url()."global/tmp/qr_codes/".$uniqueId.".png";
    /*=============GENERATE QR CODE================*/

    $data['uniqueId'] = $uniqueId;
    $data['covid_status'] = $covid_status;

    $data['assets_path'] = "https://gjepc.org/iijs-signature/";
    $data['qr_link'] = $qr_link;
    $data['name'] = $badgeInfo[0]->fname." ".$badgeInfo[0]->lname;
    $data['participantType'] = $participantType;
    $data['agency_category'] = $agency_category;
    $data['committee'] = $committee;
    $data['participantTitle'] = strtoupper($participantTitle);
    $data['participantSecondTitle'] = $participantSecondTitle;
    $data['participantShortTitle'] = strtoupper($participantShortTitle);

    $data['color'] = $color;
    $data['badgeStatus'] = $badgeStatus;
    $data['company'] = $badgeInfo[0]->company;
    $data['designation'] = $badgeInfo[0]->designation;
    $data['location'] = "";
    $data['days'] = "18th to 21st February 2022";
    $data['note'] = "Valid for IIJS SIGNATURE 2022 only";
    $data['photo']  = $badgeInfo[0]->photo_url;
    $data['dose1_status']  = $badgeInfo[0]->dose1_status;
    $data['dose2_status']  = $badgeInfo[0]->dose2_status;
    $data['city']  = $city;
    $data['webview'] = $this->getBadgeWebview($uniqueId,"raw");
    $data['webviewLink'] = "https://gjepc.org/gjepc_mobile/badge/getBadgeWebview/".$uniqueId."/preview";
    return $data;
}

 function getBadgeWebviewOld($uniqueId,$type){
  
    $data = array();

    $badgeInfo = $this->Mdl_badge->retrieve("globalExhibition",array("uniqueIdentifier"=>$uniqueId));

     if(isset($badgeInfo) && $badgeInfo !=='NA'){
           if($badgeInfo[0]->status !=="Y"){
        $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"Your Badge is not active",
          "status"=>"false"
          );  
        echo json_encode(array("Response"=>$response));exit;
      }else if($badgeInfo[0]->dose2_status !=="Y"){
        $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"Vaccination is not complete",
          "status"=>"false"
          );  
        echo json_encode(array("Response"=>$response));exit;
      }
    }else{
      $response = array("status"=>"invalid","message"=>"Record not found");
      echo json_encode($response);exit;
    }

 
    switch ($badgeInfo[0]->participant_Type) {
      case 'VIS':
            $city = $this->getVisitorCity($badgeInfo[0]->registration_id);
            $color = "sky_blue"; 
            $participantType = "Visitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "TRADE VISITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "V";
            $class = "text-dark";

      break;
      case 'IGJME':
            $city = $this->getVisitorCity($badgeInfo[0]->registration_id);
            $color = "orange"; 
            $participantType = "Visitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "MACHINERY SHOW VISITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "MV";
            $class = "text-dark";
        
      break;
      case 'INTL':
            $city="";
            $color = "light_blue"; 
            $participantType = "International Visitor";
            $agency_category = "";
            $committee= "";
            $participantTitle = "OVERSEAS VISITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "OV";
            $class = "text-white";

      break;
      case 'EXH':
            $city="";
            $color = "green"; 
            $participantType = "Exhibitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "EXHIBITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "E";
            $class = "text-white";
      break;
      case 'EXHM':
            $city="";
            $color = "green"; 
            $participantType = "Machinery Exhibitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "MACHINERY EXHIBITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "ME";
            $class = "text-white";
      break;
      case 'CONTR':
            $city="";
            $participantType = "Agency";
            $class = "text-dark";
            $agency_category = $badgeInfo[0]->agency_category;
            $committee = $badgeInfo[0]->committee;
            $participantSecondTitle = "";
            if($agency_category =="CM"){
              $color = "blue"; 
              if($committee =="C"){
                $participantTitle = "CHAIRMAN";
                $participantShortTitle = "C";
              }elseif($committee =="VC"){
                $participantTitle = "VICE CHAIRMAN";
                $participantShortTitle = "VC";
              }elseif($committee =="CO"){
                $participantTitle = "CONVENER";
                $participantShortTitle = "CO";
              }elseif($committee =="CC"){
                $participantTitle = "CO-CONVENER";
                $participantShortTitle = "CC";
              }elseif($committee =="CM"){
                $participantTitle = "COMMITTEE MEMBER";
                $participantShortTitle = "CM";
              }elseif($committee =="COA"){
                $participantTitle = "COMMITTEE OF ADMINISTRATION";
                $participantShortTitle = "COA";
              }
              $class = "text-white";
            }elseif($agency_category =="O"){
                $color = "blue"; 
                $participantTitle = "Organizer";
                $participantShortTitle = "O";

            }elseif($agency_category =="OA"){
             $color = "magenta"; 
             $participantTitle = "Official Agency";
              $participantShortTitle = "OA";
            }elseif($agency_category =="G"){
              $color = "grey"; 
              $participantTitle = "GUEST";
              $participantShortTitle = "G";
              $class = "text-dark";
            }elseif($agency_category =="VV"){
              $color = "sky_blue"; 
              $participantTitle = "TRADE VISITOR";
              $participantShortTitle = "VVIP";
              $class = "text-dark";
            }elseif($agency_category =="VIP"){
              $color = "sky_blue"; 
              $participantTitle = "TRADE VISITOR";
              $participantShortTitle = "VIP";
              $class = "text-dark";
            }elseif($agency_category =="P"){
              $color = "white"; 
               $participantTitle = "PRESS";
              $participantShortTitle = "P";
                $class = "text-dark";

            }elseif($agency_category =="S"){
              $color = "s_green"; 
              $participantTitle = "STUDENT";
              $participantShortTitle = "S";
                $class = "text-dark";
              
            }elseif($agency_category =="ED"){
              $color = "grey_blue"; 
              $participantTitle = "Executive Director";
              $participantShortTitle = "ED";
              $class = "text-dark";
              
            }

      break;
      default:
            $city="";
            $color  = "grey";
            $participantType = "";
            $agency_category = "";
            $committee = "";
            $participantTitle = "";
            $participantShortTitle = "";
            $participantSecondTitle = "";
      break;
    }

    if( $badgeInfo[0]->dose2_status=="Y" ){
      $color = $color;
      $badgeStatus = "Active";
    }else{
      $color = "grey";
      $badgeStatus = "Inactive";
      
    }
    $covid_status = $badgeInfo[0]->covid_report_status;
    /*=============GENERATE QR CODE================*/
    $qr_status = $this->generate_qr($uniqueId);
    $qr_link = base_url()."global/tmp/qr_codes/".$uniqueId.".png";
    /*=============GENERATE QR CODE================*/

    $assets_path = "https://gjepc.org/iijs-signature/";
    $name = $badgeInfo[0]->fname." ".$badgeInfo[0]->lname;
    $days = "18th to 21st Feb 2022";
    $note= "Valid for IIJS SIGNATURE 2022 on 06th to 09th January 20220only";
    $dose1_status = $badgeInfo[0]->dose1_status;
    $dose2_status = $badgeInfo[0]->dose2_status;
    if($dose2_status=="Y"){
      $dose1_status = "Y";
    }

    $html ="";
    $html .= '<!DOCTYPE html>
              <html>
                  <head>
                      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover">
                      <link rel="stylesheet" href="'.$assets_path.'assets/css/bootstrap.min.css" />
                      <style>
                          @import url("https://fonts.googleapis.com/css2?family=Montserrat&family=Roboto&display=swap");
                          body {
                              font-family: "Roboto", sans-serif;
                              font-size: 16px;
                          }
                          .top_strip {
                              height: 180px;

                          }
                          .text-white {
                              color:#fff;
                          }
                          .bottom_strip{
                            padding:70px 50px 70px 50px;
                            font-size:32px;

                          } 
                           /*==================GREY COLOR======================*/
                          .white_bg {
                              background: #FFF;
                          }
                          .white_text {
                              color: #000;
                          }
                          /*==================GREY COLOR======================*/
                          .grey_bg {
                              background: #D3D4CE;
                          }
                          .grey_text {
                              color: #bab9b9;
                          }/*=======================================================*/ 
                          /*==================GREEN COLOR======================*/
                          .green_text {
                              color: #19938A;
                          }
                          .green_bg {
                              background: #19938A;
                          } 

                          /*=======================================================*/ 
                          /*==================MAGENTA COLOR======================*/
                          .magenta_bg {
                              background: #90278e;
                          }
                          .magenta_text {
                              color: #90278e;
                          } /*=======================================================*/ 
                          /*==================ORANGE COLOR======================*/
                          .orange_bg {
                              background: #f58220;
                          }
                          .orange_text {
                              color: #f58220;
                          } /*=======================================================*/ 
                          /*==================BLUE COLOR=========================*/
                          .blue_bg {
                              background: #013247;
                          }
                          .blue_text {
                              color: #013247;
                          } /*========================================================*/
                          /*==================PINK COLOR=========================*/
                          .pink_bg {
                              background: #E6C4AB;
                          }
                          .pink_text {
                              color: #cca487;
                          } 
                           /*==================LIGHT BLUE COLOR=========================*/
                          .light_blue_bg {
                              background: #287194;
                          }
                          .light_blue_text {
                              color: #287194;
                          } 
                          /*==================SKY BLUE COLOR=========================*/
                          .sky_blue_bg {
                              background: #BFCDCA;
                          }
                          .sky_blue_text {
                              color: #7ea099
                          }
                           /*==================GREY BLUE COLOR=========================*/
                          .grey_blue_bg {
                              background: #5c746f;
                          }
                          .grey_blue_text {
                              color: #5c746f
                          }
                          /*==================GREY BLUE COLOR=========================*/
                          
                          .s_green_bg {
                              background: #22cba0;
                          }
                          .s_green_text {
                              color: #22cba0;
                          }
                          

                          .content_wrp {
                              width: 100%;
                              max-width: 1000px;
                          }
                          .visitor_pic {
                              overflow: hidden;
                            
                          }
                          .visitor_pic img{
                              width: auto;
                              height: 100%;
                              // object-fit: cover;
                              border-radius:40px;
                              border:1px solid#ccc;
                          }
                          h1 {
                             
                              font-weight: 700;
                              font-family: "Montserrat", sans-serif;
                              line-height: 24px;
                          }
                          
                          h3 {
                             
                              color: #6d6f70;
                              margin-bottom: 15px;
                              line-height: 35px;
                          }
                          p {
                              color: #6d6f70;
                          }
                          '; 
                          if($badgeInfo[0]->participant_Type =="IGJME"){
                            $html .='
                            .middle_strip {
                              text-align: center;
                              padding:15px 10px 15px 10px;
                              color: #000;
                              font-size: 80px;
                              margin:30px 0px 30px 0px;
                          }';
                          }else{
                             $html .='
                             .middle_strip {
                              text-align: center;
                             padding:15px 10px 15px 10px;
                              color: #000;
                              font-size: 80px;
                              margin:10px 0px 50px 0px;
                          }';
                          }
                          $html .='
                          .middle_strip span {
                            font-weight:900;
                            font-size: 170px;
                          }
                          .middle_strip strong {
                            font-weight:300;
                            font-size: 60px;
                          }
                          .title_dark {
                              display: block;
                              font-weight: 900;
                              letter-spacing: 2px;
                              font-size: 14px;
                              color: #000;
                          }
                          .title_name{
                            font-weight: 900;
                            color: #000;
                            font-size:45px;
                            letter-spacing:6px;
                            line-height:30px
                          }
                          .text-small {
                              font-size: 13px;
                          }
                          
                          .text-medium{
                            font-size:34px;
                          }
                          .text-bold{

                            font-weight: 600;
                          }
                      </style>
                  </head>
                  <body>
                      <div class="main_container mb-5">
                          <div class="top_strip '.$color.'_bg"></div>
                           <div class="col-12 mb-4"></div>
                          <div class="container-fluid content_wrp">
                              <div class="row mb-4">
                                  <div class="col-6">
                                      <div class="visitor_pic pt-3" style="height:450px">
                                          <img src="'.$badgeInfo[0]->photo_url.'"  class="img-fluid d-block w-100" alt="" />
                                      </div>
                                  </div>
                                  <div class="col-6">
                                       <div class=" h-100 ">
                                      <img src="'.$qr_link.'"  class="img-fluid d-block w-100" alt="" />
                                  </div>
                                  </div>
                                  <div class="col-12 mb-5"></div>
                                  <div class="col-6">
                                      <span class="mb-4 d-block title_name" style="font-variant:normal;line-height:45px" >'.strtoupper($name).'</span>

                                      <h3 class="mb-4 text-medium" style="line-height:38px">'.ucfirst($badgeInfo[0]->company).'</h3>

                                      <h3 class="mb-4 text-medium" style="">'.$badgeInfo[0]->designation.'</h3>

                                      <h3 class=" mb-4 text-medium" style="">'.$city.'</h3>
                                  </div>
                                  <div class="col-6 " style="padding-left:30px">
                                      <h3 class="text-dark text-medium mb-3" style="font-size:38px">'.$uniqueId.'</h3>
                                      <h3 class="d-table '.$color.'_text mb-4 text-medium" style="font-size:38px;font-weight:700;letter-spacing:3px">Entry to the show</h3>
                                      <h3 class="grey_text text-medium mb-5" style="font-size:38px"><b>'.$days.'</b></h3>
                                      <h3 class="d-table mb-3 '.$color.'_text text-medium mb-0" style="font-size:38px;font-weight:700;letter-spacing:3px">Vaccination status</h3>
                                      <div class="row mb-5">
                                          <div class="col-4">
                                              <img class="img-fluid" src="'.$assets_path.'assets/images/visitor_badges/heart.jpg" />
                                          </div>
                                          <div class="col-8">';
                                              if($dose2_status=="Y"){
                                                $html .='<h3 class="grey_text text-bold text-medium" >Fully </h3>
                                                         <h3 class="grey_text text-bold text-medium" >Vaccinated</h3>';
                                              }
                                              $html .='
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class=" middle_strip '.$color.'_bg '.$class.'">
                              <div style="    padding: 0px;margin: 0px 0px -70px 0px;"><span>'.strtoupper($participantShortTitle).'</span> </div>
                              <strong>'.strtoupper($participantTitle).'</strong> <br />
                              <strong>'.$participantSecondTitle.'</strong>
                          </div>
                          <div class="container-fluid content_wrp">
                            <div class="row mb-5">
                                <div class="col-5">';
                          if($badgeInfo[0]->agency_category =="S"){
                            $html .='<h3 class=" mb-2 text-medium" style="font-size:38px"><b>SHOW HOURS</b></h3>
                                      <h3 class=" mb-1 text-small" style="font-size:28px">21st January, 2022</h3>
                                      <h3 class=" mb-1 text-small" style="font-size:28px">10:00 am to 6:30 pm</h3>';
                          }else{
                            $html .='<h3 class=" mb-2 text-medium" style="font-size:38px"><b>SHOW HOURS</b></h3>
                                      <h3 class=" mb-1 text-small" style="font-size:28px">18th to 20th February, 2022</h3>
                                      <h3 class=" mb-1 text-small" style="font-size:28px">10:00 am to 7.00 pm</h3>
                                      <h3 class=" mb-1 text-small" style="font-size:28px">21st February, 2022</h3>
                                      <h3 class=" mb-1 text-small" style="font-size:28px">10:00 am to 6:30 pm</h3>
                                     ';
                          }
                                    $html .='</div>
                                  <div class="col-7" style="padding-left:30px">
                                      <h3 class="text-medium mb-3" style="font-size:38px;"><b>ENTRY IN TO </b> </h3>
                                      <h3 class="text-medium mb-2" style="font-size:38px;"> <b>EXHIBITION HALLS<b></h3>';
                                      if($badgeInfo[0]->participant_Type =="EXH"){
                                        $html .='<div class="align-self-end">   
                                                      <h3 class=" mb-1 text-small" style="font-size:28px">17th February - 10:00 am to 6:00 pm</h3>
                                                      <h3 class=" mb-1 text-small" style="font-size:28px">18th February - 7:00 am to 8:00 pm</h3>
                                                      <h3 class=" mb-1 text-small" style="font-size:28px">19th - 21st February - 8:00 am to 8:00 pm</h3>
                                                  </div>';
                                      }elseif($badgeInfo[0]->agency_category =="CM" || $badgeInfo[0]->agency_category =="ED"){
                                        $html .='<div class="align-self-end">   
                                                    <h3 class=" mb-1 text-small" style="font-size:28px">Any time during the exhibition</h3>
                                            
                                                  </div>';
                                      }elseif($badgeInfo[0]->agency_category =="S" ){
                                        $html .='<div class="align-self-end  ">   
                                                    <h3 class=" mb-1 text-small  '.$color.'_text" style="font-size:34px ">ONLY ON 21ST FEB 2022 </h3>
                                            
                                                  </div>';
                                      }else{
                                        $html .='<div class="align-self-end">   
                                                    <h3 class=" mb-1 text-small" style="font-size:28px">18th - 20th February - 10:00 am to 6:30 pm</h3>
                                                    <h3 class=" mb-1 text-small" style="font-size:28px">21st February - 10:00 am to 5:30 pm</h3>
                                                  </div>';
                                      }

                          $html .='</div>
                            </div>
                              <h3 class="text-medium text-center mb-4" style="font-size:38px"><b>Toll Free Number: 1800-103-4353</b></h3>
                              <h3 class="text-medium text-center mb-5"  style="font-size:38px"><b>Missed call Number: +91-72080048100</b></h3>
                              <div style="display:none">
                               <p class="text-center '.$color.'_text" style="font-size:30px;font-weight:900;letter-spacing:3px">TWO COVID VACCINE IS MANDATORY</p>
                              <p class="text-center '.$color.'_text" style="font-size:30px;font-weight:900;letter-spacing:3px">TO VISIT THE SHOW</p>
                              <p class=" mb-5 '.$color.'_text text-center" style="font-size:25px">GJEPC reserves the right of entry to IIJS Signature 2022 show. This Entry badge is issued subject to terms & conditions, please refer the same on www.gjepc.org/iijs-signature/, kindly read carefully before entering the show.</p>
                              </div>
                             

                              <div class="row justify-content-center mb-4">
                                  <div class="col-auto mb-3"><img src="'.$assets_path.'assets/images/visitor_badges/grey_icon/01.png" style="height:100px;width:100px" alt="" /></div>
                                  <div class="col-auto mb-3"><img src="'.$assets_path.'assets/images/visitor_badges/grey_icon/02.png" style="height:100px;width:100px" alt="" /></div>
                                  <div class="col-auto mb-3"><img src="'.$assets_path.'assets/images/visitor_badges/grey_icon/03.png" style="height:100px;width:100px" alt="" /></div>
                                  <div class="col-auto mb-3"><img src="'.$assets_path.'assets/images/visitor_badges/grey_icon/04.png" style="height:100px;width:100px" alt="" /></div>
                                  <div class="col-auto mb-3"><img src="'.$assets_path.'assets/images/visitor_badges/grey_icon/05.png" style="height:100px;width:100px" alt="" /></div>
                              </div>
                              <div class="d-table mx-auto w-75  text-center">
                              <img src="'.$assets_path.'assets/images/visitor_badges/logo-signature.jpg?v=1.3" class="img-fluid w-100" alt="" />
                              </div>
                              
                          </div>
                          <div class="mt-5 bottom_strip text-center text-white '.$color.'_bg"></div>
                      </div>
                  </body>
              </html>';

      if($type=="raw"){
        return $html;
      }else{
        echo $html;
      }
        
    }
    function getBadgeWebview($uniqueId,$type){
  
    $data = array();

    $badgeInfo = $this->Mdl_badge->retrieve("globalExhibition",array("uniqueIdentifier"=>$uniqueId));

     if(isset($badgeInfo) && $badgeInfo !=='NA'){
           if($badgeInfo[0]->status !=="Y"){
        $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"Your Badge is not active",
          "status"=>"false"
          );  
        echo json_encode(array("Response"=>$response));exit;
      }else if($badgeInfo[0]->dose2_status !=="Y"){
        $response=array(
          "verified"=>"N",
          "Result"=>"",
          "Message"=>"Vaccination is not complete",
          "status"=>"false"
          );  
        echo json_encode(array("Response"=>$response));exit;
      }
    }else{
      $response = array("status"=>"invalid","message"=>"Record not found");
      echo json_encode($response);exit;
    }

 
    switch ($badgeInfo[0]->participant_Type) {
      case 'VIS':
            $city = $this->getVisitorCity($badgeInfo[0]->registration_id);
            $color = "sky_blue"; 
            $participantType = "Visitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "TRADE VISITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "V";
            $class = "text-dark";

      break;
      case 'IGJME':
            $city = $this->getVisitorCity($badgeInfo[0]->registration_id);
            $color = "orange"; 
            $participantType = "Visitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "MACHINERY SHOW VISITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "MV";
            $class = "text-dark";
        
      break;
      case 'INTL':
            $city="";
            $color = "light_blue"; 
            $participantType = "International Visitor";
            $agency_category = "";
            $committee= "";
            $participantTitle = "OVERSEAS VISITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "OV";
            $class = "text-white";

      break;
      case 'EXH':
            $city="";
            $color = "green"; 
            $participantType = "Exhibitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "EXHIBITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "E";
            $class = "text-white";
      break;
      case 'EXHM':
            $city="";
            $color = "green"; 
            $participantType = "Machinery Exhibitor";
            $agency_category = "";
            $committee = "";
            $participantTitle = "MACHINERY EXHIBITOR";
            $participantSecondTitle = "";
            $participantShortTitle = "ME";
            $class = "text-white";
      break;
      case 'CONTR':
            $city="";
            $participantType = "Agency";
            $class = "text-dark";
            $agency_category = $badgeInfo[0]->agency_category;
            $committee = $badgeInfo[0]->committee;
            $participantSecondTitle = "";
            if($agency_category =="CM"){
              $color = "blue"; 
              if($committee =="C"){
                $participantTitle = "CHAIRMAN";
                $participantShortTitle = "C";
              }elseif($committee =="VC"){
                $participantTitle = "VICE CHAIRMAN";
                $participantShortTitle = "VC";
              }elseif($committee =="CO"){
                $participantTitle = "CONVENER";
                $participantShortTitle = "CO";
              }elseif($committee =="CC"){
                $participantTitle = "CO-CONVENER";
                $participantShortTitle = "CC";
              }elseif($committee =="CM"){
                $participantTitle = "COMMITTEE MEMBER";
                $participantShortTitle = "CM";
              }elseif($committee =="COA"){
                $participantTitle = "COMMITTEE OF ADMINISTRATION";
                $participantShortTitle = "COA";
              }
              $class = "text-white";
            }elseif($agency_category =="O"){
                $color = "blue"; 
                $participantTitle = "Organizer";
                $participantShortTitle = "O";

            }elseif($agency_category =="OA"){
             $color = "magenta"; 
             $participantTitle = "Official Agency";
              $participantShortTitle = "OA";
            }elseif($agency_category =="G"){
              $color = "grey"; 
              $participantTitle = "GUEST";
              $participantShortTitle = "G";
              $class = "text-dark";
            }elseif($agency_category =="VV"){
              $color = "sky_blue"; 
              $participantTitle = "TRADE VISITOR";
              $participantShortTitle = "VVIP";
              $class = "text-dark";
            }elseif($agency_category =="VIP"){
              $color = "sky_blue"; 
              $participantTitle = "TRADE VISITOR";
              $participantShortTitle = "VIP";
              $class = "text-dark";
            }elseif($agency_category =="P"){
              $color = "white"; 
               $participantTitle = "PRESS";
              $participantShortTitle = "P";
                $class = "text-dark";

            }elseif($agency_category =="S"){
              $color = "s_green"; 
              $participantTitle = "STUDENT";
              $participantShortTitle = "S";
                $class = "text-dark";
              
            }elseif($agency_category =="ED"){
              $color = "grey_blue"; 
              $participantTitle = "Executive Director";
              $participantShortTitle = "ED";
              $class = "text-dark";
              
            }

      break;
      default:
            $city="";
            $color  = "grey";
            $participantType = "";
            $agency_category = "";
            $committee = "";
            $participantTitle = "";
            $participantShortTitle = "";
            $participantSecondTitle = "";
      break;
    }

    if( $badgeInfo[0]->dose2_status=="Y" ){
      $color = $color;
      $badgeStatus = "Active";
    }else{
      $color = "grey";
      $badgeStatus = "Inactive";
      
    }
    $covid_status = $badgeInfo[0]->covid_report_status;
    /*=============GENERATE QR CODE================*/
    $qr_status = $this->generate_qr($uniqueId);
    $qr_link = base_url()."global/tmp/qr_codes/".$uniqueId.".png";
    /*=============GENERATE QR CODE================*/

    $assets_path = "https://gjepc.org/iijs-signature/";
    $name = $badgeInfo[0]->fname." ".$badgeInfo[0]->lname;
    $days = "18th to 21st Feb 2022";
    $note= "Valid for IIJS SIGNATURE 2022 on 06th to 09th January 20220only";
    $dose1_status = $badgeInfo[0]->dose1_status;
    $dose2_status = $badgeInfo[0]->dose2_status;
    if($dose2_status=="Y"){
      $dose1_status = "Y";
    }

    $html ="";
    $html .= '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>IIJS SHOW BADGE</title>


</head>
<body>

   <table cellpadding="20" style=" font-size:12px; font-family:Arial, Helvetica, sans-serif; width:100%;">
     <tbody style="vertical-align: top;">
       <tr>
         <td style="width: 50%;border:1px solid #000;">
           <table style="width: 100%;">
             <tbody>
    
               <tr>
                 <td colspan="2" style="text-align: center;"><img src="<?php echo base_url();?>assets/web/images/badges/Untitled-11.jpg" style="width: 150px;margin-bottom: 15px;"></td>
                 
               </tr>
                <tr>
                 
                 <td colspan="2" style="text-align: center;"><img src="https://gjepc.org/iijs-premiere/assets/images/iijs_logo.png" style="width: 150px;margin-bottom: 15px;"></td>
               </tr>
               <tr>
                 <td style="">  <div style="" >
            <img src="<?php echo base_url();?>assets/web/images/dummy-user.png" style="width: 110px;height: auto;   border-radius: 12px; border: 1px solid #ccc;">
            <!-- <img src="<?php // echo base_url();?>images/<?php // echo $photo; ?>" style="width: 105px;height: auto;"> -->
            
          </div></td>
                 <td>
                   <div style="/* height: 120px; *//* text-align: center; */" class="img_container border">
            <img src="<?php echo $qr_code; ?>" style="width: 110px;height: auto;">
          </div></td>
               </tr>
                <tr><td colspan="2" style="/* text-align: center; */"><p style="font-size: 22px;font-weight: 700;margin-bottom: 0px;"><?php echo $name; ?></p></td></tr>
                <tr><td colspan="2" style="/* text-align: center; */"><p style="margin: 0px;font-size: 18px;"><?php echo $company; ?></p></td></tr>
                <tr><td colspan="2" style="/* text-align: center; */"><p style="margin: 0;font-size: 13px;"><?php echo $designation; ?></p></td></tr>
                <tr><td colspan="2">
                  <div style="/* width:100%; */background: <?php echo $color;?>;text-align: center;padding: 20px;margin-top: 20px;margin-top: 62px;">
        <span style="font-size:20px;font-weight: 700;color: #fff;/* padding: 44px; */"><?php echo $categoryDesc;?></span>
      </div>
     
                </td></tr>
              

              
             </tbody>
           </table>
         </td>


         <td style="width: 50%;border:1px solid #000;">
           <table style="width: 100%;">
             <tbody>
         
              <tr><td colspan="2"><p style="margin-top: 0px;margin-bottom: 05px;font-size: 18px;font-weight: 400;">The show timings are as below:</p></td></tr>
              <tr><td colspan="2"><p style="margin-top: 0px;margin-bottom: 05px;font-size: 14px;">4th August 2022 – 9am – 5:30pm</p></td></tr>
              <tr><td colspan="2"><p style="margin-top: 0px;margin-bottom: 05px;font-size: 14px;">5th August 2022 – 9am – 5:30pm</p></td></tr>
              <tr><td colspan="2"><p style="margin-top: 0px;margin-bottom: 05px;font-size: 14px;">6th August 2022 – 9am – 5:30pm</p></td></tr>
              <tr><td colspan="2"><p style="margin-top: 0px;margin-bottom: 05px;font-size: 14px;">7th August 2022 – 9am – 5:30pm</p></td></tr>
              <tr><td colspan="2"><p style="margin-top: 0px;margin-bottom: 05px;font-size: 14px;">8th August 2022 – 9am – 5:30pm</p></td></tr>

              <tr><td colspan="2"><h3 style="font-weight: bold; color:#c08833;font-size: 20px;">IIJS PREMIERE 2022</h3></td></tr>
              <tr style="border-top: 3px solid #c08833;width: 100%;border-bottom: 3px solid #c08833;padding: 10px 0px;">
                <td  ><p>Associates Partners</p> <img src="<?php echo base_url();?>assets/web/images/badges/gemifields.jpg"  />
                </td>
                <td  ><p>Freight Forwarder</p><img src="<?php echo base_url();?>assets/web/images/badges/sequal.jpg" />
                </td>

              </tr>
              
              <tr >
                <td colspan="2">
                   <p style="font-size: 12px;text-align: justify;width: 100%;"><?php echo $description; ?> </p>
                </td>
              </tr>
             </tbody>
           </table>
         </td>


         
       </tr>
       <tr>
         <td style="border:1px solid #000;width: 50%;position:relative; z-index: 1;overflow:hidden;">
          <div class="bg_dots1"></div>
           <table style="width:100%;position: relative;z-index: 3;">
             <tbody style="text-align: center;">
               <tr>
                 <td colspan="2">
                    <div style=" height: 70px; width: 100%;display: flex; justify-content: center;align-items: center;">
                    <h3 style="text-align: center;color: #c08833;font-weight: 700;font-size: 20px;">BLOCK THE DATES</h3>
                    </div>
                 </td>

               </tr>
               <tr>

                 <td style="text-align:left;">  <h2>IIJS PREMIERE 2022</h2><div style="display:block;"><small>4th - 8th August, Bombay exhibition centre, Mumbai </small></div></td>
                <!--  <td> <img src="<?php echo base_url();?>assets/web/images/badges/Untitled-9.jpg" style="width: 80px"></td> -->
                 <td> <img src="<?php echo base_url();?>assets/web/images/badges/Untitled-8.jpg" style="width: 50px"></td>
               </tr>
                <tr>
                 <td style="text-align:left;">  <h2>IIJS SIGNATURE 2023</h2><div style="display:block;"><small>5th - 8th January 2023, Bombay exhibition centre, Mumbai </small></div></td>
                 <!-- <td> <img src="<?php echo base_url();?>assets/web/images/badges/Untitled-9.jpg" style="width: 80px"></td> -->
                 <td> <img src="<?php echo base_url();?>assets/web/images/badges/Untitled-7.jpg" style="width: 50px"></td>
               </tr>
                <tr>
                   <td style="text-align:left;">  <h2>IIJS TRITIYA 2023</h2><div style="display:block;"><small>17th - 20th March 2023, Bangalore international  exhibition centre, Bangalore </small></div></td>
               <!--   <td> <img src="<?php echo base_url();?>assets/web/images/badges/Untitled-9.jpg" style="width: 80px"></td> -->
                 <td> <img src="<?php echo base_url();?>assets/web/images/badges/Untitled-6.jpg" style="width: 50px"></td>
               </tr>
             </tbody>
           </table>
         <div class="bg_dots2"></div>
        <div style="clear:both"></div>

         </td>
         <td style="width: 50%;border:1px solid #000;">
           <table style="width: 100%; ">
             <tbody style="width: 100%;">
               <tr style="width: 100%;">
                 <td style="float: left;">
                    <h4 style="margin-top: 20px;font-size: 14px;">www.gjepc.org</h4>
                   
                  </td>
                 <td style="float: right;"> <img src="<?php echo base_url();?>assets/web/images/badges/logo.png" style="width: 120px;"></td>
                 
               </tr>
               <tr style="width: 100%;">
                 <td colspan="2" style="text-align: center;"> <img src="<?php echo base_url();?>assets/web/images/badges/Untitled-3.jpg" style="width: 300px;"></td>
               </tr>
               <tr>
                 <td colspan="2"><h2 style="font-size: 26px;text-align: center;">
            IF IT CAN’T BE <br>
            MADE ANYWHERE,<br>
            IT CAN BE MADE<br>
            IN INDIA.
          </h2></td>
               </tr>
               <tr>
                 <td colspan="2" style="text-align: center;">  <img src="<?php echo base_url();?>assets/web/images/badges/Untitled-4.jpg" style="width: 300px;"></td>
               </tr>
               <tr>
                 <td colspan="2">
                     <h4 style="margin-bottom: 15px;text-align:center;">INDIA.</h4>
        <h5 style="padding:0;font-size: 10px;text-align: center;">THE WORLD’S GEM &amp; JEWELLERY DESTINATION.</h5>
        <h5 style="padding:0; font-size:10px;text-align:center">The Gem &amp; Jewellery Export Promotion Council</h5>
        <p style="padding:0; font-size:10px;text-align:center">Sponsored by the Ministry of Commerce &amp; Industry</p>
        <h4 style="margin-bottom:20px;text-align:center;"><span style="padding-right: 5px; font-size: 13px;"><img src="<?php echo base_url();?>assets/web/images/badges/twitter-sign.png" width="15px" style="margin-right:5px;" />GJEPCindia</span><span style="padding-right: 5px; font-size: 13px;"><img src="<?php echo base_url();?>assets/web/images/badges/instagram.png" width="15px" style="margin-right:5px;" />GJEPCindia</span><span style=" font-size: 13px;"><img src="<?php echo base_url();?>assets/web/images/badges/facebook.png" width="15px" style="margin-right:5px;" />GJEPCindia</span></h4>
                 </td>
               </tr>

             </tbody>
           </table>
         </td>
       </tr>
     </tbody>
      

    </table>

 
</body>
</html>';

      if($type=="raw"){
        return $html;
      }else{
        echo $html;
      }
        
    }

 function getBadgeDetails(){
  $json = file_get_contents('php://input');
  $obj = json_decode($json,True);
  $uniqueId = trim($obj['uniqueId']);
  if($uniqueId !=""){

   $isExist = $this->Mdl_badge->isExist("globalExhibition",array("uniqueIdentifier"=>$uniqueId));
  if($isExist ===TRUE){
    $response=array(
          "Result"=>$this->preview($uniqueId),
          "Message"=>"",
          "status"=>"true"
          ); 
  }else{
     $response=array(
          "Result"=>"deleted",
          "Message"=>"Visitor not Found",
          "status"=>"false"
          ); 

  }
  }else{
    $response=array(
          "Result"=>"",
          "Message"=>"Unique Id Missing",
          "status"=>"false"
          );  
  }
  

  header('Content-type: application/json');
  echo json_encode(array("Response"=>$response));
 }


function getBadgeLayout($data){

$html ="";
$html .= '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>IIJS SIGNATURE 2022 e-Badges</title>
   
   
  </head>
  <body>
    <div class="main_container mb-5">
      <div class="mb-3 top_strip '.$data['color'].'"></div>
        <div class="container-fluid content_wrp">
          <div class="row mb-4">
            <div class="col-6">
              <div class="mb-3 visitor_pic"><img src="" class="img-fluid d-block" /></div> 
              <h1 class="text-uppercase">'.strtoupper($data['name']).'</h1>
              <h3 class="mb-2">'.strtoupper($data['company']).'</h3>
              <h3>'.$data['designation'].'</h3>
              <h3>'.$data['location'].'</h3>
            </div>
            <div class="col-6">
              <img src="assets/images/visitor_badges/scan.jpg" class="img-fluid d-block" />
              <h3>'.$data['uniqueId'].'</h3>
              <p class="d-table text-center mb-0" style="color:#000;">'.$data['participantType'].'</p>
              <h3>Badge Status:
              '.$data['badgeStatus'].'</h3>
              <h3>Entry to the show <br>
              '.$data['days'].'</h3>
              </div>
            </div>
            <div class="grey_bg customer_care mb-4">
              <strong>CUSTOMER CARE: +91.22.2652 4791/2/3/4</strong>
            </div>
            <h2 class="text-center mb-4" style="color: #8E8F90;">No entry without mask</h2>
            <p class="mb-4">GJEPC reserves the right of entry to IIJS. This entry badge is issued subject to terms and conditions as enclosed. Please read them carefully before entering to the show.</p>
            <div class="row justify-content-center mb-4">
            <div class="col-auto mb-3">
              <img src="assets/images/visitor_badges/grey_icon/01.png" />
            </div>
            <div class="col-auto mb-3">
              <img src="assets/images/visitor_badges/grey_icon/02.png"" />
            </div>
            <div class="col-auto mb-3">
              <img src="assets/images/visitor_badges/grey_icon/03.png"" />
            </div>
            <div class="col-auto mb-3">
              <img src="assets/images/visitor_badges/grey_icon/04.png" />
            </div>
            <div class="col-auto mb-3">
              <img src="assets/images/visitor_badges/grey_icon/05.png" />
            </div>
            </div>
            <img src="assets/images/visitor_badges/grey_icon/gjepc-signature.png" class="img-fluid d-table mx-auto" />
        <div class="mt-5 bottom_strip text-center text-white grey_bg">
          <strong>Valid for IIJS Signature 2022 on '.$data['days'].' only</strong>
        </div>
      </div>
      </div> 
  </body>
</html>';
return $html;
}


  
function getallowedDays($company_name){
    $company_name = trim($company_name);
    $company_first_letter = $company_name[0];
    if(!is_numeric($company_first_letter)){
       $alphabet = strtoupper($company_first_letter);
    }else{
       $alphabet = "NA";
    }
    $getSlot = $this->Mdl_badge->searchFunction("visitor_slot_master",array("alphabets"=>$alphabet),array("status"=>"1"),"both");
    if($getSlot !=="NA"){
      $slot = explode(",",$getSlot[0]->dates);
    }else{
        $slot = "";
    }
    $firstDate =  date("d",strtotime($this->Mdl_badge->getName("visitor_event_date_master",$slot[0],"date")));
    $secondDate =  date("d",strtotime($this->Mdl_badge->getName("visitor_event_date_master",$slot[1],"date")));
    $monthYear = date("F Y",strtotime($this->Mdl_badge->getName("visitor_event_date_master",$slot[0],"date")));
  
    return $this->ordinal($firstDate)." & ".$this->ordinal($secondDate)." ".$monthYear;
}

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13)){
        return $number. 'th';
    }
    else{
        return $number. $ends[$number % 10];
    }
}

function send_otp($message,$number) {
  $message=str_replace(" ","%20",$message);
  $url = 'http://sms.gjepc.org/submitsms.jsp?user=TheGem&key=f2474d18afXX&mobile='.$number.'&message='.$message.'&senderid=GJECPT&accusage=1';
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function test_otp() {
  $message = "One Time Password for Visitor Verification is 4569 , Regards GJEPC";
  $number ="9834797281,9619662253";
  $message=str_replace(" ","%20",$message);
  $url = 'http://sms.gjepc.org/submitsms.jsp?user=TheGem&key=f2474d18afXX&mobile='.$number.'&message='.$message.'&senderid=GJECPT&accusage=1';
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    print_r($data);
    curl_close($ch);
   
}

function emailContent($to,$visName,$message){
    $content ='
      <table width="800px" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
          <tr>
          <td style="padding:30px;">  
            <table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
            <tr>
              <td align="left"> <img src="https://gjepc.org/images/gjepc_logon.png"/> </td>
              <td align="right"> <img src="https://gjepc.org/iijs-signature/assets/images/logo.png"/> </td>
            </tr>
            <tr>
            <td align="right" colspan="3" height="30px"><hr /></td>
            </tr>
            <tr>
            <td align="right" colspan="3" height="10px"></td>
            </tr>
            <tr>
            <td colspan="3" style="font-size:13px; line-height:22px;">
             <p> Dear '.$visName.',</p>
             <p>'.$message.'</p>
            <p>Warm Regards,</br>
            IIJS SIGNATURE 2022 SHOW Web Team</p>
            </td>
            </tr>
            <tr>
            <td colspan="4" align="right" ><hr /></td>
            </tr>
          </table>
          </td>
        </tr> 
      </table>';  
    $subject = "IIJS SIGNATURE 2022 - E-mail Id Verification"; 
    $headers  = 'MIME-Version: 1.0' . "\n"; 
    $headers .= 'Content-type: text/html; charset=iso-8859-1'. "\n"; 
    $headers .='From: IIJS SIGNATURE 2022 <admin@gjepc.org>';      
    $sent =  mail($to, $subject, $content, $headers); 
   
}

 function generate_qr($uniqueId)
    {
    $data = array();

    $badgeInfo = $this->Mdl_badge->retrieve("globalExhibition",array("uniqueIdentifier"=>$uniqueId));

    if(isset($badgeInfo) && $badgeInfo !=='NA'){

    }else{
      $response = array("status"=>"invalid","message"=>"Record not found");
      echo json_encode($response);exit;
    }
    
    switch ($badgeInfo[0]->participant_Type) {
      case 'VIS':
            $category = "V";
      break;
      case 'IGJME':
            $category = "M";
      break;
      case 'INTL':
           $category = "OV";
      break;
      case 'EXH':
           $category = "E";
      break;
      case 'CONTR':
            $agency_category = $badgeInfo[0]->agency_category;
            $committee = $badgeInfo[0]->committee;

            if($agency_category =="CM"){
              $category = $committee;
            }else{
               $category = $agency_category;
            }
      break;
      default:
           $category="";
      break;
    }

   
  
    $name = $badgeInfo[0]->fname." ".$badgeInfo[0]->lname;
    $company = $badgeInfo[0]->company;
    $designation = $badgeInfo[0]->designation;
 


    $qr_code_config = array();
    $qr_code_config['cacheable'] = $this->config->item('cacheable');
    $qr_code_config['cachedir'] = $this->config->item('cachedir');
    $qr_code_config['imagedir'] = $this->config->item('imagedir');
    $qr_code_config['errorlog'] = $this->config->item('errorlog');
    $qr_code_config['ciqrcodelib'] = $this->config->item('ciqrcodelib');
    $qr_code_config['quality'] = $this->config->item('quality');
    $qr_code_config['size'] = $this->config->item('size');
    $qr_code_config['black'] = $this->config->item('black');
    $qr_code_config['white'] = $this->config->item('white');
    $this->ci_qr_code->initialize($qr_code_config);
    $image_name = $uniqueId . ".png";
    // create user content


    $codeContents = "";
    $codeContents .= trim($uniqueId);
    $codeContents .= " | ";
  
    $codeContents .= trim($category);
    $codeContents .= " | ";

    $codeContents .= trim($name);
    $codeContents .= " | ";
   
    $codeContents .= trim($company);
    $codeContents .= " | ";
  
    $codeContents .= trim($designation);
    $codeContents .= " | ";
    
    
    $params['data'] = $codeContents;
    $params['level'] = 'H';
    $params['size'] = 2;

    $params['savename'] = FCPATH . $qr_code_config['imagedir'] . $image_name;
    $this->ci_qr_code->generate($params);

    //$this->data['qr_code_image_url'] = base_url() . $qr_code_config['imagedir'] . $image_name;

    
    $file = $params['savename'];

    return $file;

      
    }

    function getVisitorCity($registration_id){

    $data = $this->Mdl_badge->retrieve("registration_master",array("id"=>$registration_id));

    if($data !="NA"){
        $city = $data[0]->city;
      }else{
        $city = "";
      }
      return $city;
    }
    function send_mailArray($to, $subject, $message,$cc)
      { 
        $account="donotreply@gjepcindia.com";
        $password="Gjepc@786";
        $from="donotreply@gjepcindia.com";
        $from_name="GJEPC INDIA";
        $cc="";
        include("phpmailer/class.phpmailer.php");
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = "smtp.office365.com";;
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
        foreach($to as $email_to){ $mail->addAddress($email_to); }
        if($cc!=''){ $mail->AddCC($cc); }   
        if(!$mail->send()){
         //return false;
        } else {
         //return true;
        }
      }



}