<?php 
$pageTitle = "Gems And Jewellery Industry In India | Country-wise all commodities - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
include 'functions.php';

		if($_REQUEST['Reset']=="Reset")
		{
		  $_SESSION['financial_year']  =""; 
		  $_SESSION['country']	   	   ="";
		  $_SESSION['commoditySel']	   =""; 
		  $_SESSION['commodity']       =""; 		  
		  $_SESSION['commodity_level'] =""; 		  
		  $_SESSION['currency']        =""; 
		  $_SESSION['currency_inr']    =""; 		  	  
		  $_SESSION['currency_usd']    =""; 		  
		  
		  header("Location: country-wise-all-commodities-import.php");
		} else {
		$search_type = $_REQUEST['search_type'];
		
		if(isset($search_type)=="SEARCH")
		{
		$financial_year  = $_REQUEST['financial_year'];
		$country 	 	 = $_REQUEST['country'];
		$commoditySel 	 = filter($_REQUEST['commoditySel']);
		$commodity = $_POST['commodity'];
		$commodity_level = filter($_REQUEST['commodity_level']);
		$trade_type 	 = "Import";
		$currency  		 = $_POST['currency'];
		$currency_inr	 = $_POST['currency_inr'];		
		$currency_usd	 = $_POST['currency_usd'];			
		
		$_SESSION['financial_year']  = $financial_year;
		$_SESSION['country'] 		 = $country;
		$_SESSION['commoditySel'] 	 = $commoditySel;
		$_SESSION['commodity_level'] = $commodity_level;
		$_SESSION['commodity'] 		 = $commodity;
		$_SESSION['currency'] 		 = $currency;
		$_SESSION['currency_inr']    = $currency_inr;
		$_SESSION['currency_usd']    = $currency_usd;
		
		$flag=1;
		
		if($financial_year=="" || $financial_year=="0")
		{  $signup_error = "Please Select Year."; $flag=0; }
		else if($country=="")
		{  $signup_error = "Please Select Country."; $flag=0; }
		else if($commoditySel=="")
		{  $signup_error = "Please Select Commodity."; $flag=0; }
		else if($commoditySel=="SpecificCommodity" && $commodity=="")
		{  $signup_error = "Please Select Specific Commodity."; $flag=0; }
		else if($commoditySel=="allCommodity" && $commodity_level=="")
		{  $signup_error = "Please Select Commodities Level."; $flag=0; }
		else if($currency=="")
		{  $signup_error = "Please Select Currency."; $flag=0; }
		else if($currency=="INR" && $currency_inr=="")
		{  $signup_error = "Please Select Currency Value."; $flag=0; }
		else if($currency=="USD" && $currency_usd=="")
		{  $signup_error = "Please Select Currency Value."; $flag=0; }
		else {
		$flag=1;
		}
		}
		}
?>

<section>       
 
