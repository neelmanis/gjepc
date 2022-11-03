<?php session_start(); 

include('db.inc.php');

include('functions.php');

$registration_id = $_SESSION['USERID'];

$stmtSql = "SELECT * FROM import_export WHERE  registration_id='$registration_id'  ORDER BY quarter_year DESC";

$stmt=mysql_query($stmtSql);

$columnHeader ='';

$setData='';

$j=1;

while($rec =mysql_fetch_assoc($stmt))

{
  if(!empty($rec['exp_commodities_name']) || !empty($rec['imp_commodities_name'])){


  $rowData = '';
  
   $imp_commodities_code = explode(",",$rec['imp_commodities_code']);
   $imp_commodities_name = explode(",",$rec['imp_commodities_name']);
   $imp_weight = explode(",",$rec['imp_weight']);
   $imp_amt_us = explode(",",$rec['imp_amt_us']);
   $imp_amt_rs = explode(",",$rec['imp_amt_rs']);
   $count =   sizeof($imp_commodities_code);

   $exp_commodities_code = explode(",",$rec['exp_commodities_code']);
   $exp_commodities_name = explode(",",$rec['exp_commodities_name']);
   $exp_weight = explode(",",$rec['exp_weight']);
   $exp_amt_us = explode(",",$rec['exp_amt_us']);
   $exp_amt_rs = explode(",",$rec['exp_amt_rs']);
   $count_exp =   sizeof($exp_commodities_code);

   $imp_weight = explode(",",$rec['imp_weight']);
   $exp_weight = explode(",",$rec['exp_weight']);
   $imp_amt_us = explode(",",$rec['imp_amt_us']);
   $imp_amt_rs = explode(",",$rec['imp_amt_rs']);
   $exp_amt_us = explode(",",$rec['exp_amt_us']);
   $exp_amt_rs = explode(",",$rec['exp_amt_rs']);


   $value='';
          
           
            $columnHeader =   ''."Party Name"."\t"."Quarter"."\t"."Type"."\t"."Commodities Name"."\t"."HS Code"."\t"."carat/Weight"."\t"."Rupees in Crores"."\t"."US$ in Million"."\t";

            for( $i=0 ;$i < $count ; $i++){ 
            $value .= ''.getNameCompany($rec['registration_id'])."\t".mb_substr($rec['quarter_year'], 0, 12)."\t"."Import"."\t".$imp_commodities_name[$i] ."\t". $imp_commodities_code[$i]."\t".$imp_weight[$i]."\t".$imp_amt_rs[$i]."\t".$imp_amt_us[$i]."\t"."\n";
          }

            for( $k=0 ;$k < $count_exp ; $k++){ 
             $value .= ''.getNameCompany($rec['registration_id'])."\t".mb_substr($rec['quarter_year'], 0, 12)."\t"."Export"."\t".$exp_commodities_name[$k]."\t".$exp_commodities_code[$k]."\t".$exp_weight[$k]."\t".$exp_amt_rs[$k]."\t".$exp_amt_us[$k]."\t"."\n";
          }

  $setData .= trim($value)."\n";
    $j++;

}
}



header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=export import sheet.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader)."\n".$setData."\n";


?>
