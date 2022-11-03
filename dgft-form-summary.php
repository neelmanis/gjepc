<?php
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
$application_id = base64_decode($_REQUEST['id']) ;
$registration_id = intval(filter($_SESSION['USERID']));
    $cur_year = (int)date('y');
	$curyear  = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $curyear-1;
	 $cur_fin_yr1= $cur_year-1;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }  else {
     $cur_fin_yr = $curyear;
 	 $cur_fin_yr1= $cur_year;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }
?>
<?php
$sqlm = "SELECT * FROM `information_master` WHERE 1 and registration_id=$registration_id";
$ssx = $conn ->query($sqlm);
$rows = $ssx->fetch_assoc();

if($rows['company_name']=="")
{
	$sql="SELECT * FROM `registration_master` WHERE 1 and id='$registration_id'";
	$result = $conn ->query($sql);
	$rows1 = $result->fetch_assoc();
	
	$company_name	= strtoupper(filter($rows1['company_name']));
	$country	=	$rows1['country'];
	$land_line_no=$rows1['land_line_no'];
	$city= filter($rows1['city']);
	$mobile_no= filter($rows1['mobile_no']);
} else {
$company_name = strtoupper(filter($rows['company_name']));
$member_type_id = filter($rows['member_type_id']);
$type_of_firm = filter($rows['type_of_firm']);
$cin_no = filter($rows['cin_no']);
$pan_no = filter($rows['pan_no']);
$tan_no = filter($rows['tan_no']);
$iec_no = filter($rows['iec_no']);
$iec_issue_date=$rows['iec_issue_date'];
$im_registration_no=filter($rows['im_registration_no']);
$im_pin_code=filter($rows['im_pin_code']);
$ssi_registration_no=$rows['ssi_registration_no'];
$ssi_issue_date=$rows['ssi_issue_date'];
$ssi_pin_code=filter($rows['ssi_pin_code']);
$issuing_industrial_liecence=$rows['issuing_industrial_liecence'];
$authority=filter($rows['authority']);
$eh_th_certification_no=$rows['eh_th_certification_no'];
$eh_th_issue_date=$rows['eh_th_issue_date'];
$eh_th_valid_date=$rows['eh_th_valid_date'];
$region_id=strtoupper(filter($rows['region_id']));
$year_of_starting_bussiness=filter($rows['year_of_starting_bussiness']);
$name=strtoupper(filter($rows['name']));
$designation=$rows['designation'];
$email_id=filter($rows['email_id']);
$aadhar_no=$rows['aadhar_no'];
$passport_no=$rows['passport_no'];
$address1=strtoupper(filter($rows['address1']));
$address2=strtoupper(filter($rows['address2']));
$address3=strtoupper(filter($rows['address3']));
$pin_code=filter($rows['pin_code']);
$city=strtoupper(filter($rows['city']));
$country=$rows['country'];
$land_line_no=$rows['land_line_no'];
$mobile_no=$rows['mobile_no'];
$joining_date=$rows['joining_date'];
$retirement_date=$rows['retirement_date'];
$admin_aprove=$rows['admin_aprove'];
$status=$rows['status'];
$status_holder=$rows['status_holder'];
$status_holder_eh=$rows['status_holder_eh'];
$msme_ssi_status=$rows['msme_ssi_status'];
$vat_tin=$rows['vat_tin_reg_no'];
$uin=$rows['uin'];
$uin_issue_date=$rows['uin_issue_date'];
$co_profile=filter($rows['co_profile']);
$sight_holder=$rows['sight_holder'];
$sez_member=$rows['sez_member'];
$epc_fieo_status=$rows['epc_fieo_status'];
$org_name=strtoupper(filter($rows['org_name']));
}