<div class="container inner_container">
    <div class="row justify-content-center mb-0 mt-3">
        <div class="col-12 text-center">
            <h1 class="bold_font">Imports Data Bank</h1>
        </div>
    </div>
    <div class="row justify-content-center" >
         
            <div class="row">
			<form class="cmxform form-export-import col-12 box-shadow mb-4" method="POST" name="regisForm" id="regisForm" autocomplete="off">
			<input type="hidden" name="search_type" id="search_type" value="SEARCH"/>
				<div class="col-12">
				<a href="https://gjepc.org/statistics.php#pane-B" class="cta" onclick="goBack()"><i class="fa fa-back"></i>&nbsp;Back</a>
				</div>
			
                <div class="form-group col-12 mb-4">
                    <p class="blue text-center">IMPORTS - COUNTRY-WISE ALL COMMODITIES</p>
                </div>
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>'; } ?>
                <div class="col-md-1">
                    <div class="form_side_pattern"> </div>
                </div>
                <div class="col-md-11 mb-3">
                    <div class="row">
                        <div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center"><label>Year</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8">
                            <select name="financial_year" class="form-control">
                                <option value=""> Select Year</option>                                
										<?php 
										$financial_query = "SELECT distinct(financial_year) FROM `statistics_integration_data` WHERE 1 order by financial_year desc";
										$execute_financial = $conn ->query($financial_query);
										while($show_financial = $execute_financial->fetch_assoc())
										{
											if($_SESSION['financial_year']==$show_financial['financial_year'])
											{
												echo "<option value='$show_financial[financial_year]' selected='selected'>$show_financial[financial_year]</option>";
											} else
											{
												echo "<option value='$show_financial[financial_year]'>$show_financial[financial_year]</option>";
											}
										} ?> 
                            </select>
                        </div>
                        </div>
                        </div>
                        <div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3 d-flex align-items-center"><label>Country</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8">
                            <select name="country" class="form-control" id="country"> 
							<option value="">Select Country</option> 
                            <?php 
							$country_query = "select * from statistics_integration_country_master where status ='1' order by country_name ASC";
							$execute_country = $conn ->query($country_query);
							while($show_country = $execute_country->fetch_assoc())
							{
								if($_SESSION['country']==$show_country['country_name'])
								{
									echo "<option value='$show_country[country_name]' selected='selected'>$show_country[country_name]</option>";
								} else
								{
								echo "<option value='$show_country[country_name]'>$show_country[country_name]</option>";
								}
							} ?>          
                            </select>
                        </div>
                        </div>
                        </div>

                        <div class="col-12 mb-2">
                        <div class="row">
                        <div class="col-3  d-flex align-items-center"><label>Select Commodity</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8 d-flex justify-content-between">
                          <label class="d-inline-block mr-3 radio-box" for="SpecificCommodity">
						  <input type="radio" name="commoditySel" id="SpecificCommodity" value="SpecificCommodity" <?php if($_SESSION['commoditySel']=="SpecificCommodity"){ echo "checked";}?>> Specific Commodity</label>
                          <label class="d-inline-block radio-box" for="allCommodity">
						  <input type="radio" name="commoditySel" id="allCommodity" value="allCommodity" <?php if($_SESSION['commoditySel']=="allCommodity"){ echo "checked";}?>> All HSCODE</label>
                        </div>
						</div>
                        </div>

                        <div class="col-12 mb-2" id="specific-commodity" <?php if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="SpecificCommodity"){?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            <label> Specific Commodity Name</label>
                        </div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8">
                        <select name="commodity" id="commodity" class="form-control search_bar" placeholder="Search Specific Commodity">
						<option value="all">All Category</option>	
								<?php 
								$region_query = "select * from statistics_integration_hscode_master where status ='1' AND commodity_category!='' AND level='8' group by commodity_category order by commodity_category";
								$execute_region = $conn ->query($region_query);
								while($show_region = $execute_region->fetch_assoc()){
									if($_SESSION['commodity']==$show_region['commodity_category'])
									{
										echo "<option value='$show_region[commodity_category]' selected='selected'>$show_region[commodity_category]</option>";
									} else
									{
									echo "<option value='$show_region[commodity_category]'>$show_region[commodity_category]</option>";
									}
								?>
								<?php  } ?>                          
                        </select>
						</div>
                        </div>
						</div>

                         <div class="col-12 mb-2" id="commodity-level" <?php if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="allCommodity"){?> <?php } else { ?> style="display: none" <?php } ?>>
                            <div class="row">
                        <div class="col-3 d-flex align-items-center">
                            <label> Commodities Level</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8">
                            <select name="commodity_level" id="commodity_level" class="form-control">
                            <option value="">Select Commodity Level</option> 
                            <option value="2" <?php if($_SESSION['commodity_level']=="2"){ echo "selected='selected'";}?>>2 Digit Level</option>
                            <option value="4" <?php if($_SESSION['commodity_level']=="4"){ echo "selected='selected'";}?>>4 Digit Level</option>
                            <option value="6" <?php if($_SESSION['commodity_level']=="6"){ echo "selected='selected'";}?>>6 Digit Level</option>
                            <option value="8" <?php if($_SESSION['commodity_level']=="8"){ echo "selected='selected'";}?>>8 Digit Level</option>
                            </select>
                        </div>
                        </div>
                        </div>
                        
                        <div class="col-12  mb-2">
                        <div class="row">
                        <div class="col-3  d-flex align-items-center">
                            <label >Value</label>
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            <span>:</span>
                        </div>
                        <div class="col-8 d-flex justify-content-between">
                        <label class="d-inline-block mr-3 radio-box" for="rupee">
						<input type="radio" name="currency" id="rupee" value="INR" <?php if($_SESSION['currency']=="INR"){ echo "checked"; }?> > <i class="fa fa-rupee"></i>&nbsp; INR</label>
                        <label class="d-inline-block radio-box" for="usd">
						<input type="radio" name="currency" id="usd" value="USD" <?php if($_SESSION['currency']=="USD"){ echo "checked"; }?>> US $ </label>
                        </div>
                        </div>
                        </div>
						
						<div class="col-12 mb-4" id="specific-inr" 
						<?php if($_SESSION['currency']=="INR"){ ?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
                        <div class="col-3  d-flex align-items-center"><label>Currency INR</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8 ">
							<select name="currency_inr" class="form-control">
							<option value=""> Select Currency</option>
                            <option value="100000" <?php if($_SESSION['currency_inr']=="100000"){ echo "selected='selected'"; }?>>Lakhs</option>
                            <option value="10000000" <?php if($_SESSION['currency_inr']=="10000000"){ echo "selected='selected'"; }?>>Crores</option>
                            </select>
                        </div>
                        </div>                       
						</div>
						
						<div class="col-12 mb-4" id="specific-usd" <?php if(isset($_SESSION['currency']) && $_SESSION['currency']=="USD"){?> <?php } else { ?> style="display: none" <?php } ?>>
                        <div class="row">
                        <div class="col-3  d-flex align-items-center"><label>Currency USD</label></div>
                        <div class="col-1 d-flex align-items-center"><span>:</span></div>
                        <div class="col-8 ">
						<select name="currency_usd" class="form-control">
						<option value=""> Select Currency</option>
                        <option value="1000" <?php if($_SESSION['currency_usd']=="1000"){ echo "selected='selected'"; }?>>Thousand</option>
                        <option value="1000000" <?php if($_SESSION['currency_usd']=="1000000"){ echo "selected='selected'"; }?>>Million</option>
                        <option value="1000000000" <?php if($_SESSION['currency_usd']=="1000000000"){ echo "selected='selected'"; }?>>Billion</option>
                        </select>
                        </div>
                        </div>                       
						</div>
                       
                    </div>
                    <div class="col-12">
                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                <input type="submit" name="submit" id="submit" value="Submit" class="gold_btn fade_anim d-block w-100 mr-3">
                            </div>
                            <div class="col-6">
                                <input type="submit" name="Reset" value="Reset" class="fade_anim btn-reset w-100 d-block">
                            </div>
                        </div>                     
                    </div>                    
                </div>
            </div>
			</form>
			
			<?php
			if(!empty($flag==1)) { ?>
			<?php
			//echo "Searched Financial year : ".$financial_year;
			$cur_year = substr($financial_year, 0,-5);
			//echo '<br/>'; 
			//current challan yr calculation
			//echo '--'.$cur_year = (int)date('Y');
			$curyear  = (int)date('Y');
			$cur_month = (int)date('m');
			if($cur_month < 4) { /*Comment for Year Change when last year become blank then uncomment*/
		/*	if($cur_month > 4) { */
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
			//echo '<br/>Last Financial year :'.$last_finyr; 
			//echo '<br/>Current Financial year :'.$cur_finyr; 
						
			$currentMonth = getCurrentMonth($conn);
			
		if(isset($commoditySel) && $commoditySel=="allCommodity")
		{
			if($commodity_level!='')
			{
				$sql="SELECT `year`, `financial_year`, `country_id`, `hs_code_id`, SUM(REPLACE(inr_value, ',', '')) as total_inr, `dollar_value`, SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$financial_year' AND country_id ='$country' AND trade_type='$trade_type'";
				
				$sqlx = "select hs_code,commodity_description,commodity_category from statistics_integration_hscode_master where level='$commodity_level'";
				$resultQ = $conn ->query($sqlx);
				
				$sql1 = "select hs_code from statistics_integration_hscode_master where level='$commodity_level'";
				$result1 = $conn ->query($sql1);
				$num1 = $result1->num_rows;
				if($num1>0){
						$sql.=" AND (";
						$myArray=array();
						$i=1;
						while($row1 = $result1->fetch_assoc()){
						$myArray[] = $row1['hs_code'];
						$codes = $row1['hs_code'];
						$sql.=" hs_code_id LIKE '$codes%' ";
						if($i<$num1)
								$sql.=" OR ";
						$i++;
						}
						$sql.=" ) ";
						$sql2 = $sql;
						$replacedResult = $conn->query($sql2);
						$replacedRow = $replacedResult->fetch_assoc();		
						$grandTotalINR = $replacedRow['total_inr']/$_POST['currency_inr'];
						$grandTotalUSD = $replacedRow['total_usd']/$_POST['currency_usd'];
				}
			}
		}
		
		if(isset($commoditySel) && $commoditySel=="SpecificCommodity")
		{
			if($_POST['commodity']!=''){
			if($_POST['commodity']=='all'){
			$sql = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr`,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$financial_year' and a.trade_type='Import' AND a.country_id='".$_POST['country']."' and a.hs_code_id=b.hs_code and b.level='8' group by b.commodity_category order by b.commodity_category";
			$sql2 = $sql;
			$replacedQuery = str_replace("group by b.commodity_category", "", $sql2);
			$replacedResult = $conn->query($replacedQuery);
			$replacedRow = $replacedResult->fetch_assoc();		
			$grandTotalINR = $replacedRow['total_inr']/$_POST['currency_inr'];
			$grandTotalUSD = $replacedRow['total_usd']/$_POST['currency_usd'];
			
			$resultQ = $conn ->query($sql);		
			} else {
		 $sql = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr`,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$financial_year' and a.trade_type='Import' AND a.country_id='".$_POST['country']."' and a.hs_code_id=b.hs_code and b.commodity_category='".$_POST['commodity']."' and b.level='8' group by b.commodity_category";
		$sql2 = $sql;
		$replacedResult = $conn->query($sql2);
		$replacedRow = $replacedResult->fetch_assoc();		
		$grandTotalINR = $replacedRow['total_inr']/$_POST['currency_inr'];
		$grandTotalUSD = $replacedRow['total_usd']/$_POST['currency_usd'];
		$resultQ = $conn ->query($sql);
			}
			}
		}
				
		$resultx = $conn ->query($sql2);  
		$rCount = $resultx->num_rows;
		if($rCount>0)
		{
		?>
            <div class="col-12">
                        <div class="row py-3"  style="border-top: 1px solid #ccc">
                            <div class="col-12"><h2 class="title text-center mb-1"><span class="d-table mx-auto mb-3" style="width:35px;"><img src="assets/images/black_star.png" class="img-fluid d-block"></span>Imports - COUNTRY-WISE ALL COMMODITIES</h2></div>
                            
                            <div class="col-12">
                                <div class="d-flex justify-content-end"> 
                                <p><strong>Date</strong>: <?php echo date("d/m/Y");?></p>   
                                </div>
								
									<div class="row justify-content-center mt-4">
                                   		<div class="col-md-9 searchResultwrap">
                                        	<ul>
                                            	<li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Year</div>
                                                        <div class="col-md-8 sResult"><?php echo $_SESSION['financial_year'];
														if(getFinancialYear($conn)==$_POST['financial_year']){ 
														echo " APR-".getCurrentMonthName($conn); }?></div>
                                                    </div>
                                                </li>
												<li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Country</div>
                                                        <div class="col-md-8 sResult"><?php echo $_POST['country'];?>
                                                        </div>
                                                    </div>
                                                </li>												
                                               <?php
												if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="SpecificCommodity"){ 
												?>
                                                <li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Specific Commodity Category</div>
                                                        <div class="col-md-8 sResult">
															<?php if($_POST['commodity']=='all'){ echo "All Commodity Category"; } else { echo $_POST['commodity']; }?>
                                                        </div>
                                                    </div>
                                                </li>
												<?php }
												if(isset($_SESSION['commoditySel']) && $_SESSION['commoditySel']=="allCommodity"){
												?>
                                                <li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Commodities Level</div>
                                                        <div class="col-md-8 sResult">
														<?php if($_SESSION['commodity_level']=="2"){?>2 Digit Level <?php } ?>
														<?php if($_SESSION['commodity_level']=="4"){?>4 Digit Level <?php } ?>
														<?php if($_SESSION['commodity_level']=="6"){?>6 Digit Level <?php } ?>
														<?php if($_SESSION['commodity_level']=="8"){?>8 Digit Level <?php } ?></div>
                                                    </div>
                                                </li>
												<?php } ?>
                                                <li>
                                                	<div class="row">
                                                    	<div class="col-md-4 sCategory">Value</div>
                                                        <div class="col-md-8 sResult">
														<?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?>
														<?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?>
														</div>
                                                    </div>
                                                </li>
                                            </ul>                                            
                                        </div>                                    
                                    </div>
								   
                                <div class="d-flex justify-content-start">
                               <button onclick="exportToExcel('tblexportData', 'country-wise-all-commodities-import')" class="cta gold_btn" title="Export To Excel"><i class="fa fa-file-excel-o" style="font-size: 40px;"></i></button>
                                </div> 
                            </div>
                            
                            <div class="col-12">
                            <?php if(isset($commoditySel) && $commoditySel=="allCommodity")	{ ?>
							<table class="table table-bordered tableInfo" id="tblexportData">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>HS Code</th>
                                            <th>Commodity Description</th>
                                            <th><?php echo $last_finyr;?> (<?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?>)</th>
                                            <th><?php echo $_REQUEST['financial_year'];?> (<?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?>)</th>
                                            <th>%Growth (YOY)</th>
                                            <th>%Share </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$i=1;
									$sub_total_Paisa=0;
									$sub_lastYear_Paisa=0;
				/* Same */			if(getFinancialYear($conn)==$financial_year){ $sameYear = "YES"; } else { $sameYear = "NO"; }		
									while($row = $resultQ->fetch_assoc())
									{	//echo $grandTotalINR.'--'.$grandTotalUSD;
										if($currency!="")
										{
											if($currency=="INR")
											{
																						
											$getCurrentYearData  = getCurrentcountrywiseAllINR_i($_REQUEST['financial_year'],$_REQUEST['country'],$row['hs_code'],$conn);
											$newTotal_Paisa  = round($getCurrentYearData/$_POST['currency_inr'],2);
											$sub_total_Paisa = round($sub_total_Paisa + $getCurrentYearData/$_POST['currency_inr'],2);																							
											$getPreviousYearData = getPreviousCountrywiseINR_i($last_finyr,$_REQUEST['country'],$row['hs_code'],$sameYear,$currentMonth,$conn);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_inr'],2);
											$getPreviousData	 = round($getPreviousYearData/$_POST['currency_inr'],2);				
											
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);
											
											$getShare = round(($newTotal_Paisa / $grandTotalINR)*100,2);									
											
											} else {
												
											$getCurrentYearData  = getCurrentcountrywiseAllUSD_i($_REQUEST['financial_year'],$_REQUEST['country'],$row['hs_code'],$conn);
										//	$newTotal_Paisa  = round($getCurrentYearData/$_POST['currency_usd'],2);
											$numbers = $getCurrentYearData/$_POST['currency_usd'];			
											$newTotal_PaisaNOround  = number_format($numbers, 12, '.', '');
											$zeroLevels = strspn($newTotal_PaisaNOround, "0", strpos($newTotal_PaisaNOround, ".")+1);
											if($zeroLevels>=3 || $zeroLevels>=2){ 
											$newTotal_Paisa = round($newTotal_PaisaNOround,4); 
											} else { 
											$newTotal_Paisa  = round($newTotal_PaisaNOround,2);  
											}
											
											$sub_total_Paisa = round($sub_total_Paisa + $getCurrentYearData/$_POST['currency_usd'],2);
																																	
											$getPreviousYearData = getPreviousCountrywiseUSD_i($last_finyr,$_REQUEST['country'],$row['hs_code'],$sameYear,$currentMonth,$conn);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_usd'],2);
										//	$getPreviousData	 = round($getPreviousYearData/$_POST['currency_usd'],2);					
											$number  = $getPreviousYearData/$_POST['currency_usd'];
											$getPreviousDataNOround  = number_format($number, 12, '.', '');
											$zeroLevel = strspn($getPreviousDataNOround, "0", strpos($getPreviousDataNOround, ".")+1);
											if($zeroLevel>=3 || $zeroLevel>=2){ 
											$getPreviousData = round($getPreviousDataNOround,4); 
											} else { 
											$getPreviousData = round($getPreviousDataNOround,2);
											}
											
											$growth = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);										
											
											$getShare = round(($newTotal_Paisa / $grandTotalUSD)*100,2);
											
											}
										}
										?>			
                                        <tr>
                                            <td class="text-left"><?php echo $i;?></td>
                                            <td class="text-left"><?php echo $row['hs_code'];?></td>
                                            <td class="text-left"><?php echo $row['commodity_description'];?></td>
                                            <td class="text-center"><?php echo $getPreviousData;?> </td>
                                            <td class="text-center"><?php echo $newTotal_Paisa;?></td>
                                            <td class="text-center"><?php echo $growthPer;?></td>
                                            <td class="text-center"><?php echo $getShare;?></td>
                                        </tr>                                                                   
										<?php 
										$i++; } ?>
						<?php if($num1>1){ ?>	
						<tr>						
						<td>&nbsp;</td>
						<td>&nbsp;</td>						
						<td class="text-left"><strong>Total</strong></td>						
						<td class="text-center"><?php echo $sub_lastYear_Paisa; ?></td>
						<td class="text-center"><?php echo $sub_total_Paisa; ?></td>
						<td class="text-center"><?php echo $totalgrowth = round((($sub_total_Paisa - $sub_lastYear_Paisa)/$sub_lastYear_Paisa)*100,2); ?></td>					
						<td class="text-center"><?php echo $totalshares = round(($sub_total_Paisa / $sub_total_Paisa)*100,2);?></td>					
					    </tr>	
						<?php } ?>
						</tbody>
                        </table>
						<?php } ?>
						<?php if(isset($commoditySel) && $commoditySel=="SpecificCommodity") { ?>
						<table class="table table-bordered tableInfo" id="tblexportData">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Commodity Category</th>
                                            <th><?php echo $last_finyr;?> (<?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?>)</th>
                                            <th><?php echo $_REQUEST['financial_year'];?> (<?php if($_SESSION['currency']=="INR"){ echo getINRCurrencyType($_POST['currency_inr'],$conn); }?> <?php if($_SESSION['currency']=="USD"){ echo getUSDCurrencyType($_POST['currency_usd'],$conn); }?>)</th>
                                            <th>%Growth (YOY)</th>
                                            <th>%Share </th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$i=1;
									$sub_total_Paisa=0;
									$sub_lastYear_Paisa=0;	
				/* Same */			if(getFinancialYear($conn)==$financial_year){ $sameYear = "YES"; } else { $sameYear = "NO"; }		
									while($row = $resultQ->fetch_assoc())
									{	//echo '<pre>'; print_r($row);								
										if($currency!="")
										{
											if($currency=="INR")
											{
											$new_Paisa  	 = $row['total_inr'];
											$newTotal_Paisa  = round($row['total_inr']/$_POST['currency_inr'],2);
											$sub_total_Paisa = round($sub_total_Paisa + $new_Paisa/$_POST['currency_inr'],2);																								
											$getPreviousYearData = getPreviousCountrycommoditywiseINR_i($last_finyr,$row['commodity_category'],$_POST['country'],$sameYear,$currentMonth,$conn);
											$getPreviousData	 = round($getPreviousYearData/$_POST['currency_inr'],2);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_inr'],2);											
											
											$growth  = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);
											
											$getShare = round(($newTotal_Paisa / $grandTotalINR)*100,2);								
											
											} else {
										
											$new_Paisa  	 = $row['total_usd'];
										//	$newTotal_Paisa  = round($row['total_usd']/$_POST['currency_usd'],2);	
											$numbers = $row['total_usd']/$_POST['currency_usd'];			
											$newTotal_PaisaNOround  = number_format($numbers, 12, '.', '');
											$zeroLevels = strspn($newTotal_PaisaNOround, "0", strpos($newTotal_PaisaNOround, ".")+1);
											if($zeroLevels>=3 || $zeroLevels>=2){ 
											$newTotal_Paisa = round($newTotal_PaisaNOround,4); 
											} else { 
											$newTotal_Paisa  = round($newTotal_PaisaNOround,2);  
											}
											
											$sub_total_Paisa = round($sub_total_Paisa + $new_Paisa/$_POST['currency_usd'],2);
											
											$getPreviousYearData = getPreviousCountrycommoditywiseUSD_i($last_finyr,$row['commodity_category'],$_POST['country'],$sameYear,$currentMonth,$conn);
											$sub_lastYear_Paisa  = round($sub_lastYear_Paisa + $getPreviousYearData/$_POST['currency_usd'],2);
										//	$getPreviousData	 = round($getPreviousYearData/$_POST['currency_usd'],2);
											$number  = $getPreviousYearData/$_POST['currency_usd'];
											$getPreviousDataNOround  = number_format($number, 12, '.', '');
											$zeroLevel = strspn($getPreviousDataNOround, "0", strpos($getPreviousDataNOround, ".")+1);
											if($zeroLevel>=3 || $zeroLevel>=2){ 
											$getPreviousData = round($getPreviousDataNOround,4); 
											} else { 
											$getPreviousData = round($getPreviousDataNOround,2);
											}
																						
											$growth  = round((($newTotal_Paisa - $getPreviousData)/$getPreviousData)*100,2);
											$growthPer = str_replace(array('INF','NAN'),'0',$growth);
											$getShare  = round(($newTotal_Paisa / $grandTotalUSD)*100,2);
											
											}
										}	
										
										?>			
                                        <tr>
                                            <td class="text-left"><?php echo $i;?></td>
                                            <td class="text-left"><?php echo $row['commodity_category'];?></td>
                                            <td class="text-center"><?php echo $getPreviousData;?> </td>
                                            <td class="text-center"><?php echo $newTotal_Paisa;?></td>
                                            <td class="text-center"><?php echo $growthPer;?></td>
                                            <td class="text-center"><?php echo $getShare;?></td>
                                        </tr>                                                                   
										<?php 
										$i++; } ?>
						<?php if($rCount>1){ ?>				
						<tr>						
						<td>&nbsp;</td>
						<td class="text-left">Total</td>																		
						<td class="text-center"><?php echo $sub_lastYear_Paisa; ?></td>
						<td class="text-center"><?php echo $sub_total_Paisa; ?></td>
						<td class="text-center"><?php echo $totalgrowth = round((($sub_total_Paisa - $sub_lastYear_Paisa)/$sub_lastYear_Paisa)*100,2); ?></td>
						<td class="text-center"><?php echo $totalshares = round(($sub_total_Paisa / $sub_total_Paisa)*100,2);?></td>			
					    </tr>
						<?php } ?>
						</tbody>
						</table>
						<?php } ?>
                        </div>
                        </div>			
            </div> 
			<?php } else {  echo 'Not Found'; } ?>
			<?php } ?>
			</div>
		</div>           
