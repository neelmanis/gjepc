<?php
include 'db.inc.php';
include 'functions.php';
// error_reporting(E_ALL);
 //ini_set('display_errors', 1);

$table = $display = ""; 
$fn = "nomination-form-importer";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Id</td>
<td>Created Date</td>
<td>Company name</td>
<td>Year of Establishment</td>
<td>Tel No.</td>
<td>Email ID</td>
<td>Company Website</td>
<td>Address</td>
<td>Address Line 2</td>
<td>City</td>
<td>Country</td>
<td>Zipcode</td>
<td>Company Type/td>
<td>Senior Management Name</td>
<td>Senior Management Designation</td>
<td>Imports from India 2021</td>
<td>Imports from India 2020</td>
<td>Imports from India 2019</td>
<td>Import Value from India  2021</td>
<td>Import Value from India  2020</td>
<td>Import Value from India  2019</td>
<td>Total Imports 2021 (in Carat)</td>
<td>Total Imports 2020 (in Carat)</td>
<td>Total Imports 2019 (in Carat)</td>
<td>Total Import Value 2021(in USD)</td>
<td>Total Import Value 2020(in USD)</td>
<td>Total Import Value 2019(in USD)</td>
<td>Type of products imported from India  2021</td>
<td>Type of products imported from India  2020</td>
<td>Type of products imported from India  2019</td>
<td>Contribution of sales imported from India as compare to overall sales 2021</td>
<td>Contribution of sales imported from India as compare to overall sales 2020</td>
<td>Contribution of sales imported from India as compare to overall sales 2019</td>
<td>Total Number of Indian firms you are trading with</td>
<td>Do you have offices in India</td>
<td>Location</td>
<td>Details of Award won in the past by an International Association</td>


<td>Respondant Name</td>
<td>Respondant Designation</td>
<td>Respondant Mobile</td>
<td>Respondant Email</td>
<td>Chartered CA Firm</td>
<td>Chartered  Name</td>
<td>Chartered  Designation</td>
<td>Chartered  Mobile</td>
<td>Chartered  Email</td>
<td>Status</td>
</tr>';

