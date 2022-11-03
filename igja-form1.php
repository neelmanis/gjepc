<?php
include('header_include.php');
include('include-new/header.php');
// print_r($_SESSION);
// $step = "qualitative_information";
//echo '------------------'.$_SESSION['step'] ;
?>
<?php
// Configure upload directory and allowed file types
$upload_dir = 'images/igja_awards/';
$allowed_types = array('jpg', 'png', 'jpeg', 'doc','pdf','PDF','docx','csv','zip');
// Define maxsize for files i.e 2MB
$maxsize = 2 * 1024 * 1024;
$created_at =date("Y-m-d H:i:s");
if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="general_info"){
	$annual_reports = array();
$income_tax_return_attatchments=array();
$company_name = filter($_REQUEST['company_name']);
$year = filter($_REQUEST['year']);
$imp_exp_code = filter($_REQUEST['imp_exp_code']);
$tel_no = filter($_REQUEST['tel_no']);
$email_id = filter($_REQUEST['email_id']);
$website = filter($_REQUEST['website']);
$address_line_1 = filter($_REQUEST['address_line_1']);
$address_line_2 = filter($_REQUEST['address_line_2']);
$city = filter($_REQUEST['city']);
$state = filter($_REQUEST['state']);
$zipcode = filter($_REQUEST['zipcode']);
$membership_no = filter($_REQUEST['membership_no']);
$membership_year = filter($_REQUEST['membership_year']);
$company_type = filter($_REQUEST['company_type']);
$nature_of_business = filter($_REQUEST['nature_of_business']);

$total_income_FY20 = filter($_REQUEST['total_income_FY20']);
$total_income_FY19 = filter($_REQUEST['total_income_FY19']);
$total_income_FY18 = filter($_REQUEST['total_income_FY18']);
$total_sale_FY20 = filter($_REQUEST['total_sale_FY20']);
$total_sale_FY19 = filter($_REQUEST['total_sale_FY19']);
$total_sale_FY18 = filter($_REQUEST['total_sale_FY18']);
$domestic_sales_FY20 = filter($_REQUEST['domestic_sales_FY20']);
$domestic_sales_FY19 = filter($_REQUEST['domestic_sales_FY19']);
$domestic_sales_FY18 = filter($_REQUEST['domestic_sales_FY18']);
$exports_FY20 = filter($_REQUEST['exports_FY20']);
$exports_FY19 = filter($_REQUEST['exports_FY19']);
$exports_FY18 = filter($_REQUEST['exports_FY18']);
$net_profit_FY20 = filter($_REQUEST['net_profit_FY20']);
$net_profit_FY19 = filter($_REQUEST['net_profit_FY19']);
$net_profit_FY18 = filter($_REQUEST['net_profit_FY18']);
$permenant_employees_FY20 = filter($_REQUEST['permenant_employees_FY20']);
$permenant_employees_FY19 = filter($_REQUEST['permenant_employees_FY19']);
$permenant_employees_FY18 = filter($_REQUEST['permenant_employees_FY18']);
$contractual_employees_FY20 = filter($_REQUEST['contractual_employees_FY20']);
$contractual_employees_FY19 = filter($_REQUEST['contractual_employees_FY19']);
$contractual_employees_FY18 = filter($_REQUEST['contractual_employees_FY18']);
$other_employees_FY20 = filter($_REQUEST['other_employees_FY20']);
$other_employees_FY19 = filter($_REQUEST['other_employees_FY19']);
$other_employees_FY18 = filter($_REQUEST['other_employees_FY18']);
$incm_tax_paid_FY20 = filter($_REQUEST['incm_tax_paid_FY20']);
$incm_tax_paid_FY19 = filter($_REQUEST['incm_tax_paid_FY19']);
$incm_tax_paid_FY18 = filter($_REQUEST['incm_tax_paid_FY18']);
$senior_management = serialize(array("sm_title"=>$_POST['sm_title'],"sm_name"=>$_POST['sm_name'],"sm_designation"=>$_POST['sm_designation']));
$company_details = serialize(array("total_income_FY20"=>$total_income_FY20,
"total_income_FY19"=>$total_income_FY19,
"total_income_FY18"=>$total_income_FY18,
"total_sale_FY20"=>$total_sale_FY20,
"total_sale_FY19"=>$total_sale_FY19,
"total_sale_FY18"=>$total_sale_FY18,
"domestic_sales_FY20"=>$domestic_sales_FY20,
"domestic_sales_FY19"=>$domestic_sales_FY19,
"domestic_sales_FY18"=>$domestic_sales_FY18,
"exports_FY20"=>$exports_FY20,
"exports_FY19"=>$exports_FY19,
"exports_FY18"=>$exports_FY18,
"net_profit_FY20"=>$net_profit_FY20,
"net_profit_FY19"=>$net_profit_FY19,
"net_profit_FY18"=>$net_profit_FY18,
"permenant_employees_FY20"=>$permenant_employees_FY20,
"permenant_employees_FY19"=>$permenant_employees_FY19,
"permenant_employees_FY18"=>$permenant_employees_FY18,
"contractual_employees_FY20"=>$contractual_employees_FY20,
"contractual_employees_FY19"=>$contractual_employees_FY19,
"contractual_employees_FY18"=>$contractual_employees_FY18,
"other_employees_FY20"=>$other_employees_FY20,
"other_employees_FY19"=>$other_employees_FY19,
"other_employees_FY18"=>$other_employees_FY18,
"incm_tax_paid_FY20"=>$incm_tax_paid_FY20,
"incm_tax_paid_FY19"=>$incm_tax_paid_FY19,
"incm_tax_paid_FY18"=>$incm_tax_paid_FY18));
$performance_award_category = implode("_", $_POST['performance_award_category']);
$theme_based_award_category = implode("_", $_POST['theme_based_award_category']);
$other_award_category = implode("_", $_POST['other_award_category']);
$_SESSION['theme_based_award_category']  = $_POST['theme_based_award_category'];



// Checks if user sent an empty form
if(!empty(array_filter($_FILES['annual_report']['name']))) {

// Loop through each file in files[] array
foreach ($_FILES['annual_report']['tmp_name'] as $key => $value) {

$file_tmpname = $_FILES['annual_report']['tmp_name'][$key];
$file_name = $_FILES['annual_report']['name'][$key];
$file_name = str_replace(" ","_",$file_name);
$file_name = time().'_'.$file_name;


$annual_reports[] = $file_name;
$file_size = $_FILES['annual_report']['size'][$key];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
// Set upload file path
$filepath = $upload_dir.$file_name;
// Check file type is allowed or not
if(in_array(strtolower($file_ext), $allowed_types)) {
// Verify file size - 2MB max
if ($file_size > $maxsize){
    $signup_error="Error: File size is larger than the allowed limit.";
    }else{
        // If file with name already exist then append time in
// front of name of the file to avoid overwriting of file
$filepath = $upload_dir.$file_name;
move_uploaded_file($file_tmpname, $filepath);
    }
}
else {

// If file extention not valid
$signup_error= "Error uploading {$file_name} ";
$signup_error= "({$file_ext} file type is not allowed)<br / >";
}
}
}
if(!empty(array_filter($_FILES['income_tax_return_attatchments']['name']))) {

// Loop through each file in files[] array
foreach ($_FILES['income_tax_return_attatchments']['tmp_name'] as $key1 => $value1) {

$file_tmpname1 = $_FILES['income_tax_return_attatchments']['tmp_name'][$key1];
$file_name1 = $_FILES['income_tax_return_attatchments']['name'][$key1];
$file_name1 = str_replace(" ","_",$file_name1);
$file_name1 = time().'_'.$file_name1;

$income_tax_return_attatchments[] = $file_name1;
$file_size1 = $_FILES['income_tax_return_attatchments']['size'][$key1];
$file_ext1 = pathinfo($file_name1, PATHINFO_EXTENSION);
// Set upload file path
$filepath1 = $upload_dir.$file_name1;

// Check file type is allowed or not
if(in_array(strtolower($file_ext1), $allowed_types)) {

// Verify file size - 2MB max
if ($file_size1 > $maxsize){
$signup_error="Error: File size is larger than the allowed limit.";
}else{

// If file with name already exist then append time in
// front of name of the file to avoid overwriting of file

$filepath1 = $upload_dir.$file_name1;

move_uploaded_file($file_tmpname1, $filepath1);
}
}
else {

// If file extention not valid
$signup_error= "Error uploading {$file_name} ";
$signup_error= "({$file_ext1} file type is not allowed)<br / >";
}
}
}


if(empty($_POST['performance_award_category']) && empty($_POST['theme_based_award_category']) && empty($_POST['other_award_category'])){
 $signup_error="Please Select  Any one Award category";
}else{
$attatchments = serialize(array("annual_reports"=>$annual_reports,"income_tax_return_attatchments"=>$income_tax_return_attatchments));
 $sql_general_info = "INSERT INTO igja_industry_performance_and_theme_based_awards SET company_name='$company_name',est_year='$year',imp_exp_code='$imp_exp_code',tel_no='$tel_no',email_id='$email_id',website='$website',address_line_1='$address_line_1',address_line_2='$address_line_2',city='$city',state='$state',zipcode='$zipcode',membership_no='$membership_no',membership_year='$membership_year',company_type='$company_type',nature_of_business='$nature_of_business',senior_management='$senior_management',performance_award_category='$performance_award_category',theme_based_award_category='$theme_based_award_category',other_award_category='$other_award_category',company_details='$company_details',attatchments='$attatchments',created_at='$created_at'";
$result = $conn->query($sql_general_info);
if($result ===TRUE){
$reg_id =  $conn->insert_id;
$step = "general_info";
$_SESSION['reg_id'] = $reg_id ;
$_SESSION['step'] = $step;
}
}




}
if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="innovative_company" && $_SESSION["reg_id"] !=""){

$details_r_n_d_activities = filter($_POST['details_r_n_d_activities']);
$innovation_activities_last_3_yr = filter($_POST['innovation_activities_last_3_yr']);
$how_impact_innovation = filter($_POST['how_impact_innovation']);
$registered_patents_for_innovation = filter($_POST['registered_patents_for_innovation']);
$award_and_accolades_won_details = filter($_POST['award_and_accolades_won_details']);
$amount_of_r_n_d_expenditure = serialize(array(
"r_n_d_activities"=>$_POST['r_n_d_activities'],
"r_n_d_activities_FY20"=>$_POST['r_n_d_activities_FY20'],
"r_n_d_activities_FY19"=>$_POST['r_n_d_activities_FY19'],
"r_n_d_activities_FY18"=>$_POST['r_n_d_activities_FY18'],
"total_r_n_d_activities_FY20"=>$_POST['total_r_n_d_activities_FY20'],
"total_r_n_d_activities_FY19"=>$_POST['total_r_n_d_activities_FY19'],
"total_r_n_d_activities_FY18"=>$_POST['total_r_n_d_activities_FY18'],
));
$reg_id = $_SESSION["reg_id"];
// Loop through each file in files[] array
foreach ($_FILES['attatchment']['tmp_name'] as $key => $value) {

$file_tmpname = $_FILES['attatchment']['tmp_name'][$key];
$file_name = $_FILES['attatchment']['name'][$key];
$file_name = str_replace(" ","_",$file_name);
$file_name = time().'_'.$file_name;
$attatchment[] = $file_name;
$file_size = $_FILES['attatchment']['size'][$key];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

// Set upload file path
$filepath = $upload_dir.$file_name;

// Check file type is allowed or not
if(in_array(strtolower($file_ext), $allowed_types)) {

// Verify file size - 2MB max
if ($file_size > $maxsize)
$signup_error="Error: File size is larger than the allowed limit.";

// If file with name already exist then append time in
// front of name of the file to avoid overwriting of file

$filepath = $upload_dir.$file_name;

if( move_uploaded_file($file_tmpname, $filepath)) {


$signup_error="all_uploaded";
}
else {
$signup_error= "Error uploading {$file_name} <br />";
}


}
else {

// If file extention not valid
$signup_error= "Error uploading {$file_name} ";
$signup_error= "({$file_ext} file type is not allowed)<br / >";
}
}


$attatchments = serialize(array("attatchments"=>$attatchment));
$sql_innovative_company = "INSERT INTO igja_theme_based_innovative_company SET reg_id='$reg_id',amount_of_r_n_d_expenditure='$amount_of_r_n_d_expenditure',details_r_n_d_activities='$details_r_n_d_activities',innovation_activities_last_3_yr='$innovation_activities_last_3_yr',how_impact_innovation='$how_impact_innovation',registered_patents_for_innovation='$registered_patents_for_innovation',award_and_accolades_won_details='$award_and_accolades_won_details',attatchments='$attatchments'";
$result = $conn->query($sql_innovative_company);
$_SESSION['theme_based_award_category'] = array_values(array_diff($_SESSION['theme_based_award_category'], array("Most Innovative Company (Part B)")));
$step = "qualitative_information";
$_SESSION['step'] = $step;
}
if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="digital_initiative" && $_SESSION["reg_id"] !=""){
$year_of_launch = filter($_POST['year_of_launch']);
$total_turnover_FY20 = filter($_POST['total_turnover_FY20']);
$total_turnover_FY19 = filter($_POST['total_turnover_FY19']);
$total_turnover_FY18 = filter($_POST['total_turnover_FY18']);
$export_turnover_FY20 = filter($_POST['export_turnover_FY20']);
$export_turnover_FY19 = filter($_POST['export_turnover_FY19']);
$export_turnover_FY18 = filter($_POST['export_turnover_FY18']);
$share_of_turnover_FY20 = filter($_POST['share_of_turnover_FY20']);
$share_of_turnover_FY19 = filter($_POST['share_of_turnover_FY19']);
$share_of_turnover_FY18 = filter($_POST['share_of_turnover_FY18']);
$no_of_clients_FY20 = filter($_POST['no_of_clients_FY20']);
$no_of_clients_FY19 = filter($_POST['no_of_clients_FY19']);
$no_of_clients_FY18 = filter($_POST['no_of_clients_FY18']);
$area1 = filter($_POST['area1']);
$isArea1 = filter($_POST['isArea1']);
$initiatives1 = filter($_POST['initiatives1']);
$impact1 = filter($_POST['impact1']);
$area2 = filter($_POST['area2']);
$isArea2 = filter($_POST['isArea2']);
$initiatives2 = filter($_POST['initiatives2']);
$impact2 = filter($_POST['impact2']);
$area3 = filter($_POST['area3']);
$isArea3 = filter($_POST['isArea3']);
$initiatives3 = filter($_POST['initiatives3']);
$impact3 = filter($_POST['impact3']);
$area4 = filter($_POST['area4']);
$isArea4 = filter($_POST['isArea4']);
$initiatives4 = filter($_POST['initiatives4']);
$impact4 = filter($_POST['impact4']);
$area5 = filter($_POST['area5']);
$isArea5 = filter($_POST['isArea5']);
$initiatives5 = filter($_POST['initiatives5']);
$impact5 = filter($_POST['impact5']);
$area6 = filter($_POST['area6']);
$isArea6 = filter($_POST['isArea6']);
$initiatives6 = filter($_POST['initiatives6']);
$impact6 = filter($_POST['impact6']);
$area7 = filter($_POST['area7']);
$isArea7 = filter($_POST['isArea7']);
$initiatives7 = filter($_POST['initiatives7']);
$impact7 = filter($_POST['impact7']);

$turnover_through_digital_platform = serialize(array("total_turnover_FY20"=>$total_turnover_FY20,"total_turnover_FY19"=>$total_turnover_FY19,"total_turnover_FY18"=>$total_turnover_FY18,"export_turnover_FY20"=>$export_turnover_FY20,"export_turnover_FY19"=>$export_turnover_FY19,"export_turnover_FY18"=>$export_turnover_FY18,"share_of_turnover_FY20"=>$share_of_turnover_FY20,"share_of_turnover_FY19"=>$share_of_turnover_FY19,"share_of_turnover_FY18"=>$share_of_turnover_FY18,"no_of_clients_FY20"=>$no_of_clients_FY20,"no_of_clients_FY19"=>$no_of_clients_FY19,"no_of_clients_FY18"=>$no_of_clients_FY18));
$areas_of_excellence = serialize(array("area1"=>$area1,"isArea1"=>$isArea1,"initiatives1"=>$initiatives1,"impact1"=>$impact1,
"area2"=>$area2,"isArea2"=>$isArea2,"initiatives2"=>$initiatives2,"impact2"=>$impact2,
"area3"=>$area3,"isArea3"=>$isArea3,"initiatives3"=>$initiatives3,"impact3"=>$impact3,
"area4"=>$area4,"isArea4"=>$isArea4,"initiatives4"=>$initiatives4,"impact4"=>$impact4,
"area5"=>$area5,"isArea5"=>$isArea5,"initiatives5"=>$initiatives5,"impact5"=>$impact5,
"area6"=>$area6,"isArea6"=>$isArea6,"initiatives6"=>$initiatives6,"impact6"=>$impact6,
"area7"=>$area7,"isArea7"=>$isArea7,"initiatives7"=>$initiatives7,"impact7"=>$impact7
));
$reg_id = $_SESSION["reg_id"];
// Loop through each file in files[] array
foreach ($_FILES['attatchment']['tmp_name'] as $key => $value) {

$file_tmpname = $_FILES['attatchment']['tmp_name'][$key];
$file_name = $_FILES['attatchment']['name'][$key];
$file_name = str_replace(" ","_",$file_name);
$file_name = time().'_'.$file_name;
$attatchment[] = $file_name;
$file_size = $_FILES['attatchment']['size'][$key];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

// Set upload file path
$filepath = $upload_dir.$file_name;

// Check file type is allowed or not
if(in_array(strtolower($file_ext), $allowed_types)) {

// Verify file size - 2MB max
if ($file_size > $maxsize)
$signup_error="Error: File size is larger than the allowed limit.";

// If file with name already exist then append time in
// front of name of the file to avoid overwriting of file

$filepath = $upload_dir.$file_name;

if( move_uploaded_file($file_tmpname, $filepath)) {


$signup_error="all_uploaded";
}
else {
$signup_error= "Error uploading {$file_name} <br />";
}


}
else {

// If file extention not valid
$signup_error= "Error uploading {$file_name} ";
$signup_error= "({$file_ext} file type is not allowed)<br / >";
}
}


$attatchments = serialize(array("attatchments"=>$attatchment));
$sql_digital_initiative = "INSERT INTO igja_theme_based_digital_initiative SET reg_id='$reg_id',year_of_launch='$year_of_launch',turnover_through_digital_platform='$turnover_through_digital_platform',areas_of_excellence='$areas_of_excellence',attatchments='$attatchments'";
$result = $conn->query($sql_digital_initiative);
$_SESSION['theme_based_award_category'] = array_values(array_diff($_SESSION['theme_based_award_category'], array("Best Digital Initiative (Part D)")));
$step = "qualitative_information";
$_SESSION['step'] = $step;

}