</section>

<?php include 'include-new/footer_export.php'; ?>

<style type="text/css">
    .form-export-import label, .form-export-import span{color: #9e9457;font-weight: bold;}
    
    .form_side_pattern:before{content:"";position: absolute;top: 0;bottom: 0;left: 13px;width: 79%;background: url(https://gjepc.org/assets/images/mobile_bg.png) repeat left;background-size: 300px;}
    .radio-box{border:1px solid#9e9457;width: 100%;padding: 6px 5px; border-radius: 5px;}
    .radio-box:hover{background: #9e9457;border:1px solid#9e9457;color:#000;}
    .radio-box input[type=radio]{margin-bottom: 6px }
    .radio-box-active{border:1px solid#7b702c;background: #9e9457;color: #000!important}
    .search_bar{position: relative;}
    .fix-into-input{    position: absolute;
    top: 10px;
    right: 7%;
    font-size: 19px;
    color: #9e9457;cursor: pointer;}
    .fix-into-input:hover{color: #000}
    .btn-reset{    background: #ccc;
    padding: 10px 15px;
    color: #fff;
  
    margin-bottom: 15px;
    position: relative;
    text-align: center;}
    .btn-reset:hover{    background: #a2a1a1;
   }
   .tableInfo thead{background: #000;
    color: #a89c5d;}
    .fstElement {
    display: block;}
    .fstToggleBtn{padding: 8px;font-size: 13px}
    .fstMultipleMode .fstControls{width: 100%}
    .fstChoiceItem,.fstResultItem,.fstMultipleMode .fstQueryInput{font-size: 12px;width: 100%}
    .fstNoResults {
    font-size: 13px;}
    .fstChoiceItem{    border: 1px solid #888158;background-color: #948b52;}
    .fstResultItem.fstSelected {
    color: #fff;
    background-color: #948b52;
    border-color: #847d54;}
    .fstResultItem.fstFocused {
    color: #fff;
    background-color: #948b52;
    border-color: #7d7855;}
    .fstMultipleMode.fstActive .fstResults{max-height:200px }
</style>
<script type="text/javascript">
	$("#regisForm").on("submit",function(e){
		//$(".otp-messages").html("<div>").show();
	$("#preloader").fadeIn();
	$("#status").fadeIn();
	})
</script>
<script type="text/javascript">
          $('input[type="radio"]').on("change",function(){
             $('input[type="radio"]:not(:checked)').parent('label').removeClass("radio-box-active");
             $('input[type="radio"]:checked').parent('label').addClass("radio-box-active");
        });
	$("#tableResult").hide();
   // $("#specific-commodity").hide();
    //$("#commodity-level").hide();
    $('input[name="commoditySel"]').on("change",function(){
        var commoditySel = $(this).val();
        if(commoditySel =="SpecificCommodity"){
        $("#specific-commodity").slideDown();
        $("#commodity-level").slideUp();

        } else if(commoditySel="allCommodity"){
        $("#commodity-level").slideDown();
        $("#specific-commodity").slideUp();        
        }
    });
	
    /*$('input[type="submit"]').click(function(e){
        e.preventDefault();
    $("#tableResult").show();
    }); */
    
	$('#commodity').fastselect();
	
	//$("#specific-inr").show();
	$('input[name="currency"]').on("change",function(){
				var currency = $(this).val();
				if(currency =="INR"){
				$("#specific-inr").slideDown();
				$("#specific-usd").slideUp();

				}else if(currency="USD"){
				$("#specific-usd").slideDown();
				$("#specific-inr").slideUp();
				}
	});
</script>
<script type="text/javascript">
function exportToExcel(tableID, filename = ''){
    var downloadurl;
    var dataFileType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTMLData = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'export_excel_data.xls';
    
    // Create download link element
    downloadurl = document.createElement("a");
    
    document.body.appendChild(downloadurl);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTMLData], {
            type: dataFileType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadurl.href = 'data:' + dataFileType + ', ' + tableHTMLData;
    
        // Setting the file name
        downloadurl.download = filename;
        
        //triggering the function
        downloadurl.click();
    }
}
</script>