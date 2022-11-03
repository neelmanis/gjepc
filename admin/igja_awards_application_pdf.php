<?php
session_start();  
ob_start();
require_once('../rcmc/tcpdf_include.php'); 
require_once('../db.inc.php');
//require_once('../functions.php');

if(isset($_REQUEST['registration_id']) && $_REQUEST['registration_id']!='')
{
	$registration_id=$_REQUEST['registration_id'];
}else{
	 echo "USER DOES NOT EXIST";exit;
}

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	protected $address;
	protected $email;
	protected $tel_no;
	protected $fax;
	
	function __construct( $address , $tel_no, $email, $fax, $orientation, $unit, $format ) 
    {
        parent::__construct( $orientation, $unit, $format, true, 'UTF-8', false );		
        $this->address = $address ;
		$this->email = $email ;
		$this->tel_no = $tel_no ;
		$this->fax = $fax ;        
    }
	
	public function Header() {
		
		    //right Logo
    		$left_image_file =  K_PATH_IMAGES.'logo_gjepc.png';
    		$this->Image($left_image_file, 162, 15, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
    		// //left Logo
    		//$right_image_file =  K_PATH_IMAGES.'logo_gjepc.png';
    		//$this->Image($right_image_file, 15, 15, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
            // $this->SetLineStyle(1);
            // $this->Rect(8,8,193,275);
	 }

	// Page footer
	// public function Footer() {
			
	// 	// Position at 15 mm from bottom
 //    		$this->SetY(-72);
	// 		$this->SetFont('times', '', 10);
	// 		$this->Cell(180, 5, 'This certificate is digitally signed and does not require physical signature. ', 0, 0, 'C', 0, '', 0, false, 'T', 'M');
	// 		$this->Ln();
 //    		// Set font 
 //    		$this->SetFont('times', 'B', 13);
 //    		// Page number
	// 		$this->Cell(180, 6, '', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
 //    		$this->Cell(180, 6, 'The Gem & Jewellery Export Promotion Council ', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
	// 		$this->SetFont('times', '', 8);
	// 		$this->Cell(180, 5, 'CIN U99100MH1966GAP013486', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
			
 //    		// Page number
	// 		if($this->email != "gjepc@vsnl.com")
	// 		{
	// 		$this->SetFont('times', 'B', 8);
	// 		$this->Cell(180, 5, 'Regional Office:'.$this->address, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
	// 		}
	// 		else
	// 		{	
	// 			$this->SetFont('times', '', 8);
	// 			$this->Cell(180, 5, 'Head office:'.$this->address, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
				
	// 		}
	// 		$this->SetFont('times', 'b', 8);
 //    		// Page number
 //    		$this->Cell(180, 5, 'Tel: '. $this->tel_no .' Fax:'. $this->fax.' E-mail: '. $this->email .' Website: http://www.gjepc.org' , 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
			
	// 		if($this->email != "gjepc@vsnl.com"){
	// 			$this->SetFont('times', '', 8);
	// 			$this->Cell(180, 5, 'Head Office : Tower A, AW 1010, G Block, Bharat Diamond Bourse, Bandra-Kurla Complex, Bandra - East, Mumbai - 400 051', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
	// 			$this->Cell(180, 5, 'Tel: 91-22-26544600 , Email: gjepc@vsnl.com', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
	// 		}
	// }
}

if(isset($_REQUEST['registration_id']) && $_REQUEST['registration_id']!='')
{
		 $uid=$_REQUEST['registration_id'];
}
	
	$fetch_general_info="select * from igja_industry_performance_and_theme_based_awards where id='$registration_id' ";
	$fetch_cat_specific_info="select * from igja_industry_performance_award_category_info where reg_id='$registration_id'";
	$fetch_best_growing="select * from igja_industry_performance_best_growing_performance where reg_id='$registration_id'";
	$fetch_qualitative ="select * from igja_industry_perfomance_qualitative_info where reg_id='$registration_id' ";
	$fetch_declaration="select * from igja_industry_performance_declaration where reg_id='$registration_id'";
	$fetch_innovative="select * from igja_theme_based_innovative_company where reg_id='$registration_id'";
	$fetch_socially_responsible="select * from igja_theme_base_socially_responsible where reg_id='$registration_id'";
	$fetch_digital_initiative="select * from igja_theme_based_digital_initiative where reg_id='$registration_id'";
	$fetch_woman_entrepreneur="select * from igja_theme_based_woman_entrepreneur where reg_id='$registration_id'";
	
	$result_general_info = $conn ->query($fetch_general_info);
	$result_cat_specific_info = $conn ->query($fetch_cat_specific_info);
	$result_best_growing = $conn ->query($fetch_best_growing);
	$result_qualitative = $conn ->query($fetch_qualitative);
	$result_declaration = $conn ->query($fetch_declaration);
	$result_innovative = $conn ->query($fetch_innovative);
	$result_socially_responsible = $conn ->query($fetch_socially_responsible);
	$result_digital_initiative = $conn ->query($fetch_digital_initiative);
	$result_woman_entrepreneur = $conn ->query($fetch_woman_entrepreneur);
	
	

	$rows_general_info = $result_general_info->fetch_assoc();
	$rows_cat_specific_info = $result_cat_specific_info->fetch_assoc(); 
	$rows_best_growing = $result_best_growing->fetch_assoc(); 
	$rows_qualitative = $result_qualitative->fetch_assoc(); 
	$rows_declaration = $result_declaration->fetch_assoc(); 
	$rows_innovative = $result_innovative->fetch_assoc(); 
	$rows_socially_responsible = $result_socially_responsible->fetch_assoc(); 
	$rows_digital_initiative = $result_digital_initiative->fetch_assoc(); 
	$rows_woman_entrepreneur = $result_woman_entrepreneur->fetch_assoc(); 
	//$date=date('d/m/Y',strtotime($rows['membership_issued_certificate_dt']));
	$date=date('d/m/Y',strtotime($rows_general_info['created_at']));
	$senior_management = unserialize($rows_general_info['senior_management']);
	$company_details = unserialize($rows_general_info['company_details']);
	$product_segment_FY20 = unserialize($rows_cat_specific_info['product_segment_FY20']);
	$product_segment_FY19 = unserialize($rows_cat_specific_info['product_segment_FY19']);
	$product_segment_FY18 = unserialize($rows_cat_specific_info['product_segment_FY18']);


	$export_details = unserialize($rows_best_growing['export_details']);
	$export_country_details_FY20 = unserialize($rows_best_growing['export_country_details_FY20']);
	$export_country_details_FY19 = unserialize($rows_best_growing['export_country_details_FY19']);
	$amount_of_r_n_d_expenditure = unserialize($rows_innovative['amount_of_r_n_d_expenditure']);
    $turnover_through_digital_platform = unserialize($rows_digital_initiative['turnover_through_digital_platform']);
    $areas_of_excellence = unserialize($rows_digital_initiative['areas_of_excellence']);
    $csr_activities = unserialize($rows_socially_responsible['csr_activities']);
    $employee_details = unserialize($rows_socially_responsible['employee_details']);



	
     // echo "=----------".$rows_innovative['amount_of_r_n_d_expenditure']; print_r($amount_of_r_n_d_expenditure);exit;

