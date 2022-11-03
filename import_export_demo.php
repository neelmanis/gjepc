<?php 
include 'include/header_stats.php';

include 'db.inc.php';
include 'functions.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; } 
?>
<style>
	.border-dotted{border-bottom: 1px dotted #ccc}
	.addIcon{color: #1862af;font-size: 20px;cursor: pointer;position: absolute; right: -11px;
    top: 38px;
    background: #fff;}
    .removeIcon{color: red;
    font-size: 20px;
    cursor: pointer;
    position: absolute;
    right: -11px;
    top: 13px;
    background: #fff;}
    .p-relative{position: relative;}
    @media all and (min-width: 768px) {
    .pl0{padding-left: 0px!important;}
    .pr0{padding-right: 0px!important;}
    .error{color: red}
    .form-control{color: #000}
    .select2-container--default .select2-selection--single .select2-selection__rendered{line-height: 40px}
    .select2-container--default .select2-selection--single{border-radius: 0px}
    .select2-container .select2-selection--single{height: 40px;}
    .fstMultipleMode .fstControls{width: 100%}
    .fstChoiceItem,.fstResultItem,.fstMultipleMode .fstQueryInput{font-size: 12px;width: 100%}
    
    .wrapper_block {position: relative;}
    .wrapper_block:before{position: absolute;content: "";height: auto;width: auto;top: 0;bottom: 0;left: 0;right: 0; background: #ccc;opacity:0.6;z-index: 1}
	}

</style>
	   <?php  
       $registration_id=$_SESSION['USERID'];
       /*-----------------------Get Membership Details  Start------------------*/
       $membership_id = getMembershipId($registration_id, $conn); 
/* 06-04-2021 comments on because of allow last year member */
    //    $check_membership = $conn->query("SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND issue_membership_certificate_expire_status='Y'");
        $check_membership = $conn->query("SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND eligible_for_renewal='Y'");
		$membership_count = $check_membership->num_rows;	
		if($membership_count<1){ 
            echo "<script>alert('You are not a Member'); window.location = 'membership_rcmc.php';</script>";
        }
       $iec_number = getIec($registration_id,$conn);
       $company_name = getCompanyName($registration_id,$conn);
       $company_pan_no = getCompanyPan($registration_id,$conn);
       $memberType = getMemberType($registration_id,$conn);	   
       /*-----------------------Get Membership Details End -------------------*/
  
        $sql= "SELECT * FROM statistics_master WHERE status ='1'"; 
        $sqlExpCountry = "SELECT * FROM country_master WHERE status='1' ";

        /*
        ** GETTING DATA FROM APPLICATION ID
        */
         $appId  = filter($_GET['application_id']);
		if($appId !="" && isset($appId)){ 
	       
	        $appSql = "SELECT * FROM statistics WHERE id ='$appId'";
	        $exportSql = "SELECT * FROM statistics_exports WHERE appId ='$appId'";
	        $importSql = "SELECT * FROM statistics_imports WHERE appId ='$appId'";
           /*---Application-----*/
	    
	       $appResult = $conn->query($appSql);
	       $appRow = $appResult->fetch_assoc();	

	       $quarter_year = $appRow['quarter_year'];
	       $export_category = $appRow['export_category'];
	       $remark = $appRow['remark'];
	       $isDraft = $appRow['isDraft'];
	       $financial_year = $appRow['financial_year'];
	       $year = $appRow['year'];
	       $isExport =$appRow['isExport'];
	   
	       $exportResult = $conn->query($exportSql);
		   $exportCount = $exportResult->num_rows;


	       $importResult = $conn->query($importSql);
		    $importCount = $importResult->num_rows;

	       $remove[] = "'";
		   $remove[] = '"';
		   $remove[] = "-"; 
		}
		?>
	   
<section>	
	<div class="container-fluid inner_container">
		<div class="row justify-content-center grey_title_bg">			
			<div class="innerpg_title_center">
				<h1>Submission Form for filing Export/Import Returns</h1>
			</div>
		</div>
		<div class="container">
			
			<div class="row justify-content-center">

				<?php if($appId !="" && isset($appId)){ ?>
					<form class="cmxform col-12 box-shadow mb-5" method="post" name="application" id="statistics-form"/>
					<div class="row">						
						<div class="form-group col-12 mb-2 p-0">
							<p class="blue">Members Information &nbsp;&nbsp;<span id="chkregisuser"></span><br/><span id="chkpanuser"></span></p>
						</div>
						<div class="form-group col-sm-6">
							<label>Membership No.</label>
							<input type="test" class="form-control" id="membership_no" name="membership_no"  value="<?php echo $membership_id;?>" readonly>
							<label for="membership_no" class="error"></label>
						</div>
						
						<div class="form-group col-sm-6">
							<label>Company Name </label>
							<input type="email" class="form-control" id="company_name" name="company_name"  value="<?php echo $company_name;?>"readonly>
							<label for="company_name" class="error"></label>
						</div>
						<div class="form-group col-md-6">
							<label>IEC No</label>
							<input type="text" class="form-control" id="iec_no" name="iec_no"  value="<?php echo $iec_number; ?>" readonly>
							<label for="iec_no" class="error"></label>
						</div>
						<div class="form-group col-md-6">
							<label>Company PAN No</label>
							<input type="text" class="form-control" id="company_pan_no" name="company_pan_no" value="<?php echo $company_pan_no;?>" readonly>
							<label for="company_pan_no" class="error"></label>
						</div>						
					</div>
					<div class="row border-dotted mb-3"></div>
					<div class="row">						
						<div class="form-group col-12 mb-2 p-0"><p class="blue">Category Of Exporter</p></div>						
						<div class="form-group col-sm-4">
							<label>Category Of Exporter</label>
							<div class="mt-2">								
								<label for="manufacturer_exporter" class="col-md-12">
									<input type="radio" id="manufacturer_exporter" name="company_type" value="6" class="mr-2" <?php if($memberType=="6"){ echo "checked"; } ?> disabled>Manufacturer Exporter
								</label>
								<label for="merchant_exporter" class="col-md-12">
									<input type="radio" id="merchant_exporter" name="company_type" value="5" class="mr-2"
									 <?php if($memberType=="5"){ echo "checked"; } ?>  disabled>Merchant Exporter
								</label>
								<label for="company_type" class="error"></label>								
							</div>
						</div>
						
					<div class="form-group col-md-4">
						<label>Select Quarter Year</label>						
						<select class="form-control" name="quarter_year" id="quarter_year">							
							<option value=""> Select Quarter Year</option>
							<?php
							$q1 = getQuarterYear("Q1",$conn);  $qdec1 = getQuarterDescription("Q1",$conn); 
							$q2 = getQuarterYear("Q2",$conn);  $qdec2 = getQuarterDescription("Q2",$conn); 
							$q3 = getQuarterYear("Q3",$conn);  $qdec3 = getQuarterDescription("Q3",$conn); 
							$q4 = getQuarterYear("Q4",$conn);  $qdec4 = getQuarterDescription("Q4",$conn); 							
							?>
							<!-- 
							<option value="Q2 2019" <?php echo "disabled"; ?>>July-Sept 2019</option>
							<option value="Q3 2019" <?php echo "disabled"; ?>>Oct-Dec 2019</option>
							<option value="Q4 2019" <?php echo "disabled"; ?>>Jan-March 2019</option> -->

							 <!-- 2020-2021 -->
							 <option value="Q1 2020" <?php if($quarter_year.' '.$year== $q1.' '.(date('Y')-1)){ echo "selected"; } ?>  disabled>Apr-June 2020</option>
							 <option value="Q2 2020" <?php if($quarter_year.' '.$year== $q2.' '.(date('Y')-1)){ echo "selected"; } ?>  disabled>July-Sept 2020</option>
							 <option value="Q3 2020" <?php if($quarter_year.' '.$year== $q3.' '.(date('Y')-1)){ echo "selected"; } ?>  disabled>Oct-Dec 2020</option>
							 <option value="Q4 2020" <?php if($quarter_year.' '.$year== $q4.' '.(date('Y')-1)){ echo "selected"; } ?>> 
							 Jan-March 2021</option>
							 <!--<option value="Q4 2020">Oct-Dec 2020</option>-->
							
							<!--<option value="<?php echo $q3.' '.(date('Y')-1);?>" <?php if(date('m') <= 3){ echo "disabled";}else{echo "disabled";}?><?php if($quarter_year.' '.$year== $q3.' '.(date('Y')-1)){ echo "selected"; } ?>>
		                     <?php echo $qdec3;?> <?php echo (date('Y')-1);?></option>
							<option value="<?php echo $q4.' '.(date('Y')-1);?>" <?php if(date('m') <= 3){ echo "";}else{echo "";}?>
							 <?php if($quarter_year.' '.$year== $q4.' '.date('Y')){ echo "selected"; } ?>>
							 <?php echo $qdec4;?> <?php echo date('Y')-1;?></option>-->
							 
							<!--<option value="<?php echo $q1.' '.date('Y');?>" <?php if(date('m') <= 6 && date('m') > 3 ){ echo "";}else{echo "";}?> <?php if($quarter_year.' '.$year== $q1.' '.date('Y')){ echo "selected"; } ?>>
							 <?php echo $qdec1;?> 2020<?php //echo date('Y');?></option>
							<option value="<?php echo $q2.' '.date('Y');?>" <?php if(date('m') <= 9 && date('m') > 6 ){ echo "";}else{echo "";}?> <?php if($quarter_year.' '.$year== $q2.' '.date('Y')){ echo "selected"; } ?>>
							 <?php echo $qdec2;?> 2020<?php //echo date('Y');?></option>
							<option value="<?php echo $q3.' '.date('Y');?>" <?php if(date('m') <= 12 && date('m') > 9 ){ echo "";}else{echo "";}?> <?php if($quarter_year.' '.$year== $q3.' '.date('Y')){ echo "selected"; } ?>>
							 <?php echo $qdec3;?> 2020<?php //echo date('Y');?></option>-->
							 <!-- Above code are commented for hide quartere year 14-08-2020-->
						</select>
							
						<label for="quarter_year" class="error"></label>
					</div>
					
					<div class="form-group col-sm-4">
							<label>Whether Exports / Imports in current year </label>
						
							<div class="mt-2">
								<label for="current_quarter" class="col-md-12">
									<input type="radio" id="exporter" name="export_type" value="exporter" class="mr-2" <?php if($isExport =="exporter"){echo "checked";}?>  >Exporter
								</label>
								<label for="current_quarter" class="col-md-12">
									<input type="radio" id="importer" name="export_type" value="importer" class="mr-2" <?php if($isExport =="importer"){echo "checked";}?>  >Importer
								</label>
								
								<label for="current_quarter" class="col-md-12">
									<input type="radio" id="both" name="export_type" value="both" class="mr-2" <?php if($isExport =="both"){echo "checked";}?> >Both
								</label>
								<label for="nil_exports" class="col-md-12">
									<input type="radio" id="nil_exports" name="export_type" value="NO" class="mr-2" <?php if($isExport =="NO"){echo "checked";}?>>None of these
								</label>
								<label for="export_type" class="error"></label>								
							</div>
					</div>
				</div>
				<div class="row border-dotted mb-3"></div>
				<?php if($exportCount > 0 ){?>
				<div class="row">
					<div class="form-group col-12 mb-2 p-0"><p class="blue">Export Details</p>
					<div class="col-md-1 d-flex"></div>
					</div>
						<div class="export_wrapper border p-3 field_wrapper_export" id="export_wrapper">
					<?php $Exp_i =0;
					while($exportRow = $exportResult->fetch_assoc()){?>		
				<div class="row pb-0 p-relative">
					
						<div class="col-md-2">
							<?php if($Exp_i =="0"){?> <label>HS Code</label> <?php }?>
							<select class="form-control selectSearch exp_hs_code" name="exp_hs_code[<?php echo $Exp_i; ?>]" id="exp_hs_code<?php echo $Exp_i; ?>" data-id="<?php echo $Exp_i; ?>">
								<option value=""> Select HS Code</option>															
								<?php                             
                                $exp_result = $conn->query($sql);
                                while($exp_row = $exp_result->fetch_assoc()){ ?>
								<option value="<?php echo $exp_row['hs_code']; ?>" <?php if($exportRow['hs_code']==$exp_row['hs_code']){echo "selected";}?>><?php echo $exp_row['hs_code']; ?></option>
							<?php  } ?>
							</select>
							<label class="error" for="exp_hs_code<?php echo $Exp_i; ?>"></label>
						</div>
						<div class="col-md-2">
                            <?php if($Exp_i =="0"){?><label>Products</label><?php } ?>
							<input type="text" name="exp_products[<?php echo $Exp_i; ?>]" id="exp_products<?php echo $Exp_i; ?>" class="form-control" value="<?php echo $exportRow['products'];?>" placeholder="Products" readonly>
							<label class="error" for="exp_products<?php echo $Exp_i; ?>"></label>
						</div>
						<div class="col-md-2">
							<?php if($Exp_i =="0"){?><label>Country of Exports</label><?php } ?>
							<select name="exp_country[<?php echo $Exp_i; ?>][]" id="exp_country<?php echo $Exp_i; ?>" class="form-control countryMulti" multiple="multiple" >
								<?php
								


								 foreach(explode(",",$exportRow['country']) as $country){?>
                                    <option value="<?php echo $country;?>" selected><?php echo getCountryName($country,$conn);?></option>
                                <?php }
								$exp_country_result = $conn->query($sqlExpCountry);
                                while($exp_country_row = $exp_country_result->fetch_assoc()){ ?>
								<option value="<?php echo $exp_country_row['country_code'];?>">  <?php  echo str_replace( $remove, "", $exp_country_row['country_name'] );  ?></option>
							<?php } ?>
							</select>
							<label class="error" for="exp_country<?php echo $Exp_i; ?>"></label>
						</div>
						<div class="col-md-2 pr0">
							<?php if($Exp_i =="0"){?><label>Gross Exports (Value)</label><?php } ?>
							<input type="text" name="exp_value[<?php echo $Exp_i; ?>]" id="exp_value<?php echo $Exp_i; ?>" class="form-control Number popUp" data-placement="top" value="<?php echo $exportRow['value'];?>" placeholder="Exports Value" data-toggle="popover"  title="Gross Export value" data-content="Please enter the value only dollar/Euro">
							<label class="error" for="exp_value<?php echo $Exp_i; ?>"></label>
						</div>
						<div class="col-md-1 pl0">
							<?php if($Exp_i =="0"){?><label>Currency</label><?php } ?>							
							<select name="exp_currency[<?php echo $Exp_i; ?>]" id="exp_currency<?php echo $Exp_i; ?>" class="form-control ">
								<option value="">Select Currency</option>
								
								<option value="EUR" <?php if(trim($exportRow['currency'])=="EUR"){echo "selected";}?>>EUR</option>
								<option value="USD" <?php if(trim($exportRow['currency'])=="USD"){echo "selected";}?>>USD</option>
							</select>
							<label class="error" for="exp_currency<?php echo $Exp_i; ?>"></label>
						</div>
						<div class="col-md-2 pr0">
							<?php if($Exp_i =="0"){?><label>Gross Exports (Qty)</label><?php } ?>
							<input type="text" name="exp_qty[<?php echo $Exp_i; ?>]" id="exp_qty<?php echo $Exp_i; ?>" class="form-control Number" value="<?php echo $exportRow['qty'];?>" placeholder="Exports Qty">
							<label class="error" for="exp_qty<?php echo $Exp_i; ?>"></label>
						</div>
						<div class="col-md-1 pl0">
							<?php if($Exp_i =="0"){?><label>Unit</label><?php } ?>					
							<select name="exp_unit[<?php echo $Exp_i; ?>]" id="exp_unit<?php echo $Exp_i; ?>" class="form-control" readonly>
								<option value="">Select unit</option>
						
								<option value="carat"  <?php if($exportRow['unit']=="carat"){echo "selected";}?>>Carat</option>
								<option value="grams"  <?php if($exportRow['unit']=="grams"){echo "selected";}?>>Grams</option>
							</select>
							<label class="error" for="exp_unit<?php echo $Exp_i; ?>"></label>
						</div>	
						<?php if( $Exp_i=="0"){?>
							<a class="m-auto p-2 add_export"><i class="fa fa-plus addIcon"></i></a>
						<?php }else{?>
							<a  class="m-auto p-2 remove_export"><i class="fa fa-minus removeIcon"></i></a>
						<?php } ?>						
											
				</div>
			<?php $Exp_i++; } ?>
				</div>
				</div>
				
				<?php  }else{ 

                   $Exp_i = 1;
					?> 
					<div class="row">
					<div class="form-group col-12 mb-2 p-0"><p class="blue">Export Details</p>
					<div class="col-md-1 d-flex"></div>
					</div>
						<div class="export_wrapper border p-3 field_wrapper_export" id="export_wrapper">
				<div class="row pb-0 p-relative">
					
						<div class="col-md-2">
							<label>HS Code</label>
							<select class="form-control selectSearch exp_hs_code" name="exp_hs_code[0]" id="exp_hs_code0" data-id="0">
								<option value=""> Select HS Code</option>															
								<?php                             
                                $exp_result = $conn->query($sql);
                                while($exp_row = $exp_result->fetch_assoc()){ ?>
								<option value="<?php echo $exp_row['hs_code']; ?>"><?php echo $exp_row['hs_code']; ?></option>
							<?php  } ?>
							</select>
							<label class="error" for="exp_hs_code0"></label>
						</div>
						<div class="col-md-2">
                            <label>Products</label>
							<input type="text" name="exp_products[0]" id="exp_products0" class="form-control" placeholder="Products" readonly>
							<label class="error" for="exp_products0"></label>
						</div>
						<div class="col-md-2">
							<label>Country of Exports</label>
							<select name="exp_country[0][]" id="exp_country0" class="form-control countryMulti" multiple="multiple" >
								<option value="">Select Country</option>								
								<?php 
								$exp_country_result = $conn->query($sqlExpCountry);
                                while($exp_country_row = $exp_country_result->fetch_assoc()){ ?>
								<option value="<?php echo $exp_country_row['country_code'];?>"><?php echo $exp_country_row['country_name'];?></option>
							<?php } ?>
							</select>
							<label class="error" for="exp_country0"></label>
						</div>
						<div class="col-md-2 pr0">
							<label>Gross Exports (Value)</label>
							<input type="text" name="exp_value[0]" id="exp_value0" class="form-control Number popUp" placeholder="Exports Value" data-toggle="popover" data-placement="top"  title="Gross Export value" data-content="Please enter the value only dollar/Euro">
							<label class="error" for="exp_value0"></label>
						</div>
						<div class="col-md-1 pl0">
							<label>Currency</label>							
							<select name="exp_currency[0]" id="exp_currency0" class="form-control ">
								<option value="">Select Currency</option>
								
								<option value="EUR">EUR</option>
								<option value="USD">USD</option>
							</select>
							<label class="error" for="exp_currency0"></label>
						</div>
						<div class="col-md-2 pr0">
							<label>Gross Exports (Qty)</label>
							<input type="text" name="exp_qty[0]" id="exp_qty0" class="form-control Number" placeholder="Exports Qty">
							<label class="error" for="exp_qty0"></label>
						</div>
						<div class="col-md-1 pl0">
							<label>Unit</label>					
							<select name="exp_unit[0]" id="exp_unit0" class="form-control" readonly>
								<option value="">Select unit</option>
						
								<option value="carat">Carat</option>
								<option value="grams">Grams</option>
							</select>
							<label class="error" for="exp_unit0"></label>
						</div>							
						<a class="m-auto p-2 add_export"><i class="fa fa-plus addIcon"></i></a>					
				</div>
				</div>
				</div>
				
				<?php } ?>

				<div class="row border-dotted mb-3"></div>
				<?php if($importCount > 0 ){?>
				<div class="row">

					<div class="form-group col-12 mb-2 p-0"><p class="blue">Import Details</p></div>
						<div class="export_wrapper field_wrapper_import border p-3" id="import_wrapper">
							<?php 
							$Imp_i = 0;
							while($importRow = $importResult->fetch_assoc()){?>	
				<div class="row pb-0 p-relative">
					
						<div class="col-md-2">
						<?php if($Imp =="0"){?>	<label>HS Code</label><?php } ?>
							<select class="form-control selectSearch imp_hs_code" name="imp_hs_code[<?php echo $Imp_i; ?>]" id="imp_hs_code<?php echo $Imp_i; ?>" data-id="<?php echo $Imp_i; ?>">
								<option value=""> Select HS Code</option>								
								<?php                              
                                $imp_result = $conn->query($sql);
                                while($imp_row = $imp_result->fetch_assoc()){ ?>
								<option value="<?php echo $imp_row['hs_code']; ?>" <?php if($importRow['hs_code']==$imp_row['hs_code']){echo "selected";}?>><?php echo $imp_row['hs_code']; ?></option>
							    <?php  } ?>
							</select>
							<label class="error" for="imp_hs_code<?php echo $Imp_i; ?>"></label>
						</div>
						<div class="col-md-2">
                           	<?php if($Imp =="0"){?>	 <label>Products</label><?php } ?>
							<input type="text" name="imp_products[<?php echo $Imp_i; ?>]" id="imp_products<?php echo $Imp_i; ?>" class="form-control" placeholder="Products" value="<?php echo $importRow['products'];?>" readonly>
							<label class="error" for="imp_products<?php echo $Imp_i; ?>"></label>
						</div>
						<div class="col-md-2">
								<?php if($Imp =="0"){?>	<label>Country of Imports</label><?php } ?>							
							<select  name="imp_country[<?php echo $Imp_i; ?>][]" id="imp_country<?php echo $Imp_i; ?>" class="form-control countryMulti"  multiple="multiple">
								<?php foreach(explode(",",$importRow['country']) as $country1){?>
                                    <option value="<?php echo $country1;?>" selected><?php echo getCountryName($country1,$conn);?></option>
                                <?php }						
								
								$imp_country_result = $conn->query($sqlExpCountry);
                                while($imp_country_row = $imp_country_result->fetch_assoc()){ ?>
								<option value="<?php echo $imp_country_row['country_code'];?>"><?php  echo str_replace( $remove, "", $imp_country_row['country_name'] );  ?></option>
							<?php } ?>
							</select>
							<label class="error" for="imp_country<?php echo $Imp_i; ?>"></label>
						</div>
						<div class="col-md-2 pr0">
								<?php if($Imp =="0"){?>	<label>Gross Imports (Value)</label> <?php } ?>
							<input type="text" name="imp_value[<?php echo $Imp_i; ?>]" id="imp_value<?php echo $Imp_i; ?>" class="form-control Number popUp" data-placement="top"  placeholder="Imports Value"  value="<?php echo $importRow['value'];?>"  data-toggle="popover"  title="Gross Import Value" data-content="Please enter the value only dollar/Euro">
							<label class="error" for="imp_value<?php echo $Imp_i; ?>"></label>
						</div>
						<div class="col-md-1 pl0">
								<?php if($Imp =="0"){?>	<label>Currency</label>	<?php } ?>						
							<select name="imp_currency[<?php echo $Imp_i; ?>]" id="imp_currency<?php echo $Imp_i; ?>" class="form-control">
								<option value="">Select Currency</option>							
								<option value="EUR" <?php if( trim($importRow['currency']) =="EUR"){echo "selected";}?>>EUR</option>
								<option value="USD" <?php if( trim($importRow['currency']) =="USD"){echo "selected";}?>>USD</option>
							</select>
							<label class="error" for="imp_currency<?php echo $Imp_i; ?>"></label>
						</div>
						<div class="col-md-2 pr0">
								<?php if($Imp =="0"){?>	<label>Gross Imports (Qty)</label><?php } ?>
							<input type="text" name="imp_qty[<?php echo $Imp_i; ?>]" id="imp_qty<?php echo $Imp_i; ?>" class="form-control Number" placeholder="Imports Qty" value="<?php echo $importRow['qty'];?>">
							<label class="error" for="imp_qty<?php echo $Imp_i; ?>"></label>
						</div>
						<div class="col-md-1 pl0">
								<?php if($Imp =="0"){?>	<label>Unit</label>	<?php } ?>						
							<select name="imp_unit[<?php echo $Imp_i; ?>]" id="imp_unit<?php echo $Imp_i; ?>" class="form-control" readonly>
								<option value="">Select unit</option>						
								<option value="carat"  <?php if( $importRow['unit'] =="carat"){echo "selected";}?>>Carat</option>
								<option value="grams"  <?php if( $importRow['unit'] =="grams"){echo "selected";}?>>Grams</option>
							</select>
							<label class="error" for="imp_unit<?php echo $Imp_i; ?>"></label>
						</div>							
						<?php if( $Imp_i=="0"){?>
							<a class="m-auto p-2 add_import"><i class="fa fa-plus addIcon"></i></a>
						<?php }else{?>
							<a  class="m-auto p-2 remove_import"><i class="fa fa-minus removeIcon"></i></a>
						<?php } ?>				
				</div>
					<?php $Imp_i++; } ?>
				</div>
				</div>
				<?php } else{ ?>
								<div class="row">

					<div class="form-group col-12 mb-2 p-0"><p class="blue">Import Details</p></div>
						<div class="export_wrapper field_wrapper_import border p-3" id="import_wrapper">
				<div class="row pb-0 p-relative">
					<?php $Imp_i = 1;?>
						<div class="col-md-2">
							<label>HS Code</label>
							<select class="form-control selectSearch imp_hs_code" name="imp_hs_code[]" id="imp_hs_code0" data-id="0">
								<option value=""> Select HS Code</option>								
								<?php                              
                                $imp_result = $conn->query($sql);
                                while($imp_row = $imp_result->fetch_assoc()){ ?>
								<option value="<?php echo $imp_row['hs_code']; ?>"><?php echo $imp_row['hs_code']; ?></option>
							    <?php  } ?>
							</select>
							<label class="error" for="imp_hs_code0"></label>
						</div>
						<div class="col-md-2">
                            <label>Products</label>
							<input type="text" name="imp_products[0]" id="imp_products0" class="form-control" placeholder="Products" readonly>
							<label class="error" for="imp_products0"></label>
						</div>
						<div class="col-md-2">
							<label>Country of Imports</label>							
							<select  name="imp_country[0][]" id="imp_country0" class="form-control countryMulti"  multiple="multiple">
								<option value="">Select Country</option>						
								<?php 
								$imp_country_result = $conn->query($sqlExpCountry);
                                while($imp_country_row = $imp_country_result->fetch_assoc()){ ?>
								<option value="<?php echo $imp_country_row['country_code'];?>"><?php echo $imp_country_row['country_name'];?></option>
							<?php } ?>
							</select>
							<label class="error" for="imp_country0"></label>
						</div>
						<div class="col-md-2 pr0">
							<label>Gross Imports (Value)</label>
							<input type="text" name="imp_value[0]" id="imp_value0" class="form-control Number popUp" data-placement="top"  placeholder="Imports Value"  data-toggle="popover"  title="Gross Import Value" data-content="Please enter the value only dollar/Euro">
							<label class="error" for="imp_value0"></label>
						</div>
						<div class="col-md-1 pl0">
							<label>Currency</label>							
							<select name="imp_currency[0]" id="imp_currency0" class="form-control">
								<option value="">Select Currency</option>							
								<option value="EUR">EUR</option>
								<option value="USD">USD</option>
							</select>
							<label class="error" for="imp_currency0"></label>
						</div>
						<div class="col-md-2 pr0">
							<label>Gross Imports (Qty)</label>
							<input type="text" name="imp_qty[0]" id="imp_qty0" class="form-control Number" placeholder="Imports Qty">
							<label class="error" for="imp_qty0"></label>
						</div>
						<div class="col-md-1 pl0">
							<label>Unit</label>							
							<select name="imp_unit[0]" id="imp_unit0" class="form-control" readonly>
								<option value="">Select unit</option>						
								<option value="carat">Carat</option>
								<option value="grams">Grams</option>
							</select>
							<label class="error" for="imp_unit0"></label>
						</div>							
						<a class="m-auto p-2 add_import"><i class="fa fa-plus addIcon"></i></a>					
				</div>
				</div>
				</div>
					
				<?php } ?>
				<div class="row border-dotted mb-3"></div>
	
					<div class="row border-dotted mb-3"></div>
					<div class="row">
							<div class="col-md-12">						
							<label for="">Remarks</label>
							<textarea name="remark" type="text" id='remark' rows="3" class="form-control"><?php echo  $remark;?></textarea>
							<label for="remark" class="error"></label>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<p>I certify all information furnished above is true and correct to the best of my knowledge.</p>
							<label for=""><input type="checkbox" name="agree" value="agree" id="agree" checked="checked"> Agree</label>
							<label for="agree" class="error"></label>
							<a href="#">Terms & Conditions</a>
						</div>
					</div>
				<div class="row">
					<div class="form-group col-12">
							<div class="d-flex">
								<input type="hidden" name="updateId" value="<?php echo $appId;?>">
								<input type="hidden" name="action" value="statisticsDataInsert">
								<input type="hidden" name="saveType" id="saveType" value="">
							
								<div>
									<input type="submit" id="save_draft" name="save_draft" class="cta fade_anim mr-2 d-inline-block" value="Save As Draft">
									<input type="submit" id="register" name="submit"  class="cta fade_anim mr-2 d-inline-block" value="Submit">
									
								</div>								
							</div>
					</div>
				</div>				
				</form>	
                          
				<?php }else{?>
					<form class="cmxform col-12 box-shadow mb-5" method="post" name="application" id="statistics-form"/>
					<div class="row">						
						<div class="form-group col-12 mb-2 p-0">
							<p class="blue">Members Information &nbsp;&nbsp;<span id="chkregisuser"></span><br/><span id="chkpanuser"></span></p>
						</div>
						<div class="form-group col-sm-6">
							<label>Membership No.</label>
							<input type="test" class="form-control" id="membership_no" name="membership_no"  value="<?php echo $membership_id;?>" readonly>
							<label for="membership_no" class="error"></label>
						</div>
						
						<div class="form-group col-sm-6">
							<label>Company Name </label>
							<input type="email" class="form-control" id="company_name" name="company_name"  value="<?php echo $company_name;?>"readonly>
							<label for="company_name" class="error"></label>
						</div>
						<div class="form-group col-md-6">
							<label>IEC No</label>
							<input type="text" class="form-control" id="iec_no" name="iec_no"  value="<?php echo $iec_number; ?>" readonly>
							<label for="iec_no" class="error"></label>
						</div>
						<div class="form-group col-md-6">
							<label>Company PAN No</label>
							<input type="text" class="form-control" id="company_pan_no" name="company_pan_no" value="<?php echo $company_pan_no;?>" readonly>
							<label for="company_pan_no" class="error"></label>
						</div>						
					</div>
					<div class="row border-dotted mb-3"></div>
					<div class="row">						
						<div class="form-group col-12 mb-2 p-0"><p class="blue">Category Of Exporter</p></div>						
						<div class="form-group col-sm-4">
							<label>Category Of Exporter</label>
							<div class="mt-2">								
								<label for="manufacturer_exporter" class="col-md-12">
									<input type="radio" id="manufacturer_exporter" name="company_type" value="6" class="mr-2" <?php if($memberType=="6"){ echo "checked"; } ?> disabled>Manufacturer Exporter
								</label>
								<label for="merchant_exporter" class="col-md-12">
									<input type="radio" id="merchant_exporter" name="company_type" value="5" class="mr-2"
									 <?php if($memberType=="5"){ echo "checked"; } ?>  disabled>Merchant Exporter
								</label>
								<label for="company_type" class="error"></label>								
							</div>
						</div>
						
					<div class="form-group col-md-4">
						<label>Select Quarter Year</label>						
						<select class="form-control" name="quarter_year" id="quarter_year">							
							<option value=""> Select Quarter Year</option>
							<?php
							$q1 = getQuarterYear("Q1",$conn);  $qdec1 = getQuarterDescription("Q1",$conn); 
							$q2 = getQuarterYear("Q2",$conn);  $qdec2 = getQuarterDescription("Q2",$conn); 
							$q3 = getQuarterYear("Q3",$conn);  $qdec3 = getQuarterDescription("Q3",$conn); 
							$q4 = getQuarterYear("Q4",$conn);  $qdec4 = getQuarterDescription("Q4",$conn); 							
							?>
							<!--<option value="Q1 2019">Apr-June 2019</option>
							<option value="Q2 2019">July-Sept 2019</option>

							<option value="<?php echo $q3.' '.(date('Y')-1);?>" <?php if(date('m') <= 3){ echo "";}else{echo "";}?> 
		                     <?php if($quarter_year.' '.$year== $q3.' '.(date('Y')-1)){ echo "selected"; } ?>>
		                     <?php echo $qdec3;?> <?php echo (date('Y')-1);?></option>

							<option value="<?php echo $q4.' '.(date('Y')-1);?>" <?php if(date('m') <= 3){ echo "";}else{echo "";}?>
							 <?php if($quarter_year.' '.$year== $q4.' '.date('Y')){ echo "selected"; } ?>>
							 <?php echo $qdec4;?> <?php echo (date('Y')-1);?></option>-->

							 <!-- 2020-2021 -->
							<!--<option value="<?php echo $q1.' '.date('Y');?>" <?php if(date('m') <= 6 && date('m') > 3 ){ echo "";}else{echo "";}?> <?php if($quarter_year.' '.$year== $q1.' '.date('Y')){ echo "selected"; } ?>>
							 <?php echo $qdec1;?> 2020<?php //echo date('Y');?></option>
							<option value="<?php echo $q2.' '.date('Y');?>" <?php if(date('m') <= 9 && date('m') > 6 ){ echo "";}else{echo "";}?> <?php if($quarter_year.' '.$year== $q2.' '.date('Y')){ echo "selected"; } ?>>
							 <?php echo $qdec2;?> 2020<?php //echo date('Y');?></option>-->
							 
							<option value="<?php echo $q3.' '.(date('Y')-1);?>" <?php if(date('m') <= 12 && date('m') > 9 ){ echo "";}else{echo "";}?> <?php if($quarter_year.' '.$year== $q3.' '.date('Y')){ echo "selected"; } ?> disabled>
							 <?php echo $qdec3;?> 2020<?php //echo date('Y');?></option>
							 <option value="Q4 2020">Jan-March 2021</option>
							 <!-- Above code are commented for hide quartere year 14-08-2020-->
						</select>
							
						<!--<select class="form-control" name="quarter_year" id="quarter_year">							
							<option value=""> Select Quarter Year</option>
							<option value="Oct-Dec <?php echo (date('Y')-1);?>" <?php if(date('m') <= 3){ echo "";}else{echo "disabled";}?>> Oct-Dec <?php echo (date('Y')-1);?></option>
							<option value="Jan-March <?php echo date('Y');?>" <?php if(date('m') <= 3){ echo "";}else{echo "disabled";}?>>Jan-March <?php echo date('Y');?></option>
							<option value="Apr-June <?php echo date('Y');?>" <?php if(date('m') <= 6 && date('m') > 3 ){ echo "";}else{echo "disabled";}?>> Apr-June <?php echo date('Y');?></option>
							<option value="July-Sept <?php echo date('Y');?>" <?php if(date('m') <= 9 && date('m') > 6 ){ echo "";}else{echo "disabled";}?>> July-Sept <?php echo date('Y');?></option>
							<option value="Oct-Dec <?php echo date('Y');?>" <?php if(date('m') <= 12 && date('m') > 9 ){ echo "";}else{echo "disabled";}?>> Oct-Dec <?php echo date('Y');?></option>
						</select>-->
						<label for="quarter_year" class="error"></label>
					</div>
					
					<div class="form-group col-sm-4">
							<label>Whether Exports / Imports in current year </label>
							<div class="mt-2">
								<label for="current_quarter" class="col-md-12">
									<input type="radio" id="exporter" name="export_type" value="exporter" class="mr-2" >Exporter
								</label>
								<label for="current_quarter" class="col-md-12">
									<input type="radio" id="importer" name="export_type" value="importer" class="mr-2" >Importer
								</label>
								
								<label for="current_quarter" class="col-md-12">
									<input type="radio" id="both" name="export_type" value="both" class="mr-2" >Both
								</label>
								<label for="nil_exports" class="col-md-12">
									<input type="radio" id="nil_exports" name="export_type" value="NO" class="mr-2">None of these
								</label>
								<label for="export_type" class="error"></label>								
							</div>
					</div>
				</div>
				<label for="both" class="error" ></label>	
				<div class="row border-dotted mb-3"></div>
				<div class="row">
					<div class="form-group col-12 mb-2 p-0"><p class="blue">Export Details</p>
					<div class="col-md-1 d-flex"></div>
					</div>
						<div class="export_wrapper border p-3 field_wrapper_export" id="export_wrapper">
				<div class="row pb-0 p-relative">
					
						<div class="col-md-2">
							<label>HS Code</label>
							<select class="form-control selectSearch exp_hs_code" name="exp_hs_code[0]" id="exp_hs_code0" data-id="0">
								<option value=""> Select HS Code</option>															
								<?php                             
                                $exp_result = $conn->query($sql);
                                while($exp_row = $exp_result->fetch_assoc()){ ?>
								<option value="<?php echo $exp_row['hs_code']; ?>"><?php echo $exp_row['hs_code']; ?></option>
							<?php  } ?>
							</select>
							<label class="error" for="exp_hs_code0"></label>
						</div>
						<div class="col-md-2">
                            <label>Products</label>
							<input type="text" name="exp_products[0]" id="exp_products0" class="form-control" placeholder="Products" readonly>
							<label class="error" for="exp_products0"></label>
						</div>
						<div class="col-md-2">
							<label>Country of Exports</label>
							<select name="exp_country[0][]" id="exp_country0" class="form-control countryMulti" multiple="multiple" >
								<option value="">Select Country</option>								
								<?php 
								$exp_country_result = $conn->query($sqlExpCountry);
                                while($exp_country_row = $exp_country_result->fetch_assoc()){ ?>
								<option value="<?php echo $exp_country_row['country_code'];?>"><?php echo $exp_country_row['country_name'];?></option>
							<?php } ?>
							</select>
							<label class="error" for="exp_country0"></label>
						</div>
						<div class="col-md-2 pr0">
							<label>Gross Exports (Value)</label>
							<input type="text" name="exp_value[0]" id="exp_value0" class="form-control Number popUp" data-placement="top" placeholder="Exports Value" data-toggle="popover"  title="Gross Export Value" data-content="Please enter the value only dollar/Euro">
							<label class="error" for="exp_value0"></label>
						</div>
						<div class="col-md-1 pl0">
							<label>Currency</label>							
							<select name="exp_currency[0]" id="exp_currency0" class="form-control ">
								<option value="">Select Currency</option>
								
								<option value="EUR">EUR</option>
								<option value="USD">USD</option>
							</select>
							<label class="error" for="exp_currency0"></label>
						</div>
						<div class="col-md-2 pr0">
							<label>Gross Exports (Qty)</label>
							<input type="text" name="exp_qty[0]" id="exp_qty0" class="form-control Number" placeholder="Exports Qty">
							<label class="error" for="exp_qty0"></label>
						</div>
						<div class="col-md-1 pl0">
							<label>Unit</label>					
							<select name="exp_unit[0]" id="exp_unit0" class="form-control" readonly>
								<option value="">Select unit</option>
						
								<option value="carat">Carat</option>
								<option value="grams">Grams</option>
							</select>
							<label class="error" for="exp_unit0"></label>
						</div>							
						<a class="m-auto p-2 add_export"><i class="fa fa-plus addIcon"></i></a>					
				</div>
				</div>
				</div>
			
				<div class="row border-dotted mb-3"></div>
				<div class="row">

					<div class="form-group col-12 mb-2 p-0"><p class="blue">Import Details</p></div>
						<div class="export_wrapper field_wrapper_import border p-3" id="import_wrapper">
				<div class="row pb-0 p-relative">
					
						<div class="col-md-2">
							<label>HS Code</label>
							<select class="form-control selectSearch imp_hs_code" name="imp_hs_code[]" id="imp_hs_code0" data-id="0">
								<option value=""> Select HS Code</option>								
								<?php                              
                                $imp_result = $conn->query($sql);
                                while($imp_row = $imp_result->fetch_assoc()){ ?>
								<option value="<?php echo $imp_row['hs_code']; ?>"><?php echo $imp_row['hs_code']; ?></option>
							    <?php  } ?>
							</select>
							<label class="error" for="imp_hs_code0"></label>
						</div>
						<div class="col-md-2">
                            <label>Products</label>
							<input type="text" name="imp_products[0]" id="imp_products0" class="form-control" placeholder="Products" readonly>
							<label class="error" for="imp_products0"></label>
						</div>
						<div class="col-md-2">
							<label>Country of Imports</label>							
							<select  name="imp_country[0][]" id="imp_country0" class="form-control countryMulti"  multiple="multiple">
								<option value="">Select Country</option>						
								<?php 
								$imp_country_result = $conn->query($sqlExpCountry);
                                while($imp_country_row = $imp_country_result->fetch_assoc()){ ?>
								<option value="<?php echo $imp_country_row['country_code'];?>"><?php echo $imp_country_row['country_name'];?></option>
							<?php } ?>
							</select>
							<label class="error" for="imp_country0"></label>
						</div>
						<div class="col-md-2 pr0">
							<label>Gross Imports (Value)</label>
							<input type="text" name="imp_value[0]" id="imp_value0" class="form-control Number popUp" data-placement="top"  placeholder="Imports Value" data-toggle="popover"  title="Gross Import Value" data-content="Please enter the value only dollar/Euro">
							<label class="error" for="imp_value0"></label>
						</div>
						<div class="col-md-1 pl0">
							<label>Currency</label>							
							<select name="imp_currency[0]" id="imp_currency0" class="form-control">
								<option value="">Select Currency</option>							
								<option value="EUR">EUR</option>
								<option value="USD">USD</option>
							</select>
							<label class="error" for="imp_currency0"></label>
						</div>
						<div class="col-md-2 pr0">
							<label>Gross Imports (Qty)</label>
							<input type="text" name="imp_qty[0]" id="imp_qty0" class="form-control Number" placeholder="Imports Qty">
							<label class="error" for="imp_qty0"></label>
						</div>
						<div class="col-md-1 pl0">
							<label>Unit</label>							
							<select name="imp_unit[0]" id="imp_unit0" class="form-control" readonly>
								<option value="">Select unit</option>						
								<option value="carat">Carat</option>
								<option value="grams">Grams</option>
							</select>
							<label class="error" for="imp_unit0"></label>
						</div>							
						<a class="m-auto p-2 add_import"><i class="fa fa-plus addIcon"></i></a>					
				</div>
				</div>
				</div>
				<div class="row border-dotted mb-3"></div>
	
					<div class="row border-dotted mb-3"></div>
					<div class="row">
							<div class="col-md-12">	
							 				
							<label for="">Remarks</label>
							<textarea name="remark" type="text" id='remark' rows="3" class="form-control"></textarea>
							<label for="remark" class="error"></label>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<p>I certify all information furnished above is true and correct to the best of my knowledge.</p>
							<label for=""><input type="checkbox" name="agree" value="agree" id="agree"> Agree</label>							
							<a href="#">Terms & Conditions</a>
							<label for="agree" class="error"></label>
						</div>
					</div>
				<div class="row">
					<div class="form-group col-12">
							<div class="d-flex">
								<input type="hidden" name="action" value="statisticsDataInsert">
								<input type="hidden" name="saveType" id="saveType" value="">
							
								<div>
									<input type="submit" id="save_draft" name="save_draft" class="cta fade_anim mr-2 d-inline-block" value="Save As Draft">
									<input type="submit" id="register" name="submit"  class="cta fade_anim mr-2 d-inline-block" value="Submit">
									
								</div>								
							</div>
					</div>
				</div>				
				</form>				

				<?php } ?>
				
				
			</div>			
		</div>		
	</div>	
</div>

</section>

</div>
<?php include 'include/footer_stats.php'; ?>
<script>
$(document).ready(function(){
/* Export form Add Remove*/
var add_input_button_export = $('.add_export');
var field_wrapper_export = $('.field_wrapper_export');
var input_count_export = <?php  if($appId !="" && isset($appId)){ echo $Exp_i-1; }else{echo "0"; } ?>;
var max_fields_export = 50;

$(add_input_button_export).click(function(){

if(input_count_export < max_fields_export){
input_count_export++;
$(field_wrapper_export).append('<div class="row pb-0 p-relative"><div class="col-md-2"><select class="form-control select exp_hs_code" name="exp_hs_code['+input_count_export+']" id="exp_hs_code'+input_count_export+'" data-id="'+input_count_export+'"><option value="">Select Hs Code</option><?php 
                               $exp_result_add = $conn->query($sql); 
                               while($exp_row_add = $exp_result_add->fetch_assoc()){ 
                               	?>
								<option value="<?php echo $exp_row_add['hs_code']; ?>"><?php echo $exp_row_add['hs_code']; ?></option><?php
								 } ?>
								</select><label class="error" for="exp_hs_code'+input_count_export+'"></label></div>'+
								'<div class="col-md-2"><input type="text" name="exp_products['+input_count_export+']" id="exp_products'+input_count_export+'" placeholder="Products" class="form-control" readonly><label class="error" for="exp_products'+input_count_export+'"></label></div>'+
								'<div class="col-md-2"><select name="exp_country['+input_count_export+'][]" id="exp_country'+input_count_export+'" class="form-control"  multiple="multiple"><option value="">Select Country</option><?php 
                               $exp_country_result1 = $conn->query($sqlExpCountry); 
                               $remove[] = "'";
                               $remove[] = '"';
                               $remove[] = "-"; 
                               while($exp_country_row1 = $exp_country_result1->fetch_assoc()){ 
                               	?>
								<option value="<?php echo $exp_country_row1['country_code']; ?>"><?php echo str_replace( $remove, "", $exp_country_row1['country_name'] ); ?></option><?php
								 } ?></select><label class="error" for="exp_country'+input_count_export+'"></label></div>'+
								'<div class="col-md-2 pr0"><input type="text" name="exp_value['+input_count_export+']" id="exp_value'+input_count_export+'" placeholder=" Export Value"class="form-control Number popUp" data-placement="top" data-toggle="popover"  title="Gross Export value" data-content="Please enter the value only dollar/Euro" ><label class="error" for="exp_value'+input_count_export+'"></label></div>'+
								'<div class="col-md-1 pl0"><select name="exp_currency['+input_count_export+']" id="exp_currency'+input_count_export+'" class="form-control"><option value="">Select Currency</option><option value="EUR">EUR</option><option value="USD">USD</option></select><label class="error" for="exp_currency'+input_count_export+'"></label></div>'+
								'<div class="col-md-2 pr0"><input type="text" name="exp_qty['+input_count_export+']" id="exp_qty'+input_count_export+'" placeholder=" Exports Qty." class="form-control Number"><label class="error" for="exp_qty'+input_count_export+'"></label></div>'+
								'<div class="col-md-1 pl0"><select name="exp_unit['+input_count_export+']" id="exp_unit'+input_count_export+'"  class="form-control" readonly><option value="">Select</option><option value="carat">Carat</option><option value="grams">Grams</option></select><label class="error" for="exp_unit'+input_count_export+'"></label></div>'+
								'<a  class="m-auto p-2 remove_export"><i class="fa fa-minus removeIcon"></i></a></div></div');
 $("#exp_hs_code"+input_count_export+"").select2();
 $("#exp_country"+input_count_export+"").fastselect();
  $('.popUp').popover('hide');
  $("#exp_value"+input_count_export).popover('show');
}
});

$(field_wrapper_export).on('click', '.remove_export', function(e){
e.preventDefault();
$(this).parent('.row').remove();
input_count_export--;
});

/* Export form Add Remove*/
/* Import form Add Remove*/
var add_input_button_import = $('.add_import');
var field_wrapper_import = $('.field_wrapper_import');
var input_count_import =<?php  if($appId !="" && isset($appId)){ echo $Imp_i-1; }else{echo "0"; } ?>;
var max_fields_import = 50;


$(add_input_button_import).click(function(){

if(input_count_import < max_fields_import){
input_count_import++;
$(field_wrapper_import).append('<div class="row pb-0 p-relative"><div class="col-md-2"><select class="form-control select imp_hs_code" name="imp_hs_code[]" id="imp_hs_code'+input_count_import+'" data-id="'+input_count_import+'"><option value="">Select Hs Code</option><?php 
                               $imp_result_add = $conn->query($sql); 
                               while($imp_row_add = $imp_result_add->fetch_assoc()){ 
                               	?>
								<option value="<?php echo $imp_row_add['hs_code']; ?>"><?php echo $imp_row_add['hs_code']; ?></option><?php
								 } ?>
								</select><label class="error" for="imp_hs_code'+input_count_import+'"></label></div>'+
								'<div class="col-md-2"><input type="text" name="imp_products['+input_count_import+']" id="imp_products'+input_count_import+'" class="form-control" placeholder="Products" readonly><label class="error" for="imp_products'+input_count_import+'"></label></div>'+
								'<div class="col-md-2"><select name="imp_country['+input_count_import+'][]" id="imp_country'+input_count_import+'" class="form-control"  multiple="multiple"><option value="">Select Country</option><?php 
                               $imp_country_result1 = $conn->query($sqlExpCountry); 
                               $remove[] = "'";
                               $remove[] = '"';
                               $remove[] = "-"; 
                               while($imp_country_row1 = $imp_country_result1->fetch_assoc()){ 
                               	?>
								<option value="<?php echo $imp_country_row1['country_code']; ?>"><?php echo str_replace( $remove, "", $imp_country_row1['country_name'] ); ?></option><?php
								 } ?></select><label class="error" for="imp_country'+input_count_import+'"></label></div>'+
								 '<div class="col-md-2 pr0"><input type="text" name="imp_value['+input_count_import+']" id="imp_value'+input_count_import+'" class="form-control Number popUp" data-placement="top" placeholder="Imports Value"  data-toggle="popover"  title="Gross Import Value" data-content="Please enter the value only dollar/Euro"><label class="error" for="imp_value'+input_count_import+'"></label></div>'+
								 '<div class="col-md-1 pl0"><select  name="imp_currency['+input_count_import+']" id="imp_currency'+input_count_import+'" class="form-control"><option value="">Select Currency</option><option value="EUR">EUR</option><option value="USD">USD</option></select><label class="error" for="imp_currency'+input_count_import+'"></label></div>'+
								 '<div class="col-md-2 pr0"><input type="text" name="imp_qty['+input_count_import+']" id="imp_qty['+input_count_import+']" class="form-control Number" placeholder="Imports Qty"><label class="error" for="imp_qty'+input_count_import+'"></label></div>'+
								 '<div class="col-md-1 pl0"><select  name="imp_unit['+input_count_import+']" id="imp_unit'+input_count_import+'" class="form-control" readonly><option value="">Select</option><option value="carat">Carat</option><option value="grams">Grams</option></select><label class="error" for="imp_unit'+input_count_import+'"></label></div>'+
								 '<a  class="m-auto p-2 remove_import"><i class="fa fa-minus removeIcon"></i></a></div></div');
 $("#imp_hs_code"+input_count_import+"").select2();
 $("#imp_country"+input_count_import+"").fastselect();
  $('.popUp').popover('hide');
  $("#imp_value"+input_count_import).popover('show');

}
});

$(field_wrapper_import).on('click', '.remove_import', function(e){
e.preventDefault();
$(this).parent('.row').remove();
input_count_import--;
});


/* Import form Add Remove*/

});

$(document).ready(function(){

	$(".cta").on("click",function(e){
		e.preventDefault();		   
		$(".error").html("");
		var btnValue = $(this).val();
		$("#saveType").val(btnValue);	
	
		var formdata = $("#statistics-form").serialize();
		
        
		$.ajax({
			type:'POST',
			//data:{formdata:formdata,btnValue:btnValue},
			data:formdata,
			url:"statisticsAction.php",
			dataType: "json",
			beforeSend:function(){
				$("#preloader").show();
				$("#status").show();
			},
			success:function(result){
			    $("#preloader").delay(300).fadeOut();
				$("#status").delay(300).fadeOut();
				

				if(result.status=="success"){
					$('#statistics-form')[0].reset();
					if(result.isDraft=="Y"){
                      var msg = "Application Saved to Draft Successfully"; 
					}else{
                       var msg = "Application Submitted Successfully"; 
					}
					
					 swal({
						title: "success",
						icon: "success",
						text: msg
					}).then(function(){
						window.location.href="import_export_lists.php";
					});
				}else{

					$.each(result, function(i, v) {
					$(".error").css("display","block");
				    $("label[for='"+v.label+"']").html(v.msg);						
					});
				}				
				  
			}
		});
	});
$("input[name='export_type']").change(function(){
	if($(this).val()=="NO"){
    $("#import_wrapper").addClass("wrapper_block");
    $("#export_wrapper").addClass("wrapper_block");
      $("label[for='both']").html("");
         swal({
						title: "warning",
						icon: "warning",
						text: "Kindly submit the form"
					});
	}else{
	$("#import_wrapper").removeClass("wrapper_block");
    $("#export_wrapper").removeClass("wrapper_block");
 

	}
});

    $(document).on("change", ".exp_hs_code", function(){	
    	var exp_hs_code =$(this).val();
    	var id = $(this).data('id');
    	var expAction = "export_code"; 
    
    		$.ajax({
			type:'POST',
			data:{exp_hs_code:exp_hs_code,expAction:expAction},
			url:"statisticsAction.php",
			dataType: "json",
			success:function(result){
            $("#exp_products"+id+"").val(result.product);
            $("#exp_unit"+id+"").val(result.unit);
            $("#exp_products"+id+"").focus();
            $("#exp_unit"+id+"").focus();
			}
		});
    });
      $(document).on("change", ".imp_hs_code", function(){	
    	var imp_hs_code =$(this).val();
    	var id = $(this).data('id');
    	var impAction = "import_code"; 
    
    		$.ajax({
			type:'POST',
			data:{imp_hs_code:imp_hs_code,impAction:impAction},
			url:"statisticsAction.php",
			dataType: "json",
			success:function(result){
            $("#imp_products"+id+"").val(result.product);
            $("#imp_unit"+id+"").val(result.unit);
            $("#imp_unit"+id+"").focus();
            $("#imp_products"+id+"").focus();
			}
		});
    });
     $('.Number').keypress(function (event) {
    var keycode = event.which;
    if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
    }
});

      $(".selectSearch").select2();
      $('.countryMulti').fastselect();
    
    
    $('.popUp').popover('show');
    // $('.popUp').click(function(e) {
    //  $('.popUp').popover('hide');
    // });
    $('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 
           && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
            }
        });
    });
});
</script>