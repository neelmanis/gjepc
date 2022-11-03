<?php session_start();ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php    
$dt=date('Y-m-d');
$filename='web'.$dt.'_web.txt';

$fh = fopen($filename, 'wb');
// current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
 	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
 $export_member="SELECT  regis.id,regis.gcode,CONCAT(regis.first_name, ' ',regis.last_name) as name ,regis.address_line1,regis.address_line2,regis.city,info.pin_code,regis.country,info.region_id,chln.payment_mode,chln.bank_name,chln.bank_name,chln.branch_name,chln.branch_city,chln.branch_postal_code,chln.challan_region_no,chln.cheque_no,chln.cheque_date,chln.bank_name,chln.bank_name,chln.admission_fees,chln.membership_fees,chln.total_payable,chln.export_fob_value,chln.import_cif_value FROM information_master info, registration_master regis ,challan_master chln,approval_master aprvl where regis.id=info.registration_id  and regis.id=chln.registration_id and regis.id=aprvl.registration_id and aprvl.membership_type='R' and aprvl.renewal_download_status='N' and chln.challan_financial_year='$cur_fin_yr'";

$result = mysql_query($export_member); 
while ($row = mysql_fetch_array($result)) {
        $last = end($row);  
        $num = mysql_num_fields($result) ;    
        for($i = 1; $i <=$num; $i++) {
		if($i==10){$row[10]=getRegionAccNo($row['region_id']);}
		if($i==11){$row[11]=getRegionBankName($row['region_id']);}
		if($i==17){$row[17]=$row['cheque_date'];}
		if($i==18){$row[18]=getCustomerBankName($row['bank_name']);}
           fwrite($fh, $row[$i]);                      
			   if ($num != $i)
                fwrite($fh, "|");		
        }     
		mysql_query("update approval_master set renewal_download_status='Y' where registration_id='".$row[0]."'");		
		fwrite($fh, "\r\n");
  }
  
  
//fwrite($filename, $fh);
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Length: ". filesize("$filename").";");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: text/plain; "); 
header("Content-Transfer-Encoding: binary");
readfile($filename);
chmod($filename, 0777);
exit;