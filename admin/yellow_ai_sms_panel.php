`<?php
session_start();
if(!isset($_SESSION['curruser_contact_name'])){ header('Location: index.php'); exit; }
if(!isset($_SESSION['curruser_login_id'])){ header("location:index.php"); exit; }
include('../whatsapp-functions.php');
include('../db.inc.php');

function getWhatsappTemplateId($id,$conn)
{
  $query_sel = "SELECT templateId FROM  whatsapp_templates_master  where id='$id'"; 
  $result = $conn->query($query_sel);
  $row = $result->fetch_assoc();    
  return $row['templateId'];
}

$adminID = intval(filter($_SESSION['curruser_login_id']));

function str_replace_variable($from, $to, $content)
{
$from = '/'.preg_quote($from, '/').'/';
return preg_replace($from, $to, $content,1);
}

function resetFields(){
  $_SESSION['main_category']="";
  $_SESSION['parichay_company_type']="";
  $_SESSION['parychay_contact_type']="";
  $_SESSION['visitor_approval']="";
  $_SESSION['category']="";
  $_SESSION['visited_show']="";
  $_SESSION['designation']="";
  $_SESSION['state']="";
  $_SESSION['firm_type']="";
  $_SESSION['member_type']="";
  $_SESSION['company_name']="";
  $_SESSION['vendor']="";
  $_SESSION['m_member_type']="";
  $_SESSION['member_status']="";
  $_SESSION['member_region']="";
  $_SESSION['member_person_type']="";
  $_SESSION['exh_region']="";
  $_SESSION['exh_show']="";
  $_SESSION['document_status']="";
  $_SESSION['last_yr_participant']="";
  $_SESSION['msg_type']="";
  $_SESSION['msg_title']="";
  $_SESSION['msg_variable']="";
  $_SESSION['msg_description']="";
  $_SESSION['custom_numbers']="";
  $_SESSION['test_variable']="";
  $_SESSION['test_number']="";
  $_SESSION['msg_dept']="";
  $_SESSION['msg_templates']="";
  $_SESSION['m_membership_type']="";
  $_SESSION['m_panel_name']="";
}

if($_REQUEST['action']=="Reset")
{
$_SESSION['main_category']="";
$_SESSION['parichay_company_type']="";
$_SESSION['parychay_contact_type']="";
$_SESSION['visitor_approval']="";
$_SESSION['category']="";
$_SESSION['visited_show']="";
$_SESSION['designation']="";
$_SESSION['state']="";
$_SESSION['firm_type']="";
$_SESSION['member_type']="";
$_SESSION['company_name']="";
$_SESSION['vendor']="";
$_SESSION['m_member_type']="";
$_SESSION['member_status']="";
$_SESSION['member_region']="";
$_SESSION['member_person_type']="";
$_SESSION['exh_region']="";
$_SESSION['exh_show']="";
$_SESSION['document_status']="";
$_SESSION['last_yr_participant']="";
$_SESSION['msg_type']="";
$_SESSION['msg_title']="";
$_SESSION['msg_variable']="";
$_SESSION['msg_description']="";
$_SESSION['custom_numbers']="";
$_SESSION['test_variable']="";
$_SESSION['test_number']="";
$_SESSION['msg_dept']="";
$_SESSION['msg_templates']="";
$_SESSION['m_membership_type']="";
 $_SESSION['m_panel_name']="";

header("Location: yellow_ai_sms_panel.php?action=panel");
}
if (isset($_POST["action"]) && $_POST["action"]=="send_messsage") {
 // echo "<pre>";print_r($_POST);exit;
  $_SESSION['main_category']  = $_REQUEST['main_category'];
  $_SESSION['parichay_company_type']  =  $_REQUEST['parichay_company_type'];
  $_SESSION['parychay_contact_type']  =  $_REQUEST['parychay_contact_type'];
  $_SESSION['visitor_approval']  =  $_REQUEST['visitor_approval'];
  $_SESSION['category']=filter($_REQUEST['category']);
  $_SESSION['visited_show']=filter($_REQUEST['visited_show']);
  $_SESSION['designation']=$_REQUEST['designation'];
  $_SESSION['state']=filter($_REQUEST['state']);
  $_SESSION['firm_type']=$_REQUEST['firm_type'];
  $_SESSION['member_type']=$_REQUEST['member_type'];
  $_SESSION['company_name']=filter($_REQUEST['company_name']);
  $_SESSION['vendor']=filter($_REQUEST['vendor']);
  $_SESSION['m_member_type']=$_REQUEST['m_member_type'];
  $_SESSION['m_membership_type']=$_REQUEST['membership_type'];
  $_SESSION['member_status']=$_REQUEST['member_status'];
  $_SESSION['member_region']=$_REQUEST['member_region'];
  $_SESSION['member_person_type']=$_REQUEST['member_person_type'];
  $_SESSION['m_panel_name']=$_REQUEST['panel_name'];
  $_SESSION['exh_region']=$_REQUEST['exh_region'];
  $_SESSION['exh_show']=$_REQUEST['exh_show'];
  $_SESSION['document_status']=$_REQUEST['document_status'];
  $_SESSION['last_yr_participant']=$_REQUEST['last_yr_participant'];

  $_SESSION['msg_dept']=$_REQUEST['msg_dept'];
  $_SESSION['msg_type']=$_REQUEST['msg_type'];
  $_SESSION['msg_templates']=$_REQUEST['msg_templates'];
  $_SESSION['msg_title']=$_REQUEST['msg_title'];
  $_SESSION['msg_variable']=$_REQUEST['msg_variable'];
  $_SESSION['msg_description']=$_REQUEST['msg_description'];
  $_SESSION['custom_numbers']=$_REQUEST['custom_numbers'];
  $_SESSION['test_variable']=$_REQUEST['test_variable'];
  $_SESSION['test_number']=$_REQUEST['test_number'];
  $_SESSION['msg_dept']=$_REQUEST['msg_dept'];
  $msg_type = filter($_POST['msg_type']);
  $msg_title = filter($_POST['msg_title']);
  $msg_description = filter($_POST['msg_description']);
  $msg_variable = filter($_POST['msg_variable']);
  $msg_templates = filter($_POST['msg_templates']);
  $msg_attatchment = filter($_POST['msg_attatchment']);
 

  if($_REQUEST['main_category'] ==""){
    $errorMsg = "Select Contact Category";
  }else if($_SESSION['msg_dept'] ==""){
    $errorMsg = "Select Department";
  }else if($_SESSION['msg_type'] ==""){
    $errorMsg = "Select Message Media Type";
  }
  // else if($_SESSION['msg_templates'] ==""){
  //   $errorMsg = "Select Template";
  // }
  // else if($_SESSION['msg_description'] ==""){
  //   $errorMsg = "Select Template";
  // }
  else{

    // $image = '';
    // $target_folder = 'whatsappAttatchments/';
    // $path_parts = "";
    // $ext="";
    // $target_path = "";
    // $filetoupload="";
    // $temp_code = rand();
    // $name = $_FILES['msg_attatchment']['name'];
    // $name = str_replace(" ","_",$name);
    // $temp_name = $_FILES['msg_attatchment']['tmp_name'];
    // $isUploaded = "";
    // if(preg_match("/.php/i", $name)) {
    //   $errorMsg = "Invalid File";
    // }else if($name !=''){

    //   if(($_FILES["msg_attatchment"]["type"] == "image/jpeg") || ($_FILES["msg_attatchment"]["type"] == "image/jpg") || ($_FILES["msg_attatchment"]["type"] == "image/png") || ($_FILES["msg_attatchment"]["type"] == "application/pdf") || ($_FILES["msg_attatchment"]["type"] == "video/mp4") || ($_FILES["msg_attatchment"]["type"] == "video/mpeg") || ($_FILES["msg_attatchment"]["type"] == "application/zip") || ($_FILES["msg_attatchment"]["type"] == "application/msword")  || ($_FILES["msg_attatchment"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")){
    //     $target_path = $target_folder.$temp_code.'_'.$name;
    //     $ans = $_FILES['msg_attatchment']['tmp_name'];
    //     if(move_uploaded_file($temp_name,$target_path))
    //     {
           
    //        $file = $temp_code.'_'.$name;
    //       $isUploaded = "1";
    //   }else{
    //     $errorMsg = $_FILES['msg_attatchment']['error'];
    //     $isUploaded = "0";
    //   }
    //   }else{
    //     $errorMsg = "Invalid File ";
    //   }

    // }else{
    //   if($msg_type !="TEXT"){
    //     $errorMsg = "Attatchment is Required ";
    //   }else{
    //     $isUploaded = "1";
    //     $file = "";
    //   }
    // }
    $templateId = trim(getWhatsappTemplateId($msg_templates,$conn));
     /*SAVE MESSAGE RECORD*/
    $save_message = "INSERT INTO whatsapp_messages_history  SET `department`='".$_SESSION["msg_dept"]."',`template_id`='$templateId',`category`='".$_SESSION["main_category"]."',`media_type`='$msg_type',`title`='$msg_title',`description`='$msg_description',`attatchment`='$msg_attatchment',`adminId`='$adminID'"; 
    $conn->query($save_message);
    $insertId = $conn->insert_id;
    $isUploaded ="1";
    if($isUploaded == "1"){

    if($_SESSION["main_category"]=="custom_numbers"){
     $custom_numbersArr  = json_decode($_SESSION['custom_numbers']);
    // $_SESSION["custom_numbers"] = implode(glue, pieces)
    $messageCount = count($custom_numbersArr);
    if(count($custom_numbersArr) >0){
    foreach ($custom_numbersArr as $cust) {
    $insertCust = "INSERT INTO whatsapp_temp_data SET `template_id`='$msg_templates',`person`= '',`company`='',`mobile`='$cust->value',`variable_name`='',`type`='$msg_type',`title`='$msg_title',`description`='$msg_description',`attatchment`='$msg_attatchment',`platform`='Y'";
    $resCust = $conn->query($insertCust);
    }

    $conn->query("UPDATE whatsapp_messages_history SET `count`='$messageCount' WHERE `id`='$insertId' ");
    resetFields();
    }
    $successMsg = "Message has been sent successfully.";

    }else if($_SESSION["main_category"]=="import_csv"){
      $templateId = trim(getWhatsappTemplateId($msg_templates,$conn));
      $csv_filename=$_FILES["import_csv"]["tmp_name"]; 
      $messageCount = $_FILES["import_csv"]["size"];
      if($_FILES["import_csv"]["size"] > 0)
     {
        $file_csv = fopen($csv_filename, "r");
        $counter_csv = 1;
          while (($getData = fgetcsv($file_csv)))
           {

            if($counter_csv !=1){
            $person_name="";
            $company_name="";
            $name = $getData[0];
            $mobile = $getData[1];
            $variable = $_POST['variable'];
            if($msg_variable !=="none"){
                $variable[0] = $name;
            }
            $variable = serialize($variable);

            $name="";
           
            $sql_import = "INSERT INTO whatsapp_temp_data SET  `template_id`='$templateId', `person`= '$person_name',`company`='$company_name',`mobile`='$mobile',`variable_name`='$variable',`type`='$msg_type',`title`='$msg_title',`description`='$msg_description',`attatchment`='$msg_attatchment',`platform`='Y'";
            $result_import = $conn->query($sql_import);
            $msg_description ="";
            
        if(!isset($result_import))
        {
           $errorMsg = "Invalid File ";
        }
        else {
           $successMsg = "Message has been sent successfully.";
        }
}
$counter_csv ++;

           }
      
           fclose($csv_filename);  
     }
    if($insertId !=""){
      $conn->query("UPDATE whatsapp_messages_history SET `count`='$messageCount' WHERE `id`='$insertId' ");
    }
    resetFields();
    
    $successMsg = "Message has been sent successfully.";

    }else if($_SESSION["main_category"]=="test_template"){

      $templateId = trim(getWhatsappTemplateId($msg_templates,$conn));
      $test_number = trim($_SESSION["test_number"]);
      $test_variable = $_SESSION["test_variable"];
      if($msg_attatchment !=""){
        $attatchment = $msg_attatchment;
      }else{
         $attatchment = "";
      }
      $userDetails = array("number"=>$test_number);
      $notification = array();
      if($msg_type =="TEXT"){
        $param = $_POST['variable'];
      }else{
        $param =array("media"=>array("mediaLink"=>$attatchment,"title"=>$msg_title));
        $variable_arr = json_decode( json_encode($_POST['variable']),JSON_FORCE_OBJECT);
        foreach($variable_arr as $variable_array){
          $param[] = $variable_array;
        }
      }
      array_unshift($param,"");
      unset($param[0]);

      $notification = array(
          "templateId"=>trim($templateId),
          "params"=>$param,
          "type"=>"whatsapp",
          "sender"=>"919619500999",
          "language"=>"en",
          "namespace"=>"f6d069b8_cb39_4d42_a8e1_045b5ea5d255"
      );
      $payload = array( "userDetails" => $userDetails ,"notification" => $notification );
      //echo "<pre>";print_r($payload);exit;
      $boat_id = "x1652181273571";
       $send_messagae = sendMsg($payload,$boat_id);
       $response = json_decode($send_messagae);
       $response->msgId;
       if($response->msgId !=""){
        resetFields();
          echo $successMsg = "Template is ok. Message has been sent successfully.";exit;
       }else{
        if($response->message !=""){
          echo $errorMsg = $response->message;
        }else{
         echo  $errorMsg = "Template is not ok. something is missing";exit;
        }
       
       }
      //header("url=yellow_ai_sms_panel.php;refresh: 5");exit();




    }else{
    switch ($_SESSION['main_category']){
    case 'visitors':
    $sql="SELECT  distinct (vd.mobile),rm.company_name as company,vd.name
    from visitor_directory vd 
    left join visitor_order_history oh on vd.visitor_id=oh.visitor_id  
    join registration_master rm on vd.registration_id=rm.id where 1 AND vd.whatsapp_verified='1'";
    if($_SESSION['category']!=""){
    if($_SESSION['category']=="visitor"){
    $sql.=" ";
    } else {
    $sql.=" and vd.category ='".$_SESSION['category']."'";
    }
    }
    if($_SESSION['visited_show']!="")
    {
      $arr_string = explode("-",$_SESSION['visited_show']);
      $show = $arr_string[0];
      $year = $arr_string[1];
      $sql.=" and oh.`show` ='".$show."' AND oh.year='".$year."'";
    }
    // if($_SESSION['designation']!="")
    // {
    // $sql.=" and (";
    // $counterDegn = 1;
    // foreach ($_SESSION['designation'] as $degnVal) {
    // if($counterDegn =="1"){
    // $sql.=" vd.`designation` ='".$degnVal."'";
    // }else{
    // $sql.=" or vd.`designation` ='".$degnVal."'";
    // }

    // $counterDegn ++;
    // }
    // $sql.=")";

    // }
    if($_SESSION['state']!="" && $_SESSION['state']!="All")
    {
    $sql.=" and rm.state ='".$_SESSION['state']."'";
    }

    if($_SESSION['firm_type']!="")
    {
    $sql.=" and rm.company_type ='".$_SESSION['firm_type']."'";
    }
    if($_SESSION['company_name']!="")
    {
    $sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
    }
    if($_SESSION['visitor_approval']!="")
    {
    if($_SESSION['visitor_approval']=='Y')
    {
    $sql.=" and vd.visitor_approval='Y' ";
    } else if($_SESSION['visitor_approval']=='P')
    {
    $sql.=" and vd.visitor_approval='P' ";
    } else {
    $sql.=" and vd.visitor_approval='D' ";
    }
    }
    $attach=" order by oh.create_date asc ";
    $sql.= "  ".$attach." ";
    break;
    case 'vendors':
    $sql = " SELECT company_name as company, contact_name as name, contact_number as mobile FROM vendor_registration WHERE status='1' ";
    $attach=" order by created_at desc";
    $sql.= "  ".$attach." ";
    break;

    case 'parichay':
    $type = filter($_POST['parichay_company_type']);
    $parychay_contact_type = filter($_POST['parychay_contact_type']);
    if($parychay_contact_type !="company_person"){
    $sql ="SELECT rm.company_name as company,";
    if($parychay_contact_type =="association_head_mobile_no1"){
    $sql.= "pk.association_head_name as name, pk.association_head_mobile_no1 as mobile ";
    }else if($parychay_contact_type =="authorised_mobile1"){
    $sql.= "pk.authorised_person as name, pk.authorised_mobile1 as mobile ";
    }else{
    $sql.= "pk.association_head_name as name, pk.association_head_mobile_no1 as mobile ";
    }
    $sql.="from parichay_card pk
    inner join registration_master rm on pk.registration_id=rm.id where 1";

    }else{
    $sql ="SELECT distinct (pk.mobile1 ) as mobile,rm.company_name as company,pk.fname as name ";
    $sql.="from parichay_person_details pk left join registration_master rm on pk.registration_id=rm.id where 1";
    }
    if($type !=""){
    $sql.=" and rm.parichay_type='$type' ";
    }
    $attach=" order by rm.post_date desc";
    $sql.= "  ".$attach." ";
    break;
    case 'solitaire':
   
    $sql ="SELECT distinct (c.mobile_no ) as mobile, i.company_name as company,c.name FROM `approval_master` a,`type_of_comaddress_master` b, `information_master` i ,`communication_address_master` c WHERE c.type_of_address = b.id and c.`registration_id`=i.`registration_id` AND c.`registration_id`=a.`registration_id` AND c.type_of_address='7' AND c.mobile_no!='' AND c.mobile_no!=0 AND c.name!='' GROUP BY c.mobile_no order by i.company_name ";

    break;
    case 'member':

    $lastFinancialYear = 2020;
    $nextFinancialYear = $lastFinancialYear +1;

    $sql = "SELECT distinct (c.mobile_no ) as mobile ,i.company_name as company,c.name FROM `approval_master` a,`type_of_comaddress_master` b, `information_master` i ,`communication_address_master` c, `challan_master` d,
      `communication_details_master` e WHERE c.type_of_address = b.id and c.`registration_id`=i.`registration_id` AND c.`registration_id`=a.`registration_id` and d.`registration_id`=c.`registration_id` and a.`registration_id`=e.`registration_id` and d.`challan_financial_year`='2022' and d.`Response_Code`='E000' and a.issue_membership_certificate_expire_status='Y'  AND c.mobile_no!='' AND c.mobile_no!=0 AND c.name!='' AND c.whatsapp_verified='1' ";

    if($_SESSION['member_region']!="")
    {
    $sql.=" and (";
    $counterMemRegion = 1;
    foreach ($_SESSION['member_region'] as $memRegionVal) {
    if($counterMemRegion =="1"){
    $sql.="  i.region_id='".$memRegionVal."' ";
    }else{
    $sql.=" or i.region_id='".$memRegionVal."' ";
    }


    $counterMemRegion ++;
    }
    $sql.=")";
    }

    if($_SESSION['m_member_type']!="")
    {

    $sql.=" and (";
    $countMemberType = 1;
    foreach ($_SESSION['m_member_type'] as $m_member_type) {
    if($countMemberType =="1"){
    $sql.=" b.member_type_id='".$m_member_type."' ";
    }else{
    $sql.=" or b.member_type_id='".$m_member_type."' ";
    }

    $countMemberType ++;
    }
    $sql.=")";
    }

    if($_SESSION['m_panel_name'] !=="" && !empty($_SESSION['m_panel_name'])){
      $m_panel_name = $_SESSION['m_panel_name'];
      $sql.=" and e.panel_name = '$m_panel_name' " ;
    }

    if($_SESSION['m_membership_type']!="")
    {
    $sql.=" and (";
    $countMemberShipType = 1;
    foreach ($_SESSION['m_membership_type'] as $m_membership_type) {
    if($countMemberShipType =="1"){
    $sql.=" a.membership_certificate_type='".$m_membership_type."' ";
    }else{
    $sql.=" or a.membership_certificate_type='".$m_membership_type."' ";
    }

    $countMemberShipType ++;
    }
    $sql.=")";
    }


    if($_SESSION['member_person_type']!="")
    {

    $sql.=" and (";
    $countMemberPersonType = 1;
    foreach ($_SESSION['member_person_type'] as $member_person_type) {
    if($countMemberPersonType =="1"){
    $sql.="  c.type_of_address='".$member_person_type."' ";
    }else{
    $sql.=" and c.type_of_address='".$member_person_type."' ";
    }

    $countMemberPersonType ++;
    }
    $sql.=") ";
    }
      $sql .=" GROUP BY c.mobile_no order by i.company_name ";

    break;
    
    case 'exhibitors':

    $sql="select distinct (a.mobile),a.company_name as company,a.contact_person as name from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid where 1 ";
    if($_SESSION['exh_show']!=''){
    $sql.="and a.event_for='".$_SESSION['exh_show']."'";
    }
    if($_SESSION['exh_region']!=''){
    $exh_region_count = 1;
    $sql.="or (";
    foreach ($_SESSION['exh_region'] as $exh_region) {
    if($exh_region_count =="1"){
    $sql.=" a.region='".$exh_region."'";
    }else{
    $sql.="and a.region='".$exh_region."'";
    }
    $exh_region_count++;
    }
    $sql.=")";
    }


    if($_SESSION['document_status']!="")
    {
    if($_SESSION['document_status']=='approved')
    {
    $sql.=" and document_status='approved' ";
    }else if($_SESSION['document_status']=='pending')
    {
    $sql.=" and document_status='pending' ";
    }else{
    $sql.=" and document_status='rejected' ";
    }
    $document_status_count = 1;
    $sql.="or (";
    foreach ($_SESSION['document_status'] as $document_status) {
    if($document_status_count =="1"){
    $sql.="  document_status='".$document_status."' ";
    }else{
    $sql.=" and document_status='".$document_status."' ";
    }
    $document_status_count++;
    }
    $sql.=")";
    }
    if($_SESSION["last_yr_participant"]!="")
    {
    $last_yr_pt = $_SESSION["last_yr_participant"];
    $sql.=" and last_yr_participant='$last_yr_pt'";
    }
    
    break;
    default:
    $sql = "";
    break;
    }
 
    $result = $conn ->query($sql);
    $rCount =  $result->num_rows;
    $messageCount = $rCount;
    if($rCount>0){
      while($rows = $result->fetch_assoc())
      {
      $name = $rows['name'];
      $company = $rows['company'];
      $mobile = $rows['mobile'];
      $msg_description = filter($_POST['msg_description']);
      // if($msg_variable !=="none"){
      //   if($msg_variable =="person"){
      //     $name_tr =str_replace(" ","%20",$rows['name']);
      //     $msg_description = str_replace_variable("VARIABLE",trim($name_tr),$msg_description);
      //   }else{
      //     $name_tr =str_replace(" ","%20",$rows['company']);
      //     $msg_description = str_replace_variable("VARIABLE",trim($name_tr),$msg_description);
      //   }
      // }else{
      //   $msg_description = $msg_description;
      // }
      $variable = $_POST['variable'];
            if($msg_variable !=="none"){
              if($msg_variable =="person"){
                // $name_tr =str_replace(" ","%20",$rows['name']);
                // $msg_description = str_replace_variable("VARIABLE",trim($name_tr),$name);
                $variable[0] = $rows['name'];
              }else{
                $variable[0] = $rows['company'];
                // $name_tr =str_replace(" ","%20",$rows['company']);
                // $msg_description = str_replace_variable("VARIABLE",trim($name_tr),$msg_description);
              }
                
            }


      $variable = serialize($variable);
       // print_r($variable);exit;  
        $templateId = trim(getWhatsappTemplateId($msg_templates,$conn));
       $insert = "INSERT INTO whatsapp_temp_data SET `template_id`='$templateId ',`person`= '$name',`company`='$company',`mobile`='$mobile',`variable_name` = '$variable',`type`='$msg_type',`title`='$msg_title',`description`='$msg_description',`attatchment`='$msg_attatchment',`platform`='Y'";
      $res = $conn->query($insert);
      $msg_description ="";
      }
      if($insertId !=""){
        $conn->query("UPDATE whatsapp_messages_history SET `count`='$messageCount' WHERE `id`='$insertId' ");
      }
      resetFields();
      $successMsg ="Message has been sent successfully ";
    }else{
      $errorMsg = "No contacts Found please check and try again.";
    }
    }
  }
}
}



//echo $sql;



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Manage Registered Member List ||GJEPC||</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <!--navigation-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />

    <link rel="stylesheet" href="css/tagify.css">
    <link rel="stylesheet" href="https://unpkg.com/@yaireo/dragsort/dist/dragsort.css" media="print" onload="this.media='all'">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
    <script type="text/javascript" src="js/ddsmoothmenu.js"></script>
    <script src="js/jQuery.tagify.min.js"></script>
    <script src="https://unpkg.com/@yaireo/dragsort"></script>
    <script type="text/javascript">
    ddsmoothmenu.init({
      mainmenuid: "smoothmenu1", //menu DIV id
      orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
      classname: 'ddsmoothmenu', //class added to menu's outer DIV
      //customtheme: ["#1c5a80", "#18374a"],
      contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
    })
    </script>
    <script>
    function getRadioVal(form, name) {
    var val;
    // get list of radio buttons with specified name
    var radios = form.elements[name];
    
    // loop through list of radio buttons
    for (var i=0, len=radios.length; i<len; i++) {
    if ( radios[i].checked ) { // radio checked?
    val = radios[i].value; // if so, hold its value in val
    break; // and break out of for loop
    }
    }
    return val; // return value of checked radio or undefined if none checked
    }
    function checkdata()
    {
       if (confirm("Confirm all details before sending ")) {
         //var main_category = document.getElementsByName('main_category').value ;
    var main_category = getRadioVal( document.getElementById('form1'), 'main_category' );
    
    if(main_category =="visitors"){
    // if(document.getElementById('category').value == ''){
    // alert("Please Select Visitor Category");
    // document.getElementById('category').focus();
    // return false;
    // }
    // if(document.getElementById('visited_show').value == ''){
    // alert("Please Select Show");
    // document.getElementById('visited_show').focus();
    // return false;
    // }
    }else if(main_category =="exhibitors"){
    if(document.getElementById('exh_show').value == ''){
    alert("Please Select Show");
    document.getElementById('exh_show').focus();
    return false;
    }
    }else if(main_category =="parichay"){
    if(document.getElementById('parichay_company_type').value == ''){
    alert("Please Select Company type");
    document.getElementById('parichay_company_type').focus();
    return false;
    }
    var parychay_contact_type = getRadioVal( document.getElementById('form1'), 'parychay_contact_type' );
    if(typeof parychay_contact_type =="undefined"){
    alert("Please Select Contact type");
    return false;
    }
    }else if(typeof main_category =="undefined"){
    alert("Please Select  Category");
    return false;
    }
       }else{
        return false;

       }
   
    
    }

  $(document).ready(function(){
    var maxField = 20; //Input fields increment limitation
    var addButton = $('.addMore'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
   
    var x = 0; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append('<div><input type="text" class="input_txt" name="variable[]"  > <a class="remove_button btn">Remove Variable</a> </div>'); 
            //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


   $('#msg_variable').on("change", function(e){
    e.preventDefault();
    let main_category = $('input[name="main_category"]:checked').val();
   // alert(main_category);

    let val = $(this).val();
    if(val !=="none"){
       if(main_category =="test_template"){
          let test_person_name = $("#test_variable").val();
          $("#variable0").val(test_person_name).attr("readonly",false);
       }else{
          $("#variable0").val(val+" name").attr("readonly",true);
       }
    }else{
        $("#variable0").val("").attr("readonly",false);
    }

   });

  });
    </script>
    <!--navigation end-->
  </head>
  <body>
    <div id="header_wrapper"><?php include("include/header.php");?></div>
    <div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
    <div class="clear"></div>
    <div id="main">
      <div class="content">
        <div class="content_head">Manage Whatsapp Message sending Panel  </div>
        <?php
          if($successMsg!=""){
          echo "<div class='content_details1'> <span class='notification n-success'>".$successMsg."</span></div>";
          $successMsg="";
          }

          if($errorMsg!=""){
          echo "<span class='notification n-error'>".$errorMsg."</span>";
          $errorMsg="";
          }
        ?>
       
        <div class="content_details1">        
          <a href="manage_templates.php?action=view" style="display: inline-block;margin-bottom: 10px"><div class="content_head_button">Add Templates</div> </a>
         
          <form method="POST" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data" autocomplete="off">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" class="orange1"> Select Contact Category</td>
        </tr>
              <tr class="<?php if($_SESSION['main_category']=='visitors'){echo "orange1";}?>">
                <td colspan="2" class=""> <label><input type="radio" name="main_category" class="main_category" data-classname='visitor' <?php if($_SESSION['main_category']=='visitors'){echo "checked";}?> value="visitors"   /> &nbsp; Visitors </label>
              </td>
            </tr>
            <tr class="visitor blocks" >
              <td><strong>Category</strong></td>
              <td>
                <select name="category" id="category" class="input_txt">
                  <option value="">Select Category</option>
                  <option value="VIP" <?php if($_SESSION['category']=='VIP'){echo "selected";}?>>VIP</option>
                  <option value="VVIP" <?php if($_SESSION['category']=='VVIP'){echo "selected";}?>>VVIP</option>
                  <option value="Elite" <?php if($_SESSION['category']=='Elite'){echo "selected";}?>>ELITE</option>
                  <option value="visitor" <?php if($_SESSION['category']=='visitor'){echo "selected";}?>>Registered Visitors</option>
                </select>
              </td>
            </tr>
            <tr class="visitor blocks">
              <td><strong>Show Visited </strong></td>
              <td>
                <select name="visited_show" id="visited_show" class="input_txt">
                  <option value="">Select Show</option>
                  <option value="iijs-2019" <?php if($_SESSION['visited_show']=='iijs-2019'){echo "selected";}?>>IIJS 2019</option>
                  <!--<option value="signature-2019" <?php if($_SESSION['visited_show']=='signature-2019'){echo "selected";}?>>SIGNATURE 2019</option>-->
                  <option value="vbsm-2020" <?php if($_SESSION['visited_show']=='vbsm-2020'){echo "selected";}?>>IIJS Virtual 2020</option>
                  <option value="vbsm2-2021" <?php if($_SESSION['visited_show']=='vbsm2-2021'){echo "selected";}?>>IIJS Virtual 2021</option>
                  <option value="signature2-2021" <?php if($_SESSION['visited_show']=='signature2-2021'){echo "selected";}?>>IIJS SIGNATURE 2021</option>
                  <option value="iijs21-2021" <?php if($_SESSION['visited_show']=='iijs21-2021'){echo "selected";}?>>IIJS PREMIERE 2021</option>
                  <option value="signature22-2022" <?php if($_SESSION['visited_show']=='signature22-2022'){echo "selected";}?>>IIJS SIGNATURE 2022</option>
                  <option value="iijs22-2022" <?php if($_SESSION['visited_show']=='iijs-2022'){echo "selected";}?>>IIJS PREMIERE 2022</option>
                  <option value="signature23-2023" <?php if($_SESSION['visited_show']=='signature23-2023'){echo "selected";}?>>IIJS SIGNATURE 2023</option>
                </select>
              </td>
            </tr>
            <tr class="visitor blocks">
              <td><strong>Designation</strong></td>
              <td>
                <label><input type="checkbox" name="designation[]" value="19" <?php if(in_array("19", $_SESSION['designation'])){echo "checked";}?> >&nbsp;Partners&nbsp;&nbsp;</label>
                <label><input type="checkbox" name="designation[]" value="18" <?php if(in_array("18", $_SESSION['designation'])){echo "checked";}?> >&nbsp;Properitor&nbsp;&nbsp;</label>
                <label><input type="checkbox" name="designation[]" value="23" <?php if(in_array("23", $_SESSION['designation'])){echo "checked";}?> >&nbsp;CEO&nbsp;&nbsp;</label>
                <label><input type="checkbox" name="designation[]" value="26" <?php if(in_array("26", $_SESSION['designation'])){echo "checked";}?> >&nbsp;MD&nbsp;&nbsp;</label>
                <label><input type="checkbox" name="designation[]" value="20" <?php if(in_array("20", $_SESSION['designation'])){echo "checked";}?> >&nbsp;Director&nbsp;&nbsp;</label>
                <label><input type="checkbox" name="designation[]" value="21" <?php if(in_array("21", $_SESSION['designation'])){echo "checked";}?> >&nbsp;Chairman&nbsp;&nbsp;</label>
              </td>
              
            </tr>
            <tr class="visitor blocks">
              <td><strong>State</strong></td>
              <td>
                <select name="state" id="state" class="input_txt">
                  <option value="">All States</option>
                  <?php
                  $query = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
                  while($result= $query->fetch_assoc()){ ?>
                  <option value="<?php echo $result['state_code'];?>"  <?php if($result['state_code']==$state){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr class="visitor blocks">
              <td width="19%"><strong>Company Name</strong></td>
              <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" autocomplete="off"/></td>
            </tr>
            <tr class="<?php if($_SESSION['main_category']=='exhibitors'){echo "orange1";}?>">
              <td colspan="2" class=""><label><input type="radio" name="main_category" class="main_category" value="exhibitors" data-classname='exhibitors' <?php if($_SESSION['main_category']=='exhibitors'){echo "checked";}?>  /> &nbsp; Exhibitors</label>   </td>
            </tr>
            
            <tr class="exhibitors blocks">
              <td><b>Region</b></td>
              <td>
                <!--   <select name="exh_region" class="input_txt" >
                  <option value="">All Regions</option> -->
                  <?php $region_query = "select * from region_master";
                  $execute_region = $conn->query($region_query);
                  while($show_region = $execute_region->fetch_assoc())
                  {
                  ?>
                  <label><input type="checkbox" name="exh_region[]" value="<?php echo $show_region["region_name"]; ?>" <?php if(in_array($show_region["region_name"], $_SESSION['exh_region'])){echo "checked";}?> >&nbsp;<?php echo $show_region["region_name"]; ?>&nbsp;&nbsp;</label>
                  <!-- <option value="<?php echo $show_region["region_name"]; ?>" <?php if($_SESSION["exh_region"]==$show_region["region_name"]) echo "selected"; ?>><?php echo $show_region["region_name"]; ?></option> -->
                  <?php }
                  ?>
                  <!--  </select> -->
                </td>
              </tr>
              <tr class="exhibitors blocks">
                <td valign="top" class="content_txt">Show</td>
                <td>
                  <select class="input_txt" name="exh_show" id="exh_show" >
                    <option value="">----Select Show----</option>
                    <option value="IIJS Signature 2020" <?php if($_SESSION["exh_show"]=="IIJS Signature 2020") echo "selected"; ?>>IIJS Signature 2020</option>
                    <option value="IIJS 2020" <?php if($_SESSION["exh_show"]=="IIJS 2020") echo "selected"; ?>>IIJS 2020</option>
                    <option value="IIJS Signature 2021" <?php if($_SESSION["exh_show"]=="IIJS Signature 2021") echo "selected"; ?>>IIJS Signature 2021</option>
                    <option value="IIJS PREMIERE 2022" <?php if($_SESSION["exh_show"]=="IIJS PREMIERE 2022") echo "selected"; ?>>IIJS PREMIERE 2022</option>
                  </select>
                </td>
              </tr>
              <tr class="exhibitors blocks">
                <td><strong>Application Status</strong></td>
                <td>
                <input type="checkbox" name="document_status[]" value="approved" <?php if(in_array("approved", $_SESSION['document_status'])){echo "checked";}?> >&nbsp;Application Approved&nbsp;&nbsp;</label>
              <input type="checkbox" name="document_status[]" value="rejected" <?php if(in_array("rejected", $_SESSION['document_status'])){echo "checked";}?> >&nbsp;Application Pending&nbsp;&nbsp;</label>
            <input type="checkbox" name="document_status[]" value="pending" <?php if(in_array("pending", $_SESSION['document_status'])){echo "checked";}?> >&nbsp;Application Rejected&nbsp;&nbsp;</label>
          </td>
        </tr>
        
        <tr class="<?php if($_SESSION['main_category']=='vendors'){echo "orange1";}?>">
          <td colspan="2" class=""> <label><input type="radio" name="main_category" class="main_category" value="vendors" data-classname='vendors' <?php if($_SESSION['main_category']=='vendors'){echo "checked";}?>/> &nbsp; Vendors </label> </td>
        </tr>
        <tr class="vendors blocks">
          <td valign="top" class="text_content">All registered Vendors</td>
          <td class="text_content">
            
            <label> <input type="checkbox" name="vendor" value="YES"  <?php if($_SESSION['vendor']=='YES'){echo "checked";}?>   /> Yes&nbsp;</label>
          </td>
        </tr>
        <tr  class="<?php if($_SESSION['main_category']=='parichay'){echo "orange1";}?>" >
          <td colspan="2" class=""> <label><input type="radio" name="main_category" class="main_category" value="parichay" data-classname='parichay'  <?php if($_SESSION['main_category']=='parichay'){echo "checked";}?>   /> &nbsp; Parichay Card </label> </td>
        </tr>
        
        <tr class="parichay blocks">
          <td valign="top" class="content_txt">Company Type</td>
          <td> 
		  <select class="input_txt" name="parichay_company_type" id="parichay_company_type" >
            <option value="" >Select </option>
            <option value="M"  <?php if($_SESSION['parichay_company_type']=='M'){echo "selected";}?>>Member Company</option>
            <option value="association" <?php if($_SESSION['parichay_company_type']=='association'){echo "selected";}?>>Association</option>            
          </select>
		  </td>
        </tr>
        <tr class="parichay blocks">
          <td valign="top" class="content_txt">Contact Types</td>
          <td>
            <label><input type="radio" name="parychay_contact_type" value="association_head_mobile_no1"  <?php if($_SESSION['parychay_contact_type']=='association_head_mobile_no1'){echo "checked";}?>  /> &nbsp; Association head</label><br>
            
            <label><input type="radio" name="parychay_contact_type" value="authorised_mobile1" <?php if($_SESSION['parychay_contact_type']=='authorised_mobile1'){echo "checked";}?>  /> &nbsp; Authorised Person  </label><br>
            <label><input type="radio" name="parychay_contact_type" value="company_person" <?php if($_SESSION['parychay_contact_type']=='company_person'){echo "checked";}?>  /> &nbsp; Company Preson  </label><br>
            
          </td>
        </tr>
         <tr  class="<?php if($_SESSION['main_category']=='parichay'){echo "orange1";}?>" >
          <td colspan="2" class=""> <label><input type="radio" name="main_category" class="main_category" value="solitaire" data-classname='solitaire'  <?php if($_SESSION['main_category']=='solitaire'){echo "checked";}?>   /> &nbsp; Solitaire </label> </td>
        </tr>
        <tr class="<?php if($_SESSION['main_category']=='member'){echo "orange1";}?>" >
          <td colspan="2" class=""> <label><input type="radio" name="main_category" class="main_category" value="member" data-classname='member'  <?php if($_SESSION['main_category']=='member'){echo "checked";}?>   /> &nbsp; Member </label> </td>
        </tr>
        
        <tr class="member blocks">
          <td valign="top" class="content_txt">Region </td>
          <td>
            <?php $regionMaster = $conn->query("SELECT * FROM region_master WHERE `status` = '1'");
            while ($rowRegion = $regionMaster->fetch_assoc()) { ?>
            
            <label><input type="checkbox" name="member_region[]" value="<?php echo $rowRegion["region_name"]; ?>" <?php if(in_array($rowRegion["region_name"], $_SESSION['member_region'])){echo "checked";}?> >&nbsp;<?php echo $rowRegion["region_name"]; ?>&nbsp;&nbsp;</label>
            
            <?php  }  ?>
            
          </td>
        </tr>
        <tr class="member blocks">
          <td><strong>Member Type</strong></td>
          <td>
            <?php
            $sqlMemType="select * from member_type_master where status=1";
            $resultMemType =  $conn ->query($sqlMemType);
            while($rowsMemType = $resultMemType->fetch_assoc())
            {
            if($_SESSION['m_member_type']==$rowsMemType['member_type_name'])
            { ?>
            <label><input type="checkbox" name="m_member_type[]" value="<?php echo $rowsMemType["sap_value"]; ?>" <?php if(in_array($rowsMemType["sap_value"], $_SESSION['m_member_type'])){echo "checked";}?> >&nbsp;<?php echo $rowsMemType["member_type_name"]; ?>&nbsp;&nbsp;</label>
            <?php }else
            { ?>
            
            <label><input type="checkbox" name="m_member_type[]" value="<?php echo $rowsMemType["sap_value"]; ?>" <?php if(in_array($rowsMemType["sap_value"], $_SESSION['m_member_type'])){echo "checked";}?> >&nbsp;<?php echo $rowsMemType["member_type_name"]; ?>&nbsp;&nbsp;</label>
            <?php }
            }
            ?>
          </td>
        </tr>
        <tr class="member blocks">
          <td valign="top" class="content_txt">Person Type </td>
          <td>
            <?php $commMaster = $conn->query("SELECT * FROM type_of_comaddress_master WHERE  address_identity='CTP' AND `status` = '1'");
            while ($commRow = $commMaster->fetch_assoc()) { ?>
            
            <label><input type="checkbox" name="member_person_type[]" value="<?php echo $commRow["id"]; ?>" <?php if(in_array($commRow["id"], $_SESSION['member_person_type'])){echo "checked";}?> >&nbsp;<?php echo $commRow["type_of_comaddress_name"]; ?>&nbsp;&nbsp;</label>            
            <?php  }  ?>            
          </td>
        </tr>
        <tr class="member blocks">
          <td valign="top" class="content_txt">Membership Type </td>
          <td>
            <label>
              <input type="checkbox" name="membership_type[]" value="ZASSOC"  >&nbsp;<?php echo "Associate"; ?>&nbsp;&nbsp;
              <input type="checkbox" name="membership_type[]" value="ZORDIN"  >&nbsp;<?php echo "Ordinary"; ?>&nbsp;&nbsp;
            </label>
          </td>
        </tr>
         <tr class="member blocks">
          <td valign="top" class="content_txt">Membership panel </td>
          <td>
           <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
    <tr class="orange1">
    <td colspan="14" >Panel</td>
    </tr>   
    <tr>
    <td colspan="8"><strong class="text6">Panel Details: <span class="star">*</span><span id="panel_msg" class="star"></span></strong></td>
    </tr> 
    <tr>
    <td colspan="2" align="center"> 
  <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Coloured Gemstones" <?php if($_SESSION['m_panel_name'] =='Coloured Gemstones'){echo "checked='checked'";}?>/>
    </div>
  </td>
    <td width="46%"><span class="text6 ">Coloured Gemstones</span></td>
    <td colspan="2" align="center"> 
  <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Pearls" <?php if($_SESSION['m_panel_name'] =='Pearls'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Pearls</span></td>
    </tr>
    
    <tr bgcolor="#CCCCCC">
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Costume/Fashion Jewellery" <?php if($_SESSION['m_panel_name'] =='Costume/Fashion Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Costume/Fashion Jewellery</span></td>
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Sales To Foreign Tourists" <?php if($_SESSION['m_panel_name'] =='Sales To Foreign Tourists'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Sales To Foreign Tourists</span></td>
    </tr>
    
    <tr>
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Diamonds" <?php if($_SESSION['m_panel_name'] =='Diamonds'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Diamonds</span></td>
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Synthetic Stones" <?php if($_SESSION['m_panel_name'] =='Synthetic Stones'){echo "checked='checked'";}?> />
    </div></td>
    <td width="46%"><span class="text6 ">Synthetic Stones</span></td>
    </tr>
    
    <tr bgcolor="#CCCCCC">
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Gold Jewellery" <?php if($_SESSION['m_panel_name'] =='Gold Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Gold Jewellery</span></td>
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Not Indicated" <?php if($_SESSION['m_panel_name'] =='Not Indicated'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Not Indicated</span></td>
    </tr>
    
    <tr>
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="Other Precious Metal Jewellery" <?php if($_SESSION['m_panel_name'] =='Other Precious Metal Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Other Precious Metal Jewellery</span></td>
    
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Silver Jewellery" <?php if($_SESSION['m_panel_name'] =='Silver Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Silver Jewellery</span></td>
    </tr>
  
  <tr>
    <td colspan="2" align="center"> <div align="left">
    <input type="radio" name="panel_name" id="panel_name" value="SEZ" <?php if($_SESSION['m_panel_name'] =='SEZ'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">SEZ</span></td>
    
    <td colspan="2" align="center"> <div align="left">
      <input type="radio" name="panel_name" id="panel_name" value="Studded Jewellery" <?php if($_SESSION['m_panel_name'] =='Studded Jewellery'){echo "checked='checked'";}?>/>
    </div></td>
    <td width="46%"><span class="text6 ">Studded Jewellery</span></td>
    </tr>  
  </table>

          </td>
        </tr>

        <tr class="<?php if($_SESSION['main_category']=='custom_numbers'){echo "orange1";}?>" >
          <td colspan="2" class=""> <label><input type="radio" name="main_category" class="main_category" value="custom_numbers" data-classname='custom_numbers'  <?php if($_SESSION['main_category']=='custom_numbers'){echo "checked";}?>   /> &nbsp; Add Multiple Numbers </label> </td>
        </tr>
        
        <tr class="custom_numbers blocks">
          <td valign="top" class="content_txt">Add Number </td>
          <td>
            <?php 
            $custNumStr ="";
            foreach ($custom_numbersArr as $custNum) {
              $custNumStr .=$custNum->value.","; 
            }

            $custNumStr =  substr($custNumStr, 0, -1);
            ?>
            <input type="text" class="" name="custom_numbers" placeholder="Add comma saparated numbers" style="width: 50%;" value="<?php echo $custNumStr;?>">
            <br>
            <i>Use comma separated mobile numbers</i>
          </td>
        </tr>
        <tr class="<?php if($_SESSION['main_category']=='import_csv'){echo "orange1";}?>" >
          <td colspan="2" class=""> <label><input type="radio" name="main_category" class="main_category" value="import_csv" data-classname='import_csv'  <?php if($_SESSION['main_category']=='import_csv'){echo "checked";}?>   /> &nbsp; Import CSV File </label> </td>
        </tr>
        <tr class="import_csv blocks">
          <td valign="top" class="content_txt">Choose .CSV file </td>
          <td>
            <input type="file" class="input_txt" name="import_csv"/>
            <br>
            <i>Use  column CSV file 1.Variable column 2.Mobile number column</i>
            <br>
            <i><a href="https://gjepc.org/admin/whatsappAttatchments/import_csv_sample.csv" target="_blank" download="download">Click</a> here to download sample csv file format</i>
          </td>
        </tr>
        <tr class="<?php if($_SESSION['main_category']=='test_template'){echo "orange1";}?>" >
          <td colspan="2" class=""> <label><input type="radio" name="main_category" class="main_category" value="test_template" data-classname='test_template'  <?php if($_SESSION['main_category']=='test_template'){echo "checked";}?>   /> &nbsp; Test Template </label> </td>
        </tr>
        <tr class="test_template blocks">
          <td valign="top" class="content_txt">Name  : </td>
          <td>
            <input type="text" class="input_txt" name="test_variable" id="test_variable" value="<?php echo $_SESSION['test_variable'];?>">             
            <i>Add name if template required dynamic name  </i>
          </td>
        </tr>
        <tr class="test_template blocks">
          <td valign="top" class="content_txt">Number  : </td>
          <td>
            <input type="text" class="input_txt" name="test_number" id="test_number" value="<?php echo $_SESSION['test_number'];?>">
          </td>
        </tr>
        
        <tr>
          <td colspan="2" class="orange1"> Message Content</td>
        </tr>

         <tr>
          <td valign="top" class="content_txt">Sender  Department</td>
          <td> <select class="input_txt" name="msg_dept">
            <option value="">---Select Department---</option>
            <?php
            $sqlDept = "SELECT * FROM whatsapp_sender_department_master WHERE `status`='1' order by id desc";
            $resDept = $conn->query($sqlDept);
            while ($rowDept = $resDept->fetch_assoc()) { ?>
            <option value="<?= $rowDept['id']; ?>" <?php if($_SESSION['msg_dept'] ==$rowDept['id']){echo "selected";}?>><?= $rowDept['department_name']; ?></option>             
           <?php  }  ?>           
          </select>
        </td>
      </tr>
        <tr>
          <td valign="top" class="content_txt">Media Type</td>
          <td> <select class="input_txt" name="msg_type" id="msg_type">
            <option value="">---Select Type---</option>
            <option value="TEXT" <?php if($_SESSION['msg_type'] =="TEXT"){echo "selected";}?>>Text</option>
            <option value="IMAGE" <?php if($_SESSION['msg_type'] =="IMAGE"){echo "selected";}?>>Image</option>
            <option value="DOCUMENT" <?php if($_SESSION['msg_type'] =="DOCUMENT"){echo "selected";}?>>Document</option>
            <option value="VIDEO" <?php if($_SESSION['msg_type'] =="VIDEO"){echo "selected";}?>>Video</option>
          </select>
        </td>
      </tr>
       <tr>
          <td valign="top" class="content_txt">Saved Templates </td>
          <td> <select class="input_txt" name="msg_templates" id="msg_templates">
            <option value="">---Select Template---</option>
          </select>
        </td>
      </tr>
      
      <td valign="top" class="content_txt">Select Variable</td>
      <td> <select class="input_txt" name="msg_variable" id="msg_variable">
        <option value="" <?php if($_SESSION['msg_variable'] ==""){echo "selected";}?>>---Select Variable---</option>
        <option value="none" <?php if($_SESSION['msg_variable'] =="none"){echo "selected";}?>>No Variable</option>
        <option value="person" <?php if($_SESSION['msg_variable'] =="person"){echo "selected";}?>>Person name</option>
        <option value="company" <?php if($_SESSION['msg_variable'] =="company"){echo "selected";}?>>Company Name</option>
      </select>
    </td>
  </tr>
  
  <tr>
    <td valign="top" class="content_txt">Title</td>
    <td> <input type='text' class="input_txt" name="msg_title" id="msg_title" value="<?php echo $_SESSION['msg_title'];?>" style="width:90%">


    </td>
  </tr>
</tr>
<td valign="top" class="content_txt">Description</td>
<td> <textarea disabled  rows="14" class="input_txt" name="msg_description" id="msg_description" style="width: 90%"><?php echo $_SESSION['msg_description'];?></textarea>
</td>
</tr>
<tr>
  <td>Add Variables. </td>
  <td class="field_wrapper"><input type="text" class="input_txt" name="variable[]" id="variable0" value="<?php echo $_SESSION['variable'];?>"> <a class="addMore btn">Add more variable</a> <br> </td>

</tr>
<tr>
<td valign="top" class="content_txt">Media Link</td>
<td> <textarea class="input_txt" name="msg_attatchment" ></textarea><br>
  <i>Allowed File types:.PNG,.JPG,JPEG,.DOC,.DOCX,.CSV,.zip,.PDF</i><br>
  <i>Max File Size :2 MB</i>
</td>
</tr>
<tr>
<td colspan="2" style="padding: 20px">
  <input type="submit" value="Send Message" class="content_head_button input_submit" />
  
  <input type="hidden" name="action" id="action" value="send_messsage" />
   <a href="yellow_ai_sms_panel.php?action=Reset"><div class="content_head_button input_submit">Reset</div> </a>
  
</td>
</tr>
</table>
</form>


</div>
</div>
</div>

<script data-name="custom_numbers">
(function(){
/* =============The DOM element you wish to replace with Tagify-===============*/
var input = document.querySelector('input[name=custom_numbers]');

/*=============== initialize Tagify on the above input node reference==========*/
new Tagify(input)
})()
</script>

<script>
$(document).ready(function(){
 
 /*=============Encode Decode Message Title=================*/
  $("#decode_string").hide();
  $("#encode_string").click(function(){
    let uri_dc = $("#msg_description").val();
    var encodeUri = encodeURIComponent(uri_dc);
     $("#msg_description").val(encodeUri);
     $("#decode_string").show();
     $("#encode_string").hide();
  });
  $("#decode_string").click(function(){
    let uri_en = $("#msg_description").val();
    var decodeUri = decodeURIComponent(uri_en);
      $("#msg_description").val(decodeUri);
      $("#decode_string").hide();
      $("#encode_string").show();

  });
 /*=============Encode Decode Message Title=================*/


 /*================Encode Decode Message Description==========*/
 $("#decode_title").hide();
 $("#encode_title").click(function(){
    let uri_dc = $("#msg_title").val();
    var encodeUri = encodeURIComponent(uri_dc);
     $("#msg_title").val(encodeUri);
     $("#decode_title").show();
     $("#encode_title").hide();
  });
  $("#decode_title").click(function(){
    let uri_en = $("#msg_title").val();
    var decodeUri = decodeURIComponent(uri_en);
     $("#msg_title").val(decodeUri);
     $("#decode_title").hide();
      $("#encode_title").show();
  });
/*================Encode Decode Message Description==========*/

/*==============Hide All table rows on load==================*/
$("#msg_contact_custom").hide();
$(".visitor").hide();
$(".exhibitors").hide();
$(".vendors").hide();
$(".parichay").hide();
$(".member").hide();
$(".custom_numbers").hide();
$(".import_csv").hide();
$(".test_template").hide();
/*==============Hide All table rows on load==================*/

/*==============Show table row if category is in session ==================*/
<?php if($_SESSION['main_category']=='visitors'){?>
$(".visitor").show();
<?php }else if($_SESSION['main_category']=='exhibitors'){?>
$(".exhibitors").show();
<?php }else if($_SESSION['main_category']=='vendors'){?>
$(".vendors").show();
<?php }else if($_SESSION['main_category']=='parichay'){?>
$(".parichay").show();
<?php }else if($_SESSION['main_category']=='member'){?>
$(".member").show();
<?php }else if($_SESSION['main_category']=='custom_numbers'){?>
$(".custom_numbers").show();
<?php }else if($_SESSION['main_category']=='import_csv'){?>
$(".import_csv").show();
<?php }else if($_SESSION['main_category']=='test_template'){?>
$(".test_template").show();
<?php } ?> 
/*==============Show table row if category is in session ==================*/


/* ========Table  rows to openable tabs script===============*/
$('input[name="main_category"]').change(function(){
  let selClass = $(this).data("classname");
  let isChecked = $(this).prop("checked");
  let ref = $(this);
  if(isChecked){
    $(".blocks").hide();
    $("."+selClass).show();
    ref.parent().parent().parent().siblings().removeClass("orange1");
    ref.parent().parent().parent().addClass("orange1");
  }
});
/*========== Table  rows to openable tabs script================*/


let WEB_ROOT = "https://gjepc.org/admin/";
/*========== Load saved Templates on media type change================*/
$('#msg_type').change(function(){
  $("#msg_title").html("");
  $("#msg_description").html("");
  let msg_type = $(this).val();
  let actiontype = "getSavedTemplatedOnType";
  $.ajax({
    type:'POST',
    data:{msg_type:msg_type,actiontype:actiontype},
    url: WEB_ROOT + 'ajax.php',
    dataType: "json",
    success:function(result){
      if(result.status=='success'){
         $("#msg_templates").html(result.data);
      }else{
         $("#msg_templates").html("");
         $("#msg_description").html("");
        alert(result.message);
      }
    }
  }); 
});
/*========== Load saved Templates on media type change================*/

/*========== Load Templates  Data on Template change================*/
$('#msg_templates').change(function(){
  let template_id = $(this).val();
  let actiontype = "getTemplateData";
  $.ajax({
    type:'POST',
    data:{template_id:template_id,actiontype:actiontype},
    url: WEB_ROOT + 'ajax.php',
    dataType: "json",
    success:function(result){
      if(result.status=='success'){
         $("#msg_title").val(result.title);
         $("#msg_description").html(result.content);
      }else{
        alert(result.message);
      }
    }
  }); 
});
/*========== Load Templates  Data on Template change================*/

});
</script>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>