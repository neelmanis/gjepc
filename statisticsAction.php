<?php 
session_start(); 
include('db.inc.php');
include('functions.php');
$registration_id=$_SESSION['USERID'];
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

$memberType = getMemberType($registration_id,$conn);

/*
**  hscode onchange export data 
*/
if($_POST && $_POST['expAction'] =="export_code"){
 $exp_hs_code = $_POST['exp_hs_code'];
$sqlExpCode = "SELECT * FROM statistics_master WHERE hs_code ='$exp_hs_code'";
$resultExpCode = $conn->query($sqlExpCode);
$rowExpCode = $resultExpCode->fetch_assoc();
 $product = $rowExpCode['product_name'];
 $unit = $rowExpCode['unit'];
 echo json_encode(array("product"=>$product,"unit"=>$unit));exit;
}

/*
**  hscode onchange Import data 
*/

if($_POST && $_POST['impAction'] =="import_code"){

$imp_hs_code = $_POST['imp_hs_code'];
$sqlImpCode = "SELECT * FROM statistics_master WHERE hs_code ='$imp_hs_code'";
$resultImpCode = $conn->query($sqlImpCode);
$rowImpCode = $resultImpCode->fetch_assoc();
$product = $rowImpCode['product_name'];
$unit = $rowImpCode['unit'];
echo json_encode(array("product"=>$product,"unit"=>$unit));exit;
}

/*
**  Modal Data response
*/
if(isset($_POST['actionType']) && $_POST['actionType']=="modalDataAction")
{
 // print_r($_POST); exit;
  $appID = $_POST['appid'];
  $sql = "SELECT * FROM statistics where registration_id='$registration_id' AND registration_id!=0 AND id='$appID' ";
  $query = $conn->query($sql);
  $ans= $query->fetch_assoc();
  $quarter_year = getQuarterDescription($ans['quarter_year'],$conn);
      
  $sqlExport = "SELECT * from statistics_exports where appId='$appID'";
  $exportResult = $conn->query($sqlExport);
  $countExport  = $exportResult->num_rows;
  if($countExport > 0)
  {
  echo '<div class="row">
          <div class="form-group col-12 mb-2 p-0"><p class="blue">Export Details</p>
          <div class="col-md-1 d-flex"></div>
          </div>
          <div class="export_wrapper border p-3 field_wrapper_export" id="export_wrapper">
        <div class="row pb-0 p-relative">
            <table class="table" width="100px;">
            <thead>
              <tr>
                <th>HS Code</th>
                <th>Products</th>
                <th>Country</th>
                <th>Value</th>
                <th>Currency</th>
                <th>Qty</th>
                <th>Unit</th>
              </tr>
            </thead>
            <tbody>';
            while($exportRows = $exportResult->fetch_assoc()) {
              $countries = '';
              $countryName = explode(",",$exportRows['country']);     
              foreach($countryName as $country) {             
                $countries .= getCountryName($country,$conn).",";
              } //    echo $countries;                      
              
           echo '<tr>
              <td>'.$exportRows['hs_code'].'</td>
              <td>'.$exportRows['products'].'</td>
              <td>'.rtrim($countries,',').'</td>
              <td>'.$exportRows['value'].'</td>
              <td>'.$exportRows['currency'].'</td>
              <td>'.$exportRows['qty'].'</td>
              <td>'.$exportRows['unit'].'</td>                        
              </tr>';
            }
          echo '</tbody>
            </table></div>
          </div>
          </div>';
  } else { 
   echo 'NIL Exports';
  }
    
  $sqlImport = "SELECT * from statistics_imports where appId='$appID'";
  $importResult = $conn->query($sqlImport);
  $countImport  = $importResult->num_rows;
  if($countImport > 0)
  {
  echo '<div class="row">
          <div class="form-group col-12 mb-2 p-0"><p class="blue">Import Details</p>
          <div class="col-md-1 d-flex"></div>
          </div>
          <div class="export_wrapper border p-3 field_wrapper_export" id="export_wrapper">
        <div class="row pb-0 p-relative">
            <table class="table" width="100px;">
            <thead>
              <tr>
                <th>HS Code</th>
                <th>Products</th>
                <th>Country</th>
                <th>Value</th>
                <th>Currency</th>
                <th>Qty</th>
                <th>Unit</th>
              </tr>
            </thead>
            <tbody>';
            while($importRows = $importResult->fetch_assoc()) {
              $countries = '';
              $countryName = explode(",",$importRows['country']);     
              foreach($countryName as $country) {           
                $countries .= getCountryName($country,$conn).",";
              } //    echo $countries;                      
              
           echo '<tr>
              <td>'.$importRows['hs_code'].'</td>
              <td>'.$importRows['products'].'</td>
              <td>'.rtrim($countries,',').'</td>
              <td>'.$importRows['value'].'</td>
              <td>'.$importRows['currency'].'</td>
              <td>'.$importRows['qty'].'</td>
              <td>'.$importRows['unit'].'</td>                        
              </tr>';
            }
          echo '</tbody>
            </table></div>
          </div>
          </div>';
  }else { 
   echo ' / NIL Imports';
  }
}