// echo "<pre>";print_r($senior_management); $senior_management['sm_title'][0];exit;
	$content='';

		$content.='
		<br>
		<br>
		<table style="margin:2% auto;font-size:13px">
		<tr>
    <td></td>
    <td align="right">Date : '.$date.'</td>
    </tr>
      <tr>
    
    <td align="center"  colspan="2" ><p style="color:blue;font-size:18px;"> General Information </p></td>
    </tr>
    <tr>
    
    <td colspan="2" >1. Basic Information</td>
    </tr>
    
    <tr>
	    <td  width="100%" colspan="2"> 
	   
		<table width="100%" border="1px" cellpadding="5px">
			<tbody>
			<tr>
			<td><strong>Company Name</strong></td>
			<td>'.$rows_general_info['company_name'].'</td>
			</tr>
			<tr>
			<td><strong>Year of Establishment</strong></td>
			<td>'.$rows_general_info['est_year'].'</td>
			</tr>
			<tr>
			<td><strong>Importer Exporter Code No.:</strong></td>
			<td>'.$rows_general_info['imp_exp_code'].'</td>
			</tr>
			<tr>
			<td><strong>Tel No.:</strong></td>
			<td>'.$rows_general_info['tel_no'].'</td>
			</tr>
			<tr>
			<td><strong>Email ID:</strong></td>
			<td>'.$rows_general_info['email_id'].'</td>
			</tr>
			<tr>
			<td><strong>Website:</strong></td>
			<td>'.$rows_general_info['website'].'</td>
			</tr>
			<tr>
			<td><strong>Address:</strong></td>
			<td>'.$rows_general_info['address_line_1'].'</td>
			</tr>
			<tr>
			<td><strong>Address Line 2 (optional):</strong></td>
			<td>'.$rows_general_info['address_line_2'].'</td>
			</tr>
			 <tr>
			<td><strong>City</strong></td>
			<td>'.$rows_general_info['city'].'</td>
			</tr>
			<tr>
			<td><strong>State</strong></td>
			<td>'.$rows_general_info['state'].'</td>
			</tr>
			<tr>
			<td><strong>Zipcode</strong></td>
			<td>'.$rows_general_info['zipcode'].'</td>
			</tr>
			<tr>
			<td><strong>GJEPC Membership registration number</strong></td>
			<td>'.$rows_general_info['membership_no'].'</td>
			</tr>
			<tr>
			<td><strong>Year of acquiring GJEPC membership</strong></td>
			<td>'.$rows_general_info['membership_year'].'</td>
			</tr>
			<tr>
			<td><strong>Ownership Pattern</strong></td>

				<td>'.$rows_general_info['company_type'].'</td>
			</tr>
			<tr>
			<td><strong>Nature of Operation</strong></td>
			<td>'.$rows_general_info['nature_of_business'].'</td>

			</tr>
			</tbody>
		</table>
		</td>
		
	</tr>
	<tr>
    <td colspan="2"><br></td>
    </tr>
	<tr>
    <td colspan="2">2. Senior Management </td>
    </tr>
    <tr>
	    <td colspan="2"> 
	   
		<table width="100%" border="1px" cellpadding="5px" >
			<thead>
			<tr>
			<th><strong>Title</strong></th>
			<th><strong>Name</strong></th>
			<th> <strong>Designation</strong></th>
			</tr>
			</thead>
			<tbody>
			<tr>
			<td>'.$senior_management['sm_title'][0].'</td>
			<td>'.$senior_management['sm_name'][0].'</td>
			<td>'.$senior_management['sm_designation'][0].'</td>
			
			</tr>
			<tr>
			<td>'.$senior_management['sm_title'][1].'</td>
			<td>'.$senior_management['sm_name'][1].'</td>
			<td>'.$senior_management['sm_designation'][1].'</td>
			
			</tr>
			<tr>
			<td>'.$senior_management['sm_title'][2].'</td>
			<td>'.$senior_management['sm_name'][2].'</td>
			<td>'.$senior_management['sm_designation'][2].'</td>
			
			</tr>
			</tbody>
		</table>
		</td>
		
	</tr>
		<tr>
    <td colspan="2"><br></td>
    </tr>
	<tr>
    <td colspan="2">3. Award Categories </td>
    </tr>
     <tr>
	    <td colspan="2"> 
	   
		<table width="100%" border="1px" cellpadding="5px">
			<thead>
			<tr>
			<th><strong>Industry Performance Awards Categories</strong></th>
			<th><strong>Theme based Award Categories</strong></th>
			<th><strong>Other Categories</strong></th>
			</tr>
			</thead>
			<tbody>
			<tr>
			<td>';
			foreach (explode("_",$rows_general_info['performance_award_category']) as $performance) {
			$content.=	$performance."<br>";
			}

$content.='</td>
			<td>';
			foreach (explode("_",$rows_general_info['theme_based_award_category']) as $performance) {
			$content.=	$performance."<br>";
			}

$content.='</td>
			<td>';
			foreach (explode("_",$rows_general_info['other_award_category']) as $performance) {
			$content.=	$performance."<br>";
			}