if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="socially_responsible" && $_SESSION["reg_id"] !=""){
    $reg_id = $_SESSION["reg_id"];
    $csr_exp_amount_FY20 = filter($_POST['csr_exp_amount_FY20']);
    $csr_exp_amount_FY19 = filter($_POST['csr_exp_amount_FY19']);
    $csr_exp_amount_FY18 = filter($_POST['csr_exp_amount_FY18']);
    $csr_exp_amount_spent_directly_FY20 = filter($_POST['csr_exp_amount_spent_directly_FY20']);
    $csr_exp_amount_spent_directly_FY19 = filter($_POST['csr_exp_amount_spent_directly_FY19']);
    $csr_exp_amount_spent_directly_FY18 = filter($_POST['csr_exp_amount_spent_directly_FY18']);
    $csr_exp_amount_through_trust_FY20 = filter($_POST['csr_exp_amount_through_trust_FY20']);
    $csr_exp_amount_through_trust_FY19 = filter($_POST['csr_exp_amount_through_trust_FY19']);
    $csr_exp_amount_through_trust_FY18 = filter($_POST['csr_exp_amount_through_trust_FY18']);
$csr_details = filter($_POST['csr_details']);
$trust_ngo_details = filter($_POST['trust_ngo_details']);
$no_of_employee_FY20 = filter($_POST['no_of_employee_FY20']);
$no_of_employee_FY19 = filter($_POST['no_of_employee_FY19']);
$no_of_employee_FY18 = filter($_POST['no_of_employee_FY18']);
$awards_accolades_details = filter($_POST['awards_accolades_details']);
$csr_activities = serialize(array("csr_exp_amount_FY20"=>$csr_exp_amount_FY20,"csr_exp_amount_FY19"=>$csr_exp_amount_FY19,"csr_exp_amount_FY18"=>$csr_exp_amount_FY18,"csr_exp_amount_spent_directly_FY20"=>$csr_exp_amount_spent_directly_FY20,"csr_exp_amount_spent_directly_FY19"=>$csr_exp_amount_spent_directly_FY19,"csr_exp_amount_spent_directly_FY18"=>$csr_exp_amount_spent_directly_FY18,"csr_exp_amount_through_trust_FY20"=>$csr_exp_amount_through_trust_FY20,"csr_exp_amount_through_trust_FY19"=>$csr_exp_amount_through_trust_FY19,"csr_exp_amount_through_trust_FY18"=>$csr_exp_amount_through_trust_FY18));
$employee_details = serialize(array("no_of_employee_FY20"=>$no_of_employee_FY20,"no_of_employee_FY19"=>$no_of_employee_FY19,"no_of_employee_FY18"=>$no_of_employee_FY18));
// Loop through each file in files[] array
foreach ($_FILES['attatchment']['tmp_name'] as $key => $value) {

$file_tmpname = $_FILES['attatchment']['tmp_name'][$key];
$file_name = $_FILES['attatchment']['name'][$key];
$file_name = str_replace(" ","_",$file_name);
$file_name = time().'_'.$file_name;
$attatchment[] = $file_name;
$file_size = $_FILES['attatchment']['size'][$key];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

// Set upload file path
$filepath = $upload_dir.$file_name;

// Check file type is allowed or not
if(in_array(strtolower($file_ext), $allowed_types)) {

// Verify file size - 2MB max
if ($file_size > $maxsize)
$signup_error="Error: File size is larger than the allowed limit.";

// If file with name already exist then append time in
// front of name of the file to avoid overwriting of file

$filepath = $upload_dir.$file_name;

if( move_uploaded_file($file_tmpname, $filepath)) {


$signup_error="all_uploaded";
}
else {
$signup_error= "Error uploading {$file_name} <br />";
}


}
else {

// If file extention not valid
$signup_error= "Error uploading {$file_name} ";
$signup_error= "({$file_ext} file type is not allowed)<br / >";
}
}


$attatchments = serialize(array("attatchments"=>$attatchment));
$sql_socially_responsible = "INSERT INTO igja_theme_base_socially_responsible SET reg_id='$reg_id',csr_activities='$csr_activities',csr_details='$csr_details',trust_ngo_details='$trust_ngo_details',employee_details='$employee_details',awards_accolades_details='$awards_accolades_details',created_at='$created_at',attatchments='$attatchments'";
$result = $conn->query($sql_socially_responsible);
$_SESSION['theme_based_award_category'] = array_values(array_diff($_SESSION['theme_based_award_category'], array("Most Socially Responsible Company (Part C)")));

$step = "qualitative_information";
$_SESSION['step'] = $step;
}
if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="woman_entrepreneur" && $_SESSION["reg_id"] !=""){
    $reg_id = $_SESSION["reg_id"];
    $entrepreneur_name = filter($_POST['entrepreneur_name']);
    $no_of_years_in_business = filter($_POST['no_of_years_in_business']);
    $current_designation = filter($_POST['current_designation']);
    $prev_management_details = filter($_POST['prev_management_details']);
    $details_of_inititative_taken = filter($_POST['details_of_inititative_taken']);
    $details_of_past_engagements = filter($_POST['details_of_past_engagements']);
    $contribution_to_innovation = filter($_POST['contribution_to_innovation']);
    $awards_accolades_details = filter($_POST['awards_accolades_details']);
    $sql_woman_entrepreneur = "INSERT INTO igja_theme_based_woman_entrepreneur SET reg_id='$reg_id',entrepreneur_name='$entrepreneur_name',no_of_years_in_business='$no_of_years_in_business',current_designation='$current_designation',prev_management_details='$prev_management_details',details_of_inititative_taken='$details_of_inititative_taken',details_of_past_engagements='$details_of_past_engagements',contribution_to_innovation='$contribution_to_innovation',awards_accolades_details='$awards_accolades_details',created_at='$created_at'";
    $result = $conn->query($sql_woman_entrepreneur);
    $_SESSION['theme_based_award_category'] = array_values(array_diff($_SESSION['theme_based_award_category'], array("Woman Entrepreneur of the Year (Part E)")));
    $step = "qualitative_information";
$_SESSION['step'] = $step;
}
if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="award_cat_specific_info" && $_SESSION["reg_id"] !=""){
    $reg_id = $_SESSION["reg_id"];
    $product_segment_FY20 = serialize(array("product_segment"=>$_POST['product_segment_FY20'],"isApplicable"=>$_POST['check_applicable_FY20'],"total_sales"=>$_POST['total_sales_FY20'],"domestic_sales"=>$_POST['domestic_sales_FY20'],"export_sales"=>$_POST['export_sales_FY20'],"net_profit"=>$_POST['net_profit_FY20'],"value_addition"=>$_POST['value_addition_FY20'],"calc_value_addition"=>$_POST['calc_value_addition_FY20']));
    $product_segment_FY19 = serialize(array("product_segment"=>$_POST['product_segment_FY19'],"isApplicable"=>$_POST['check_applicable_FY19'],"total_sales"=>$_POST['total_sales_FY19'],"domestic_sales"=>$_POST['domestic_sales_FY19'],"export_sales"=>$_POST['export_sales_FY19'],"net_profit"=>$_POST['net_profit_FY19'],"value_addition"=>$_POST['value_addition_FY19'],"calc_value_addition"=>$_POST['calc_value_addition_FY19']));
    $product_segment_FY18 = serialize(array("product_segment"=>$_POST['product_segment_FY18'],"isApplicable"=>$_POST['check_applicable_FY18'],"total_sales"=>$_POST['total_sales_FY18'],"domestic_sales"=>$_POST['domestic_sales_FY18'],"export_sales"=>$_POST['export_sales_FY18'],"net_profit"=>$_POST['net_profit_FY18'],"value_addition"=>$_POST['value_addition_FY18'],"calc_value_addition"=>$_POST['calc_value_addition_FY18']));
    $award_cat_specific_info = "INSERT INTO igja_industry_performance_award_category_info SET reg_id='$reg_id',product_segment_FY20='$product_segment_FY20',product_segment_FY19='$product_segment_FY19',product_segment_FY18='$product_segment_FY18',created_at='$created_at'";
    $result = $conn->query($award_cat_specific_info);

$step = "award_cat_specific_info";

$_SESSION['step'] = $step;
}
if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="best_growing_perfomance" && $_SESSION["reg_id"] !=""){
    $reg_id = $_SESSION["reg_id"];
    $export_details = serialize(array("export_questions"=>$_POST['export_questions'],"export_details_FY20"=>$_POST['export_details_FY20'],"export_details_FY19"=>$_POST['export_details_FY19'],"export_details_FY18"=>$_POST['export_details_FY18']));
$export_country_details_FY20 = serialize(array("country_FY20"=>$_POST['country_FY20'],"export_sales_rs_FY20"=>$_POST['export_sales_rs_FY20'],"export_sales_dollar_FY20"=>$_POST['export_sales_dollar_FY20']));
$export_country_details_FY19 = serialize(array("country_FY19"=>$_POST['country_FY19'],"export_sales_rs_FY19"=>$_POST['export_sales_rs_FY19'],"export_sales_dollar_FY19"=>$_POST['export_sales_dollar_FY19']));
$business_details_and_explanation = filter($_POST['business_details_and_explanation']);
$key_insights = filter($_POST['key_insights']);

// Loop through each file in files[] array
foreach ($_FILES['attatchment']['tmp_name'] as $key => $value) {

$file_tmpname = $_FILES['attatchment']['tmp_name'][$key];
$file_name = $_FILES['attatchment']['name'][$key];
$file_name = str_replace(" ","_",$file_name);
$file_name = time().'_'.$file_name;
$attatchment[] = $file_name;
$file_size = $_FILES['attatchment']['size'][$key];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

// Set upload file path
$filepath = $upload_dir.$file_name;

// Check file type is allowed or not
if(in_array(strtolower($file_ext), $allowed_types)) {

// Verify file size - 2MB max
if ($file_size > $maxsize)
$signup_error="Error: File size is larger than the allowed limit.";

// If file with name already exist then append time in
// front of name of the file to avoid overwriting of file

$filepath = $upload_dir.$file_name;

if( move_uploaded_file($file_tmpname, $filepath)) {


$signup_error="all_uploaded";
}
else {
$signup_error= "Error uploading {$file_name} <br />";
}


}
else {

// If file extention not valid
$signup_error= "Error uploading {$file_name} ";
$signup_error= "({$file_ext} file type is not allowed)<br / >";
}
}


$attatchments = serialize(array("attatchments"=>$attatchment));
$best_growing_perfomance = "INSERT INTO igja_industry_performance_best_growing_performance SET reg_id='$reg_id',export_details='$export_details',export_country_details_FY20='$export_country_details_FY20',export_country_details_FY19='$export_country_details_FY19',business_details_and_explanation='$business_details_and_explanation',key_insights='$key_insights',created_at='$created_at',attatchments='$attatchments'";
$result = $conn->query($best_growing_perfomance);

$step = "best_growing_perfomance";

$_SESSION['step'] = $step;

}
if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="qualitative_information" && $_SESSION["reg_id"] !=""){
    $reg_id = $_SESSION["reg_id"];
    $business_details_and_explanation = filter($_POST["business_details_and_explanation"]);
    $strategic_export_initiative = filter($_POST["strategic_export_initiative"]);
    $case_of_excellence = filter($_POST["case_of_excellence"]);
    $nominated_segment = filter($_POST["nominated_segment"]);
    $mandatory_details = filter($_POST["mandatory_details"]);
    $is_mandatory = filter($_POST["is_mandatory"]);
// Loop through each file in files[] array
foreach ($_FILES['attatchment']['tmp_name'] as $key => $value) {

$file_tmpname = $_FILES['attatchment']['tmp_name'][$key];
$file_name = $_FILES['attatchment']['name'][$key];
$file_name = str_replace(" ","_",$file_name);
$file_name = time().'_'.$file_name;
$attatchment[] = $file_name;
$file_size = $_FILES['attatchment']['size'][$key];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

// Set upload file path
$filepath = $upload_dir.$file_name;

// Check file type is allowed or not
if(in_array(strtolower($file_ext), $allowed_types)) {

// Verify file size - 2MB max
if ($file_size > $maxsize)
$signup_error="Error: File size is larger than the allowed limit.";

// If file with name already exist then append time in
// front of name of the file to avoid overwriting of file

$filepath = $upload_dir.$file_name;

if( move_uploaded_file($file_tmpname, $filepath)) {


$signup_error="all_uploaded";
}
else {
$signup_error= "Error uploading {$file_name} <br />";
}


}
else {

// If file extention not valid
$signup_error= "Error uploading {$file_name} ";
$signup_error= "({$file_ext} file type is not allowed)<br / >";
}
}


$attatchments = serialize(array("attatchments"=>$attatchment));
$qualitative_information = "INSERT INTO igja_industry_perfomance_qualitative_info SET reg_id='$reg_id',business_details_and_explanation='$business_details_and_explanation',strategic_export_initiative='$strategic_export_initiative',case_of_excellence='$case_of_excellence',nominated_segment='$nominated_segment',mandatory_details='$mandatory_details',is_mandatory='$is_mandatory',created_at='$created_at',attatchments='$attatchments'";
    $result = $conn->query($qualitative_information);

$step = "qualitative_information";
$_SESSION['step'] = $step;
}

if(isset($_POST) && isset($_POST['action']) && $_POST['action']=="declaration" && $_SESSION["reg_id"] !=""){
        $reg_id = $_SESSION["reg_id"];
$respondant_name = filter($_POST["respondant_name"]);
$designation = filter($_POST["designation"]);
$mobile = filter($_POST["mobile"]);
$email_id = filter($_POST["email_id"]);
$ca_firm_name = filter($_POST["ca_firm_name"]);
$ca_name = filter($_POST["ca_name"]);
$ca_designation = filter($_POST["ca_designation"]);
$ca_mobile = filter($_POST["ca_mobile"]);
$ca_email = filter($_POST["ca_email"]);
// Loop through each file in files[] array
foreach ($_FILES['attatchment']['tmp_name'] as $key => $value) {

$file_tmpname = $_FILES['attatchment']['tmp_name'][$key];
$file_name = $_FILES['attatchment']['name'][$key];
$file_name = str_replace(" ","_",$file_name);
$file_name = time().'_'.$file_name;
$attatchment[] = $file_name;
$file_size = $_FILES['attatchment']['size'][$key];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

// Set upload file path
$filepath = $upload_dir.$file_name;

// Check file type is allowed or not
if(in_array(strtolower($file_ext), $allowed_types)) {

// Verify file size - 2MB max
if ($file_size > $maxsize)
$signup_error="Error: File size is larger than the allowed limit.";

// If file with name already exist then append time in
// front of name of the file to avoid overwriting of file

$filepath = $upload_dir.$file_name;

if( move_uploaded_file($file_tmpname, $filepath)) {


$signup_error="all_uploaded";
}
else {
$signup_error= "Error uploading {$file_name} <br />";
}


}
else {

// If file extention not valid
$signup_error= "Error uploading {$file_name} ";
$signup_error= "({$file_ext} file type is not allowed)<br / >";
}
}


$attatchments = serialize(array("attatchments"=>$attatchment));
$qualitative_information = "INSERT INTO igja_industry_performance_declaration SET reg_id='$reg_id',respondant_name='$respondant_name',designation='$designation',mobile='$mobile',email_id='$email_id',ca_firm_name='$ca_firm_name',ca_name='$ca_name',ca_designation='$ca_designation',ca_mobile='$ca_mobile',ca_email='$ca_email',created_at='$created_at',attatchments='$attatchments'";
        $result = $conn->query($qualitative_information);
        $date = date("jS F Y ");
        $sql_info = "SELECT * FROM igja_industry_performance_and_theme_based_awards where id='$reg_id'";
        $result_info = $conn->query($sql_info);
        $row_info =  $result_info->fetch_assoc();
$company_name =$row_info['company_name'];
$company_email_id =$row_info['email_id'];
        $html ='<table width="80%" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
    <tbody>
        
        <tr>
            <td align="left"><img src="http://www.gjepc.org/images/gjepc_logo.png"></td>
        </tr>
        
        <tr>
            <td colspan="3" height="30"><hr></td>
        </tr>
        
        <tr>
            
            <td colspan="3" id="content">
                
                <table width="100%">
                    
                    <tr>
                        
                        <td align="right"> <strong> '.$date.'</strong> </td>
                    </tr>
                </table>
                
                <p style="line-height:22px;">Dear '.$company_name.',</p>
                <p style="line-height:22px;"> Your Application Submitted Successfully</p>
                
                
                <p style="line-height:22px;">Thanking you.</p>
                <p style="line-height:22px;">Yours faithfully,</p>
                <p style="line-height:22px;"><strong>Team GJEPC.</strong></p>
                
            </td>
            
        </tr>
        
        
        <tr>
            <td colspan="3" height="30"><hr></td>
        </tr>
        
        <tr>
            <td align="center" colspan="3">
                
                <img src="https://www.gjepc.org/images/gjepc_logo.png">
                
                <p style="line-height:22px;">
                    <b>The Gem &amp; Jewellery Export Promotion Council</b><br>Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400051
                    <br> Tel + 9122 43541800 Fax +9122 26524769  <br> Website: <a href="https://www.gjepc.org/" target="_blank">https://www.gjepc.org/ </a>
                </p>
                
                <table cellpadding="5">
                    <tr>
                        <td> <a href="https://www.facebook.com/GJEPC" target="_blank"> <img src="https://gjepc.org/download/icon/fb.png" /> </a> </td>
                        <td> <a href="https://twitter.com/GJEPCIndia" target="_blank"> <img src="https://gjepc.org/download/icon/tw.png" /> </a> </td>
                        <td> <a href="https://www.instagram.com/gjepcindia/" target="_blank"> <img src="https://gjepc.org/download/icon/insta.png" /> </a> </td>
                        <td> <a href="https://www.linkedin.com/in/sabyaray/" target="_blank"> <img src="https://gjepc.org/download/icon/li.png" /> </a> </td>
                    </tr>
                </table>
                
            </td>
        </tr>
        
    </tbody>
    
</table>';
$to = $company_email_id;
$subject = "IGJA AWARDS REGISTRATION";
$headers  = 'MIME-Version: 1.0' . "\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
$headers .= 'From: GJEPC <admin@gjepc.org>';
    // $headers .= 'Cc: raksha@gjepcindia.com\r\n';
    mail($to, $subject, $html, $headers);
        
        $step = "declaration";
        
        $_SESSION['step'] = $step;
    }
    
    if(isset($_REQUEST['form-reset']) && $_REQUEST['form-reset'] !="" && $_REQUEST['form-reset']=="yes" ){
        unset($_SESSION['step']);
        unset($_SESSION['reg_id']);
        unset($_SESSION['theme_based_award_category']);
        header("Location: https://gjepc.org/igja-form1.php");
    }
    
    
    ?>
    
    <section class="py-5">
        <div class="container">
            
            <div class="mb-4">
                
                <div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div> Nomination Form - <span>Council Members</span> </div>
                
                <p class="text-center"> <strong> Last date for submission is <span style="background:#a89c5d; color:#fff; padding:3px;"> 10th May, 2022 </span> </strong> </p>
                
            </div>
            <?php  $theme_based_award_category =  $_SESSION['theme_based_award_category']; ?>
            <div class="row mb grid_gallery nomination_container">
                