$sql="SELECT * FROM  igja_gold_supply_awards where STATUS='Y' AND email_id !='sample@email.tst' AND email_id != 1";
$result = $conn->query($sql);   
while(($row = $result->fetch_assoc()) !== null)
{   

    $id=$row['id'];
    $company_name=$row['company_name'];
    $est_year=$row['year'];
    $imp_exp_code=$row['fax_no'];
    $tel_no=$row['tel_no'];
    $email=$row['email_id'];
    $website = $row['website'];
    $address_line_1 = $row['address_line_1'];
    $address_line_2 = $row['address_line_2'];
    $city = $row['city'];
    $state = $row['county'];
    $zipcode = $row['zipcode'];
    $membership_no = $row['membership_no'];
    $membership_year = $row['membership_year'];
    $company_type = $row['company_type_office'];
    $senior_management = unserialize($row['senior_management']);
    $created_at = $row['created_at'];
    $senior_ma = '';$sm_name='';$sm_designation='';
    foreach($senior_management as $x=>$se){
        foreach($se as $key=>$val){
            if($se[$key] != '' ){
                $senior_ma .= $val.', ';
            }
           
        } 
        if($x == "sm_name"){
            foreach($se as $y=>$ex){
                if($se[$y] != ''){
                    $sm_name .= $ex.',';
                }
                
            }
           
        }
        if($x == "sm_designation"){
            foreach($se as $y=>$ex){
                if($se[$y] != '' ){
                    $sm_designation .= $ex.',';
                }
                
            }
        }
    }
    $performance = '';
    $performance_award_category = explode('_',$row['performance_award_category']);
    foreach($performance_award_category as $pe){
        $performance .= $pe.',';
    }
    $theme = '';
    $theme_based_award_category = explode('_',$row['theme_based_award_category']);
    foreach($theme_based_award_category as $pe){
      
        if($pe == 'New Business Award'){
            $pe = 'Upcoming Exporter of the year';
        }
        $theme .= $pe.',';
    }
    $other = '';
    $other_award_category = explode('_',$row['other_award_category']);
    foreach($other_award_category as $pe){
        if($pe == 'New Business Award'){
            $pe = 'Upcoming Exporter of the year';
        }
        $other .= $pe.',';
    }
    $end_year = $row['end_year'];
    $company_det = '';
    $company_details = unserialize($row['finance_details']);
    //print_r($company_details);die();
    $total_income_FY20 = $company_details['FY20'][0];
    $total_income_FY19 = $company_details['FY19'][0];
    $total_income_FY18 = $company_details['FY18'][0];
    $total_sale_FY20=$company_details['FY20'][1];
    $total_sale_FY19=$company_details['FY19'][1];
    $total_sale_FY18=$company_details['FY18'][1];
    $domestic_sales_FY20 = $company_details['FY20'][2];
    $domestic_sales_FY19 = $company_details['FY19'][2];
    $domestic_sales_FY18 = $company_details['FY18'][2];
    $exports_FY20 = $company_details['FY20'][3];
    $exports_FY19 = $company_details['FY19'][3];
    $exports_FY18 = $company_details['FY18'][3];
    $net_profit_FY20 = $company_details['FY20'][4];
    $net_profit_FY19 = $company_details['FY19'][4];
    $net_profit_FY18 = $company_details['FY18'][4];
    $permenant_employees_FY20 = $company_details['FY20'][5];
    $permenant_employees_FY19 = $company_details['FY19'][5];
    $permenant_employees_FY18 = $company_details['FY18'][5];
    
    
    $gold_supp_details = unserialize($row['gold_supp_details']);
    $indian_firms =  $gold_supp_details['gold_supp_details_FY20'][0];
    $company_type_office =  $gold_supp_details['company_type_office'];
    $location =  $gold_supp_details['location'];    
    $gold_supp_details_FY20[2] =  $gold_supp_details['gold_supp_details_FY20[2]'][0];

    //$sql_query = "SELECT * FROM  igja_best_bank_financing_award where reg_id=$id ORDER BY id desc";
    $declaration = unserialize($row['respondant_details']);
    //print_r($row);die();
    $respondant_name = $declaration['respondant_details'];
    $designation = $declaration['designation'];
    $mobile = $declaration['mobile'];
    $email_id = $declaration['email_id'];
    $ca_details = unserialize($row['ca_details']);
    $ca_firm_name = $ca_details['ca_firm_name'];
    $ca_name = $ca_details['ca_name'];
    $ca_designation = $ca_details['ca_designation'];
    $ca_mobile = $ca_details['ca_mobile'];
    $ca_email = $ca_details['ca_email'];
    $status = $row['status'];
    
    $table .= '<tr>
    <td>'.$id.'</td>
    <td>'.$created_at.'</td>
    <td>'.$company_name.'</td>
    <td>'.$est_year.'</td>
    <td>'.$tel_no.'</td>
    <td>'.$email.'</td>
    <td>'.$website.'</td>
    <td>'.$address_line_1.'</td>
    <td>'.$address_line_2.'</td>
    <td>'.$city.'</td>
    <td>'.$state.'</td>
    <td>'.$zipcode.'</td>
    <td>'.$company_type.'</td>
    <td>'.$sm_name.'</td>
    <td>'.$sm_designation.'</td>
    <td>'.$total_income_FY20.'</td>
    <td>'.$total_income_FY19.'</td>
    <td>'.$total_income_FY18.'</td>
    <td>'.$total_sale_FY20.'</td>
    <td>'.$total_sale_FY19.'</td>
    <td>'.$total_sale_FY18.'</td>
    <td>'.$domestic_sales_FY20.'</td>
    <td>'.$domestic_sales_FY19.'</td>
    <td>'.$domestic_sales_FY18.'</td>
    <td>'.$exports_FY20.'</td>
    <td>'.$exports_FY19.'</td>
    <td>'.$exports_FY18.'</td>
    <td>'.$net_profit_FY20.'</td>
    <td>'.$net_profit_FY19.'</td>
    <td>'.$net_profit_FY18.'</td>
    <td>'.$permenant_employees_FY20.'</td>
    <td>'.$permenant_employees_FY19.'</td>
    <td>'.$permenant_employees_FY18.'</td>
    <td>'.$indian_firms.'</td>    
    <td>'.$company_type_office.'</td>    
    <td>'.$location.'</td>    
    <td>'.$gold_supp_details_FY20[2].'</td>    


    <td>'.$respondant_name.'</td>
    <td>'.$designation.'</td>
    <td>'.$mobile.'</td>
    <td>'.$email_id.'</td>
    <td>'.$ca_firm_name.'</td>
    <td>'.$ca_name.'</td>
    <td>'.$ca_designation.'</td>
    <td>'.$ca_mobile.'</td>
    <td>'.$ca_email.'</td>
    <td>'.$status.'</td>
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