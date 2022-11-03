<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class BadgeTest extends MX_Controller
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


   
    $codeContents .= $uniqueId;
    $codeContents .= "|";
  
    $codeContents .= $category;
    $codeContents .= "|";

    $codeContents .= $name;
    $codeContents .= "|";
   
    $codeContents .= $company;
    $codeContents .= "|";
  
    $codeContents .= $designation;
    
    
    
    $params['data'] = $codeContents;
    $params['level'] = 'H';
    $params['size'] = 2;

    $params['savename'] = FCPATH . $qr_code_config['imagedir'] . $image_name;
    $this->ci_qr_code->generate($params);

    $this->data['qr_code_image_url'] = base_url() . $qr_code_config['imagedir'] . $image_name;

    
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

    function getBadgeWebview($uniqueId){
  
    $data = array();

    $badgeInfo = $this->Mdl_badge->retrieve("globalExhibition",array("uniqueIdentifier"=>$uniqueId));

     if(isset($badgeInfo) && $badgeInfo !=='NA'){

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

    $assets_path = "https://gjepc.org/iijs-signature/";
    $name = $badgeInfo[0]->fname." ".$badgeInfo[0]->lname;
    $days = "15th to 19th September 2021";
    $note= "Valid for IIJS Premiere 2021 only";


    $html ="";
    $html .= '<!DOCTYPE html>
              <html>
                <head>
                  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
                 
                  <link rel="stylesheet" href="'.$assets_path.'assets/css/bootstrap.min.css">
                  
                  <style>
                    @import url("https://fonts.googleapis.com/css2?family=Montserrat&family=Roboto&display=swap");
                    body {font-family: "Roboto", sans-serif; font-size: 16px;}
                    .top_strip {height: 50px;}
                    /*================== GREY COLOR ======================*/
                    .grey_bg {background:#cacaca;}
                    .grey_text {color: #cacaca;}
                      /*=======================================================*/
                    /*================== GREEN COLOR ======================*/
                      .green_text {color: #00b2a5;}
                    .green_bg {background: #00b2a5;}
                    /*=======================================================*/
                    /*================== MAGENTA COLOR ======================*/
                    .magenta_bg {background: #90278e;}
                    .magenta_text {color: #90278e;}
                    /*=======================================================*/
                    /*================== ORANGE COLOR ======================*/
                    .orange_bg {background:  #f58220;}
                    .orange_text {color: #f58220;}
                    /*=======================================================*/
                      /*================== BLUE COLOR =========================*/
                    .blue_bg{background: #172b75;}
                    .blue_text{color: #172b75;}
                    /*========================================================*/
                    .content_wrp {width: 100%; max-width: 1000px;}
                    .visitor_pic {overflow: hidden; border-radius: 15px;}
                    h1 {font-size: 18px; font-weight: 700; font-family: "Montserrat", sans-serif; line-height: 24px;}
                    h2 {font-size: 25px;}
                    h3 {font-size: 18px; color:#6d6f70; margin-bottom: 15px; line-height: 25px;}
                    p {color: #6D6F70}
                    .middle_strip {text-align: center;  padding: 15px; color: #000;font-size: 18px;}
                    .title_dark{display: block; font-weight: 900; letter-spacing: 2px;font-size: 14px;color: #000;}
                    .text-small{font-size: 13px;}
                    .text-medium{font-size: 15px;}
                  </style>
                </head>
                <body>
                  <div class="main_container mb-5">
                    <div class="mb-3 top_strip '.$color.'_bg"></div>
                    
                    <div class="container-fluid content_wrp">
                      
                      <div class="row mb-4">
                        
                       
                        <div class="col-6">
                        <div class=" visitor_pic"><img src="'.$badgeInfo[0]->photo_url.'" style="max-width:100%;max-height:150px" class="img-fluid d-block" alt="">
                        </div>
                        
                      </div>
                      <div class="col-6">
                        <img src="'.$qr_link.'" style="max-width:100%;max-height:100%" class="img-fluid d-block w-100" alt="">
                      </div>
                      <div class="col-12 mb-3"></div>


                        <div class="col-6">
                          
                          <h3 class=" mb-2 title_dark">'.$name.'</h3>
                          <h3 class="mb-2 text-small" >'.$badgeInfo[0]->company.'</h3>
                          <h3 class="text-small">'.$badgeInfo[0]->designation.'</h3>
                          <h3 class="text-small">'.$city.'</h3>
                        </div>
                        <div class="col-6">
                          <h3 class="text-dark text-medium mb-1">'.$uniqueId.'</h3>
                          <h3 class="d-table '.$color.'_text mb-1 text-medium">Entry to the show</h3>
                          <h3 class="text-dark text-medium mb-3"><b>'.$days.'</b></h3>
                          <h3 class="d-table '.$color.'_text text-medium mb-0">Vaccination status</h3>
                          <div class="row">
                            <div class="col-6">
                              <p class="text-medium mb-1">Dose 1</p>
                            
                             <img src="'.$assets_path.'assets/images/checked.png">
                            </div>
                            <div class="col-6">
                              <p class="text-medium mb-1">Dose 2</p>
                              <img src="'.$assets_path.'assets/images/checked.png">
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      
                    </div>
                    <div class="mb-4 middle_strip '.$color.'_bg">
                      <strong>'.strtoupper($participantShortTitle).'</strong>
                      <br>
                      <strong>'.strtoupper($participantTitle).'</strong>
                      <br>
                      <strong>'.$participantSecondTitle.'</strong>
                    </div>
                    <div class="container-fluid content_wrp">
                      <h3 class="text-medium text-center mb-0"><b>Toll Free Number: 1800-103-4353</b></h3>
                      <h3 class="text-medium text-center"> <b>Missed call Number: +91-72080048100</b></h3>
                      <h3 class="text-center mb-4 '.$color.'_text">No entry without mask</h3>
                      <p class="mb-4 '.$color.'_text text-center">GJEPC reserves the right of entry to IIJS. This entry badge is issued subject to terms and conditions as enclosed. Please read them carefully before entering to the show.</p>
                      <div class="row justify-content-center mb-4">
                        
                        <div class="col-auto mb-3">
                          <img src="'.$assets_path.'assets/images/visitor_badges/red_icon/01.png" alt="">
                        </div>
                        <div class="col-auto mb-3">
                          <img src="'.$assets_path.'assets/images/visitor_badges/red_icon/02.png" alt="">
                        </div>
                        <div class="col-auto mb-3">
                          <img src="'.$assets_path.'assets/images/visitor_badges/red_icon/03.png" alt="">
                        </div>
                        <div class="col-auto mb-3">
                          <img src="'.$assets_path.'assets/images/visitor_badges/red_icon/04.png" alt="">
                        </div>
                        <div class="col-auto mb-3">
                          <img src="'.$assets_path.'assets/images/visitor_badges/red_icon/05.png" alt="">
                        </div>
                      </div>
                      <img src="https://gjepc.org/iijs-premiere/assets/images/badge-logos.png" class="img-fluid d-table mx-auto" alt="">
                    </div>
                    <div class="mt-5 p-3 text-center text-white '.$color.'_bg"><strong>Valid for IIJS PREMIERE 2021 on 15th to 19th September only</strong>
                    </div>
                    
                  </div>
                  
                </body>
              </html>';
    echo $html;
     
       
    }


}