<div class="col-12" id="nav">
                    
    <ul id="tabs" class="nav nav-tabs justify-content-center d-flex" role="tablist">
                            
        <li class="nav-item">
            <a id="tab-A" href="#pane-A" class="nav-link <?php if( $_SESSION['step'] ==""){ echo "active";}else{echo "disabled";}?> " data-toggle="tab" role="tab">General Information</a>
        </li>

        <li class="nav-item">
            <a id="tab-B" href="#pane-B" class="nav-link <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="general_info"){
        echo "active";}else{ echo "disabled";}?>" data-toggle="tab" role="tab">Award Category Specific Information</a>
        </li>

        <li class="nav-item">
            <a id="tab-C" href="#pane-C" class="nav-link <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="award_cat_specific_info"){
        echo "active";}else{ echo "disabled";}?>" data-toggle="tab" role="tab"> Export Related Information </a>
        </li>


        <li class="nav-item">
            <a id="tab-D" href="#pane-D" class="nav-link <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="best_growing_perfomance"){
        echo "active";}else{ echo "disabled";}?>" data-toggle="tab" role="tab">Quality Information</a>
        </li>

        <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="qualitative_information"){
        $reg_id = $_SESSION['reg_id'];

        // $get_theme_based_award_category = "SELECT theme_based_award_category FROM igja_industry_performance_and_theme_based_awards WHERE id='$reg_id'";
        // $result = $conn->query($get_theme_based_award_category);
        // $getCategoryCount = $result->num_rows;
        // $rowThemeBasedCategory =  $result->fetch_assoc();
        // $theme_based_award_category = explode("_",$rowThemeBasedCategory['theme_based_award_category']);
        if(in_array("Most Innovative Company (Part B)", $theme_based_award_category)){?>

        <li class="nav-item">
            <a id="tab-F" href="#pane-F" class="nav-link <?php if($theme_based_award_category[0]=="Most Innovative Company (Part B)"){echo "active";}else{echo "disabled";}?> " data-toggle="tab" role="tab">Innovative Company</a>
        </li>
        <?php  }?>

        <?php   if(in_array("Best Digital Initiative (Part D)", $theme_based_award_category)){?>

        <li class="nav-item">
            <a id="tab-H" href="#pane-H"  class="nav-link <?php if($theme_based_award_category[0]=="Best Digital Initiative (Part D)"){echo "active";}else{echo "disabled";}?>" data-toggle="tab" role="tab">Best Digital Initiative</a>
        </li>

        <?php  } ?>

        <?php if(in_array("Most Socially Responsible Company (Part C)", $theme_based_award_category)){ ?>

        <li class="nav-item">
            <a id="tab-G" href="#pane-G"  class="nav-link <?php if($theme_based_award_category[0]=="Most Socially Responsible Company (Part C)"){echo "active";}else{echo "disabled";}?>" data-toggle="tab" role="tab"> Innovative Company</a>
        </li>

        <?php  } ?>

        <?php  if(in_array("Woman Entrepreneur of the Year (Part E)", $theme_based_award_category)){?>
        <li class="nav-item">
            <a id="tab-I" href="#pane-I" class="nav-link  <?php if($theme_based_award_category[0]=="Woman Entrepreneur of the Year (Part E)"){echo "active";}else{echo "disabled";}?>" data-toggle="tab" role="tab">Woman Entrepreneur of the Year</a>
        </li>
        <?php  }
        }?>


        <li class="nav-item">
            <a id="tab-E" href="#pane-E" class="nav-link <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="qualitative_information"  && empty($_SESSION['theme_based_award_category'])){
        echo "active";}else{ echo "disabled";}?>" data-toggle="tab" role="tab">Declaration</a>
        </li>

        <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="declaration"){?>

        <li class="nav-item">
            <a id="tab-J" href="#pane-J" class="nav-link " data-toggle="tab" role="tab"></a>
        </li>
        <?php }?>

    </ul>
                    
</div>



