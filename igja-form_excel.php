<?php
include 'db.inc.php';
include 'functions.php';
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$query = "SELECT * FROM igja_industry_performance_and_theme_based_awards";
$table = $display = ""; 
$fn = "report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Id</td>
<td>Created Date</td>
<td>company name</td>
<td>Year of Establishment</td>
<td>Importer Exporter Code No.</td>
<td>Tel No.</td>
<td>Email ID</td>
<td>Company Website</td>
<td>Address.</td>
<td>Address Line 2</td>
<td>City</td>
<td>State</td>
<td>Zipcode</td>
<td>GJEPC Membership Registration</td>
<td>Year of acquiring GJEPC Membership</td>
<td>Ownership Pattern</td>
<td>Nature of Operation</td>
<td>Senior Management Name</td>
<td>Senior Management Designation</td>
<td>Industry Performance Awards Categories</td>
<td>Theme based Award Categories</td>
<td>Other Categories</td>
<td>Total Income 2021</td>
<td>Total Income 2020</td>
<td>Total Income 2019</td>
<td>Total Sales 2021 (Rs.Crore)</td>
<td>Total Sales 2020 (Rs.Crore)</td>
<td>Total Sales 2019 (Rs.Crore)</td>
<td>Domestic Sales 2021(Rs.Crore)</td>
<td>Domestic Sales 2020(Rs.Crore)</td>
<td>Domestic Sales 2019(Rs.Crore)</td>
<td>Export Sales 2021(Rs.Crore)</td>
<td>Export Sales 2020(Rs.Crore)</td>
<td>Export Sales 2019(Rs.Crore)</td>
<td>Net Profit 2021</td>
<td>Net Profit 2020</td>
<td>Net Profit 2019</td>
<td>Permenant Employees 2021</td>
<td>Permenant Employees 2020</td>
<td>Permenant Employees 2019</td>
<td>Contractual Employees (FY2021-2020)</td>
<td>Contractual Employees (FY2020-2019)</td>
<td>Contractual Employees (FY2019-2018)</td>
<td>Other Employees 2021</td>
<td>Other Employees 2020</td>
<td>Other Employees 2019</td>
<td>Incm Tax Paid 2021</td>
<td>Incm Tax Paid 2020</td>
<td>Incm Tax Paid 2019</td>

<td>Precious Metal Jewellery - Plain FY 2020-21 (Y/N)</td>
<td>Total Sales in Cr FY 2020-21</td>
<td>Domestic Sales in Cr Fy 2020-21</td>
<td>Export Sales in Cr FY 2020-21</td>
<td>Net Profit in Cr FY 2020-21</td>
<td>Value Addition (%) FY 2020-21</td>
<td>Calculations of Value Addition FY 2020-21</td>
<td>Precious Metal Jewellery - Plain FY 2019-2020 (Y/N)</td>
<td>Total Sales in Cr FY 2019-2020</td>
<td>Domestic Sales in Cr Fy 2019-2020</td>
<td>Export Sales in Cr FY 2019-2020</td>
<td>Net Profit in Cr FY 2019-2020</td>
<td>Value Addition (%) FY 2019-2020</td>
<td>Calculations of Value Addition FY 2019-2020</td>
<td>Precious Metal Jewellery - Plain FY 2019-2018 (Y/N)</td>
<td>Total Sales in Cr FY 2019-18</td>
<td>Domestic Sales in Cr Fy 2019-18</td>
<td>Export Sales in Cr FY 2019-18</td>
<td>Net Profit in Cr FY 2019-18</td>
<td>Value Addition (%) FY 2019-18</td>
<td>Calculations of Value Addition FY 2019-18</td>

<td>Precious Metal Jewellery – Studded</td>
<td>Total Sales in Cr FY 2020-21</td>
<td>Domestic Sales in Cr Fy 2020-21</td>
<td>Export Sales in Cr FY 2020-21</td>
<td>Net Profit in Cr FY 2020-21</td>
<td>Value Addition (%) FY 2020-21</td>
<td>Calculations of Value Addition FY 2020-21</td>
<td>Precious Metal Jewellery – Studded</td>
<td>Total Sales in Cr FY 2019-20</td>
<td>Domestic Sales in Cr Fy 2019-20</td>
<td>Export Sales in Cr FY 2019-20</td>
<td>Net Profit in Cr FY 2019-20</td>
<td>Value Addition (%) FY 2019-20</td>
<td>Calculations of Value Addition FY 2019-20</td>
<td>Precious Metal Jewellery – Studded</td>
<td>Total Sales in Cr FY 2019-18</td>
<td>Domestic Sales in Cr Fy 2019-18</td>
<td>Export Sales in Cr FY 2019-18</td>
<td>Net Profit in Cr FY 2019-18</td>
<td>Value Addition (%) FY 2019-18</td>
<td>Calculations of Value Addition FY 2019-18</td>

<td>Precious Metal Jewellery – Plain & Studded</td>
<td>Total Sales in Cr FY 2020-21</td>
<td>Domestic Sales in Cr Fy 2020-21</td>
<td>Export Sales in Cr FY 2020-21</td>
<td>Net Profit in Cr FY 2020-21</td>
<td>Value Addition (%) FY 2020-21</td>
<td>Calculations of Value Addition FY 2020-21</td>
<td>Precious Metal Jewellery – Plain & Studded</td>
<td>Total Sales in Cr FY 2019-20</td>
<td>Domestic Sales in Cr Fy 2019-20</td>
<td>Export Sales in Cr FY 2019-20</td>
<td>Net Profit in Cr FY 2019-20</td>
<td>Value Addition (%) FY 2019-20</td>
<td>Calculations of Value Addition FY 2019-20</td>
<td>Precious Metal Jewellery – Plain & Studded</td>
<td>Total Sales in Cr FY 2019-18</td>
<td>Domestic Sales in Cr Fy 2019-18</td>
<td>Export Sales in Cr FY 2019-18</td>
<td>Net Profit in Cr FY 2019-18</td>
<td>Value Addition (%) FY 2019-18</td>
<td>Calculations of Value Addition FY 2019-18</td>

<td>Silver Jewellery</td>
<td>Total Sales in Cr FY 2020-21</td>
<td>Domestic Sales in Cr Fy 2020-21</td>
<td>Export Sales in Cr FY 2020-21</td>
<td>Net Profit in Cr FY 2020-21</td>
<td>Value Addition (%) FY 2020-21</td>
<td>Calculations of Value Addition FY 2020-21</td>
<td>Silver Jewellery</td>
<td>Total Sales in Cr FY 2019-20</td>
<td>Domestic Sales in Cr Fy 2019-20</td>
<td>Export Sales in Cr FY 2019-20</td>
<td>Net Profit in Cr FY 2019-20</td>
<td>Value Addition (%) FY 2019-20</td>
<td>Calculations of Value Addition FY 2019-20</td>
<td>Silver Jewellery</td>
<td>Total Sales in Cr FY 2019-18</td>
<td>Domestic Sales in Cr Fy 2019-18</td>
<td>Export Sales in Cr FY 2019-18</td>
<td>Net Profit in Cr FY 2019-18</td>
<td>Value Addition (%) FY 2019-18</td>
<td>Calculations of Value Addition FY 2019-18</td>

<td>Cut & Polished Diamonds</td>
<td>Total Sales in Cr FY 2020-21</td>
<td>Domestic Sales in Cr Fy 2020-21</td>
<td>Export Sales in Cr FY 2020-21</td>
<td>Net Profit in Cr FY 2020-21</td>
<td>Value Addition (%) FY 2020-21</td>
<td>Calculations of Value Addition FY 2020-21</td>
<td>Cut & Polished Diamonds</td>
<td>Total Sales in Cr FY 2019-20</td>
<td>Domestic Sales in Cr Fy 2019-20</td>
<td>Export Sales in Cr FY 2019-20</td>
<td>Net Profit in Cr FY 2019-20</td>
<td>Value Addition (%) FY 2019-20</td>
<td>Calculations of Value Addition FY 2019-20</td>
<td>Cut & Polished Diamonds</td>
<td>Total Sales in Cr FY 2019-18</td>
<td>Domestic Sales in Cr Fy 2019-18</td>
<td>Export Sales in Cr FY 2019-18</td>
<td>Net Profit in Cr FY 2019-18</td>
<td>Value Addition (%) FY 2019-18</td>
<td>Calculations of Value Addition FY 2019-18</td>

<td>Cut & Polished Coloured Gemstones</td>
<td>Total Sales in Cr FY 2020-21</td>
<td>Domestic Sales in Cr Fy 2020-21</td>
<td>Export Sales in Cr FY 2020-21</td>
<td>Net Profit in Cr FY 2020-21</td>
<td>Value Addition (%) FY 2020-21</td>
<td>Calculations of Value Addition FY 2020-21</td>
<td>Cut & Polished Coloured Gemstones</td>
<td>Total Sales in Cr FY 2019-20</td>
<td>Domestic Sales in Cr Fy 2019-20</td>
<td>Export Sales in Cr FY 2019-20</td>
<td>Net Profit in Cr FY 2019-20</td>
<td>Value Addition (%) FY 2019-20</td>
<td>Calculations of Value Addition FY 2019-20</td>
<td>Cut & Polished Coloured Gemstones</td>
<td>Total Sales in Cr FY 2019-18</td>
<td>Domestic Sales in Cr Fy 2019-18</td>
<td>Export Sales in Cr FY 2019-18</td>
<td>Net Profit in Cr FY 2019-18</td>
<td>Value Addition (%) FY 2019-18</td>
<td>Calculations of Value Addition FY 2019-18</td>
<td>Cut & Polished Synthetic Stone</td>
<td>Total Sales in Cr FY 2020-21</td>
<td>Domestic Sales in Cr Fy 2020-21</td>
<td>Export Sales in Cr FY 2020-21</td>
<td>Net Profit in Cr FY 2020-21</td>
<td>Value Addition (%) FY 2020-21</td>
<td>Calculations of Value Addition FY 2020-21</td>
<td>Cut & Polished Synthetic Stone</td>
<td>Total Sales in Cr FY 2019-20</td>
<td>Domestic Sales in Cr Fy 2019-20</td>
<td>Export Sales in Cr FY 2019-20</td>
<td>Net Profit in Cr FY 2019-20</td>
<td>Value Addition (%) FY 2019-20</td>
<td>Calculations of Value Addition FY 2019-20</td>
<td>Cut & Polished Synthetic Stone</td>
<td>Total Sales in Cr FY 2019-18</td>
<td>Domestic Sales in Cr Fy 2019-18</td>
<td>Export Sales in Cr FY 2019-18</td>
<td>Net Profit in Cr FY 2019-18</td>
<td>Value Addition (%) FY 2019-18</td>
<td>Calculations of Value Addition FY 2019-18</td>
<td>Costume/Fashion Jewellery</td>
<td>Total Sales in Cr FY 2020-21</td>
<td>Domestic Sales in Cr Fy 2020-21</td>
<td>Export Sales in Cr FY 2020-21</td>
<td>Net Profit in Cr FY 2020-21</td>
<td>Value Addition (%) FY 2020-21</td>
<td>Calculations of Value Addition FY 2020-21</td>
<td>Costume/Fashion Jewellery</td>
<td>Total Sales in Cr FY 2019-20</td>
<td>Domestic Sales in Cr Fy 2019-20</td>
<td>Export Sales in Cr FY 2019-20</td>
<td>Net Profit in Cr FY 2019-20</td>
<td>Value Addition (%) FY 2019-20</td>
<td>Calculations of Value Addition FY 2019-20</td>
<td>Costume/Fashion Jewellery</td>
<td>Total Sales in Cr FY 2019-18</td>
<td>Domestic Sales in Cr Fy 2019-18</td>
<td>Export Sales in Cr FY 2019-18</td>
<td>Net Profit in Cr FY 2019-18</td>
<td>Value Addition (%) FY 2019-18</td>
<td>Calculations of Value Addition FY 2019-18</td>

