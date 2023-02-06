<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?php
  // function cleanData(&$str)
  // {
  //   if($str == 't') $str = 'TRUE';
  //   if($str == 'f') $str = 'FALSE';
  //   if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
  //     $str = "'$str";
  //   }
  //   if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  // }

  // // filename for download
  // $filename = "TritiyaSpaceRegistration_" . date('Ymd') . ".csv";

  // header("Content-Disposition: attachment; filename=\"$filename\"");
  // header("Content-Type: text/csv;");
  
  // $out = fopen("php://output", 'w');

  // $flag = false;


  //$sql = "SELECT a.event_for,r.gcode,a.id as 'gid', a.uid,a.gst,a.company_name,a.bp_number,x.c_bp_number as 'Billing BP No',a.contact_person, a.contact_person_desg_show,a.mobile,a.contact_person_co,a.contact_person_desg,a.contacts,a.email,a.billing_address_id,a.billing_gstin as 'Billing GST',a.address1,a.address2,a.address3,a.city,a.pincode,a.country,a.website,a.billing_address1,a.billing_address2,a.billing_address3,a.bcity,a.bpincode,a.bcountry,a.btelephone_no,a.bfax_no, a.tan_no,a.telephone_no,a.region,a.created_date,b.last_yr_participant,e.last_yr_turn_over, b.options, b.section,b.selected_area,b.selected_premium_type, b.category, b.selected_scheme_type,c.payment_status,c.document_status,c.application_status,c.created_date,c.bank_acc_no,c.name_bank,c.name_bank_branch,c.ifsc_code,c.int_acc_type,c.document_dissapprove_reason as dissapprove_reason ,c.sales_order_no,c.isCombo,b.tot_space_cost_rate,b.tot_space_cost_discount,b.get_tot_space_cost_rate,b.get_category_rate,b.selected_premium_rate,b.sub_total_cost,b.security_deposit,b.govt_service_tax,b.grand_total,a.dir_name,a.din_number,a.cin_number,a.iec_number,a.company_type,a.cast from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid inner join registration_master r on a.uid=r.id inner join exh_reg_company_details e on a.id=e.gid left join communication_address_master x on a.billing_address_id=x.id where a.event_for='IIJS Tritiya 2023'";
  //$result = $conn ->query($sql);
  // while($row = $result->fetch_assoc()) {
  //     if(!$flag) {
  //       // display field/column names as first row
  //       fputcsv($out, array_keys($row), ',', '"');
  //       $flag = true;
  //     }
  //   array_walk($row, 'cleanData');
  //   fputcsv($out, array_values($row), ',', '"');
  // }

  // fclose($out);
  // exit;
function getLastYearPremiereParticipant($registration_id,$conn)
{
  $query_inr = "SELECT exh_id FROM `exh_registration` WHERE 1 AND `uid`='$registration_id' AND `show`='IIJS PREMIERE 2022' ";
  $result = $conn->query($query_inr);
  $count = $result->num_rows;
  if($count > 0){
    return "Yes"; 
  }else{
    return "No"; 
  }
  
}

$sql = "SELECT a.event_for,r.gcode,a.id as 'gid', a.uid,a.gst,a.company_name,a.bp_number,x.c_bp_number as billing_bp_no,a.contact_person, a.contact_person_desg_show,a.mobile,a.contact_person_co,a.contact_person_desg,a.contacts,a.email,a.billing_address_id,a.billing_gstin as billing_gst,a.address1,a.address2,a.address3,a.city,a.pincode,a.country,a.website,a.billing_address1,a.billing_address2,a.billing_address3,a.bcity,a.bpincode,a.bcountry,a.btelephone_no,a.bfax_no, a.tan_no,a.telephone_no,a.region,a.created_date,b.last_yr_participant,e.last_yr_turn_over, b.options, b.section,b.selected_area,b.selected_premium_type, b.category, b.selected_scheme_type,c.payment_status,c.document_status,c.application_status,c.created_date,c.bank_acc_no,c.name_bank,c.name_bank_branch,c.ifsc_code,c.int_acc_type,c.document_dissapprove_reason as dissapprove_reason ,c.sales_order_no,c.isCombo,b.tot_space_cost_rate,b.tot_space_cost_discount,b.get_tot_space_cost_rate,b.get_category_rate,b.selected_premium_rate,b.sub_total_cost,b.security_deposit,b.govt_service_tax,b.grand_total,a.dir_name,a.din_number,a.cin_number,a.iec_number,a.company_type,a.cast from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid inner join registration_master r on a.uid=r.id inner join exh_reg_company_details e on a.id=e.gid left join communication_address_master x on a.billing_address_id=x.id where a.event_for='IGJME'";
$result = $conn ->query($sql);