<div id="content" class="col-12 tab-content" role="tablist">
                    
    <div id="pane-A" class="card tab-pane fade <?php if($_SESSION['step']==""){ echo "show active";}else{echo "hide";}?> " role="tabpanel" aria-labelledby="tab-A">
                        
        <div class="card-header" role="tab" id="heading-A">
            <h5 class="mb-0">
                <a data-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">General Information</a>
            </h5>
        </div>
        
        <div id="collapse-A" class="collapse show" data-parent="#content" role="tabpanel" aria-labelledby="heading-A">
                            
            <div class="card-body p-0">
                                
                <form class="box-shadow" method="POST" name="general_info" id="general_info" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">
                                    
                    <div class="row">

                        <div class="form-group col-12">
                            <?php  if(isset($signup_error)){ echo "<div class='alert alert-danger' role='alert'>".$signup_error.'</div>';} ?>
                        </div>

                        <div class="form-group col-12"> 
                            <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> 
                                <strong>Basic Information</strong>
                            </p> 
                        </div>
                                        
                        <div class="form-group col-4">
                            <label>Company Name*</label>
                            <input type="text"  name='company_name' id="company_name" value="<?php echo $company_name;?>" class="form-control">
                        </div>
                                        
                        <div class="form-group col-4">
                            <label>Year of Establishment*</label>
                            <select name="year" class="form-control">
                                <option value="">Select</option>
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
                                <option value="2017">2017</option>
                                <option value="2015">2015</option>
                                <option value="2014">2014</option>
                                <option value="2013">2013</option>
                                <option value="2012">2012</option>
                                <option value="2011">2011</option>
                                <option value="2010">2010</option>
                                <option value="2009">2009</option>
                                <option value="2008">2008</option>
                                <option value="2007">2007</option>
                                <option value="2006">2006</option>
                                <option value="2005">2005</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>
                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>
                                <option value="1989">1989</option>
                                <option value="1988">1988</option>
                                <option value="1987">1987</option>
                                <option value="1986">1986</option>
                                <option value="1985">1985</option>
                                <option value="1984">1984</option>
                                <option value="1983">1983</option>
                                <option value="1982">1982</option>
                                <option value="1981">1981</option>
                                <option value="1980">1980</option>
                                <option value="1979">1979</option>
                                <option value="1978">1978</option>
                                <option value="1977">1977</option>
                                <option value="1976">1976</option>
                                <option value="1975">1975</option>
                                <option value="1974">1974</option>
                                <option value="1973">1973</option>
                                <option value="1972">1972</option>
                                <option value="1971">1971</option>
                                <option value="1970">1970</option>
                                <option value="1969">1969</option>
                                <option value="1968">1968</option>
                                <option value="1967">1967</option>
                                <option value="1966">1966</option>
                                <option value="1965">1965</option>
                                <option value="1964">1964</option>
                                <option value="1963">1963</option>
                                <option value="1962">1962</option>
                                <option value="1961">1961</option>
                                <option value="1960">1960</option>
                                <option value="1959">1959</option>
                                <option value="1958">1958</option>
                                <option value="1957">1957</option>
                                <option value="1956">1956</option>
                                <option value="1955">1955</option>
                                <option value="1954">1954</option>
                                <option value="1953">1953</option>
                                <option value="1952">1952</option>
                                <option value="1951">1951</option>
                                <option value="1950">1950</option>
                                <option value="1949">1949</option>
                                <option value="1948">1948</option>
                                <option value="1947">1947</option>
                                <option value="1946">1946</option>
                                <option value="1945">1945</option>
                                <option value="1944">1944</option>
                                <option value="1943">1943</option>
                                <option value="1942">1942</option>
                                <option value="1941">1941</option>
                                <option value="1940">1940</option>
                                <option value="1938">1938</option>
                                <option value="1937">1937</option>
                                <option value="1936">1936</option>
                                <option value="1935">1935</option>
                                <option value="1934">1934</option>
                                <option value="1933">1933</option>
                                <option value="1932">1932</option>
                                <option value="1931">1931</option>
                                <option value="1930">1930</option>
                                <option value="1929">1929</option>
                                <option value="1928">1928</option>
                                <option value="1927">1927</option>
                                <option value="1926">1926</option>
                                <option value="1925">1925</option>
                                <option value="1924">1924</option>
                                <option value="1923">1923</option>
                                <option value="1922">1922</option>
                            </select>
                        </div>
                                        
                        <div class="form-group col-4">
                            <label>Importer Exporter Code No.*</label>
                            <input type="text" name="imp_exp_code" id="imp_exp_code" value="<?php echo $imp_exp_code;?>" class="form-control">
                        </div>
                                        
                        <div class="form-group col-4">
                            <label>Tel No.*</label>
                            <input type="number" name="tel_no" id="tel_no" value="<?php echo $tel_no;?>"  class="form-control numeric">
                        </div>
                                        
                        <div class="form-group col-4">
                            <label>Email ID*</label>
                            <input type="text" name="email_id" id="email_id" value="<?php echo $email_id;?>" class="form-control">
                        </div>
                        
                        <div class="form-group col-4">
                            <label>Website</label>
                            <input type="text" name="website" id="website" value="<?php echo $website;?>" class="form-control">
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label>Address*</label>
                            <textarea class="form-control" name="address_line_1" id="address_line_1" value="<?php echo $address_line_1;?>"  ></textarea>
                        </div>
                                        
                        <div class="form-group col-sm-6">
                            <label>Address Line 2 (optional) </label>
                            <textarea class="form-control" name="address_line_2" id="address_line_2" value="<?php echo $address_line_1;?>"></textarea>
                        </div>
                        
                        <div class="form-group col-4">
                            <label>City*</label>
                            <input type="text" name="city" id="city" value="<?php echo $city;?>" class="form-control">
                        </div>
                        
                        <div class="form-group col-4">
                            <label>State*</label>
                            <select name="state" id="state" class="form-control">
                                <option value="0">Select</option>
                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                <option value="Assam">Assam</option>
                                <option value="Bihar">Bihar</option>
                                <option value="Chandigarh">Chandigarh</option>
                                <option value="Chhattisgarh">Chhattisgarh</option>
                                <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                                <option value="Daman and Diu">Daman and Diu</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Lakshadweep">Lakshadweep</option>
                                <option value="Puducherry">Puducherry</option>
                                <option value="Goa">Goa</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Haryana">Haryana</option>
                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                <option value="Jharkhand">Jharkhand</option>
                                <option value="Karnataka">Karnataka</option>
                                <option value="Kerala">Kerala</option>
                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Manipur">Manipur</option>
                                <option value="Meghalaya">Meghalaya</option>
                                <option value="Mizoram">Mizoram</option>
                                <option value="Nagaland">Nagaland</option>
                                <option value="Odisha">Odisha</option>
                                <option value="Punjab">Punjab</option>
                                <option value="Rajasthan">Rajasthan</option>
                                <option value="Sikkim">Sikkim</option>
                                <option value="Tamil Nadu">Tamil Nadu</option>
                                <option value="Telangana">Telangana</option>
                                <option value="Tripura">Tripura</option>
                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                <option value="Uttarakhand">Uttarakhand</option>
                                <option value="West Bengal">West Bengal</option>
                            </select>
                        </div>
                                        
                        <div class="form-group col-4">
                            <label>Zipcode*</label>
                            <input type="text" name="zipcode" id="zipcode" value="<?php echo $zipcode;?>" class="form-control">
                        </div>
                        
                        <div class="form-group col-4">
                            <label>GJEPC Membership Registration*</label>
                            <input type="text" name="membership_no" id="membership_no" value="<?php echo $membership_no;?>" class="form-control">
                        </div>
                        
                        <div class="form-group col-4">
                            <label>Year of acquiring GJEPC Membership*</label>
                            <select name="membership_year" id="membership_year" class="form-control">
                                <option value="">Select</option>
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
                                <option value="2017">2017</option>
                                <option value="2015">2015</option>
                                <option value="2014">2014</option>
                                <option value="2013">2013</option>
                                <option value="2012">2012</option>
                                <option value="2011">2011</option>
                                <option value="2010">2010</option>
                                <option value="2009">2009</option>
                                <option value="2008">2008</option>
                                <option value="2007">2007</option>
                                <option value="2006">2006</option>
                                <option value="2005">2005</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>
                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>
                                <option value="1989">1989</option>
                                <option value="1988">1988</option>
                                <option value="1987">1987</option>
                                <option value="1986">1986</option>
                                <option value="1985">1985</option>
                                <option value="1984">1984</option>
                                <option value="1983">1983</option>
                                <option value="1982">1982</option>
                                <option value="1981">1981</option>
                                <option value="1980">1980</option>
                                <option value="1979">1979</option>
                                <option value="1978">1978</option>
                                <option value="1977">1977</option>
                                <option value="1976">1976</option>
                                <option value="1975">1975</option>
                                <option value="1974">1974</option>
                                <option value="1973">1973</option>
                                <option value="1972">1972</option>
                                <option value="1971">1971</option>
                                <option value="1970">1970</option>
                                <option value="1969">1969</option>
                                <option value="1968">1968</option>
                                <option value="1967">1967</option>
                                <option value="1966">1966</option>
                                <option value="1965">1965</option>
                                <option value="1964">1964</option>
                                <option value="1963">1963</option>
                                <option value="1962">1962</option>
                                <option value="1961">1961</option>
                                <option value="1960">1960</option>
                                <option value="1959">1959</option>
                                <option value="1958">1958</option>
                                <option value="1957">1957</option>
                                <option value="1956">1956</option>
                                <option value="1955">1955</option>
                                <option value="1954">1954</option>
                                <option value="1953">1953</option>
                                <option value="1952">1952</option>
                                <option value="1951">1951</option>
                                <option value="1950">1950</option>
                                <option value="1949">1949</option>
                                <option value="1948">1948</option>
                                <option value="1947">1947</option>
                                <option value="1946">1946</option>
                                <option value="1945">1945</option>
                                <option value="1944">1944</option>
                                <option value="1943">1943</option>
                                <option value="1942">1942</option>
                                <option value="1941">1941</option>
                                <option value="1940">1940</option>
                                <option value="1938">1938</option>
                                <option value="1937">1937</option>
                                <option value="1936">1936</option>
                                <option value="1935">1935</option>
                                <option value="1934">1934</option>
                                <option value="1933">1933</option>
                                <option value="1932">1932</option>
                                <option value="1931">1931</option>
                                <option value="1930">1930</option>
                                <option value="1929">1929</option>
                                <option value="1928">1928</option>
                                <option value="1927">1927</option>
                                <option value="1926">1926</option>
                                <option value="1925">1925</option>
                                <option value="1924">1924</option>
                                <option value="1923">1923</option>
                                <option value="1922">1922</option>
                            </select>
                        </div>
                                        
                        <div class="form-group col-sm-12">
                            <label for=""><strong>Ownership Pattern*</strong></label>
                            <div class="mt-2">
                                <label for="" generated="true" style="display: none;" class="error">Please Select Company type</label>
                                <label for="Propritory" class="mr-3">
                                    <input type="radio" id="Proprietary" name="company_type" value="Proprietary" <?php if($company_type =="Proprietary"){ echo "checked";}?> class="mr-2">Proprietary
                                </label>
                                <label for="Partnership" class="mr-3">
                                    <input type="radio" id="Partnership" name="company_type" value="Partnership" <?php if($company_type =="Partnership"){ echo "checked";}?>  class="mr-2">Partnership
                                </label>
                                <label for="Private" class="mr-3">
                                    <input type="radio" id="Private" <?php if($company_type =="Private Ltd"){ echo "checked";}?> name="company_type" value="Private Ltd" class="mr-2">Private Ltd.
                                </label>
                                <label for="Public">
                                    <input type="radio" id="Public" name="company_type" value="Public Ltd" <?php if($company_type =="Public Ltd"){ echo "checked";}?> class="mr-2">Public Ltd.
                                </label>
                                <div class="d-block">
                                    <label for="company_type" generated="true" class="error d-none">Please Select Company Type</label>
                                </div>
                                
                            </div>
                        </div>
                                        
                        <div class="form-group col-sm-12">
                            <label for=""><strong>Nature of Operation*</strong></label>
                            <div class="mt-2">
                                <label for="" generated="true" style="display: none;" class="error">Please Select </label>
                                <label for="Manufacturing" class="mr-3">
                                    <input type="radio" id="Manufacturing" name="nature_of_business" <?php if($nature_of_business =="Manufacturing"){ echo "checked";}?> value="Manufacturing" class="mr-2">Manufacturing
                                </label>
                                <label for="Trading" class="mr-3">
                                    <input type="radio" id="Trading" name="nature_of_business"  <?php if($nature_of_business =="Trading"){ echo "checked";}?> value="Trading" class="mr-2">Trading
                                </label>
                                <label for="Importer" class="mr-3">
                                    <input type="radio" id="Importer" name="nature_of_business" <?php if($nature_of_business =="Importer"){ echo "checked";}?>  value="Importer" class="mr-2">Importer
                                </label>
                                <label for="Exporter">
                                    <input type="radio" id="Exporter" name="nature_of_business" <?php if($nature_of_business =="Exporter"){ echo "checked";}?> value="Exporter" class="mr-2">Exporter
                                </label>
                                <div class="d-block">
                                    <label for="nature_of_business" generated="true" class="error d-none">Please Select Nature of Operation</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                                        
                        <div class="form-group col-12"> 
                            <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Senior Management</strong></p> 
                        </div>
                                        
                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-4">
                                    <label>Title</label>
                                    <select class="form-control" name="sm_title[0]">
                                        <option value="">Select Title</option>
                                        <option <?php if($_POST['sm_title'][0] =="Mr"){ echo "selected";}?>  value="Mr">Mr</option>
                                        <option <?php if($_POST['sm_title'][0] =="Ms"){ echo "selected";}?> value="Ms">Ms</option>
                                        <option <?php if($_POST['sm_title'][0] =="Mrs"){ echo "selected";}?> value="Mrs">Mrs</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>Name</label>
                                    <input type="text" name="sm_name[0]" id="sm_name" value="<?php echo $_POST['sm_name'][0];?>" class="form-control">
                                </div>
                                
                                <div class="form-group col-4">
                                    <label>Designation</label>
                                    <input type="text" name="sm_designation[0]" id="m_designation" value="<?php echo $_POST['sm_designation'][0];?>" class="form-control">
                                </div>
                                
                                
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-4">
                                    <label>Title</label>
                                    <select class="form-control" name="sm_title[]">
                                        <option value="">Select Title</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Mrs">Mrs</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>Name</label>
                                    <input type="text" name="sm_name[]" id="sm_name" class="form-control">
                                </div>
                                
                                <div class="form-group col-4">
                                    <label>Designation</label>
                                    <input type="text" name="sm_designation[]" id="m_designation" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="form-group col-4">
                                    <label>Title</label>
                                    <select class="form-control" name="sm_title[]">
                                        <option value="">Select Title</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Mrs">Mrs</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>Name</label>
                                    <input type="text" name="sm_name[]" id="sm_name" class="form-control">
                                </div>
                                
                                <div class="form-group col-4">
                                    <label>Designation</label>
                                    <input type="text" name="sm_designation[]" id="m_designation" class="form-control">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                                        
                        <div class="form-group col-12"> 
                            <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;">
                                <strong>Please select the appropriate award category/categories under which you would like to be nominated <span><a href="https://www.gjepc.org/igja-guidelines.php" class="blink" style="color:#f00; font-size: 12px" target="_blank"> Click here to Read Guidelines</a></span></strong>
                            </p> 
                        </div>

                        <!-- <div class="col-12 form-group"><p class="pb-2 gold_clr ml-3"></p></div> -->

                        <div class="col-12 form-group">
                            <p><strong>Industry Performance Awards Categories</strong></p>
                        </div>

                        <div class="col-12">
                            
                            <div class="row award_input_box">
                            
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="performance_award_category[]" id="" value="Precious Metal Jewellery - Plain (Large)" <?php if( in_array("Precious Metal Jewellery - Plain (Large)", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Precious Metal Jewellery - Plain (Large)
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Cut & Polished Diamonds (Small)" <?php if( in_array("Cut & Polished Diamonds (Small)", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Cut & Polished Diamonds (Large)
                                    </label>
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Precious Metal Jewellery - Plain (Medium)" <?php if( in_array("Precious Metal Jewellery - Plain (Medium)", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Precious Metal Jewellery - Plain (Medium)
                                    </label>
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="01 Awards  Silver Jewellery">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Silver Jewellery" <?php if( in_array("Silver Jewellery", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Silver Jewellery
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Precious Metal Jewellery - Studded (Large)" <?php if( in_array("Silver Jewellery", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Precious Metal Jewellery - Studded (Large)
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Cut & Polished Coloured Gemstones" <?php if( in_array("Cut & Polished Coloured Gemstones", $_POST['performance_award_category']) ){ echo "checked";}?>>02 Awards <br /> Cut & Polished Coloured Gemstones
                                    </label>
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Precious Metal Jewellery - Studded (Medium)" <?php if( in_array("Precious Metal Jewellery - Studded (Medium)", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Precious Metal Jewellery - Studded (Medium)
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Costume/Fashion Jewellery"  <?php if( in_array("Costume/Fashion Jewellery", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Costume/Fashion Jewellery
                                    </label>
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Cut & Polished Synthetic Stones" <?php if( in_array("Cut & Polished Synthetic Stones", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Cut & Polished Synthetic Stones
                                    </label>
                                </div>
                            
                               <!--  <div class="col-md-6 form-group">
                                    <label for="Retailer">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Cut & Polished Diamonds (Highest Turnover) – (First, Second & Third)"  <?php if( in_array("Cut & Polished Diamonds (Highest Turnover) – (First, Second & Third)", $_POST['performance_award_category']) ){ echo "checked";}?>>03 Awards <br />Cut & Polished Diamonds (Highest Turnover) – (First, Second & Third)
                                    </label>
                                </div> -->

                                <!-- <div class="col-md-6 form-group">
                                    <label for="Retailer">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Sales to Foreign Tourist" <?php if( in_array("Sales to Foreign Tourist", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Sales to Foreign Tourist
                                    </label>
                                </div> -->
                            
                                <!--  <div class="col-md-6 form-group">
                                    <label for="Retailer">
                                        <input type="checkbox" name="performance_award_category[]" id="performance_award_category" value="Cut & Polished Diamonds (Medium)" <?php if( in_array("Cut & Polished Diamonds (Medium)", $_POST['performance_award_category']) ){ echo "checked";}?>>01 Awards <br /> Cut & Polished Diamonds (Medium)
                                    </label>
                                </div> -->

                                <div class="col-12">
                                    <label for="performance_award_category[]" generated="true" class="error d-none">Please Select Any </label>
                                </div>
                            
                            </div>

                        </div>
                                
                        <div class="col-12 form-group">
                            <p><strong>Theme based Award Categories</strong></p>
                        </div>

                        <div class="col-12">

                            <div class="row award_input_box">
                                
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Most Innovative Company (Part B)" <?php if( in_array("Most Innovative Company (Part B)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>01 Awards <br> Most Innovative Company (Part B)
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Best Digital Initiative (Part D)" <?php if( in_array("Best Digital Initiative (Part D)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>01 Awards <br> Best Digital Initiative (Part D)
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Woman Entrepreneur of the Year (Part E)" <?php if( in_array("Woman Entrepreneur of the Year (Part E)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>01 Awards <br> Woman Entrepreneur of the Year (Part E)
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Woman Entrepreneur of the Year (Part E)" <?php if( in_array("Woman Entrepreneur of the Year (Part E)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>01 Awards <br> Corporate Social Responsibility (CSR) Award
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Woman Entrepreneur of the Year (Part E)" <?php if( in_array("Woman Entrepreneur of the Year (Part E)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>01 Awards <br> Innovation in Marketing Award
                                    </label>
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Most Socially Responsible Company (Part C)" <?php if( in_array("Most Socially Responsible Company (Part C)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>03 Awards <br> Innovation in Manufacturing Award
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Most Socially Responsible Company (Part C)" <?php if( in_array("Most Socially Responsible Company (Part C)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>03 Awards <br> Highest Gems and Jewellery Sales (Importer)
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Most Socially Responsible Company (Part C)" <?php if( in_array("Most Socially Responsible Company (Part C)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>01 Awards <br> Upcoming exporter of the year
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Most Socially Responsible Company (Part C)" <?php if( in_array("Most Socially Responsible Company (Part C)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>01 Awards <br> Best in Gems and Jewellery E- Commerce Platform
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="theme_based_award_category[]" id="theme_based_award_category" value="Most Socially Responsible Company (Part C)" <?php if( in_array("Most Socially Responsible Company (Part C)", $_POST['theme_based_award_category']) ){ echo "checked";}?>>01 Awards <br> Exports to highest no of International Clients and Importing countries
                                    </label>
                                </div>
                                
                                <div class="col-12">
                                    <label for="theme_based_award_category[]" generated="true" class="error d-none">Please Select Any </label>
                                </div>
                                
                            </div>

                        </div>

                        <div class="col-12 form-group">
                            <p><strong>Other Categories</strong></p>
                        </div>

                        <div class="col-12">

                            <div class="row award_input_box">
                            
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="other_award_category[]" id="other_award_category" value="Highest Employment on roll of Company" <?php if( in_array("Highest Employment on roll of Company", $_POST['other_award_category']) ){ echo "checked";}?> >03 Awards <br /> Highest Employment on roll of Company
                                    </label>
                                </div>
                            
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="other_award_category[]" id="other_award_category" value="Highest Taxpayer Company"  <?php if( in_array("Highest Taxpayer Company", $_POST['other_award_category']) ){ echo "checked";}?>>03 Awards  <br />Highest Taxpayer Company
                                    </label>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="other_award_category[]" id="other_award_category" value="Highest Employment on roll of Company" <?php if( in_array("Highest Employment on roll of Company", $_POST['other_award_category']) ){ echo "checked";}?> >01 Awards <br /> New Business Award
                                    </label>
                                </div>
                            
                                <div class="col-md-6 form-group">
                                    <label for="">
                                        <input type="checkbox" name="other_award_category[]" id="other_award_category" value="Highest Taxpayer Company"  <?php if( in_array("Highest Taxpayer Company", $_POST['other_award_category']) ){ echo "checked";}?>>01 Awards  <br />Global Retailer of the year 
                                    </label>
                                </div>

                                <div class="col-12">
                                    <label for="other_award_category[]" generated="true" class="error d-none">Please Select Any </label>
                                </div>
                            
                            </div>
                            
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-12"> 
                            <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;">
                                <strong>Overall Company Details </strong>
                            </p> 
                        </div>
                                        
                        <div class="form-group col-12">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <label>Please attach annual reports/audited financial statements for <strong> FY21, FY20 & FY19</strong> </label>
                                </div>
                                <div class="col-md-6"><input type="file" name="annual_report[]" id="annual_report" class="form-control" multiple="multiple"><label>(upload max file size 2MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label> </div>
                            </div>
                        </div>
                                         
                        <div class="form-group col-12">
                            
                            <table class="responsive_table category_table">
                                <thead>
                                    <tr>
                                        <th>Particular</th>
                                        <th>FY21</th>
                                        <th>FY20</th>
                                        <th>FY19</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr>
                                        <td data-column="Particular">Total Income (Sales + Other Income) (Rs Crore) </td>
                                        <td data-column="FY21"><input type="text" name="total_income_FY20" id="total_income_FY20" class="form-control numeric" value=<?php echo $total_income_FY20 ;?> ></td>
                                        <td data-column="FY20"><input type="text" name="total_income_FY19" class="form-control numeric" value="<?php echo $total_income_FY19 ;?>"></td>
                                        <td data-column="FY19"><input type="text" name="total_income_FY18" class="form-control numeric" value="<?php echo $total_income_FY18 ;?>"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Particular">Total Sales (Rs Crore) </td>
                                        <td data-column="FY21"><input type="text" name="total_sale_FY20" class="form-control numeric" value="<?php echo $total_sale_FY20 ;?>"></td>
                                        <td data-column="FY20"><input type="text" name="total_sale_FY19" class="form-control numeric" value="<?php echo $total_sale_FY19 ;?>"></td>
                                        <td data-column="FY19"><input type="text" name="total_sale_FY18" class="form-control numeric" value="<?php echo $total_sale_FY18 ;?>"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Particular">(a) Domestic Sales (Rs Crore) </td>
                                        <td data-column="FY21"><input type="text" name="domestic_sales_FY20" class="form-control numeric" value="<?php echo $domestic_sales_FY20 ;?>"></td>
                                        <td data-column="FY20"><input type="text" name="domestic_sales_FY19" class="form-control numeric" value="<?php echo $domestic_sales_FY19 ;?>"></td>
                                        <td data-column="FY19"><input type="text" name="domestic_sales_FY18" class="form-control numeric" value="<?php echo $domestic_sales_FY18 ;?>"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Particular">(b) Exports (Rs Crore) </td>
                                        <td data-column="FY21"><input type="text" name="exports_FY20" class="form-control numeric" value="<?php echo $exports_FY20 ;?>"></td>
                                        <td data-column="FY20"><input type="text" name="exports_FY19" class="form-control numeric" value="<?php echo $exports_FY19 ;?>"></td>
                                        <td data-column="FY19"><input type="text" name="exports_FY18" class="form-control numeric" value="<?php echo $exports_FY18;?>"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Particular">Net Profit (Rs Crore) </td>
                                        <td data-column="FY21"><input type="text" name="net_profit_FY20" class="form-control " value="<?php echo $net_profit_FY20 ;?>"></td>
                                        <td data-column="FY20"><input type="text" name="net_profit_FY19" class="form-control " value="<?php echo $net_profit_FY19 ;?>"></td>
                                        <td data-column="FY19"><input type="text" name="net_profit_FY18" class="form-control " value="<?php echo $net_profit_FY18 ;?>"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Particular">Total Number of Permanent Employees* </td>
                                        <td data-column="FY21"><input type="text" name="permenant_employees_FY20" class="form-control numeric" value="<?php echo $permenant_employees_FY20 ;?>"></td>
                                        <td data-column="FY20"><input type="text" name="permenant_employees_FY19" class="form-control numeric" value="<?php echo $permenant_employees_FY19 ;?>"></td>
                                        <td data-column="FY19"><input type="text" name="permenant_employees_FY18" class="form-control numeric" value="<?php echo $permenant_employees_FY18 ;?>"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Particular">Total Number of Contractual Employees*</td>
                                        <td data-column="FY21"><input type="text" name="contractual_employees_FY20" class="form-control numeric" value="<?php echo $contractual_employees_FY20 ;?>"></td>
                                        <td data-column="FY20"><input type="text"  name="contractual_employees_FY19" class="form-control numeric" value="<?php echo $contractual_employees_FY19 ;?>"></td>
                                        <td data-column="FY19"><input type="text"   name="contractual_employees_FY18" class="form-control numeric" value="<?php echo $contractual_employees_FY18 ;?>"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Particular">Total Number of Employees, of any other type*</td>
                                        <td data-column="FY21" ><input type="text"  name="other_employees_FY20" class="form-control numeric" value="<?php echo $other_employees_FY20;?>"></td>
                                        <td data-column="FY20"><input type="text" name="other_employees_FY19"  class="form-control numeric" value="<?php echo $other_employees_FY19;?>"></td>
                                        <td data-column="FY19"><input type="text" name="other_employees_FY18" class="form-control numeric" value="<?php echo $other_employees_FY18;?>"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Particular">Income Tax amount paid(Rupees in Crores)**</td>
                                        <td data-column="FY21"><input type="text" name="incm_tax_paid_FY20" class="form-control numeric"  value="<?php echo $incm_tax_paid_FY20;?>"></td>
                                        <td data-column="FY20"><input type="text" name="incm_tax_paid_FY19" class="form-control numeric"  value="<?php echo $incm_tax_paid_FY19;?>"></td>
                                        <td data-column="FY19"><input type="text" name="incm_tax_paid_FY18" class="form-control numeric"  value="<?php echo $incm_tax_paid_FY18;?>"></td>
                                    </tr>
                                </tbody>
                                
                            </table>

                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label>Upload Company Undertaking along with CA Certifications</label>
                            <input type="file" name="income_tax_return_attatchments[]" class="form-control" multiple="multiple">
                            <label>(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label>
                        </div>

                        <div class="form-group col-12">
                            <p>Notes:</p>
                            <ul class="inner_under_listing">
                                <li>This information is mandatory if the company has nominated for the category ‘Highest Employment on Rolls of Company’. Undertaking from company along with CA certification certifying total number of employees are required to be submitted along with nomination form.</li>
                                <li>This information is mandatory if the company has nominated for the category ‘Highest Taxpayer Company’. Undertaking from company along with CA certification and income tax challans certifying total income tax paid are required to be submitted along with nomination form.</li>
                                <li>This information is mandatory if the company has nominated for the categories  ‘Upcoming Exporter of the year’ and ‘New Business Award’. Undertaking from company along with CA certification certifying total sales including domestic and export sales of last three financial years (2018-19, 2019-20, 2020-21) are required to be submitted along with nomination form.</li>
                            </ul>
                        </div>
                        
                    </div>
                       
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" name="action" value="general_info">
                            <input type="submit" name="Next" value="Next" class="btnNext gold_btn d-table">
                        </div>
                    </div>
                                        
                </form>
                                    
            </div>
                                
        </div>
                            
    </div>  <!-- 01 General Information -->

    <div id="pane-B" class="card tab-pane fade <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="general_info"){
                            echo "active show";}?> " role="tabpanel" aria-labelledby="tab-B">
                            
        <div class="card-header" role="tab" id="heading-B">
            <h5 class="m-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
                Award Category Specific Information
                </a>
            </h5>
            
        </div>
                            
        <div id="collapse-B" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-B">
            
            <div class="card-body p-0">
                
                <form class="box-shadow" name="award_cat_specific_info" id="award_cat_specific_info"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">
                    
                    <div class="row">
                        
                        <div class="form-group col-12"> 
                            <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;">
                                <strong>Product Wise Breakup  (It is mandatory to provide product wise details for the award categories nominated for)
                                </strong>
                            </p> 
                        </div>
                        
                        <div class="form-group col-12">
                            
                            <table class="responsive_table category_table">

                                <thead>
                                    <tr>
                                        <th>Product Segments (FY2020-21)</th>
                                        <th>Select Row</th>
                                        <th>Total Sales (Rs.Crore)</th>
                                        <th>Domestic Sales (Rs.Crore)</th>
                                        <th>Export Sales (Rs.Crore)</th>
                                        <th>Net Profit (Rs. Crore)</th>
                                        <th>Value Addition* (%) </th>
                                        <th>Calculations of Value Addition</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                    <tr>
                                        <td data-column="Product Segments (FY2020-21)">Precious Metal Jewellery – Plain <input type="hidden" name="product_segment_FY20[]" value="Precious Metal Jewellery – Plain"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY20[8]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No" name="check_applicable_FY20[8]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY20[]" class="form-control "></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Product Segments (FY2020-21)">Precious Metal Jewellery – Studded <input type="hidden" name="product_segment_FY20[]" value="Precious Metal Jewellery – Studded"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY20[0]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No" name="check_applicable_FY20[0]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY20[]" class="form-control "></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Product Segments (FY2020-21)">Silver Jewellery <input type="hidden" name="product_segment_FY20[]" value="Silver Jewellery"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY19[1]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No" name="check_applicable_FY19[1]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY20[]" class="form-control "></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Product Segments (FY2020-21)">Cut &amp; Polished Diamonds <input type="hidden" name="product_segment_FY20[]" value="Cut &amp; Polished Diamonds "></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY20[2]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY20[2]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY20[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2020-21)">Cut &amp; Polished Coloured    Gemstones <input type="hidden" name="product_segment_FY20[]" value="Cut &amp; Polished Coloured    Gemstones"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY20[3]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY20[3]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY20[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2020-21)">Cut &amp; Polished Synthetic Stone <input type="hidden" name="product_segment_FY20[]" value="Cut &amp; Polished Synthetic Stone"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY20[4]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY20[4]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY20[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2020-21)">Costume/Fashion Jewellery <input type="hidden" name="product_segment_FY20[]" value="Costume/Fashion Jewellery"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY20[5]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY20[5]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY20[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2020-21)">Sales to Foreign Tourists <input type="hidden" name="product_segment_FY20[]" value="Sales to Foreign Tourists"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY20[6]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY20[6]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY20[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY20[]" class="form-control "></td>
                                    </tr>
    
                                </tbody>

                            </table>

                        </div>

                        <div class="form-group col-12">
                            
                            <table class="responsive_table category_table">
                                <thead>
                                    <tr>
                                        <th>Product Segments (FY2019-2020)</th>
                                        <th>Select Row</th>
                                        <th>Total Sales (Rs.Crore)</th>
                                        <th>Domestic Sales (Rs.Crore)</th>
                                        <th>Export Sales (Rs.Crore)</th>
                                        <th>Net Profit (Rs. Crore)</th>
                                        <th>Value Addition* (%) </th>
                                        <th>Calculations of Value Addition</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                    <tr>
                                        <td data-column="Product Segments (FY2019-2020)">Precious Metal Jewellery – Plain <input type="hidden" name="product_segment_FY19[]" value="Precious Metal Jewellery – Plain"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY19[8]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No" name="check_applicable_FY19[8]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY19[]" class="form-control "></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Product Segments (FY2019-2020)">Precious Metal Jewellery – Studded <input type="hidden" name="product_segment_FY19[]" value="Precious Metal Jewellery – Studded"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY19[0]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No" name="check_applicable_FY19[0]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY19[]" class="form-control "></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Product Segments (FY2019-2020)">Silver Jewellery <input type="hidden" name="product_segment_FY19[]" value="Silver Jewellery"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY19[1]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No" name="check_applicable_FY19[1]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY19[]" class="form-control "></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Product Segments (FY2019-2020)">Cut &amp; Polished Diamonds <input type="hidden" name="product_segment_FY19[]" value="Cut &amp; Polished Diamonds "></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY19[2]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY19[2]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY19[]" class="form-control "></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Product Segments (FY2019-2020)">Cut &amp; Polished Coloured    Gemstones <input type="hidden" name="product_segment_FY19[]" value="Cut &amp; Polished Coloured    Gemstones"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY19[3]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY19[3]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY19[]" class="form-control "></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Product Segments (FY2019-2020)">Cut &amp; Polished Synthetic Stone <input type="hidden" name="product_segment_FY19[]" value="Cut &amp; Polished Synthetic Stone"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY19[4]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY19[4]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY19[]" class="form-control "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="Product Segments (FY2019-2020)">Costume/Fashion Jewellery <input type="hidden" name="product_segment_FY19[]" value="Costume/Fashion Jewellery"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY19[5]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY19[5]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY19[]" class="form-control "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="Product Segments (FY2019-2020)">Sales to Foreign Tourists <input type="hidden" name="product_segment_FY19[]" value="Sales to Foreign Tourists"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                            <input type="radio"   value="Yes" name="check_applicable_FY19[6]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                            <input type="radio"  value="No"  name="check_applicable_FY19[6]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY19[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY19[]" class="form-control "></td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <div class="form-group col-12">

                            <table class="responsive_table category_table">

                                <thead>
                                    <tr>
                                        <th>Product Segments (FY2018-19)</th>
                                        <th> Select Row</th>
                                        <th>Total Sales (Rs.Crore)</th>
                                        <th>Domestic Sales (Rs.Crore)</th>
                                        <th>Export Sales (Rs.Crore)</th>
                                        <th>Net Profit (Rs. Crore)</th>
                                        <th>Value Addition* (%) </th>
                                        <th> Calculations of Value Addition</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr>
                                        <td data-column="Product Segments (FY2018-2019)">Precious Metal Jewellery – Plain <input type="hidden" name="product_segment_FY18[]" value="Precious Metal Jewellery – Plain"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                        <input type="radio"   value="Yes" name="check_applicable_FY18[8]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                        <input type="radio"  value="No" name="check_applicable_FY18[8]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY18[]" class="form-control"></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2018-2019)">Precious Metal Jewellery – Studded <input type="hidden" name="product_segment_FY18[]" value="Precious Metal Jewellery – Studded"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                        <input type="radio"   value="Yes" name="check_applicable_FY18[0]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                        <input type="radio"  value="No" name="check_applicable_FY18[0]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY18[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2018-2019)">Silver Jewellery <input type="hidden" name="product_segment_FY18[]" value="Silver Jewellery"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                        <input type="radio"   value="Yes" name="check_applicable_FY19[1]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                        <input type="radio"  value="No" name="check_applicable_FY19[1]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY18[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2018-2019)">Cut &amp; Polished Diamonds <input type="hidden" name="product_segment_FY18[]" value="Cut &amp; Polished Diamonds "></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                        <input type="radio"   value="Yes" name="check_applicable_FY18[2]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                        <input type="radio"  value="No"  name="check_applicable_FY18[2]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY18[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2018-2019)">Cut &amp; Polished Coloured    Gemstones <input type="hidden" name="product_segment_FY18[]" value="Cut &amp; Polished Coloured    Gemstones"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                        <input type="radio"   value="Yes" name="check_applicable_FY18[3]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                        <input type="radio"  value="No"  name="check_applicable_FY18[3]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY18[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2018-2019)">Cut &amp; Polished Synthetic Stone <input type="hidden" name="product_segment_FY18[]" value="Cut &amp; Polished Synthetic Stone"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                        <input type="radio"   value="Yes" name="check_applicable_FY18[4]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                        <input type="radio"  value="No"  name="check_applicable_FY18[4]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY18[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2018-2019)">Costume/Fashion Jewellery <input type="hidden" name="product_segment_FY18[]" value="Costume/Fashion Jewellery"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                        <input type="radio"   value="Yes" name="check_applicable_FY18[5]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                        <input type="radio"  value="No"  name="check_applicable_FY18[5]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY18[]" class="form-control "></td>
                                    </tr>

                                    <tr>
                                        <td data-column="Product Segments (FY2018-2019)">Sales to Foreign Tourists <input type="hidden" name="product_segment_FY18[]" value="Sales to Foreign Tourists"></td>
                                        <td data-column="Select Row"><label class="mr-3">
                                        <input type="radio"   value="Yes" name="check_applicable_FY18[6]" class="mr-2 check_applicable">Yes
                                        </label>
                                        <label class="mr-3">
                                        <input type="radio"  value="No"  name="check_applicable_FY18[6]" class="mr-2 check_applicable">No
                                        </label>
                                        </td>
                                        <td data-column="Total Sales (Rs.Crore)"><input type="text" name="total_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Domestic Sales (Rs.Crore)"><input type="text" name="domestic_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (Rs.Crore)"><input type="text" name="export_sales_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Net Profit (Rs. Crore)"><input type="text" name="net_profit_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Value Addition* (%)"><input type="text" name="value_addition_FY18[]" class="form-control numeric"></td>
                                        <td data-column="Calculations of Value Addition"><input type="text" name="calc_value_addition_FY18[]" class="form-control "></td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                    <p><strong>Note</strong></p>

                    <ul class="inner_under_listing mb-3">
                        <li>*Value addition = (Total Export Sales + Closing Stock) – (Opening stock + Total Purchase related to Exports) x 100 / (Opening stock + Total Purchase related to Exports)</li>
                        <li>Undertaking from company along with CA certification certifying value addition is required to be submitted along with nomination form</li>
                    </ul>

                    <div class="d-flex">
                        <!-- <div class="mr-3"><a href="#" class="btnNext gold_btn d-table">Prev</a></div> -->
                        <input type="hidden" name="action" value="award_cat_specific_info">
                        <input type="submit" name="submit" value="Next" class="btnNext gold_btn d-table" >
                    </div>
                
                </form>

            </div>

        </div>

    </div> <!-- 02 Award Category specific information -->

    <div id="pane-C" class="card tab-pane fade <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="award_cat_specific_info"){
    echo "active show";}?>" role="tabpanel" aria-labelledby="tab-C">

        <div class="card-header" role="tab" id="heading-C">
            <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse-C" aria-expanded="false" aria-controls="collapse-C">
                Export Related Information (Optional)
                </a>
            </h5>
        </div>

        <div id="collapse-C" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-C">

            <div class="card-body p-0">

                <form class="box-shadow" name="best_growing_perfomance" id="best_growing_perfomance"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">

                    <div class="row">

                        <div class="form-group col-12"> 
                            <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;">
                                <strong> Please provide following details </strong>
                            </p> 
                        </div>

                        <div class="form-group col-12">

                            <table class="responsive_table category_table">
                                <thead>
                                    <tr>
                                        <th>Details</th>
                                        <th>FY 2020-21</th>
                                        <th>FY 2019-20</th>
                                        <th>FY 2018-19</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td data-column="Details">Total number of countries your company is exporting to <input type="hidden" name="export_questions[]" value="Total    number of countries your company is exporting to "></td>
                                        <td data-column="FY 2020-21"><input type="text"  name="export_details_FY20[]" class="form-control numeric"></td>
                                        <td data-column="FY 2019-20"><input type="text"  name="export_details_FY19[]" class="form-control numeric"></td>
                                        <td data-column="FY 2018-19"><input type="text"  name="export_details_FY18[]"class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Details">Total    number of non-traditional export markets (Refer to rule no. 18) <input type="hidden" name="export_questions[]" value="Total    number of non-traditional export markets (Refer to rule no. 18) "></td>
                                        <td data-column="FY 2020-21"><input type="text"  name="export_details_FY20[]" class="form-control numeric"></td>
                                        <td data-column="FY 2019-20"><input type="text"  name="export_details_FY19[]" class="form-control numeric"></td>
                                        <td data-column="FY 2018-19"><input type="text"  name="export_details_FY18[]"class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Details">Exports sales to non-traditional markets (Rs in Crore) <input type="hidden" name="export_questions[]" value="Exports    sales to non-traditional markets (Rs in Crore)"></td>
                                        <td data-column="FY 2020-21"><input type="text"  name="export_details_FY20[]" class="form-control numeric"></td>
                                        <td data-column="FY 2019-20"><input type="text"  name="export_details_FY19[]" class="form-control numeric"></td>
                                        <td data-column="FY 2018-19"><input type="text"  name="export_details_FY18[]"class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Details">Exports    sales to non-traditional markets (in US $) <input type="hidden" name="export_questions[]" value="Exports    sales to non-traditional markets (in US $)"></td>
                                        <td data-column="FY 2020-21"><input type="text"  name="export_details_FY20[]" class="form-control numeric"></td>
                                        <td data-column="FY 2019-20"><input type="text"  name="export_details_FY19[]" class="form-control numeric"></td>
                                        <td data-column="FY 2018-19"><input type="text"  name="export_details_FY18[]"class="form-control numeric"></td>
                                    </tr>
                                </tbody>
                            
                            </table>

                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-12"> 
                            <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;">
                                <strong>Please provide details of all countries (not regions) of exports</strong>
                            </p> 
                        </div>

                        <div class="form-group col-12">
                            <p>Kindly provide information regarding exports to all countries in last three financial year. The list of countries along with export volume and export value (in INR Crore and USD $)</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <input type="file" name="attatchment[]" multiple="multiple" class="form-control">
                                    <label>(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-12">

                            <p class="text-center"> <strong>FY2020-21</strong> </p>

                            <table class="responsive_table category_table validate_cust">

                                <thead>
                                    <tr>
                                        <th>Country</th>
                                        <th>Export Sales (in Rs. crore)</th>
                                        <th>Export Sales (in US $)</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY20[0]" class="form-control "></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY20[0]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY20[0]"  class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY20[1]" class="form-control "></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY20[1]"  class="form-control numeric numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY20[1]"  class="form-control numeric numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country" data-column="Country"><input type="text" name="country_FY20[2]" class="form-control "></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY20[2]"  class="form-control numeric numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY20[2]"  class="form-control numeric numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY20[3]" class="form-control "></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY20[3]"  class="form-control numeric numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY20[3]"  class="form-control numeric numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY20[4]" class="form-control "></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY20[4]"  class="form-control numeric numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY20[4]"  class="form-control numeric numeric"></td>
                                    </tr>

                                </tbody>
                            
                            </table>

                        </div>

                        <div class="form-group col-12">

                            <p class="text-center"> <strong>FY 2019-20</strong> </p>

                            <table class="responsive_table category_table">

                                <thead>

                                    <tr>
                                        <th>Country</th>
                                        <th>Export Sales (in Rs. crore)</th>
                                        <th>Export Sales (in US $)</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[0]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[0]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[0]"  class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[1]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[1]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[1]"  class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[2]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[2]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[2]"  class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[3]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[3]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[3]"  class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[4]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[4]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[4]"  class="form-control numeric"></td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <div class="form-group col-12">

                            <p class="text-center"> <strong>FY 2019-2020</strong> </p>

                            <table class="responsive_table category_table">

                                <thead>
                                    <tr>
                                        <th>Country</th>
                                        <th>Export Sales (in Rs. crore)</th>
                                        <th>Export Sales (in US $)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[0]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[0]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[0]"  class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[1]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[1]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[1]"  class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[2]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[2]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[2]"  class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[3]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[3]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[3]"  class="form-control numeric"></td>
                                    </tr>
                                    <tr>
                                        <td data-column="Country"><input type="text" name="country_FY19[4]" class="form-control numeric"></td>
                                        <td data-column="Export Sales (in Rs. crore)"><input type="text" name="export_sales_rs_FY19[4]"  class="form-control numeric"></td>
                                        <td data-column="Export Sales (in US $)"><input type="text" name="export_sales_dollar_FY19[4]"  class="form-control numeric"></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Business Details and explanation related to financial details</strong></p> </div>

                        <div class="form-group col-12">
                            <p style="font-size:13px;">Kindly provide details of your business and the key products exported by your company? Please explain your financials with respect to reasons for major trends in parameters such as growth or decline in Export Turnover, growth or decline in total income, net profits, etc. (Please be as descriptive as possible by attaching additional documents)</p>
                        </div>

                        <div class="form-group col-12"> 
                            <textarea class="form-control " name="business_details_and_explanation"></textarea>  
                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong> Strategic Exports Initiatives</strong></p> </div>

                        <div class="form-group col-12"><p style="font-size:13px;">Please explain the initiatives taken by your company to expand its export markets or the number of products exported in the international market. Also provide the company's strategy to increase the market reach of the product.</p></div>

                        <div class="form-group col-12"> <textarea class="form-control" name="strategic_export_initiative"></textarea>  </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong> Case for Excellence</strong></p> </div>

                        <div class="form-group col-12">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <label class="mb-lg-0">Attach documents/literature, etc. to support the contention</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="attatchment[]" multiple="multiple" class="form-control">
                                    <label>(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label> 
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <p style="font-size:13px;">Please provide key insights on your business which make your enterprise a strong contender for the nominated award category in GJEPC's India Gem & Jewellery Awards 2020. (Attach documents/literature, etc. to support the contention)</p>
                        </div>

                        <div class="form-group col-12"> <textarea class="form-control" name="key_insights"></textarea>  </div>

                    </div>

                    <div class="d-flex">
                        <input type="hidden" name="action" value="best_growing_perfomance">
                        <input type="submit" name="submit" value="Next" class="btnNext gold_btn d-table" >
                    </div>

                </form>

            </div>

        </div>

    </div> <!-- 03 Export Related Information -->

    <div id="pane-D" class="card tab-pane fade <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="best_growing_perfomance"){
echo "active show";}?>" role="tabpanel" aria-labelledby="tab-D">

        <div class="card-header" role="tab" id="heading-D">
            <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse-D" aria-expanded="false" aria-controls="collapse-D">
                Quality Information</a>
            </h5>
        </div>

        <div id="collapse-D" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-D">

            <div class="card-body p-0">

                <form class="box-shadow" name="qualitative_information" id="qualitative_information"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">

                    <div class="row">

                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>Business details and explanation related to financial details</strong></p> </div>

                        <div class="form-group col-12">
                            <div class="row align-items-center">
                                <div class="col-auto"><label class="mb-lg-0">Please be as descriptive as possible by attaching additional documents</label></div>
                                <div class="form-group col-12"> <textarea class="form-control" name="attatchment_details"></textarea>  </div>
                                <div class="col-md-6"><input type="file" class="form-control" name="attatchment[]" multiple="multiple"> <label>(upload max file size 5MB jpeg,png,jpg,doc,docx,csv,excel,pdf)</label></div>
                            </div>
                        </div>

                        <div class="form-group col-12"><p style="font-size:13px;">Kindly provide details of your business and the key products exported by your company? Please explain your financials with respect to reasons for major trends in parameters such as growth or decline in Turnover, growth or decline in Profits, etc. (Please be as descriptive as possible by attaching additional documents)</p></div>

                        <div class="form-group col-12"> <textarea class="form-control" name="business_details_and_explanation"></textarea>  </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>Strategic Exports Initiatives</strong></p> </div>

                        <div class="form-group col-12"><p style="font-size:13px;">Kindly provide details of the initiatives your company has taken for marketing or branding of the products in international market. Also provide company's vision for increasing the market reach of the product.</p></div>

                        <div class="form-group col-12"> <textarea class="form-control" name="strategic_export_initiative"></textarea>  </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>Case for Excellence</strong></p> </div>

                        <div class="form-group col-12"><p style="font-size:13px;">Please provide key insights on your business which make your enterprise a strong contender for GJEPC's India Gem & Jewellery Awards 2019. Attach documents/literature, etc. to support the contention.</p></div>

                        <div class="form-group col-12"> <textarea class="form-control" name="case_of_excellence"></textarea>  </div>

                    </div>

                    <div class="row">

                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>Nominated Segment</strong></p> </div>

                        <div class="form-group col-12"><p style="font-size:13px;">Kindly provide any past details of the awards & accolades won by the company in the nominated segment</p></div>

                        <div class="form-group col-12"> <textarea class="form-control" name="nominated_segment"></textarea>  </div>


                        <!-- <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>5. Mandatory</strong></p> </div> -->

                        <!-- <div class="form-group col-12"><p style="font-size:13px;">Has your company/firm/partner/director been convicted for any legal proceedings against them in any court of law with respect to Central excise/customs/FEMA/RBI, etc. in the last 10 years? </p></div> -->

                        <!-- <div class="form-group col-sm-6">
                        <label for="company_name"><strong>If Yes, Please provide details.</strong></label>
                        <div class="mt-2">
                        <label for="Propritory" class="mr-3">
                        <input type="radio" id="mandatory_yes" name="is_mandatory" value="Yes" class="mr-2">Yes
                        </label>
                        <label for="Partnership" class="mr-3">
                        <input type="radio" id="mandatory_no" name="is_mandatory" value="No" class="mr-2">No
                        </label>

                        </div>
                        <div class="col-12"><label for="is_mandatory" generated="true" class="error d-none">Please Select</label></div>
                        </div> -->

                        <!-- <div class="form-group col-12"> <textarea class="form-control" name="mandatory_details"></textarea>  </div> -->

                    </div>

                    <div class="row">

                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>Number of outlets of Company  </strong></p> </div>
                        
                        <div class="form-group col-12">
                            <div class="row align-items-center">
                                <div class="col-12 mb-2"><label class="mb-lg-0">Kindly provide information regarding the number of outlets of the company both domestic and international along with address and supporting evidence.</label></div>
                                <div class="col-12 mb-2"><textarea class="form-control" name="attatchment_details"></textarea></div>
                                <div class="col-md-6"><input type="file" name="attatchment[]" multiple="multiple" class="form-control valid"><label>(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label> </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>Number of International Clients and Importing countries</strong></p> </div>

                        <div class="form-group col-12">
                            <div class="row align-items-center">
                                <div class="col-12 mb-2"><label class="mb-lg-0">Kindly provide information regarding exports to total number of international clients in last FY 2021-22. Also provide list of international clients along with export volume and export value (in INR Crore and USD $)</label></div>
                                <div class="col-12 mb-2"><textarea class="form-control" name="attatchment_details"></textarea></div>
                                <div class="col-md-6"><input type="file" name="attatchment[]" multiple="multiple" class="form-control valid"><label>(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label> </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> 
                            <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> 
                                <strong>Woman Entrepreneur </strong>
                            </p> 
                        </div>

                        <div class="col-12">

                            <div class="row align-items-center">

                                <div class="form-group col-md-4 col-lg-3">
                                    <label class="mb-lg-0">Title</label>
                                    <select class="form-control valid" name="sm_title[0]">
                                        <option value="">Select Title</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Mrs">Mrs</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-lg-3 form-group">
                                    <label class="mb-lg-0">Name</label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="col-md-4 col-lg-3 form-group">
                                    <label class="mb-lg-0">Designation</label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="col-md-4 col-lg-3 form-group">
                                    <label class="mb-lg-0">Years of Experience</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="">1 year </option>
                                        <option value="">2 year </option>
                                        <option value="">3 year </option>
                                        <option value="">4 year </option>
                                    </select>
                                </div>

                                <div class="col-12 form-group">
                                    <label class="mb-lg-0">Write up on initiatives/ approaches taken up by nominee for the growth and contribution towards the business. Please attach Documents showcasing the nominee is full-time employee of the company</label>
                                    <textarea class="form-control" name="attatchment_details"></textarea> 
                                </div>

                                <div class="col-md-6 form-group"><input type="file" name="attatchment[]" multiple="multiple" class="form-control valid"><label>(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label> </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> 
                            <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> 
                                <strong>Lifetime achievement award *</strong>
                            </p> 
                        </div>

                        <div class="col-12">

                            <p>Kindly provide the following information</p>

                            <div class="row align-items-center">

                                <div class="form-group col-md-4 col-lg-3">
                                    <label class="mb-lg-0">Title</label>
                                    <select class="form-control valid" name="sm_title[0]">
                                        <option value="">Select Title</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Mrs">Mrs</option>
                                    </select>
                                </div>

                                <div class="col-md-4 col-lg-3 form-group">
                                    <label class="mb-lg-0">Name</label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="col-md-4 col-lg-3 form-group">
                                    <label class="mb-lg-0">Designation</label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="col-md-4 col-lg-3 form-group">
                                    <label class="mb-lg-0">Years of Experience</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="">1 year </option>
                                        <option value="">2 year </option>
                                        <option value="">3 year </option>
                                        <option value="">4 year </option>
                                    </select>
                                </div>

                                <div class="col-12 form-group">
                                    <label class="mb-lg-0">Write up on initiatives/ approaches taken up by nominee for the growth and contribution towards the business. </label>
                                    <textarea class="form-control" name="attatchment_details"></textarea> 
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">


                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>Mandatory</strong></p> </div>

                        <div class="form-group col-12"><p style="font-size:13px;">Has your company/firm/partner/director been convicted for any legal proceedings against them in any court of law with respect to Central excise/customs/FEMA/RBI, etc. in the last 10 years?</p></div>

                        <div class="form-group col-sm-6">
                            <label for="company_name"><strong>If Yes, Please provide details.</strong></label>
                            <div class="mt-2">
                                <label for="Propritory" class="mr-3">
                                    <input type="radio" id="mandatory_yes" name="is_mandatory" value="Yes" class="mr-2">Yes
                                </label>
                                <label for="Partnership" class="mr-3">
                                    <input type="radio" id="mandatory_no" name="is_mandatory" value="No" class="mr-2">No
                                </label>
                            </div>
                        </div>
                        <div class="col-12"><label for="is_mandatory" generated="true" class="error d-none">Please Select</label></div>

                        <div class="form-group col-12"> <textarea class="form-control" name="mandatory_details"></textarea>  </div>
                    
                    </div>

                    <div class="d-flex">
                        <input type="hidden" name="action" value="qualitative_information">
                        <input type="submit" name="submit" value="Next" class="btnNext gold_btn d-table" >
                    </div>

                </form>
            
            </div>

        </div>

    </div> <!-- 04 Quality Information -->

    <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="qualitative_information"){
    $reg_id = $_SESSION['reg_id'];
    $theme_based_award_category =  $_SESSION['theme_based_award_category'];
                        
    if(in_array("Most Innovative Company (Part B)", $theme_based_award_category) && $_SESSION['step']=='qualitative_information'){?>

    <div id="pane-F" class="card tab-pane fade <?php if($theme_based_award_category[0]=="Most Innovative Company (Part B)" && $_SESSION['step'] =="qualitative_information"){echo "active show";}else{echo "hide";}?>" role="tabpanel" aria-labelledby="tab-F">
        
        <div class="card-header" role="tab" id="heading-F">
            <h5 class="mb-0">
            <a class="collapsed" data-toggle="collapse" href="#collapse-F" aria-expanded="false" aria-controls="collapse-F">
                Innovative Company
            </a>
            </h5>
        </div>
        
        <div id="collapse-F" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-F">
            
            <div class="card-body p-0">
                
                <form class="box-shadow" method="POST" name="innovative_company" id="innovative_company" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">
                    
                    <div class="row">

                        <div class="form-group col-12">
                            <p><strong> Note:</strong> Kindly write ‘Not Applicable’ wherever not required to be filled </p>
                        </div>

                    </div>
                    
                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong> Please provide details of research and development activities undertaken by your company * </strong></p> </div>
                        
                        <div class="form-group col-12">
                            <div class="row align-items-center">
                                <div class="col-12"><label class="mb-lg-0">Kindly attach relevant material and additional sheets wherever applicable</label></div>
                                <div class="col-md-6"><input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"><label>(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label> </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-12"> <p><strong>Amount of R&D Expenditure</strong> (Please mention R&D Expenditure on Product Design and New Technology separately in below table)</p> </div>
                        
                        <div class="form-group col-12">
                            
                            <table class="responsive_table category_table">
                                <thead>
                                    <tr>
                                        <th>R&D Activities (Rs Crore)</th>
                                        <th>FY2020-21</th>
                                        <th>FY2019-20</th>
                                        <th>FY2018-19</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                    <tr>
                                        <td data-column="R&D Activities (Rs Crore)"><input type="text" name="r_n_d_activities[0]" class="form-control "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[0]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[0]" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="r_n_d_activities_FY18[0]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="R&D Activities (Rs Crore)"><input type="text" name="r_n_d_activities[1]" class="form-control  "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[1]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[1]" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="r_n_d_activities_FY18[1]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="R&D Activities (Rs Crore)"><input type="text" name="r_n_d_activities[2]" class="form-control  "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[2]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[2]" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="r_n_d_activities_FY18[2]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="R&D Activities (Rs Crore)"><input type="text" name="r_n_d_activities[3]" class="form-control  "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[3]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[3]" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="r_n_d_activities_FY18[3]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="R&D Activities (Rs Crore)">Total R&D Exp. Amount (Rs Crore)</td>
                                        <td data-column="FY2020-21"><input type="text" name="total_r_n_d_activities_FY20" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="total_r_n_d_activities_FY19" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="total_r_n_d_activities_FY18" class="form-control numeric "></td>
                                    </tr>
                                    
                                </tbody>
                                
                            </table>
                            
                        </div>
                        
                        <div class="form-group col-12"> <p>Details of R&D activities</p> </div>
                        
                        <div class="form-group col-12">
                            
                            <textarea class="form-control" name="details_r_n_d_activities"></textarea>
                            
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong> Kindly provide details of the innovation activities undertaken by your company in the last 3 years (e.g. technology adoption, development of new product, innovation in marketing etc.)? *</strong></p> </div>
                        
                        <div class="form-group col-12">
                            
                            <textarea class="form-control" name="innovation_activities_last_3_yr"></textarea>
                            
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Please explain how the innovation has impacted and helped the business of your company </strong></p> </div>
                        
                        <div class="form-group col-12">
                            
                            <textarea class="form-control" name="how_impact_innovation"></textarea>
                            
                        </div>

                    </div>
                        
                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Kindly provide details of any patents that have been registered for innovation by the organization for last 3 financial years</strong></p> </div>
                        
                        <div class="form-group col-12">
                            
                            <textarea class="form-control" name="registered_patents_for_innovation"></textarea>
                            
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Kindly provide write up on initiatives take by company for digital marketing or branding of the products in international market. Provide the company’s vision for increasing the market reach of the product *</strong></p> </div>
                        
                        <div class="form-group col-12">
                            
                            <textarea class="form-control" name="award_and_accolades_won_details"></textarea>
                            
                        </div>

                        <div class="col-md-6">
                            <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"><label>(upload max file size 15MB. video)</label> 
                        </div>
                        
                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Kindly mention details of any awards and accolades won by your company in the past for innovations</strong></p> </div>
                        
                        <div class="form-group col-12">
                            
                            <textarea class="form-control" name="award_and_accolades_won_details"></textarea>
                            
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Kindly provide details of Corporate Social Responsibility activities undertaken by your company *</strong></p> </div>

                        <div class="form-group col-12">Kindly attach relevant material and additional sheets wherever applicable</div>
                        
                        <div class="form-group col-md-6">
                            <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"><label>(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label> 
                        </div>

                        <div class="form-group col-md-6">
                            <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"><label>(upload max file size 15MB. video)</label> 
                        </div>

                        <div class="form-group col-12"><strong>Amount of CSR Expenditure</strong></div>

                        <div class="form-group col-12">
                                                
                            <table class="responsive_table category_table">
                                <thead>
                                    <tr>
                                        <th>CSR Activities (Rs Crore)</th>
                                        <th>FY2020-21</th>
                                        <th>FY2019-20</th>
                                        <th>FY2018-19</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                    <tr>
                                        <td data-column="CSR Activities (Rs Crore)"><input type="text" name="r_n_d_activities[0]" class="form-control "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[0]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[0]" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="r_n_d_activities_FY18[0]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="CSR Activities (Rs Crore)"><input type="text" name="r_n_d_activities[1]" class="form-control"></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[1]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[1]" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="r_n_d_activities_FY18[1]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="CSR Activities (Rs Crore)"><input type="text" name="r_n_d_activities[2]" class="form-control  "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[2]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[2]" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="r_n_d_activities_FY18[2]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="CSR Activities (Rs Crore)"><input type="text" name="r_n_d_activities[3]" class="form-control  "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[3]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[3]" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="r_n_d_activities_FY18[3]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="CSR Activities (Rs Crore)">Total CSR Exp. Amount (Rs Crore)</td>
                                        <td data-column="FY2020-21"><input type="text" name="total_r_n_d_activities_FY20" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="total_r_n_d_activities_FY19" class="form-control numeric "></td>
                                        <td data-column="FY2018-19"><input type="text" name="total_r_n_d_activities_FY18" class="form-control numeric "></td>
                                    </tr>
                                    
                                </tbody>
                                
                            </table>
                                                
                        </div>

                        <div class="form-group col-12">
                           <strong> Details of CSR activities </strong>  (Write up on impact of project on stakeholders and scalability/ replicability of the project (not more than 1500 words)).
                        </div>

                        <div class="form-group col-12">
                           <textarea class="form-control" name="innovation_activities_last_3_yr"></textarea>
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Kindly provide details of Innovation in Marketing undertaken by your company *</strong></p> </div>

                        <div class="form-group col-12">a. Kindly attach relevant material and documents being used on various marketing platforms like You tube, Social Media, Television, Radio, Newspaper, Magazine, Poster/ etc. Maximum upload file size should not be more than 5MB in jpeg, png, jpg, doc, docx, csv, excel, pdf format.</div>
                        
                        <div class="form-group col-md-6">
                            <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control">
                        </div>

                        <div class="form-group col-12">b. Kindly attach relevant material and additional documents of marketing material. Maximum file size of the video upload should not be more than 15MB. </div>
                        
                        <div class="form-group col-md-6">
                            <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control">
                        </div>


                        <div class="form-group col-12">
                           Details of Innovation idea, strategy for implementation and results of the marketing/ branding activities for last 3 financial year.
                        </div>

                        <div class="form-group col-12">
                           <textarea class="form-control" name="innovation_activities_last_3_yr"></textarea>
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Kindly provide details of Innovation in Manufacturing undertaken by your company *</strong></p> </div>

                        <div class="form-group col-12">Kindly attach relevant material and additional sheets wherever applicable. Maximum file size should not be more than 5MB in jpeg, png, jpg, doc, docx, csv, excel, pdf format.</div>
                        
                        <div class="form-group col-md-6">
                            <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control">
                        </div>

                        <div class="form-group col-12">
                           <textarea class="form-control" name="innovation_activities_last_3_yr"></textarea>
                        </div>

                    </div>

                    <div class="row">
                        
                        <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Kindly provide details of Sales from E- Commerce Platform in last two financial year *</strong></p> </div>

                        <div class="form-group col-12">Kindly attach relevant material and additional sheets wherever applicable. Maximum file size should not be more than 5MB in jpeg, png, jpg, doc, docx, csv, excel, pdf format.</div>
                        
                        <div class="form-group col-md-6">
                            <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control">
                        </div>

                       <div class="form-group col-12">
                                                
                            <table class="responsive_table category_table">
                                <thead>
                                    <tr>
                                        <th>Sales from E- Commerce Platform (Rs Crore) </th>
                                        <th>FY2020-21</th>
                                        <th>FY2019-20</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                    <tr>
                                        <td data-column="Sales from E- Commerce Platform (Rs Crore)"><input type="text" name="r_n_d_activities[0]" class="form-control "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[0]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[0]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="Sales from E- Commerce Platform (Rs Crore)"><input type="text" name="r_n_d_activities[1]" class="form-control  "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[1]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[1]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="Sales from E- Commerce Platform (Rs Crore)"><input type="text" name="r_n_d_activities[2]" class="form-control  "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[2]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[2]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="Sales from E- Commerce Platform (Rs Crore)"><input type="text" name="r_n_d_activities[3]" class="form-control  "></td>
                                        <td data-column="FY2020-21"><input type="text" name="r_n_d_activities_FY20[3]" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="r_n_d_activities_FY19[3]" class="form-control numeric "></td>
                                    </tr>
                                    
                                    <tr>
                                        <td data-column="Sales from E- Commerce Platform (Rs Crore)">Total Sales from E- Commerce Platform Amount (Rs Crore)</td>
                                        <td data-column="FY2020-21"><input type="text" name="total_r_n_d_activities_FY20" class="form-control numeric "></td>
                                        <td data-column="FY2019-20"><input type="text" name="total_r_n_d_activities_FY19" class="form-control numeric "></td>
                                    </tr>
                                    
                                </tbody>
                                
                            </table>
                                                
                        </div>

                    </div>

                    <input type="hidden" name="action" value="innovative_company">
                    <button type="submit" class="gold_btn fade_anim"> Next </button>
                    
                </form>
                
            </div>
            
        </div>

    </div>
    
    <?php  } ?>
                        
                        <?php    if(in_array("Best Digital Initiative (Part D)", $theme_based_award_category)){?>
                        <div id="pane-H" class="card tab-pane fade <?php if($theme_based_award_category[0]=="Best Digital Initiative (Part D)" && $_SESSION['step']=='qualitative_information'){echo "active show";}else{echo "hide";}?>" role="tabpanel" aria-labelledby="tab-H">
                            
                            <div class="card-header" role="tab" id="heading-H">
                                <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-H" aria-expanded="false" aria-controls="collapse-H">
                                    Best Digital Initiative
                                </a>
                                </h5>
                            </div>
                            
                            <div id="collapse-H" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-H">
                                
                                <div class="card-body p-0">
                                    
                                    <form class="box-shadow" method="POST" name="digital_initiative" id="digital_initiative" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">
                                        
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <p><strong>  Note: </strong> Kindly write ‘Not Applicable’ wherever not required to be filled </p>
                                                
                                            </div>
                                            <div class="form-group col-12"><p>Please provide details of initiative in key areas such as those mentioned below to help build a case for an award for 'Digital Initiatives' </p> </div>
                                            
                                            <div class="form-group col-12">
                                                <div class="row align-items-center">
                                                    <div class="col-auto"><label class="mb-lg-0">Please feel free to attach annexures in order to provided more detailed information</label></div>
                                                    <div class="col-md-4"><input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"> <label>(upload max file size 2MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label></div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>1. In case of Initiative in sales through digital platform, please provide following details (Rs Crore)</strong></p> </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>Year of launch of Digital Platform for sales </label>
                                                <input type="text" name="year_of_launch" class="form-control numeric" />
                                            </div>
                                            
                                            <div class="form-group col-12">
                                                <table class="responsive_table category_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Particulars</th>
                                                            <th>FY2019-20</th>
                                                            <th>FY2018-19</th>
                                                            <th>FY2017-18</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <tr>
                                                            <td>Total Turnover through Digital Platform</td>
                                                            <td><input type="text" name="total_turnover_FY20" class="form-control numeric"></td>
                                                            <td><input type="text" name="total_turnover_FY19" class="form-control numeric"></td>
                                                            <td><input type="text" name="total_turnover_FY18" class="form-control numeric"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Export Turnover through Digital Platform</td>
                                                            <td><input type="text" name="export_turnover_FY20" class="form-control numeric"></td>
                                                            <td><input type="text" name="export_turnover_FY19" class="form-control numeric"></td>
                                                            <td><input type="text" name="export_turnover_FY18" class="form-control numeric"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>% Share of Turnover through Digital Platform <span class="d-block" style="font-size:11px;"> <i> i.e. [(Turnover through Digital Platform / total turnover) * 100] </i> </span></td>
                                                            <td><input type="text" name="share_of_turnover_FY20" class="form-control numeric"></td>
                                                            <td><input type="text" name="share_of_turnover_FY19" class="form-control numeric"></td>
                                                            <td><input type="text" name="share_of_turnover_FY18" class="form-control numeric"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>No. of Clients using Digital Platform </td>
                                                            <td><input type="text" name="no_of_clients_FY20" class="form-control numeric"></td>
                                                            <td><input type="text" name="no_of_clients_FY19" class="form-control numeric"></td>
                                                            <td><input type="text" name="no_of_clients_FY18" class="form-control numeric"></td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                    
                                                </table>
                                            </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"> <strong>2. In case of digital initiatives in other areas of excellence, please explain how the digital initiative in the selected area has impacted and helped the overall business of the company </strong></p> </div>
                                            
                                            <div class="form-group col-12">
                                                <table class="responsive_table category_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Areas of excellence </th>
                                                            <th>Yes / No</th>
                                                            <th>Initiatives</th>
                                                            <th>Impact</th>
                                                        </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <tr>
                                                            <td>Product Design <input type="hidden" name="area1" value="Product Design"> </td>
                                                            <td>
                                                                <label for="yes" class="mr-3">
                                                                    <input type="radio"   value="Yes" name="isArea1" class="mr-2 select_area">Yes
                                                                </label>
                                                                <label for="Propritory" class="mr-3">
                                                                    <input type="radio"  value="No" name="isArea1" class="mr-2 select_area">No
                                                                </label>
                                                            </td>
                                                            <td><textarea class="form-control" name="initiatives1"></textarea></td>
                                                            <td><textarea class="form-control" name="impact1"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Selling/Marketing/Customer Service <input type="hidden" name="area2" value="Selling/Marketing/Customer Service "> </td>
                                                            <td>
                                                                <label for="yes" class="mr-3">
                                                                    <input type="radio"   value="Yes" name="isArea2" class="mr-2 select_area">Yes
                                                                </label>
                                                                <label for="Propritory" class="mr-3">
                                                                    <input type="radio"  value="No" name="isArea2" class="mr-2 select_area">No
                                                                </label>
                                                            </td>
                                                            <td><textarea class="form-control" name="initiatives2"></textarea></td>
                                                            <td><textarea class="form-control" name="impact2"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Media & Public Relations <input type="hidden" name="area3" value="Media & Public Relations"></td>
                                                            <td>
                                                                <label for="yes" class="mr-3">
                                                                    <input type="radio"   value="Yes" name="isArea3" class="mr-2 select_area">Yes
                                                                </label>
                                                                <label for="Propritory" class="mr-3">
                                                                    <input type="radio"  value="No" name="isArea3" class="mr-2 select_area">No
                                                                </label>
                                                            </td>
                                                            <td><textarea class="form-control" name="initiatives3"></textarea></td>
                                                            <td><textarea class="form-control" name="impact3"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Human Resource functions  <input type="hidden" name="area4" value="Human Resource functions "></td>
                                                            <td>
                                                                <label for="yes" class="mr-3">
                                                                    <input type="radio"   value="Yes" name="isArea4" class="mr-2 select_area">Yes
                                                                </label>
                                                                <label for="Propritory" class="mr-3">
                                                                    <input type="radio"  value="No" name="isArea4" class="mr-2 select_area">No
                                                                </label>
                                                            </td>
                                                            <td><textarea class="form-control" name="initiatives4"></textarea></td>
                                                            <td><textarea class="form-control" name="impact4"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Inventory & Supply Chain Management  <input type="hidden" name="area5" value="Inventory & Supply Chain Management"></td>
                                                            <td>
                                                                <label for="yes" class="mr-3">
                                                                    <input type="radio"   value="Yes" name="isArea5" class="mr-2 select_area">Yes
                                                                </label>
                                                                <label for="Propritory" class="mr-3">
                                                                    <input type="radio"  value="No" name="isArea5" class="mr-2 select_area">No
                                                                </label>
                                                            </td>
                                                            <td><textarea class="form-control" name="initiatives5"></textarea></td>
                                                            <td><textarea class="form-control" name="impact5"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Data & Information Management  <input type="hidden" name="area6" value="Data & Information Management "></td>
                                                            <td>
                                                                <label for="yes" class="mr-3">
                                                                    <input type="radio"   value="Yes" name="isArea6" class="mr-2 select_area">Yes
                                                                </label>
                                                                <label for="Propritory" class="mr-3">
                                                                    <input type="radio"  value="No" name="isArea6" class="mr-2 select_area">No
                                                                </label>
                                                            </td>
                                                            <td><textarea class="form-control" name="initiatives6"></textarea></td>
                                                            <td><textarea class="form-control" name="impact6"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Other operational functions (please specify)  <input type="hidden" name="area7" value="Other operational functions (please specify)"></td>
                                                            <td>
                                                                <label for="yes" class="mr-3">
                                                                    <input type="radio"   value="Yes" name="isArea7" class="mr-2 select_area">Yes
                                                                </label>
                                                                <label for="Propritory" class="mr-3">
                                                                    <input type="radio"  value="No" name="isArea7" class="mr-2 select_area">No
                                                                </label>
                                                            </td>
                                                            <td><textarea class="form-control" name="initiatives7"></textarea></td>
                                                            <td><textarea class="form-control" name="impact7"></textarea></td>
                                                        </tr>
                                                    </tbody>
                                                    
                                                </table>
                                            </div>
                                            
                                            
                                        </div>
                                        <input type="hidden" name="action" value="digital_initiative">
                                        <input type="submit" name="submit" class="btnNext gold_btn d-table" value="Next">
                                        
                                    </form>
                                    
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                        <?php  } ?>
                        <?php if(in_array("Most Socially Responsible Company (Part C)", $theme_based_award_category)){ ?>
                        <div id="pane-G" class="card tab-pane fade <?php if($theme_based_award_category[0]=="Most Socially Responsible Company (Part C)" && $_SESSION['step']=='qualitative_information'){echo "active show";}else{echo "hide";}?>" role="tabpanel" aria-labelledby="tab-G">
                            
                            <div class="card-header" role="tab" id="heading-G">
                                <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-G" aria-expanded="false" aria-controls="collapse-G">
                                    Innovative Company
                                </a>
                                </h5>
                            </div>
                            
                            <div id="collapse-G" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-G">
                                
                                <div class="card-body p-0">
                                    
                                    <form class="box-shadow" method="POST" name="socially_responsible" id="socially_responsible" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data" >
                                        
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <p><strong>  Note: </strong> Kindly write ‘Not Applicable’ wherever not required to be filled </p>
                                                
                                            </div>
                                            
                                            <!-- <div class="form-group col-12">
                                                <p><strong>  Note: </strong> CSR Activities for the purpose of this award does not include </p>
                                                <ul class="inner_under_listing">
                                                    <li>activities undertaken by your company for the benefit of company's employees</li>
                                                    <li>donation made or activities undertaken for religious purpose</li>
                                                    <li>donation made through trusts/NGOs but indirectly used for the purposes mentioned above</li>
                                                </ul>
                                            </div> -->
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>1. Please provide details of research and development activities undertaken by your company</strong></p> </div>
                                            
                                            <div class="form-group col-12">
                                                <div class="row align-items-center">
                                                    <div class="col-12"><label class="mb-lg-0">Kindly attach relevant material and additional sheets wherever applicable</label></div>
                                                    <div class="col-md-6"><input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"> <label>(upload max file size 2MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label></div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group col-12">
                                                
                                                <p>Amount of R&D Expenditure (Please mention R&D Expenditure on Product Design and New Technology separately in below table)</p>
                                                
                                                <table class="responsive_table category_table">
                                                    <thead>
                                                        <tr>
                                                            <th>R&D Activities (Rs Crore)</th>
                                                            <th>FY 2021-2022</th>
                                                            <th>FY 2020-2021</th>
                                                            <th>FY 2019-2020</th>
                                                        </tr>
                                                        
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <tr>
                                                            <td>Total R&D Exp. Amount</td>
                                                            <td><input type="text" name="csr_exp_amount_FY20" class="form-control numeric"></td>
                                                            <td><input type="text" name="csr_exp_amount_FY19" class="form-control numeric"></td>
                                                            <td><input type="text" name="csr_exp_amount_FY18" class="form-control numeric"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total R&D Exp. Amount spent directly</td>
                                                            <td><input type="text" name="csr_exp_amount_spent_directly_FY20" class="form-control numeric"></td>
                                                            <td><input type="text" name="csr_exp_amount_spent_directly_FY19" class="form-control numeric"></td>
                                                            <td><input type="text" name="csr_exp_amount_spent_directly_FY18" class="form-control numeric"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Total R&D Exp. Amount through Trust/NGOs etc.</td>
                                                            <td><input type="text" name="csr_exp_amount_through_trust_FY20" class="form-control numeric"></td>
                                                            <td><input type="text" name="csr_exp_amount_through_trust_FY19" class="form-control numeric"></td>
                                                            <td><input type="text" name="csr_exp_amount_through_trust_FY18" class="form-control numeric"></td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                                
                                            </div>
                                            
                                            <div class="form-group col-12">
                                                
                                                <p>Details of R&D activities undertakens</p>
                                                
                                                <textarea class="form-control" name="csr_details"></textarea>
                                                
                                            </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>2. Kindly provide details of the innovation activities undertaken by your company in the last 3 years (e.g. technology adoption, development of new product, innovation in marketing etc.)?</strong></p> </div>
                                            
                                            <div class="form-group col-12">
                                                
                                                <textarea class="form-control" name="trust_ngo_details"></textarea>
                                                
                                            </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>3. Please explain how the innovation has impacted and helped the business of your company</strong></p> </div>
                                            
                                            <!-- <div class="form-group col-4">
                                                <label>FY2019-20</label>
                                                <input type="text" name="no_of_employee_FY20" class="form-control numeric">
                                            </div>
                                            
                                            <div class="form-group col-4">
                                                <label>FY2018-19</label>
                                                <input type="text" name="no_of_employee_FY19" class="form-control numeric">
                                            </div>
                                            
                                            <div class="form-group col-4">
                                                <label>FY2017-18</label>
                                                <input type="text" name="no_of_employee_FY18" class="form-control numeric">
                                            </div> -->

                                            <div class="form-group col-12">
                                                
                                                <textarea class="form-control" name="awards_accolades_details"></textarea>
                                                
                                            </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>4.  Kindly provide details of any patents that have been registered for innovation by the organization for last 3 financial years</strong></p> </div>
                                            
                                            <div class="form-group col-12">
                                                
                                                <textarea class="form-control" name="awards_accolades_details"></textarea>
                                                
                                            </div>

                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>5.  Kindly provide write up on initiatives take by company for digital marketing or branding of the products in international market. Provide the company’s vision for increasing the market reach of the product</strong></p> </div>

                                            <div class="form-group col-12">
                                                
                                                <textarea class="form-control" name="awards_accolades_details"></textarea>
                                                
                                            </div>

                                            <div class="form-group col-md-6">
                                                
                                               <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"> <label>(upload max file size 2MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label>
                                                
                                            </div>

                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>6.  Kindly mention details of any awards and accolades won by your company in the past for innovations</strong></p> </div>
                                            
                                            <div class="form-group col-12">
                                                
                                                <textarea class="form-control" name="awards_accolades_details"></textarea>
                                                
                                            </div>


                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>7.  Kindly provide details of Corporate Social Responsibility activities undertaken by your company</strong></p> </div>

                                            <div class="col-12">

                                                <p>Kindly attach relevant material and additional sheets wherever applicable</p>
                                                
                                                <div class="row">

                                                    <div class="form-group col-md-6">

                                                
                                                        <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"> <label>(upload max file size 2MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label>
                                                
                                                    </div>

                                                    <div class="form-group col-md-6">

                                                        
                                                       <input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"> <label>(upload max file size 2MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label>
                                                        
                                                    </div>

                                                    <div class="form-group col-12">

                                                        <p>Amount of CSR Expenditure</p>

                                                        <table class="responsive_table category_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>CSR Activities (Rs Crore)</th>
                                                                    <th>FY2021-22</th>
                                                                    <th>FY2020-21</th>
                                                                    <th>FY2019-20</th>
                                                                </tr>
                                                                
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                                 <tr>
                                                                    <td>Total CSR Exp. Amount (Rs Crore)</td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>

                                                    <div class="form-group col-12">
                                                        <p><strong>Details of CSR activities  </strong> (Write up on impact of project on stakeholders and scalability/ replicability of the project (not more than 1500 words) </p>
                                                    </div>
                                                    
                                                    <div class="form-group col-12">

                                                        <textarea class="form-control"></textarea>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>8.  Kindly provide details of Innovation in Marketing undertaken by your company</strong></p> </div>

                                            <div class="form-group  col-12">
                                                <p>a. Kindly attach relevant material and documents being used on various marketing platforms like You tube, Social Media, Television, Radio, Newspaper, Magazine, Poster/ etc. Maximum upload file size should not be more than 2MB in jpeg, png, jpg, doc, docx, csv, excel, pdf format.</p>
                                                <div class="row">
                                                    <div class="col-md-6"><input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"></div>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group  col-12">
                                                <p>b. Kindly attach relevant material and additional documents of marketing material. Maximum file size of the video upload should not be more than 15MB.  </p>
                                                <div class="row">
                                                    <div class="col-md-6"><input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"></div>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group  col-12">
                                                <p>Details of Innovation idea, strategy for implementation and results of the marketing/ branding activities for last 3 financial year.</p>
                                                <textarea name="" id="" class="form-control"></textarea>
                                                
                                            </div>

                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>8.  Kindly provide details of Innovation in Manufacturing undertaken by your company</strong></p> </div>

                                            <div class="form-group  col-12">
                                                <p>Kindly attach relevant material and additional sheets wherever applicable. Maximum file size should not be more than 5MB in jpeg, png, jpg, doc, docx, csv, excel, pdf format</p>
                                                <div class="row">
                                                    <div class="col-md-6"><input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"></div>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group col-12">

                                                <textarea class="form-control"></textarea>

                                            </div>

                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>9. Kindly provide details of Sales from E- Commerce Platform in last two financial year</strong></p> </div>

                                            <div class="form-group col-12">
                                                <p>Kindly attach relevant material and additional sheets wherever applicable. Maximum file size should not be more than 5MB in jpeg, png, jpg, doc, docx, csv, excel, pdf format.</p>
                                                <div class="row">
                                                    <div class="col-md-6"><input type="file" name="attatchment[]" id="attatchment[]" multiple="multiple" class="form-control"></div>
                                                </div>
                                            </div>


                                            <div class="form-group col-12">


                                                        <table class="responsive_table category_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sales from E- Commerce Platform (Rs Crore)</th>
                                                                    <th>FY2021-22</th>
                                                                    <th>FY2020-21</th>
                                                                </tr>
                                                                
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                                 <tr>
                                                                    <td>Total Sales from E- Commerce Platform Amount (Rs Crore)</td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                    <td><input type="text" name="" id="" class="form-control" value=""></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                            
                                        </div>
                                        <input type="hidden" name="action" value="socially_responsible">
                                        <input type="submit" name="submit" value="Next" class="btnNext gold_btn d-table" >
                                        
                                    </form>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        <?php  } ?>
                        <?php  if(in_array("Woman Entrepreneur of the Year (Part E)", $theme_based_award_category)){?>
                        
                        <div id="pane-I" class="card tab-pane fade <?php if($theme_based_award_category[0]=="Woman Entrepreneur of the Year (Part E)" && $_SESSION['step']=='qualitative_information'){echo "active show";}else{echo "hide";}?>" role="tabpanel" aria-labelledby="tab-I">
                            
                            <div class="card-header" role="tab" id="heading-I">
                                <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-I" aria-expanded="false" aria-controls="collapse-I">
                                    Woman Entrepreneur of the Year
                                </a>
                                </h5>
                            </div>
                            
                            <div id="collapse-I" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-I">
                                
                                <div class="card-body p-0">
                                    
                                    <form class="box-shadow" method="POST" name="woman_entrepreneur" id="woman_entrepreneur" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">
                                        
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <p><strong>  Note: </strong> Kindly write ‘Not Applicable’ wherever not required to be filled </p>
                                                
                                            </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>1. Please provide Nominated Entrepreneur Details</strong></p> </div>
                                            
                                            <div class="form-group col-sm-6">
                                                <label>Name of the Nominated Entrepreneur'</label>
                                                <input type="text" class="form-control" name="entrepreneur_name">
                                            </div>
                                            
                                            <div class="form-group col-sm-6">
                                                <label>No. of years in the management of current gems and jewellery business</label>
                                                <input type="text" class="form-control" name="no_of_years_in_business">
                                            </div>
                                            
                                            <div class="form-group col-sm-6">
                                                <label>Current Designation</label>
                                                <input type="text" class="form-control" name="current_designation">
                                            </div>
                                            
                                            <div class="form-group col-sm-6">
                                                <label>Details of any previous management of any business</label>
                                                <input type="text" class="form-control" name="prev_management_details">
                                            </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>2. Kindly provide the details of your initiatives taken by you for driving the growth of your gems and jewellery business. </strong></p> </div>
                                            
                                            <div class="form-group col-12"> <textarea class="form-control" name="details_of_inititative_taken"></textarea> </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>3. Kindly provide details of your past engagements in the management of any businesses </strong></p> </div>
                                            
                                            <div class="form-group col-12"> <textarea class="form-control" name="details_of_past_engagements"></textarea> </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>4. Kindly provide details of your contribution to the Innovation actions of your company and/or for the development of the society </strong></p> </div>
                                            
                                            <div class="form-group col-12"> <textarea class="form-control" name="contribution_to_innovation"></textarea> </div>
                                            
                                            <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>5. Kindly provide the details of awards and accolades won by you in the past as an entrepreneur </strong></p> </div>
                                            
                                            <div class="form-group col-12"> <textarea class="form-control" name="awards_accolades_details"></textarea> </div>
                                            
                                            <input type="hidden" name="action" value="woman_entrepreneur">
                                            <input type="submit" name="submit" value="Next" class="btnNext gold_btn d-table" >
                                            
                                            
                                        </div>
                                        
                                    </form>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        <?php  }
                        }?>

                        




<div id="pane-E" class="card tab-pane fade <?php if($_SESSION['step'] !="" && $_SESSION['step'] =="qualitative_information" && empty($_SESSION['theme_based_award_category'])){
echo "active show";}?>" role="tabpanel" aria-labelledby="tab-E">

<div class="card-header" role="tab" id="heading-E">
<h5 class="mb-0">
<a class="collapsed" data-toggle="collapse" href="#collapse-E" aria-expanded="false" aria-controls="collapse-E">
Declaration
</a>
</h5>
</div>

<div id="collapse-E" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-E">

<div class="card-body p-0">

<form class="box-shadow" name="declaration" id="declaration"  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off" enctype="multipart/form-data">

<div class="row">
    <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Declaration </strong></p> </div>

    <div class="form-group col-12"> <p>This is to certify that the above information is true and correct to the best of my knowledge</p> </div>

    <div class="form-group col-md-4"> <input type="text" placeholder="Name of the Respondent" name="respondant_name" class="form-control">  </div>

    <div class="form-group col-md-4"> <input type="text" placeholder="Designation" name="designation" class="form-control">  </div>

    <div class="form-group col-md-4"> <input type="text" placeholder="Mobile" name="mobile" maxlength="10" class="form-control numeric">  </div>

    <div class="form-group col-md-4"> <input type="text" placeholder="Email Id" name="email_id" class="form-control">  </div>

</div>

<div class="row">

    <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Chartered Accountant Declaration </strong></p> </div>

    <div class="form-group col-md-4"> <input type="text" placeholder="Name of the CA Firm" name="ca_firm_name" class="form-control">  </div>

    <div class="form-group col-md-4"> <input type="text" placeholder="Name of the individual" name="ca_name" class="form-control">  </div>

    <div class="form-group col-md-4"> <input type="text" placeholder="Designation" name="ca_designation" class="form-control">  </div>

    <div class="form-group col-md-4"> <input type="text" placeholder="Mobile" maxlength="10" name="ca_mobile" class="form-control numeric">  </div>

    <div class="form-group col-md-4"> <input type="text" placeholder="Email" name="ca_email" class="form-control">  </div>

</div>

<div class="row">

    <div class="form-group col-12"> <p class="pb-2 gold_clr" style="border-bottom:1px dashed #a89c5d;"><strong>Upload Attatchments</strong></p> </div>
    <div class="col-md-6">
    <input type="file"  name="attatchment[]" multiple="multiple" class="form-control">
    <label>(upload max file size 5MB. jpeg,png,jpg,doc,docx,csv,excel,pdf)</label>
    </div>

</div>
 
<input type="hidden" name="action" value="declaration">
<input type="submit" name="submit" value="Submit" class="btnNext gold_btn d-table" >


</form>

</div>

</div>

</div>
<?php if($_SESSION['step'] !="" && $_SESSION['step'] =="declaration"){?>
<div id="pane-J" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-J">

<div class="card-header" role="tab" id="heading-J">
<h5 class="mb-0">
<a class="collapsed" data-toggle="collapse" href="#collapse-J" aria-expanded="false" aria-controls="collapse-J">
Declaration
</a>
</h5>
</div>

<div id="collapse-J" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-J">

<div class="card-body p-0">

<div class=" row box-shadow py-5">
<div class="col-12 text-center">
<p class=" text-center text-success">Your application for Nomination Awards has been  submitted successfully</p>
<!-- <a href="https://gjepc.org/igja-form1.php?form-reset=yes" class="d-inline-block  btnNext gold_btn">Back</a> -->
</div>

</div>

</div>

</div>

</div>
<?php } ?>


</div>

</div>

</div>

</section>
<?php include('include-new/footer.php');?>
<script>
$('.btnNext').click(function(){
$('.nav-tabs > .active').next('li').find('a').trigger('click');
});
$('.btnPrevious').click(function(){
$('.nav-tabs > .active').prev('li').find('a').trigger('click');
});
</script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
jQuery.validator.addMethod("specialChrs", function (value, element) {
if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
return false;
} else {
return true;
};
},  "Special Characters Not Allowed");
jQuery.validator.addMethod("Chrs", function (value, element) {
if (/[^a-zA-Z\-]+$/i.test(value)) {
return false;
} else {
return true;
};
},  "Only Letters are Allowed");
jQuery.validator.addMethod("mobno", function (value, element) {
var regExp = /^[6-9]\d{9}$/;
if (value.match(regExp) ) {
return true;
} else {
return false;
};
},"Please Enter valid Mobile No");
$("#general_info").validate({
rules: {
company_name:{
required: true,
},
year:{
required: true,
},
imp_exp_code:{
required: true,
},
tel_no:{
required: true,
},
email_id: {
required: true,
email:true
},
website:{
required: true,
},
address_line_1:{
required: true,
},
city:{
required: true,
Chrs: true
},
state:{
required: true,
Chrs: true
},
zipcode:{
required: true,
number:true,
},
membership_no:{
required: true,
},
membership_year:{
required: true,
},
company_type:{
required: true,
},
nature_of_business:{
required: true,
},
"sm_name[0]":{
required: true,
},
"sm_designation[0]":{
required: true,
},
"sm_title[0]":{
required: true,
},
// 'performance_award_category[]':{
//  required: true,
// },
// "theme_based_award_category[]":{
//  required: true,
// },
// 'other_award_category[]':{
//  required: true,
// },
annual_report:{
required: true,
},
total_income_FY20:{
required: true,
},
total_income_FY19:{
required: true,
},
total_income_FY18:{
required: true,
},
total_income_FY20:{
required: true,
},
total_income_FY19:{
required: true,
},
total_income_FY18:{
required: true,
},
total_income_FY20:{
required: true,
},
total_income_FY19:{
required: true,
},
total_income_FY18:{
required: true,
},
total_sale_FY20:{
required: true,
},
total_sale_FY19:{
required: true,
},
total_sale_FY18:{
required: true,
},
domestic_sales_FY20:{
required: true,
},
domestic_sales_FY19:{
required: true,
},
domestic_sales_FY18:{
required: true,
},
exports_FY20:{
required: true,
},
exports_FY19:{
required: true,
},
exports_FY18:{
required: true,
},
net_profit_FY20:{
required: true,
},
net_profit_FY19:{
required: true,
},
net_profit_FY18:{
required: true,
},
permenant_employees_FY20:{
required: true,
},
permenant_employees_FY19:{
required: true,
},
permenant_employees_FY18:{
required: true,
},
contractual_employees_FY20:{
required: true,
},
contractual_employees_FY19:{
required: true,
},
contractual_employees_FY18:{
required: true,
},
other_employees_FY20:{
required: true,
},
other_employees_FY19:{
required: true,
},
other_employees_FY18:{
required: true,
},
incm_tax_paid_FY20:{
required: true,
},
incm_tax_paid_FY19:{
required: true,
},
incm_tax_paid_FY18:{
required: true,
}
},
messages: {

company_name: {
required: "Company name is Required",
},
year: {
required: "Company Establishment year is required",
},
imp_exp_code: {
required: "Import Export code is required",
},
tel_no: {
required: "Telephone Number name is Required",
},
email_id: {
required: "Email id is Required",
email: "Please Enter a valid Email id",
},
website: {
required: "Website  is Required",
},
address_line_1: {
required: "Address1 name is Required",
},
city: {
required: "City name is Required",
},
state: {
required: "Choose from the list",
},
zipcode: {
required: "Zip code  is Required",
},
membership_no: {
required: "Membership Number  is Required",
},
membership_year: {
required: "Membership year  is Required",
},
company_type: {
required: "Please Select Company Type",
},
sr_name: {
required: "Please Select Nature of business ",
},
"sm_name[0]": {
required: "Name is Required",
},
"sm_designation[0]": {
required: "Designation is Required",
},
"sm_title[0]": {
required: "Select Title ",
},
// 'performance_award_category[]':{
//  required:"Please Select Any ",
// },
// 'theme_based_award_category[]':{
//  required: "Please Select Any",
// },
// 'other_award_category[]':{
//  required: "Please Select Any",
// },
// annual_report:{
//    required: "Please upload files here here",
// },
total_income_FY20:{
required: "Required",
},
total_income_FY19:{
required: "Required",
},
total_income_FY18:{
required: "Required",
},
total_income_FY20:{
required: "Required",
},
total_income_FY19:{
required: "Required",
},
total_income_FY18:{
required: "Required",
},
total_income_FY20:{
required: "Required",
},
total_income_FY19:{
required: "Required",
},
total_income_FY18:{
required: "Required",
},
total_sale_FY20:{
required: "Required",
},
total_sale_FY19:{
required: "Required",
},
total_sale_FY18:{
required: "Required",
},
domestic_sales_FY20:{
required: "Required",
},
domestic_sales_FY19:{
required: "Required",
},
domestic_sales_FY18:{
required: "Required",
},
exports_FY20:{
required: "Required",
},
exports_FY19:{
required: "Required",
},
exports_FY18:{
required: "Required",
},
net_profit_FY20:{
required: "Required",
},
net_profit_FY19:{
required: "Required",
},
net_profit_FY18:{
required: "Required",
},
permenant_employees_FY20:{
required: "Required",
},
permenant_employees_FY19:{
required: "Required",
},
permenant_employees_FY18:{
required: "Required",
},
contractual_employees_FY20:{
required: "Required",
},
contractual_employees_FY19:{
required: "Required",
},
contractual_employees_FY18:{
required: "Required",
},
other_employees_FY20:{
required: "Required",
},
other_employees_FY19:{
required: "Required",
},
other_employees_FY18:{
required: "Required",
},
incm_tax_paid_FY20:{
required: "Required",
},
incm_tax_paid_FY19:{
required: "Required",
},
incm_tax_paid_FY18:{
required: "Required",
},




}
});
$("#innovative_company").validate({
rules: {

"r_n_d_activities[0]":{
required: true,
},
"r_n_d_activities_FY20[0]":{
required: true,
},
"r_n_d_activities_FY19[0]":{
required: true,
},
"r_n_d_activities_FY18[0]":{
required: true,
},
amount_of_r_n_d_expenditure:{
required: true,
}
,details_r_n_d_activities:{
required: true,
},
innovation_activities_last_3_yr:{
required: true,
},
how_impact_innovation:{
required: true,
},
registered_patents_for_innovation:{
required: true,
},
award_and_accolades_won_details:{
required: true,
}

},
messages: {

"r_n_d_activities[0]": {
required: "Required",
},
"r_n_d_activities_FY20[0]": {
required: "Required",
},
"r_n_d_activities_FY19[0]": {
required: "Required",
},
"r_n_d_activities_FY18[0]": {
required: "Required",
},
amount_of_r_n_d_expenditure:{
required: "Please Specify Here",
},
details_r_n_d_activities:{
required: "Please Specify Here",
},
innovation_activities_last_3_yr:{
required: "Please Specify Here",
},
how_impact_innovation:{
required: "Please Specify Here",
},
registered_patents_for_innovation:{
required: "Please Specify Here",
},
award_and_accolades_won_details:{
required: "Please Specify Here",
},

}
});
$("#digital_initiative").validate({
rules: {

year_of_launch:{
required: true,
},
total_turnover_FY20:{
required: true,
},
total_turnover_FY19:{
required: true,
},
total_turnover_FY18:{
required: true,
},
export_turnover_FY20:{
required: true,
},
export_turnover_FY19:{
required: true,
},
export_turnover_FY18:{
required: true,
},
share_of_turnover_FY20:{
required: true,
},
share_of_turnover_FY19:{
required: true,
},
share_of_turnover_FY18:{
required: true,
},
no_of_clients_FY20:{
required: true,
},
no_of_clients_FY19:{
required: true,
},
no_of_clients_FY18:{
required: true,
},
isArea1:{
required: true,
},
isArea2:{
required: true,
},
isArea3:{
required: true,
},
isArea4:{
required: true,
},
isArea5:{
required: true,
},
isArea6:{
required: true,
},
isArea7:{
required: true,
},
initiatives1:{
required: true,
},
impact1:{
required: true,
},
initiatives2:{
required: true,
},
impact2:{
required: true,
},
initiatives3:{
required: true,
},
impact3:{
required: true,
},
initiatives4:{
required: true,
},
impact4:{
required: true,
},
initiatives5:{
required: true,
},
impact5:{
required: true,
},
initiatives6:{
required: true,
},
impact6:{
required: true,
},
initiatives7:{
required: true,
},
impact7:{
required: true,
},
},
messages: {

year_of_launch:{
required: "Year of Launch Required",
},
total_turnover_FY20:{
required: "Required",
},
total_turnover_FY19:{
required: "Required",
},
total_turnover_FY18:{
required: "Required",
},
export_turnover_FY20:{
required: "Required",
},
export_turnover_FY19:{
required: "Required",
},
export_turnover_FY18:{
required: "Required",
},
share_of_turnover_FY20:{
required: "Required",
},
share_of_turnover_FY19:{
required: "Required",
},
share_of_turnover_FY18:{
required: "Required",
},
no_of_clients_FY20:{
required: "Required",
},
no_of_clients_FY19:{
required: "Required",
},
no_of_clients_FY18:{
required: "Required",
},
isArea1:{
required: "Required",
},
isArea2:{
required: "Required",
},
isArea3:{
required: "Required",
},
isArea4:{
required: "Required",
},
isArea5:{
required: "Required",
},
isArea6:{
required: "Required",
},
isArea7:{
required: "Required",
},
initiatives1:{
required: "Required",
},
impact1:{
required: "Required",
},
initiatives2:{
required: "Required",
},
impact2:{
required: "Required",
},
initiatives3:{
required: "Required",
},
impact3:{
required: "Required",
},
initiatives4:{
required: "Required",
},
impact4:{
required: "Required",
},
initiatives5:{
required: "Required",
},
impact5:{
required: "Required",
},
initiatives6:{
required: "Required",
},
impact6:{
required: "Required",
},
initiatives7:{
required: "Required",
},
impact7:{
required: "Required",
},

}
});
$("#socially_responsible").validate({
rules: {

csr_exp_amount_FY20:{
required: true,
},
csr_exp_amount_FY19:{
required: true,
},
csr_exp_amount_FY18:{
required: true,
},
csr_exp_amount_spent_directly_FY20:{
required: true,
},
csr_exp_amount_spent_directly_FY19:{
required: true,
},
csr_exp_amount_spent_directly_FY18:{
required: true,
},
csr_exp_amount_through_trust_FY20:{
required: true,
},
csr_exp_amount_through_trust_FY19:{
required: true,
},
csr_exp_amount_through_trust_FY18:{
required: true,
},
csr_details:{
    required: true,
},
trust_ngo_details:{
    required: true,
},
no_of_employee_FY20:{
    required: true,
},
no_of_employee_FY19:{
    required: true,
},
no_of_employee_FY18:{
    required: true,
},
awards_accolades_details:{
    required: true,
}
},
messages: {

csr_exp_amount_FY20:{
required: "Required",
},
csr_exp_amount_FY19:{
required: "Required",
},
csr_exp_amount_FY18:{
required: "Required",
},
csr_exp_amount_spent_directly_FY20:{
required: "Required",
},
csr_exp_amount_spent_directly_FY19:{
required: "Required",
},
csr_exp_amount_spent_directly_FY18:{
required: "Required",
},
csr_exp_amount_through_trust_FY20:{
required: "Required",
},
csr_exp_amount_through_trust_FY19:{
required: "Required",
},
csr_exp_amount_through_trust_FY18:{
required: "Required",
},
csr_details:{
    required: "Please Specify Here" ,
},
trust_ngo_details:{
    required: "Please Specify Here",
},
no_of_employee_FY20:{
    required: "No. of Employees Required",
},
no_of_employee_FY19:{
    required: " No. of Employees Required",
},
no_of_employee_FY18:{
    required: " No. of Employees Required",
},
awards_accolades_details:{
    required: " No. of Employees Required",
}
}
});

$("#woman_entrepreneur").validate({
rules: {
entrepreneur_name:{
required: true,
},
no_of_years_in_business:{
required: true,
},
current_designation:{
required: true,
},
prev_management_details:{
required: true,
},
details_of_inititative_taken:{
required: true,
},
details_of_past_engagements:{
required: true,
},
contribution_to_innovation:{
required: true,
},
awards_accolades_details:{
required: true,
},
},
messages: {
entrepreneur_name:{
required: "Please Specify Here",
},
no_of_years_in_business:{
required: "Please Specify Here",
},
current_designation:{
required: "Please Specify Here",
},
prev_management_details:{
required: "Please Specify Here",
},
details_of_inititative_taken:{
required: "Please Specify Here",
},
details_of_past_engagements:{
required: "Please Specify Here",
},
contribution_to_innovation:{
required: "Please Specify Here",
},
awards_accolades_details:{
required: "Please Specify Here",
},
}
});
$("#award_cat_specific_info").validate({
rules: {
"check_applicable_FY20[8]":{
required: true,
},
"check_applicable_FY20[7]":{
required: true,
},
"check_applicable_FY20[6]":{
required: true,
},
"check_applicable_FY20[5]":{
required: true,
},
"check_applicable_FY20[4]":{
required: true,
},
"check_applicable_FY20[3]":{
required: true,
},
"check_applicable_FY20[2]":{
required: true,
},
"check_applicable_FY20[1]":{
required: true,
},
"check_applicable_FY20[0]":{
required: true,
},
"check_applicable_FY19[8]":{
required: true,
},
"check_applicable_FY19[7]":{
required: true,
},
"check_applicable_FY19[6]":{
required: true,
},
"check_applicable_FY19[5]":{
required: true,
},
"check_applicable_FY19[4]":{
required: true,
},
"check_applicable_FY19[3]":{
required: true,
},
"check_applicable_FY19[2]":{
required: true,
},
"check_applicable_FY19[1]":{
required: true,
},
"check_applicable_FY19[0]":{
required: true,
},
"check_applicable_FY18[8]":{
required: true,
},
"check_applicable_FY18[7]":{
required: true,
},
"check_applicable_FY18[6]":{
required: true,
},
"check_applicable_FY18[5]":{
required: true,
},
"check_applicable_FY18[4]":{
required: true,
},
"check_applicable_FY18[3]":{
required: true,
},
"check_applicable_FY18[2]":{
required: true,
},
"check_applicable_FY18[1]":{
required: true,
},
"check_applicable_FY18[0]":{
required: true,
},
"total_sales_FY20[]":{
required: true,
},
"domestic_sales_FY20[]":{
required: true,
},
"export_sales_FY20[]":{
required: true,
},
"net_profit_FY20[]":{
required: true,
},
"value_addition_FY20[]":{
required: true,
},
"calc_value_addition_FY20[]":{
required: true,
},
"total_sales_FY19[]":{
required: true,
},
"domestic_sales_FY19[]":{
required: true,
},
"export_sales_FY19[]":{
required: true,
},
"net_profit_FY19[]":{
required: true,
},
"value_addition_FY19[]":{
required: true,
},
"calc_value_addition_FY19[]":{
required: true,
},
"total_sales_FY18[]":{
required: true,
},
"domestic_sales_FY18[]":{
required: true,
},
"export_sales_FY18[]":{
required: true,
},
"net_profit_FY18[]":{
required: true,
},
"value_addition_FY18[]":{
required: true,
},
"calc_value_addition_FY18[]":{
required: true,
},




},
messages: {
"check_applicable_FY20[8]":{
required: "Required",
},
"check_applicable_FY20[7]":{
required: "Required",
},
"check_applicable_FY20[6]":{
required: "Required",
},
"check_applicable_FY20[5]":{
required: "Required",
},
"check_applicable_FY20[4]":{
required: "Required",
},
"check_applicable_FY20[3]":{
required: "Required",
},
"check_applicable_FY20[2]":{
required: "Required",
},
"check_applicable_FY20[1]":{
required: "Required",
},
"check_applicable_FY20[0]":{
required: "Required",
},
"check_applicable_FY19[8]":{
required: "Required",
},
"check_applicable_FY19[7]":{
required: "Required",
},
"check_applicable_FY19[6]":{
required: "Required",
},
"check_applicable_FY19[5]":{
required: "Required",
},
"check_applicable_FY19[4]":{
required: "Required",
},
"check_applicable_FY19[3]":{
required: "Required",
},
"check_applicable_FY19[2]":{
required: "Required",
},
"check_applicable_FY19[1]":{
required: "Required",
},
"check_applicable_FY19[0]":{
required: "Required",
},
"check_applicable_FY18[8]":{
required: "Required",
},
"check_applicable_FY18[7]":{
required: "Required",
},
"check_applicable_FY18[6]":{
required: "Required",
},
"check_applicable_FY18[5]":{
required: "Required",
},
"check_applicable_FY18[4]":{
required: "Required",
},
"check_applicable_FY18[3]":{
required: "Required",
},
"check_applicable_FY18[2]":{
required: "Required",
},
"check_applicable_FY18[1]":{
required: "Required",
},
"check_applicable_FY18[0]":{
required: "Required",
},
"total_sales_FY20[]":{
required: "Required",
},
"domestic_sales_FY20[]":{
required: "Required",
},
"export_sales_FY20[]":{
required: "Required",
},
"net_profit_FY20[]":{
required: "Required",
},
"value_addition_FY20[]":{
required: "Required",
},
"calc_value_addition_FY20[]":{
required: "Required",
},
"total_sales_FY19[]":{
required: "Required",
},
"domestic_sales_FY19[]":{
required: "Required",
},
"export_sales_FY19[]":{
required: "Required",
},
"net_profit_FY19[]":{
required: "Required",
},
"value_addition_FY19[]":{
required: "Required",
},
"calc_value_addition_FY19[]":{
required: "Required",
},
"total_sales_FY18[]":{
required: "Required",
},
"domestic_sales_FY18[]":{
required: "Required",
},
"export_sales_FY18[]":{
required: "Required",
},
"net_profit_FY18[]":{
required: "Required",
},
"value_addition_FY18[]":{
required: "Required",
},
"calc_value_addition_FY18[]":{
required: "Required",
},
}
});

$("#best_growing_perfomance").validate({
rules: {
// "export_details_FY20[]":{
//  required: true,
// },
//  "export_details_FY19[]":{
//  required: true,
// },
// "export_details_FY18[]":{
//  required: true,
// },
// "country_FY20[0]":{
//  required: true,
// },
// "country_FY19[0]":{
//  required: true,
// },
//  "export_sales_rs_FY20[0]":{
//  required: true,
// },
// "export_sales_rs_FY19[0]":{
//  required: true,
// },
// "export_sales_dollar_FY20[0]":{
//  required: true,
// },
// "export_sales_dollar_FY19[0]":{
//  required: true,
// },
//  "country_FY20[1]":{
//  required: true,
// },
// "country_FY19[1]":{
//  required: true,
// },
//  "export_sales_rs_FY20[1]":{
//  required: true,
// },
// "export_sales_rs_FY19[1]":{
//  required: true,
// },
// "export_sales_dollar_FY20[1]":{
//  required: true,
// },
// "export_sales_dollar_FY19[1]":{
//  required: true,
// },
//  "country_FY20[2]":{
//  required: true,
// },
// "country_FY19[2]":{
//  required: true,
// },
//  "export_sales_rs_FY20[2]":{
//  required: true,
// },
// "export_sales_rs_FY19[2]":{
//  required: true,
// },
// "export_sales_dollar_FY20[2]":{
//  required: true,
// },
// "export_sales_dollar_FY19[2]":{
//  required: true,
// },
// "country_FY20[3]":{
//  required: true,
// },
// "country_FY19[3]":{
//  required: true,
// },
//  "export_sales_rs_FY20[3]":{
//  required: true,
// },
// "export_sales_rs_FY19[3]":{
//  required: true,
// },
// "export_sales_dollar_FY20[3]":{
//  required: true,
// },
// "export_sales_dollar_FY19[3]":{
//  required: true,
// },
//   "country_FY20[4]":{
//  required: true,
// },
// "country_FY19[4]":{
//  required: true,
// },
//  "export_sales_rs_FY20[4]":{
//  required: true,
// },
// "export_sales_rs_FY19[4]":{
//  required: true,
// },
// "export_sales_dollar_FY20[4]":{
//  required: true,
// },
// "export_sales_dollar_FY19[4]":{
//  required: true,
// },
// "business_details_and_explanation":{
//  required: true,
// },
//  "strategic_export_initiative":{
//  required: true,
// },

// "key_insights":{
//  required: true,
// },


},
messages: {
//    "export_details_FY20[]":{
//  required: "Required",
// },
//  "export_details_FY19[]":{
//  required: "Required",
// },
// "export_details_FY18[]":{
//  required: "Required",
// },
// "country_FY20[0]":{
//  required: "Required",
// },
// "country_FY19[0]":{
//  required: "Required",
// },
//  "export_sales_rs_FY20[0]":{
//  required: "Required",
// },
// "export_sales_rs_FY19[0]":{
//  required: "Required",
// },
// "export_sales_dollar_FY20[0]":{
//  required: "Required",
// },
// "export_sales_dollar_FY19[0]":{
//  required: "Required",
// },
//  "country_FY20[1]":{
//  required: "Required",
// },
// "country_FY19[1]":{
//  required: "Required",
// },
//  "export_sales_rs_FY20[1]":{
//  required: "Required",
// },
// "export_sales_rs_FY19[1]":{
//  required: "Required",
// },
// "export_sales_dollar_FY20[1]":{
//  required: "Required",
// },
// "export_sales_dollar_FY19[1]":{
//  required: "Required",
// },
//  "country_FY20[2]":{
//  required: "Required",
// },
// "country_FY19[2]":{
//  required: "Required",
// },
//  "export_sales_rs_FY20[2]":{
//  required: "Required",
// },
// "export_sales_rs_FY19[2]":{
//  required: "Required",
// },
// "export_sales_dollar_FY20[2]":{
//  required: "Required",
// },
// "export_sales_dollar_FY19[2]":{
//  required: "Required",
// },
//   "country_FY20[3]":{
//  required: "Required",
// },
// "country_FY19[3]":{
//  required: "Required",
// },
//  "export_sales_rs_FY20[3]":{
//  required: "Required",
// },
// "export_sales_rs_FY19[3]":{
//  required: "Required",
// },
// "export_sales_dollar_FY20[3]":{
//  required: "Required",
// },
// "export_sales_dollar_FY19[3]":{
//  required: "Required",
// },
//  "country_FY20[4]":{
//  required: "Required",
// },
// "country_FY19[4]":{
//  required: "Required",
// },
//  "export_sales_rs_FY20[4]":{
//  required: "Required",
// },
// "export_sales_rs_FY19[4]":{
//  required: "Required",
// },
// "export_sales_dollar_FY20[4]":{
//  required: "Required",
// },
// "export_sales_dollar_FY19[4]":{
//  required: "Required",
// },

// "business_details_and_explanation":{
//  required: "Please Specify Here",
// },
//  "strategic_export_initiative":{
//  required: "Please Specify Here",
// },

// "key_insights":{
//  required: "Please Specify Here",
// },
}
});

$("#qualitative_information").validate({
rules: {


is_mandatory:{
required: true,
},
mandatory_details:{
required: function(element){
return $("input[name='is_mandatory']").val()=="Yes";
}
},



},
messages: {

is_mandatory:{
required: "Please Specify Here"
},
mandatory_details:{
required: "Please Specify Here"
},


}
});
$("#declaration").validate({
rules: {
respondant_name:{
required: true,
},
designation:{
required: true,
},
mobile:{
required: true,

},
email_id:{
required: true,
email:true
},
ca_firm_name:{
required: true,
},
ca_name:{
required: true,
},
ca_designation:{
required: true,
},
ca_mobile:{
    required: true,
},
ca_email:{
    required: true,
    email:true
}

},
messages: {
respondant_name:{
required:'Enter Respondant name'
},
designation:{
required: 'Enter Designation',
},
mobile:{
required: 'Enter Mobile No',
},
email_id:{
required: 'Enter Email ID',
},
ca_firm_name:{
required: 'Enter CA Firm Name',
},
ca_name:{
required: "Enter Individual Name",
},
ca_designation:{
required: "Enter Designation ",
},
ca_mobile:{
    required: "Enter Mobile Number",
},
ca_email:{
    required: "Enter Email Id",
}


}
});
$('.check_applicable').click(function(){
    var val = $(this).val();
    if(val =="Yes"){
        $(this).parent('label').parent('td').siblings().children('.form-control').val('');
        $(this).parent('label').parent('td').siblings().not(":eq(0)").append("<label  class='error d-block' >Required</label>");
    }else{
        $(this).parent('label').parent('td').siblings().children('.form-control').val('NA');
$(this).parent('label').parent('td').siblings().children('label').remove();
    }
});
$('.numeric').keypress(function (event) {
var keycode = event.which;
if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
event.preventDefault();
}
});
$("input[name='is_mandatory']").change(function(){
if($(this).val()=="No"){
$("textarea[name='mandatory_details']").val("NA");
}else if($(this).val()=="Yes" && $("input[name='mandatory_details']").val("NA")){
$("textarea[name='mandatory_details']").val("");
}
});
$('.select_area').change(function(){
if($(this).val()=="No"){
$(this).parent('label').parent('td').siblings().children('textarea').val("NA");
}else{
$(this).parent('label').parent('td').siblings().children('textarea').val("");
}
});
$(".category_table .form-control").keyup(function(){
var val = $(this).val();
var label = $(this).attr('name');

if(val !=""){
$(this).siblings('.error').html("");
}
});

});
</script>

<style>
    select {
    -webkit-appearance: auto;
}
    .card-body .row {border: 0; padding: 0; margin-bottom: 0;}
    .award_input_box label input {left: 0;}
    .award_input_box label {padding-left: 30px;}
    .responsive_table tr{background: #f1f1f1!important;}
</style>