<td>Total number of countries your company is exporting to</td>
<td>Details  2020-21</td>
<td>Details 2019-20</td>
<td>Details 2018-19</td>
<td>Total number of non-traditional export markets (Refer to rule no. 18)</td>
<td>Details  2020-21</td>
<td>Details 2019-20</td>
<td>Details 2018-19</td>
<td>Exports sales to non-traditional markets (INR in Crore)</td>
<td>Details  2020-21</td>
<td>Details 2019-20</td>
<td>Details 2018-19</td>
<td>Exports sales to non-traditional markets (in US $)</td>
<td>Details  2020-21</td>
<td>Details 2019-20</td>
<td>Details 2018-19</td>

<td>Country FY2020-21 </td>
<td>Export Sales FY2020-21 (in INR. crore)</td>
<td>Export Sales FY2020-21 (in US $)</td>
<td>Country FY 2019-20 </td>
<td>Export Sales FY 2019-20 (in INR. crore)</td>
<td>Export Sales FY 2019-20 (in US $)</td>
<td>Country FY 2018-2019 </td>
<td>Export Sales FY 2018-2019 (in INR. crore)</td>
<td>Export Sales FY 2018-2019 (in US $)</td>
<td>Business details and explanation financial files details</td>
<td>Strategic Exports Initiatives</td>
<td>Case for Excellence</td>

<td>Business details and explanation financial files details</td>
<td>Business details and explanation related to financial details</td>
<td>Strategic Exports Initiatives</td>
<td>Case for Excellence</td>
<td>Nominated Segment</td>
<td>Number of outlets of Company</td>
<td>Number of International Clients and Importing countries</td>
<td>Title</td>
<td>Name</td>
<td>Designation</td>
<td>Years of Experience</td>
<td>approaches taken up by nominee</td>
<td>Provide details Y/N</td>
<td>Provide details</td>