$table = $display = ""; 
$fn = "report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>event_for</td>
<td>gcode No</td>
<td>gid</td>
<td>uid </td>
<td>gst</td>
<td>company_name</td>
<td>bp_number</td>
<td>c_bp_number</td>
<td>billing_bp_no</td>
<td>contact_person</td>
<td>contact_person_desg_show</td>
<td>mobile</td>
<td>contact_person_co</td>
<td>contact_person_desg</td>
<td>contacts</td>
<td>email</td>
<td>billing_address_id</td>
<td>billing_gst</td>
<td>address1</td>
<td>address2</td>
<td>address3</td>
<td>city</td>
<td>pincode</td>
<td>country</td>
<td>website</td>
<td>billing_address1</td>
<td>billing_address2</td>
<td>billing_address3</td>
<td>bcity</td>
<td>bpincode</td>
<td>bcountry</td>
<td>btelephone_no</td>
<td>bfax_no</td>
<td>tan_no</td>
<td>telephone_no</td>
<td>region</td>
<td>created_date</td>
<td>last_yr_participant</td>
<td>last_yr_turn_over</td>
<td>options</td>
<td>section</td>
<td>selected_area</td>
<td>selected_premium_type</td>
<td>category</td>
<td>selected_scheme_type</td>
<td>payment_status</td>
<td>document_status</td>
<td>application_status</td>
<td>created_date</td>
<td>bank_acc_no</td>
<td>name_bank</td>
<td>name_bank_branch</td>
<td>ifsc_code</td>
<td>int_acc_type</td>
<td>dissapprove_reason</td>
<td>sales_order_no</td>
<td>isCombo</td>
<td>tot_space_cost_rate</td>
<td>tot_space_cost_discount</td>
<td>get_tot_space_cost_rate</td>
<td>get_category_rate</td>
<td>selected_premium_rate</td>
<td>sub_total_cost</td>


<td>security_deposit</td>
<td>govt_service_tax</td>
<td>grand_total</td>
<td>dir_name</td>
<td>din_number</td>
<td>cin_number</td>
<td>iec_number</td>
<td>company_type</td>
<td>cast</td>
<td>Last Year IIJS Premiere Participant</td>
</tr>';

while($row = $result->fetch_assoc())
{ 

$table .= '<tr>
<td>'.$row['event_for'].'</td>
<td>'.$row['gcode No'].'</td>
<td>'.$row['gid'].'</td>
<td>'.$row['uid'].'</td>
<td>'.$row['gst'].'</td>
<td>'.$row['company_name'].'</td>
<td>'.$row['bp_number'].'</td>
<td>'.$row['c_bp_number'].'</td>
<td>'.$row['billing_bp_no'].'</td>
<td>'.$row['contact_person'].'</td>
<td>'.$row['contact_person_desg_show'].'</td>
<td>'.$row['mobile'].'</td>
<td>'.$row['contact_person_co'].'</td>
<td>'.$row['contact_person_desg'].'</td>
<td>'.$row['contacts'].'</td>
<td>'.$row['email'].'</td>
<td>'.$row['billing_address_id'].'</td>
<td>'.$row['billing_gst'].'</td>
<td>'.$row['address1'].'</td>
<td>'.$row['address2'].'</td>
<td>'.$row['address3'].'</td>
<td>'.$row['city'].'</td>
<td>'.$row['pincode'].'</td>
<td>'.$row['country'].'</td>
<td>'.$row['website'].'</td>
<td>'.$row['billing_address1'].'</td>
<td>'.$row['billing_address2'].'</td>
<td>'.$row['billing_address3'].'</td>
<td>'.$row['bcity'].'</td>
<td>'.$row['bpincode'].'</td>
<td>'.$row['bcountry'].'</td>
<td>'.$row['btelephone_no'].'</td>
<td>'.$row['bfax_no'].'</td>
<td>'.$row['tan_no'].'</td>
<td>'.$row['telephone_no'].'</td>
<td>'.$row['region'].'</td>
<td>'.$row['created_date'].'</td>
<td>'.$row['last_yr_participant'].'</td>
<td>'.$row['last_yr_turn_over'].'</td>
<td>'.$row['options'].'</td>
<td>'.$row['section'].'</td>
<td>'.$row['selected_area'].'</td>
<td>'.$row['selected_premium_type'].'</td>
<td>'.$row['category'].'</td>
<td>'.$row['selected_scheme_type'].'</td>
<td>'.$row['payment_status'].'</td>
<td>'.$row['document_status'].'</td>
<td>'.$row['application_status'].'</td>
<td>'.$row['created_date'].'</td>
<td>'.$row['bank_acc_no'].'</td>
<td>'.$row['name_bank'].'</td>
<td>'.$row['name_bank_branch'].'</td>
<td>'.$row['ifsc_code'].'</td>
<td>'.$row['int_acc_type'].'</td>
<td>'.$row['dissapprove_reason'].'</td>
<td>'.$row['sales_order_no'].'</td>
<td>'.$row['isCombo'].'</td>
<td>'.$row['tot_space_cost_rate'].'</td>
<td>'.$row['tot_space_cost_discount'].'</td>
<td>'.$row['get_tot_space_cost_rate'].'</td>
<td>'.$row['get_category_rate'].'</td>
<td>'.$row['selected_premium_rate'].'</td>
<td>'.$row['sub_total_cost'].'</td>
<td>'.$row['security_deposit'].'</td>
<td>'.$row['govt_service_tax'].'</td>
<td>'.$row['grand_total'].'</td>
<td>'.$row['dir_name'].'</td>
<td>'.$row['din_number'].'</td>
<td>'.$row['cin_number'].'</td>
<td>'.$row['iec_number'].'</td>
<td>'.$row['company_type'].'</td>
<td>'.$row['cast'].'</td>
<td>'.getLastYearPremiereParticipant($row['uid'],$conn).'</td>
</tr>';
  
}
 $table .= $display;
$table .= '</table>';

    header("Content-type: application/x-msdownload"); 
    # replace excelfile.xls with whatever you want the filename to default to
    header("Content-Disposition: attachment; filename=$fn.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $table;
exit; 
?>