/*
** APPLICATION SUBMIT ACTION
*/

if($_POST && $_POST["action"]=="statisticsDataInsert"){
 /* echo "<pre>";print_r($_POST);exit;*/
  $data = $_POST;

 
/*------------Members Information Validation------*/
$membership_no = trim($data['membership_no']);
$company_name = trim($data['company_name']);
$iec_no = trim($data['iec_no']);
$company_pan_no = trim($data['company_pan_no']);
$quarter_year = trim($data['quarter_year']);

$region = getRegion($registration_id,$conn);
$remark = filter($data['remark']);
$export_type = filter($data['export_type']);
$agree = filter($data['agree']);

// current challan yr calculation
    $cur_year = (int)date('Y');
    $curyear  = (int)date('Y');
    $cur_month = (int)date('m');
    // if ($cur_month < 4) {
     // $cur_fin_yr = $curyear-1;
    // $cur_fin_yr1= $cur_year;
     //$cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
     // $cur_finyr= ($curyear-1) . '-' . $curyear;
    // } else {
    //  $cur_fin_yr = $curyear;
    //  $cur_fin_yr1= $cur_year;
    //  $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
    //  $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    // }
     $getSelectedyear = trim(substr($quarter_year, 2));
     $cur_finyr= $getSelectedyear . '-' . ($getSelectedyear+1);






if(empty($membership_no))
{
    $membership_no_error[] = array("status"=>"empty","msg"=>"Membership No. Required","label"=>"membership_no"); 
}else{
    $membership_no_error[] =array();
}
if(empty($company_name))
{
    $company_name_error[] = array("status"=>"empty","msg"=>" Company Name is Required","label"=>"company_name"); 
}else{
    $company_name_error[] =array();
}
if(empty($iec_no))
{
    $iec_no_error[] = array("status"=>"empty","msg"=>"Required","label"=>"iec_no"); 
}else{
    $iec_no_error[] =array();
}
if(empty($company_pan_no))
{
    $company_pan_no_error[] = array("status"=>"empty","msg"=>"Required","label"=>"company_pan_no"); 
}else{
    $company_pan_no_error[] =array();
}
if(empty($quarter_year))
{
     $quarter_year_error[] = array("status"=>"empty","msg"=>"Required","label"=>"quarter_year");
}else{
    $quarter_year_error[] =array();
}

if(empty($remark))
{
     $remark_error[] = array("status"=>"empty","msg"=>"Add remark here...","label"=>"remark");
}else{
    $remark_error[] =array();
}
if(empty($export_type))
{
     $export_type_error[] = array("status"=>"empty","msg"=>" Select export type here...","label"=>"export_type");
}else{
    $export_type_error[] =array();
}


if(isset($data['agree']) ){
if(empty($agree))
{
     $agree_error[] = array("status"=>"empty","msg"=>"Required","label"=>"agree");
}else{
    $agree_error[] =array();
}
}else{
   $agree_error[] = array("status"=>"empty","msg"=>"Required","label"=>"agree");
}

/*print_r($membership_no_error);exit;*/

if(!empty($membership_no_error) || !empty($company_name_error) || !empty($iec_no_error) || !empty($company_pan_no_error) || !empty($quarter_year_error) || !empty($export_type_error) || !empty($export_type_error) ){

$member_data_error = array_merge(array_filter($membership_no_error),array_filter($company_name_error),array_filter($iec_no_error),array_filter($company_pan_no_error),array_filter($quarter_year_error),array_filter($export_type_error),array_filter($export_type_error));
/*echo json_encode($member_data_error);exit;*/

}



/*------------Members Information Validation------*/
    /*---export hs code check--*/
    $exp_hs_codes = $data['exp_hs_code'];

    //print_r($exp_hs_codes);exit;
    foreach ($exp_hs_codes as $exp_hs_code_key => $exp_hs_code) {
       if(empty(trim($exp_hs_code))){
        $exp_hs_code_error[] = array("status"=>"empty","msg"=>"Required","label"=>"exp_hs_code".$exp_hs_code_key); 
       }else{
        $exp_hs_code_error[] =array();
       }
     } 
  
  

  /*---export products check--*/
     $exp_productss = $data['exp_products'];
    foreach ($exp_productss as $exp_products_key => $exp_products) {
       if(empty(trim($exp_products))){
        $exp_products_error[] = array("status"=>"empty","msg"=>"Required","label"=>"exp_products".$exp_products_key); 
       }else{
        $exp_products_error[] =array();
       }
     } 
     //echo "<pre>";print_r($exp_products_error);exit;
    
     /*---export country check--*/
    
      
    if(isset($data['exp_country'])){
      $exp_countrys = $data['exp_country'];
      foreach ($exp_countrys as $exp_country_key => $exp_country)
      {
      if(empty($exp_country)){
      $exp_country_error[] = array("status"=>"empty","msg"=>"Required","label"=>"exp_country".$exp_country_key);
      } else {
      $exp_country_error[] =array();
      }
      }
      } else {
      $exp_country_error[] = array("status"=>"empty","msg"=>"Required","label"=>"exp_country1");
    }
      /*--- export Value country check--*/
     $exp_values = $data['exp_value'];

    foreach ($exp_values as $exp_value_key => $exp_value) {
       if(empty(trim($exp_value))){
        $exp_value_error[] = array("status"=>"empty","msg"=>"Please enter the value only Dollar/Euro","label"=>"exp_value".$exp_value_key); 
       }else{
        $exp_value_error[] =array();
       }
     } 

    /*--- export currency country check--*/
     $exp_currencys = $data['exp_currency'];
    foreach ($exp_currencys as $exp_currency_key => $exp_currency) {
       if(empty(trim($exp_currency))){
        $exp_currency_error[] = array("status"=>"empty","msg"=>"Required","label"=>"exp_currency".$exp_currency_key); 
       }else{
        $exp_currency_error[] =array();
       }
     } 
  
    /*--- export currency country check--*/
     $exp_qtys = $data['exp_qty'];
    foreach ($exp_qtys as $exp_qty_key => $exp_qty) {
       if(empty(trim($exp_qty))){
        $exp_qty_error[] = array("status"=>"empty","msg"=>"Required","label"=>"exp_qty".$exp_qty_key); 
       }else{
        $exp_qty_error[] =array();
       }
     } 
  
  /*--- export currency country check--*/
     $exp_units = $data['exp_unit'];
    foreach ($exp_units as $exp_unit_key => $exp_unit) {
       if(empty(trim($exp_unit))){
        $exp_unit_error[] = array("status"=>"empty","msg"=>"Required","label"=>"exp_unit".$exp_unit_key); 
       }else{
        $exp_unit_error[] =array();
       }
     } 
        /*---export hs code check--*/
    $imp_hs_codes = $data['imp_hs_code'];
    foreach ($imp_hs_codes as $imp_hs_code_key => $imp_hs_code) {
       if(empty(trim($imp_hs_code))){
        $imp_hs_code_error[] = array("status"=>"empty","msg"=>"Required","label"=>"imp_hs_code".$imp_hs_code_key); 
       }else{
        $imp_hs_code_error[] =array();
       }
     } 
  
  /*---import products check--*/
     $imp_productss = $data['imp_products'];
    foreach ($imp_productss as $imp_products_key => $imp_products) {
       if(empty(trim($imp_products))){
        $imp_products_error[] = array("status"=>"empty","msg"=>"Required","label"=>"imp_products".$imp_products_key); 
       }else{
        $imp_products_error[] =array();
       }
     } 
    
     /*---import country check--*/

         
       if(isset($data['imp_country']) ){
     $imp_countrys = $data['imp_country'];

    foreach ($imp_countrys as $imp_country_key => $imp_country) {
       if(empty($imp_country)){
        $imp_country_error[] = array("status"=>"empty","msg"=>"Required","label"=>"imp_country".$imp_country_key); 
       }else{
        $imp_country_error[] =array();
       }
     } 
      }else{
          $imp_country_error[] = array("status"=>"empty","msg"=>"Required","label"=>"imp_country0"); 
      }
     
 
      /*--- import Value value check--*/
     $imp_values = $data['imp_value'];

    foreach ($imp_values as $imp_value_key => $imp_value) {
       if(empty(trim($imp_value))){
        $imp_value_error[] = array("status"=>"empty","msg"=>"Please enter the value only Dollar/Euro","label"=>"imp_value".$imp_value_key); 
       }else{
        $imp_value_error[] =array();
       }
     } 

    /*--- import currency currency check--*/
     $imp_currencys = $data['imp_currency'];
    foreach ($imp_currencys as $imp_currency_key => $imp_currency) {
       if(empty(trim($imp_currency))){
        $imp_currency_error[] = array("status"=>"empty","msg"=>"Required","label"=>"imp_currency".$imp_currency_key); 
       }else{
        $imp_currency_error[] =array();
       }
     } 
  
    /*--- import currency qty check--*/
     $imp_qtys = $data['imp_qty'];
    foreach ($imp_qtys as $imp_qty_key => $imp_qty) {
       if(empty(trim($imp_qty))){
        $imp_qty_error[] = array("status"=>"empty","msg"=>"Required","label"=>"imp_qty".$imp_qty_key); 
       }else{
        $imp_qty_error[] =array();
       }
     } 
  
  /*--- import currency unit check--*/
     $imp_units = $data['imp_unit'];
    foreach ($imp_units as $imp_unit_key => $imp_unit) {
       if(empty(trim($imp_unit))){
        $imp_unit_error[] = array("status"=>"empty","msg"=>"Required","label"=>"imp_unit".$imp_unit_key); 
       }else{
        $imp_unit_error[] =array();
       }
     } 

    


     if( !empty($exp_hs_code_error)  || !empty($exp_products_error) || !empty($exp_country_error) || !empty($exp_value_error) || !empty($exp_currency_error) || !empty($exp_qty_error) || !empty($exp_unit_error) ){
        $exp_error =  array_merge(array_filter($exp_hs_code_error),array_filter($exp_products_error),array_filter($exp_country_error),array_filter($exp_value_error),array_filter($exp_currency_error),array_filter($exp_qty_error),array_filter($exp_unit_error));

     }


      if( !empty($imp_hs_code_error)  || !empty($imp_products_error) || !empty($imp_country_error) || !empty($imp_value_error) || !empty($imp_currency_error) || !empty($imp_qty_error) || !empty($imp_unit_error) ){
        $imp_error =  array_merge(array_filter($imp_hs_code_error),array_filter($imp_products_error),array_filter($imp_country_error),array_filter($imp_value_error),array_filter($imp_currency_error),array_filter($imp_qty_error),array_filter($imp_unit_error));
    
     }


      if($export_type == "importer"){
        
        $final_error = array_merge(array_filter($imp_error), array_filter($member_data_error),array_filter($agree_error)) ;

      }elseif($export_type == "exporter"){
      
        $final_error = array_merge(array_filter($exp_error), array_filter($member_data_error),array_filter($agree_error)) ;
       
      }elseif($export_type == "both"){
        $final_error = array_merge(array_filter($exp_error),array_filter($imp_error), array_filter($member_data_error),array_filter($agree_error)) ;

      }elseif($export_type == "NO"){
        $final_error = $member_data_error ;
          
      }else{

        $final_error = array_merge(array_filter($exp_error),array_filter($imp_error), array_filter($member_data_error),array_filter($agree_error)) ;

      }

      if(!empty($final_error)){
        echo json_encode($final_error);exit;    
      }

    /*insert application info*/

  $saveType = filter($_POST['saveType']);
  if($saveType =="Submit"){
    $isDraft = "N";
  }else{
     $isDraft = "Y";
  }
  $quarterYear = substr($quarter_year,0,2);
  
  $get_QYear = substr($quarter_year,3);
  
  $isExport = filter($_POST['export_type']);
  $updateId = filter($_POST['updateId']);
  if($registration_id !=""){
  if($updateId !="" ){
    $sql = "UPDATE  statistics SET export_category='$memberType',quarter_year='$quarterYear',remark='$remark',financial_year='$cur_finyr',year='$get_QYear',isDraft='$isDraft',isExport='$isExport' WHERE id='$updateId' and registration_id='$registration_id'";
  } else {
    $sql = "INSERT INTO statistics SET registration_id='$registration_id', membership_no='$membership_no', region='$region', company_name='$company_name', iec_no='$iec_no', company_pan='$company_pan_no', export_category='$memberType',quarter_year='$quarterYear',remark='$remark',financial_year='$cur_finyr',year='$get_QYear',status='1',isDraft='$isDraft',isExport='$isExport'";
  }
}
  $resultApplication =  $conn->query($sql);

    if($updateId !=""){
        $appId = $updateId;
    } else {
         $appId = $conn->insert_id;
    }

   /*  print_r($exp_hs_codes[1]);exit;*/
     /*insert export information*/
    if($resultApplication === TRUE && $appId !="" &&  $registration_id !=""){
    
    $exp_del="DELETE FROM statistics_exports WHERE appId='$appId' and registration_id='$registration_id' ";
    $conn->query($exp_del);
     $expCount = sizeof($exp_hs_codes);
    for($i=0 ;$i < $expCount ; $i++) { 
      
    $exp_countrys_multiple= implode(",",array_unique($exp_countrys[$i]));
  if($exp_hs_codes[$i]!=''){
     $sqlExports = "INSERT INTO statistics_exports SET registration_id='$registration_id', appId='$appId',hs_code='$exp_hs_codes[$i]',products='$exp_productss[$i]',country='$exp_countrys_multiple',value='$exp_values[$i]',currency='$exp_currencys[$i]',qty='$exp_qtys[$i]',unit='$exp_units[$i]',isDraft='$isDraft'";
    $resultExports =  $conn->query($sqlExports);
    }
  }
 
  
    $imp_del="DELETE FROM statistics_imports WHERE appId='$appId' and registration_id='$registration_id' ";
    $conn->query($imp_del);
    $impCount = sizeof($imp_hs_codes);
    for( $j=0 ;$j < $impCount ; $j++){
    $imp_countrys_multiple= implode(",",array_unique($imp_countrys[$j]));
  if($imp_hs_codes[$j]!=''){
    $sqlImports = "INSERT INTO statistics_imports SET registration_id='$registration_id', appId='$appId',hs_code='$imp_hs_codes[$j]',products='$imp_productss[$j]',country='$imp_countrys_multiple',value='$imp_values[$j]',currency='$imp_currencys[$j]',qty='$imp_qtys[$j]',unit='$imp_units[$j]',isDraft='$isDraft'";
    $resultImports =  $conn->query($sqlImports);
    }
  
  }
    

$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
  <td width="85%" align="left"><img src="http://gjepc.org/images/gjepc_logo.png" width="105" height="91" /></td>         
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;"> Thank you for registering in Import/Export at Gems and Jewellery Export Promotion Council (GJEPC).
</td>
  </tr>
   <tr>
    <td>&nbsp; </td>
    </tr>
  <tr>
  <td>&nbsp; </td>
  </tr>
   <tr>
    <td>&nbsp; </td>
    </tr>
  <tr>
    <td height="22" align="left"  style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong></td>
  </tr>  
</table>';
  
  $to =  $_SESSION['EMAILID'];
  $subject = "Thanks for Showing Interest in Import/Export"; 
  $headers  = 'MIME-Version: 1.0' . "\n"; 
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
  $headers .= 'From: GJEPC <admin@gjepc.org>';  
  mail($to, $subject, $message, $headers);    
  
    }

    echo json_encode(array("status"=>"success","message"=>"Data Inserted successfully","isDraft"=>$isDraft));
 
}
?>