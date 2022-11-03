<?php
include 'db.inc.php';
include 'functions.php';
// error_reporting(E_ALL);
 //ini_set('display_errors', 1);

$query = "SELECT * FROM   igja_industry_performance_and_theme_based_awards";
$table = $display = ""; 
$fn = "nomination-form-bank-financing-the-Industry_excel";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Id</td>
<td>Created Date</td>
<td>Bank name</td>
<td>Year of Establishment</td>
<td>Fax No</td>
<td>Tel No.</td>
<td>Email ID</td>
<td>Company Website</td>
<td>Address</td>
<td>Address Line 2</td>
<td>City</td>
<td>State</td>
<td>Zipcode</td>
<td>Company Type</td>
<td>Senior Management Name</td>
<td>Senior Management Designation</td>
<td>Total Income 2021</td>
<td>Total Income 2020</td>
<td>Total Income 2019</td>
<td>Total lending to Gems and Jewellery Sector 2021 (Rs.Crore)</td>
<td>Total lending to Gems and Jewellery Sector 2020 (Rs.Crore)</td>
<td>Total lending to Gems and Jewellery Sector 2019 (Rs.Crore)</td>
<td>Total Export Finance sanctioned  2021</td>
<td>Total Export Finance sanctioned  2020</td>
<td>Total Export Finance sanctioned  2019</td>

<td>Export finance sanctioned for Gems & Jewellery Sector 2021(Rs.Crore)</td>
<td>Export finance sanctioned for Gems & Jewellery Sector 2020(Rs.Crore)</td>
<td>Export finance sanctioned for Gems & Jewellery Sector 2019(Rs.Crore)</td>
<td>Total loans outstanding in Gems and Jewellery Sector  2021(Rs.Crore)</td>
<td>Total loans outstanding in Gems and Jewellery Sector  2020(Rs.Crore)</td>
<td>Total loans outstanding in Gems and Jewellery Sector  2019(Rs.Crore)</td>
<td>Total number of exporters from Gems & Jewellery sector financed 2021</td>
<td>Total number of exporters from Gems & Jewellery sector financed 2020</td>
<td>Total number of exporters from Gems & Jewellery sector financed 2019</td>
<td>Total NPAs 2021</td>
<td>Total NPAs 2020</td>
<td>Total NPAs 2019</td>
<td>End Year</td>


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

$sql="SELECT * FROM  igja_best_bank_financing_award";
$result = $conn->query($sql);   
while(($row = $result->fetch_assoc()) !== null)
{   

    $id=$row['id'];
    $company_name=$row['bank_name'];
    $est_year=$row['year'];
    $imp_exp_code=$row['imp_exp_code'];
    $tel_no=$row['tel_no'];
    $fax_no=$row['fax_no'];
    $email=$row['email_id'];
    $website = $row['website'];
    $address_line_1 = $row['address_line_1'];
    $address_line_2 = $row['address_line_2'];
    $city = $row['city'];
    $state = $row['state'];
    $zipcode = $row['zipcode'];
    $membership_no = $row['membership_no'];
    $membership_year = $row['membership_year'];
    $company_type = $row['bank_type'];
    $nature_of_business = $row['nature_of_business'];
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
    
    $total_income_FY20 = $company_details['FY20'][0];
    $total_income_FY19 = $company_details['FY19'][0];
    $total_income_FY18 = $company_details['FY18'][0];
    $domestic_sales_FY20 = $company_details['FY20'][2];
    $domestic_sales_FY19 = $company_details['FY19'][2];
    $domestic_sales_FY18 = $company_details['FY18'][2];
    $total_sale_FY20=$company_details['FY20'][1];
    $total_sale_FY19=$company_details['FY19'][1];
    $total_sale_FY18=$company_details['FY18'][1];   
    $exports_FY20 = $company_details['FY20'][3];
    $exports_FY19 = $company_details['FY19'][3];
    $exports_FY18 = $company_details['FY18'][3];
    $net_profit_FY20 = $company_details['FY20'][4];
    $net_profit_FY19 = $company_details['FY19'][4];
    $net_profit_FY18 = $company_details['FY18'][4];
    $permenant_employees_FY20 = $company_details['FY20'][5];
    $permenant_employees_FY19 = $company_details['FY19'][5];
    $permenant_employees_FY18 = $company_details['FY18'][5];
    $contractual_employees_FY20 = $company_details['FY20'][6];
    $contractual_employees_FY19 = $company_details['FY19'][6];
    $contractual_employees_FY18 = $company_details['FY18'][6];
    
    
    //$sql_query = "SELECT * FROM  igja_best_bank_financing_award where reg_id=$id ORDER BY id desc";
    $declaration = unserialize($row['respondant_details']);

    $respondant_name = $declaration['respondant_name'];
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
    <td>'.$fax_no.'</td>
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
    <td>'.$contractual_employees_FY20.'</td>
    <td>'.$contractual_employees_FY19.'</td>
    <td>'.$contractual_employees_FY18.'</td>
    <td>'.$end_year.'</td>    


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