$sqld = "SELECT * FROM `membership_dgft` WHERE 1 and registration_id=$registration_id and id=$application_id";
$queryd = $conn ->query($sqld);
$rowsd = $queryd->fetch_assoc();
$financial_year = filter($rowsd['financial_year']);
$dgft_ra_office = filter($rowsd['dgft_ra_office']);
$annual_turnover = filter($rowsd['annual_turnover']);
$financial_year1 = filter($rowsd['financial_year1']);
$financial_year2 = filter($rowsd['financial_year2']);
$financial_year3 = filter($rowsd['financial_year3']);
$financial_year1_export = filter($rowsd['financial_year1_export']);
$financial_year2_export = filter($rowsd['financial_year2_export']);
$financial_year3_export = filter($rowsd['financial_year3_export']);
$export_sub_total = filter($rowsd['export_sub_total']);
$deemed_export_total = filter($rowsd['deemed_export_total']);
$exports_total = filter($rowsd['exports_total']);
$exports_of_service = filter($rowsd['exports_of_service']);
$all_total_exports = filter($rowsd['all_total_exports']);
$rcmc_no = filter($rowsd['rcmc_no']);
$rcmc_issue_date = filter($rowsd['rcmc_issue_date']);
$rcmc_issue_authority = filter($rowsd['rcmc_issue_authority']);
$rcmc_product_of_which = filter($rowsd['rcmc_product_of_which']);
$rcmc_expiry = filter($rowsd['rcmc_expiry']);
$rcmc_status = filter($rowsd['rcmc_status']);
$rcmc_validity = filter($rowsd['rcmc_validity']);
$status_from_epc = filter($rowsd['status_from_epc']);
$export_sales_to_foreign_tourists = filter($rowsd['export_sales_to_foreign_tourists']);
$export_synthetic_stones = filter($rowsd['export_synthetic_stones']);
$export_costume_jewellery = filter($rowsd['export_costume_jewellery']);
$import_cif_value = filter($rowsd['import_cif_value']);
$export_other_precious_metal_jewellery = filter($rowsd['export_other_precious_metal_jewellery']);
$export_pearls = filter($rowsd['export_pearls']);
$export_coloured_gemstones = filter($rowsd['export_coloured_gemstones']);
$export_gold_jewellery = filter($rowsd['export_gold_jewellery']);
$export_studded_gold_jewellery = filter($rowsd['export_studded_gold_jewellery']);
$export_silver_jewellery = filter($rowsd['export_silver_jewellery']);
$export_studded_silver_jewellery = filter($rowsd['export_studded_silver_jewellery']);
$export_rough_diamonds = filter($rowsd['export_rough_diamonds']);
$export_cut_polished_diamonds = filter($rowsd['export_cut_polished_diamonds']);
$export_rough_lgd = filter($rowsd['export_rough_lgd']);
$export_cut_polished_lgd = filter($rowsd['export_cut_polished_lgd']);
$export_other_items = filter($rowsd['export_other_items']);
$export_total = filter($rowsd['export_total']);
$import_findings_mountings = filter($rowsd['import_findings_mountings']);
$import_false_pearls = filter($rowsd['import_false_pearls']);
$import_rough_imitation_stones = filter($rowsd['import_rough_imitation_stones']);
$import_silver = filter($rowsd['import_silver']);
$import_raw_pearls = filter($rowsd['import_raw_pearls']);
$import_cut_polished_gemstones = filter($rowsd['import_cut_polished_gemstones']);
$import_rough_gemstones = filter($rowsd['import_rough_gemstones']);
$import_gold = filter($rowsd['import_gold']);
$import_cut_polished_diamonds = filter($rowsd['import_cut_polished_diamonds']);
$import_rough_diamonds = filter($rowsd['import_rough_diamonds']);
$import_synthetic_stones = filter($rowsd['import_synthetic_stones']);
$import_gold_jewellery = filter($rowsd['import_gold_jewellery']);
$import_silver_jewellery = filter($rowsd['import_silver_jewellery']);
$import_rough_lgd = filter($rowsd['import_rough_lgd']);
$import_cut_polished_lgd = filter($rowsd['import_cut_polished_lgd']);
$import_other_items = filter($rowsd['import_other_items']);
$import_total = filter($rowsd['import_total']);
$export_fob_value = filter($rowsd['export_fob_value']);
$isDraft = filter($rowsd['export_fob_value']);
$action=$_REQUEST['action'];