$content.='</td>
			</tr>
			

			</tbody>
		</table>
		</td>
		
	</tr>
	<tr>
    <td colspan="2"><br></td>
    </tr>
	<tr>
    <td colspan="2">4. Overall Company Details </td>
    </tr>
    <tr>
	    <td colspan="2"> 
	   
		<table width="100%" border="1px" cellpadding="5px">
			<thead>
		    <tr>
			<th>Particular</th>
			<th>FY20</th>
			<th>FY19</th>
			<th>FY18</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			<td>Total Income (Sales + Other Income) (Rs Crore)</td>
			<td>'.$company_details['total_income_FY20'].'</td>
			<td>'.$company_details['total_income_FY19'].'</td>
			<td>'.$company_details['total_income_FY18'].'</td>
			
			</tr>
			<tr>
			<td>Total Sales (Rs Crore)</td>
			<td>'.$company_details['total_sale_FY20'].'</td>
			<td>'.$company_details['total_sale_FY19'].'</td>
			<td>'.$company_details['total_sale_FY18'].'</td>
		
			</tr>
			<tr>
			<td>(a) Domestic Sales (Rs Crore)</td>
			
			<td>'.$company_details['domestic_sales_FY20'].'</td>
			<td>'.$company_details['domestic_sales_FY19'].'</td>
			<td>'.$company_details['domestic_sales_FY18'].'</td>
			
			</tr>
			<tr>
			<td>(b) Exports (Rs Crore)</td>
			
			<td>'.$company_details['exports_FY20'].'</td>
			<td>'.$company_details['exports_FY19'].'</td>
			<td>'.$company_details['exports_FY18'].'</td>
		
			</tr>
			<tr>
			<td>Net Profit (Rs Crore)</td>
			
			<td>'.$company_details['net_profit_FY20'].'</td>
			<td>'.$company_details['net_profit_FY19'].'</td>
			<td>'.$company_details['net_profit_FY18'].'</td>
			
			</tr>
			<tr>
			<td>Total Number of Permanent Employees*</td>
			
			<td>'.$company_details['permenant_employees_FY20'].'</td>
			<td>'.$company_details['permenant_employees_FY19'].'</td>
			<td>'.$company_details['permenant_employees_FY18'].'</td>

			</tr>
			<tr>
			<td>Total Number of Contractual Employees*</td>
			<td>'.$company_details['contractual_employees_FY20'].'</td>
			<td>'.$company_details['contractual_employees_FY19'].'</td>
			<td>'.$company_details['contractual_employees_FY18'].'</td>
			
			</tr>
			<tr>
			<td>Total Number of Employees, of any other type*</td>
			<td>'.$company_details['other_employees_FY20'].'</td>
			<td>'.$company_details['other_employees_FY19'].'</td>
			<td>'.$company_details['other_employees_FY18'].'</td>
			</tr>
			<tr>
			<td>Income Tax amount paid(Rupees in Crores)**</td>
			
			<td>'.$company_details['incm_tax_paid_FY20'].'</td>
			<td>'.$company_details['incm_tax_paid_FY19'].'</td>
			<td>'.$company_details['incm_tax_paid_FY18'].'</td>
	
			</tr>
			

			</tbody>
		</table>
		</td>
		
	</tr>
	<tr>
    <td colspan="2"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
    </tr>

	<tr>    
    <td align="center"  colspan="2" ><p style="color:blue;font-size:18px;"> Award Category Specific Information </p></td>
    </tr>
    <tr>
    <td colspan="2"><br></td>
    </tr>
    <tr>
    <td colspan="2">1. Product Wise Breakup (It is mandatory to provide product wise details for the award categories nominated for)</td>
    </tr>
    <tr>    
    <td align="center"  colspan="2" ><strong>FY2019-20</strong></td>
    </tr>
     <tr>
	    <td colspan="2"> 
	   
		<table width="100%" border="1px" cellpadding="5px">
			<thead>
		    <tr>
			<th>Product Segments (FY2019-20)</th>
			<th>Total Sales (Rs.Crore)</th>

			<th>Domestic Sales (Rs.Crore)</th>
			<th>Export Sales (Rs.Crore)</th>
			<th>Net Profit (Rs. Crore)</th>
			<th>Value Addition* (%)</th>
			<th>Calculations of Value Addition</th>
			
			</tr>
			</thead>
			<tbody><tr>
						<td>'.$product_segment_FY20['product_segment'][0].'</td>
						<td>'.$product_segment_FY20['total_sales'][0].'</td>
						<td>'.$product_segment_FY20['domestic_sales'][0].'</td>
						<td>'.$product_segment_FY20['export_sales'][0].'</td>
						<td>'.$product_segment_FY20['net_profit'][0].'</td>
						<td>'.$product_segment_FY20['value_addition'][0].'</td>
						<td>'.$product_segment_FY20['calc_value_addition'][0].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY20['product_segment'][1].'</td>
						<td>'.$product_segment_FY20['total_sales'][1].'</td>
						<td>'.$product_segment_FY20['domestic_sales'][1].'</td>
						<td>'.$product_segment_FY20['export_sales'][1].'</td>
						<td>'.$product_segment_FY20['net_profit'][1].'</td>
						<td>'.$product_segment_FY20['value_addition'][1].'</td>
						<td>'.$product_segment_FY20['calc_value_addition'][1].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY20['product_segment'][2].'</td>
						<td>'.$product_segment_FY20['total_sales'][2].'</td>
						<td>'.$product_segment_FY20['domestic_sales'][2].'</td>
						<td>'.$product_segment_FY20['export_sales'][2].'</td>
						<td>'.$product_segment_FY20['net_profit'][2].'</td>
						<td>'.$product_segment_FY20['value_addition'][2].'</td>
						<td>'.$product_segment_FY20['calc_value_addition'][2].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY20['product_segment'][3].'</td>
						<td>'.$product_segment_FY20['total_sales'][3].'</td>
						<td>'.$product_segment_FY20['domestic_sales'][3].'</td>
						<td>'.$product_segment_FY20['export_sales'][3].'</td>
						<td>'.$product_segment_FY20['net_profit'][3].'</td>
						<td>'.$product_segment_FY20['value_addition'][3].'</td>
						<td>'.$product_segment_FY20['calc_value_addition'][3].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY20['product_segment'][4].'</td>
						<td>'.$product_segment_FY20['total_sales'][4].'</td>
						<td>'.$product_segment_FY20['domestic_sales'][4].'</td>
						<td>'.$product_segment_FY20['export_sales'][4].'</td>
						<td>'.$product_segment_FY20['net_profit'][4].'</td>
						<td>'.$product_segment_FY20['value_addition'][4].'</td>
						<td>'.$product_segment_FY20['calc_value_addition'][4].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY20['product_segment'][5].'</td>
						<td>'.$product_segment_FY20['total_sales'][5].'</td>
						<td>'.$product_segment_FY20['domestic_sales'][5].'</td>
						<td>'.$product_segment_FY20['export_sales'][5].'</td>
						<td>'.$product_segment_FY20['net_profit'][5].'</td>
						<td>'.$product_segment_FY20['value_addition'][5].'</td>
						<td>'.$product_segment_FY20['calc_value_addition'][5].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY20['product_segment'][6].'</td>
						<td>'.$product_segment_FY20['total_sales'][6].'</td>
						<td>'.$product_segment_FY20['domestic_sales'][6].'</td>
						<td>'.$product_segment_FY20['export_sales'][6].'</td>
						<td>'.$product_segment_FY20['net_profit'][6].'</td>
						<td>'.$product_segment_FY20['value_addition'][6].'</td>
						<td>'.$product_segment_FY20['calc_value_addition'][6].'</td>
						
						</tr>
			        </tbody>
		</table>
	<tr>    
    <td  colspan="2" ><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
    </tr>
    <tr>    
    <td align="center"  colspan="7" ><strong>FY2018-19</strong></td>
    </tr>
		<table width="100%" border="1px" cellpadding="5px">
			<thead>
		    <tr>
			<th>Product Segments (FY2018-19)</th>
			<th>Total Sales (Rs.Crore)</th>

			<th>Domestic Sales (Rs.Crore)</th>
			<th>Export Sales (Rs.Crore)</th>
			<th>Net Profit (Rs. Crore)</th>
			<th>Value Addition* (%)</th>
			<th>Calculations of Value Addition</th>
			
			</tr>
			</thead>
			<tbody>
			<tr>
						<td>'.$product_segment_FY19['product_segment'][0].'</td>
						<td>'.$product_segment_FY19['total_sales'][0].'</td>
						<td>'.$product_segment_FY19['domestic_sales'][0].'</td>
						<td>'.$product_segment_FY19['export_sales'][0].'</td>
						<td>'.$product_segment_FY19['net_profit'][0].'</td>
						<td>'.$product_segment_FY19['value_addition'][0].'</td>
						<td>'.$product_segment_FY19['calc_value_addition'][0].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY19['product_segment'][1].'</td>
						<td>'.$product_segment_FY19['total_sales'][1].'</td>
						<td>'.$product_segment_FY19['domestic_sales'][1].'</td>
						<td>'.$product_segment_FY19['export_sales'][1].'</td>
						<td>'.$product_segment_FY19['net_profit'][1].'</td>
						<td>'.$product_segment_FY19['value_addition'][1].'</td>
						<td>'.$product_segment_FY19['calc_value_addition'][1].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY19['product_segment'][2].'</td>
						<td>'.$product_segment_FY19['total_sales'][2].'</td>
						<td>'.$product_segment_FY19['domestic_sales'][2].'</td>
						<td>'.$product_segment_FY19['export_sales'][2].'</td>
						<td>'.$product_segment_FY19['net_profit'][2].'</td>
						<td>'.$product_segment_FY19['value_addition'][2].'</td>
						<td>'.$product_segment_FY19['calc_value_addition'][2].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY19['product_segment'][3].'</td>
						<td>'.$product_segment_FY19['total_sales'][3].'</td>
						<td>'.$product_segment_FY19['domestic_sales'][3].'</td>
						<td>'.$product_segment_FY19['export_sales'][3].'</td>
						<td>'.$product_segment_FY19['net_profit'][3].'</td>
						<td>'.$product_segment_FY19['value_addition'][3].'</td>
						<td>'.$product_segment_FY19['calc_value_addition'][3].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY19['product_segment'][4].'</td>
						<td>'.$product_segment_FY19['total_sales'][4].'</td>
						<td>'.$product_segment_FY19['domestic_sales'][4].'</td>
						<td>'.$product_segment_FY19['export_sales'][4].'</td>
						<td>'.$product_segment_FY19['net_profit'][4].'</td>
						<td>'.$product_segment_FY19['value_addition'][4].'</td>
						<td>'.$product_segment_FY19['calc_value_addition'][4].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY19['product_segment'][5].'</td>
						<td>'.$product_segment_FY19['total_sales'][5].'</td>
						<td>'.$product_segment_FY19['domestic_sales'][5].'</td>
						<td>'.$product_segment_FY19['export_sales'][5].'</td>
						<td>'.$product_segment_FY19['net_profit'][5].'</td>
						<td>'.$product_segment_FY19['value_addition'][5].'</td>
						<td>'.$product_segment_FY19['calc_value_addition'][5].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY19['product_segment'][6].'</td>
						<td>'.$product_segment_FY19['total_sales'][6].'</td>
						<td>'.$product_segment_FY19['domestic_sales'][6].'</td>
						<td>'.$product_segment_FY19['export_sales'][6].'</td>
						<td>'.$product_segment_FY19['net_profit'][6].'</td>
						<td>'.$product_segment_FY19['value_addition'][6].'</td>
						<td>'.$product_segment_FY19['calc_value_addition'][6].'</td>
						
						</tr>
						</tbody>
		</table>
		<tr>    
    <td  colspan="2" ><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
    </tr>
    <tr>    
    <td align="center"  colspan="7" ><strong>FY2017-18</strong></td>
    </tr>
		<table width="100%" border="1px" cellpadding="5px">
			<thead>
		    <tr>
			<th>Product Segments (FY2017-18)</th>
			<th>Total Sales (Rs.Crore)</th>

			<th>Domestic Sales (Rs.Crore)</th>
			<th>Export Sales (Rs.Crore)</th>
			<th>Net Profit (Rs. Crore)</th>
			<th>Value Addition* (%)</th>
			<th>Calculations of Value Addition</th>
			
			</tr>
			</thead>
			<tbody>
			<tr>
						<td>'.$product_segment_FY18['product_segment'][0].'</td>
						<td>'.$product_segment_FY18['total_sales'][0].'</td>
						<td>'.$product_segment_FY18['domestic_sales'][0].'</td>
						<td>'.$product_segment_FY18['export_sales'][0].'</td>
						<td>'.$product_segment_FY18['net_profit'][0].'</td>
						<td>'.$product_segment_FY18['value_addition'][0].'</td>
						<td>'.$product_segment_FY18['calc_value_addition'][0].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY18['product_segment'][1].'</td>
						<td>'.$product_segment_FY18['total_sales'][1].'</td>
						<td>'.$product_segment_FY18['domestic_sales'][1].'</td>
						<td>'.$product_segment_FY18['export_sales'][1].'</td>
						<td>'.$product_segment_FY18['net_profit'][1].'</td>
						<td>'.$product_segment_FY18['value_addition'][1].'</td>
						<td>'.$product_segment_FY18['calc_value_addition'][1].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY18['product_segment'][2].'</td>
						<td>'.$product_segment_FY18['total_sales'][2].'</td>
						<td>'.$product_segment_FY18['domestic_sales'][2].'</td>
						<td>'.$product_segment_FY18['export_sales'][2].'</td>
						<td>'.$product_segment_FY18['net_profit'][2].'</td>
						<td>'.$product_segment_FY18['value_addition'][2].'</td>
						<td>'.$product_segment_FY18['calc_value_addition'][2].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY18['product_segment'][3].'</td>
						<td>'.$product_segment_FY18['total_sales'][3].'</td>
						<td>'.$product_segment_FY18['domestic_sales'][3].'</td>
						<td>'.$product_segment_FY18['export_sales'][3].'</td>
						<td>'.$product_segment_FY18['net_profit'][3].'</td>
						<td>'.$product_segment_FY18['value_addition'][3].'</td>
						<td>'.$product_segment_FY18['calc_value_addition'][3].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY18['product_segment'][4].'</td>
						<td>'.$product_segment_FY18['total_sales'][4].'</td>
						<td>'.$product_segment_FY18['domestic_sales'][4].'</td>
						<td>'.$product_segment_FY18['export_sales'][4].'</td>
						<td>'.$product_segment_FY18['net_profit'][4].'</td>
						<td>'.$product_segment_FY18['value_addition'][4].'</td>
						<td>'.$product_segment_FY18['calc_value_addition'][4].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY18['product_segment'][5].'</td>
						<td>'.$product_segment_FY18['total_sales'][5].'</td>
						<td>'.$product_segment_FY18['domestic_sales'][5].'</td>
						<td>'.$product_segment_FY18['export_sales'][5].'</td>
						<td>'.$product_segment_FY18['net_profit'][5].'</td>
						<td>'.$product_segment_FY18['value_addition'][5].'</td>
						<td>'.$product_segment_FY18['calc_value_addition'][5].'</td>
						
						</tr>
						<tr>
						<td>'.$product_segment_FY18['product_segment'][6].'</td>
						<td>'.$product_segment_FY18['total_sales'][6].'</td>
						<td>'.$product_segment_FY18['domestic_sales'][6].'</td>
						<td>'.$product_segment_FY18['export_sales'][6].'</td>
						<td>'.$product_segment_FY18['net_profit'][6].'</td>
						<td>'.$product_segment_FY18['value_addition'][6].'</td>
						<td>'.$product_segment_FY18['calc_value_addition'][6].'</td>
						
						</tr></tbody>
		</table>
		</td>
		
	</tr>
	<tr>    
    <td  colspan="2" ><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
    </tr>
	<tr>
    
    <td align="center"  colspan="2" ><p style="color:blue;font-size:18px;">  Export Related Information (Optional) </p></td>
    </tr>
    <tr>
       <td colspan="2">1. Export Details</td>
    </tr>
    <tr>
	    <td colspan="2">
		    <table width="100%" border="1px" cellpadding="5px">
				<thead>
			    <tr>
				<th>Details</th>
				<th>FY2019-20</th>
				<th>FY2018-19</th>
				<th>FY2017-18</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<td>'.$export_details['export_questions'][0].'</td>
				<td>'.$export_details['export_details_FY20'][0].'</td>
				<td>'.$export_details['export_details_FY19'][0].'</td>
				<td>'.$export_details['export_details_FY18'][0].'</td>
			
				</tr>
				<tr>
				<td>'.$export_details['export_questions'][1].'</td>
				<td>'.$export_details['export_details_FY20'][1].'</td>
				<td>'.$export_details['export_details_FY19'][1].'</td>
				<td>'.$export_details['export_details_FY18'][1].'</td>
			
				</tr>
				<tr>
				<td>'.$export_details['export_questions'][2].'</td>
				<td>'.$export_details['export_details_FY20'][2].'</td>
				<td>'.$export_details['export_details_FY19'][2].'</td>
				<td>'.$export_details['export_details_FY18'][2].'</td>
			
				</tr>
				<tr>
				<td>'.$export_details['export_questions'][3].'</td>
				<td>'.$export_details['export_details_FY20'][3].'</td>
				<td>'.$export_details['export_details_FY19'][3].'</td>
				<td>'.$export_details['export_details_FY18'][3].'</td>
			
				</tr>
				<tr>
				<td>'.$export_details['export_questions'][4].'</td>
				<td>'.$export_details['export_details_FY20'][4].'</td>
				<td>'.$export_details['export_details_FY19'][4].'</td>
				<td>'.$export_details['export_details_FY18'][4].'</td>
			
				</tr>
				</tbody>
			</table>
	    </td>
    </tr>
    <tr>    
    <td  colspan="2" ><br></td>
    </tr>
    <tr>
        <td colspan="2">2.Please provide details of 5 major countries (not regions) of exports</td>
    </tr>
    <tr>
	    <td width="50%">
		    <table width="100%" border="1px" cellpadding="5px">
				<thead>
			    <tr>
				<th>Country</th>
				<th>Export Sales(in Rs. crore)</th>
				<th>Export Sales(in US $)</th>
				
				</tr>
				</thead>
				<tbody>
				<tr>
				<td>'.$export_country_details_FY20['country_FY20'][0].'</td>
				<td>'.$export_country_details_FY20['export_sales_rs_FY20'][0].'</td>
				<td>'.$export_country_details_FY20['export_sales_dollar_FY20'][0].'</td>
				</tr>
				<tr>
				<td>'.$export_country_details_FY20['country_FY20'][1].'</td>
				<td>'.$export_country_details_FY20['export_sales_rs_FY20'][1].'</td>
				<td>'.$export_country_details_FY20['export_sales_dollar_FY20'][1].'</td>
				</tr>
				<tr>
				<td>'.$export_country_details_FY20['country_FY20'][2].'</td>
				<td>'.$export_country_details_FY20['export_sales_rs_FY20'][2].'</td>
				<td>'.$export_country_details_FY20['export_sales_dollar_FY20'][2].'</td>
				</tr>
				<tr>
				<td>'.$export_country_details_FY20['country_FY20'][3].'</td>
				<td>'.$export_country_details_FY20['export_sales_rs_FY20'][3].'</td>
				<td>'.$export_country_details_FY20['export_sales_dollar_FY20'][3].'</td>
				</tr>
				<tr>
				<td>'.$export_country_details_FY20['country_FY20'][4].'</td>
				<td>'.$export_country_details_FY20['export_sales_rs_FY20'][4].'</td>
				<td>'.$export_country_details_FY20['export_sales_dollar_FY20'][4].'</td>
				</tr>
				</tbody>
			</table>
	    </td>
	    <td width="50%">
		   <table width="100%" border="1px" cellpadding="5px">
				<thead>
				    <tr>
					<th>Country</th>
					<th>Export Sales(in Rs. crore)</th>
					<th>Export Sales(in US $)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
				<td>'.$export_country_details_FY19['country_FY20'][0].'</td>
				<td>'.$export_country_details_FY19['export_sales_rs_FY20'][0].'</td>
				<td>'.$export_country_details_FY19['export_sales_dollar_FY20'][0].'</td>
				</tr>
				<tr>
				<td>'.$export_country_details_FY19['country_FY20'][1].'</td>
				<td>'.$export_country_details_FY19['export_sales_rs_FY20'][1].'</td>
				<td>'.$export_country_details_FY19['export_sales_dollar_FY20'][1].'</td>
				</tr>
				<tr>
				<td>'.$export_country_details_FY19['country_FY20'][2].'</td>
				<td>'.$export_country_details_FY19['export_sales_rs_FY20'][2].'</td>
				<td>'.$export_country_details_FY19['export_sales_dollar_FY20'][2].'</td>
				</tr>
				<tr>
				<td>'.$export_country_details_FY19['country_FY20'][3].'</td>
				<td>'.$export_country_details_FY19['export_sales_rs_FY20'][3].'</td>
				<td>'.$export_country_details_FY19['export_sales_dollar_FY20'][3].'</td>
				</tr>
				<tr>
				<td>'.$export_country_details_FY19['country_FY20'][4].'</td>
				<td>'.$export_country_details_FY19['export_sales_rs_FY20'][4].'</td>
				<td>'.$export_country_details_FY19['export_sales_dollar_FY20'][4].'</td>
				</tr>
				</tbody>
			</table>
	    </td>
    </tr>
    <tr>
        <td colspan="2">
        <p><strong> 3. Business Details and explanation related to financial details</strong></p>
        <p>'.$rows_best_growing['business_details_and_explanation'].'</p>
        <br>
        </td>
    </tr>
    <tr>
        <td colspan="2">
        <p><strong> 4. Strategic Exports Initiatives</strong></p>
        <p>'.$rows_best_growing['strategic_export_initiative'].'</p>
         <br>
        </td>
    </tr>
     <tr>
        <td colspan="2">
        <p><strong> 5. Case for Excellence</strong></p>
          <p>'.$rows_best_growing['key_insights'].'</p>
         <br>
        </td>
    </tr>
    <tr>
    <td align="center"  colspan="2" ><p style="color:blue;font-size:18px;">  Qualitative Information</p></td>
    </tr>
     <tr>
        <td colspan="2">
        <p><strong>1. Business details and explanation related to financial details</strong></p>
        <p></p>
         <br>
         <p><i>Kindly provide details of your business and the key products exported by your company? Please explain your financials with respect to reasons for major trends in parameters such as growth or decline in Turnover, growth or decline in Profits, etc. (Please be as descriptive as possible by attaching additional documents)</i></p>
        <p>'.$rows_qualitative['attatchment_details'].'</p>
         <br>

        </td>
    </tr>
     <tr>
        <td colspan="2">
        <p><strong>2. Strategic Exports Initiatives</strong></p>
        <i>Kindly provide details of the initiatives your company has taken for marketing or branding of the products in international market. Also provide companys vision for increasing the market reach of the product.</i>
        <p>'.$rows_qualitative['business_details_and_explanation'].'</p>
         <br>
         

        </td>
    </tr>
     <tr>
        <td colspan="2">
        <p><strong>3. Case for Excellence</strong></p>
        <i>Please provide key insights on your business which make your enterprise a strong contender for GJEPCs India Gem & Jewellery Awards 2019. Attach documents/literature, etc. to support the contention.</i>
        <p>'.$rows_qualitative['strategic_export_initiative'].'</p>
         <br>
         

        </td>
    </tr>
    <tr>
        <td colspan="2">
        <p><strong>4. Nominated Segment</strong></p>
        <i>Kindly provide any past details of the awards & accolades won by the company in the nominated segment</i>
         <p>'.$rows_qualitative['nominated_segment'].'</p>
         <br>
         

        </td>
    </tr>
     <tr>
        <td colspan="2">
        <p><strong>5. Mandatory</strong></p>
        <i>Has your company/firm/partner/director been convicted for any legal proceedings against them in any court of law with respect to Central excise/customs/FEMA/RBI, etc. in the last 10 years?</i>
        <p>'.$rows_qualitative['mandatory_details'].'</p>
         <br>
         

        </td>
    </tr>

     <tr>
    <td align="center"  colspan="2" ><p style="color:blue;font-size:18px;">  Innovative Company</p></td>
    </tr>
     <tr>
	    <td width="100%" colspan="2">
		    <table width="100%" border="1px" cellpadding="5px">
				<thead>
			    <tr>
				<th>R&D Activities (Rs Crore)</th>
				<th>FY2019-20</th>
				<th>FY2018-19</th>
				<th>FY2017-18</th>
				
				</tr>
				</thead>
				<tbody>
				<tr>
				
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities'][0].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY20'][0].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY19'][0].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY18'][0].'</td>
				
				</tr>
				<tr>
				
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities'][1].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY20'][1].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY19'][1].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY18'][1].'</td>
				
				</tr>
				<tr>
				
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities'][2].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY20'][2].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY19'][2].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY18'][2].'</td>
			
				<td></td>
				<td></td>
				</tr>
				<tr>
				
				<td>Total R&D Exp. Amount (Rs Crore)</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY20'][3].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY19'][3].'</td>
				<td>'.$amount_of_r_n_d_expenditure['r_n_d_activities_FY18'][3].'</td>
				
				<td></td>
				<td></td>
				</tr>
			
				</tbody>
			</table>
	    </td>
	   
    </tr>
     <tr>
        <td width="100%" colspan="2">
        <p><strong>Details of R&D activities</strong></p>
        
        <p>'.$rows_innovative['details_r_n_d_activities'].'</p>
         <br>
         

        </td>
    </tr>
  
     <tr>
        <td width="100%" colspan="2">
        <p><strong>2. Kindly provide details of the innovation activities undertaken by your company in the last 3 years (e.g. technology adoption, development of new product, innovation in marketing etc.)</strong></p>
        
       <p>'.$rows_innovative['innovation_activities_last_3_yr'].'</p>
         <br>
         

        </td>
    </tr>
     <tr>
        <td width="100%" colspan="2">
        <p><strong>3. Please explain how the innovation has impacted and helped the business of your company</strong></p>
        
        <p>'.$rows_innovative['how_impact_innovation'].'</p>
         <br>
         <br>
         

        </td>
    </tr>
    <tr>
        <td width="100%" colspan="2">
        <p><strong>4. Kindly provide details of any patents that have been registered for innovation by the organization</strong></p>
        
         <p>'.$rows_innovative['registered_patents_for_innovation'].'</p>
         <br>
         

        </td>
    </tr>

      <tr>
        <td width="100%" colspan="2">
        <p><strong>5. Kindly mention details of any awards and accolades won by your company in the past for innovations</strong></p>
        
        <p>'.$rows_innovative['award_and_accolades_won_details'].'</p>

        </td>
    </tr>
     <tr>    
    <td  colspan="2" ><br><br><br><br></td>
    </tr>
     <tr>
    <td align="center" colspan="2"><p style="color:blue;font-size:18px;">Best Digital Initiative</p></td>
    </tr>
     <tr>
       <td width="100%" colspan="2">
        <p><strong>1. In case of Initiative in sales through digital platform, please provide following details (Rs Crore)</strong></p>
        <i>Year of launch of Digital Platform for sales</i>

        
        <p>'.$rows_digital_initiative['year_of_launch'].'</p>
         <br>
         

        </td>
    </tr>
       <tr>
	    <td width="100%" colspan="2">
		    <table width="100%" border="1px" cellpadding="5px">
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
				<td>'.$turnover_through_digital_platform['total_turnover_FY20'].'</td>
				<td>'.$turnover_through_digital_platform['total_turnover_FY19'].'</td>
				<td>'.$turnover_through_digital_platform['total_turnover_FY18'].'</td>
				
				
				</tr>
				<tr>
				
				<td>Export Turnover through Digital Platform</td>
				<td>'.$turnover_through_digital_platform['export_turnover_FY20'].'</td>
				<td>'.$turnover_through_digital_platform['export_turnover_FY19'].'</td>
				<td>'.$turnover_through_digital_platform['export_turnover_FY18'].'</td>
				</tr>
				<tr>
				
				<td>% Share of Turnover through Digital Platform</td>
				<td>'.$turnover_through_digital_platform['share_of_turnover_FY20'].'</td>
				<td>'.$turnover_through_digital_platform['share_of_turnover_FY19'].'</td>
				<td>'.$turnover_through_digital_platform['share_of_turnover_FY18'].'</td>
				</tr>
				<tr>
				
				<td>No. of Clients using Digital Platform</td>
				<td>'.$turnover_through_digital_platform['no_of_clients_FY20'].'</td>
				<td>'.$turnover_through_digital_platform['no_of_clients_FY19'].'</td>
				<td>'.$turnover_through_digital_platform['no_of_clients_FY18'].'</td>
				</tr>
				
				</tbody>
			</table>
	    </td>
	   
    </tr>
     <tr>
        <td width="100%" colspan="2">
        <p><strong>2. In case of digital initiatives in other areas of excellence, please explain how the digital initiative in the selected area has impacted and helped the overall business of the company</strong></p>
       
         <br>
         

        </td>
    </tr>
           <tr>
	    <td width="100%" colspan="2">
		    <table width="100%" border="1px" cellpadding="5px">
				<thead>
			    <tr>
				<th>Areas of excellence</th>
				<th>Yes / No</th>
				<th>Initiatives</th>
				<th>Impact</th>
				
				</tr>
				</thead>
				<tbody>
				<tr>
				
				<td>'.$areas_of_excellence['area1'].'</td>
				<td>'.$areas_of_excellence['isArea1'].'</td>
				<td>'.$areas_of_excellence['initiatives1'].'</td>
				<td>'.$areas_of_excellence['impact1'].'</td>
			
				</tr>
				<tr>
				
				<td>'.$areas_of_excellence['area2'].'</td>
				<td>'.$areas_of_excellence['isArea2'].'</td>
				<td>'.$areas_of_excellence['initiatives2'].'</td>
				<td>'.$areas_of_excellence['impact2'].'</td>
				</tr>
				<tr>
				
				<td>'.$areas_of_excellence['area3'].'</td>
				<td>'.$areas_of_excellence['isArea3'].'</td>
				<td>'.$areas_of_excellence['initiatives3'].'</td>
				<td>'.$areas_of_excellence['impact3'].'</td>
				</tr>
				<tr>
				
				<td>'.$areas_of_excellence['area4'].'</td>
				<td>'.$areas_of_excellence['isArea4'].'</td>
				<td>'.$areas_of_excellence['initiatives4'].'</td>
				<td>'.$areas_of_excellence['impact4'].'</td>
				</tr>
                <tr>
				
				<td>'.$areas_of_excellence['area5'].'</td>
				<td>'.$areas_of_excellence['isArea5'].'</td>
				<td>'.$areas_of_excellence['initiatives5'].'</td>
				<td>'.$areas_of_excellence['impact5'].'</td>
				</tr>
				<tr>
				
				<td>'.$areas_of_excellence['area6'].'</td>
				<td>'.$areas_of_excellence['isArea6'].'</td>
				<td>'.$areas_of_excellence['initiatives6'].'</td>
				<td>'.$areas_of_excellence['impact6'].'</td>
				</tr>
				<tr>
				
				<td>'.$areas_of_excellence['area7'].'</td>
				<td>'.$areas_of_excellence['isArea7'].'</td>
				<td>'.$areas_of_excellence['initiatives7'].'</td>
				<td>'.$areas_of_excellence['impact7'].'</td>
				</tr>				
				</tbody>
			</table>
			<br>
	    </td>
	   
    </tr>
     <tr>    
    <td  colspan="2" ><br><br></td>
    </tr>
     <tr>
    <td align="center"  colspan="2" ><p style="color:blue;font-size:18px;">Socially Responsible Company</p></td>
    </tr>
      <tr>
        <td colspan="2">
        <p><strong>1. Please provide details of CSR activities undertaken your company</strong></p>
        
        <p>Amount of CSR Expenditure</p>
         <br>
         

        </td>
    </tr>
    <tr>
	    <td width="100%" colspan="2">
		    <table width="100%" border="1px" cellpadding="5px">
				<thead>
			    <tr>
				<th>CSR activities (Rs Crore)</th>
				<th>FY2019-20</th>
				<th>FY2018-19</th>
				<th>FY2017-18</th>
				
				</tr>
				</thead>
				<tbody>
				<tr>
				<td>Total CSR Exp. Amount</td>
				<td>'.$csr_activities['csr_exp_amount_FY20'].'</td>
				<td>'.$csr_activities['csr_exp_amount_FY19'].'</td>
				<td>'.$csr_activities['csr_exp_amount_FY18'].'</td>
				</tr>
				<tr>
				
				<td>Total CSR Exp. Amount spent directly</td>
				<td>'.$csr_activities['csr_exp_amount_spent_directly_FY20'].'</td>
				<td>'.$csr_activities['csr_exp_amount_spent_directly_FY19'].'</td>
				<td>'.$csr_activities['csr_exp_amount_spent_directly_FY18'].'</td>
				</tr>
				<tr>
				
				<td>Total CSR Exp. Amount through Trust/NGOs etc.</td>
				<td>'.$csr_activities['csr_exp_amount_through_trust_FY20'].'</td>
				<td>'.$csr_activities['csr_exp_amount_through_trust_FY19'].'</td>
				<td>'.$csr_activities['csr_exp_amount_through_trust_FY18'].'</td>
				</tr>
						
			   
				</tbody>
			</table>
	    </td>
	   
    </tr>
     <tr>
        <td width="100%" colspan="2">
        <p><strong>Details of CSR activities</strong></p>
        
       <td>'.$rows_socially_responsible['csr_details'].'</td>
         <br>
         

        </td>
    </tr>
     <tr>
        <td width="100%" colspan="2">
        <p><strong>2. Please provide details of any trusts/NGOs/such other related organizations that your company is associated with for CSR activities</strong></p>
        
        <td>'.$rows_socially_responsible['trust_ngo_details'].'</td>
         <br>
         

        </td>
    </tr>
    <tr>
	    <td width="100%" colspan="2">
		    <table width="100%" border="1px" cellpadding="5px">
				<thead>
			    <tr>
				<th>FY2019-20</th>
				<th>FY2018-19</th>
				<th>FY2017-18</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<td>'.$employee_details['no_of_employee_FY20'].'</td>
				<td>'.$employee_details['no_of_employee_FY19'].'</td>
				
				<td>'.$employee_details['no_of_employee_FY18'].'</td>
			
				
						
			   
				</tbody>
			</table>
	    </td>
	   
    </tr>
     <tr>
        <td colspan="2">
        <p><strong>4. Kindly mention details of any awards and accolades won by your company in the pastin the nominated category</strong></p>
        
        <p>'.$rows_socially_responsible['awards_accolades_details'].'</p>
         <br>
         

        </td>
    </tr>
     <tr>    
    <td  colspan="2" ><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
    </tr>
     <tr>
    <td align="center"  colspan="2" ><p style="color:blue;font-size:18px;">Woman Entrepreneur of the Year</p></td>
    </tr>
	<tr>
        <td colspan="2">
        <p><strong>1. Please provide Nominated Entrepreneur Details</strong></p>
        
	    </td>
	</tr>
	<tr>
        <td colspan="2">
        
        
        <p><strong>Name of the Nominated Entrepreneur</strong> : '.$rows_woman_entrepreneur['entrepreneur_name'].'</p>
	    <br>
	    <p><strong>No. of years in the management of current gems and jewellery business</strong> :'.$rows_woman_entrepreneur['no_of_years_in_business'].' </p>
	    <br>
	     <p><strong>Current Designation</strong> : '.$rows_woman_entrepreneur['current_designation'].' </p>
	    <br>
	    <p><strong>Details of any previous management of any business</strong> : '.$rows_woman_entrepreneur['prev_management_details'].' </p>
	    <br>

	    </td>
	</tr>
	<tr>
        <td colspan="2">
        <p><strong>2. Kindly provide the details of your initiatives taken by you for driving the growth of your gems and jewellery business</strong></p>
       <p> '.$rows_woman_entrepreneur['details_of_inititative_taken'].' </p>
        <br>
	    </td>
	</tr>
	<tr>
        <td colspan="2">
        <p><strong>3. Kindly provide details of your past engagements in the management of any businesses</strong></p>
        <p> '.$rows_woman_entrepreneur['details_of_past_engagements'].' </p>
        <br>
	    </td>
	</tr>
	<tr>
        <td colspan="2">
        <p><strong>4. Kindly provide details of your contribution to the Innovation actions of your company and/or for the development of the society</strong></p>
        <p> '.$rows_woman_entrepreneur['contribution_to_innovation'].' </p>
        <br>
	    </td>
	</tr>
	<tr>
        <td colspan="2">
        <p><strong>5. Kindly provide the details of awards and accolades won by you in the past as an entrepreneur</strong></p>
        <p> '.$rows_woman_entrepreneur['awards_accolades_details'].' </p>
        <br>
	    </td>
	</tr>


    <tr>
    	<td align="center"  colspan="2" ><p style="color:blue;font-size:18px;">Declaration</p></td>
    </tr>
    
    <tr>
        <td colspan="2">
        
        
        <p><strong>Name of the Respondent</strong> : '.$rows_declaration['respondant_name'].'  </p>
	 
	    <p><strong>Designation</strong> : '.$rows_declaration['designation'].' </p>
	 
	     <p><strong>Mobile</strong> : '.$rows_declaration['mobile'].' </p>
	 
	    <p><strong>Email Id</strong> : '.$rows_declaration['email_id'].'</p>
	 

	    </td>
	</tr>
	<tr>
        <p><strong>Chartered Accountant Declaration</strong></p>
    </tr>
    <tr>
        <td colspan="2">
        
        
        <p><strong>Name of the CA Firm</strong> : '.$rows_declaration['ca_firm_name'].' </p>
	 
	    <p><strong>Name of the individual</strong> : '.$rows_declaration['ca_name'].' </p>
	 
	     <p><strong>Designation</strong> : '.$rows_declaration['ca_designation'].' </p>
	 
	    <p><strong>Mobile</strong> : '.$rows_declaration['ca_mobile'].'</p>
	 
	    <p><strong>Email</strong> : '.$rows_declaration['ca_email'].' </p>
	 

	    </td>
	</tr>
	

</table>';


//echo $content;exit;
// create new PDF document
$pdf = new MYPDF($address, $reg_tel_no, $reg_email, $reg_fax, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mukesh Singh');
$pdf->SetTitle('IGJA AWARDS FORM');
$pdf->SetSubject('Application form details');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
//$pdf->setAddress('test');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetTopMargin(35);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);
// ---------------------------------------------------------
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 20);

// set some text to print
$txt = <<<EOD
$content
EOD;
// print a block of text using Write()

if($region_id=="HO-MUM (M)")
{
		
	$certificate = 'file://'.realpath('sslcertificate.crt');
	$info = array(
		'Name' => 'Mithilesh Pandey',
		'Location' => 'Mumbai',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'mithilesh@gjepcindia.com',
		);
	$signature = 'images/digital-sign-1.jpg';
}


// set document signature
//$pdf->setSignature($certificate, $certificate, 'kwebmaker', '', 2, $info);

$pdf->writeHTML($txt, true, false, true, false, '');

$pdf->Image($signature, 15, 165, 65, 14, 'JPG');

// define active area for signature appearance
$pdf->setSignatureAppearance(15, 165, 65, 13);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Igja-awards-'.$registration_id.'.pdf', 'D');

