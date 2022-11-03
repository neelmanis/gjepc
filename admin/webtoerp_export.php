<?php session_start();ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php  
$dt=date('Y-m-d'); 
$filename='web'.$dt.'_web.txt';
$fh = fopen($filename, 'wb');
$export_member="SELECT  regis.id,info.registration_id,info.company_name,info.company_name2,info.address1,info.address2,info.address3,info.city,info.pin_code,info.country,info.mobile_no,info.fax_no,regis.email_id,info.designation,info.iec_no,info.iec_issue_date,info.year_of_starting_bussiness,info.dtc_sight_holder,info.seepz_member,info.type_of_firm,chln.export_fob_value,chln.import_cif_value,comm.refer_membership_id,chln.seconder_code,comm.panel_name,comm.panel_name,aprvl.import_export_approve,aprvl.payment_approve,aprvl.document_approve,aprvl.memorandum_of_association,aprvl.required_subscription,DATE_FORMAT(regis.post_date,'%d/%m/%y') AS post FROM information_master info, registration_master regis ,communication_details_master comm,challan_master chln,approval_master aprvl where regis.id=info.registration_id and info.registration_id=comm.registration_id and info.registration_id=chln.registration_id and aprvl.membership_type='N' and info.registration_id=aprvl.registration_id and aprvl.download_status='N' and aprvl.information_approve='Y' and aprvl.document_approve='Y' and aprvl.payment_approve='Y'";

$result = mysql_query($export_member);    
while ($row = mysql_fetch_array($result)) {      
        $last = end($row);  
        $num = mysql_num_fields($result) ;    
        for($i = 2; $i <=$num; $i++) { 
		 if($i==24){$row[24]=getPanelCode($row['panel_name']);} 
               fwrite($fh, strtoupper($row[$i]));                      
               if ($row[$i] != $last)
                fwrite($fh, "|");
 			    if($i==$num){
				 fwrite($fh,"|");
			}
        }  
		
	/*.................Fetch Head Offoce Address.................*/
	$qh_comm=mysql_query("select * from communication_address_master where registration_id='".$row[1]."' and type_of_address='2'");
	$rh_comm=mysql_fetch_array($qh_comm);	
	$headoffice_address=strtoupper($rh_comm['address1'])."|".strtoupper($rh_comm['address2'])."|".strtoupper($rh_comm['city'])."|".strtoupper($rh_comm['pincode'])."|".strtoupper($rh_comm['country'])."|".strtoupper($rh_comm['mobile_no'])."|".strtoupper($rh_comm['email_id'])."|";
	
	fwrite($fh, $headoffice_address);
	
	/*.................Fetch Registered Address.................*/
	$qres_comm=mysql_query("select * from communication_address_master where registration_id='".$row[1]."' and type_of_address='6'");
	$rres_comm=mysql_fetch_array($qres_comm);	
	$resoffice_address=strtoupper($rres_comm['address1'])."|".strtoupper($rres_comm['address2'])."|".($rres_comm['city'])."|".strtoupper($rres_comm['pincode'])."|".strtoupper($rres_comm['country'])."|".strtoupper($rres_comm['fax_no1'])."|".strtoupper($rres_comm['mobile_no'])."|".strtoupper($rres_comm['email_id'])."|";
	   
	   fwrite($fh, $resoffice_address);
	   /*.................Fetch Branch Address.................*/
	$qb_comm=mysql_query("select * from communication_address_master where registration_id='".$row[1]."' and type_of_address='3'");
	$rb_comm=mysql_fetch_array($qb_comm);	
	$branchoffice_address=strtoupper($rb_comm['address1'])."|".strtoupper($rb_comm['address2'])."|".strtoupper($rb_comm['city'])."|".strtoupper($rb_comm['pincode'])."|".strtoupper($rb_comm['country'])."|".strtoupper($rb_comm['fax_no1'])."|".strtoupper($rb_comm['mobile_no'])."|".strtoupper($rb_comm['email_id'])."|";
	   
	   fwrite($fh, $branchoffice_address);
		mysql_query("update approval_master set download_status='Y' where registration_id='".$row[0]."'");		
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