<td>R&D Activities 1 (Rs Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>R&D Activities 2 (Rs Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>R&D Activities 3 (Rs Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>R&D Activities 4 (Rs Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>R&D Activities 5 (Rs Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>R&D Activities 6 (Rs Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>R&D Activities 7 (Rs Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>R&D Activities 8 (Rs Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>Total R&D Exp. Amount 2020(INR Crore)</td>
<td>Total R&D Exp. Amount 2019(INR Crore)</td>
<td>Total R&D Exp. Amount 2018(INR Crore)</td>
<td>Details of R&D activities</td>
<td>Company in the last 3 years</td>
<td>Business of your company</td>
<td>Last 3 financial years</td>
<td>Company in the past for innovations</td>
<td>CSR Activities 1 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>CSR Activities  2 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>CSR Activities 3 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>CSR Activities 4 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>CSR Activities 5 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>CSR Activities 6 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>CSR Activities 7 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>CSR Activities 8 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>FY2018-19</td>
<td>Total CSR Exp. Amount FY2020-21(INR Crore)</td>
<td>Total CSR Exp. Amount FY2019-20(INR Crore)</td>
<td>Total CSR Exp. Amount FY2018-19(INR Crore)</td>
<td>Details of CSR activities</td>
<td>Marketing undertaken by your company</td>
<td>Manufacturing undertaken by your company </td>
<td>Sales from E- Commerce Platform 1 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>Sales from E- Commerce Platform 2 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>Sales from E- Commerce Platform 3 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>Sales from E- Commerce Platform 4 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>Sales from E- Commerce Platform 5 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>Sales from E- Commerce Platform 6 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>Sales from E- Commerce Platform 7 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>Sales from E- Commerce Platform 8 (INR Crore)</td>
<td>FY2020-21</td>
<td>FY2019-20</td>
<td>Total Sales from E- Commerce Platform Amount (Rs Crore) FY2021-20</td>
<td>Total Sales from E- Commerce Platform Amount (Rs Crore)FY2020-19</td>

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
$sql="SELECT * FROM igja_industry_performance_declaration WHERE STATUS='Y' AND email_id !='sample@email.tst'";
$result1 = $conn->query($sql);   
//print_r($result1);die();
while(($row = $result1->fetch_assoc()) !== null)
{  
    $id=$row['reg_id'];
    $sql="SELECT * FROM  igja_industry_performance_and_theme_based_awards where id=$id";

//$sql="SELECT * FROM  igja_industry_performance_and_theme_based_awards";
$result = $conn->query($sql);   
while(($row = $result->fetch_assoc()) !== null)
{   

    $id=$row['id'];
    $company_name=$row['company_name'];
    $est_year=$row['est_year'];
    $imp_exp_code=$row['imp_exp_code'];
    $tel_no=$row['tel_no'];
    $email=$row['email_id'];
    $website = $row['website'];
    $address_line_1 = $row['address_line_1'];
    $address_line_2 = $row['address_line_2'];
    $city = $row['city'];
    $state = $row['state'];
    $zipcode = $row['zipcode'];
    $membership_no = $row['membership_no'];
    $membership_year = $row['membership_year'];
    $company_type = $row['company_type'];
    $nature_of_business = $row['nature_of_business'];
    $senior_management = unserialize($row['senior_management']);
    $created_at = $row['created_at'];
    $senior_ma = '';$sm_name='';$sm_designation='';
    foreach($senior_management as $x=>$se){
        foreach($se as $key=>$val){
            if($se[$key] != '' ){
                $senior_ma .= $val.', ';
            }
            // if($x == "sm_title") {
            //     $senior_ma .= $senior_management['sm_name'][$key].', ';
            // } 
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
    $company_det = '';
    $company_details = unserialize($row['company_details']);
    $total_income_FY20 = $company_details['total_income_FY20'];
    $total_income_FY19 = $company_details['total_income_FY19'];
    $total_income_FY18 = $company_details['total_income_FY18'];
    $total_sale_FY20=$company_details['total_sale_FY20'];
    $total_sale_FY19=$company_details['total_sale_FY19'];
    $total_sale_FY18=$company_details['total_sale_FY18'];
    $domestic_sales_FY20 = $company_details['domestic_sales_FY20'];
    $domestic_sales_FY19 = $company_details['domestic_sales_FY19'];
    $domestic_sales_FY18 = $company_details['domestic_sales_FY18'];
    $exports_FY20 = $company_details['exports_FY20'];
    $exports_FY19 = $company_details['exports_FY19'];
    $exports_FY18 = $company_details['exports_FY18'];
    $net_profit_FY20 = $company_details['net_profit_FY20'];
    $net_profit_FY19 = $company_details['net_profit_FY19'];
    $net_profit_FY18 = $company_details['net_profit_FY18'];
    $permenant_employees_FY20 = $company_details['permenant_employees_FY20'];
    $permenant_employees_FY19 = $company_details['permenant_employees_FY19'];
    $permenant_employees_FY18 = $company_details['permenant_employees_FY18'];
    $contractual_employees_FY20 = $company_details['contractual_employees_FY20'];
    $contractual_employees_FY19 = $company_details['contractual_employees_FY19'];
    $contractual_employees_FY18 = $company_details['contractual_employees_FY18'];
    $other_employees_FY20 = $company_details['other_employees_FY20'];
    $other_employees_FY19 = $company_details['other_employees_FY19'];
    $other_employees_FY18 = $company_details['other_employees_FY18'];
    $incm_tax_paid_FY20 = $company_details['incm_tax_paid_FY20'];
    $incm_tax_paid_FY19 = $company_details['incm_tax_paid_FY19'];
    $incm_tax_paid_FY18 = $company_details['incm_tax_paid_FY18'];
    $company_det_FY20 = $company_details['total_income_FY20'].','.$company_details['total_sale_FY20'].','.$company_details['domestic_sales_FY20'].','.$company_details['exports_FY20'].','.$company_details['net_profit_FY20'].','.$company_details['permenant_employees_FY20'].','.$company_details['contractual_employees_FY20'].','.$company_details['other_employees_FY20'].','.$company_details['incm_tax_paid_FY20'];
    $company_det_FY19 = $company_details['total_income_FY19'].','.$company_details['total_sale_FY19'].','.$company_details['domestic_sales_FY19'].','.$company_details['exports_FY19'].','.$company_details['net_profit_FY19'].','.$company_details['permenant_employees_FY19'].','.$company_details['contractual_employees_FY19'].','.$company_details['other_employees_FY19'].','.$company_details['incm_tax_paid_FY19'];
    $company_det_FY18 = $company_details['total_income_FY18'].','.$company_details['total_sale_FY18'].','.$company_details['domestic_sales_FY18'].','.$company_details['exports_FY18'].','.$company_details['net_profit_FY18'].','.$company_details['permenant_employees_FY18'].','.$company_details['contractual_employees_FY18'].','.$company_details['other_employees_FY18'].','.$company_details['incm_tax_paid_FY18'];
    // foreach($company_details as $pe){
        
    //     $company_det .= $pe.',';
    // }
    
    $sql_query = "SELECT * FROM  igja_industry_performance_award_category_info where reg_id=$id ORDER BY id desc";
    $category = $conn->query($sql_query);
    // if($category){
    //     $category =  $category->fetch_assoc();
    // }else{
    //     $category = array();
    // }
    $category =  $category->fetch_assoc();
    $product_segment = '';$isApplicable='';$total_sales='';$domestic_sales='';$export_sales='';$net_profit='';
    $value_addition='';$calc_value_addition='';
    $product_segment_array = array();
    $product_segment_array = unserialize($category['product_segment_FY20']);
    //print_r($product_segment_array);die();
    // foreach($product_segment_array as $key=>$exp){
    //     if($key == "product_segment"){
    //         if(count($product_segment_array['product_segment']) > 0){
    //             foreach($exp as $ex){
    //                 $product_segment .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key  == "isApplicable"){
    //         if(count($product_segment_array['isApplicable']) > 0){
    //             foreach($exp as $ex){
    //                 $isApplicable .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "total_sales"){
    //         if(count($product_segment_array['total_sales']) > 0){
    //             foreach($exp as $ex){
    //                 $total_sales .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "domestic_sales"){
    //         if(count($product_segment_array['domestic_sales']) > 0){
    //             foreach($exp as $ex){
    //                 $domestic_sales .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "export_sales"){
    //         if(count($product_segment_array['export_sales']) > 0){
    //             foreach($exp as $ex){
    //                 $export_sales .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key  == "net_profit"){
    //         if(count($product_segment_array['net_profit']) > 0){
    //             foreach($exp as $ex){
    //                 $net_profit .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "net_profit"){
    //         if(count($product_segment_array['value_addition']) > 0){
    //             foreach($exp as $ex){
    //                 $value_addition .= $ex.',';
    //             }    
    //         }
    //     }
    //     if($key == "calc_value_addition"){
    //         if(count($product_segment_array['calc_value_addition']) > 0){
    //             foreach($exp as $ex){
    //                 $calc_value_addition .= $ex.',';
    //             }
    //         }
    //     }
    // }
    $isApplicable_FY21 = $product_segment_array['isApplicable'][0];
    $total_sales_FY21 = $product_segment_array['total_sales'][0];
    $domestic_sales_FY21 = $product_segment_array['domestic_sales'][0];
    $export_sales_FY21 = $product_segment_array['export_sales'][0];
    $net_profit_FY21 = $product_segment_array['net_profit'][0];
    $value_addition_FY21 = $product_segment_array['value_addition'][0];
    $calc_value_addition_FY21 = $product_segment_array['calc_value_addition'][0];

    $isApplicable_FY21_1 = $product_segment_array['isApplicable'][1];
    $total_sales_FY21_1 = $product_segment_array['total_sales'][1];
    $domestic_sales_FY21_1 = $product_segment_array['domestic_sales'][1];
    $export_sales_FY21_1 = $product_segment_array['export_sales'][1];
    $net_profit_FY21_1 = $product_segment_array['net_profit'][1];
    $value_addition_FY21_1 = $product_segment_array['value_addition'][1];
    $calc_value_addition_FY21_1 = $product_segment_array['calc_value_addition'][1];
    $isApplicable_FY21_2 = $product_segment_array['isApplicable'][2];
    $total_sales_FY21_2 = $product_segment_array['total_sales'][2];
    $domestic_sales_FY21_2 = $product_segment_array['domestic_sales'][2];
    $export_sales_FY21_2 = $product_segment_array['export_sales'][2];
    $net_profit_FY21_2 = $product_segment_array['net_profit'][2];
    $value_addition_FY21_2 = $product_segment_array['value_addition'][2];
    $calc_value_addition_FY21_2 = $product_segment_array['calc_value_addition'][2];
    $isApplicable_FY21_3 = $product_segment_array['isApplicable'][3];
    $total_sales_FY21_3 = $product_segment_array['total_sales'][3];
    $domestic_sales_FY21_3 = $product_segment_array['domestic_sales'][3];
    $export_sales_FY21_3 = $product_segment_array['export_sales'][3];
    $net_profit_FY21_3 = $product_segment_array['net_profit'][3];
    $value_addition_FY21_3 = $product_segment_array['value_addition'][3];
    $calc_value_addition_FY21_3 = $product_segment_array['calc_value_addition'][3];
    $isApplicable_FY21_4 = $product_segment_array['isApplicable'][4];
    $total_sales_FY21_4 = $product_segment_array['total_sales'][4];
    $domestic_sales_FY21_4 = $product_segment_array['domestic_sales'][4];
    $export_sales_FY21_4 = $product_segment_array['export_sales'][4];
    $net_profit_FY21_4 = $product_segment_array['net_profit'][4];
    $value_addition_FY21_4 = $product_segment_array['value_addition'][4];
    $calc_value_addition_FY21_4 = $product_segment_array['calc_value_addition'][4];
    $isApplicable_FY21_5 = $product_segment_array['isApplicable'][5];
    $total_sales_FY21_5 = $product_segment_array['total_sales'][5];
    $domestic_sales_FY21_5 = $product_segment_array['domestic_sales'][5];
    $export_sales_FY21_5 = $product_segment_array['export_sales'][5];
    $net_profit_FY21_5 = $product_segment_array['net_profit'][5];
    $value_addition_FY21_5 = $product_segment_array['value_addition'][5];
    $calc_value_addition_FY21_5 = $product_segment_array['calc_value_addition'][5];
    $isApplicable_FY21_6 = $product_segment_array['isApplicable'][6];
    $total_sales_FY21_6 = $product_segment_array['total_sales'][6];
    $domestic_sales_FY21_6 = $product_segment_array['domestic_sales'][6];
    $export_sales_FY21_6 = $product_segment_array['export_sales'][6];
    $net_profit_FY21_6 = $product_segment_array['net_profit'][6];
    $value_addition_FY21_6 = $product_segment_array['value_addition'][6];
    $calc_value_addition_FY21_6 = $product_segment_array['calc_value_addition'][6];
    $isApplicable_FY21_7 = $product_segment_array['isApplicable'][7];
    $total_sales_FY21_7 = $product_segment_array['total_sales'][7];
    $domestic_sales_FY21_7 = $product_segment_array['domestic_sales'][7];
    $export_sales_FY21_7 = $product_segment_array['export_sales'][7];
    $net_profit_FY21_7 = $product_segment_array['net_profit'][7];
    $value_addition_FY21_7 = $product_segment_array['value_addition'][7];
    $calc_value_addition_FY21_7 = $product_segment_array['calc_value_addition'][7];
    
    $product_segment_19 = '';$isApplicable_19='';$total_sales_19='';$domestic_sales_19='';$export_sales_19='';$net_profit_19='';
    $value_addition_19='';$calc_value_addition_19='';
    $product_segment_array_19 = unserialize($category['product_segment_FY19']);

    $isApplicable_FY20 = $product_segment_array_19['isApplicable'][0];
    $total_sales_FY20 = $product_segment_array_19['total_sales'][0];
    $domestic_sales_FY20 = $product_segment_array_19['domestic_sales'][0];
    $export_sales_FY20 = $product_segment_array_19['export_sales'][0];
    $net_profit_FY20 = $product_segment_array_19['net_profit'][0];
    $value_addition_FY20 = $product_segment_array_19['value_addition'][0];
    $calc_value_addition_FY20 = $product_segment_array_19['calc_value_addition'][0];
    $isApplicable_FY20_1 = $product_segment_array_19['isApplicable'][1];
    $total_sales_FY20_1 = $product_segment_array_19['total_sales'][1];
    $domestic_sales_FY20_1 = $product_segment_array_19['domestic_sales'][1];
    $export_sales_FY20_1 = $product_segment_array_19['export_sales'][1];
    $net_profit_FY20_1= $product_segment_array_19['net_profit'][1];
    $value_addition_FY20_1 = $product_segment_array_19['value_addition'][1];
    $calc_value_addition_FY20_1 = $product_segment_array_19['calc_value_addition'][1];
    $isApplicable_FY20_2 = $product_segment_array_19['isApplicable'][2];
    $total_sales_FY20_2 = $product_segment_array_19['total_sales'][2];
    $domestic_sales_FY20_2 = $product_segment_array_19['domestic_sales'][2];
    $export_sales_FY20_2 = $product_segment_array_19['export_sales'][2];
    $net_profit_FY20_2 = $product_segment_array_19['net_profit'][2];
    $value_addition_FY20_2 = $product_segment_array_19['value_addition'][2];
    $calc_value_addition_FY20_2 = $product_segment_array_19['calc_value_addition'][2];
    $isApplicable_FY20_3 = $product_segment_array_19['isApplicable'][3];
    $total_sales_FY20_3 = $product_segment_array_19['total_sales'][3];
    $domestic_sales_FY20_3 = $product_segment_array_19['domestic_sales'][3];
    $export_sales_FY20_3 = $product_segment_array_19['export_sales'][3];
    $net_profit_FY20_3 = $product_segment_array_19['net_profit'][3];
    $value_addition_FY20_3 = $product_segment_array_19['value_addition'][3];
    $calc_value_addition_FY20_3 = $product_segment_array_19['calc_value_addition'][3];
    $isApplicable_FY20_4 = $product_segment_array_19['isApplicable'][4];
    $total_sales_FY20_4 = $product_segment_array_19['total_sales'][4];
    $domestic_sales_FY20_4 = $product_segment_array_19['domestic_sales'][4];
    $export_sales_FY20_4 = $product_segment_array_19['export_sales'][4];
    $net_profit_FY20_4 = $product_segment_array_19['net_profit'][4];
    $value_addition_FY20_4 = $product_segment_array_19['value_addition'][4];
    $calc_value_addition_FY20_4 = $product_segment_array_19['calc_value_addition'][4];
    $isApplicable_FY20_5 = $product_segment_array_19['isApplicable'][5];
    $total_sales_FY20_5 = $product_segment_array_19['total_sales'][5];
    $domestic_sales_FY20_5 = $product_segment_array_19['domestic_sales'][5];
    $export_sales_FY20_5 = $product_segment_array_19['export_sales'][5];
    $net_profit_FY20_5 = $product_segment_array_19['net_profit'][5];
    $value_addition_FY20_5 = $product_segment_array_19['value_addition'][5];
    $calc_value_addition_FY20_5 = $product_segment_array_19['calc_value_addition'][5];
    $isApplicable_FY20_6 = $product_segment_array_19['isApplicable'][6];
    $total_sales_FY20_6 = $product_segment_array_19['total_sales'][6];
    $domestic_sales_FY20_6 = $product_segment_array_19['domestic_sales'][6];
    $export_sales_FY20_6 = $product_segment_array_19['export_sales'][6];
    $net_profit_FY20_6 = $product_segment_array_19['net_profit'][6];
    $value_addition_FY20_6 = $product_segment_array_19['value_addition'][6];
    $calc_value_addition_FY20_6 = $product_segment_array_19['calc_value_addition'][6];
    $isApplicable_FY20_7 = $product_segment_array_19['isApplicable'][7];
    $total_sales_FY20_7 = $product_segment_array_19['total_sales'][7];
    $domestic_sales_FY20_7 = $product_segment_array_19['domestic_sales'][7];
    $export_sales_FY20_7 = $product_segment_array_19['export_sales'][7];
    $net_profit_FY20_7 = $product_segment_array_19['net_profit'][7];
    $value_addition_FY20_7 = $product_segment_array_19['value_addition'][7];
    $calc_value_addition_FY20_7 = $product_segment_array_19['calc_value_addition'][7];

    // foreach($product_segment_array_19 as $key=>$exp){
    //     if($key == "product_segment"){
    //         if(count($product_segment_array_19['product_segment']) > 0){
    //             foreach($exp as $ex){
    //                 $product_segment_19 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "isApplicable"){
    //         if(count($product_segment_array_19['isApplicable']) > 0){
    //             foreach($exp as $ex){
    //                 $isApplicable_19 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "total_sales"){
    //         if(count($product_segment_array_19['total_sales']) > 0){
    //             foreach($exp as $ex){
    //                 $total_sales_19 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "domestic_sales"){
    //         if(count($product_segment_array_19['domestic_sales']) > 0){
    //             foreach($exp as $ex){
    //                 $domestic_sales_19 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "export_sales"){
    //         if(count($product_segment_array_19['export_sales']) > 0){
    //             foreach($exp as $ex){
    //                 $export_sales_19 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "net_profit"){
    //         if(count($product_segment_array_19['net_profit']) > 0){
    //             foreach($exp as $ex){
    //                 $net_profit_19 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "net_profit"){
    //         if(count($product_segment_array_19['value_addition']) > 0){
    //             foreach($exp as $ex){
    //                 $value_addition_19 .= $ex.',';
    //             }    
    //         }
    //     }
    //     if($key == "calc_value_addition"){
    //         if(count($product_segment_array_19['calc_value_addition']) > 0){
    //             foreach($exp as $ex){
    //                 $calc_value_addition_19 .= $ex.',';
    //             }
    //         }
    //     }
        
    // }
    $product_segment_18 = '';$isApplicable_18='';$total_sales_18='';$domestic_sales_18='';$export_sales_18='';$net_profit_18='';
    $value_addition_18='';$calc_value_addition_18='';
    $product_segment_array_18 = unserialize($category['product_segment_FY18']);

    $isApplicable_FY19 = $product_segment_array_18['isApplicable'][0];
    $total_sales_FY19 = $product_segment_array_18['total_sales'][0];
    $domestic_sales_FY19 = $product_segment_array_18['domestic_sales'][0];
    $export_sales_FY19 = $product_segment_array_18['export_sales'][0];
    $net_profit_FY19 = $product_segment_array_18['net_profit'][0];
    $value_addition_FY19 = $product_segment_array_18['value_addition'][0];
    $calc_value_addition_FY19 = $product_segment_array_18['calc_value_addition'][0];
    $isApplicable_FY19_1 = $product_segment_array_18['isApplicable'][1];
    $total_sales_FY19_1 = $product_segment_array_18['total_sales'][1];
    $domestic_sales_FY19_1 = $product_segment_array_18['domestic_sales'][1];
    $export_sales_FY19_1 = $product_segment_array_18['export_sales'][1];
    $net_profit_FY19_1 = $product_segment_array_18['net_profit'][1];
    $value_addition_FY19_1 = $product_segment_array_18['value_addition'][1];
    $calc_value_addition_FY19_1 = $product_segment_array_18['calc_value_addition'][1];
    $isApplicable_FY19_2 = $product_segment_array_18['isApplicable'][2];
    $total_sales_FY19_2 = $product_segment_array_18['total_sales'][2];
    $domestic_sales_FY19_2 = $product_segment_array_18['domestic_sales'][2];
    $export_sales_FY19_2 = $product_segment_array_18['export_sales'][2];
    $net_profit_FY19_2 = $product_segment_array_18['net_profit'][2];
    $value_addition_FY19_2 = $product_segment_array_18['value_addition'][2];
    $calc_value_addition_FY19_2 = $product_segment_array_18['calc_value_addition'][2];
    $isApplicable_FY19_3 = $product_segment_array_18['isApplicable'][3];
    $total_sales_FY19_3 = $product_segment_array_18['total_sales'][3];
    $domestic_sales_FY19_3 = $product_segment_array_18['domestic_sales'][3];
    $export_sales_FY19_3 = $product_segment_array_18['export_sales'][3];
    $net_profit_FY19_3 = $product_segment_array_18['net_profit'][3];
    $value_addition_FY19_3 = $product_segment_array_18['value_addition'][3];
    $calc_value_addition_FY19_3 = $product_segment_array_18['calc_value_addition'][3];
    $isApplicable_FY19_4 = $product_segment_array_18['isApplicable'][4];
    $total_sales_FY19_4 = $product_segment_array_18['total_sales'][4];
    $domestic_sales_FY19_4 = $product_segment_array_18['domestic_sales'][4];
    $export_sales_FY19_4 = $product_segment_array_18['export_sales'][4];
    $net_profit_FY19_4 = $product_segment_array_18['net_profit'][4];
    $value_addition_FY19_4 = $product_segment_array_18['value_addition'][4];
    $calc_value_addition_FY1_9_4 = $product_segment_array_18['calc_value_addition'][4];
    $isApplicable_FY19_5 = $product_segment_array_18['isApplicable'][5];
    $total_sales_FY19_5 = $product_segment_array_18['total_sales'][5];
    $domestic_sales_FY19_5 = $product_segment_array_18['domestic_sales'][5];
    $export_sales_FY19_5 = $product_segment_array_18['export_sales'][5];
    $net_profit_FY19_5 = $product_segment_array_18['net_profit'][5];
    $value_addition_FY19_5 = $product_segment_array_18['value_addition'][5];
    $calc_value_addition_FY1_9_5 = $product_segment_array_18['calc_value_addition'][5];
    $isApplicable_FY19_6 = $product_segment_array_18['isApplicable'][6];
    $total_sales_FY19_6 = $product_segment_array_18['total_sales'][6];
    $domestic_sales_FY19_6 = $product_segment_array_18['domestic_sales'][6];
    $export_sales_FY19_6 = $product_segment_array_18['export_sales'][6];
    $net_profit_FY19_6 = $product_segment_array_18['net_profit'][6];
    $value_addition_FY19_6 = $product_segment_array_18['value_addition'][6];
    $calc_value_addition_FY1_9_6 = $product_segment_array_18['calc_value_addition'][6];
    $isApplicable_FY19_7 = $product_segment_array_18['isApplicable'][7];
    $total_sales_FY19_7 = $product_segment_array_18['total_sales'][7];
    $domestic_sales_FY19_7 = $product_segment_array_18['domestic_sales'][7];
    $export_sales_FY19_7 = $product_segment_array_18['export_sales'][7];
    $net_profit_FY19_7 = $product_segment_array_18['net_profit'][7];
    $value_addition_FY19_7 = $product_segment_array_18['value_addition'][7];
    $calc_value_addition_FY19_7 = $product_segment_array_18['calc_value_addition'][7];
    // foreach($product_segment_array_18 as $key=>$exp){
    //     if($key == "product_segment"){
    //         if(count($product_segment_array_18['product_segment']) > 0){
    //             foreach($exp as $ex){
    //                 $product_segment_18 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "isApplicable"){
    //         if(count($product_segment_array_18['isApplicable']) > 0){
    //             foreach($exp as $ex){
    //                 $isApplicable_18 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "total_sales"){
    //         if(count($product_segment_array_18['total_sales']) > 0){
    //             foreach($exp as $ex){
    //                 $total_sales_18 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "domestic_sales"){
    //         if(count($product_segment_array_18['domestic_sales']) > 0){
    //             foreach($exp as $ex){
    //                 $domestic_sales_18 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "export_sales"){
    //         if(count($product_segment_array_18['export_sales']) > 0){
    //             foreach($exp as $ex){
    //                 $export_sales_18 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "net_profit"){
    //         if(count($product_segment_array_18['net_profit']) > 0){
    //             foreach($exp as $ex){
    //                 $net_profit_18 .= $ex.',';
    //             }
    //         }
    //     }
    //     if($key == "net_profit"){
    //         if(count($product_segment_array_18['value_addition']) > 0){
    //             foreach($exp as $ex){
    //                 $value_addition_18 .= $ex.',';
    //             }    
    //         }
    //     }
    //     if($key == "calc_value_addition"){
    //         if(count($product_segment_array_18['calc_value_addition']) > 0){
    //             foreach($exp as $ex){
    //                 $calc_value_addition_18 .= $ex.',';
    //             }
    //         }
    //     }
        
    // }

    $sql_query = "SELECT * FROM  igja_industry_performance_best_growing_performance where reg_id=$id ORDER BY id desc";
    $growing = $conn->query($sql_query);
    $growing =  $growing->fetch_assoc();
    $export_details_array = array();
    $export_questions = '';$export_details_FY20='';$export_details_FY19='';$export_details_FY18='';
    $export_details_array = unserialize($growing['export_details']);

    $export_questions = $export_details_array['export_questions'][0];
    $export_details_FY21 = $export_details_array['export_details_FY20'][0];
    $export_details_FY19 = $export_details_array['export_details_FY19'][0];
    $export_details_FY18 = $export_details_array['export_details_FY18'][0];

    $export_questions_1 = $export_details_array['export_questions'][1];
    $export_details_FY21_1 = $export_details_array['export_details_FY20'][1];
    $export_details_FY20_1 = $export_details_array['export_details_FY19'][1];
    $export_details_FY18_1 = $export_details_array['export_details_FY18'][1];

    $export_questions_2 = $export_details_array['export_questions'][2];
    $export_details_FY21_2 = $export_details_array['export_details_FY20'][2];
    $export_details_FY20_2 = $export_details_array['export_details_FY19'][2];
    $export_details_FY18_2 = $export_details_array['export_details_FY18'][2];
    
    $export_questions_3 = $export_details_array['export_questions'][3];
    $export_details_FY21_3 = $export_details_array['export_details_FY20'][3];
    $export_details_FY20_3 = $export_details_array['export_details_FY19'][3];
    $export_details_FY18_3 = $export_details_array['export_details_FY18'][3];
    // foreach($export_details_array as $key=>$exp_ques){
    //     if($key == "export_questions"){
    //         if(count($export_details_array['export_questions']) > 0){
    //             foreach($exp_ques as $ex_ques){
    //                 $export_questions .= $ex_ques.',';
    //             }
    //         }
    //     }
    //     if($key == "export_details_FY20"){
    //         if(count($export_details_array['export_details_FY20']) > 0){
    //             foreach($exp_ques as $ex_ques){
    //                 $export_details_FY20 .= $ex_ques.',';
    //             }
    //         }
    //     }
    //     if($key == "export_details_FY19"){
    //         if(count($export_details_array['export_details_FY19']) > 0){
    //             foreach($exp_ques as $ex_ques){
    //                 $export_details_FY19 .= $ex_ques.',';
    //             }
    //         }
    //     }
    //     if($key == "export_details_FY18"){
    //         if(count($export_details_array['export_details_FY18']) > 0){
    //             foreach($exp_ques as $ex_ques){
    //                 $export_details_FY18 .= $ex_ques.',';
    //             }
    //         }
    //     }
    // }    

    $country_FY20='';$export_sales_rs_FY20='';$export_sales_dollar_FY20='';
    $export_country_details_FY20_array = unserialize($growing['export_country_details_FY20']);
    foreach($export_country_details_FY20_array as $key=>$exp_country){
        if($key == "country_FY20"){
            if(count($export_country_details_FY20_array['country_FY20']) > 0){
                foreach($exp_country as $ex_ques){
                    $country_FY20 .= $ex_ques.',';
                }
            }
        }
        if($key == "export_sales_rs_FY20"){
            if(count($export_country_details_FY20_array['export_sales_rs_FY20']) > 0){
                foreach($exp_country as $ex_ques){
                    $export_sales_rs_FY20 .= $ex_ques.',';
                }
            }
        }
        if($key == "export_sales_dollar_FY20"){
            if(count($export_country_details_FY20_array['export_sales_dollar_FY20']) > 0){
                foreach($exp_country as $ex_ques){
                    $export_sales_dollar_FY20 .= $ex_ques.',';
                }
            }
        }
    }  

    $country_FY19='';$export_sales_rs_FY19='';$export_sales_dollar_FY19='';
    $export_country_details_FY19_array = unserialize($growing['export_country_details_FY19']);
    foreach($export_country_details_FY19_array as $key=>$exp_country){
        if($key == "country_FY19"){
            if(count($export_country_details_FY19_array['country_FY19']) > 0){
                foreach($exp_country as $ex_ques){
                    $country_FY19 .= $ex_ques.',';
                }
            }
        }
        if($key == "export_sales_rs_FY19"){
            if(count($export_country_details_FY19_array['export_sales_rs_FY19']) > 0){
                foreach($exp_country as $ex_ques){
                    $export_sales_rs_FY19 .= $ex_ques.',';
                }
            }
        }
        if($key == "export_sales_dollar_FY19"){
            if(count($export_country_details_FY19_array['export_sales_dollar_FY19']) > 0){
                foreach($exp_country as $ex_ques){
                    $export_sales_dollar_FY19 .= $ex_ques.',';
                }
            }
        }
    } 

    $country_FY18='';$export_sales_rs_FY18='';$export_sales_dollar_FY18='';
    $export_country_details_FY18_array = unserialize($growing['export_country_details_FY18']);
    foreach($export_country_details_FY18_array as $key=>$exp_country){
        if($key == "country_FY18"){
            if(count($export_country_details_FY18_array['country_FY18']) > 0){
                foreach($exp_country as $ex_ques){
                    $country_FY18 .= $ex_ques.',';
                }
            }
        }
        if($key == "export_sales_rs_FY18"){
            if(count($export_country_details_FY18_array['export_sales_rs_FY18']) > 0){
                foreach($exp_country as $ex_ques){
                    $export_sales_rs_FY18 .= $ex_ques.',';
                }
            }
        }
        if($key == "export_sales_dollar_FY18"){
            if(count($export_country_details_FY18_array['export_sales_dollar_FY18']) > 0){
                foreach($exp_country as $ex_ques){
                    $export_sales_dollar_FY18 .= $ex_ques.',';
                }
            }
        }
    } 
    $countries_not_regions_exports = unserialize($growing['attatchments']);
    $financial_year = unserialize($growing['financial_year']);
    $business_details_and_explanation_3 = $growing['business_details_and_explanation'];
    $strategic_export_initiative_3 = $growing['strategic_export_initiative'];
    $case_of_excellence_3 = $growing['key_insights'];


    $sql_query = "SELECT * FROM  igja_industry_perfomance_qualitative_info where reg_id=$id ORDER BY id desc";
    $qualitative_info = $conn->query($sql_query);
    if($qualitative_info){
        $qualitative_info =  $qualitative_info->fetch_assoc();
    } else{
        $qualitative_info =  array();
    }
    //$qualitative_info =  $qualitative_info->fetch_assoc();
    $attatchment_details = $qualitative_info['attatchment_details'];
    $business_details_and_explanation = $qualitative_info['business_details_and_explanation'];
    $strategic_export_initiative = $qualitative_info['strategic_export_initiative'];
    $case_of_excellence = $qualitative_info['case_of_excellence'];
    $nominated_segment = $qualitative_info['nominated_segment'];
    $number_comp_outlets = $qualitative_info['number_comp_outlets'];
    $number_of_internation_clients = $qualitative_info['number_of_internation_clients'];
    $sm_title = $qualitative_info['sm_title'];
    $name_w = $qualitative_info['name_w'];
    $designation = $qualitative_info['designation'];
    $experience = $qualitative_info['experience'];
    $is_mandatory = $qualitative_info['is_mandatory'];
    $mandatory_details = $qualitative_info['mandatory_details'];

    $sql_query = "SELECT * FROM  igja_theme_based_innovative_company where reg_id=$id ORDER BY id desc";
    $innovative_company = $conn->query($sql_query);
    $innovative_company =  $innovative_company->fetch_assoc();
    $r_n_d_activities='';$r_n_d_activities_FY20='';$r_n_d_activities_FY19='';$r_n_d_activities_FY18='';
    $amount_of_r_n_d_expenditure_array = unserialize($innovative_company['amount_of_r_n_d_expenditure']);
    $r_n_d_activities = $amount_of_r_n_d_expenditure_array['r_n_d_activities'][0];
    $r_n_d_activitiesFY2020_21 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY20'][0];
    $r_n_d_activitiesFY2019_20 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY19'][0];
    $r_n_d_activitiesFY2019_18 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY18'][0];

    $r_n_d_activities_1 = $amount_of_r_n_d_expenditure_array['r_n_d_activities'][1];
    $r_n_d_activitiesFY2020_21_1 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY20'][1];
    $r_n_d_activitiesFY2019_20_1 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY19'][1];
    $r_n_d_activitiesFY2019_18_1 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY18'][1];
    $r_n_d_activities_2 = $amount_of_r_n_d_expenditure_array['r_n_d_activities'][2];
    $r_n_d_activitiesFY2020_21_2 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY20'][2];
    $r_n_d_activitiesFY2019_20_2 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY19'][2];
    $r_n_d_activitiesFY2019_18_2 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY18'][2];
    $r_n_d_activities_3 = $amount_of_r_n_d_expenditure_array['r_n_d_activities'][3];
    $r_n_d_activitiesFY2020_21_3 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY20'][3];
    $r_n_d_activitiesFY2019_20_3 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY19'][3];
    $r_n_d_activitiesFY2019_18_3 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY18'][3];
    $r_n_d_activities_4 = $amount_of_r_n_d_expenditure_array['r_n_d_activities'][4];
    $r_n_d_activitiesFY2020_21_4 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY20'][4];
    $r_n_d_activitiesFY2019_20_4 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY19'][4];
    $r_n_d_activitiesFY2019_18_4 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY18'][4];
    $r_n_d_activities_5 = $amount_of_r_n_d_expenditure_array['r_n_d_activities'][5];
    $r_n_d_activitiesFY2020_21_5 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY20'][5];
    $r_n_d_activitiesFY2019_20_5 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY19'][5];
    $r_n_d_activitiesFY2019_18_5 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY18'][5];
    $r_n_d_activities_6 = $amount_of_r_n_d_expenditure_array['r_n_d_activities'][6];
    $r_n_d_activitiesFY2020_21_6 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY20'][6];
    $r_n_d_activitiesFY2019_20_6 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY19'][6];
    $r_n_d_activitiesFY2019_18_6 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY18'][6];
    $r_n_d_activities_7 = $amount_of_r_n_d_expenditure_array['r_n_d_activities'][7];
    $r_n_d_activitiesFY2020_21_7 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY20'][7];
    $r_n_d_activitiesFY2019_20_7 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY19'][7];
    $r_n_d_activitiesFY2019_18_7 = $amount_of_r_n_d_expenditure_array['r_n_d_activities_FY18'][7];
    // foreach($amount_of_r_n_d_expenditure_array as $key=>$exp_company){
    //     if($key == "r_n_d_activities"){
    //         if(count($amount_of_r_n_d_expenditure_array['r_n_d_activities']) > 0){
    //             foreach($exp_company as $ex_comp){
    //                 $r_n_d_activities .= $ex_comp.',';
    //             }
    //         }
    //     }
    //     if($key == "r_n_d_activities_FY20"){
    //         if(count($amount_of_r_n_d_expenditure_array['r_n_d_activities_FY20']) > 0){
    //             foreach($exp_company as $ex_comp){
    //                 $r_n_d_activities_FY20 .= $ex_comp.',';
    //             }
    //         }
    //     }
    //     if($key == "r_n_d_activities_FY19"){
    //         if(count($amount_of_r_n_d_expenditure_array['r_n_d_activities_FY19']) > 0){
    //             foreach($exp_company as $ex_comp){
    //                 $r_n_d_activities_FY19 .= $ex_comp.',';
    //             }
    //         }
    //     }
    //     if($key == "r_n_d_activities_FY18"){
    //         if(count($amount_of_r_n_d_expenditure_array['r_n_d_activities_FY18']) > 0){
    //             foreach($exp_company as $ex_comp){
    //                 $r_n_d_activities_FY18 .= $ex_comp.',';
    //             }
    //         }
    //     }
    // } 
    $total_r_n_d_activities_FY20 = $amount_of_r_n_d_expenditure_array['total_r_n_d_activities_FY20'];
    $total_r_n_d_activities_FY19 = $amount_of_r_n_d_expenditure_array['total_r_n_d_activities_FY19'];
    $total_r_n_d_activities_FY18 = $amount_of_r_n_d_expenditure_array['total_r_n_d_activities_FY18'];
    $details_r_n_d_activities = $innovative_company['details_r_n_d_activities'] == null ? '' : $innovative_company['details_r_n_d_activities'];
    $innovation_activities_last_3_yr = $innovative_company['innovation_activities_last_3_yr'] == null ? '' : $innovative_company['innovation_activities_last_3_yr'];
    $how_impact_innovation = $innovative_company['how_impact_innovation'] == null ? '' : $innovative_company['how_impact_innovation'];
    $registered_patents_for_innovation = $innovative_company['registered_patents_for_innovation'] == null ? '' : $innovative_company['registered_patents_for_innovation'];
    $award_and_accolades_won_details = $innovative_company['award_and_accolades_won_details'] == null ? '' : $innovative_company['award_and_accolades_won_details'];
    
    $e_commerce_activities='';$e_commerce_activities_FY20='';$e_commerce_activities_FY19='';$e_commerce_activities_FY18='';
    $amount_of_csr_expenditure_array = unserialize($innovative_company['amount_of_csr_expenditure']);
    $e_commerce_activities = $amount_of_csr_expenditure_array['csr_activities'][0];
    $e_commerce_activities_FY20 = $amount_of_csr_expenditure_array['csr_activities_FY20'][0];
    $e_commerce_activities_FY19 = $amount_of_csr_expenditure_array['e_commerce_activities_FY19'][0];
    $e_commerce_activities_FY18 = $amount_of_csr_expenditure_array['e_commerce_activities_FY18'][0];

    $e_commerce_activities_1 = $amount_of_csr_expenditure_array['csr_activities'][1];
    $e_commerce_activities_FY20_1 = $amount_of_csr_expenditure_array['csr_activities_FY20'][1];
    $e_commerce_activities_FY19_1 = $amount_of_csr_expenditure_array['csr_activities_FY19'][1];
    $e_commerce_activities_FY18_1 = $amount_of_csr_expenditure_array['csr_activities_FY18'][1];
    $e_commerce_activities_2 = $amount_of_csr_expenditure_array['csr_activities'][2];
    $e_commerce_activities_FY20_2 = $amount_of_csr_expenditure_array['csr_activities_FY20'][2];
    $e_commerce_activities_FY19_2 = $amount_of_csr_expenditure_array['csr_activities_FY19'][2];
    $e_commerce_activities_FY18_2 = $amount_of_csr_expenditure_array['csr_activities_FY18'][2];
    $e_commerce_activities_3 = $amount_of_csr_expenditure_array['csr_activities'][3];
    $e_commerce_activities_FY20_3 = $amount_of_csr_expenditure_array['csr_activities_FY20'][3];
    $e_commerce_activities_FY19_3 = $amount_of_csr_expenditure_array['csr_activities_FY19'][3];
    $e_commerce_activities_FY18_3 = $amount_of_csr_expenditure_array['csr_activities_FY18'][3];
    $e_commerce_activities_4 = $amount_of_csr_expenditure_array['csr_activities'][4];
    $e_commerce_activities_FY20_4 = $amount_of_csr_expenditure_array['csr_activities_FY20'][4];
    $e_commerce_activities_FY19_4 = $amount_of_csr_expenditure_array['csr_activities_FY19'][4];
    $e_commerce_activities_FY18_4 = $amount_of_csr_expenditure_array['csr_activities_FY18'][4];
    $e_commerce_activities_5 = $amount_of_csr_expenditure_array['csr_activities'][5];
    $e_commerce_activities_FY20_5 = $amount_of_csr_expenditure_array['csr_activities_FY20'][5];
    $e_commerce_activities_FY19_5 = $amount_of_csr_expenditure_array['csr_activities_FY19'][5];
    $e_commerce_activities_FY18_5 = $amount_of_csr_expenditure_array['csr_activities_FY18'][5];
    $e_commerce_activities_6 = $amount_of_csr_expenditure_array['csr_activities'][6];
    $e_commerce_activities_FY20_6 = $amount_of_csr_expenditure_array['csr_activities_FY20'][6];
    $e_commerce_activities_FY19_6 = $amount_of_csr_expenditure_array['csr_activities_FY19'][6];
    $e_commerce_activities_FY18_6 = $amount_of_csr_expenditure_array['csr_activities_FY18'][6];
    $e_commerce_activities_7 = $amount_of_csr_expenditure_array['csr_activities'][7];
    $e_commerce_activities_FY20_7 = $amount_of_csr_expenditure_array['csr_activities_FY20'][7];
    $e_commerce_activities_FY19_7 = $amount_of_csr_expenditure_array['csr_activities_FY19'][7];
    $e_commerce_activities_FY18_7 = $amount_of_csr_expenditure_array['csr_activities_FY18'][7];
    // foreach($amount_of_csr_expenditure_array as $key=>$exp_comm){
    //     if($key == "e_commerce_activities"){
    //         if(count($amount_of_csr_expenditure_array['e_commerce_activities']) > 0){
    //             foreach($exp_comm as $ex_comp){
    //                 $e_commerce_activities .= $ex_comp.',';
    //             }
    //         }
    //     }
    //     if($key == "e_commerce_activities_FY20"){
    //         if(count($amount_of_csr_expenditure_array['e_commerce_activities_FY20']) > 0){
    //             foreach($exp_comm as $ex_comp){
    //                 $e_commerce_activities_FY20 .= $ex_comp.',';
    //             }
    //         }
    //     }
    //     if($key == "e_commerce_activities_FY19"){
    //         if(count($amount_of_csr_expenditure_array['e_commerce_activities_FY19']) > 0){
    //             foreach($exp_comm as $ex_comp){
    //                 $e_commerce_activities_FY19 .= $ex_comp.',';
    //             }
    //         }
    //     }
    //     if($key == "e_commerce_activities_FY18"){
    //         if(count($amount_of_csr_expenditure_array['e_commerce_activities_FY18']) > 0){
    //             foreach($exp_comm as $ex_comp){
    //                 $e_commerce_activities_FY18 .= $ex_comp.',';
    //             }
    //         }
    //     }
    // } 
    $total_e_commerce_activities_FY20 = $amount_of_csr_expenditure_array['total_csr_activities_FY20'];
    $total_e_commerce_activities_FY19 = $amount_of_csr_expenditure_array['total_csr_activities_FY19'];
    $total_e_commerce_activities_FY18 = $amount_of_csr_expenditure_array['total_csr_activities_FY18'];
    $details_of_csr = $innovative_company['details_of_csr'];
    $details_of_innovation = $innovative_company['details_of_innovation'];
    $innovation_of_manufacturing_details = $innovative_company['innovation_of_manufacturing_details'];

    $e_commerce_activities_e='';$e_commerce_activities_FY20_e='';$e_commerce_activities_FY19_e='';$e_commerce_activities_FY18_e='';
    $amount_e_commerce_activities_e_array = unserialize($innovative_company['amount_e_commerce_activities']);

    $e_commerce_activities_e = $amount_e_commerce_activities_e_array['e_commerce_activities'][0];
    $e_commerce_activities_e_FY20 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY20'][0];
    $e_commerce_activities_e_FY19 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY19'][0];
    $e_commerce_activities_e_FY18 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY18'][0];
    $e_commerce_activities_e_1 = $amount_e_commerce_activities_e_array['e_commerce_activities'][1];
    $e_commerce_activities_e_FY20_1 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY20'][1];
    $e_commerce_activities_e_FY19_1 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY19'][1];
    $e_commerce_activities_e_FY18_1 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY18'][1];
    $e_commerce_activities_e_2 = $amount_e_commerce_activities_e_array['e_commerce_activities'][2];
    $e_commerce_activities_e_FY20_2 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY20'][2];
    $e_commerce_activities_e_FY19_2 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY19'][2];
    $e_commerce_activities_e_FY18_2 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY18'][2];
    $e_commerce_activities_e_3 = $amount_e_commerce_activities_e_array['e_commerce_activities'][3];
    $e_commerce_activities_e_FY20_3 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY20'][3];
    $e_commerce_activities_e_FY19_3 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY19'][3];
    $e_commerce_activities_e_FY18_3 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY18'][3];
    $e_commerce_activities_e_4 = $amount_e_commerce_activities_e_array['e_commerce_activities'][4];
    $e_commerce_activities_e_FY20_4 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY20'][4];
    $e_commerce_activities_e_FY19_4 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY19'][4];
    $e_commerce_activities_e_FY18_4 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY18'][4];
    $e_commerce_activities_e_5 = $amount_e_commerce_activities_e_array['e_commerce_activities'][5];
    $e_commerce_activities_e_FY20_5 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY20'][5];
    $e_commerce_activities_e_FY19_5 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY19'][5];
    $e_commerce_activities_e_FY18_5 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY18'][5];
    $e_commerce_activities_e_6 = $amount_e_commerce_activities_e_array['e_commerce_activities'][6];
    $e_commerce_activities_e_FY20_6 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY20'][6];
    $e_commerce_activities_e_FY19_6 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY19'][6];
    $e_commerce_activities_e_FY18_6 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY18'][6];
    $e_commerce_activities_e_7 = $amount_e_commerce_activities_e_array['e_commerce_activities'][7];
    $e_commerce_activities_e_FY20_7 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY20'][7];
    $e_commerce_activities_e_FY19_7 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY19'][7];
    $e_commerce_activities_e_FY18_7 = $amount_e_commerce_activities_e_array['e_commerce_activities_FY18'][7];
    // foreach($amount_e_commerce_activities_e_array as $key=>$exp_comm_e){
    //     if($key == "e_commerce_activities"){
    //         if(count($amount_e_commerce_activities_e_array['e_commerce_activities']) > 0){
    //             foreach($exp_comm_e as $ex_comp){
    //                 $e_commerce_activities_e .= $ex_comp.',';
    //             }
    //         }
    //     }
    //     if($key == "e_commerce_activities_FY20"){
    //         if(count($amount_e_commerce_activities_e_array['e_commerce_activities_FY20']) > 0){
    //             foreach($exp_comm_e as $ex_comp){
    //                 $e_commerce_activities_FY20_e .= $ex_comp.',';
    //             }
    //         }
    //     }
    //     if($key == "e_commerce_activities_FY19"){
    //         if(count($amount_e_commerce_activities_e_array['e_commerce_activities_FY19']) > 0){
    //             foreach($exp_comm_e as $ex_comp){
    //                 $e_commerce_activities_FY19_e .= $ex_comp.',';
    //             }
    //         }
    //     }
    //     if($key == "e_commerce_activities_FY18"){
    //         if(count($amount_e_commerce_activities_e_array['e_commerce_activities_FY18']) > 0){
    //             foreach($exp_comm_e as $ex_comp){
    //                 $e_commerce_activities_FY18_e .= $ex_comp.',';
    //             }
    //         }
    //     }
    // } 
    $total_e_commerce_activities_FY20_e = $amount_e_commerce_activities_e_array['total_e_commerce_activities_FY20'];
    $total_e_commerce_activities_FY19_e = $amount_e_commerce_activities_e_array['total_e_commerce_activities_FY19'];
    
    $sql_query = "SELECT * FROM  igja_industry_performance_declaration where reg_id=$id ORDER BY id desc";
    $declaration = $conn->query($sql_query);
    $declaration =  $declaration->fetch_assoc();
    $respondant_name = $declaration['respondant_name'];
    $designation = $declaration['designation'];
    $mobile = $declaration['mobile'];
    $email_id = $declaration['email_id'];
    $ca_firm_name = $declaration['ca_firm_name'];
    $ca_name = $declaration['ca_name'];
    $ca_designation = $declaration['ca_designation'];
    $ca_mobile = $declaration['ca_mobile'];
    $ca_email = $declaration['ca_email'];
    $status = $declaration['status'];

    $table .= '<tr>
    <td>'.$id.'</td>
    <td>'.$created_at.'</td>
    <td>'.$company_name.'</td>
    <td>'.$est_year.'</td>
    <td>'.$imp_exp_code.'</td>
    <td>'.$tel_no.'</td>
    <td>'.$email.'</td>
    <td>'.$website.'</td>
    <td>'.$address_line_1.'</td>
    <td>'.$address_line_2.'</td>
    <td>'.$city.'</td>
    <td>'.$state.'</td>
    <td>'.$zipcode.'</td>
    <td>'.$membership_no.'</td>
    <td>'.$membership_year.'</td>
    <td>'.$company_type.'</td>
    <td>'.$nature_of_business.'</td>
    <td>'.$sm_name.'</td>
    <td>'.$sm_designation.'</td>
    <td>'.$performance.'</td>
    <td>'.$theme.'</td>
    <td>'.$other.'</td>
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
    <td>'.$other_employees_FY20.'</td>
    <td>'.$other_employees_FY19.'</td>
    <td>'.$other_employees_FY18.'</td>
    <td>'.$incm_tax_paid_FY20.'</td>
    <td>'.$incm_tax_paid_FY19.'</td>
    <td>'.$incm_tax_paid_FY18.'</td>
    
    <td>'.$isApplicable_FY21.'</td>
    <td>'.$total_sales_FY21.'</td>
    <td>'.$domestic_sales_FY21.'</td>
    <td>'.$export_sales_FY21.'</td>
    <td>'.$net_profit_FY21.'</td>
    <td>'.$value_addition_FY21.'</td>
    <td>'.$calc_value_addition_FY21.'</td>
    <td>'.$isApplicable_FY20.'</td>
    <td>'.$total_sales_FY20.'</td>
    <td>'.$domestic_sales_FY20.'</td>
    <td>'.$export_sales_FY20.'</td>
    <td>'.$net_profit_FY20.'</td>
    <td>'.$value_addition_FY20.'</td>
    <td>'.$calc_value_addition_FY20.'</td>
    <td>'.$isApplicable_FY19.'</td>
    <td>'.$total_sales_FY19.'</td>
    <td>'.$domestic_sales_FY19.'</td>
    <td>'.$export_sales_FY19.'</td>
    <td>'.$net_profit_FY19.'</td>
    <td>'.$value_addition_FY19.'</td>
    <td>'.$calc_value_addition_FY19.'</td>    
    <td>'.$isApplicable_FY21_1.'</td>
    <td>'.$total_sales_FY21_1.'</td>
    <td>'.$domestic_sales_FY21_1.'</td>
    <td>'.$export_sales_FY21_1.'</td>
    <td>'.$net_profit_FY21_1.'</td>
    <td>'.$value_addition_FY21_1.'</td>
    <td>'.$calc_value_addition_FY21_1.'</td>
    <td>'.$isApplicable_FY20_1.'</td>
    <td>'.$total_sales_FY20_1.'</td>
    <td>'.$domestic_sales_FY20_1.'</td>
    <td>'.$export_sales_FY20_1.'</td>
    <td>'.$net_profit_FY20_1.'</td>
    <td>'.$value_addition_FY20_1.'</td>
    <td>'.$calc_value_addition_FY20_1.'</td>
    <td>'.$isApplicable_FY19_1.'</td>
    <td>'.$total_sales_FY19_1.'</td>
    <td>'.$domestic_sales_FY19_1.'</td>
    <td>'.$export_sales_FY19_1.'</td>
    <td>'.$net_profit_FY19_1.'</td>
    <td>'.$value_addition_FY19_1.'</td>
    <td>'.$calc_value_addition_FY19_1.'</td>
    <td>'.$isApplicable_FY21_2.'</td>
    <td>'.$total_sales_FY21_2.'</td>
    <td>'.$domestic_sales_FY21_2.'</td>
    <td>'.$export_sales_FY21_2.'</td>
    <td>'.$net_profit_FY21_2.'</td>
    <td>'.$value_addition_FY21_2.'</td>
    <td>'.$calc_value_addition_FY21_2.'</td>
    <td>'.$isApplicable_FY20_2.'</td>
    <td>'.$total_sales_FY20_2.'</td>
    <td>'.$domestic_sales_FY20_2.'</td>
    <td>'.$export_sales_FY20_2.'</td>
    <td>'.$net_profit_FY20_2.'</td>
    <td>'.$value_addition_FY20_2.'</td>
    <td>'.$calc_value_addition_FY20_2.'</td>
    <td>'.$isApplicable_FY19_2.'</td>
    <td>'.$total_sales_FY19_2.'</td>
    <td>'.$domestic_sales_FY19_2.'</td>
    <td>'.$export_sales_FY19_2.'</td>
    <td>'.$net_profit_FY19_2.'</td>
    <td>'.$value_addition_FY19_2.'</td>
    <td>'.$calc_value_addition_FY19_2.'</td>   
    <td>'.$isApplicable_FY21_3.'</td>
    <td>'.$total_sales_FY21_3.'</td>
    <td>'.$domestic_sales_FY21_3.'</td>
    <td>'.$export_sales_FY21_3.'</td>
    <td>'.$net_profit_FY21_3.'</td>
    <td>'.$value_addition_FY21_3.'</td>
    <td>'.$calc_value_addition_FY21_3.'</td>
    <td>'.$isApplicable_FY20_3.'</td>
    <td>'.$total_sales_FY20_3.'</td>
    <td>'.$domestic_sales_FY20_3.'</td>
    <td>'.$export_sales_FY20_3.'</td>
    <td>'.$net_profit_FY20_3.'</td>
    <td>'.$value_addition_FY20_3.'</td>
    <td>'.$calc_value_addition_FY20_3.'</td>
    <td>'.$isApplicable_FY19_3.'</td>
    <td>'.$total_sales_FY19_3.'</td>
    <td>'.$domestic_sales_FY19_3.'</td>
    <td>'.$export_sales_FY19_3.'</td>
    <td>'.$net_profit_FY19_3.'</td>
    <td>'.$value_addition_FY19_3.'</td>
    <td>'.$calc_value_addition_FY19_3.'</td>
    <td>'.$isApplicable_FY21_4.'</td>
    <td>'.$total_sales_FY21_4.'</td>
    <td>'.$domestic_sales_FY21_4.'</td>
    <td>'.$export_sales_FY21_4.'</td>
    <td>'.$net_profit_FY21_4.'</td>
    <td>'.$value_addition_FY21_4.'</td>
    <td>'.$calc_value_addition_FY21_4.'</td>
    <td>'.$isApplicable_FY20_4.'</td>
    <td>'.$total_sales_FY20_4.'</td>
    <td>'.$domestic_sales_FY20_4.'</td>
    <td>'.$export_sales_FY20_4.'</td>
    <td>'.$net_profit_FY20_4.'</td>
    <td>'.$value_addition_FY20_4.'</td>
    <td>'.$calc_value_addition_FY20_4.'</td>
    <td>'.$isApplicable_FY19_4.'</td>
    <td>'.$total_sales_FY19_4.'</td>
    <td>'.$domestic_sales_FY19_4.'</td>
    <td>'.$export_sales_FY19_4.'</td>
    <td>'.$net_profit_FY19_4.'</td>
    <td>'.$value_addition_FY19_4.'</td>
    <td>'.$calc_value_addition_FY19_4.'</td>
    <td>'.$isApplicable_FY21_5.'</td>
    <td>'.$total_sales_FY21_5.'</td>
    <td>'.$domestic_sales_FY21_5.'</td>
    <td>'.$export_sales_FY21_5.'</td>
    <td>'.$net_profit_FY21_5.'</td>
    <td>'.$value_addition_FY21_5.'</td>
    <td>'.$calc_value_addition_FY21_5.'</td>
    <td>'.$isApplicable_FY20_5.'</td>
    <td>'.$total_sales_FY20_5.'</td>
    <td>'.$domestic_sales_FY20_5.'</td>
    <td>'.$export_sales_FY20_5.'</td>
    <td>'.$net_profit_FY20_5.'</td>
    <td>'.$value_addition_FY20_5.'</td>
    <td>'.$calc_value_addition_FY20_5.'</td>
    <td>'.$isApplicable_FY19_5.'</td>
    <td>'.$total_sales_FY19_5.'</td>
    <td>'.$domestic_sales_FY19_5.'</td>
    <td>'.$export_sales_FY19_5.'</td>
    <td>'.$net_profit_FY19_5.'</td>
    <td>'.$value_addition_FY19_5.'</td>
    <td>'.$calc_value_addition_FY19_5.'</td>
    <td>'.$isApplicable_FY21_6.'</td>
    <td>'.$total_sales_FY21_6.'</td>
    <td>'.$domestic_sales_FY21_6.'</td>
    <td>'.$export_sales_FY21_6.'</td>
    <td>'.$net_profit_FY21_6.'</td>
    <td>'.$value_addition_FY21_6.'</td>
    <td>'.$calc_value_addition_FY21_6.'</td>
    <td>'.$isApplicable_FY20_6.'</td>
    <td>'.$total_sales_FY20_6.'</td>
    <td>'.$domestic_sales_FY20_6.'</td>
    <td>'.$export_sales_FY20_6.'</td>
    <td>'.$net_profit_FY20_6.'</td>
    <td>'.$value_addition_FY20_6.'</td>
    <td>'.$calc_value_addition_FY20_6.'</td>
    <td>'.$isApplicable_FY19_6.'</td>
    <td>'.$total_sales_FY19_6.'</td>
    <td>'.$domestic_sales_FY19_6.'</td>
    <td>'.$export_sales_FY19_6.'</td>
    <td>'.$net_profit_FY19_6.'</td>
    <td>'.$value_addition_FY19_6.'</td>
    <td>'.$calc_value_addition_FY19_6.'</td>
    <td>'.$isApplicable_FY21_7.'</td>
    <td>'.$total_sales_FY21_7.'</td>
    <td>'.$domestic_sales_FY21_7.'</td>
    <td>'.$export_sales_FY21_7.'</td>
    <td>'.$net_profit_FY21_7.'</td>
    <td>'.$value_addition_FY21_7.'</td>
    <td>'.$calc_value_addition_FY21_7.'</td>
    <td>'.$isApplicable_FY20_7.'</td>
    <td>'.$total_sales_FY20_7.'</td>
    <td>'.$domestic_sales_FY20_7.'</td>
    <td>'.$export_sales_FY20_7.'</td>
    <td>'.$net_profit_FY20_7.'</td>
    <td>'.$value_addition_FY20_7.'</td>
    <td>'.$calc_value_addition_FY20_7.'</td>
    <td>'.$isApplicable_FY19_7.'</td>
    <td>'.$total_sales_FY19_7.'</td>
    <td>'.$domestic_sales_FY19_7.'</td>
    <td>'.$export_sales_FY19_7.'</td>
    <td>'.$net_profit_FY19_7.'</td>
    <td>'.$value_addition_FY19_7.'</td>
    <td>'.$calc_value_addition_FY19_7.'</td>

    <td>'.$export_questions.'</td>
    <td>'.$export_details_FY21.'</td>
    <td>'.$export_details_FY19.'</td>
    <td>'.$export_details_FY18.'</td>   
    <td>'.$export_questions_1.'</td>
    <td>'.$export_details_FY21_1.'</td>
    <td>'.$export_details_FY19_1.'</td>
    <td>'.$export_details_FY18_1.'</td>
    <td>'.$export_questions_2.'</td>
    <td>'.$export_details_FY21_2.'</td>
    <td>'.$export_details_FY19_2.'</td>
    <td>'.$export_details_FY18_2.'</td>
    <td>'.$export_questions_3.'</td>
    <td>'.$export_details_FY21_3.'</td>
    <td>'.$export_details_FY19_3.'</td>
    <td>'.$export_details_FY18_3.'</td>
    
    <td>'.$country_FY20.'</td>
    <td>'.$export_sales_rs_FY20.'</td>
    <td>'.$export_sales_dollar_FY20.'</td>
    <td>'.$country_FY19.'</td>
    <td>'.$export_sales_rs_FY19.'</td>
    <td>'.$export_sales_dollar_FY19.'</td>
     <td>'.$country_FY18.'</td>
    <td>'.$export_sales_rs_FY18.'</td>
    <td>'.$export_sales_dollar_FY18.'</td>
    <td>'.$business_details_and_explanation_3.'</td>
    <td>'.$strategic_export_initiative_3.'</td>
    <td>'.$case_of_excellence_3.'</td>

    <td>'.$attatchment_details.'</td>
    <td>'.$business_details_and_explanation.'</td>
    <td>'.$strategic_export_initiative.'</td>
    <td>'.$case_of_excellence.'</td>
    <td>'.$nominated_segment.'</td>
    <td>'.$number_comp_outlets.'</td>
    <td>'.$number_of_internation_clients.'</td>
    <td>'.$sm_title.'</td>
    <td>'.$name_w.'</td>
    <td>'.$designation.'</td>
    <td>'.$experience.'</td>
    <td>'.$approach.'</td>
    <td>'.$is_mandatory.'</td>
    <td>'.$mandatory_details.'</td>
   
    <td>'.$r_n_d_activities.'</td>
    <td>'.$r_n_d_activitiesFY2020_21.'</td>
    <td>'.$r_n_d_activitiesFY2019_20.'</td>
    <td>'.$r_n_d_activitiesFY2019_18.'</td>
    <td>'.$r_n_d_activities_1.'</td>
    <td>'.$r_n_d_activitiesFY2020_21_1.'</td>
    <td>'.$r_n_d_activitiesFY2019_20_1.'</td>
    <td>'.$r_n_d_activitiesFY2019_18_1.'</td>

    <td>'.$r_n_d_activities_2.'</td>
    <td>'.$r_n_d_activitiesFY2020_21_2.'</td>
    <td>'.$r_n_d_activitiesFY2019_20_2.'</td>
    <td>'.$r_n_d_activitiesFY2019_18_2.'</td>
    <td>'.$r_n_d_activities_3.'</td>
    <td>'.$r_n_d_activitiesFY2020_21_3.'</td>
    <td>'.$r_n_d_activitiesFY2019_20_3.'</td>
    <td>'.$r_n_d_activitiesFY2019_18_3.'</td>
    <td>'.$r_n_d_activities_4.'</td>
    <td>'.$r_n_d_activitiesFY2020_21_4.'</td>
    <td>'.$r_n_d_activitiesFY2019_20_4.'</td>
    <td>'.$r_n_d_activitiesFY2019_18_4.'</td>
    <td>'.$r_n_d_activities_5.'</td>
    <td>'.$r_n_d_activitiesFY2020_21_5.'</td>
    <td>'.$r_n_d_activitiesFY2019_20_5.'</td>
    <td>'.$r_n_d_activitiesFY2019_18_5.'</td>
    <td>'.$r_n_d_activities_6.'</td>
    <td>'.$r_n_d_activitiesFY2020_21_6.'</td>
    <td>'.$r_n_d_activitiesFY2019_20_6.'</td>
    <td>'.$r_n_d_activitiesFY2019_18_6.'</td>
    <td>'.$r_n_d_activities_7.'</td>
    <td>'.$r_n_d_activitiesFY2020_21_7.'</td>
    <td>'.$r_n_d_activitiesFY2019_20_7.'</td>
    <td>'.$r_n_d_activitiesFY2019_18_7.'</td>
    <td>'.$total_r_n_d_activities_FY20.'</td>
    <td>'.$total_r_n_d_activities_FY19.'</td>
    <td>'.$total_r_n_d_activities_FY18.'</td>
    <td>'.$details_r_n_d_activities.'</td>
    <td>'.$innovation_activities_last_3_yr.'</td>
    <td>'.$how_impact_innovation.'</td>
    <td>'.$registered_patents_for_innovation.'</td>
    <td>'.$award_and_accolades_won_details.'</td>

    
    <td>'.$e_commerce_activities.'</td>
    <td>'.$e_commerce_activities_FY20.'</td>
    <td>'.$e_commerce_activities_FY19.'</td>
    <td>'.$e_commerce_activities_FY18.'</td>
    <td>'.$e_commerce_activities_1.'</td>
    <td>'.$e_commerce_activities_FY20_1.'</td>
    <td>'.$e_commerce_activities_FY19_1.'</td>
    <td>'.$e_commerce_activities_FY18_1.'</td>
    <td>'.$e_commerce_activities_2.'</td>
    <td>'.$e_commerce_activities_FY20_2.'</td>
    <td>'.$e_commerce_activities_FY19_2.'</td>
    <td>'.$e_commerce_activities_FY18_2.'</td>
    <td>'.$e_commerce_activities_3.'</td>
    <td>'.$e_commerce_activities_FY20_3.'</td>
    <td>'.$e_commerce_activities_FY19_3.'</td>
    <td>'.$e_commerce_activities_FY18_3.'</td>
    <td>'.$e_commerce_activities_4.'</td>
    <td>'.$e_commerce_activities_FY20_4.'</td>
    <td>'.$e_commerce_activities_FY19_4.'</td>
    <td>'.$e_commerce_activities_FY18_4.'</td>
    <td>'.$e_commerce_activities_5.'</td>
    <td>'.$e_commerce_activities_FY20_5.'</td>
    <td>'.$e_commerce_activities_FY19_5.'</td>
    <td>'.$e_commerce_activities_FY18_5.'</td>
    <td>'.$e_commerce_activities_6.'</td>
    <td>'.$e_commerce_activities_FY20_6.'</td>
    <td>'.$e_commerce_activities_FY19_6.'</td>
    <td>'.$e_commerce_activities_FY18_6.'</td>
    <td>'.$e_commerce_activities_7.'</td>
    <td>'.$e_commerce_activities_FY20_7.'</td>
    <td>'.$e_commerce_activities_FY19_7.'</td>
    <td>'.$e_commerce_activities_FY18_7.'</td>

    <td>'.$total_e_commerce_activities_FY20.'</td>
    <td>'.$total_e_commerce_activities_FY19.'</td>
    <td>'.$total_e_commerce_activities_FY18.'</td>
    <td>'.$details_of_csr.'</td>
    <td>'.$details_of_innovation.'</td>
    <td>'.$innovation_of_manufacturing_details.'</td>
    <td>'.$e_commerce_activities_e.'</td>
    <td>'.$e_commerce_activities_e_FY20.'</td>
    <td>'.$e_commerce_activities_e_FY19.'</td>
    <td>'.$e_commerce_activities_e_1.'</td>
    <td>'.$e_commerce_activities_e_FY20_1.'</td>
    <td>'.$e_commerce_activities_e_FY19_1.'</td>
    <td>'.$e_commerce_activities_e_2.'</td>
    <td>'.$e_commerce_activities_e_FY20_2.'</td>
    <td>'.$e_commerce_activities_e_FY19_2.'</td>
    <td>'.$e_commerce_activities_e_3.'</td>
    <td>'.$e_commerce_activities_e_FY20_3.'</td>
    <td>'.$e_commerce_activities_e_FY19_3.'</td>
    <td>'.$e_commerce_activities_e_4.'</td>
    <td>'.$e_commerce_activities_e_FY20_4.'</td>
    <td>'.$e_commerce_activities_e_FY19_4.'</td>
    <td>'.$e_commerce_activities_e_5.'</td>
    <td>'.$e_commerce_activities_e_FY20_5.'</td>
    <td>'.$e_commerce_activities_e_FY19_5.'</td>
    <td>'.$e_commerce_activities_e_6.'</td>
    <td>'.$e_commerce_activities_e_FY20_6.'</td>
    <td>'.$e_commerce_activities_e_FY19_6.'</td>
    <td>'.$e_commerce_activities_e_7.'</td>
    <td>'.$e_commerce_activities_e_FY20_7.'</td>
    <td>'.$e_commerce_activities_e_FY19_7.'</td>
    <td>'.$total_e_commerce_activities_FY20_e.'</td>
    <td>'.$total_e_commerce_activities_FY19_e.'</td>

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