if($action=="save")
{


   $sql1="update  membership_dgft set isDraft='0',status='Y' WHERE registration_id='$registration_id' and financial_year='$cur_fin_yr'" ;
   $saveResult = $conn ->query($sql1);
   $html = "";
   $html .='<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
				<tr>
		        <td colspan="2" style="background-color: #a89c5d; padding: 3px;"></td>
		      </tr>
				<tr>
	            <td colspan="2" align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png"></td>                        
		      </tr>
		      
							  <tr>
						  		<td colspan="2"><a href="https://gjepc.org/dgft-form.php">DGFT form link</a></td>
							  
							  </tr>
							  <tr>
						  		<td>Company Name</td>
							  	<td>'. $company_name.'</td>
							  </tr>
							  
							 
							   <tr>
						  		<td>IEC No.</td>
							  	<td>'. $iec_no.'</td>
							  </tr>
							   <tr>
						  		<td>PAN No.</td>
							  	<td>'. $pan_no.'</td>
							  </tr>
							  <tr>
						  		<td>CIN No.</td>
							  	<td>'. $cin_no.'</td>
							  </tr>
							   <tr>
						  		<td>TAN No.</td>
							  	<td>'. $tan_no.'</td>
							  </tr>
							   <tr>
						  		<td>IEC Issue Date.</td>
							  	<td>'. $iec_issue_date.'</td>
							  </tr>
							  <tr>
						  		<td>DGFT RA Office</td>
							  	<td>'. $dgft_ra_office.'</td>
							  </tr>
							   <tr>
						  		<td>Annual Turnover Of The Firm (Last FY Year)</td>
							  	<td>'. $annual_turnover.'</td>
							  </tr>
							   <tr>
						  		<td>Export Performance In '. $financial_year1.'</td>
							  	<td>'. $financial_year1_export.'</td>
							  </tr>
							  <tr>
						  		<td>Export Performance In '. $financial_year2.'</td>
							  	<td>'. $financial_year2_export.'</td>
							  </tr>
							  <tr>
						  		<td>Export Performance In '. $financial_year3.'</td>
							  	<td>'. $financial_year3_export.'</td>
							  </tr>

								<tr>
						  		<td>Sub-Total (Direct Exports + Third Party Exports )</td>
							  	<td>'. $export_sub_total.'</td>
							  </tr>				

								<tr>
						  		<td>Total Deemed Exports (Supplies to EOU/EHTP/BTP/STPI + Other Deemed Exports + Supplies to SEZ)</td>
							  	<td>'. $deemed_export_total.'</td>
							  </tr>				
							  <tr>
						  		<td>Total Exports (Sub-Total + Total Deemed Exports)</td>
							  	<td>'. $exports_total.'</td>
							  </tr>		
							  <tr>
						  		<td>Export of Service</td>
							  	<td>'. $exports_of_service.'</td>
							  </tr>		
							   <tr>
						  		<td>Total</td>
							  	<td>'. $all_total_exports.'</td>
							  </tr>		
							  <tr>
						  		<td>Status Holder</td>
							  	<td>'. $status_holder.'</td>
							  </tr>';
							  if ($status_holder =='Yes'){
							  $html.='<tr>
						  		<td>Status Holder Category</td>
							  	<td>'. $status_holder_eh.'</td>
							  </tr>
							 
							  <tr>
						  		<td>EH/TH/STH Certificate</td>
							  	<td>'. $eh_th_certification_no.'</td>
							  </tr>';
							    } 
							  $html.='<tr>
						  		<td>Valid Upto :</td>
							  	<td>'. $eh_th_valid_date.'</td>
							  </tr>
							  <tr>
						  		<td>IM Registration No. :</td>
							  	<td>'. $im_registration_no.'</td>
							  </tr>		
							   <tr>
						  		<td>IM Pin Code :</td>
							  	<td>'. $im_pin_code.'</td>
							  </tr>		
							  <tr>
						  		<td>IISSUING INDUSTRIAL LINCENCES/IEM  :</td>
							  	<td>'. $issuing_industrial_liecence.'</td>
							  </tr>	
							  <tr>
						  		<td>Authority :</td>
							  	<td>'. $authority.'</td>
							  </tr>		
							  <tr>
						  		<td>Date of Issue :</td>
							  	<td>'. $eh_th_issue_date.'</td>
							  </tr>							
							</table>
					</div>
					
					
					
                    
					
					
        
				
					
			
				
				

					<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Firm Address Details</strong> </p>	
					</div>';
					
					
					
					

		
	   	$query = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and type_of_address='2'");
	   	if(	$query ->num_rows > 0){
	   		while($result= $query->fetch_assoc()){ 
	   			$html .='<div class="col-12 form-group">
						<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
							 
							   <tr>
						  		<td>Address Type.</td>
							  	<td>'. getaddresstype($result['type_of_address'],$conn).'</td>
							  </tr>
							   <tr>
						  		<td>Address Line 1.</td>
							  	<td>'.  $result['address1'].'</td>
							  </tr>
							   <tr>
						  		<td>Address Line 2.</td>
							  	<td>'.  $result['address2'].'</td>
							  </tr>
							  <tr>
						  		<td>City .</td>
							  	<td>'.  $result['city'].'</td>
							  </tr>
							  <tr>
						  		<td>State .</td>
							  	<td>'.  $result['state'].'</td>
							  </tr>
							  <tr>
						  		<td>Pincode .</td>
							  	<td>'.  $result['pincode'].'</td>
							  </tr>
													
							</table>
					</div>';
	   				
			
		
		 } } 	

			$html.='<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>RCMC Details</strong> </p>	
					</div>
					<div class="col-12 form-group">
						<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
							 
							   <tr>
						  		<td>RCMC No.</td>
							  	<td>'. $rcmc_no.'</td>
							  </tr>
							   <tr>
						  		<td>Issue Date.</td>
							  	<td>'.  $rcmc_issue_date.'</td>
							  </tr>
							  <tr>
						  		<td>Issue Authority.</td>
							  	<td>'.  $rcmc_issue_authority.'</td>
							  </tr>
							  <tr>
						  		<td>Product Of Which Registered .</td>
							  	<td>'.  $rcmc_product_of_which.'</td>
							  </tr>
							   <tr>
						  		<td>Expiry Date .</td>
							  	<td>'.  $rcmc_expiry.'</td>
							  </tr>
							  <tr>
						  		<td>RCMC Status .</td>
							  	<td>'.  $rcmc_status.'</td>
							  </tr>
							   <tr>
						  		<td>Validity Period  .</td>
							  	<td>'.  $rcmc_validity.'</td>
							  </tr>
							   <tr>
						  		<td>Status From EPC  .</td>
							  	<td>'.  $status_from_epc.'</td>
							  </tr>
							  
													
							</table>
					</div>
  					
                      
                     
                       	<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Branch Details</strong> </p>	
						</div>';
					
							$query_branch_office = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and type_of_address='3'");
							
							if($query_branch_office->num_rows  > 0){ 

                             $result_branch_office = $query_branch_office ->fetch_assoc();
							
							}
						
						$html .=	'<div class="col-12 form-group">
						<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
							  <tr>
						  		<td>Branch Code</td>
							  	<td>'.  $result_branch_office['gcode'].'</td>
							  </tr>
							   <tr>
						  		<td>GSTIN.</td>
							  	<td>'.  $result_branch_office['gst_no'].'</td>
							  </tr>

							   <tr>
						  		<td>Is EOU.</td>
							  	<td>'.  $result_branch_office['is_eou'].'</td>
							  </tr>
							   <tr>
						  		<td>Is sez.</td>
							  	<td>'.  $result_branch_office['is_sez'].'</td>
							  </tr>
							  
							   <tr>
						  		<td>Address Line 1.</td>
							  	<td>'.  $result_branch_office['address1'].'</td>
							  </tr>
							   <tr>
						  		<td>Address Line 2.</td>
							  	<td>'.  $result_branch_office['address2'].'</td>
							  </tr>
							  <tr>
						  		<td>City .</td>
							  	<td>'.  $result_branch_office['city'].'</td>
							  </tr>
							  <tr>
						  		<td>State .</td>
							  	<td>'.  getState($result_branch_office['state'],$conn).'</td>
							  </tr>
							  <tr>
						  		<td>Pincode .</td>
							  	<td>'.  $result_branch_office['pincode'].'</td>
							  </tr>
													
							</table>
					</div>
			
					
                       	
            <div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Industrial Registration Details</strong> </p>	
						</div>

						<div class="col-12 form-group">
						<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
							  <tr>
						  		<td>MSME/SSI</td>
							  	<td>'.$msme_ssi_status.'</td>
							  </tr>';
							  

							if($msme_ssi_status !='No'){
							$html .=	'<tr>
						  		<td>UAM/MSME/UDHYAM REGISTRATION No</td>
							  	<td>'.  $ssi_registration_no.'</td>
							  </tr>
							  <tr>
						  		<td>DATE OF ISSUE OF UAM/MSME/UDYAM </td>
							  	<td>'.  $ssi_issue_date.'</td>
							  </tr>
							  <tr>
						  		<td>UAM/MSME/UDHYAM Pin Code </td>
							  	<td>'.  $ssi_pin_code.'</td>
							  </tr>
							  <tr>
						  		<td>Authority </td>
							  	<td>'.  $authority.'</td>
							  </tr>';
							  } 
							  
													
							$html .='</table>
					</div>

						<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Details of Proprietor/Partner/Director/Karta/Managing Trustee </strong> </p>	
						</div>	';	
                        
                      
     
	   	$query_proprietor = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and (type_of_address='1' OR type_of_address='5' OR type_of_address='7'   )");
	   	if(	$query_proprietor ->num_rows > 0){
	   		while($result_proprietor= $query_proprietor->fetch_assoc()){ 
	   			$html .='<div class="col-12">
	   				<div class="row">
	   				<div class="col-12">
							<p style="border-bottom:1px dashed #a89c5d; margin-top:15px"><strong>'. getaddresstype($result_proprietor['type_of_address'],$conn).'</strong> </p>	
						</div>
	   					<div class="col-12 form-group">
						<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
							  
							  
							
							   <tr>
						  		<td>Name.</td>
							  	<td>'.  $result_proprietor['name'].'</td>
							  </tr>
							  <tr>
						  		<td>DIN No</td>
							  	<td>'.  $result_proprietor['din'].'</td>
							  </tr>
							  <tr>
						  		<td>Is the Director a Foreign National?</td>
							  	<td>'. $result_proprietor['isForeignNational1'].'</td>
							  </tr>
							   <tr>
						  		<td>Address Line 1.</td>
							  	<td>'.  $result_proprietor['address1'].'</td>
							  </tr>
							  <tr>
						  		<td>Address Line 2.</td>
							  	<td>'.  $result_proprietor['address2'].'</td>
							  </tr>
							  <tr>
						  		<td>City .</td>
							  	<td>'.  $result_proprietor['city'].'</td>
							  </tr>
							  <tr>
						  		<td>State .</td>
							  	<td>'.  getState($result_proprietor['state'],$conn).'</td>
							  </tr>
							  <tr>
						  		<td>Pincode .</td>
							  	<td>'.  $result_proprietor['pincode'].'</td>
							  </tr>
													
							</table>
					</div>
					
	   				
	   				</div>
	   			</div>';
   						
	   				
		
			
		
	 }
	}
		
		
		 	$html .='<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Other Details (Preferred sectors of operations)</strong> </p>	
						</div>	
						<div class="col-12 mb-2">
							<strong>Exports List</strong>
						</div>	
			 <div class="col-12 form-group">
						<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
							  
							  
							   <tr>
						  		<td>Coloured Gemstones</td>
							  	<td>'. $export_coloured_gemstones.'</td>
							  </tr>
							  <tr>
						  		<td>Costume/Fashion Jewellery</td>
							  	<td>'. $export_costume_jewellery.'</td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Diamonds</td>
							  	<td>'. $export_cut_polished_diamonds.'</td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Diamonds</td>
							  	<td>'. $export_gold_jewellery.'</td>
							  </tr>
							  <tr>
						  		<td>Studded Gold Jewellery</td>
							  	<td>'. $export_studded_gold_jewellery.'</td>
							  </tr>

									<tr>
						  		<td>Plain Silver Jewellery </td>
							  	<td>'. $export_silver_jewellery.'</td>
							  </tr>
							  <tr>
						  		<td>Studded Silver Jewellery </td>
							  	<td>'. $export_studded_silver_jewellery.'</td>
							  </tr>
							   <tr>
						  		<td>Other Precious Metal Jewellery</td>
							  	<td>'. $export_other_precious_metal_jewellery.'</td>
							  </tr>
							   <tr>
						  		<td>Pearls</td>
							  	<td>'. $export_pearls.'</td>
							  </tr>
							   <tr>
						  		<td>Rough Diamonds</td>
							  	<td>'. $export_rough_diamonds.'</td>
							  </tr>
							   <tr>
						  		<td>Sales to Foreign Tourists</td>
							  	<td>'. $export_sales_to_foreign_tourists.'</td>
							  </tr>
							    <tr>
						  		<td>Synthetic Stones </td>
							  	<td>'. $export_synthetic_stones.'</td>
							  </tr>
							  <tr>
						  		<td>Rough Lab Grown Diamond </td>
							  	<td>'. $export_rough_lgd.'</td>
							  </tr>
							   <tr>
						  		<td>Cut & Polished Lab Grown Diamond </td>
							  	<td>'. $export_cut_polished_lgd.'</td>
							  </tr>
							  <tr>
						  		<td>Other Items </td>
							  	<td>'. $export_other_items.'</td>
							  </tr>
							  <tr>
						  		<td>Total </td>
							  	<td>'. $export_total.'</td>
							  </tr>
							  
							  
													
							</table>
					</div>
            
			<div class="col-12 mb-2">
							<strong>Import List</strong>
						</div>	
			 <div class="col-12 form-group">
						<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
							  
							  
							   <tr>
						  		<td>Cut & Polished Diamonds</td>
							  	<td>'. $import_cut_polished_diamonds.'</td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Gemstones </td>
							  	<td>'. $import_cut_polished_gemstones.'</td>
							  </tr>
							  <tr>
						  		<td>Processed & Finished Pearls</td>
							  	<td>'. $import_false_pearls.'</td>
							  </tr>

							  <tr>
						  		<td>Findings & Mountings </td>
							  	<td>'. $import_findings_mountings.'</td>
							  </tr>
							  <tr>
						  		<td>Gold Bar</td>
							  	<td>'. $import_gold.'</td>
							  </tr>

									<tr>
						  		<td>Raw Pearls  </td>
							  	<td>'. $import_raw_pearls.'</td>
							  </tr>

							   
							   <tr>
						  		<td>Rough Diamonds</td>
							  	<td>'. $import_rough_diamonds.'</td>
							  </tr>
							   <tr>
						  		<td>Rough Gemstones</td>
							  	<td>'. $import_rough_gemstones.'</td>
							  </tr>

							    <tr>
						  		<td>Rough Imitation Stones, Glass Beads/ Glass Chattons </td>
							  	<td>'. $import_rough_imitation_stones.'</td>
							  </tr>


							  <tr>
						  		<td>Synthetic stones </td>
							  	<td>'. $import_synthetic_stones.'</td>
							  </tr>

							   <tr>
						  		<td>Gold Jewellery </td>
							  	<td>'. $import_gold_jewellery.'</td>
							  </tr>

							  <tr>
						  		<td>Silver Jewellery  </td>
							  	<td>'. $import_silver_jewellery.'</td>
							  </tr>
							  <tr>
						  		<td>Rough Lab Grown Diamond  </td>
							  	<td>'. $import_rough_lgd.'</td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Lab Grown Diamond </td>
							  	<td>'. $import_cut_polished_lgd.'</td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Lab Grown Diamond </td>
							  	<td>'. $import_cut_polished_lgd.'</td>
							  </tr>
							   <tr>
						  		<td>Other Items </td>
							  	<td>'. $import_other_items.'</td>
							  </tr>
							   <tr>
						  		<td>Total </td>
							  	<td>'. $import_total.'</td>
							  </tr>
							  <tr>
						  		<td>F.O.B value of exports  </td>
							  	<td>'. $export_fob_value.'</td>
							  </tr>
							  <tr>
						  		<td>C.I.F value of imports  </td>
							  	<td>'. $import_cif_value.'</td>
							  </tr>
							  
							  
													
							</table>';
	 $message = $html;
	 $to_email_id = "santosh@kwebmaker.com";	
	 //$to_email_id = getUserEmail($registration_id,$conn);
    $cc = "";
	 $subject = "Membership DGFT Form"; 
	 send_mail($to_email_id, $subject, $message,$cc);	
	// mail($to, $subject, $message, $headers);

if(!$saveResult) die ($conn->error);
$_SESSION['succ_msg']="Information saved successfully";
header('location:dgft-form.php'); exit;
}




