<?php
ob_start;
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
?>

<?php
$registration_id = intval($_REQUEST['registration_id']);
$app_id = intval($_REQUEST['app_id']);

$email = $_REQUEST['email'];
$member_name = filter($_REQUEST['member_name']);
$address1 = filter($_REQUEST['address1']);
$address2 = filter($_REQUEST['address2']);
$pincode = filter($_REQUEST['pincode']);
$city = filter($_REQUEST['city']);
$commemail = $_REQUEST['commemail'];
$permission_type = $_REQUEST['permission_type'];
$visiting_country1 = $_REQUEST['visiting_country1'];
$city1 = $_REQUEST['city1'];
$visiting_country2 = $_REQUEST['visiting_country2'];
$city2 = $_REQUEST['city2'];
$visiting_country3 = $_REQUEST['visiting_country3'];
$city3 = $_REQUEST['city3'];
$visiting_country4 = $_REQUEST['visiting_country4'];
$city4 = $_REQUEST['city4'];
$visiting_country5 = $_REQUEST['visiting_country5'];
$city5 = $_REQUEST['city5'];
$visiting_country6 = $_REQUEST['visiting_country6'];
$city6 = $_REQUEST['city6'];
$item1 = $_REQUEST['item1'];
$invoice_value1 = $_REQUEST['invoice_value1'];
$item2 = $_REQUEST['item2'];
$invoice_value2 = $_REQUEST['invoice_value2'];
$item3 = $_REQUEST['item3'];
$invoice_value3 = $_REQUEST['invoice_value3'];
$item4 = $_REQUEST['item4'];
$invoice_value4 = $_REQUEST['invoice_value4'];
$item5 = $_REQUEST['item5'];
$invoice_value5 = $_REQUEST['invoice_value5'];
$apprx_invoice_value = $_REQUEST['apprx_invoice_value'];
$amended_permission = isset($_REQUEST["amended_premission"])?1:0;
$bank_name = $_REQUEST['bank_name'];
$other_bank_name = $_REQUEST['other_bank_name'];
$branch_name =  $_REQUEST['branch_name'];
$person_name_carrying = $_REQUEST['person_name_carrying'];
$passport_no = $_REQUEST['passport_no']; 
$passport_issue_date = $_REQUEST['passport_issue_date'];
$passport_expiry_date = $_REQUEST['passport_expiry_date']; 
$date_of_departure = $_REQUEST['date_of_departure'];
$reg_brand_name_of_j = $_REQUEST['reg_brand_name_of_j'];
$reg_brand_name_of_a = $_REQUEST['reg_brand_name_of_a'];
$address_of_place_of_dis = $_REQUEST['address_of_place_of_dis'];
$premission_granted = $_REQUEST['premission_granted'];
$report_submitted = $_REQUEST['report_submitted'];
$multiple_exh_app = $_REQUEST['multiple_exh_app'];
$region_code = $_REQUEST['region_code'];
$from_date = $_REQUEST['from_date'];
$to_date = $_REQUEST['to_date'];
$date_of_data_entry = $_REQUEST['date_of_data_entry'];
$application_date = $_REQUEST['application_date'];
$actual_invoice_amt = $_REQUEST['actual_invoice_amt'];
$unsold_amt = $_REQUEST['unsold_amt'];
$sold_amt = $_REQUEST['sold_amt'];
$no_of_orders_boo = $_REQUEST['no_of_orders_boo'];
$merchant_reg_no = $_REQUEST['merchant_reg_no'];
$manufacturer_reg_no = $_REQUEST['manufacturer_reg_no'];
$member_id = $_REQUEST['member_id'];
$old_ref_no = $_REQUEST['old_ref_no'];
$new_ref_no = $_REQUEST['new_ref_no'];
$permission_status = $_REQUEST['permission_status'];
$modified_date = date('d-m-Y');

$sql = "UPDATE `trade_general_info` SET email= '$email',commemail='$commemail',member_name='$member_name',address1= '$address1',address2='$address2',`pincode`='$pincode',`city`= '$city',`permission_type`= '$permission_type',`visiting_country1`= '$visiting_country1',`city1` = '$city1',`visiting_country2`= '$visiting_country2',`city2`= '$city2',`visiting_country3`= '$visiting_country3',`city3`= '$city3',`visiting_country4`= '$visiting_country4',`city4`= '$city4',`visiting_country5`= '$visiting_country5',`city5`= '$city5',`visiting_country6`= '$visiting_country6',`city6`= '$city6',`item1`= '$item1',`invoice_value1`= '$invoice_value1',`item2`= '$item2',`invoice_value2`= '$invoice_value2',`item3`= '$item3',`invoice_value3`= '$invoice_value3',`item4`= '$item4',`invoice_value4`= '$invoice_value4',`item5` = '$item5',`invoice_value5`= '$invoice_value5',`apprx_invoice_value` = '$apprx_invoice_value',`bank_name`= '$bank_name',`other_bank_name`= '$other_bank_name',`branch_name`= '$branch_name',`person_name_carrying` = '$person_name_carrying',`passport_no`= '$passport_no',`passport_issue_date` ='$passport_issue_date',`passport_expiry_date` = '$passport_expiry_date',`date_of_departure` = '$date_of_departure',`region_code`= '$region_code',`from_date`= '$from_date',`to_date`= '$to_date',`application_date`= '$application_date',`actual_invoice_amt`= '$actual_invoice_amt',`unsold_amt`= '$unsold_amt',`sold_amt`= '$sold_amt',`merchant_reg_no`     = '$merchant_reg_no',`manufacturer_reg_no` = '$manufacturer_reg_no',`member_id`= '$member_id',`old_ref_no`= '$old_ref_no',`new_ref_no`= '$new_ref_no',`modified_date`= '$modified_date' WHERE `app_id`= '$app_id' LIMIT 1";					
$result = $conn ->query($sql);
if($result){
if($permission_type=="promotional_tour")
{
	header('location:trade_approval_documents.php?app_id='.$app_id.'&&registration_id='.$registration_id);
}
else
{
	header('location:trade_exhibition.php?app_id='.$app_id.'&&registration_id='.$registration_id);
} 
 } else { die ($conn->error); }
exit;
?>