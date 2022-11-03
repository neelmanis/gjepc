<?php
session_start(); 
ob_start();
include('../db.inc.php');
include('../functions.php');
$date=date("d_m_Y");
error_reporting(E_ALL);
ini_set('display_errors', 1);
$sql = "SELECT * FROM vendor_area_registration WHERE 1 ";
$result = $conn->query($sql);

  /* VENDOR ALL DOCUMENT LIST*/ 
   $all_docs = "SELECT * FROM vendor_documents WHERE 1";
   $all_docs_result = $conn->query($all_docs);

   /* VENDOR AREA  SPECIFIC DOCUMENT LIST*/ 
   $all_docs = "SELECT * FROM vendor_documents WHERE 1";
   $all_docs_result = $conn->query($all_docs);

   $columns = array(array("title"=>"Area","value"=>"area"),array("title"=>"Company Name","value"=>"company_name"));
   
   while($all_docs_row = $all_docs_result->fetch_assoc()){
    $columns[] = array("title"=>$all_docs_row['name'],"value"=>$all_docs_row['document_key']);
   }

  //echo "<pre>";print_r($columns);
   $columnCount = count($columns);
     
  function getColumnValue($vendor_id,$area_id,$value,$conn){
    if($value =="area"){
       $result_area = $conn->query("SELECT * FROM vendor_area_master WHERE id='$area_id'");
       $row_area = $result_area->fetch_assoc();
       return $row_area['area'];

    }else if($value =="company_name"){
      return getVendorCompanyName($vendor_id,$conn);
    }else{
        /* GET DOCUMENT ID FROM DOCUMENT KEY */
          $get_doc_master = $conn->query("SELECT * FROM vendor_documents WHERE document_key='$value'");
          $get_doc_master_row = $get_doc_master->fetch_assoc();
          $document_id = $get_doc_master_row['id'];
          $type = $get_doc_master_row['type'];
        if( $type =="c"){
          $result_doc = $conn->query("SELECT * FROM vendor_document_uploads WHERE vendor_id='$vendor_id' and document_key='$value'");
          if($result_doc->num_rows > 0){
             $row_doc = $result_doc->fetch_assoc();
             return $row_doc['status'];
          }else{
            /* CHECK AREA DOC UPLOADED OR NOT */
            $area_spec_doc =  $conn->query("SELECT * FROM vendor_area_specific_docs WHERE area='$area_id'");
            $area_spec_doc_row =  $area_spec_doc->fetch_assoc();
            $area_spec_docs_array = explode(",",$area_spec_doc_row['document'] );

            

            if(in_array($document_id ,$area_spec_docs_array )){
              return "Not Uploaded ";
            }
            return "NA";
          }
        }else{
          $result_doc = $conn->query("SELECT * FROM area_spec_doc_upload WHERE vendor_id='$vendor_id' and document_key='$value' and area_id='$area_id'");
          if($result_doc->num_rows > 0){
             $row_doc = $result_doc->fetch_assoc();
             return $row_doc['status'];
          }else{
            /* CHECK AREA DOC UPLOADED OR NOT */
            $area_spec_doc =  $conn->query("SELECT * FROM vendor_area_specific_docs WHERE area='$area_id'");
            $area_spec_doc_row =  $area_spec_doc->fetch_assoc();
            $area_spec_docs_array = explode(",",$area_spec_doc_row['document'] );

            

            if(in_array($document_id ,$area_spec_docs_array )){
              return "Not Uploaded ";
            }
            return "NA";
          }

        }

        


        
        
    }

  }

$table = $display = ""; 
$fn = "vendor_empanelment_report_". date('Ymd');
?>



<?php $table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">

  <tr>';
foreach($columns as $column ){ 
      $table .= '<th>'.$column['title'].'</th>';
   } 
 $table .= '</tr>';

   while ($row = $result->fetch_assoc()) {
     
  /* GET AREAWISE DOCUMENT LIST */ 
    $area_id = $row['area_id'];
    $vendor_id = $row['vendor_id'];

 $table .= '<tr>';

    for ($i=0; $i < $columnCount; $i++) { 
      $table .= '<td>'.getColumnValue( $vendor_id,$area_id,$columns[$i]['value'],$conn).'</td>';
     }
  $table .= '</tr>';
  
   } 
  
$table .= '</table>';
  header("Content-type: application/x-msdownload");
  header("Content-Disposition: attachment; filename=$fn.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
  echo $table;
exit; 

?>


         