?>


<section class="py-5">
	<div class="container inner_container">
    	
        <h1 class="bold_font text-center mb-5"><img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> Membership DGFT Form</h1>
       
		<div class="row">        	
   
            
            <div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
		</div>
         
    		<div class="col-lg col-md-12 ">
    		    
    		    <div class="row justify-content-around">
    		    	
    		    </div>
    			<a onClick="PrintContent();" class="input_bg cta fade_anim text-right mb-3 d-inline-block" target="_blank" style="cursor:pointer;color: #fff;font-size:13px;">Print</a>
    	
				<p class="gold_clr mb-4 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong> Account Information </strong> </p>				
				<?php 
                if($_SESSION['succ_msg']!=""){
                echo "<div class='alert alert-success' role='alert'>".$_SESSION['succ_msg']."</div>";
                $_SESSION['succ_msg']="";
                }
                
                ?>

			 
			
<div id="divtoprint">
				<form class="cmxform row" method="POST" name="infoForm" id="infoForm">

					<div class="col-12 form-group">
						<table class="table responsive_table portal_table summary_table table-light ">
							  <tr>
						  		<td>Company Name</td>
							  	<td><?php echo $company_name;?></td>
							  </tr>
							   <tr>
						  		<td>Member Type</td>
							  	<td> <select class="form-control" name="member_type_id" id="member_type_id">
                                <option value="">--- Select Member Type ---</option>
                                  <?php
                                  $sql1="SELECT * FROM `member_type_master` WHERE 1 and `status`=1";
                                  $result1 = $conn->query($sql1);
                                  while($rows1 = $result1->fetch_assoc())
                                  {
                                  if($rows1['sap_value']==$member_type_id)
                                  {
                                  echo "<option selected='selected' value='$rows1[sap_value]'>$rows1[member_type_name]</option>";
                                  } else {
                                  echo "<option value='$rows1[sap_value]'>$rows1[member_type_name]</option>";
                                  }
                                  }
                                  ?>
                        </select></td>
							  	</tr>
							   <tr>
						  		<td>NATURE OF CONCERN / FIRM</td>
							  	<td><select class="form-control" name="type_of_firm" id="type_of_firm">
                                <option value="">--- Select Type of Firm ---</option>
                                      <?php
                                      $sql2="SELECT * FROM `type_of_firm_master` WHERE 1 and `status`=1";
                                      $result2 = $conn->query($sql2);
									  while($rows2 = $result2->fetch_assoc())
                                      {
                                      if($rows2['sap_value']==$type_of_firm)
                                      {
                                      echo "<option selected='selected' value='$rows2[sap_value]'>$rows2[type_of_firm_name]</option>";
                                      } else  {
                                      echo "<option value='$rows2[sap_value]'>$rows2[type_of_firm_name]</option>";
                                      }
                                      }
                                      ?>
                        </select></td>
							  </tr>
							   <tr>
						  		<td>IEC No.</td>
							  	<td><?php echo $iec_no;?></td>
							  </tr>
							   <tr>
						  		<td>PAN No.</td>
							  	<td><?php echo $pan_no; ?></td>
							  </tr>
							  <tr>
						  		<td>CIN No.</td>
							  	<td><?php echo $cin_no;?></td>
							  </tr>
							   <tr>
						  		<td>TAN No.</td>
							  	<td><?php echo $tan_no;?></td>
							  </tr>
							   <tr>
						  		<td>IEC Issue Date.</td>
							  	<td><?php echo $iec_issue_date;?></td>
							  </tr>
							  <tr>
						  		<td>DGFT RA Office</td>
							  	<td><?php echo $dgft_ra_office;?></td>
							  </tr>
							   <tr>
						  		<td>Annual Turnover Of The Firm (Last FY Year)</td>
							  	<td><?php echo $annual_turnover;?></td>
							  </tr>
							   <tr>
						  		<td>Export Performance In <?php echo $financial_year1;?></td>
							  	<td><?php echo $financial_year1_export;?></td>
							  </tr>
							  <tr>
						  		<td>Export Performance In <?php echo $financial_year2;?></td>
							  	<td><?php echo $financial_year2_export;?></td>
							  </tr>
							  <tr>
						  		<td>Export Performance In <?php echo $financial_year3;?></td>
							  	<td><?php echo $financial_year3_export;?></td>
							  </tr>

								<tr>
						  		<td>Sub-Total (Direct Exports + Third Party Exports )</td>
							  	<td><?php echo $export_sub_total; ?></td>
							  </tr>				

								<tr>
						  		<td>Total Deemed Exports (Supplies to EOU/EHTP/BTP/STPI + Other Deemed Exports + Supplies to SEZ)</td>
							  	<td><?php echo $deemed_export_total; ?></td>
							  </tr>				
							  <tr>
						  		<td>Total Exports (Sub-Total + Total Deemed Exports)</td>
							  	<td><?php echo $exports_total; ?></td>
							  </tr>		
							  <tr>
						  		<td>Export of Service</td>
							  	<td><?php echo $exports_of_service; ?></td>
							  </tr>		
							   <tr>
						  		<td>Total</td>
							  	<td><?php echo $all_total_exports; ?></td>
							  </tr>		
							  <tr>
						  		<td>Status Holder</td>
							  	<td><?php echo $status_holder; ?></td>
							  </tr>	
							  <tr>
						  		<td>Status Holder</td>
							  	<td><?php echo $status_holder; ?></td>
							  </tr>
							  <?php if ($status_holder =='Yes'){?>
							  	 <tr>
						  		<td>Status Holder Category</td>
							  	<td><?php echo $status_holder_eh; ?></td>
							  </tr>
							  <tr>
						  		<td>EH/TH/STH Certificate</td>
							  	<td><?php echo $eh_th_certification_no; ?></td>
							  </tr>
							  
							  <?php  } ?>
							  <tr>
						  		<td>Valid Upto :</td>
							  	<td><?php echo $eh_th_valid_date; ?></td>
							  </tr>
							  <tr>
						  		<td>IM Registration No. :</td>
							  	<td><?php echo $im_registration_no; ?></td>
							  </tr>		
							   <tr>
						  		<td>IM Pin Code :</td>
							  	<td><?php echo $im_pin_code; ?></td>
							  </tr>		
							  <tr>
						  		<td>IISSUING INDUSTRIAL LINCENCES/IEM  :</td>
							  	<td><?php echo $issuing_industrial_liecence; ?></td>
							  </tr>	
							  <tr>
						  		<td>Authority :</td>
							  	<td><?php echo $authority; ?></td>
							  </tr>		
							  <tr>
						  		<td>Date of Issue :</td>
							  	<td><?php echo $eh_th_issue_date; ?></td>
							  </tr>							
							</table>
					</div>
					
					
					
                    
					
					
        
				
					
			
				
				

					<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Firm Address Details</strong> </p>	
					</div>
					
					
					
					

		<?php 
	   	$query = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and type_of_address='2'");
	   	if(	$query ->num_rows > 0){
	   		while($result= $query->fetch_assoc()){ ?>
	   			<div class="col-12 form-group">
						<table class="table responsive_table portal_table summary_table table-light ">
							 
							   <tr>
						  		<td>Address Type.</td>
							  	<td><?php echo getaddresstype($result['type_of_address'],$conn);?></td>
							  </tr>
							   <tr>
						  		<td>Address Line 1.</td>
							  	<td><?php echo  $result['address1'];?></td>
							  </tr>
							   <tr>
						  		<td>Address Line 2.</td>
							  	<td><?php echo  $result['address2'];?></td>
							  </tr>
							  <tr>
						  		<td>City .</td>
							  	<td><?php echo  $result['city'];?></td>
							  </tr>
							  <tr>
						  		<td>State .</td>
							  	<td><?php echo  $result['state'];?></td>
							  </tr>
							  <tr>
						  		<td>Pincode .</td>
							  	<td><?php echo  $result['pincode'];?></td>
							  </tr>
													
							</table>
					</div>
	   				
			
		
		<?php } } ?>		
		

			

					<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>RCMC Details</strong> </p>	
					</div>
					<div class="col-12 form-group">
						<table class="table responsive_table portal_table summary_table table-light ">
							 
							   <tr>
						  		<td>RCMC No.</td>
							  	<td><?php echo $rcmc_no;?></td>
							  </tr>
							   <tr>
						  		<td>Issue Date.</td>
							  	<td><?php echo  $rcmc_issue_date;?></td>
							  </tr>
							  <tr>
						  		<td>Issue Authority.</td>
							  	<td><?php echo  $rcmc_issue_authority;?></td>
							  </tr>
							  <tr>
						  		<td>Product Of Which Registered .</td>
							  	<td><?php echo  $rcmc_product_of_which;?></td>
							  </tr>
							   <tr>
						  		<td>Expiry Date .</td>
							  	<td><?php echo  $rcmc_expiry;?></td>
							  </tr>
							  <tr>
						  		<td>RCMC Status .</td>
							  	<td><?php echo  $rcmc_status;?></td>
							  </tr>
							   <tr>
						  		<td>Validity Period  .</td>
							  	<td><?php echo  $rcmc_validity;?></td>
							  </tr>
							   <tr>
						  		<td>Status From EPC  .</td>
							  	<td><?php echo  $status_from_epc;?></td>
							  </tr>
							  
													
							</table>
					</div>
  					
                      
                     
                       	<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Branch Details</strong> </p>	
						</div>
						<?php 
							$query_branch_office = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and type_of_address='3'");
							
							if($query_branch_office->num_rows  > 0){ 

                             $result_branch_office = $query_branch_office ->fetch_assoc();
							
							}else{ ?>
								<a href="https://gjepc.org/communication_form.php" class="cta " target="_blank">Click here to add/update address</a>
									<label  for="branch_error" ><?php if($signup_error['label'] =="branch_error"){ echo $signup_error['message'];  }?></label>
							<?php }
							?>
							<div class="col-12 form-group">
						<table class="table responsive_table portal_table summary_table table-light ">
							  <tr>
						  		<td>Branch Code</td>
							  	<td><?php echo  $result_branch_office['gcode'];?></td>
							  </tr>
							   <tr>
						  		<td>GSTIN.</td>
							  	<td><?php echo  $result_branch_office['gst_no'];?></td>
							  </tr>

							   <tr>
						  		<td>Is EOU.</td>
							  	<td><?php echo  $result_branch_office['is_eou'];?></td>
							  </tr>
							   <tr>
						  		<td>Is sez.</td>
							  	<td><?php echo  $result_branch_office['is_sez'];?></td>
							  </tr>
							  
							   <tr>
						  		<td>Address Line 1.</td>
							  	<td><?php echo  $result_branch_office['address1'];?></td>
							  </tr>
							   <tr>
						  		<td>Address Line 2.</td>
							  	<td><?php echo  $result_branch_office['address2'];?></td>
							  </tr>
							  <tr>
						  		<td>City .</td>
							  	<td><?php echo  $result_branch_office['city'];?></td>
							  </tr>
							  <tr>
						  		<td>State .</td>
							  	<td><?php echo  getState($result_branch_office['state'],$conn);?></td>
							  </tr>
							  <tr>
						  		<td>Pincode .</td>
							  	<td><?php echo  $result_branch_office['pincode'];?></td>
							  </tr>
													
							</table>
					</div>
			
					
                       	
            <div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Industrial Registration Details</strong> </p>	
						</div>

						<div class="col-12 form-group">
						<table class="table responsive_table portal_table summary_table table-light ">
							  <tr>
						  		<td>MSME/SSI</td>
							  	<td><?php  if($msme_ssi_status !=="No"){ echo "Yes"; }else{ echo "No"; } ?></td>
							  </tr>
							  

							  <?php if($msme_ssi_status !='No'){?>
								<tr>
						  		<td>UAM/MSME/UDHYAM REGISTRATION No</td>
							  	<td><?php echo  $ssi_registration_no;?></td>
							  </tr>
							  <tr>
						  		<td>DATE OF ISSUE OF UAM/MSME/UDYAM </td>
							  	<td><?php echo  $ssi_issue_date;?></td>
							  </tr>
							  <tr>
						  		<td>UAM/MSME/UDHYAM Pin Code </td>
							  	<td><?php echo  $ssi_pin_code;?></td>
							  </tr>
							  <tr>
						  		<td>Authority </td>
							  	<td><?php echo  $authority;?></td>
							  </tr>
							  <?php } ?>
							  
													
							</table>
					</div>
						                    
                        
                        
					
						
						
              
                    
                     
				
                      
						<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Details of Proprietor/Partner/Director/Karta/Managing Trustee </strong> </p>	
						</div>		
                        
                      
      <?php 
	   	$query_proprietor = $conn ->query("select * from communication_address_master where registration_id='".$_SESSION['USERID']."' and (type_of_address='1' OR type_of_address='5' OR type_of_address='7'   )");
	   	if(	$query_proprietor ->num_rows > 0){
	   		while($result_proprietor= $query_proprietor->fetch_assoc()){ ?>
	   			<div class="col-12">
	   				<div class="row">
	   					<div class="col-12 form-group">
						<table class="table responsive_table portal_table summary_table table-light ">
							  
							  
							   <tr>
						  		<td>Address Type.</td>
							  	<td><?php echo getaddresstype($result_proprietor['type_of_address'],$conn);?></td>
							  </tr>
							   <tr>
						  		<td>Name.</td>
							  	<td><?php echo  $result_proprietor['name'];?></td>
							  </tr>
							  <tr>
						  		<td>DIN No</td>
							  	<td><?php echo  $result_proprietor['din'];?></td>
							  </tr>
							  <tr>
						  		<td>Is the Director a Foreign National?</td>
							  	<td><?php echo $result_proprietor['isForeignNational1']; ?></td>
							  </tr>
							   <tr>
						  		<td>Address Line 1.</td>
							  	<td><?php echo  $result_proprietor['address1'];?></td>
							  </tr>
							  <tr>
						  		<td>Address Line 2.</td>
							  	<td><?php echo  $result_proprietor['address2'];?></td>
							  </tr>
							  <tr>
						  		<td>City .</td>
							  	<td><?php echo  $result_proprietor['city'];?></td>
							  </tr>
							  <tr>
						  		<td>State .</td>
							  	<td><?php echo  getState($result_proprietor['state'],$conn);?></td>
							  </tr>
							  <tr>
						  		<td>Pincode .</td>
							  	<td><?php echo  $result_proprietor['pincode'];?></td>
							  </tr>
													
							</table>
					</div>
	   				
	   				</div>
	   			</div>
   						
	   				
		
			
		
		<?php }
	}else{ ?>
<a href="https://gjepc.org/communication_form.php" class="cta " target="_blank">Click here to add/update address</a>
	<?php }
		 ?>
		
		 	<div class="col-12">
							<p class="gold_clr mb-3 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong>Other Details (Preferred sectors of operations)</strong> </p>	
						</div>	
						<div class="col-12 mb-2">
							<strong>Exports List</strong>
						</div>	
			 <div class="col-12 form-group">
						<table class="table responsive_table portal_table summary_table table-light ">
							  
							  
							   <tr>
						  		<td>Coloured Gemstones</td>
							  	<td><?php echo $export_coloured_gemstones;?></td>
							  </tr>
							  <tr>
						  		<td>Costume/Fashion Jewellery</td>
							  	<td><?php echo $export_costume_jewellery;?></td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Diamonds</td>
							  	<td><?php echo $export_cut_polished_diamonds;?></td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Diamonds</td>
							  	<td><?php echo $export_gold_jewellery;?></td>
							  </tr>
							  <tr>
						  		<td>Studded Gold Jewellery</td>
							  	<td><?php echo $export_studded_gold_jewellery;?></td>
							  </tr>

									<tr>
						  		<td>Plain Silver Jewellery </td>
							  	<td><?php echo $export_silver_jewellery;?></td>
							  </tr>
							  <tr>
						  		<td>Studded Silver Jewellery </td>
							  	<td><?php echo $export_studded_silver_jewellery;?></td>
							  </tr>
							   <tr>
						  		<td>Other Precious Metal Jewellery</td>
							  	<td><?php echo $export_other_precious_metal_jewellery;?></td>
							  </tr>
							   <tr>
						  		<td>Pearls</td>
							  	<td><?php echo $export_pearls;?></td>
							  </tr>
							   <tr>
						  		<td>Rough Diamonds</td>
							  	<td><?php echo $export_rough_diamonds;?></td>
							  </tr>
							   <tr>
						  		<td>Sales to Foreign Tourists</td>
							  	<td><?php echo $export_sales_to_foreign_tourists;?></td>
							  </tr>
							    <tr>
						  		<td>Synthetic Stones </td>
							  	<td><?php echo $export_synthetic_stones;?></td>
							  </tr>
							  <tr>
						  		<td>Rough Lab Grown Diamond </td>
							  	<td><?php echo $export_rough_lgd;?></td>
							  </tr>
							   <tr>
						  		<td>Cut & Polished Lab Grown Diamond </td>
							  	<td><?php echo $export_cut_polished_lgd;?></td>
							  </tr>
							  <tr>
						  		<td>Other Items </td>
							  	<td><?php echo $export_other_items;?></td>
							  </tr>
							  <tr>
						  		<td>Total </td>
							  	<td><?php echo $export_total;?></td>
							  </tr>
							  
							  
													
							</table>
					</div>
            
			<div class="col-12 mb-2">
							<strong>Import List</strong>
						</div>	
			 <div class="col-12 form-group">
						<table class="table responsive_table portal_table summary_table table-light ">
							  
							  
							   <tr>
						  		<td>Cut & Polished Diamonds</td>
							  	<td><?php echo $import_cut_polished_diamonds;?></td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Gemstones </td>
							  	<td><?php echo $import_cut_polished_gemstones;?></td>
							  </tr>
							  <tr>
						  		<td>Processed & Finished Pearls</td>
							  	<td><?php echo $import_false_pearls;?></td>
							  </tr>

							  <tr>
						  		<td>Findings & Mountings </td>
							  	<td><?php echo $import_findings_mountings;?></td>
							  </tr>
							  <tr>
						  		<td>Gold Bar</td>
							  	<td><?php echo $import_gold;?></td>
							  </tr>

									<tr>
						  		<td>Raw Pearls  </td>
							  	<td><?php echo $import_raw_pearls;?></td>
							  </tr>

							   
							   <tr>
						  		<td>Rough Diamonds</td>
							  	<td><?php echo $import_rough_diamonds;?></td>
							  </tr>
							   <tr>
						  		<td>Rough Gemstones</td>
							  	<td><?php echo $import_rough_gemstones;?></td>
							  </tr>

							    <tr>
						  		<td>Rough Imitation Stones, Glass Beads/ Glass Chattons </td>
							  	<td><?php echo $import_rough_imitation_stones;?></td>
							  </tr>


							  <tr>
						  		<td>Synthetic stones </td>
							  	<td><?php echo $import_synthetic_stones;?></td>
							  </tr>

							   <tr>
						  		<td>Gold Jewellery </td>
							  	<td><?php echo $import_gold_jewellery;?></td>
							  </tr>

							  <tr>
						  		<td>Silver Jewellery  </td>
							  	<td><?php echo $import_silver_jewellery;?></td>
							  </tr>
							  <tr>
						  		<td>Rough Lab Grown Diamond  </td>
							  	<td><?php echo $import_rough_lgd;?></td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Lab Grown Diamond </td>
							  	<td><?php echo $import_cut_polished_lgd;?></td>
							  </tr>
							  <tr>
						  		<td>Cut & Polished Lab Grown Diamond </td>
							  	<td><?php echo $import_cut_polished_lgd;?></td>
							  </tr>
							   <tr>
						  		<td>Other Items </td>
							  	<td><?php echo $import_other_items;?></td>
							  </tr>
							   <tr>
						  		<td>Total </td>
							  	<td><?php echo $import_total;?></td>
							  </tr>
							  <tr>
						  		<td>F.O.B value of exports  </td>
							  	<td><?php echo $export_fob_value;?></td>
							  </tr>
							  <tr>
						  		<td>C.I.F value of imports  </td>
							  	<td><?php echo $import_cif_value;?></td>
							  </tr>
							  
							  
													
							</table>
					</div>
           

           

			
			
         
         
            
      
         <?php
         if($rowsd['isDraft'] =="1"){ ?>
	<div class="form-group col-sm-12">
						<input type="hidden" name="action" value="save" class="cta fade_anim"/>
						<a href="https://gjepc.org/dgft-form.php?application_id=<?php echo base64_encode($application_id);?>" class="input_bg cta fade_anim p-3" >Update Information</a>
						<input class="input_bg cta fade_anim" type="submit" value="Confirm and submit"/>

					</div>
         <?php }
         ?>
				
                    
			</form>
		</div>
			
			
            </div>            
        </div> 	
    </div>    
</section>
<style>
	.summary_table th{
	border-bottom: 0px solid #000!important;
	}
</style>
<?php include 'include-new/footer-card.php'; ?>


<script type="text/javascript">
function PrintContent(){
	var DocumentContainer = document.getElementById("divtoprint");
	var WindowObject = window.open("", "PrintWindow","width=1200,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
}
</script>
